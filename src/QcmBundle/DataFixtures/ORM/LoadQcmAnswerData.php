<?php


namespace QcmBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use QcmBundle\Entity\QcmAnswer;

class LoadQcmAnswerData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $qcmAnswer1 = new QcmAnswer();
        $qcmAnswer1->setIsCorrect(true);
        $qcmAnswer1->setResponse('Représente une boite noire');
        $qcmAnswer1->setQcmQuestion($this->getReference('qcmQuestion1'));
        $manager->persist($qcmAnswer1);

        $qcmAnswer2 = new QcmAnswer();
        $qcmAnswer2->setIsCorrect(false);
        $qcmAnswer2->setResponse('Représente une boite blanche');
        $qcmAnswer2->setQcmQuestion($this->getReference('qcmQuestion1'));
        $manager->persist($qcmAnswer2);

        $qcmAnswer3 = new QcmAnswer();
        $qcmAnswer3->setIsCorrect(true);
        $qcmAnswer3->setResponse("L'héritage permet la réutilisabilité.");
        $qcmAnswer3->setQcmQuestion($this->getReference('qcmQuestion2'));
        $manager->persist($qcmAnswer3);

        $qcmAnswer4 = new QcmAnswer();
        $qcmAnswer4->setIsCorrect(false);
        $qcmAnswer4->setResponse("L'héritage permet l'encapsulation.");
        $qcmAnswer4->setQcmQuestion($this->getReference('qcmQuestion2'));
        $manager->persist($qcmAnswer4);
        


        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}