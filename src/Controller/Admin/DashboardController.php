<?php

namespace App\Controller\Admin;

use App\Entity\Consulta;
use App\Entity\DetalleHorario;
use App\Entity\Festivo;
use App\Entity\Horario;
use App\Entity\Paciente;
use App\Entity\Prescripcion;
use App\Entity\Renovacion;
use App\Entity\SeguroMedico;
use App\Entity\TipoConsulta;
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
            MenuItem::linkToUrl('Atrás','fa fa-circle-left', $this->generateUrl('app_perfil')),
            MenuItem::linkToDashboard('Datos maestros', 'fa fa-home'),

            MenuItem::section('Usuarios'),
            MenuItem::linkToCrud('Usuarios', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Pacientes', 'fa fa-users', Paciente::class),
            MenuItem::linkToCrud('Seguros', 'fa fa-thermometer-half ', SeguroMedico::class),

            MenuItem::section('Consultas'),
            MenuItem::linkToCrud('Consultas', 'fa fa-hospital-o', Consulta::class),
            MenuItem::linkToCrud('Tipos de consultas', 'fa fa-stethoscope', TipoConsulta::class),

            MenuItem::section('Medicación'),
            MenuItem::linkToCrud('Prescripciones', 'fa fa-medkit', Prescripcion::class),
            MenuItem::linkToCrud('Renovaciones', 'fa fa-plus-square', Renovacion::class),

            MenuItem::section('Horarios'),
            MenuItem::linkToCrud('Horarios', 'fa fa-clock', Horario::class),
            MenuItem::linkToCrud('DetalleHorario', 'fa fa-calendar', DetalleHorario::class),
            MenuItem::linkToCrud('Festivos', 'fa fa-calendar-times-o', Festivo::class),
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
