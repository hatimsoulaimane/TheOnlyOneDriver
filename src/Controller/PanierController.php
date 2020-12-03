<?php

namespace App\Controller;

use App\Service\VtcAppInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier", name="panier_")
 */
class PanierController extends AbstractController
{
    /**
     * @var VtcAppInterface
     */
    private $appService;

    public function __construct(VtcAppInterface $appService)
    {

        $this->appService = $appService;
    }

    /**
     * @Route("/", name="contenu")
     */
    public function index()
    {
        $contenuDuPanier = $this->appService->contenuDuPanier();
        return $this->json(
            [
                'panier' => $contenuDuPanier
            ]);
    }


    /**
     * @Route ("/ajouter/{id}-{slug}", name="ajouter")
     * @param int $id
     * @param string $slug
     * @return RedirectResponse
     */
    public function ajouter(int $id, string $slug)
    {
        $this->appService->ajouterAuPanier($id);
        return $this->redirectToRoute("home_transfert", ['id' => $id, 'slug' => $slug]);
    }


    /**
     * @Route ("/diminuer/{id}", name="diminuer")
     * @param int $id
     * @return JsonResponse
     */
    public function diminuer(int $id)
    {
        $quantite =$this->appService->diminuerQteDuPanier($id);
        return $this->json(['quantite' => $quantite]);
    }

    /**
     * @Route ("/moins/{id}", name="moins")
     * @param int $id
     * @return RedirectResponse
     */
    public function moins(int $id)
    {
        $quantite = $this->appService->moinsQteDuPanier($id);
        return $this->redirectToRoute('panier_chekout');
    }

    /**
     * @Route ("/augmenter/{id}", name="augmenter")
     * @param int $id
     * @return JsonResponse
     */
    public function augmenter(int $id)
    {
        $quantite = $this->appService->augmenterQteDuPanier($id);
        return $this->json(['quantite' => $quantite]);
    }

    /**
     * @Route("/plus/{id}", name="plus")
     * @param int $id
     * @return RedirectResponse
     */
    public function plus(int $id)
    {
        $quantite = $this->appService->plusQteDuPanier($id);
        return $this->redirectToRoute('panier_chekout');
    }

    /**
     * @Route ("/supprimer/{id}", name="supprimer")
     * @param int $id
     * @return JsonResponse
     */
    public function supprimer(int $id)
    {
        $this->appService->supprimerDuPanier($id);
        return $this->json(["resultat"=>"OK"]);
    }

    /**
     * @Route("/effacer/{id}", name="effacer")
     * @param int $id
     * @return RedirectResponse
     */
    public function effacer(int $id)
    {
        $this->appService->effacerDuPanier($id);
        return $this->redirectToRoute('panier_chekout');
    }

    /**
     * @Route("/checkout", name="chekout")
     * @return Response
     */
    public function checkout()
    {
        $panier = $this->appService->contenuDuPanier();
        $total = 0;
        foreach ($panier as $id => $article) {
            $total += $article['sous_total'];
        }
        return $this->render('panier/checkout.html.twig', [
            'titre_page' => $titrePage = "Checkout",
            'titre_section' =>$titreSection = "valider le panier",
            'articles' => $this->appService->contenuDuPanier(),
            'total'=>$total,
//            'diminuer'=>$this->appService->diminuerQteDuPanier($id),
//            'augmenter'=>$this->appService->augmenterQteDuPanier($id),
        ]);
    }
}
