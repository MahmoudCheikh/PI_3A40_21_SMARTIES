<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Form\FavorisType;
use App\Repository\FavorisRepository;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favoris")
 */
class FavorisController extends AbstractController
{
    /**
     * @Route("/", name="favoris_index", methods={"GET"})
     */
    public function index(FavorisRepository $favorisRepository): Response
    {
        return $this->render('favoris/index.html.twig', [
            'favoris' => $favorisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="favoris_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $favori = new Favoris();
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($favori);
            $entityManager->flush();

            return $this->redirectToRoute('favoris_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('favoris/new.html.twig', [
            'favori' => $favori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favoris_show", methods={"GET"})
     */
    public function show(Favoris $favori): Response
    {
        return $this->render('favoris/show.html.twig', [
            'favori' => $favori,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="favoris_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Favoris $favori, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('favoris_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('favoris/edit.html.twig', [
            'favori' => $favori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favoris_delete", methods={"POST"})
     */
    public function delete(Request $request, Favoris $favori, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favori->getId(), $request->request->get('_token'))) {
            $entityManager->remove($favori);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favoris_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/{id}", name="favoris" , methods={"GET"})
     */
    public function favoris(ProduitRepository $produitRepository,UsersRepository $usersRepository , EntityManagerInterface $entityManager,$id): Response
    {
        $produit=$ProduitRepository->find($id);
        $Favoris = new Favoris ();
        $form = $this->createForm(FavorisType::class, $Favoris );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->find($this->getuser()->getid());
            $Favoris ->setIdUser($user);
            $Favoris ->setIdProduit($produit);
            $entityManager->persist($Favoris );


            $entityManager->flush();

            return $this->redirectToRoute('favoris', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/produit/favoris.html.twig', [
            'produit'=> $produit,
            'Favoris' => $Favoris ,
            'form' => $form->createView(),
        ]);

    }
}
