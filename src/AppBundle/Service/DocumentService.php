<?php


namespace AppBundle\Service;


use AppBundle\Entity\Document;
use AppBundle\Repository\DocumentRepository;

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

    public function findDocumentsFromSupervisor($repository, $id)
    {
        return $this->container->get('doctrine')->getRepository($repository)->findDocumentsFromSupervisor($id);
    }
}