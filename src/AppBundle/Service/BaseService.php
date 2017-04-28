<?php


namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


class BaseService
{
    protected $em;
    protected $container;

    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function findAll($repository)
    {
        return $this->container->get('doctrine')
        ->getRepository($repository)
        ->findAll();
    }

    public function find($repository, $id)
    {
        return $this->container->get('doctrine')->getRepository($repository)->find($id);
    }

    public function findBy($repository, array $criteria)
    {
        return $this->container->get('doctrine')
            ->getRepository($repository)
            ->findBy($criteria);
    }

    public function addEntity($entity)
    {
        $em =$this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();
    }

    public function deleteEntity($entity)
    {
        $em =$this->container->get('doctrine')->getManager();
        $em->remove($entity);
        $em->flush();
    }


}