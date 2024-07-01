<?php
// src/Controller/ProfileController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/edit', name: 'profile_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
                        //check permittion 
                        if (!$this->getUser()) {
                            return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
                    }
        // Get the currently logged-in user
        $user = $this->getUser();

        

        // Ensure user exists
        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found');
        }

        // Create a form to handle profile editing
        $form = $this->createForm(ProfileEditType::class, $user);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the updated user entity
            $entityManager->persist($user);
            $entityManager->flush();

            // Add flash message for success
            $this->addFlash('success', 'Profile updated successfully.');

            // Redirect to profile page or any other route
            return $this->redirectToRoute('profile_edit');
        }

        // Render the edit profile form template
        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
