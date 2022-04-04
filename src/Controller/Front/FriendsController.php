<?php

namespace App\Controller\Front;

use App\Entity\Friends;
use App\Entity\User;
use App\Form\FriendsType;
use App\Form\FriendsAcceptRequestType;
use App\Repository\FriendsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/friends')]
class FriendsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'friends_index', methods: ['GET', 'POST'])]
    public function index(Request $request, FriendsRepository $friendsRepository): Response
    {
        $friendsSendedByCurrentUser = $friendsRepository->findBy(['senderUser' => $this->getUser()]);
        $friendsReceivedByCurrentUser = $friendsRepository->findBy(['receiverUser' => $this->getUser()]);
        $friendsOfCurrentUser = array_merge($friendsSendedByCurrentUser, $friendsReceivedByCurrentUser);
        $uniqueFriendsOfCurrentUser = array_unique($friendsOfCurrentUser);

        $arrUserFriendsReceived = [];
        for ($i=0; $i<sizeof($friendsReceivedByCurrentUser); $i++){
            array_push($arrUserFriendsReceived, $this->getDoctrine()->getRepository(User::class)->findBy(['id' => $friendsReceivedByCurrentUser[$i]->getSenderUser()->getId()]));
        }
        return $this->render('friends/index.html.twig', [
            'friendsRequestsOfCurrentUser' => $uniqueFriendsOfCurrentUser,
//            'friendsRequestReceived' => $arrUserFriendsReceived[0] ?? null,
        ]);
    }

    #[Route('/new', name: 'friends_new', methods: ['GET','POST'])]
    public function new(Request $request, FriendsRepository $friendsRepository): Response
    {
        $friend = new Friends();
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        $friendsAcceptedSendedByCurrentUser = $friendsRepository->findBy(['status' => 'accepted', 'senderUser' => $this->getUser() ]);
        $friendsAcceptedReceivedByCurrentUser = $friendsRepository->findBy(['status' => 'accepted', 'receiverUser' => $this->getUser() ]);
        $friendsAcceptedByCurrentUser = array_merge($friendsAcceptedReceivedByCurrentUser, $friendsAcceptedSendedByCurrentUser);

        $allUsers = $this->getDoctrine()->getRepository(User::class)->findAll();


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $friend->setSenderUser($this->security->getUser());
            $friend->setStatus('sent');

            $entityManager->persist($friend);
            $entityManager->flush();

            return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('friends/new.html.twig', [
            'friend' => $friend,
            'form' => $form,
            'usersList' => $allUsers,
        ]);
    }

    #[Route('/{id}', name: 'friends_show', methods: ['GET'])]
    public function show(Friends $friend): Response
    {
        $friendSendToVue = null;
         if ($friend->getSenderUser() === $this->security->getUser()) {
             $friendSendToVue = $this->getDoctrine()->getRepository(User::class)->findBy(['id' => $friend->getReceiverUser()->getId()]);
         } else {
             $friendSendToVue = $this->getDoctrine()->getRepository(User::class)->findBy(['id' => $friend->getSenderUser()->getId()]);
         };
        dump($friendSendToVue);
        return $this->render('friends/show.html.twig', [
            'friend' => $friend,
        ]);
    }

    /*
     * @ParamConverter("id", class="Friends", options={"id": "id"})
     */
    #[Route('/{id}/accept', name: 'friends_accept', methods: ['GET', 'POST'])]
    public function friendsAccept(Friends $friends, FriendsRepository $friendsRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $friendRequest = $friendsRepository->findOneBy(['id' => $friends->getId()]);
        $friendRequest->setStatus('accepted');
        $entityManager->persist($friendRequest);
        $entityManager->flush();

        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'friends_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Friends $friend): Response
    {
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('friends/edit.html.twig', [
            'friend' => $friend,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'friends_delete', methods: ['POST'])]
    public function delete(Request $request, Friends $friend): Response
    {
        if ($this->isCsrfTokenValid('delete'.$friend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friend);
            $entityManager->flush();
        }

        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }
}
