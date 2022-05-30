<?php

namespace App\Controller\Front;

use App\Entity\Friends;
use App\Entity\FriendsSearch;
use App\Entity\User;
use App\Form\FriendsType;
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
        $friendsSendedByCurrentUser = $friendsRepository->findBy(['senderUser' => $this->getUser()]);
        $friendsReceivedByCurrentUser = $friendsRepository->findBy(['receiverUser' => $this->getUser()]);
        $friendsReceivedByCurrentUserStatusSent = $friendsRepository->findBy(['receiverUser' => $this->getUser(), 'status' => 'sent']);
        $friendsOfCurrentUser = array_merge($friendsSendedByCurrentUser, $friendsReceivedByCurrentUser);
        $uniqueFriendsOfCurrentUser = array_unique($friendsOfCurrentUser);

        $arrUserFriendsReceivedStatusSent = [];
        for ($i = 0; $i < sizeof($friendsReceivedByCurrentUserStatusSent); $i++) {
            array_push($arrUserFriendsReceivedStatusSent, $userRepository->findOneBy(['id' => $friendsReceivedByCurrentUserStatusSent[$i]->getSenderUser()->getId()]));
        }
        return $this->render('friends/index.html.twig', [
            'friendsRequestsOfCurrentUser' => $uniqueFriendsOfCurrentUser,
            'friendsRequestReceived' => $arrUserFriendsReceivedStatusSent ?? null,
            'currentUser' => $this->getUser(),
        ]);
    }

    #[Route('/new', name: 'friends_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FriendsRepository $friendsRepository): Response
    {
        $friend = new Friends();
        $form = $this->createForm(FriendsType::class, $friend);
        $form->handleRequest($request);

        $friendsAcceptedSendedByCurrentUser = $friendsRepository->findBy(['status' => 'accepted', 'senderUser' => $this->getUser()]);
        $friendsAcceptedReceivedByCurrentUser = $friendsRepository->findBy(['status' => 'accepted', 'receiverUser' => $this->getUser()]);
        $friendsAcceptedByCurrentUser = array_merge($friendsAcceptedReceivedByCurrentUser, $friendsAcceptedSendedByCurrentUser);

        $allUsers = $this->getDoctrine()->getRepository(User::class)->findAll();
        $allUsersExceptCurrent = array_filter(
            $allUsers,
            function ($e) {
                return $e->getId() !== $this->getUser()->getId();
            }
        );

        $search = new FriendsSearch();
        $formSearch = $this->createForm(FriendsSearchType::class, $search);
        $formSearch->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $friend->setSenderUser($this->security->getUser());
            $friend->setStatus('sent');

            $entityManager->persist($friend);
            $entityManager->flush();

            return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('friends/new.html.twig', [
            'form' => $form,
            'formSearch' => $formSearch,
            'allUsers' => $allUsersExceptCurrent,
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

        if ($friendRequest->getReceiverUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $friendRequest->setStatus('accepted');
        $entityManager->persist($friendRequest);
        $entityManager->flush();
        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'friends_delete', methods: ['POST'])]
    public function delete(Request $request, Friends $friend): Response
    {
        if ($this->isCsrfTokenValid('delete' . $friend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($friend);
            $entityManager->flush();
        }

        return $this->redirectToRoute('friends_index', [], Response::HTTP_SEE_OTHER);
    }
}
