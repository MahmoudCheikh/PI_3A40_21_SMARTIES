<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $ProduitRepository): Response
    {
        return $this->render('Produit/index.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
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
            $entityManager->persist($Produit);
            $entityManager->flush();

            return $this->redirectToRoute('Produit_index', [], Response::HTTP_SEE_OTHER);
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
            'Produit' => $Produit,
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
            $entityManager->flush();

            return $this->redirectToRoute('Produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Produit/edit.html.twig', [
            'Produit' => $Produit,
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

        return $this->redirectToRoute('Produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
