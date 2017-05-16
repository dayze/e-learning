<?php


namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class CheckRole
{
    private $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function check($role)
    {
        return $this->container->get('security.authorization_checker')->isGranted($role);
    }
}