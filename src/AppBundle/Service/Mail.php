<?php


namespace AppBundle\Service;


use Swift_Mailer;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class Mail
{

    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    public function __construct(Twig_Environment $twig, Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function sendMail($subject, $mailTo, $view, $parameters)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom()
            ->setTo($mailTo)
            ->setBody(
                $this->renderView($view, $parameters),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function renderView($view, $parameters)
    {
        $response = new Response();
        $response->setContent($this->twig->render($view, $parameters));
        return $response;
    }
}