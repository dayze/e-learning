<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Supervisor;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SupervisorController extends Controller
{
    public function displayAction()
    {
        $userService = $this->get("app.user");
        $supervisors = $userService->findByRole("ROLE_SUPERVISOR");
        return $this->render("AppBundle:Supervisor:view.html.twig", array("supervisors" => $supervisors));
    }

    public function createAction(Request $request)
    {
        $userService = $this->get("app.user");
        $supervisor = new Supervisor();
        $form = $this->get("form.factory")->create(UserType::class, $supervisor, array(
            'action' => $this->generateUrl('app_supervisor_create'),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $supervisor->setEnabled(true);
            $supervisor->setRoles(array('ROLE_SUPERVISOR'));
            $supervisor = $form->getData();
            $userService->addEntity($supervisor);
            $data = $this->renderView("AppBundle:Supervisor/part:raw.html.twig", array("supervisor" => $supervisor));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $supervisor,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(Supervisor $supervisor)
    {
        $userService = $this->get("app.user");
        $userService->deleteEntity($supervisor);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, supervisor $supervisor)
    {
        $form = $this->get("form.factory")->create(UserType::class, $supervisor, array(
            'action' => $this->generateUrl('app_supervisor_edit', array('id' => $supervisor->getId())),
            'method' => 'POST'));
        $form->remove('plainPassword');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:Supervisor/part:raw.html.twig", array("supervisor" => $supervisor));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $supervisor->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $supervisor,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => false,
            'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $supervisor,
                'form' => $form->createView()))));
    }

}