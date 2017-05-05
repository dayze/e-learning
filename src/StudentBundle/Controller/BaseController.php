<?php

namespace StudentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function indexAction()
    {
        $student = $this->getUser();
        $sections = $student->getSections();
        return $this->render('StudentBundle:part:index.html.twig', ['sections' => $sections]);
    }
}
