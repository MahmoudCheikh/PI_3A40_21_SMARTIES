<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Commande;
use App\Form\AchatType;
use App\Repository\AchatRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/achat")
 */
class AchatController extends AbstractController
{
    /**
     * @Route("/", name="achat_index", methods={"GET"})
     */
    public function index(AchatRepository $achatRepository): Response
    {
        return $this->render('achat/index.html.twig', [
            'achats' => $achatRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="achat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, UsersRepository $usersRepository): Response
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $usersRepository->find($this->getuser()->getid());
            $achat->setIdUser($user);
            $entityManager->persist($achat);
            $entityManager->flush();

            return $this->redirectToRoute('achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('achat/new.html.twig', [
            'achat' => $achat,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/frontnew/{id}", name="achat_front_new", methods={"GET", "POST"})
     */
    public function newFront(int $id,Request $request, EntityManagerInterface $entityManager, UsersRepository $usersRepository,CommandeRepository $commandeRepository): Response
    {
        $commande = $commandeRepository->find($id);
        $achat = new Achat();
        $user = $usersRepository->find($this->getuser()->getid());
        $achat->setIdUser($user);
        $achat->setIdProduit($commande->getIdProduit());
        $achat->setDate(new \DateTime());
        $achat->setNomClient($user->getNom());
        $achat->setNumeroClient($commande->getNbProduits());
        $entityManager->persist($achat);
        $entityManager->flush();

        $entityManager->remove($commande);
        $entityManager->flush();


        return $this->redirectToRoute('achatfront', [], Response::HTTP_SEE_OTHER);



    }



    /**
     * @Route("/tripardate", name="trierpardate", methods={"GET"})
     */
    public function trierpardate (AchatRepository $AchatRepository , Request $request): Response
    {
        return $this->render('/commande/achatfront.html.twig',[
            'achats' => $this->getDoctrine()->getRepository(Achat::class)->findBy([], ['numeroClient' => 'DESC']),
        ]);
    }



    /**
     * @Route("/pdfd", name="pdfd", methods={"GET"})
     */
    public function pdfd (AchatRepository $AchatRepository , Request $request): Response
    {
            $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $achats = $AchatRepository->findAll();

        $html = $this->renderView('/commande/achatfront.html.twig',[
            'achats' => $achats,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("MonFacture.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/{id}", name="achat_show", methods={"GET"})
     */
    public function show(Achat $achat): Response
    {
        return $this->render('achat/show.html.twig', [
            'achat' => $achat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="achat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('achat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('achat/edit.html.twig', [
            'achat' => $achat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="achat_delete", methods={"POST"})
     */
    public function delete(Request $request, Achat $achat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $achat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($achat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('achat_index', [], Response::HTTP_SEE_OTHER);
    }


}
