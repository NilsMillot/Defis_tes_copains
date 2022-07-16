<?php

namespace App\Controller\Back;

use App\Entity\Post;
use App\Entity\UserLikePost;
use App\Entity\Challenges;
use App\Form\PostType;
use App\Form\PostBackType;
use App\Repository\PostRepository;
use App\Repository\UserLikePostRepository;
use App\Repository\RemarkRepository;
use App\Repository\UserLikeRemarkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;


#[Route('/admin/post')]
class PostController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'admin_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('back/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'title' => 'Post'
        ]);
    }

    #[Route('/new', name: 'admin_post_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostBackType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $post->addUserId($this->security->getUser());
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/new.html.twig', [
            'post' => $post,
            'formPost' => $form,
            'title' => 'Post'

        ]);
    }


    #[Route('/edit/{id}', name: 'admin_post_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {

        $formPost = $this->createForm(PostType::class, $post);
        $formPost->handleRequest($request);

        if ($formPost->isSubmitted() && $formPost->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/post/edit.html.twig', [
            'post' => $post,
            'formPost' => $formPost,
            'title' => 'Post'
        ]);

    }


    #[Route('/{id}', name: 'admin_post_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository,UserLikeRemarkRepository $userLikeRemarkRepository, UserLikePostRepository $userLikePostRepository,RemarkRepository $remarkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $likes = $userLikePostRepository->findBy(['postLiked'=>$post->getId()]);
            $remarks = $remarkRepository->findBy(['post'=>$post->getId()]);
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($remarks as $remark ){
                $likeRemarks = $userLikeRemarkRepository->findBy(['remarkId'=>$remark->getId()]);
                foreach ($likeRemarks as $likeRemark ){
                    $entityManager->remove($likeRemark);
                }
                $entityManager->remove($remark);
            }
            foreach ($likes as $like ){
                $entityManager->remove($like);
            }
            $entityManager->remove($post);
            $entityManager->flush();
        }


        return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
    }

}
