<?php

namespace App\Controller\Back;

use App\Entity\Signalement;
use App\Entity\Post;
use App\Entity\Remark;
use App\Form\SignalementType;
use App\Repository\SignalementRepository;
use App\Repository\PostRepository;
use App\Repository\RemarkRepository;
use App\Repository\UserLikePostRepository;
use App\Repository\UserLikeRemarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;

#[Route('/admin/signalement')]
class SignalementController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    #[Route('/', name: 'admin_signalement_index', methods: ['GET'])]
    public function index(SignalementRepository $signalementRepository): Response
    {
        return $this->render('back/signalement/index.html.twig', [
            'signalements' => $signalementRepository->findAll(),
            'title' => 'Signalement'
        ]);
    }


    #[Route('/{id}', name: 'admin_signalement_delete', methods: ['POST'])]
    public function delete(Request $request, Signalement $signalement, UserLikeRemarkRepository $userLikeRemarkRepository, UserLikePostRepository $userLikePostRepository, SignalementRepository $signalementRepository, RemarkRepository $remarkRepository, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $signalement->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();

            if ($signalement->getIdPost()) {
                $posts = $postRepository->findBy(['id' => $signalement->getIdPost()]);
                foreach ($posts as $post) {
                    $likes = $userLikePostRepository->findBy(['postLiked' => $post->getId()]);
                    $remarks = $remarkRepository->findBy(['post' => $post->getId()]);
                    foreach ($remarks as $remark) {
                        $likes = $userLikeRemarkRepository->findBy(['remarkId' => $remark->getId()]);
                        $signalements_remark = $signalementRepository->findBy(['id_remark'=>$remark->getId()]) ;
                        foreach ($likes as $like) {
                            $entityManager->remove($like);
                        }
                        foreach ($signalements_remark as $signalement_remark){
                            $entityManager->remove($signalement_remark);
                        }
                        $entityManager->remove($signalement);
                        $entityManager->remove($remark);
                    }
                    foreach ($likes as $like) {
                        $entityManager->remove($like);
                    }
                    $entityManager->remove($signalement);
                    $entityManager->remove($post);
                }
            } elseif ($signalement->getIdRemark()) {
                $remarks = $remarkRepository->findBy(['id' => $signalement->getIdRemark()]);
                foreach ($remarks as $remark) {
                    $likes = $userLikeRemarkRepository->findBy(['remarkId' => $remark->getId()]);

                    foreach ($likes as $like) {
                        $entityManager->remove($like);
                    }
                    $entityManager->remove($signalement);
                    $entityManager->remove($remark);

                }
            }

            $entityManager->flush();

        }

        return $this->redirectToRoute('admin_signalement_index', [], Response::HTTP_SEE_OTHER);
    }

}