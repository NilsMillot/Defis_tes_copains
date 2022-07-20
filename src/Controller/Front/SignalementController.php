<?php

namespace App\Controller\Front;

use App\Entity\Signalement;
use App\Entity\Post;
use App\Entity\Remark;
use App\Form\SignalementType;
use App\Repository\SignalementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/signalement')]
class SignalementController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'signalement_index', methods: ['GET'])]
    public function index(SignalementRepository $signalementRepository): Response
    {
        return $this->render('signalement/index.html.twig', [
            'signalements' => $signalementRepository->findAll(),
        ]);
    }

    #[Route('/new/post/{id}', name: 'signalement_new_post', methods: ['GET', 'POST'])]
    public function newPostSignalement(Request $request,Post $post, SignalementRepository $signalementRepository): JsonResponse
    {
        $exist = $signalementRepository->findBy(['id_post'=>$post->getId(),'id_user_signalement'=>$this->security->getUser()]);
        if($exist){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exist[0]);
            $entityManager->flush();
        }else {
            $signalement = new Signalement();
            $entityManager = $this->getDoctrine()->getManager();
            $signalement->setIdUserSignalement($this->security->getUser());
            $signalement->setIdPost($post);
            $entityManager->persist($signalement);
            $entityManager->flush();
        }
        $id = $post->getId();
        return $this->json(['content'=>'OK', 'id'=>$id]);

    }

    #[Route('/new/remark/{id}', name: 'signalement_new_remark', methods: ['GET', 'POST'])]
    public function newRemakSignalement(Request $request,Remark $remark, SignalementRepository $signalementRepository): JsonResponse
    {
        $signalement = new Signalement();
        $entityManager = $this->getDoctrine()->getManager();
        $signalement->setIdUserSignalement($this->security->getUser());
        $signalement->setIdRemark($remark);
        $entityManager->persist($signalement);
        $entityManager->flush();

        return $this->json(['content'=>'OK']);

    }

    #[Route('/{id}', name: 'signalement_show', methods: ['GET'])]
    public function show(Signalement $signalement): Response
    {
        return $this->render('signalement/show.html.twig', [
            'signalement' => $signalement,
        ]);
    }

    #[Route('/{id}/edit', name: 'signalement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signalement $signalement, SignalementRepository $signalementRepository): Response
    {
        $form = $this->createForm(SignalementType::class, $signalement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signalementRepository->add($signalement, true);

            return $this->redirectToRoute('app_signalement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signalement/edit.html.twig', [
            'signalement' => $signalement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'signalement_delete', methods: ['POST'])]
    public function delete(Request $request, Signalement $signalement, SignalementRepository $signalementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signalement->getId(), $request->request->get('_token'))) {
            $signalementRepository->remove($signalement, true);
        }

        return $this->redirectToRoute('app_signalement_index', [], Response::HTTP_SEE_OTHER);
    }
}
