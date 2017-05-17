<?php


namespace StudentBundle\Service;


use AppBundle\Service\BaseService;
use StudentBundle\Entity\Action;

class ActionService extends BaseService
{
    public function SaveAction($student, $actionName)
    {
        $action = new Action();
        $action->setName($actionName);
        $action->setStudents([$student]);
        $this->addEntity($action);
    }
}