<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitasController extends AbstractController
{
    #[Route('/citas', name: 'app_citas')]
    public function index(): Response
    {
        $bodyClass = 'pagBase'; 
        return $this->render('citas/index.html.twig', [
            'bodyclass' => $bodyClass,
            'controller_name' => 'CitasController',
        ]);
    }
}
