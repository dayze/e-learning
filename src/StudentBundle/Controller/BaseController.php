<?php

namespace StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    public function indexAction()
    {
        $this->get('app.breadcrumb')->addHome();
        $student = $this->getUser();
        $sections = $student->getSections();
        $timeRetrieve = $this->get('app.retrievetime')->getTimeRetrieve($this->getUser());
        return $this->render('StudentBundle:part:index.html.twig', ['sections' => $sections, 'timeretrieve' => $timeRetrieve]);
    }

    public function displayCourseAction($id)
    {
        $actionS = $this->get('app.action');
        $courseS = $this->get('app.course');
        $course = $courseS->find('AppBundle:Course', $id);
        $actionS->SaveAction($this->getUser(), $course->getName());
        $this->get('app.breadcrumb')->addCourse($course);
        $timeRetrieve = $this->get('app.retrievetime')->getTimeRetrieve($this->getUser());

        return $this->render('StudentBundle:part:course.html.twig', ["course" => $course, 'timeretrieve' => $timeRetrieve]);
    }

    public function displayCourseCategoryAction($id)
    {
        $actionS = $this->get('app.action');
        $courseCategoryS = $this->get('app.course_category');
        $courseCategory = $courseCategoryS->find("AppBundle:CourseCategory", $id);
        $actionS->SaveAction($this->getUser(), $courseCategory->getName());
        $this->get('app.breadcrumb')->addCourseCategory($courseCategory);
        $timeRetrieve = $this->get('app.retrievetime')->getTimeRetrieve($this->getUser());

        return $this->render('StudentBundle:part:courseCategory.html.twig', ["courseCategory" => $courseCategory ,'timeretrieve' => $timeRetrieve]);
    }

    public function displayGradesAction(Request $request)
    {
       $repo = $this->getDoctrine()->getRepository('QcmBundle:Score');
       $scores = $repo->findByQcm($request->request->get('qcm_id'), $this->getUser());
       if(!$scores){
           return new JsonResponse(null, 400);
       }
       return new JsonResponse($this->renderView('StudentBundle:part:gradeModal.html.twig', ["scores" => $scores]));
    }
}
