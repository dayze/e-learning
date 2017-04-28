<?php


namespace QcmBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use QcmBundle\Entity\Qcm;

class LoadQcmData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $qcm1 = new Qcm();
        $qcm1->setName('Programmation Orienté Objet');
        $this->addReference('qcm1', $qcm1);
        $manager->persist($qcm1);

        $qcm2 = new Qcm();
        $qcm2->setName('HTML 5');
        $this->addReference('qcm2', $qcm2);
        $manager->persist($qcm2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}