<?php


namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{

    public function logout(Request $Request, Response $Response, TokenInterface $Token)
    {
        dump($Request);
        die();
    }

}