<?php


namespace QcmBundle\DataFixtures\ORM;


use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use QcmBundle\Entity\QcmQuestion;
use StudentBundle\Entity\RetrieveTime;

class LoadRetrieveTimeData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $date1rt1 = new DateTime();
        $date1rt1->setDate(2017, 5, 12);
        $date1rt1->setTime(14, 2);
        $date2rt1 = new DateTime();
        $date2rt1->setDate(2017, 5, 12);
        $date2rt1->setTime(15, 2);
        $timert1 = $date1rt1->diff($date2rt1);
        $rt1 = new RetrieveTime();
        $rt1->setDate($date1rt1);
        $rt1->setStudents($this->getReference('student1'));
        $rt1->setTime(new DateTime($timert1->format('%H:%I:%S')));
        $manager->persist($rt1);

        $date1rt2 = new DateTime();
        $date1rt2->setDate(2017, 5, 15);
        $date1rt2->setTime(16, 10);
        $date2rt2 = new DateTime();
        $date2rt2->setDate(2017, 5, 15);
        $date2rt2->setTime(16, 45);
        $timert2 = $date1rt2->diff($date2rt2);
        $rt2 = new RetrieveTime();
        $rt2->setDate($date1rt2);
        $rt2->setStudents($this->getReference('student1'));
        $rt2->setTime(new DateTime($timert2->format('%H:%I:%S')));
        $manager->persist($rt2);

        $date1rt3 = new DateTime();
        $date1rt3->setDate(2017, 5, 12);
        $date1rt3->setTime(14, 2);
        $date2rt3 = new DateTime();
        $date2rt3->setDate(2017, 5, 12);
        $date2rt3->setTime(15, 2);
        $timert3 = $date1rt3->diff($date2rt3);
        $rt3 = new RetrieveTime();
        $rt3->setDate($date1rt3);
        $rt3->setStudents($this->getReference('student2'));
        $rt3->setTime(new DateTime($timert3->format('%H:%I:%S')));
        $manager->persist($rt3);

        $date1rt4 = new DateTime();
        $date1rt4->setDate(2017, 5, 15);
        $date1rt4->setTime(16, 10);
        $date2rt4 = new DateTime();
        $date2rt4->setDate(2017, 5, 15);
        $date2rt4->setTime(16, 45);
        $timert4 = $date1rt4->diff($date2rt4);
        $rt4 = new RetrieveTime();
        $rt4->setDate($date1rt4);
        $rt4->setStudents($this->getReference('student2'));
        $rt4->setTime(new DateTime($timert4->format('%H:%I:%S')));
        $manager->persist($rt4);

        $date1rt5 = new DateTime();
        $date1rt5->setDate(2017, 4, 17);
        $date1rt5->setTime(14, 2);
        $date2rt5 = new DateTime();
        $date2rt5->setDate(2017, 4, 17);
        $date2rt5->setTime(14, 58);
        $timert5 = $date1rt5->diff($date2rt5);
        $rt5 = new RetrieveTime();
        $rt5->setDate($date1rt5);
        $rt5->setStudents($this->getReference('student1'));
        $rt5->setTime(new DateTime($timert5->format('%H:%I:%S')));
        $manager->persist($rt5);

        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}