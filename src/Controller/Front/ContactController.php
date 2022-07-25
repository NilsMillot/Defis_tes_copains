<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_page', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('esgicommunityapp@gmail.com')
                ->subject('Nouveau message de ' . $contactFormData['nom'])
                ->text(
                    'Sender : ' . $contactFormData['email'] . \PHP_EOL .
                        $contactFormData['message'],
                    'text/plain'
                );

            $mailer->send($email);

            $this->addFlash('success', 'Vore message a été envoyé');

            return $this->redirectToRoute('contact_page');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
