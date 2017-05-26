<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Section;
use AppBundle\Form\CourseType;
use AppBundle\Form\SectionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends Controller
{
    public function displayAction()
    {
        $courseService = $this->get("app.course");
        if (in_array('ROLE_SUPERVISOR', $this->getUser()->getRoles())) {
            $courses = $courseService->findBy('AppBundle:Course', ["supervisor" => $this->getUser()->getId()]);
        } else {
            $courses = $courseService->findAll("AppBundle:Course");
        }
        return $this->render('AppBundle:Course:view.html.twig', array("courses" => $courses));
    }

    /*************************************CRUD*************************************************
     * @param Request $request
     * @return JsonResponse
     */

    public function createAction(Request $request)
    {
        $courseService = $this->get("app.course");
        $course = new Course();
        $supervisor_id = $this->get('app.check_role')->check('ROLE_SUPERVISOR') ? $this->getUser()->getId() : null;
        $form = $this->get("form.factory")->create(CourseType::class, $course, [
            'action' => $this->generateUrl('app_create_course'),
            'method' => 'POST',
            'supervisor_id' => $supervisor_id
        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            if (in_array('ROLE_SUPERVISOR', $this->getUser()->getRoles())) {
                $em = $this->getDoctrine()->getRepository('AppBundle:Supervisor');
                $supervisor = $em->find($this->getUser()->getId());
                $course->setSupervisor($supervisor);
            } else {

            }
            $courseService->addEntity($course);
            $data = $this->renderView("AppBundle:Course/part:raw.html.twig", array("course" => $course));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:Course/part:crudModal.html.twig', array('course' => $course,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:Course/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(Course $course)
    {
        $courseService = $this->get("app.course");
        $courseService->deleteEntity($course);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, Course $course)
    {
        $supervisor_id = $this->get('app.check_role')->check('ROLE_SUPERVISOR') ? $this->getUser()->getId() : null;
        $form = $this->get("form.factory")->create(CourseType::class, $course, [
            'action' => $this->generateUrl('app_edit_course', ['id' => $course->getId()]),
            'method' => 'POST',
            'supervisor_id' => $supervisor_id

        ]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:Course/part:raw.html.twig", array("course" => $course));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $course->getId(), "action" => "edit")
                , 200);
        } else if (!$form->isValid() && $form->isSubmitted()) {
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:Course/part:crudModal.html.twig', array('course' => $course,
                    'form' => $form->createView()))), 400);

        }
        return new JsonResponse(array(
            'error' => true,
            'form' => $this->renderView('AppBundle:Course/part:crudModal.html.twig', array('course' => $course,
                'form' => $form->createView()))));
    }


}