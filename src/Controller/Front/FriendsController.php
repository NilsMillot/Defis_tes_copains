<?php

namespace App\Controller\Front;

use App\Entity\Friends;
use App\Entity\FriendsSearch;
use App\Form\FriendsSearchType;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
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
    public function index(Request $request, FriendsRepository $friendsRepository, UserRepository $userRepository): Response
    {
        // crud part
        $friendsSendedByCurrentUser = $friendsRepository->findBy(['senderUser' => $this->getUser()]);
        $friendsReceivedByCurrentUser = $friendsRepository->findBy(['receiverUser' => $this->getUser()]);
        $friendsReceivedByCurrentUserStatusSent = $friendsRepository->findBy(['receiverUser' => $this->getUser(), 'status' => 'sent']);
        $friendsOfCurrentUser = array_merge($friendsSendedByCurrentUser, $friendsReceivedByCurrentUser);
        $uniqueFriendsOfCurrentUser = array_unique($friendsOfCurrentUser);

        $arrUserFriendsReceivedStatusSent = [];
        for ($i = 0; $i < sizeof($friendsReceivedByCurrentUserStatusSent); $i++) {
            array_push($arrUserFriendsReceivedStatusSent, $userRepository->findOneBy(['id' => $friendsReceivedByCurrentUserStatusSent[$i]->getSenderUser()->getId()]));
        }

        // search part
        $friendsAcceptedOrSentSendedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted', 'sent'], 'senderUser' => $this->getUser()]);
        $friendsAcceptedOrSentReceivedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted', 'sent'], 'receiverUser' => $this->getUser()]);
        $friendsAcceptedSendedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted'], 'senderUser' => $this->getUser()]);
        $friendsAcceptedReceivedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted'], 'receiverUser' => $this->getUser()]);
        $usersAcceptedOrSentReceivedByCurrentUser = array_map(function ($friend) {
            return $friend->getSenderUser();
        }, $friendsAcceptedOrSentReceivedByCurrentUser);
        $usersAcceptedOrSentSendedByCurrentUser = array_map(function ($friend) {
            return $friend->getReceiverUser();
        }, $friendsAcceptedOrSentSendedByCurrentUser);

        $usersAcceptedReceivedByCurrentUser = array_map(function ($friend) {
            return [$friend->getId(), $friend->getSenderUser()];
        }, $friendsAcceptedReceivedByCurrentUser);

        $usersAcceptedSendedByCurrentUser = array_map(function ($friend) {
            return [$friend->getId(), $friend->getReceiverUser()];
        }, $friendsAcceptedSendedByCurrentUser);

        // dd($usersAcceptedReceivedByCurrentUser);
        $usersAcceptedOrSent = array_merge($usersAcceptedOrSentReceivedByCurrentUser, $usersAcceptedOrSentSendedByCurrentUser);
        $usersAccepted = array_merge($usersAcceptedReceivedByCurrentUser, $usersAcceptedSendedByCurrentUser);

        $search = new FriendsSearch();
        $formSearch = $this->createForm(FriendsSearchType::class, $search);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid() && $formSearch->getData()->getName() != null) {
            $arrUsers = $userRepository->findUsers($formSearch->getData()->getName());
            $arrUsersExceptCurrent = array_filter(
                $arrUsers,
                function ($e) {
                    return $e->getId() !== $this->getUser()->getId();
                }
            );
        }

        return $this->renderForm('friends/index.html.twig', [
            'friendsRequestsOfCurrentUser' => $uniqueFriendsOfCurrentUser,
            'friendsRequestReceived' => $arrUserFriendsReceivedStatusSent ?? null,
            'currentUser' => $this->getUser(),
            'formSearch' => $formSearch,
            'arrUsers' => $arrUsersExceptCurrent ?? null,
            'usersAcceptedOrSent' => $usersAcceptedOrSent,
            'usersAccepted' => $usersAccepted,
        ]);
    }

    #[Route('/{id}/send', name: 'friends_sendRequest', methods: ['GET', 'POST'])]
    public function sendRequest(Request $request, UserRepository $userRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $friend = new Friends();
        $friend->setSenderUser($this->security->getUser());
        $friend->setStatus('sent');
        $friend->setReceiverUser($userRepository->findOneBy(['id' => $request->get('id')]));
        $entityManager->persist($friend);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Demande d\'ami envoyée!'
        );
        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }


    /*
     * @ParamConverter("id", class="Friends", options={"id": "id"})
     */
    #[Route('/{id}/accept', name: 'friends_accept', methods: ['GET', 'POST'])]
    public function friendsAccept(Friends $friends, FriendsRepository $friendsRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $friendRequest = $friendsRepository->findOneBy(['id' => $friends->getId()]);
        if ($friendRequest->getReceiverUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $friendRequest->setStatus('accepted');
        $entityManager->persist($friendRequest);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Demande d\'ami acceptée!'
        );
        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'friends_delete', methods: ['POST'])]
    public function delete(Request $request, Friends $friend): Response
    {
        if ($this->isCsrfTokenValid('delete' . $friend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friend);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Ami refusé!'
            );
        }
        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }
}
