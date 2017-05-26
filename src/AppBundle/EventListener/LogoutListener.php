<?php


namespace AppBundle\EventListener;


use AppBundle\Service\CheckRole;
use StudentBundle\Service\ActionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{

    /**
     * @var ActionService
     */
    private $actionService;
    /**
     * @var CheckRole
     */
    private $checkRole;

    public function __construct(ActionService $actionService, CheckRole $checkRole)
    {
        $this->actionService = $actionService;
        $this->checkRole = $checkRole;
    }

    public function logout(Request $Request, Response $Response, TokenInterface $Token)
    {
        if($this->checkRole->check('ROLE_STUDENT')){
            $student = $Token->getUser();
            $this->actionService->SaveAction($student, 'logout');
        }

    }

}