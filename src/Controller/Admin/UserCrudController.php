<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', 'Liste des Users')
            ->setPaginatorPageSize(8)
            ->setEntityLabelInSingular('user')
            ->setEntityLabelInPlural('users');
    }

    public function configureFields(string $pageName): iterable
    {
        $nomComplet = TextField::new('nomComplet');
        $nom = TextField::new('nom');
        $prenom = TextField::new('prenom', 'Prénom');
        $email = TextField::new('email');
        $adresse = TextField::new('adresse');
        $createdAt = DateTimeField::new('createdAt', 'Date de création');
        $updatedAt = DateTimeField::new('updatedAt', 'Date de modification');


        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL){
            $champ = [$nomComplet, $nom, $prenom, $email, $adresse, $createdAt, $updatedAt];
        }else{
            $champ = [$nom, $prenom, $email, $adresse];
        }
        return $champ;
    }

}
