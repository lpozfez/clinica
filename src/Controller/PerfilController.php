<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        $rol = $this->getUser()->getRoles()[0]; // Obtener el rol del usuario

        if ($rol == 'ROLE_MEDICO' || $rol == 'ROLE_ADMINISTRATIVO') {
            $bodyClass = 'pagMedico'; // Clase CSS para la página de médico y admin
        } else {
            $bodyClass = 'pagBase'; // Clase CSS para la página de paciente
        }
        
        return $this->render('perfil/index.html.twig', [
            'bodyclass' => $bodyClass,
            'controller_name' => 'PerfilController',
        ]);
    }
}

