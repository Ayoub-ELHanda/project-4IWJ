<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/users/{id}', name: 'user_show')]
    public function show(int $id): Response
    {
                        //check permittion 
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        // Fetch user with $id from database or other logic
        $user = 'show'; // Fetch user logic here

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
