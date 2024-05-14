<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TodoRepository;


class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(TodoRepository $todoRepository): Response
    {
        $todos = $todoRepository->findAll(); // Fetch all Todo items from the database
    
        return $this->render('todo/index.html.twig', [
            'todos' => $todos, // Pass the fetched Todo items to the template
        ]);
    }
}
