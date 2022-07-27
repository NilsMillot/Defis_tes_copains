<?php

namespace App\Controller\Front;

use App\Entity\Group;
use App\Entity\Challenges;
use App\Entity\FriendsSearch;

use App\Form\FriendsSearchType;
use App\Form\GroupType;

use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use App\Repository\FriendsRepository;
use App\Repository\ChallengesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/group')]
class GroupController extends AbstractController
{
    #[Route('/', name: 'group_index', methods: ['GET'])]
    public function index(GroupRepository $groupRepository): Response
    {
        return $this->render('group/index.html.twig', [
            'groups' => $groupRepository->findAll(),
            'username' => $this->getUser()->getUsername(),
            'userGroup'=> $this->getUser()->getIdGroup(),
            'pro'=> $this->getUser()->getPro(),

        ]);
    }

    #[Route('/error', name: 'group_error', methods: ['GET'])]
    public function error(GroupRepository $groupRepository): Response
    {
        return $this->render('group/error.html.twig', [
            'groups' => $groupRepository->findAll(),
            'username' => $this->getUser()->getUsername(),
            'userGroup'=> $this->getUser()->getIdGroup(),
            'pro'=> $this->getUser()->getPro(),

        ]);
    }

    #[Route('/new', name: 'group_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, FriendsRepository $friendsRepository,): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        $group->setNumberUser(sizeOf($group->getUsers()));

        $search = new FriendsSearch();
        $formSearch = $this->createForm(FriendsSearchType::class, $search);
        $formSearch->handleRequest($request);

        $friendsAcceptedOrSentSendedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted', 'sent'], 'senderUser' => $this->getUser()]);
        $friendsAcceptedOrSentReceivedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted', 'sent'], 'receiverUser' => $this->getUser()]);
        $friendsAcceptedSendedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted'], 'senderUser' => $this->getUser()]);
        $friendsAcceptedReceivedByCurrentUser = $friendsRepository->findBy(['status' => ['accepted'], 'receiverUser' => $this->getUser()]);

        $friendsSendedByCurrentUserStatusSent = $friendsRepository->findBy(['senderUser' => $this->getUser(), 'status' => 'sent']);
        $friendsReceivedByCurrentUserStatusSent = $friendsRepository->findBy(['receiverUser' => $this->getUser(), 'status' => 'sent']);
        $friendsOfCurrentUserStatusSent = array_merge($friendsSendedByCurrentUserStatusSent, $friendsReceivedByCurrentUserStatusSent);
        $uniqueFriendsOfCurrentUserStatusSent = array_unique($friendsOfCurrentUserStatusSent);

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

        if ($formSearch->isSubmitted() && $formSearch->isValid() && $formSearch->getData()->getName() != null) {
            $arrUsers = $userRepository->findUsers($formSearch->getData()->getName());
            $arrUsersExceptCurrent = array_filter(
                $arrUsers,
                function ($e) {
                    return $e->getId() !== $this->getUser()->getId();
                }
            );
            $usrsAccpted = [];
            for ($i = 0; $i < sizeof($usersAccepted); $i++) {
                $usrsAccpted[$i] = $usersAccepted[$i][1];
            }
            $intersectSearchAndUsersAccepted = array_intersect($arrUsersExceptCurrent, $usrsAccpted);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if($group->getNumberUser() > 3 && !$this->getUser()->isSubscribed()){
                return $this->redirectToRoute('group_error', [], Response::HTTP_SEE_OTHER);
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($group);
                $entityManager->flush();

                $nameOfGroup = $group->getName();
                $this->addFlash(
                    'notice',
                    'Groupe "' . $nameOfGroup .  '" crée!'
                );
                return $this->redirectToRoute('group_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->renderForm('group/new.html.twig', [
            'group' => $group,
            'form' => $form,

            'friendsRequestsOfCurrentUserStatusSent' => $uniqueFriendsOfCurrentUserStatusSent,
            'usersAccepted' => $usersAccepted,
            'usersAcceptedOrSent' => $usersAcceptedOrSent,
            'formSearch' => $formSearch,
            'arrUsers' => $arrUsersExceptCurrent ?? null,
            'intersectSearchAndUsersAccepted' => $intersectSearchAndUsersAccepted ?? null,

        ]);
    }

    #[Route('/{id}', name: 'group_show', methods: ['GET'])]
    public function show(Group $group, ChallengesRepository $challengeRepository): Response
    {
        $group_chal = $challengeRepository->findBy(['groupId'=>$group->getId()]);
        return $this->render('group/show.html.twig', [
            'group' => $group,
            'group_chal' => $group_chal
        ]);
    }

    #[Route('/{id}/edit', name: 'group_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Group $group): Response
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $nameOfGroup = $group->getName();
            $this->addFlash(
                'notice',
                '"' . "$nameOfGroup" . '" modifié!'
            );

            return $this->redirectToRoute('group_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('group/edit.html.twig', [
            'group' => $group,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'group_delete', methods: ['POST'])]
    public function delete(Request $request, Group $group): Response
    {
        if ($this->isCsrfTokenValid('delete' . $group->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($group);
            $entityManager->flush();
            $nameOfGroup = $group->getName();
            $this->addFlash(
                'warning',
                'Groupe "' . "$nameOfGroup" . '" supprimé!'
            );
        }

        return $this->redirectToRoute('group_index', [], Response::HTTP_SEE_OTHER);
    }
}
