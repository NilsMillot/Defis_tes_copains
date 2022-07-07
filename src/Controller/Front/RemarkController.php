<?php

namespace App\Controller\Front;

use App\Entity\Challenges;
use App\Entity\Remark;
use App\Entity\UserLikeRemark;
use App\Form\RemarkType;
use App\Repository\RemarkRepository;
use App\Repository\UserLikeRemarkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/remark')]
class RemarkController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'remark_index', methods: ['GET'])]
    public function index(RemarkRepository $remarkRepository): Response
    {
        return $this->render('remark/index.html.twig', [
            'remarks' => $remarkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'remark_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $remark = new Remark();
        $form = $this->createForm(RemarkType::class, $remark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($remark);
            $entityManager->flush();

            return $this->redirectToRoute('remark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remark/new.html.twig', [
            'remark' => $remark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'remark_show', methods: ['GET'])]
    public function show(Remark $remark): Response
    {
        return $this->render('remark/show.html.twig', [
            'remark' => $remark,
        ]);
    }

    #[Route('/edit/{id}', name: 'remark_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Remark $remark): Response
    {
        $remark_user = $remark->getUserId();
        foreach ($remark_user->toArray() as $user)
        {
            if ($user !== $this->security->getUser()) {
                throw $this->createAccessDeniedException();
            }
        }
        $form = $this->createForm(RemarkType::class, $remark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('remark_index', [], Response::HTTP_SEE_OTHER);
        }
        $content_remark = $remark->getContentRemark();
        return $this->json(['content'=>$content_remark]);
    }


    #[Route('/like/{id}', name:'like_remark', methods: ['POST','GET'])]
    public function likeRemark(Request $request, Remark $remark, UserLikeRemarkRepository $userLikeRemarkRepository): Response
    {
        $exist = $userLikeRemarkRepository->findBy(['remarkId'=>$remark->getId(),'userId'=>$this->security->getUser()]);

        if($exist){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exist[0]);
            $entityManager->flush();
        }else{
            $userLikeRemark = new UserLikeRemark();
            $entityManager = $this->getDoctrine()->getManager();
            $userLikeRemark->setUserId($this->security->getUser());
            $userLikeRemark->setRemarkId($remark);
            $entityManager->persist($userLikeRemark);
            $entityManager->flush();
        }

        $id = $remark->getId();
        return new Response($id, 200, array('Content-Type' => 'text/html'));
    }

    #[Route('/{id}/{id_challenge}', name: 'remark_delete', methods: ['POST','GET'])]
    /**
     * @ParamConverter("challenge", options={"id" = "id_challenge"})
     **/
    public function delete(Request $request, Remark $remark, Challenges $challenge, RemarkRepository $remarkRepository,UserLikeRemarkRepository $userLikeRemarkRepository): Response
    {

        $remark_user = $remark->getUserId();
        foreach ($remark_user->toArray() as $user)
        {
            if ($user !== $this->security->getUser()) {
                throw $this->createAccessDeniedException();
            }
        }
        if ($this->isCsrfTokenValid('delete'.$remark->getId(), $request->request->get('_token'))) {
            $likes = $userLikeRemarkRepository->findBy(['remarkId'=>$remark->getId()]);

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($likes as $like ){
                $entityManager->remove($like);
            }
            $entityManager->remove($remark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenges_show', [
            'id'=>$challenge->getId(),
        ],
            Response::HTTP_SEE_OTHER);
    }


}
