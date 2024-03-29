<?php

namespace App\Controller\Back;

use App\Entity\Challenges;
use App\Entity\Remark;
use App\Entity\Post;
use App\Entity\UserLikeRemark;
use App\Form\RemarkType;
use App\Form\RemarkBackType;
use App\Repository\RemarkRepository;
use App\Repository\PostRepository;
use App\Repository\UserLikeRemarkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/admin/remark')]
class RemarkController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'admin_remark_index', methods: ['GET'])]
    public function index(RemarkRepository $remarkRepository): Response
    {
        return $this->render('back/remark/index.html.twig', [
            'remarks' => $remarkRepository->findAll(),
            'title'=>'Commentaires'
        ]);
    }

    #[Route('/new', name: 'admin_remark_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $remark = new Remark();
        $formRemark = $this->createForm(RemarkBackType::class, $remark);
        $formRemark->handleRequest($request);

        if ($formRemark->isSubmitted() && $formRemark->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $remark->addUserId($this->security->getUser());
            $entityManager->persist($remark);
            $entityManager->flush();

            return $this->redirectToRoute('admin_remark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/remark/new.html.twig', [
            'remark' => $remark,
            'formRemark' => $formRemark,
            'title'=>'Commentaires'

        ]);
    }

    #[Route('/find/post/{id}', name: 'admin_remark_to_challenge', methods: ['GET','POST'])]
    public function selectChallengeByPost(Request $request,Post $post, PostRepository $postRepository): JsonResponse
    {

        $posts = $postRepository->findOneBy(['id'=>$post->getId()]);

        $challenge = $posts->getChallengeId()->getName();
        return $this->json(['challenge'=>$challenge]);


    }

    #[Route('/{id}', name: 'admin_remark_show', methods: ['GET'])]
    public function show(Remark $remark): Response
    {
        return $this->render('back/remark/show.html.twig', [
            'remark' => $remark,
            'title'=>'Commentaires'

        ]);
    }

    #[Route('/edit/{id}', name: 'admin_remark_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Remark $remark): Response
    {

        $formRemark = $this->createForm(RemarkType::class, $remark);
        $formRemark->handleRequest($request);

        if ($formRemark->isSubmitted() && $formRemark->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_remark_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('back/remark/edit.html.twig', [
            'remark' => $remark,
            'formRemark' => $formRemark,
            'title'=>'Commentaires'
        ]);
    }

    #[Route('/{id}', name: 'admin_remark_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Remark $remark,  RemarkRepository $remarkRepository,UserLikeRemarkRepository $userLikeRemarkRepository): Response
    {

        if ($this->isCsrfTokenValid('delete'.$remark->getId(), $request->request->get('_token'))) {
            $likes = $userLikeRemarkRepository->findBy(['remarkId'=>$remark->getId()]);

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($likes as $like ){
                $entityManager->remove($like);
            }
            $entityManager->remove($remark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_remark_index', [], Response::HTTP_SEE_OTHER);

    }


}
