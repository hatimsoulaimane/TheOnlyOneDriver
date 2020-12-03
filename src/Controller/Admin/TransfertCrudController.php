<?php

namespace App\Controller\Admin;

use App\Entity\Transfert;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TransfertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transfert::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInSingular('Transfert')
            ->setEntityLabelInPlural('Transferts')
            ->setPageTitle('index', "Liste des transferts")
            ->setPaginatorPageSize(8);
    }


    public function configureFields(string $pageName): iterable
    {
        $panelTransfert = FormField::addPanel("Infos Transfert");
        $titre = TextField::new("titre");
        $description = TextEditorField::new("description");
        $nb_passager = NumberField::new("nb_passager");
        $nb_bagage = NumberField::new("nb_bagage");
        $destination = TextField::new("destination");
        $prix = NumberField::new('prix', "Prix ");
        $dispo = BooleanField::new('dispo', "Est Disponible ?");
        $createdAt = DateTimeField::new('createdAt', "Date de création");
        $updatedAt = DateTimeField::new('updatedAt', "Date de modification");

        $panelImage = FormField::addPanel("Infos Images");
        $imageName = ImageField::new("imageName","Photo")->setBasePath("/images/prestations");
        $imageFile = ImageField::new("imageFile","Télécharger la photo")->setFormType(VichImageType::class);

        $infosTransferts = [$panelTransfert, $titre, $description, $nb_bagage, $nb_passager, $destination, $prix, $dispo];

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL){
            $infosImages = [$panelImage, $imageName];
        }else{
            $infosImages = [$panelImage, $imageFile];
        }

        return array_merge($infosTransferts, $infosImages);

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

}
