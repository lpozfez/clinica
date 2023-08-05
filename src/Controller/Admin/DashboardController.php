<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_MEDICO')]
    public function index(): Response
    {
        return $this->render('admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Clinica ginecológica');
    }

    public function configureMenuItems(): iterable
    {
        return[
            MenuItem::linkToUrl('Atrás','fa fa-circle-left', $this->generateUrl('app_medico')),
            MenuItem::linkToDashboard('Datos maestros', 'fa fa-home'),
            MenuItem::section('Usuarios'),
            MenuItem::linkToCrud('Usuarios', 'fa fa-user', User::class),
        ];
    }
    
    public function configureActions(): Actions
    {
        return parent::configureActions()
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
        
    }
    /*
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
        ->addCssFile('assets/estilos/admin.css');
    }*/
}
