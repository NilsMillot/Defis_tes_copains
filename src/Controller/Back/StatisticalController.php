<?php

namespace App\Controller\Back;

use App\Entity\Statistical;
use App\Form\StatisticalType;
use App\Repository\StatisticalRepository;
use App\Repository\CategoryRepository;
use App\Repository\ChallengesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/statistical')]
class StatisticalController extends AbstractController
{
    #[Route('/data/challenge', name: 'admin_statistical_data_challenge', methods: ['GET'])]
    public function dataChallenge( ChallengesRepository $challengesRepository): JsonResponse
    {

        // On va chercher le nombre de challenges par date
        $challenges = $challengesRepository->countByDate();
        $challengeDate = [];
        $challengesCount = [];

        foreach ($challenges as $challenge) {
            $challengeDate[] = $challenge['dateChallenge'];
            $challengesCount[] = $challenge['count'];
        }

        return new JsonResponse(
            [
                'challengeDate' => $challengeDate,
                'challengeCount' => $challengesCount
            ]
        );
    }

    #[Route('/challenge', name: 'admin_statistical_challenge', methods: ['GET'])]
    public function indexChallenge(ChallengesRepository $challengesRepository): Response
    {
        $challenges = $challengesRepository->findAll();
        $countLike = 0;
        foreach ($challenges as $challenge)
        {
            foreach ($challenge->getUserLikeChallenges() as $like){
                $countLike ++;
            }
        }

        return $this->render('back/statistical/challenges.html.twig', [
            'countLike' => $countLike,
            'challengeTotaux' => count($challenges),
            'title' => 'Statistique Challenge',
        ]);
    }

    #[Route('/data/category', name: 'admin_statistical_data_category', methods: ['GET'])]
    public function dataCategory(CategoryRepository $categoryRepository): JsonResponse
    {
        // On va chercher les données de la table category
        $category = $categoryRepository->findAll();

        // On démonte les données pour les afficher dans le tableau et les donners à chart.js
        $categoryNom = [];
        $categoryCount = [];
        foreach ($category as $cat) {
            $categoryNom[] = $cat->getName();
            $categoryCount[] = count($cat->getChallenges());
        }

        return new JsonResponse(
            [
                'categoryNom' => $categoryNom,
                'categoryCount' => $categoryCount,
            ]
        );
    }

    #[Route('/category', name: 'admin_statistical_category', methods: ['GET'])]
    public function indexCategory(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->render('back/statistical/category.html.twig', [
            'categoryTotaux' => count($category),
            'title' => 'Statistique Categories',
        ]);
    }

    #[Route('/data/user', name: 'admin_statistical_data_user', methods: ['GET'])]
    public function dataUser(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->countByDate();
        $usersPro = $userRepository->findBy(['pro'=>true]);
        $usersProFalse = $userRepository->findBy(['pro'=> false]);
        $userProNull = $userRepository->findBy(['pro'=> null]);
        $userDate = [];
        $userCount = [];

        foreach ($users as $user) {
            $userDate[] = $user['dateUser'];
            $userCount[] = $user['count'];
        }

        return new JsonResponse(
            [
                'userPro'=>count($usersPro),
                'userNonPro' => count($usersProFalse) + count($userProNull),
                'userDate' => $userDate,
                'userCount' => $userCount,
            ]
        );
    }

    #[Route('/user', name: 'admin_statistical_user', methods: ['GET'])]
    public function indexUser(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();

        return $this->render('back/statistical/user.html.twig', [
            'userTotaux' => count($user),
            'title' => 'Statistique User',
        ]);
    }



}
