<?php

namespace App\Controller\Front;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    #[Route('/place', name: 'place_index', methods: ['GET'])]
    public function index(PlaceRepository $placeRepository): Response
    {
        return $this->render('front/place/index.html.twig', [
            'places' => $placeRepository->findAll(),
        ]);
    }

    #[Route('/place/{id}', name: 'place_show', requirements: ['id' => '^\d*$'])]
    public function show(Place $place): Response
    {
        return $this->render('front/place/show.html.twig', [
            'place' => $place
        ]);
    }
}
