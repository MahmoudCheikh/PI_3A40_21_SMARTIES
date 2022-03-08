<?php

namespace App\Controller;

use App\Entity\Emplacement;
use App\Entity\Produit;
use App\Repository\AchatRepository;
use App\Repository\CommandeRepository;
use App\Repository\AccessoireRepository;
use App\Repository\EmplacementRepository;
use App\Repository\ProduitRepository;
use App\Repository\SujetRepository;
use App\Repository\VeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/test/", name="siteback")
     */
    public function test(): Response
    {
        return $this->render('/base_back.html.twig');
    }

    /**
     * @Route("/", name="site")
     */
    public function front(ProduitRepository $produitRepository,SujetRepository $sujetRepository): Response
    {

        if($this->getUser()!= null){


       if ($this->getUser()->getUsername() == "ADMIN@ADMIN.COM"){
           return $this->redirectToRoute("siteback");
        }
        }

        $produits = $produitRepository->findAll();
        $produits = array_slice($produits ,0 , 4);
        $sujets= $sujetRepository->findAll();
        $sujets = array_slice($sujets ,0 , 3);

        return $this->render('/base_front.html.twig',[
            'produits' => $produits,
            'sujets'=>$sujets,
        ]);
    }

    /**
     * @Route("/commandefront", name="ahmed" , methods={"GET"})
     */

    public function ahmed_b(CommandeRepository $CommandeRepository): Response
    {
        return $this->render('/commande/commandeFront.html.twig', [
            'Commandes' => $CommandeRepository->findAll(),

        ]);
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



    /*
    /**
     * @Route("/produitfront", name="mariem")
     *//*
    public function mariem_e(ProduitRepository $ProduitRepository,VeloRepository $veloRepository,AccessoireRepository $accessoireRepository): Response
    {
        return $this->render('/produit/mariem_front.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
            'velos' => $veloRepository->findAll(),
            'accessoires' => $accessoireRepository->findAll(),
        ]);
    }
*/

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
    /**
     * @Route("/triparcapacite", name="triparcapacite", methods={"GET"})
     */
    public function triparcapacite (EmplacementRepository $emplacementRepository,Request $request):Response
    {
        return $this->render('/emplacement/site_front.html.twig',[
            'emplacements' => $this->getDoctrine()->getRepository(Emplacement::class)->findBy([], ['capacite' => 'DESC']),
        ]);
    }
    /**
     * @Route("/trirSites", name="trirSites", methods={"GET"})
     */
    public function trirSites(EmplacementRepository $emplacementRepository,Request $request):Response
    {
        return $this->render('/emplacement/site_front.html.twig',[
            'emplacements' => $this->getDoctrine()->getRepository(Emplacement::class)->findBy([], ['lieu' => 'ASC']),
        ]);
    }



}
