<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/test/", name="site")
     */
    public function test(): Response
    {
        return $this->render('/test.html.twig');
    }

    /**
     * @Route("/ahmed/", name="ahmed")
     */
    public function ahmed(): Response
    {
        return $this->render('/ahmed.html.twig');
    }

    /**
     * @Route("/fadwa/", name="fadwa")
     */
    public function fadwa(): Response
    {
        return $this->render('/fadwa.html.twig');
    }

    /**
     * @Route("/aziz/", name="aziz")
     */
    public function aziz(): Response
    {
        return $this->render('/aziz.html.twig');
    }

    /**
     * @Route("/mariem/", name="mariem")
     */
    public function mariem(): Response
    {
        return $this->render('/mariem.html.twig');
    }

    /**
     * @Route("/mahmoud/", name="mahmoud")
     */
    public function mahmoud(): Response
    {
        return $this->render('/mahmoud.html.twig');
    }

    /**
     * @Route("/hazem/", name="hazem")
     */
    public function hazem(): Response
    {
        return $this->render('/hazem.html.twig');
    }

    /**
     * @Route("/autre/", name="autre")
     */
    public function autre(): Response
    {
        return $this->render('/autre.html.twig');
    }


}
