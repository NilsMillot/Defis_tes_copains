<?php

namespace App\Controller\Back;

use App\Entity\Tags;
use App\Form\TagsNewsType;
use App\Repository\TagsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tags')]
class TagsController extends AbstractController
{
    #[Route('/', name: 'admin_tags_index', methods: ['GET'])]
    public function index(TagsRepository $tagsRepository): Response
    {
        return $this->render('back/tags/index.html.twig', [
            'tags' => $tagsRepository->findAll(),
            'title'=>'Tags'
        ]);
    }

    #[Route('/new', name: 'admin_tags_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TagsRepository $tagsRepository): Response
    {
        $tag = new Tags();
        $form = $this->createForm(TagsNewsType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagsRepository->add($tag, true);

            return $this->redirectToRoute('admin_tags_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tags/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'title'=>'Tags'
        ]);
    }

    #[Route('/{id}', name: 'admin_tags_show', methods: ['GET'])]
    public function show(Tags $tag): Response
    {
        return $this->render('back/tags/show.html.twig', [
            'tag' => $tag,
            'title'=>'Tags'
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_tags_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tags $tag, TagsRepository $tagsRepository): Response
    {
        $form = $this->createForm(TagsNewsType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagsRepository->add($tag, true);

            return $this->redirectToRoute('admin_tags_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/tags/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
            'title'=>'Tags'
        ]);
    }

    #[Route('/{id}', name: 'admin_tags_delete', methods: ['POST'])]
    public function delete(Request $request, Tags $tag, TagsRepository $tagsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $tagsRepository->remove($tag, true);
        }

        return $this->redirectToRoute('admin_tags_index', [], Response::HTTP_SEE_OTHER);
    }
}
