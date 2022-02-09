<?php

namespace App\Controller\Admin;

use App\Entity\Modelo;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ModeloCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Modelo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('nombre'),
            AssociationField::new('marca'),
        ];
    }
}
