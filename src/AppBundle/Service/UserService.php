<?php


namespace AppBundle\Service;


class UserService extends BaseService
{
    public function findByRole($role)
    {
        return $this->container->get("doctrine")
            ->getRepository("AppBundle:User")
            ->findByRole($role);
    }
}