<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\AccessoireRepository;
use App\Repository\EmplacementRepository;
use App\Repository\ProduitRepository;
use App\Repository\VeloRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{

    /**
     * @Route("/produitfront", name="marieme")
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
     *
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $ProduitRepository): Response
    {
        /*return $this->render('Produit/index.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
        ]);*/

        return $this->render('Produit/mariem.html.twig', [
            'Produits' => $ProduitRepository->findAll(),
        ]);
    }


    /*l fou9 l 7ketya lkol*/
    /**
     * @Route("/explore_produit/{id}", name="explore2" , methods={"GET"})
     */
    public function explore2(ProduitRepository $ProduitRepository,VeloRepository $veloRepository,AccessoireRepository $accessoireRepository,$id): Response
    {
        $produit=$ProduitRepository->find($id);

        return $this->render('/produit/ExploreProduit.html.twig', [
                'produit'=> $produit,
            'velos' => $veloRepository->findAll(),
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
