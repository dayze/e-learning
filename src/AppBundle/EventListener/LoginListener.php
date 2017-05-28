<?php


namespace AppBundle\EventListener;


use AppBundle\Service\CheckRole;
use Doctrine\ORM\EntityManager;
use StudentBundle\Service\ActionService;
use StudentBundle\Service\RetrieveTimeService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Twig_Environment;

class LoginListener
{

    private $tokenStorage;
    private $em;
    private $checkRole;
    private $rt;
    private $actionService;
    private $twig;

    public function __construct(TokenStorage $tokenStorage, EntityManager $em, CheckRole $checkRole,
                                RetrieveTimeService $rt, ActionService $actionService, Twig_Environment $twig)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        $this->checkRole = $checkRole;
        $this->rt = $rt;
        $this->actionService = $actionService;
        $this->twig = $twig;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($this->checkRole->check('ROLE_STUDENT')) {
            $student = $this->tokenStorage->getToken()->getUser();
            $lastLogin = $this->em->getRepository('StudentBundle:Action')->findActionAndStudent('login', $student->getId());
            if ($lastLogin) {
                $lastAction = $this->em->getRepository('StudentBundle:Action')->findLast($student->getId());
                if($lastAction != "logout"){
                    $retrieveTime = $lastAction->getDate()->diff($lastLogin->getDate());
                    $this->rt->addRetrieveTime($retrieveTime, $student);
                }
            }
            $this->actionService->SaveAction($student, 'login');
        }
    }

}