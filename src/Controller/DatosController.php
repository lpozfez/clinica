<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DatosController extends AbstractController
{
    #[Route('/datos', name: 'app_datos')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $bodyClass = 'pagBase'; 
        return $this->render('datos/index.html.twig', [
            'bodyclass' => $bodyClass,
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
