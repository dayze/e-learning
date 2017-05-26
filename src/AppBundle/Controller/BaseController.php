<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class BaseController extends Controller
{
    public function indexAction()
    {
        $securityContext = $this->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if($securityContext->isGranted('ROLE_ADMIN') || $securityContext->isGranted('ROLE_SUPERVISOR') ){
                return $this->dashboardAction();
            }
            else if($securityContext->isGranted('ROLE_STUDENT')){
                return $this->redirectToRoute('student_homepage');
            }
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function dashboardAction()
    {
        return $this->render("AppBundle::homepage.html.twig");
    }

    public function registerAction(Request $request)
    {
        $userService = $this->get("app.user");
        $student = new Student();
        $form = $this->get("form.factory")->create(StudentType::class, $student, [
            'method' => 'POST']);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $student->setEnabled(true);
            $student->setRoles(array('ROLE_STUDENT'));
            $student = $form->getData();
            $userService->addEntity($student);
            //redirect
            die(dump('ok'));
        } else if (!$form->isValid() && $form->isSubmitted()) {
                $this->renderView('AppBundle:Student/part:crudModal.html.twig', array('student' => $student,
                    'form' => $form->createView(),
                ));
        }
        return $this->render('AppBundle:register:registerForm.html.twig', [
           "form" => $form->createView()
        ]);

    }

}