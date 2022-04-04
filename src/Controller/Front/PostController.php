<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\UserLikePost;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserLikePostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;


#[Route('/post')]
class PostController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'post_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'post_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/like/{id}', name:'like_post', methods: ['POST','GET'])]
    public function likePost(Request $request, Post $post): Response
    {
        $userLikePost = new UserLikePost();
        $entityManager = $this->getDoctrine()->getManager();
        $userLikePost->setUserWhoLiked($this->security->getUser());
        $userLikePost->setPostLiked($post);
        $entityManager->persist($userLikePost);
        $entityManager->flush();
        $id = $post->getId();
        return new Response($id, 200, array('Content-Type' => 'text/html'));
    }

    #[Route('/unlike/{id}', name:'unlike_post', methods: ['POST','GET'])]
    public function unlikePost(Request $request, Post $post, UserLikePostRepository $userLikePostRepository): Response
    {
        $userLikePost = $userLikePostRepository->findBy(['postLiked'=>$post->getId(),'userWhoLiked'=>$this->security->getUser()]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($userLikePost[0]);
        $entityManager->flush();
        $id = $post->getId();
        return new Response($id, 200, array('Content-Type' => 'text/html'));

    }
}
