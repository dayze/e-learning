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
        $courseCategory1->setName('Programmation orienté objet');
        $courseCategory1->setCourse($this->getReference("course1"));
        $this->addReference('courseCategory1', $courseCategory1);
        $manager->persist($courseCategory1);

        $courseCategory2 = new CourseCategory();
        $courseCategory2->setName('Algorithmie');
        $courseCategory2->setCourse($this->getReference("course1"));
        $this->addReference('courseCategory2', $courseCategory2);
        $manager->persist($courseCategory2);

        $courseCategory3 = new CourseCategory();
        $courseCategory3->setName('Trigger');
        $courseCategory3->setCourse($this->getReference("course2"));
        $this->addReference('courseCategory3', $courseCategory3);
        $manager->persist($courseCategory3);

        $courseCategory4 = new CourseCategory();
        $courseCategory4->setName('Vocabulaire');
        $courseCategory4->setCourse($this->getReference("course3"));
        $this->addReference('courseCategory4', $courseCategory4);
        $manager->persist($courseCategory4);

        $courseCategory5 = new CourseCategory();
        $courseCategory5->setName('Conjugaison');
        $courseCategory5->setCourse($this->getReference("course3"));
        $this->addReference('courseCategory5', $courseCategory5);
        $manager->persist($courseCategory5);

        $courseCategory6 = new CourseCategory();
        $courseCategory6->setName('Vocabulaire');
        $courseCategory6->setCourse($this->getReference("course4"));
        $this->addReference('courseCategory6', $courseCategory6);
        $manager->persist($courseCategory6);

        $courseCategory7 = new CourseCategory();
        $courseCategory7->setName('Conjugaison');
        $courseCategory7->setCourse($this->getReference("course4"));
        $this->addReference('courseCategory7', $courseCategory7);
        $manager->persist($courseCategory7);

        $courseCategory8 = new CourseCategory();
        $courseCategory8->setName('Modèle OSI');
        $courseCategory8->setCourse($this->getReference("course5"));
        $this->addReference('courseCategory8', $courseCategory8);
        $manager->persist($courseCategory8);

        $courseCategory9 = new CourseCategory();
        $courseCategory9->setName('Programmation orienté objet');
        $courseCategory9->setCourse($this->getReference("course6"));
        $this->addReference('courseCategory9', $courseCategory9);
        $manager->persist($courseCategory9);

        $courseCategory10 = new CourseCategory();
        $courseCategory10->setName('Conjugaison');
        $courseCategory10->setCourse($this->getReference("course7"));
        $this->addReference('courseCategory10', $courseCategory10);
        $manager->persist($courseCategory10);

        $courseCategory11 = new CourseCategory();
        $courseCategory11->setName('Vocabulaire');
        $courseCategory11->setCourse($this->getReference("course7"));
        $this->addReference('courseCategory11', $courseCategory11);
        $manager->persist($courseCategory11);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}