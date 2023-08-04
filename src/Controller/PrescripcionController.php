<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PrescripcionController extends AbstractController
{
    #[Route('/prescripcion', name: 'app_prescripcion')]
    public function index(): Response
    {
        return $this->render('prescripcion/index.html.twig', [
            'controller_name' => 'PrescripcionController',
        ]);
    }
}
