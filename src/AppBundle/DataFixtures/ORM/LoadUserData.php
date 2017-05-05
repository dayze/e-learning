<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Supervisor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername("admin");
        $userAdmin->setPlainPassword("admin");
        $userAdmin->setEnabled(true);
        $userAdmin->setEmail("admin@admin.fr");
        $userAdmin->setRoles(array("ROLE_ADMIN"));
        $manager->persist($userAdmin);
        $manager->flush();

        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}