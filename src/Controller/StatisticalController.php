<?php

namespace App\Controller;

use App\Entity\Statistical;
use App\Form\StatisticalType;
use App\Repository\StatisticalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistical')]
class StatisticalController extends AbstractController
{
    #[Route('/', name: 'statistical_index', methods: ['GET'])]
    public function index(StatisticalRepository $statisticalRepository): Response
    {
        return $this->render('statistical/index.html.twig', [
            'statisticals' => $statisticalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'statistical_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $statistical = new Statistical();
        $form = $this->createForm(StatisticalType::class, $statistical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($statistical);
            $entityManager->flush();

            return $this->redirectToRoute('statistical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statistical/new.html.twig', [
            'statistical' => $statistical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'statistical_show', methods: ['GET'])]
    public function show(Statistical $statistical): Response
    {
        return $this->render('statistical/show.html.twig', [
            'statistical' => $statistical,
        ]);
    }

    #[Route('/{id}/edit', name: 'statistical_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Statistical $statistical): Response
    {
        $form = $this->createForm(StatisticalType::class, $statistical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('statistical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('statistical/edit.html.twig', [
            'statistical' => $statistical,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'statistical_delete', methods: ['POST'])]
    public function delete(Request $request, Statistical $statistical): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statistical->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($statistical);
            $entityManager->flush();
        }

        return $this->redirectToRoute('statistical_index', [], Response::HTTP_SEE_OTHER);
    }
}
