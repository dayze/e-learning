<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Course;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCourseData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $course1 = new Course();
        $course1->setName('Français');
        $course1->setSupervisor($this->getReference("supervisor1")); //todo that
        $manager->persist($course1);
        $this->addReference('course1', $course1);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}