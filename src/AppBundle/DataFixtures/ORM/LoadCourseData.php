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
        $course1->setName('Php');
        $course1->setSupervisor($this->getReference("supervisor1"));
        $course1->addSection($this->getReference('section1'));
        $manager->persist($course1);
        $this->addReference('course1', $course1);

        $course2 = new Course();
        $course2->setName('Sql');
        $course2->setSupervisor($this->getReference("supervisor1"));
        $course2->addSection($this->getReference('section1'));
        $manager->persist($course2);
        $this->addReference('course2', $course2);

        $course3 = new Course();
        $course3->setName('Français');
        $course3->setSupervisor($this->getReference("supervisor1"));
        $course3->addSection($this->getReference('section2'));
        $manager->persist($course3);
        $this->addReference('course3', $course3);

        $course4 = new Course();
        $course4->setName('Anglais');
        $course4->setSupervisor($this->getReference("supervisor1"));
        $course4->addSection($this->getReference('section2'));
        $manager->persist($course4);
        $this->addReference('course4', $course4);

        $course5 = new Course();
        $course5->setName('Réseaux');
        $course5->setSupervisor($this->getReference("supervisor1"));
        $course5->addSection($this->getReference('section1'));
        $manager->persist($course5);
        $this->addReference('course5', $course5);

        $course6 = new Course();
        $course6->setName('Java');
        $course6->setSupervisor($this->getReference("supervisor1"));
        $course6->addSection($this->getReference('section1'));
        $manager->persist($course6);
        $this->addReference('course6', $course6);

        $course7 = new Course();
        $course7->setName('Français');
        $course7->setSupervisor($this->getReference("supervisor1"));
        $course7->addSection($this->getReference('section1'));
        $manager->persist($course7);
        $this->addReference('course7', $course7);

        $course8 = new Course();
        $course8->setName('Anglais');
        $course8->setSupervisor($this->getReference("supervisor1"));
        $course8->addSection($this->getReference('section1'));
        $manager->persist($course8);
        $this->addReference('course8', $course8);

        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
    }
}