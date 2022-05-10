<?php

namespace App\Controller\Front;

use App\Entity\Remark;
use App\Entity\UserLikeRemark;
use App\Form\RemarkType;
use App\Repository\RemarkRepository;
use App\Repository\UserLikeRemarkRepository;
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

    #[Route('/{id}/edit', name: 'remark_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Remark $remark): Response
    {
        $form = $this->createForm(RemarkType::class, $remark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('remark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remark/edit.html.twig', [
            'remark' => $remark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'remark_delete', methods: ['POST'])]
    public function delete(Request $request, Remark $remark): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remark->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($remark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('remark_index', [], Response::HTTP_SEE_OTHER);
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


}
