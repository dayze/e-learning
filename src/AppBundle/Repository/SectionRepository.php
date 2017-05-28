<?php

namespace AppBundle\Repository;

/**
 * SectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SectionRepository extends \Doctrine\ORM\EntityRepository
{
    public function findUserBySectionAndRole($id, $roles)
    {
        $qb = $this->createQueryBuilder('a');
        return $qb
            ->join('a.students', 'students')
            ->addSelect('students')
            ->where('a.id = :id')
            ->andWhere('students.roles LIKE :roles')
            ->setParameter('id', $id)
            ->setParameter('roles', '%"' . $roles . '"%')
            ->getQuery()
            ->getSingleResult();
    }

    public function findSectionBySupervisor($id)
    {
        $qb = $this->createQueryBuilder('sec');
        return $qb
            ->innerJoin('sec.supervisors', 'sup')
            ->where('sup.id = :sup_id')
            ->setParameter('sup_id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findSectionByQcm($qcm_id)
    {
        return $this->createQueryBuilder('sec')
            ->join('sec.docRelation', 'docRelation')
            ->join('docRelation.qcm', 'qcm')
            ->join('qcm.score', 'score')
            ->addSelect('docRelation')
            ->addSelect('qcm')
            ->where('docRelation.qcm = :qcm_id')
            ->setParameter('qcm_id', $qcm_id)
            ->getQuery()
            ->getResult();
    }

    public function getTimeRetrieveForSectionAndMonth($section_id, $date)
    {
        $startDate = date($date) . '-01';
        $endDate = date('Y-m-t', strtotime($date));
        return $this->createQueryBuilder('s')
            ->join('s.students', 'stu')
            ->addSelect('stu')
            ->join('stu.retrieveTime', 'rt')
            ->addSelect('rt')
            ->where('s.id=:section_id')
            ->andWhere('rt.date >= :startDate')
            ->andWhere('rt.date <= :endDate')
            ->setParameters([
                'section_id' => $section_id,
                'startDate' => $startDate,
                'endDate' => $endDate
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }


}
