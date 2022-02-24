<?php

namespace App\Controller\Admin;

use App\Entity\Coche;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CocheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coche::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->setTextAlign('right'),
            AssociationField::new('modelo')->setTextAlign('center'),
            NumberField::new('precio')->setTextAlign('right'),
            NumberField::new('potencia')->setTextAlign('right'),
            NumberField::new('cilindrada')->setTextAlign('right'),
            NumberField::new('velocidad')->setTextAlign('right')
        ];
    }
    
}
