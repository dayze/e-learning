<?php
namespace AppBundle\Service;

class CourseCategoryService extends BaseService
{
    public function findCourseCategoryByCourse($id)
    {
        $courseCategories = $this->container->get('doctrine')->getRepository('AppBundle:CourseCategory')->findCourseCategoryByCourse($id);
        $result = [];
        foreach ($courseCategories as $courseCategory) {
            $result[$courseCategory->getName()] = $courseCategory->getId();
        }
        return $result;
    }
}