<?php

namespace App\Controller\Back;

use App\Entity\Statistical;
use App\Form\StatisticalType;
use App\Repository\StatisticalRepository;
use App\Repository\CategoryRepository;
use App\Repository\ChallengesRepository;
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
//        $countLike = 0;
//        foreach ($challenges as $challenge)
//        {
//            foreach ($challenge->getUserLikeChallenges() as $like){
//                $countLike ++;
//            }
//        }

        return $this->render('back/statistical/category.html.twig', [
//            'countLike' => $countLike,
            'categoryTotaux' => count($category),
            'title' => 'Statistique Categories',
        ]);
    }



}
