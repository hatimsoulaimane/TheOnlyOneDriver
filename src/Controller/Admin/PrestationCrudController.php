<?php

namespace App\Controller\Admin;

use App\Entity\PieceJointe;
use App\Entity\Prestation;
use App\Form\PieceJointeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Prestation')
            ->setEntityLabelInPlural('Prestations')
            ->setPageTitle('index', "Liste des prestations")
            ->setPaginatorPageSize(8);
    }


    public function configureFields(string $pageName): iterable
    {
        $panelPrestation = FormField::addPanel("Infos Prestation");
        $titre = TextField::new("titre");
        $description = TextEditorField::new("description");
        $nb_passager = NumberField::new("nb_passager");
        $nb_bagage = NumberField::new("nb_bagage");
        $destination = TextField::new("Destination");
        $prix = NumberField::new('prix', "Prix ");
        $dispo = BooleanField::new('dispo', "Est Disponible ?");
        $createdAt = DateTimeField::new('createdAt', "Date de création");
        $updatedAt = DateTimeField::new('updatedAt', "Date de modification");

        $panelImage = FormField::addPanel("Infos Images");
        $imageName = ImageField::new("imageName","Image")->setBasePath("/images/prestations");
        $imageFile = ImageField::new("imageFile","Télécharger l'image")->setFormType(VichImageType::class);

        $pieceJointes = CollectionField::new("pieceJointes","Images Jointes")
            ->setEntryType(PieceJointeType::class)
            ->setFormTypeOption("by_reference", false)
            ->onlyOnForms();

        $pieceJointesDetail = CollectionField::new("pieceJointes","Images Jointes")
            ->setTemplatePath("pj/images.html.twig")
            ->onlyOnDetail();

        $infosPrestations = [$panelPrestation, $titre, $description, $nb_bagage, $nb_passager, $destination, $prix, $dispo];


        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL){
            $infosImages = [$panelImage, $imageName, $pieceJointesDetail];
        }else{
            $infosImages = [$panelImage, $imageFile, $pieceJointes];
        }

        return array_merge($infosPrestations, $infosImages);

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

}
