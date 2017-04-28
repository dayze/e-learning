<?php


namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function displaySupervisorAction()
    {
        $userService = $this->get("app.user");
        $supervisors = $userService->findByRole("ROLE_SUPERVISOR");
        return $this->render("AppBundle:Supervisor:view.html.twig", array("users" => $supervisors));
    }

    public function createAction(Request $request)
    {
        $userService = $this->get("app.user");
        $user = new User();
        $form = $this->get("form.factory")->create(UserType::class, $user, array(
            'action' => $this->generateUrl('app_user_create'),
            'method' => 'POST'));
        $form->handleRequest($request);
        $userType = $request->get('userType') == "user"; //define the user role via post parameter
        if ($form->isValid()) {
            $user->setEnabled(true);
            if ($request->get('userType') == "user")
                $user->setRoles(array('ROLE_STUDENT'));
            else
                $user->setRoles(array('ROLE_SUPERVISOR'));

            $user = $form->getData();
            $userService->addEntity($user);
            $view = $userType == "user" ? "AppBundle:User/part:raw.html.twig" : "AppBundle:Supervisor/part:raw.html.twig";
            $data = $this->renderView($view, array("user" => $user));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $user,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(User $user)
    {
        $userService = $this->get("app.user");
        $userService->deleteEntity($user);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, User $user)
    {
        $form = $this->get("form.factory")->create(UserType::class, $user, array(
            'action' => $this->generateUrl('app_user_edit', array('id' => $user->getId())),
            'method' => 'POST'));
        $form->remove('plainPassword');
        $form->handleRequest($request);
        $userType = $request->get('userType') == "user"; //define the user role via post parameter
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $view = $userType == "user" ? "AppBundle:User/part:raw.html.twig" : "AppBundle:Supervisor/part:raw.html.twig";
            $data = $this->renderView($view, array("user" => $user));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $user->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $user,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => false,
            'form' => $this->renderView('AppBundle:Supervisor/part:crudModal.html.twig', array('supervisor' => $user,
                'form' => $form->createView()))));
    }

    public function displayUsersAction($id)
    {
        $sectionRepository = $this->getDoctrine()->getRepository('AppBundle:Section');
        $section = $sectionRepository->findUserBySectionAndRole($id, 'ROLE_STUDENT');
        return $this->render('AppBundle:User:view.html.twig', array("section" => $section));
    }


}