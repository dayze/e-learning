<?php


namespace AppBundle\EventListener;


use AppBundle\Service\CheckRole;
use DateTime;
use Doctrine\ORM\EntityManager;
use StudentBundle\Service\ActionService;
use StudentBundle\Service\RetrieveTimeService;
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
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var RetrieveTimeService
     */
    private $rt;

    public function __construct(ActionService $actionService, CheckRole $checkRole, EntityManager $em, RetrieveTimeService $rt)
    {
        $this->actionService = $actionService;
        $this->checkRole = $checkRole;
        $this->em = $em;
        $this->rt = $rt;
    }

    public function logout(Request $Request, Response $Response, TokenInterface $Token)
    {
        if($this->checkRole->check('ROLE_STUDENT')){
            $student = $Token->getUser();
            $this->actionService->SaveAction($student, 'logout');
            $lastLogin = $this->em->getRepository('StudentBundle:Action')->findActionAndStudent('login', $student->getId());
            $lastActionDate = new DateTime('now');
            $retrieveTime = $lastActionDate->diff($lastLogin->getDate());
            $this->rt->addRetrieveTime($retrieveTime, $student);
        }

    }

}