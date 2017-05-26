<?php


namespace StudentBundle\Service;


use AppBundle\Entity\Student;
use AppBundle\Service\BaseService;
use DateTime;
use Doctrine\DBAL\Types\TimeType;
use StudentBundle\Entity\RetrieveTime;

class RetrieveTimeService extends BaseService
{
    public function addRetrieveTime($retrieveTime, Student $student)
    {
        $rt = new RetrieveTime();
        $rt->setTime(new DateTime($retrieveTime->format('%H:%I:%S')));
        $rt->setDate(new \DateTime('now'));
        $rt->setStudents($student);
        $this->em->persist($rt);
        $this->em->flush();
    }

    public function getTimeRetrieve(Student $student)
    {
        $retrieveTimes = $this->em->getRepository('StudentBundle:RetrieveTime')->getRetrieveTime($student);
        $intervals = [];
        foreach ($retrieveTimes as $retrieveTime) {
            /** @var $retrieveTime RetrieveTime */
            $intervals[] = $retrieveTime->getTime()->diff(new DateTime('1970-01-01 00:00:00'));
            $this->setEndDuration($retrieveTime);
        }
        $e = new DateTime('00:00:00');
        $f = clone $e;
        foreach ($intervals as $interval) {
            $e->add($interval);
        }
        $total = $f->diff($e)->format("%H:%I:%S");
        return $total;
    }

    public function setEndDuration($retrieveTime)
    {
        $f = clone $retrieveTime->getDate();
        $time = $retrieveTime->getTime()->diff(new DateTime('1970-01-01 00:00:00'));
        $endDate = $f->add($time);
        $retrieveTime->setBeginDate($endDate);
    }
}