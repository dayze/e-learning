<?php
namespace AppBundle\Service;

use AppBundle\Service\BaseService;
use Symfony\Component\HttpFoundation\Request;


class CourseService extends BaseService
{
    public function findCourseBySection($repository, $id)
    {
        return $this->container->get('doctrine')->getRepository($repository)->findCourseBySection($id);
    }
}