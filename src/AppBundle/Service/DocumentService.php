<?php


namespace AppBundle\Service;


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
}