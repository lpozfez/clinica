<?php

namespace App\Controller\Admin;

use App\Entity\Horario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HorarioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Horario::class;
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
