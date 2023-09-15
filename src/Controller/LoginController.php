<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//https://symfony.com/doc/current/security.html#securing-controllers-and-other-code
class LoginController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $bodyClass = 'pagBase'; // Clase CSS para la página base
        return $this->render('login/index.html.twig', [
            'bodyclass' => $bodyClass,
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    
}
