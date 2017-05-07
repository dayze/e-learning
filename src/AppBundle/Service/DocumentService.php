<?php


namespace AppBundle\Service;


use AppBundle\Entity\Document;

class DocumentService extends BaseService
{
    public function findAllJoinSections()
    {
        return $this->container->get('doctrine')
            ->createQuery(
                'SELECT p, c FROM AppBundle:Document d
            JOIN d.sections s'
            );
    }

    public function addSection(Document $document, $request)
    {
        foreach ($request['sections'] as $sections) {
            $section = $this->container->get('doctrine')->getRepository('AppBundle:Section')->find($sections['sections']);
            $document->addSection($section);
            $courseCategory = $this->container->get('doctrine')->getRepository('AppBundle:CourseCategory')->find($sections['courseCategory']);
            $document->setCourseCategory($courseCategory);
            }
    }
}