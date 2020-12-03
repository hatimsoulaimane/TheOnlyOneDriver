<?php

namespace App\Notifications;

// On importe les classes nécessaires à l'envoi d'email et à twig
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CreationCompteNotification
{
    /**
     * Propriété contenant le module d'envoi de mails
     *
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * Propriété contenant l'environnement Twig
     *
     * @var Environment
     */
    private $renderer;

    /**
     * CreationCompteNotification constructor.
     * @param Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    /**
     * Méthode de notification (envoi de mail)
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @return void
     */
    public function notify()
    {
        // On construit le mail
        $message = (new Swift_Message('The Only One Driver - Nouvelle inscription'))
            //Expéditeur
            ->setFrom('soulaiman.hatim@gmail.com')
            //Destinataire
            ->setTo('soulaiman.hatim@gmail.com')
            // Corps du messsage
            ->setBody(
                $this->renderer->render(
                    'emails/ajout_compte.html.twig'
                ),
                'text/html'
            );
        //On envoie le mail
        $this->mailer->send($message);
    }
}