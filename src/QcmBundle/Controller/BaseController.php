<?php


namespace QcmBundle\Controller;


use Doctrine\ORM\EntityRepository;
use QcmBundle\Form\QcmAnswerType;
use QcmBundle\Form\QcmQuestionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BaseController extends Controller
{
    public function displayAllAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('QcmBundle:Qcm');
        $qcms = $em->findAll();
        return $this->render('QcmBundle:qcm:view.html.twig', ["qcms" => $qcms]);
    }

    public function displayQuestionOfQcmAction($id)
    {
        $em = $this->getDoctrine()->getManager()->getRepository('QcmBundle:QcmQuestion');
        $qcmQuestions = $em->findBy(array('qcm' => $id));
        $formBuilderQuestionnaire = $this->createFormBuilder();
        $i = 0;
        foreach ($qcmQuestions as $qcmQuestion) {
            $formBuilder = $this->get('form.factory')->createNamedBuilder($i, FormType::class, $qcmQuestion);
            $formBuilder
                ->add('question')
                ->add('qcmAnswers', CollectionType::class, [
                    'entry_type' => QcmAnswerType::class,

/*                    'entry_options' => [
                        'choices' => [
                            $arr
                        ],
                        'expanded' => true,
                        'choice_label' => function($qcmAnswers, $key, $index){
                            return $qcmAnswers;
                        }
                    ]*/
                ])
            ;
            $formBuilderQuestionnaire->add($formBuilder);
            $i++;
        }
        $form = $formBuilderQuestionnaire->getForm();
        $form->add('save', SubmitType::class, array('label' => 'Envoyer',
            "attr" => array("class" => "btn btn-primary")));
        //$form = $this->get("form.factory")->create(QcmQuestionType::class, $qcmQuestions);
        return $this->render('QcmBundle:qcm:qcmQuestions.html.twig', ["qcmQuestions" => $qcmQuestions, "form" => $form->createView()]);
    }
    /*    public function displayQuestionOfQcmAction($id)
        {
            $em = $this->getDoctrine()->getManager()->getRepository('QcmBundle:QcmQuestion');
            $qcmQuestions = $em->findBy(array('qcm' => $id));
            $form = $this->get("form.factory")->create(QcmQuestionType::class, $qcmQuestions[0]);
            return $this->render('QcmBundle:qcm:qcmQuestions.html.twig', ["qcmQuestions" => $qcmQuestions, "form" => $form->createView()]);
        }*/


}