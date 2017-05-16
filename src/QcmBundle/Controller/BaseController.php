<?php


namespace QcmBundle\Controller;


use AppBundle\Entity\Section;
use Doctrine\ORM\EntityRepository;
use QcmBundle\Entity\Qcm;
use QcmBundle\Entity\QcmQuestion;
use QcmBundle\Form\QcmAnswerType;
use QcmBundle\Form\QcmQuestionType;
use QcmBundle\Form\QcmType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    public function displayAllAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Qcm');
        $qcms = $em->findAll();
        return $this->render('QcmBundle:qcm:view.html.twig', ["qcms" => $qcms]);
    }

    public function displayQuestionOfQcmAction(Request $request, Qcm $qcm)
    {
        $qcmS = $this->get('app.qcm');
        $this->get('app.breadcrumb')->addQcm($qcm);
        $em = $this->getDoctrine()->getManager()->getRepository('QcmBundle:QcmQuestion');
        $qcmQuestions = $em->findBy(array('qcm' => $qcm->getId()));
        $isAlreadyDone = $qcmS->checkQcmProperty($qcm);
        $formBuilderQuestionnaire = $this->createFormBuilder();
        $i = 0;
        foreach ($qcmQuestions as $qcmQuestion) {
            /* @var $qcmQuestion QcmQuestion */
            $formBuilder = $this->get('form.factory')->createNamedBuilder($i, FormType::class, $qcmQuestions);
            $formBuilder
                ->add('qcmAnswers', EntityType::class, [
                    'class' => 'QcmBundle\Entity\QcmAnswer',
                    'expanded' => true,
                    'label' => $qcmQuestion->getQuestion(),
                    'query_builder' => function (EntityRepository $er) use ($qcmQuestion) {
                        return $er->createQueryBuilder('qcmAnswer')
                            ->join('qcmAnswer.qcmQuestion', 'qcmQuestion')
                            ->where('qcmAnswer.qcmQuestion = :qcmQuestionId')
                            ->setParameter('qcmQuestionId', $qcmQuestion->getId());
                    },
                ]);
            $formBuilderQuestionnaire->add($formBuilder);
            $i++;
        }
        $form = $formBuilderQuestionnaire->getForm();
        $form
            ->add('save', SubmitType::class, array('label' => 'Envoyer',
                "attr" => array("class" => "btn btn-primary")));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $qcmQuestions = $form->getData();
            $score = $qcmS->setScore($qcmQuestions);
            return $this->render('StudentBundle:part:score.html.twig', ['score' => $score]);
        }
        $view = $this->get('app.check_role')->check('ROLE_STUDENT') ? "StudentBundle:part:qcm.html.twig" : "QcmBundle:qcm:qcmQuestions.html.twig";
        return $this->render($view, ["isAlreadyDone" => $isAlreadyDone ,"qcmQuestions" => $qcmQuestions, "form" => $form->createView()]);
    }

    public function createAction(Request $request)
    {
        $qcmS = $this->get('app.qcm');
        $qcm = new Qcm();
        $supervisor_id = $this->get('app.check_role')->check('ROLE_ADMIN') ? null : $this->getUser()->getId();
        $form = $this->get("form.factory")->create(QcmType::class, $qcm,
            [
                'action' => $this->generateUrl('app_create_qcm'),
                'method' => 'POST',
                'em' => $this->getDoctrine()->getManager(),
                'supervisor_id' => $supervisor_id
            ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $qcm = $form->getData();
            $qcmS->handleImg($qcm);
            //  $qcmS->addSection($qcm, $request->request->get('qcmbundle_qcm'));
            $qcmS->addEntity($qcm);
            $data = $this->renderView("QcmBundle:qcm/part:raw.html.twig", array("qcm" => $qcm));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data, 'supervisor' => $this->getUser()->getId()), 200);
        } else if (!$form->isValid() && $request->get('isSubmit') == true) {
            return new JsonResponse(
                array(
                    'supervisor' => $this->getUser()->getId(),
                    'error' => true,
                    'form' => $this->renderView('QcmBundle:qcm/part:crudModal.html.twig', array('qcm' => $qcm,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('QcmBundle:qcm/part:crudModal.html.twig', array(
                'form' => $form->createView(),
                'supervisor' => $this->getUser()->getId()
            ))));
    }

    public function deleteAction(Qcm $qcm)
    {
        $qcmS = $this->get("app.qcm");
        $qcmS->handleDeleteImg($qcm);
        $qcmS->deleteEntity($qcm);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Qcm $qcm)
    {
        $qcmS = $this->get('app.qcm');
        $qcmS->handlePathImg($qcm);
        $supervisor_id = $this->get('app.check_role')->check('ROLE_ADMIN') ? null : $this->getUser()->getId();
        $form = $this->get("form.factory")->create(QcmType::class, $qcm, [
            'action' => $this->generateUrl('app_edit_qcm', ['id' => $qcm->getId()]),
            'method' => 'POST',
            'em' => $this->getDoctrine()->getManager(),
            'supervisor_id' => $supervisor_id
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $qcm = $form->getData();
            $qcmS->handleImg($qcm);
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("QcmBundle:qcm/part:raw.html.twig", array("qcm" => $qcm));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $qcm->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $request->get('isSubmit') == true) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('QcmBundle:qcm/part:crudModal.html.twig', [
                    'qcm' => $qcm,
                    'form' => $form->createView()
                ])), 400);

        }
        return new JsonResponse(array(
            'error' => true,
            'form' => $this->renderView('QcmBundle:qcm/part:crudModal.html.twig', [
                'qcm' => $qcm,
                'form' => $form->createView()
            ])));
    }
}