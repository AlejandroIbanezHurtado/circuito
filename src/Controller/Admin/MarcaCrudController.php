<?php

namespace App\Controller\Admin;

use App\Entity\Marca;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MarcaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Marca::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
        ];
    }
    
}
