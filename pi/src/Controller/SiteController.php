<?php

namespace App\Controller;

use App\Repository\AchatRepository;
use App\Repository\CommandeRepository;
use App\Repository\AccessoireRepository;
use App\Repository\EmplacementRepository;
use App\Repository\ProduitRepository;
use App\Repository\VeloRepository;
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
        return $this->render('/base_back.html.twig');
    }




    /**
     * @Route("/front/", name="site")
     */
    public function front(): Response
    {
        return $this->render('/base_front.html.twig');
    }



    /**
     * @Route("/fadwa/", name="fadwa")
     */
    public function fadwa(): Response
    {
        return $this->render('/abonnement/fadwa.html.twig');
    }

        /**
         * @Route("/ahmed/", name="ahmed")
         */
        public function ahmed(): Response
    {
        return $this->render('/commande/newFront.html.twig');
    }

    /**
     * @Route("/siteF", name="mariem", methods={"GET"})
     */
    public function mariem(EmplacementRepository $emplacementRepository): Response
    {
        return $this->render('/emplacement/site_front.html.twig', [
            'emplacements' => $emplacementRepository->findAll(),
        ]);
    }
    /**
     * @Route("/produitfront", name="mariem")
     */
    public function mariem_e(ProduitRepository $ProduitRepository,VeloRepository $veloRepository,AccessoireRepository $accessoireRepository): Response
    {
        return $this->render('/produit/mariem_front.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
            'velos' => $veloRepository->findAll(),
            'accessoires' => $accessoireRepository->findAll(),
        ]);
    }


    /**
     * @Route("/mahmoud/", name="mahmoud")
     */
    public function mahmoud(): Response
    {
        return $this->render('/users/mahmoud.html.twig');
    }

    /**
     * @Route("/hazem/", name="hazem")
     */
    public function hazem(): Response
    {
        return $this->render('/piecedr/hazem.html.twig');
    }

    /**
     * @Route("/autre/", name="autre")
     */
    public function autre(): Response
    {
        return $this->render('/autre.html.twig');
    }


}
