<?php

namespace App\Controller\Admin;

use App\Entity\Renovacion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RenovacionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Renovacion::class;
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
