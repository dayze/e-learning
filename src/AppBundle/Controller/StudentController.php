<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    public function createAction(Request $request)
    {
        $userService = $this->get("app.user");
        $student = new Student();
        $form = $this->get("form.factory")->create(UserType::class, $student, array(
            'action' => $this->generateUrl('app_student_create'),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $student->setEnabled(true);
            $student->setRoles(array('ROLE_STUDENT'));
            $student = $form->getData();
            $userService->addEntity($student);
            $data = $this->renderView("AppBundle:Student/part:raw.html.twig", array("student" => $student));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Student/part:crudModal.html.twig', array('student' => $student,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Student/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(Student $student)
    {
        $userService = $this->get("app.user");
        $userService->deleteEntity($student);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Student $student)
    {
        $form = $this->get("form.factory")->create(UserType::class, $student, array(
            'action' => $this->generateUrl('app_student_edit', array('id' => $student->getId())),
            'method' => 'POST'));
        $form->remove('plainPassword');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:Student/part:raw.html.twig", array("student" => $student));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $student->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Student/part:crudModal.html.twig', array('student' => $student,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => false,
            'form' => $this->renderView('AppBundle:Student/part:crudModal.html.twig', array('student' => $student,
                'form' => $form->createView()))));
    }

    public function displayAction($id)
    {
        $sectionRepository = $this->getDoctrine()->getRepository('AppBundle:Section');
        $section = $sectionRepository->findUserBySectionAndRole($id, 'ROLE_STUDENT');
        return $this->render('AppBundle:Student:view.html.twig', array("section" => $section));
    }


}