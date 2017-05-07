<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Supervisor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSupervisorData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        
        $supervisor1 = new Supervisor();
        $supervisor1->setUsername("supervisor1");
        $supervisor1->setPlainPassword("supervisor1");
        $supervisor1->setEnabled(true);
        $supervisor1->setEmail("supervisor1@supervisor1.fr");
        $supervisor1->setRoles(array("ROLE_SUPERVISOR"));
        $supervisor1->setFirstName('Sophie');
        $supervisor1->setLastName('Boucher');
        $manager->persist($supervisor1);
        $this->addReference('supervisor1', $supervisor1);

        $supervisor2 = new Supervisor();
        $supervisor2->setUsername("supervisor2");
        $supervisor2->setPlainPassword("supervisor2");
        $supervisor2->setEnabled(true);
        $supervisor2->setEmail("supervisor2@supervisor2.fr");
        $supervisor2->setRoles(array("ROLE_SUPERVISOR"));
        $supervisor2->setFirstName('Henri');
        $supervisor2->setLastName('Dumas');
        $manager->persist($supervisor2);
        $this->addReference('supervisor2', $supervisor2);

        $supervisor3 = new Supervisor();
        $supervisor3->setUsername("supervisor3");
        $supervisor3->setPlainPassword("supervisor3");
        $supervisor3->setEnabled(true);
        $supervisor3->setEmail("supervisor3@supervisor3.fr");
        $supervisor3->setRoles(array("ROLE_SUPERVISOR"));
        $supervisor3->setFirstName('Émilie');
        $supervisor3->setLastName('Mary');
        $manager->persist($supervisor3);
        $this->addReference('supervisor3', $supervisor3);

        $supervisor4 = new Supervisor();
        $supervisor4->setUsername("supervisor4");
        $supervisor4->setPlainPassword("supervisor4");
        $supervisor4->setEnabled(true);
        $supervisor4->setEmail("supervisor4@supervisor4.fr");
        $supervisor4->setRoles(array("ROLE_SUPERVISOR"));
        $supervisor4->setFirstName('Marcel');
        $supervisor4->setLastName('Legendre');
        $manager->persist($supervisor4);
        $this->addReference('supervisor4', $supervisor4);

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}