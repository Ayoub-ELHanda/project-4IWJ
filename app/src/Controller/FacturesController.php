<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FacturesController extends AbstractController
{
    #[Route('/factures', name: 'app_factures')]
    public function index(): Response
    {
        return $this->render('factures/index.html.twig', [
            'controller_name' => 'FacturesController',
        ]);
    }
}
