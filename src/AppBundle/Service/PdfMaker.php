<?php


namespace AppBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PdfMaker
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function makePdf($view)
    {
        $filename = sprintf('test-%s.pdf', date('Y-m-d'));
        return new Response(
            $this->container->get('knp_snappy.pdf')->getOutputFromHtml($view, [
                'encoding' => 'utf-8',
            ]),
            200,
            [
                'Content-Type' => 'application/pdf; charset=utf-8',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ]
        );
    }

}