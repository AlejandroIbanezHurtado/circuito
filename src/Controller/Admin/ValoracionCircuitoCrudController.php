<?php

namespace App\Controller\Admin;

use App\Entity\ValoracionCircuito;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ValoracionCircuitoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ValoracionCircuito::class;
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
    
    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->disable(Action::NEW);
    }
}
