<?php

namespace StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $this->get('app.breadcrumb')->addHome();
        $student = $this->getUser();
        $sections = $student->getSections();
        return $this->render('StudentBundle:part:index.html.twig', ['sections' => $sections]);
    }

    public function displayCourseAction($id)
    {
        $courseS = $this->get('app.course');
        $course = $courseS->find('AppBundle:Course', $id);
        $this->get('app.breadcrumb')->addCourse($course);
        return $this->render('StudentBundle:part:course.html.twig', ["course" => $course]);
    }

    public function displayCourseCategoryAction($id)
    {
        $courseCategoryS = $this->get('app.course_category');
        $courseCategory = $courseCategoryS->find("AppBundle:CourseCategory", $id);
        $this->get('app.breadcrumb')->addCourseCategory($courseCategory);
        return $this->render('StudentBundle:part:courseCategory.html.twig', ["courseCategory" => $courseCategory]);
    }
}
