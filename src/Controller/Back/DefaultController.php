<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ChallengesRepository;
use App\Repository\GroupRepository;
use App\Repository\PostRepository;
use App\Repository\RemarkRepository;

class DefaultController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(RemarkRepository $remarkRepository,PostRepository $postRepository, GroupRepository $groupRepository,UserRepository $userRepository,ChallengesRepository $challengesRepository): Response
    {
        $user = $userRepository->findAll();
        $userRecent = $userRepository->findRecentUser();
        $group = $groupRepository->findAll();
        $challenge = $challengesRepository->findAll();
        $challengeRecent = $challengesRepository->findRecentChallenge();
        $post = $postRepository->findAll();
        $remark = $remarkRepository->findAll();

        return $this->render('back/default/index.html.twig', [
            'controller_name' => 'DefaultControllerADMIN',
            'userTotaux'=> count($user),
            'userRecent'=> $userRecent[0],
            'challengeTotaux' => count($challenge),
            'challengeRecent' => $challengeRecent[0],
            'groupTotaux'=> count($group),
            'postTotaux'=>count($post),
            'remarkTotaux'=>count($remark),
            'title'=>'Home'
        ]);
    }
}
