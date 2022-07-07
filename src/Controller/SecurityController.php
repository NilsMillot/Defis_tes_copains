<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\FacebookAuthenticator;
use Doctrine\ORM\EntityManager;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/connect/facebook', name: 'connect_facebook_start', methods: ['GET'])]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook')
            ->redirect([
                'public_profile', 'email'
            ]);
    }

    #[Route('/connect/facebook/check', name: 'connect_facebook_check', methods: ['GET'])]
    public function connectCheckAction(Request $request)
    {
        $response = new Response();
        return $response;
    }

    #[Route('/connect/google', name: 'connect_google_start', methods: ['GET'])]
    public function connectGoogleAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'email'
            ]);
    }

    #[Route('/connect/google/check', name: 'connect_google_check', methods: ['GET'])]
    public function connectGoogleCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        $response = new Response();
        return $response;
    }


    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_USER"]);
            $user->setStatut(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('front_default', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('security/register.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
