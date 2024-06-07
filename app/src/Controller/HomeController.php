<?php
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // Vous pouvez ajouter le code nécessaire ici pour générer la réponse de votre page d'accueil.
        // Par exemple, le rendu d'un template Twig.
        
        return $this->render('home/index.html.twig');
    }
}
