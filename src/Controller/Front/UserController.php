<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, FriendsRepository $friendsRepository): Response
    {
        $friendsSendedByCurrentUserStatusAccepted = $friendsRepository->findBy(['senderUser' => $this->getUser(), 'status' => 'accepted']);
        $friendsReceivedByCurrentUserStatusAccepted = $friendsRepository->findBy(['receiverUser' => $this->getUser(), 'status' => 'accepted']);
        $friendsOfCurrentUser = array_merge($friendsReceivedByCurrentUserStatusAccepted, $friendsSendedByCurrentUserStatusAccepted);
        $uniqueFriendsOfCurrentUser = array_unique($friendsOfCurrentUser);

        $userNames = explode(' ', $this->getUser()->getUsername());
        $userInitials = sizeof($userNames) === 1 ? $userNames[0][0] : $userNames[0][0] . $userNames[1][0];

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
            'userInitials' => strtoupper($userInitials),
            'numberOfFriends' => sizeof($uniqueFriendsOfCurrentUser),
            'numberOfChallengesCreated' => sizeof($this->getUser()->getChallenge()),
            'numberOfGroup' => sizeof($this->getUser()->getIdGroup()),
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
