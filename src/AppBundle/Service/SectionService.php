<?php
namespace AppBundle\Service;

use AppBundle\Entity\Section;
use AppBundle\Service\BaseService;
use Symfony\Component\HttpFoundation\Request;


class SectionService extends BaseService
{
    public function findSectionBySupervisor($id)
    {
        $sections = $this->container->get('doctrine')->getRepository('AppBundle:Section')->findSectionBySupervisor($id);
        $result = [];
        foreach ($sections as $section) {
            /** @var $section Section */
            $result[$section->getName()] = $section->getId();
        }
        return $result;
    }
}