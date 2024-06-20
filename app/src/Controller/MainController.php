<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/Dashboard', name: 'app_Dashboard')]
    public function Dashboard(): Response
    {
        return $this->render('admin/Dashboard.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    
}
