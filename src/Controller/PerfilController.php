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
        $bodyClass = 'pagMedico'; // Clase CSS para la página de médico y admin
        return $this->render('perfil/index.html.twig', [
            'bodyclass' => $bodyClass,
            'controller_name' => 'PerfilController',
        ]);
    }
}

