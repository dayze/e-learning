<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Section;

class LoadSectionData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $section1 = new Section();
        $section1->setName('BTS SIO');
        $section1->setPromotion(new \DateTime());
        $section1->addUser($this->getReference('user1'))
            ->addUser($this->getReference('user2'));
        //$section1->addDocument($this->getReference("document1"))->addDocument($this->getReference("document2"));
        $manager->persist($section1);
        $manager->flush();
        $this->addReference('section1', $section1);
    }

    public function getOrder()
    {
        return 3;
    }
}