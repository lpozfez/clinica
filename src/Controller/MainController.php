<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        $bodyClass = 'pagBase'; // Clase CSS para la página base
        return $this->render('main/index.html.twig', [
            'bodyclass' => $bodyClass,
            'controller_name' => 'PerfilController',
        ]);
    }
}
