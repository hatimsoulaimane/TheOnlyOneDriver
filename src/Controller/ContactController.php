<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            //à partir là pour envoyer le mail
            //dd($contact);
            $message = (new \Swift_Message('Nouveau Contact'))

                //On attribue l'expediteur
                ->setFrom($contact['email'])

                //On attribue le destinataire
                ->setTo('soulaiman.hatim@gmail.com')

                //On crée le message avec la vue
                ->setBody(
                    $this->renderView(
                    'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            //On envoie le message
            $mailer->send($message);

            $this->addFlash('message', 'Le message a bien été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
