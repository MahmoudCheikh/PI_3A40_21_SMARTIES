<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\ActiviteRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/evenement_front/", name="aziz" , methods={"GET"})
     */
    public function aziz(EvenementRepository $EvenementRepository , Request $request): Response
    {
        dump($request->get('search'));
        if (null !=$request->get('search')){
            return $this->render('/evenement/eventindex.html.twig',[
                'evenements' => $this->getDoctrine()->getRepository(Evenement::class)->findBy(['nom' => $request->get('search')]),
            ]);
        }
        return $this->render('/evenement/eventindex.html.twig',[
            'evenements' => $EvenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $EvenementRepository): Response
    {
        /*        return $this->render('Evenement/index.html.twig', [
                    'evenements' => $EvenementRepository->findAll(),
                ]);
        */
        return $this->render('Evenement/index.html.twig', [
            'evenements' => $EvenementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/activite_front/{id}", name="aziz1" , methods={"GET"})
     */
    public function aziz1(Evenement $Evenement, ActiviteRepository $ActiviteRepository): Response
    {
        return $this->render('/evenement/activiteindex.html.twig', [
            'evenement' => $Evenement,
            'activites' => $ActiviteRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $Evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Evenement/new.html.twig', [
            'evenement' => $Evenement,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $Evenement): Response
    {
        return $this->render('Evenement/show.html.twig', [
            'evenement' => $Evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $Evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $Evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Evenement/edit.html.twig', [
            'evenement' => $Evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $Evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $Evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
    }





}



