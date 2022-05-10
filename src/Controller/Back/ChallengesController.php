<?php
namespace App\Controller\Back;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security as security;
use App\Repository\ChallengesRepository;

class ChallengesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
    // Avoid calling getUser() in the constructor: auth may not
    // be complete yet. Instead, store the entire Security object.
    $this->security = $security;
    }


    #[Route('/admin/challenges', name: 'admin_challenges_index', methods: ['GET'])]
    public function index(ChallengesRepository $challengesRepository): Response
    {
        return $this->render('back/challenges/index.html.twig', [
            'challenges' => $challengesRepository->findAll(),
            'title' => 'Challenges'
        ]);
    }
}