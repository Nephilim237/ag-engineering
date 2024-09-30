<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($this->getParameter('contact_mail'))
                ->replyTo($form->getData()->getEmailSender())
                ->to($this->getParameter('contact_mail'))
                ->priority(Email::PRIORITY_HIGH)
                ->subject($form->getData()->getSubject())
                ->text($form->getData()->getMessage());

            $mailer->send($email);
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash('success', 'Votre message a bien été pris en compte, un de nos expert vous repondra tres bientot.');
            return $this->redirectToRoute('app_contact', ['_fragment' => 'contact-form']);
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
