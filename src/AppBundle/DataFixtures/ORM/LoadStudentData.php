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

        $user = new User();
        $user->setUsername("user");
        $user->setPlainPassword("user");
        $user->setEnabled(true);
        $user->setEmail("user@user.fr");
        $user->setRoles(array("ROLE_STUDENT"));
        $manager->persist($user);
        $this->addReference('user1', $user);

        $user2 = new User();
        $user2->setUsername("user2");
        $user2->setPlainPassword("user2");
        $user2->setEnabled(true);
        $user2->setEmail("user2@user.fr");
        $user2->setRoles(array("ROLE_STUDENT"));
        $manager->persist($user2);
        $this->addReference('user2', $user2);

        $user3 = new User();
        $user3->setUsername("supervisor");
        $user3->setPlainPassword("supervisor");
        $user3->setEnabled(true);
        $user3->setEmail("supervisor@user.fr");
        $user3->setRoles(array("ROLE_SUPERVISOR"));
        $manager->persist($user3);
        $this->addReference('user3', $user3);

        $supervisor1 = new Supervisor();
        $supervisor1->setUsername('supervisor1');
        $supervisor1->setPlainPassword('supervisor1');
        $supervisor1->setEnabled(true);
        $supervisor1->setEmail("supervisor1@gmail.");
        $supervisor1->setRoles(["ROLE_SUPERVISOR"]);
        $this->addReference("supervisor1", $supervisor1);
        $manager->persist($supervisor1);
        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}