<?php


namespace StudentBundle\Controller;


use StudentBundle\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ActionController extends Controller
{
    public function setStudentActAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $action = new Action();
            $action->setStudents([$this->getUser()]);
            $action->setName(trim($request->request->get('act')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();
            return new JsonResponse(["error" => false]);
        }
        else{
            return new JsonResponse(["error" => true], 400);
        }
    }

}