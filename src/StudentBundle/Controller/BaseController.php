<?php

namespace StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        return $this->render('StudentBundle:Default:index.html.twig');
    }
}
