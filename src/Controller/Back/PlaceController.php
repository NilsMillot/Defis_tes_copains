<?php

namespace App\Controller\Back;

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
        return $this->render('back/place/index.html.twig', [
            'places' => $placeRepository->findAll(),
        ]);
    }

    #[Route('/place/create', name: 'place_create')]
    public function create(Request $request): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();

            $this->addFlash('green', "Le lieu à bien été créé.");

            return $this->redirectToRoute('admin_place_index');
        }

        return $this->render('back/place/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/place/edit/{id}', name: 'place_edit')]
    public function edit(Place $place, Request $request): Response
    {
        $form = $this->createForm(PlaceType::class, $place);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('green', "Le lieu {$place->getName()} à bien été édité.");

            return $this->redirectToRoute('admin_place_show', [
                'id' => $place->getId()
            ]);
        }

        return $this->render('back/place/edit.html.twig', [
            'place' => $place,
            'form' => $form->createView()
        ]);
    }

    #[Route('/place/remove/{id}/{token}', name: 'place_remove')]
    public function remove(Place $place, $token): Response
    {
        if ($this->isCsrfTokenValid('remove_place', $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();

            $this->addFlash('green', "Le lieu {$place->getName()} à bien été suprprimé.");

            return $this->redirectToRoute('admin_place_index');
        }

        throw new Exception('Invalid token CSRF');
    }

    #[Route('/place/{id}', name: 'place_show', requirements: ['id' => '^\d*$'])]
    public function show(Place $place): Response
    {
        return $this->render('back/place/show.html.twig', [
            'place' => $place
        ]);
    }
}
