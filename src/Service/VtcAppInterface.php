<?php


namespace App\Service;


use App\Repository\PrestationRepository;
use App\Repository\TransfertRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VtcAppInterface
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PrestationRepository
     */
    private $prestationRepository;
    /**
     * @var TransfertRepository
     */
    private $transfertRepository;

    public function __construct(SessionInterface $session, PrestationRepository $prestationRepository, TransfertRepository $transfertRepository)
    {
        $this->session = $session;
        $this->prestationRepository = $prestationRepository;
        $this->transfertRepository = $transfertRepository;
    }

    public static function capitalize(string $chaine)
    {
        return ucwords(mb_strtolower(trim($chaine)));
    }

    public static function lowercase(string $chaine)
    {
        return mb_strtolower(trim($chaine));
    }
    public static function uppercase(string $chaine)
    {
        return mb_strtoupper(trim($chaine));
    }
    public static function concactene(string $prenom, string $nom)
    {
        return $prenom . " " . $nom;
    }

    /**
     * Permet de recuperer le contenu du panier
     * @return array
     */
    public function contenuDuPanier(): array
    {
        $panier = $this->session->get('panier', []);
        $contenuDuPanier = [];
        foreach ($panier as $id => $quantite) {
           $transfert = $this->transfertRepository->find($id);
           if ($quantite && $transfert->getDispo()) {
               $contenuDuPanier[] = [
               "quantite" => $quantite,
               "transfert" => $transfert,
               "sous_total" => $quantite * $transfert->getPrix()
                ];
           }
        }
        return $contenuDuPanier;
    }

    /**
     * Permet d'ajouter une prestation au panier
     * @param int $id
     */
    public function ajouterAuPanier(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        $this->session->set('panier', $panier);
    }

    /**
     * Permet de diminuer la qte de prestation dans panier
     * @param int $id
     * @return int
     */
    public function diminuerQteDuPanier(int $id):int
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]--;
        }
        $this->session->set('panier', $panier);
        return $panier[$id];
    }

    /**
     * Permet de diminuer la qte de transfert dans checkout
     * @param int $id
     * @return int
     */
    public function moinsQteDuPanier(int $id):int
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]--;
        }
        $this->session->set('panier', $panier);
        return $panier[$id];
    }


    /**
     * Permet d'augmenter la qte de trabsfert dans panier
     * @param int $id
     * @return int
     */
    public function augmenterQteDuPanier(int $id):int
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        }
        $this->session->set('panier', $panier);
        return $panier[$id];
    }

    /**
     * Permet d'augmenter la qte de transfert dans checkout
     * @param int $id
     * @return int
     */
    public function plusQteDuPanier(int $id):int
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        }
        $this->session->set('panier', $panier);
        return $panier[$id];
    }

    /**
     * Permet de supprimer une prestation du panier
     * @param int $id
     */
    public function supprimerDuPanier(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    /**
     * Permet de supprimer le transfert du checkout
     * @param int $id
     */
    public function effacerDuPanier(int $id)
    {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }


//    /**
//     * @param string $imageName
//     * @return string
//     */
//    public static function getImageUrl(string $imageName)
//    {
//        return "images/prestations/" . $imageName;
//    }
}