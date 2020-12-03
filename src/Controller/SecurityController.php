<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Form\ResetPassType;
use App\Form\UserRegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Notifications\CreationCompteNotification;

/**
 * Class SecurityController
 * @package App\Controller
 * @Route("/", name="app_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connexion.html.twig', [
            'titre_page' => $titrePage = "connexion",
            'titre_section' => $titreSection = "page de connexion",
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/oubli-pass", name="app_forgotten_password")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return RedirectResponse|Response
     */
    public function forgottenPass(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        //On crée le formulaire
        $form = $this->createForm(ResetPassType::class);

        //On traite le formulaire
        $form->handleRequest($request);

        //Si le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){
            //On récupére les données
            $donnees = $form->getData();

            //On cherche si un utilisateur a cet email
            $user = $userRepository->findOneByEmail($donnees['email']);

            //Si l'utilisateur n'existe pas
            if(!$user){
                //On envoie un message flash
                $this->addFlash('danger', 'Cette adresse n\'existe pas');

                return $this->redirectToRoute('app_login');
            }
            //Si utilisateur existe on génére un token
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }catch(\Exception $e){
                $this->addFlash('warning', 'Une erreur est survenue : '.$e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            //On génére l'Url se réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password', ['token' => $token],
            UrlGeneratorInterface::ABSOLUTE_URL);

            //On envoie le message
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('soulaiman.hatim@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "<p>Bonjour,</p><p>Une demande de réinitialisation de mot de passe a été effectuée pour le site The Only One Driver. Veuillez cliquer sur le lien suivant : " . $url .'</p>',
                    'text/html'
                )
            ;
            //On envoie l'email
            $mailer->send($message);

            //On crée le message flash
            $this->addFlash('message', 'Un email de réinitialisation de mot de passe vous a été envoyé');

            return $this->redirectToRoute('app_login');
        }
        //On envoie vers la page de demande de l'email
        return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/reset-pass/{token}", name="reset_password")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        //On cherche l'utilisateur avec le token fourni
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if(!$user){
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('app_login');
        }

        //On vérifie si le formulaire est envoyé en methode post
        if($request->isMethod('POST')){
           //On supprime le token de l'utilisateur
            $user->setResetToken(null);

            //On chiffre le mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Mot de passe modifié avec succès');

            return $this->redirectToRoute('app_login');
        }else{
            return $this->render('security/reset_password.html.twig', ['token'=> $token]);
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return new Exception("Sera intercepté avant d'arriver ici");
    }

    /**
     * @var CreationCompteNotification
     */
    private $notify_creation;

    public function __construct(CreationCompteNotification $notify_creation)
    {
        $this->notify_creation = $notify_creation;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param GuardAuthenticatorHandler $handler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     * @Route ("/register", name="register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $encoder,
                            GuardAuthenticatorHandler $handler,
                            LoginFormAuthenticator $authenticator,
                            \Swift_Mailer $mailer)
    {

        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            //dd($user);
            $user->setPassword($encoder->encodePassword(
                $user,
                $form['plainPassword']->getData()
            ));
            //dd($user);
            //on génére le token d'activation
            $user->setActivationToken(md5(uniqid()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //Envoie de l'email d'inscription à l'admin
            $this->notify_creation->notify();

            //on créé le message
            $message = (new \Swift_Message('Activation de votre compte'))
                //On attribue l'expediteur
                ->setFrom('soulaiman.hatim@gmail.com')
                //On attribue le destinataire
                ->setTo($user->getEmail())
                //On crée le contenu
                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            //On envoie l'email
            $mailer->send($message);


            return $handler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render("security/inscription.html.twig", [
           'titre_page' => $titrePage = "inscription",
           'titre_section' => $titreSection = "page d'inscription",
            'registrationForm' => $form->createView(),
       ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $userRepository){
        //On verifie si un utilisateur a ce token
        $user = $userRepository->findOneBy(['activation_token' => $token]);

        //Si aucun utilisateur n'existe avec ce token
        if(!$user){
            //erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        //On supprime le token
        $user->setActivationToken(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        //On envoie un message flash
        $this->addFlash('message', 'Vous avez bien activé votre compte');

        //On retourne à l'accueil
        return $this->redirectToRoute('home_accueil');
    }

    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->render('home/user.html.twig');
    }

    /**
     * @Route ("/users/profil/modifier", name="users_profil_modifier")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profile mis à jour');
            return $this->redirectToRoute('app_users');
        }
        return $this->render('security/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
