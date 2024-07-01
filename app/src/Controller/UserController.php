<?php

// src/Controller/UserController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'profile_users')]
    public function listUsers(EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }

        // Fetch all users from the database
        $users = $entityManager->getRepository(User::class)->findAll();

        // Render the user list template
        return $this->render('profile/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users/{id}', name: 'user_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }

        // Fetch the user with $id from the database
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
