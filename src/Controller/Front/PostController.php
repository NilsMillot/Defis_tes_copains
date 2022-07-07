<?php

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\UserLikePost;
use App\Entity\Challenges;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserLikePostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/edit/{id}', name: 'post_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): JsonResponse
    {
        $post_user = $post->getUserId();
        foreach ($post_user->toArray() as $user)
        {
            if ($user !== $this->security->getUser()) {
                throw $this->createAccessDeniedException();
            }
        }

        $formPost = $this->createForm(PostType::class, $post);
        $formPost->handleRequest($request);

        $challenge = $post->getChallengeId();
        if ($formPost->isSubmitted() && $formPost->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            $allPosts = $postRepository->findBy(['challengeId'=>$challenge->getId()]);
            return $this->redirectToRoute('challenges_show', [
                'id'=>$challenge->getId(),
                'posts'=>$allPosts,
            ],
            );
        }

        $name = $post->getName();
        $content = $post->getContent();
        $image = $post->getImageFile();
        return $this->json(['name'=>$name,'content'=>$content,'image'=>$image]);

    }



    #[Route('/like/{id}', name:'like_post', methods: ['POST','GET'])]
    public function likePost(Request $request, Post $post, UserLikePostRepository $userLikePostRepository): Response
    {
        $exist = $userLikePostRepository->findBy(['postLiked'=>$post->getId(),'userWhoLiked'=>$this->security->getUser()]);
        if($exist){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exist[0]);
            $entityManager->flush();
        }else{
            $userLikePost = new UserLikePost();
            $entityManager = $this->getDoctrine()->getManager();
            $userLikePost->setUserWhoLiked($this->security->getUser());
            $userLikePost->setPostLiked($post);
            $entityManager->persist($userLikePost);
            $entityManager->flush();
        }
        $id = $post->getId();
        return new Response($id, 200, array('Content-Type' => 'text/html'));
    }

    #[Route('/{id}/{id_challenge}', name: 'post_delete', methods: ['POST','GET'])]
    /**
     * @ParamConverter("challenge", options={"id" = "id_challenge"})
     **/
    public function delete(Request $request, Post $post,Challenges $challenge, PostRepository $postRepository,UserLikeRemarkRepository $userLikeRemarkRepository, UserLikePostRepository $userLikePostRepository,RemarkRepository $remarkRepository): Response
    {
        $post_user = $post->getUserId();
        foreach ($post_user->toArray() as $user)
        {
            if ($user !== $this->security->getUser()) {
                throw $this->createAccessDeniedException();
            }
        }
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

        $allPosts = $postRepository->findBy(['challengeId'=>$challenge->getId()]);
        return $this->redirectToRoute('challenges_show', [
            'id'=>$challenge->getId(),
            'posts'=>$allPosts,
        ],
            Response::HTTP_SEE_OTHER);
    }

}
