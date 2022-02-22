<?php

namespace App\Controller;

use App\Entity\Sujet;
use App\Form\SujetFrontType;
use App\Form\SujetType;
use App\Repository\SujetRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sujet")
 */
class SujetController extends AbstractController
{
    /**
     * @Route("/", name="sujet_index", methods={"GET"})
     */
    public function index(SujetRepository $sujetRepository): Response
    {
        return $this->render('sujet/index.html.twig', [
            'sujets' => $sujetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/front", name="sujet_front", methods={"GET"})
     */
    public function indexfront(SujetRepository $sujetRepository): Response
    {
        return $this->render('sujet/sujettest.html.twig', [
            'sujets' => $sujetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sujet_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sujet);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujet/new.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/newfront", name="sujet_new_front", methods={"GET", "POST"})
     */
    public function newFront(Request $request, EntityManagerInterface $entityManager , UsersRepository $usersRepository): Response
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetFrontType::class, $sujet);
        $form->handleRequest($request);
        $sujet->setDate(new \DateTime());

        $user = $usersRepository->find($this->getUser()->getId());


        if ($form->isSubmitted() && $form->isValid()) {
            $sujet->setIdUser($user);
            $sujet->setIdPost(1);
            $entityManager->persist($sujet);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujet/SujetCreateFront.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sujet_show", methods={"GET"})
     */
    public function show(Sujet $sujet): Response
    {
        return $this->render('sujet/show.html.twig', [
            'sujet' => $sujet,
        ]);
    }

    /**
     * @Route("/front/{id}", name="sujet_show_front", methods={"GET"})
     */
    public function showFront(Sujet $sujet): Response
    {
        return $this->render('sujet/SujetShowOne.html.twig', [
            'sujet' => $sujet,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="sujet_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sujet $sujet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sujet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujet/edit.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/front", name="sujet_front_edit", methods={"GET", "POST"})
     */
    public function editFront(Request $request, Sujet $sujet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SujetFrontType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sujet_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujet/edit_front.html.twig', [
            'sujet' => $sujet,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="sujet_delete", methods={"POST"})
     */
    public function delete(Request $request, Sujet $sujet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sujet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sujet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sujet_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/{id}", name="sujet_delete_front", methods={"POST"})
     */
    public function Front(Request $request, Sujet $sujet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sujet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sujet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sujet_front', [], Response::HTTP_SEE_OTHER);
    }

}

