<?php

namespace App\Controller\Admin;

use App\Entity\TipoConsulta;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TipoConsultaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TipoConsulta::class;
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
