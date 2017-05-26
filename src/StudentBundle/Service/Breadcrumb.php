<?php


namespace StudentBundle\Service;


use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use AppBundle\Service\BaseService;
use QcmBundle\Entity\Qcm;
use QcmBundle\Entity\QcmQuestion;
use QcmBundle\Entity\Score;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\File;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class Breadcrumb
{
    private $breadcrumbs;
    private $container;
    private $generateRoute;

    public function __construct(Breadcrumbs $breadcrumbs, Container $container)
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->container = $container;
    }

    private function generateRoute($route)
    {
        return $this->container->get('router')->generate($route);
    }

    public function addHome()
    {
        $this->breadcrumbs->addItem('Accueil', $this->generateRoute('student_homepage'));
    }

    public function addCourse(Course $course)
    {
        $this->addHome();
        $this->breadcrumbs->addRouteItem($course->getName(), "student_display_course", ["id" => $course->getId()]);

    }

    public function addCourseCategory(CourseCategory $courseCategory)
    {
        $this->addCourse($courseCategory->getCourse());
        $this->breadcrumbs->addRouteItem($courseCategory->getName(), "student_display_courseCategory", ["id" => $courseCategory->getId()]);
    }

    public function addQcm(Qcm $qcm)
    {
        $this->addCourseCategory($qcm->getDocRelation()[0]->getCourseCategory());
        $this->breadcrumbs->addRouteItem($qcm->getName(), "qcm_display_questions", ["id" => $qcm->getId()]);
    }
}