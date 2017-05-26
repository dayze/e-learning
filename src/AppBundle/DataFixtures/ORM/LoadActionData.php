<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use StudentBundle\Entity\Action;

class LoadActionData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
      $action1= new Action();
      $action1->setName('login');
      $action1->setStudents([$this->getReference('student1')]);
      $manager->persist($action1);
      $manager->flush();

    }

    public function getOrder()
    {
        return 7;
    }
}