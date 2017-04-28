<?php


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function debugAction()
    {
        $sectionSE = $this->get('app.section');
        var_dump($sectionSE->findAll("AppBundle:Section"));
        $this->get("doctrine")->getRepository("AppBundle:User")->findBy();
    }

    public function indexAction()
    {
        $securityContext = $this->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->dashboardAction();
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function dashboardAction()
    {
        return $this->render('AppBundle:Default:homepage.html.twig');
    }



}