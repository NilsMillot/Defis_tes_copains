<?php

namespace App\Controller\Front;

use App\Entity\Challenges;
use App\Entity\ChallengesUserRegister;
use App\Entity\Post;
use App\Entity\Remark;
use App\Entity\User;
use App\Form\ChallengesType;
use App\Form\PostType;
use App\Form\RemarkType;
use App\Repository\ChallengesRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\UserLikePostRepository;
use App\Repository\ChallengesUserRegisterRepository;
use App\Services\QrCodeService;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

#[Route('/challenges')]
class ChallengesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'challenges_index', methods: ['GET'])]
    public function index(ChallengesRepository $challengesRepository): Response
    {

        return $this->render('challenges/index.html.twig', [
            'challenges' => $challengesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'challenges_new', methods: ['GET','POST'])]
    public function new(Request $request, QrCodeService $qrCodeService, ChallengesRepository $challengesRepository): Response
    {

        $qrCode = null;
        $challenge = new Challenges();
        $form = $this->createForm(ChallengesType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $challenge->setCreationDate(new \DateTime());
            $challenge->addUser($this->security->getUser());

            $lastChallenge = $challengesRepository->findOneBy([], ['id' => 'desc']);
            if ($lastChallenge === null) {
                $futurId = 1;
            } else {
                $lastId = $lastChallenge->getId();
                $futurId = $lastId + 1;
            }
            $qrCode = $qrCodeService->qrcode($futurId);

            $challenge->setQrCode($qrCode);

            $entityManager->persist($challenge);
            $entityManager->flush();


            return $this->redirectToRoute('challenges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('challenges/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form,
        ]);
    }

    #[Route('/register/{id}', name: 'challenges_register', methods: ['GET','POST'])]
    public function register(Challenges $challenge){
        $challengeRegister = new ChallengesUserRegister();
        $entityManager = $this->getDoctrine()->getManager();
        $challengeRegister->setUserRegister($this->security->getUser());
        $challengeRegister->setChallengeRegister($challenge);
        $entityManager->persist($challengeRegister);
        $entityManager->flush();

        return $this->redirectToRoute('challenges_show', ['id'=>$challenge->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/register/delete/{id}', name: 'challenges_delete_register', methods: ['GET','POST'])]
    public function registerDelete(Challenges $challenge,ChallengesUserRegisterRepository $challengesUserRegisterRepository){
        $challengeRegister = $challengesUserRegisterRepository->findBy(['userRegister'=>$this->security->getUser(),'challengeRegister'=>$challenge->getId()]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($challengeRegister[0]);
        $entityManager->flush();

        return $this->redirectToRoute('challenges_show', ['id'=>$challenge->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'challenges_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Challenges $challenge, PostRepository $postRepository, UserLikePostRepository $userLikePostRepository): Response
    {
        $allPosts = $postRepository->findBy(['challengeId'=>$challenge->getId()]);
        $post = new Post();
        $formPost = $this->createForm(PostType::class, $post);
        $remark = new Remark();
        $formRemark = $this->createForm(RemarkType::class, $remark);

        $formPost->handleRequest($request);
        if($formPost->isSubmitted() && $formPost->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $post->addUserId($this->security->getUser());
            $post->setChallengeId($challenge);
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('challenges_show', [
                'id'=>$challenge->getId(),
                'posts'=>$allPosts,
                ],
                Response::HTTP_SEE_OTHER);
        }

        $formRemark->handleRequest($request);
        if($formRemark->isSubmitted() && $formRemark->isValid()){
            $post = $postRepository->findOneBy(['id'=>$_POST['post-id']]);
            $entityManager = $this->getDoctrine()->getManager();
            $remark->addUserId($this->security->getUser());
            $remark->setPost($post);
            $entityManager->persist($remark);
            $entityManager->flush();
            return $this->redirectToRoute('challenges_show', [
                'id'=>$challenge->getId(),
                'posts'=>$allPosts,
            ],
                Response::HTTP_SEE_OTHER);

        }
        
        return $this->render('challenges/show.html.twig', [
            'challenge' => $challenge,
            'posts'=>$allPosts,
            'formPost' => $formPost->createView(),
            'formRemark' => $formRemark->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'challenges_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Challenges $challenge): Response
    {
        $form = $this->createForm(ChallengesType::class, $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('challenges_show', ['id'=>$challenge->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('challenges/edit.html.twig', [
            'challenge' => $challenge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'challenges_delete', methods: ['POST'])]
    public function delete(Request $request, Challenges $challenge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$challenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenges_index', [], Response::HTTP_SEE_OTHER);
    }
}
