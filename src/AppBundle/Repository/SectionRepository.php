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

}
