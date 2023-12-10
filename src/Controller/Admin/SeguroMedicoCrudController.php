<?php

namespace App\Controller\Admin;

use App\Entity\SeguroMedico;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SeguroMedicoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SeguroMedico::class;
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
