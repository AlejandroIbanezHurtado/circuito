<?php

namespace App\Controller\Admin;

use App\Entity\ValoracionCoche;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ValoracionCocheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ValoracionCoche::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('valoracion')->hideWhenCreating(),
            TextEditorField::new('descripcion')->hideWhenCreating(),
            AssociationField::new('reserva')->hideWhenCreating()
        ];
    }
    
}
