<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Student;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadStudentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        
        $student1 = new Student();
        $student1->setUsername("student1");
        $student1->setPlainPassword("student1");
        $student1->setEnabled(true);
        $student1->setEmail("student1@student1.fr");
        $student1->setRoles(array("ROLE_STUDENT"));
        $student1->setFirstName('Margaret');
        $student1->setLastName('Lagarde');
        $manager->persist($student1);
        $this->addReference('student1', $student1);

        $student2 = new Student();
        $student2->setUsername("student2");
        $student2->setPlainPassword("student2");
        $student2->setEnabled(true);
        $student2->setEmail("student2@student2.fr");
        $student2->setRoles(array("ROLE_STUDENT"));
        $student2->setFirstName('Margot');
        $student2->setLastName('Legros');
        $manager->persist($student2);
        $this->addReference('student2', $student2);

        $student3 = new Student();
        $student3->setUsername("student3");
        $student3->setPlainPassword("student3");
        $student3->setEnabled(true);
        $student3->setEmail("student3@student3.fr");
        $student3->setRoles(array("ROLE_STUDENT"));
        $student3->setFirstName('Louise');
        $student3->setLastName('Barthelemy');
        $manager->persist($student3);
        $this->addReference('student3', $student3);

        $student4 = new Student();
        $student4->setUsername("student4");
        $student4->setPlainPassword("student4");
        $student4->setEnabled(true);
        $student4->setEmail("student4@student4.fr");
        $student4->setRoles(array("ROLE_STUDENT"));
        $student4->setFirstName('Frédéric');
        $student4->setLastName('Vallet-Couturier');
        $manager->persist($student4);
        $this->addReference('student4', $student4);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}