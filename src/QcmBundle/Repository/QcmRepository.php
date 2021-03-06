<?php

namespace QcmBundle\Repository;

/**
 * QcmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QcmRepository extends \Doctrine\ORM\EntityRepository
{
    public function findScoreByStudent($student_id, $qcm_id)
    {
        return $this->createQueryBuilder('q')
            ->innerJoin('q.score', 's')
            ->addSelect('s')
            ->where('s.student = :student_id')
            ->andWhere('q.id = :qcm_id')
            ->setParameters(['student_id' => $student_id, 'qcm_id' => $qcm_id])
            ->getQuery()
            ->getResult();
    }
}
