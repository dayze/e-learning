<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCourseCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $courseCategory1 = new CourseCategory();
        $courseCategory1->setName('grammaire');
        $courseCategory1->setCourse($this->getReference("course1"));
        $this->addReference('courseCategory1', $courseCategory1);
        $manager->persist($courseCategory1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}