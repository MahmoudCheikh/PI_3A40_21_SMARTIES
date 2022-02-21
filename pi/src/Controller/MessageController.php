<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Sujet;
use App\Form\MessageFrontType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use App\Repository\SujetRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newfront/{id}", name="message_new_front", methods={"GET", "POST"})
     */
    public function newFront(Request $request, EntityManagerInterface $entityManager , int $id , SujetRepository $sujetRepository, UsersRepository $usersRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageFrontType::class, $message);
        $form->handleRequest($request);
        $user = $usersRepository->find($this->getUser()->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $test = $sujetRepository->find($id);
            $message->setIdSujet($test);
            $message->setDate(new \DateTime());
            $message->setIdUser($user);
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('sujet_show_front', array(  'id'=> $test->getId()), Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/msgNewFront.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/deletefront/{id}", name="message_front_delete", methods={"POST"})
     */
    public function deleteFront(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $sujet = $message->getIdSujet()->getId();
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sujet_show_front', array(  'id'=> $sujet), Response::HTTP_SEE_OTHER);
    }
}

