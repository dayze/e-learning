<?php


namespace QcmBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use QcmBundle\Entity\QcmQuestion;

class LoadQcmQuestionData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $qcmQuestion1 = new QcmQuestion();
        $qcmQuestion1->setQuestion("Qu'est-ce que l'encapsulation ?");
        $qcmQuestion1->setQcm($this->getReference('qcm1'));
        $manager->persist($qcmQuestion1);
        $this->addReference('qcmQuestion1', $qcmQuestion1);

        $qcmQuestion2 = new QcmQuestion();
        $qcmQuestion2->setQuestion("Qu'est-ce que l'héritage ?");
        $qcmQuestion2->setQcm($this->getReference('qcm1'));
        $this->addReference('qcmQuestion2', $qcmQuestion2);
        $manager->persist($qcmQuestion2);


        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}