<?php
namespace App\Controller\Back;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as security;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }
    #[Route('/', name: 'admin_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('back/users/index.html.twig', [
            'users' => $userRepository->findAll(),
            'title' => 'Utilisateurs'
        ]);
    }

    #[Route('/new', name: 'admin_user_new', methods: ['GET','POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userNames = explode(' ', $form->getData()->getUsername());
            $userInitials = sizeof($userNames) === 1 ? $userNames[0][0] : $userNames[0][0] . $userNames[1][0];
            $user->setPassword($passwordHasher->hashPassword($user,$user->getPassword()));
            $user->setInitials($userInitials);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/users/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'title' => 'Utilisateurs'

        ]);
    }

    #[Route('/{id}', name: 'admin_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/users/show.html.twig', [
            'user' => $user,
            'title' => 'Utilisateurs'

        ]);
    }

    #[Route('/{id}/edit', name: 'admin_user_edit', methods: ['GET','POST'])]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form->get('roles')->getData();

            $data = array();

            foreach($roles as $role)
            {
                $data[] = $role;
            }

            $user->setRoles($data);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'title' => 'Utilisateurs'

        ]);
    }

    #[Route('/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setStatut(false);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    }

}