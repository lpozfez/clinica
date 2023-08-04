<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DatosController extends AbstractController
{
    #[Route('/datos', name: 'app_datos')]
    public function index(): Response
    {
        return $this->render('datos/index.html.twig', [
            'controller_name' => 'DatosController',
        ]);
    }
}
