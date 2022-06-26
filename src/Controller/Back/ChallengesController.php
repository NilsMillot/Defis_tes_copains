<?php
namespace App\Controller\Back;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security as security;
use App\Repository\ChallengesRepository;
use App\Entity\Challenges;
use App\Form\ChallengesType;
use App\Repository\PostRepository;
use App\Repository\UserLikeChallengeRepository;
use App\Repository\ChallengesUserRegisterRepository;
use App\Services\QrCodeService;

#[Route('/admin/challenges')]
class ChallengesController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
    // Avoid calling getUser() in the constructor: auth may not
    // be complete yet. Instead, store the entire Security object.
    $this->security = $security;
    }


    #[Route('/', name: 'admin_challenges_index', methods: ['GET'])]
    public function index(ChallengesRepository $challengesRepository): Response
    {
        return $this->render('back/challenges/index.html.twig', [
            'challenges' => $challengesRepository->findAll(),
            'title' => 'Challenges'
        ]);
    }

    #[Route('/new', name: 'admin_challenges_new', methods: ['GET','POST'])]
    public function new(Request $request,QrCodeService $qrCodeService, ChallengesRepository $challengesRepository): Response
    {
        $qrCode = null;
        $challenges = new Challenges();
        $form = $this->createForm(ChallengesType::class, $challenges);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $challenges->setCreationDate(new \DateTime());
            $challenges->addUser($this->security->getUser());
            foreach($form["tags"]->getData() as $tag) {
                $challenges->addTag($tag);
            }
            $lastChallenge = $challengesRepository->findOneBy([], ['id' => 'desc']);
            if ($lastChallenge === null) {
                $futurId = 1;
            } else {
                $lastId = $lastChallenge->getId();
                $futurId = $lastId + 1;
            }

            $qrCode = $qrCodeService->qrcode($futurId);

            $challenges->setQrCode($qrCode);

            $entityManager->persist($challenges);
            $entityManager->flush();

            return $this->redirectToRoute('admin_challenges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/challenges/new.html.twig', [
            'challenges' => $challenges,
            'form' => $form,
            'title' => 'Challenges'

        ]);
    }


    #[Route('/{id}/edit', name: 'admin_challenges_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Challenges $challenges): Response
    {
        $form = $this->createForm(ChallengesType::class, $challenges);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_challenges_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/challenges/edit.html.twig', [
            'offer' => $challenges,
            'form' => $form,
            'title' => 'Challenges'

        ]);
    }


    #[Route('/{id}/delete', name: 'admin_challenges_delete', methods: ['POST','GET'])]
    public function delete(Request $request, Challenges $challenge,UserLikeChallengeRepository $userLikeChallengeRepository, PostRepository $postRepository, ChallengesUserRegisterRepository $challengesUserRegisterRepository): Response
    {

        $challenge_user = $challenge->getUsers();
        foreach ($challenge_user->toArray() as $user)
        {
            if ($user !== $this->security->getUser() && !(in_array('ROLE_ADMIN',$this->security->getUser()->getRoles()))  ) {
                throw $this->createAccessDeniedException();
            }
        }

        if ($this->isCsrfTokenValid('delete'.$challenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $posts = $postRepository->findBy(['challengeId'=>$challenge->getId()]);
            $challenge_user_registers = $challengesUserRegisterRepository->findBy(['challengeRegister'=>$challenge->getId()]);
            $user_like_challenges = $userLikeChallengeRepository->findBy(['challengesLiked'=>$challenge->getId()]);

            foreach ($posts as $post){
                $entityManager->remove($post);
            }
            foreach ($challenge_user_registers as $challenge_user_register){
                $entityManager->remove($challenge_user_register);
            }
            foreach ($user_like_challenges as $user_like_challenge) {
                $entityManager->remove($user_like_challenge);
            }
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_challenges_index', [], Response::HTTP_SEE_OTHER);
    }
}