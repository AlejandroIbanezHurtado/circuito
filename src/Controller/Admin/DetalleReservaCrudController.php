<?php

namespace App\Controller\Admin;

use App\Entity\DetalleReserva;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DetalleReservaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetalleReserva::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('coche'),
            AssociationField::new('valoracionCoche'),
            AssociationField::new('reserva')
        ];
    }
}
