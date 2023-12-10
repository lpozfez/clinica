<?php

namespace App\Controller\Admin;

use App\Entity\DetalleHorario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DetalleHorarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DetalleHorario::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
