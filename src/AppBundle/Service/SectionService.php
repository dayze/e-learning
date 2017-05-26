<?php
namespace AppBundle\Service;

use AppBundle\Entity\Section;
use AppBundle\Service\BaseService;
use Symfony\Component\HttpFoundation\Request;


class SectionService extends BaseService
{
    public function findSectionBySupervisor($id)
    {
        return $this->container->get('doctrine')->getRepository('AppBundle:Section')->findSectionBySupervisor($id);
    }
}