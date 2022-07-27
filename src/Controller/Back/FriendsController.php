<?php

namespace App\Controller\Back;

use App\Entity\Friends;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;
use App\Form\FriendsTypeBackoffice;
use App\Repository\FriendsRepository;

#[Route('/admin/friends')]
class FriendsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'admin_friends_index', methods: ['GET'])]
    public function index(FriendsRepository $friendsRepository): Response
    {
        return $this->render('back/friends/index.html.twig', [
            'friends' => $friendsRepository->findAll(),
            'title' => 'Demandes d\'amis'
        ]);
    }

    #[Route('/new', name: 'admin_friends_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $friend = new Friends();
        $form = $this->createForm(FriendsTypeBackoffice::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $friend->setSenderUser($form->getData()->getSenderUser());
            $friend->setReceiverUser($form->getData()->getReceiverUser());
            $friend->setStatus('sent');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($friend);
            $entityManager->flush();

            return $this->redirectToRoute('admin_friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/friends/new.html.twig', [
            'friend' => $friend,
            'form' => $form,
            'title' => 'Invitations'
        ]);
    }

    #[Route('/{id}', name: 'admin_friends_show', methods: ['GET'])]
    public function show(Friends $friend): Response
    {
        return $this->render('back/friends/show.html.twig', [
            'friend' => $friend,
            'title' => 'Informations de la demande d\'amis'
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_friends_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Friends $friend): Response
    {
        $form = $this->createForm(FriendsTypeBackoffice::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $friend->setSenderUser($form->getData()->getSenderUser());
            $friend->setReceiverUser($form->getData()->getReceiverUser());
            $friend->setStatus($form->getData()->getStatus());
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($friend);
            $entityManager->flush();

            return $this->redirectToRoute('admin_friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/friends/edit.html.twig', [
            'friend' => $friend,
            'form' => $form,
            'title' => 'Invitations'
        ]);
    }

    #[Route('/{id}', name: 'admin_friends_delete', methods: ['POST'])]
    public function delete(Request $request, Friends $friend): Response
    {
        if ($this->isCsrfTokenValid('delete' . $friend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friend);;
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_friends_index', [], Response::HTTP_SEE_OTHER);
    }
}
