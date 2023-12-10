<?php

namespace App\Controller\Admin;

use App\Entity\Prescripcion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PrescripcionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prescripcion::class;
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
