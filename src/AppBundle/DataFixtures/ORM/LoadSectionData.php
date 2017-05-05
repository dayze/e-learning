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
        $section1->addStudent($this->getReference('student1'))
                ->addStudent($this->getReference('student2'));
        $section1->addSupervisor($this->getReference('supervisor1'))
                ->addSupervisor($this->getReference('supervisor2'));
        $this->addReference('section1', $section1);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setName('BTS MUC');
        $section2->setPromotion(new \DateTime());
        $section2->addStudent($this->getReference('student3'))
                ->addStudent($this->getReference('student4'));
        $section2->addSupervisor($this->getReference('supervisor1'))
            ->addSupervisor($this->getReference('supervisor2'));
        $this->addReference('section2', $section2);
        $manager->persist($section2);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}