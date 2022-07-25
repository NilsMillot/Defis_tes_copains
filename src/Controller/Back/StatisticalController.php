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
    #[Route('/data', name: 'admin_statistical_data', methods: ['GET'])]
    public function data(CategoryRepository $categoryRepository, ChallengesRepository $challengesRepository): JsonResponse
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
                'categoryNom' => $categoryNom,
                'categoryCount' => $categoryCount,
                'challengeDate' => $challengeDate,
                'challengeCount' => $challengesCount
            ]
        );

    }

    #[Route('/', name: 'admin_statistical_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('back/statistical/index.html.twig', [
            'title' => 'statistique',
        ]);
    }

}
