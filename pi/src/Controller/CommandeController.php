<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Form\CommandeFrontType;
use App\Repository\CommandeRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{

    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $CommandeRepository): Response
    {
       /* return $this->render('Commande/index.html.twig', [
            'Commandes' => $CommandeRepository->findAll(),
        ]);*/
        return $this->render('Commande/ahmed.html.twig', [
            'Commandes' => $CommandeRepository->findAll(),
        ]);

    }


    /**
     * @Route("/commandefront", name="commandefront" , methods={"GET"})
     */

    public function ahmed_a(CommandeRepository $CommandeRepository): Response
    {
        return $this->render('/commande/commandefront.html.twig', [
            'Commandes' => $CommandeRepository->findAll(),

        ]);
    }


    /**
     * @Route("/new", name="commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Commande);
            $entityManager->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/new.html.twig', [
            'commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newFront", name="commande_newFront", methods={"GET", "POST"})
     */
    public function newF(Request $request, EntityManagerInterface $entityManager,UsersRepository $usersRepository): Response
    {
        $Commande = new Commande();
        $form = $this->createForm(CommandeFrontType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->find(2);
            $Commande->setIdUser($user);
            $entityManager->persist($Commande);

            $entityManager->flush();

            return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/newFront.html.twig', [
            'commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $Commande): Response
    {
        return $this->render('Commande/show.html.twig', [
            'commande' => $Commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $Commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/edit.html.twig', [
            'commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     */
    public function deleteback(Request $request, Commande $Commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($Commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/commandef/{id}", name="commande_delete_front", methods={"POST" , "GET"})
     */
    public function deletefront(Request $request, Commande $Commande, EntityManagerInterface $entityManager , int $id): Response
    {
        $entityManager->remove($Commande);
        $entityManager->flush();


        return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
    }
/*
    /**
     * @Route("/commandeupdate/{id}", name="commande_update_front", methods={"POST" , "GET"})
     */
  //  public function updatefront(int $nb,CommandeRepository  $commandeRepository,Request $request, Commande $Commande, EntityManagerInterface $entityManager , int $id): Response
//    {

        //$test = $commandeRepository->find($id);
       // $test->setNbProduits($nb);
      //  $entityManager->persist($test);
    //    $entityManager->flush();


  //      return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
//    }


    /**
     * @Route("/{id}/editF", name="commande_update_front", methods={"GET", "POST"})
     */
    public function updatefront(Request $request, Commande $Commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeFrontType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('commandefront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/updateFront.html.twig', [
            'commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }



}





