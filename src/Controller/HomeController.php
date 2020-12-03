<?php

namespace App\Controller;


use App\Repository\PrestationRepository;
use App\Repository\TransfertRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{
    private $prestationRepository;
    private $transfertRepository;
    private $userRepository;

    public function __construct(PrestationRepository $prestationRepository, TransfertRepository $transfertRepository, UserRepository $userRepository)
    {
        $this->prestationRepository = $prestationRepository;
        $this->transfertRepository = $transfertRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('home/index.html.twig', [
            'titre_page' => $titrePage = "Accueil",
            'titre_section' => $titreSection = "page accueil",
//            'prestations' => $prestations = $this->prestationRepository->findAll()
        ]);
    }

    /**
     * @Route("/transfert", name="transfert" )
     */
    public function tansfert()
    {
        return $this->render('home/transfert.html.twig', [
            'titre_page' => $titrePage = "Transfert",
            'titre_section' => $titreSection = "page transfert",
            'transferts' => $transferts = $this->transfertRepository->findAll()
        ]);
    }

//    /**
//     * @Route("/detail/{id}-{slug}", name="transfert" )
//     * @param int $id
//     * @return Response
//     */
//    public function tansfertDetail(int $id)
//    {
//        return $this->render('home/transfertDetail.html.twig', [
//            'titre_page' => $titrePage = "Transfert",
//            'titre_section' => $titreSection = "page transfert",
//            'transfert' => $transfert = $this->transfertRepository->find($id)
//        ]);
//    }

    /**
     * @Route("/prestation", name="prestation")
     */
    public function prestation()
    {
        return $this->render('home/prestation.html.twig', [
            'titre_page' => $titrePage = "Prestation",
            'titre_section' => $titreSection = "page prestation",
            'prestations' => $prestations = $this->prestationRepository->findAll()
        ]);
    }

    /**
     * @Route("/vehicule", name="vehicule")
     */
    public function vehicule()
    {
        return $this->render('home/vehicule.html.twig', [
            'titre_page' => $titrePage = "Véhicule",
            'titre_section' => $titreSection = "page véhicule",
        ]);
    }

//    /**
//     * @Route("/prestation/{id}-{slug}", name="prestation")
//     * @param int $id
//     * @return Response
//     */
//    public function prestation(int $id)
//    {
//        return $this->render('home/prestation.html.twig',[
//            'titre_page' => $titrePage = "Prestation",
//            'titre_section' => $titreSection = "page prestation",
//            'prestation' => $prestation = $this->prestationRepository->find($id)
//
//        ]);
//    }

//    /**
//     * @Route("/user/{id}", name="user")
//     * @param int $id
//     * @return Response
//     */
//    public function user(int $id)
//    {
//        return $this->render('home/user.html.twig', [
//            'titre_page' => $titrePage = "User",
//            'titre_section' => $titreSection = "page client",
//            'user' => $user = $this->userRepository->find($id)
////
//        ]);
//    }
}
