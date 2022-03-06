<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Form\EvenementType;
use App\Repository\ActiviteRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("/evenement")
 */
class EvenementController extends Controller
{

    /**
     * @Route("/evenement_front/", name="aziz" , methods={"GET"})
     */
    public function aziz(EvenementRepository $EvenementRepository, Request $request): Response
    {
        //dump($request->get('search'));
        if (null != $request->get('search') && null != $request->get('search1')) {
            $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['type' => $request->get('search'), 'nom' => $request->get('search1')]);
            $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
            return $this->render('/evenement/eventindex.html.twig', [
                'evenements' => $evenement,
            ]);
        }
        if (null != $request->get('search')) {
            $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['type' => $request->get('search')]);
            $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
            return $this->render('/evenement/eventindex.html.twig', [
                'evenements' => $evenement,
            ]);
        }
        if (null != $request->get('search1')) {
            $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findBy(['nom' => $request->get('search1')]);
            $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
            return $this->render('/evenement/eventindex.html.twig', [
                'evenements' => $evenement,
            ]);
        }
        $evenement = $EvenementRepository->findAll();
        $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
        return $this->render('/evenement/eventindex.html.twig', [
            'evenements' => $evenement,
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
     * @Route("/evenement_front/tripardate", name="trierpardate", methods={"GET"})
     */
    public function trierpardate(EvenementRepository $EvenementRepository, Request $request): Response
    {

        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findBy([], ['dateD' => 'ASC']);
        $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
        return $this->render('/evenement/eventindex.html.twig', [
            'evenements' => $evenement,
        ]);
    }

    /**
     * @Route("/evenement_front/triparnbplace", name="trierparnbplace", methods={"GET"})
     */
    public function trierparnbplace(EvenementRepository $EvenementRepository, Request $request): Response
    {

        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findBy([], ['nb_places' => 'ASC']);
        $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
        return $this->render('/evenement/eventindex.html.twig', [
            'evenements' => $evenement,
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
    public function delete(Request $request, Evenement $Evenement, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        if ($this->isCsrfTokenValid('delete' . $Evenement->getId(), $request->request->get('_token'))) {
            //$user = $this->getUser();
            $Test= $this->getDoctrine()->getRepository(Participation::class)->findAll();
            foreach ($Test as $item) {

                $email = (new Email())
                    ->from('mohamedaziz.jaziri1@esprit.tn')
                    ->to($item->getIdUser()->getEmail())
                    ->subject('Evenement Annulé')
                    ->html($this->renderView(
                        '/evenement/email.html.twig',[
                        'sa' =>$item,

                    ]),
                        'text/html'
                    ) ;

                $mailer->send($email);
            }
            $entityManager->remove($Evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/participerevent/{id}", name="participerevent", methods={"GET", "POST"})
     */
    public function participer(EvenementRepository $EvenementRepository,Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $event = $EvenementRepository->find($id);
        $Test= $this->getDoctrine()->getRepository(Participation::class)->findBy(['IdUser' => $user, 'IdEvent' => $event]);
        $Test = array_shift($Test);
        if($Test==null){
        $Participation = new Participation();
        $user = $this->getUser();
        $Participation->setIdUser($user);
        $event = $EvenementRepository->find($id);
        $event->setNbPlaces($event->getNbPlaces()-1);
        $event->setNbParticipants($event->getNbParticipants()-1);
        $Participation->setIdEvent($event);
        $entityManager->persist($Participation);
        $entityManager->flush();
        $evenement = $EvenementRepository->findAll();
        $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
        return $this->render('/evenement/eventindex.html.twig', [
            'evenements' => $evenement,
        ]); }
        else{
            $request
                ->getSession()
                ->getFlashBag()
                ->add('ajoute', 'vous participer deja a levenement!!!');
            return $this->redirectToRoute('aziz', [], Response::HTTP_SEE_OTHER);
        }

    }

    /**
     * @Route("/npparticiperevent/{id}", name="npparticiperevent", methods={"GET", "POST"})
     */
    public function npparticiper(EvenementRepository $EvenementRepository,Request $request,$id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $event = $EvenementRepository->find($id);
        $Participation= $this->getDoctrine()->getRepository(Participation::class)->findBy(['IdUser' => $user, 'IdEvent' => $event]);
        $Participation = array_shift($Participation);
        if($Participation==null){
            $request
                ->getSession()
                ->getFlashBag()
                ->add('ajouter', 'vous devez dabbord participer a levenement!!!');
            return $this->redirectToRoute('aziz', [], Response::HTTP_SEE_OTHER);
        }
        else{
        $event->setNbPlaces($event->getNbPlaces()+1);
        $event->setNbParticipants($event->getNbParticipants()+1);
        $entityManager->remove($Participation);
        $entityManager->flush();
        $evenement = $EvenementRepository->findAll();
        $evenement = $this->get('knp_paginator')->paginate($evenement, $request->query->getInt('page', 1), 4);
        //return $this->redirectToRoute('evenementfront', [], Response::HTTP_SEE_OTHER);
        return $this->render('/evenement/eventindex.html.twig', [
            'evenements' => $evenement,
        ]);}

    }
}


