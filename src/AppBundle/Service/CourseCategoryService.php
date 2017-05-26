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

    public function findCourseCategoryElement($id, $student_id)
    {
        $repository = $this->container->get('doctrine')->getRepository('AppBundle:CourseCategory');
        return $repository->findCourseCategoryElement($id, $student_id);
    }
}