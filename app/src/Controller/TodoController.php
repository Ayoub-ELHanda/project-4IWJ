<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TodoFormType;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(TodoRepository $todoRepository): Response
    {
        $todos = $todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    #[Route('/todo/{id}', name: 'app_todo_show')]
    public function show(TodoRepository $todoRepository, $id): Response
    {
        $todo = $todoRepository->find($id);

        if (!$todo) {
            throw $this->createNotFoundException('Todo not found');
        }

        return $this->render('todo/show.html.twig', [
            'todo' => $todo,
        ]);
    }

    #[Route('/todo/{id}/edit', name: 'app_todo_edit')]
    public function edit(Request $request, TodoRepository $todoRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $todo = $todoRepository->find($id);

        if (!$todo) {
            throw $this->createNotFoundException('Todo not found');
        }

        $form = $this->createForm(TodoFormType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_todo');
        }

        return $this->render('todo/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/todo/{id}/delete', name: 'app_todo_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, TodoRepository $todoRepository, EntityManagerInterface $entityManager, $id): Response

    {
        $todo = $todoRepository->find($id);
    
        if (!$todo) {
            throw $this->createNotFoundException('Todo not found');
        }
    
        // Vérifier la validité du token CSRF
        if ($this->isCsrfTokenValid('delete'.$todo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($todo);
            $entityManager->flush();
        }
    
        return $this->redirectToRoute('app_todo');
    }
    

}
