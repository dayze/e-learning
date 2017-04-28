<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use AppBundle\Form\CourseCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CourseCategoryController extends Controller
{
    /*************************************CRUD*************************************************
     * @param Request $request
     * @param Course $course
     * @return JsonResponse
     */

    public function createAction(Request $request, Course $course)
    {
        $courseCategoryService = $this->get("app.course");
        $courseCategory = new CourseCategory();
        $form = $this->get("form.factory")->create(CourseCategoryType::class, $courseCategory, array(
            'action' => $this->generateUrl('app_create_courseCategory', array("id" => $course->getId())),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $courseCategory->setCourse($course);
            $courseCategoryService->addEntity($courseCategory);
            $data = $this->renderView("AppBundle:CourseCategory/part:raw.html.twig", array("courseCategory" => $courseCategory));
            return new JsonResponse(array('error' => false, "action" => "new", 'data' => $data), 200);
        }
        else if(!$form->isValid() && $form->isSubmitted()){
            return new JsonResponse(
                array(
                    'error' => true,
                    'form' => $this->renderView('AppBundle:CourseCategory/part:crudModal.html.twig', array('course' => $course,
                        'form' => $form->createView(),
                    ))), 400);
        }
        return new JsonResponse(array('error' => false,
            'form' => $this->renderView('AppBundle:CourseCategory/part:crudModal.html.twig', array(
                'form' => $form->createView()
            ))));
    }

    public function deleteAction(CourseCategory $courseCategory)
    {
        $courseCategoryService = $this->get("app.course_category");
        $courseCategoryService->deleteEntity($courseCategory);
        return new JsonResponse(array("error" => false), 200);
    }

    public function editAction(Request $request, CourseCategory $courseCategory)
    {
        $form = $this->get("form.factory")->create(CourseCategoryType::class, $courseCategory, array(
            'action' => $this->generateUrl('app_edit_courseCategory', array('id' => $courseCategory->getId())),
            'method' => 'POST'));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $data = $this->renderView("AppBundle:CourseCategory/part:raw.html.twig", array("courseCategory" => $courseCategory));
            return new JsonResponse(
                array("error" => false, "data" => $data, "id" => $courseCategory->getId(), "action" => "edit")
                , 200);
        }
        else if(!$form->isValid() && $form->isSubmitted()){
            return new JsonResponse(array(
                'error' => true,
                'form' => $this->renderView('AppBundle:CourseCategory/part:crudModal.html.twig', array('courseCategory' => $courseCategory,
                    'form' => $form->createView()))),400);

        }
        return new JsonResponse(array(
            'error' => true,
            'form' => $this->renderView('AppBundle:CourseCategory/part:crudModal.html.twig', array('courseCategory' => $courseCategory,
                'form' => $form->createView()))));
    }



}