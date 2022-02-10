<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="Evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $EvenementRepository): Response
    {
        return $this->render('Evenement/index.html.twig', [
            'Evenements' => $EvenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="Evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $Evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Evenement);
            $entityManager->flush();

            return $this->redirectToRoute('Evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Evenement/new.html.twig', [
            'Evenement' => $Evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Evenement_show", methods={"GET"})
     */
    public function show(Evenement $Evenement): Response
    {
        return $this->render('Evenement/show.html.twig', [
            'Evenement' => $Evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="Evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $Evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $Evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('Evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Evenement/edit.html.twig', [
            'Evenement' => $Evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $Evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
