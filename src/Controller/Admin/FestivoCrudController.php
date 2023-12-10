<?php

namespace App\Controller\Admin;

use App\Entity\Festivo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FestivoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Festivo::class;
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
