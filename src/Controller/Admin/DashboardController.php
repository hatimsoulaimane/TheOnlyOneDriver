<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use App\Entity\Prestation;
use App\Entity\Transfert;
use App\Repository\CommandeRepository;
use App\Repository\PrestationRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use http\Client\Curl\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 * @Route ("/admin", name="back_")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PrestationRepository
     */
    private $prestationRepository;

    /**
     * @var CommandeRepository
     */
    private $commandeRepository;

    public function __construct(UserRepository $userRepository, PrestationRepository $prestationRepository, CommandeRepository $commandeRepository)
    {
        $this->userRepository = $userRepository;
        $this->prestationRepository = $prestationRepository;
        $this->commandeRepository = $commandeRepository;
    }


    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
//        dd(count($this->userRepository->findAll()));
        return $this->render("bundles/EasyAdminBundle/welcome.html.twig", [
            "titre_page" => $titrePage = "Tableau de bord",
            "nb_users" => $nbUsers = count($this->userRepository->findAll()),
            "nb_presta" => $nbPresta =count($this->prestationRepository->findAll()),
            "totalCmd" => $totalCmd =count($this->commandeRepository->findAll()),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('THE ONLY ONE DRIVER')
            ->setFaviconPath('images/prestations/vtc.jpg');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('DASHBOARD', 'fa fa-home');


        yield MenuItem::section("Gerer les Users");
        yield MenuItem::linkToCrud('Clients', 'fas fa-list', \App\Entity\User::class);

        yield MenuItem::section("Gerer les Transferts");
        yield MenuItem::linkToCrud('Transferts', 'fas fa-list', Transfert::class);


        yield MenuItem::section("Gerer les Prestations");
        yield MenuItem::linkToCrud('Prestations', 'fas fa-list', Prestation::class);


        yield MenuItem::section("Autres");
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Commentaire::class);

        yield MenuItem::section("");
        yield MenuItem::linkToRoute('Retour SiteWeb', 'fas fa-laptop-house', 'home_accueil');

    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($this->getUser()->getNomComplet())
            ->setAvatarUrl('https://i.pinimg.com/originals/08/a9/0a/08a90a48a9386c314f97a07ba1f0db56.jpg')
            ;
    }
}
