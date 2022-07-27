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

        if ($form->isSubmitted() && $form->isValid()) {
            if($group->getNumberUser() > 7 && !$this->getUser()->isSubscribed()){
                return $this->redirectToRoute('group_error', [], Response::HTTP_SEE_OTHER);
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($group);
                $entityManager->flush();

                $nameOfGroup = $group->getName();
                if (in_array($this->getUser()->getUsername(), (array)$group->getUsers()))
                    $this->addFlash(
                        'notice',
                        'Non non nooon !! Ne créez pas de groupe sans vous inclure'
                    );
                else
                $this->addFlash(
                    'notice',
                    'Groupe "' . $nameOfGroup .  '" créé !'
                );
                return $this->redirectToRoute('group_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->renderForm('group/new.html.twig', [
            'group' => $group,
            'form' => $form,
            'actualUser' => $this->getUser()->getUsername(),
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
