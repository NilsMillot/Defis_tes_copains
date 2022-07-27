<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use App\Form\UserAvatarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/user')]
class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'user_index', methods: ['GET', 'POST'])]
    public function index(Request $request, UserRepository $userRepository, FriendsRepository $friendsRepository): Response
    {
        $friendsSendedByCurrentUserStatusAccepted = $friendsRepository->findBy(['senderUser' => $this->getUser(), 'status' => 'accepted']);
        $friendsReceivedByCurrentUserStatusAccepted = $friendsRepository->findBy(['receiverUser' => $this->getUser(), 'status' => 'accepted']);
        $friendsOfCurrentUser = array_merge($friendsReceivedByCurrentUserStatusAccepted, $friendsSendedByCurrentUserStatusAccepted);
        $uniqueFriendsOfCurrentUser = array_unique($friendsOfCurrentUser);

        $userNames = explode(' ', $this->getUser()->getUsername());
        $userInitials = sizeof($userNames) === 1 ? $userNames[0][0] : $userNames[0][0] . $userNames[1][0];

        $currentAvatar = $this->getUser()->getImageName();

        // change avatar
        $formAvatar = $this->createForm(UserAvatarType::class, $this->getUser());
        $formAvatar->handleRequest($request);

        if ($formAvatar->isSubmitted() && $formAvatar->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($formAvatar->getData());
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
            'userInitials' => strtoupper($userInitials),
            'numberOfFriends' => sizeof($uniqueFriendsOfCurrentUser),
            'numberOfChallengesCreated' => sizeof($this->getUser()->getChallenge()),
            'numberOfGroup' => sizeof($this->getUser()->getIdGroup()),
            'formAvatar' => $formAvatar->createView(),
            'currentAvatar' => $currentAvatar,
        ]);
    }

    #[Route('/post_pp', name: 'user_post_pp', methods: ['POST', 'GET'])]
    public function post_pp(Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser()->getId());
        dump($user);
        dump($request);
        $user->setImageName($request->get('pp'));
        // $this->security->getUser()->setImageName($request->get('pp'));
        // dump('post_pp');
        // return $request;
        // return $this->render('user/index.html.twig');
        // return new Response($request->get('pp'), 200, array('Content-Type' => 'multipart/form-data'));
        return new Response('', 200, array('Content-Type' => 'text/html'));
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
