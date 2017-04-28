<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Document;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDocumentData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $document1 = new Document();

        $document1->setPath('web/upload/test.txt');
        $document1->setAvailable(true);
        $document1->setName("Cours 1");
        $document1->setType('pdf');
        $manager->persist($document1);
        $this->addReference('document1', $document1);

        $document2 = new Document();

        $document2->setPath('web/upload/test2.txt');
        $document2->setAvailable(true);
        $document2->setName("Cours 2");
        $document2->setType('pdf');
        $manager->persist($document2);
        $this->addReference('document2', $document2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}