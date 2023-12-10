<?php

namespace App\Controller\Admin;

use App\Entity\Consulta;
use App\Entity\TipoConsulta;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConsultaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consulta::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('paciente'),
            AssociationField::new('tipo'),
            DateTimeField::new('fecha')->setFormat('dd/MM/yyyy  hh:mm'),
            TextEditorField::new('notasClinicas'),
        ];
    }
    
}
