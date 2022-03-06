<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Favoris;
use App\Form\CommandeFrontType;
use App\Form\FavorisType;
use App\Form\ProduitType;
use App\Repository\AccessoireRepository;
use App\Repository\EmplacementRepository;
use App\Repository\ProduitRepository;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\UsersRepository;



/**
 * @Route("/produit")
 */
class ProduitController extends Controller
{

    /**
     * @Route("/velo", name="velo",methods={"GET"})
     */
    public function mariem_velo(ProduitRepository $ProduitRepository,Request $request): Response
    {
        //pagination
        $produit = $ProduitRepository->findBy(['type' => "Velo"]);
        $produit = $this->get('knp_paginator')->paginate(
            $produit,
            $request->query->getInt('page',1),4
        );
        //search
        //dump($request->get('search'));
        if (null != $request->get('search')) {
            $produit = $this->getDoctrine()->getRepository(Produit::class)->findBy(['libelle' => $request->get('search')]);
            $produit = $this->get('knp_paginator')->paginate($produit, $request->query->getInt('page',1), 4);
            return $this->render('/produit/velo.html.twig', [
                'Produits' => $produit,
            ]);
        }
        //render
        return $this->render('/produit/velo.html.twig', [
            'Produits' => $produit,
        ]);
    }
    /**
     * @Route("/accessoire", name="accessoire",methods={"GET"})
     */
    public function mariem_accessoire(ProduitRepository $ProduitRepository,Request $request): Response
    {
        //pagination
        $produit = $ProduitRepository->findBy(['type' => "Accessoire"]);
        $produit = $this->get('knp_paginator')->paginate(
            $produit,
            $request->query->getInt('page',1),4
        );
        //search
        //dump($request->get('search'));
        if (null != $request->get('search')) {
            $produit = $this->getDoctrine()->getRepository(Produit::class)->findBy(['libelle' => $request->get('search')]);
            $produit = $this->get('knp_paginator')->paginate($produit, $request->query->getInt('page',1), 4);
            return $this->render('/produit/accessoire.html.twig', [
                'Produits' => $produit,
            ]);
        }
        //render
        return $this->render('/produit/accessoire.html.twig', [
            'Produits' => $produit,
        ]);
    }
    /**
     * @Route("/pdr", name="pdr",methods={"GET"})
     */
    public function mariem_pdr(ProduitRepository $ProduitRepository,Request $request): Response
    {

        //pagination
        $produit = $ProduitRepository->findBy(['type' => "Piece de Rechange"]);
        $produit = $this->get('knp_paginator')->paginate(
            $produit,
            $request->query->getInt('page',1),4
        );
        //search
        //dump($request->get('search'));
        if (null != $request->get('search')) {
            $produit = $this->getDoctrine()->getRepository(Produit::class)->findBy(['libelle' => $request->get('search')]);
            $produit = $this->get('knp_paginator')->paginate($produit, $request->query->getInt('page',1), 4);
            return $this->render('/produit/pdr.html.twig', [
                'Produits' => $produit,
            ]);
        }
        //render
        return $this->render('/produit/pdr.html.twig', [
            'Produits' => $produit,
        ]);
    }

    /**
     *
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $ProduitRepository): Response
    {
        /*return $this->render('Produit/index.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
        ]);*/

        return $this->render('produit/index.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/explore_produit/{id}", name="explore2" , methods={"GET","POST"})
     */
    public function explore2(Request $request, EntityManagerInterface $entityManager, UsersRepository $usersRepository , ProduitRepository $ProduitRepository,VeloRepository $veloRepository,$id): Response
    {
        $produit=$ProduitRepository->find($id);
        $Commande = new Commande();
        $form = $this->createForm(CommandeFrontType::class, $Commande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->find($this->getuser()->getid());
            $Commande->setIdUser($user);
            $Commande->setIdProduit($produit);
            $entityManager->persist($Commande);


            $entityManager->flush();

            return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
        }
        $Favoris = new Favoris ();
        $form1 = $this->createForm(FavorisType::class, $Favoris );
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            $user = $usersRepository->find($this->getuser()->getid());
            $Favoris ->setIdUser($user);
            $Favoris ->setIdProduit($produit);
            $entityManager->persist($Favoris );


            $entityManager->flush();

            return $this->redirectToRoute('favoris', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/produit/ExploreProduit.html.twig', [
                'produit'=> $produit,
            'velos' => $veloRepository->findAll(),
            'commande' => $Commande,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
        ]);
    }
    /**
     * @Route("/new", name="produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Produit = new Produit();
        $form = $this->createForm(ProduitType::class, $Produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $new=$form->getData();
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'img\bike',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $Produit->setImage($newFilename);
            }
            $entityManager->persist($Produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Produit/new.html.twig', [
            'Produit' => $Produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $Produit): Response
    {
        return $this->render('Produit/show.html.twig', [
            'produit' => $Produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $Produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $Produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $new=$form->getData();
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        'img\bike',
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $Produit->setImage($newFilename);
            }




            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Produit/edit.html.twig', [
            'produit' => $Produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $Produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }


}
