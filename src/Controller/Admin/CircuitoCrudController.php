<?php

namespace App\Controller\Admin;

use App\Entity\Circuito;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CircuitoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Circuito::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('tramo','Duración del tramo (m)'),
            NumberField::new('precio_circuito','Precio/tramo'),
            TextField::new('foto'),
        ];
    }
    
}
