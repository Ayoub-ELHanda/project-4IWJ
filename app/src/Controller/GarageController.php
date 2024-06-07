<?php

namespace App\Controller;

use App\Entity\Garage;
use App\Form\GarageType;
use App\Repository\GarageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GarageController extends AbstractController
{
    #[Route('/garages', name: 'garages_list')]

    public function list(GarageRepository $garageRepository): Response
    {
        $garages = $garageRepository->findAll();

        return $this->render('garage/list.html.twig', [
            'garages' => $garages,
        ]);
    }

    #[Route('/garage/new', name: 'garage_new')]

    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $garage = new Garage();
        $form = $this->createForm(GarageType::class, $garage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($garage);
            $em->flush();

            return $this->redirectToRoute('garages_list');
        }

        return $this->render('garage/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}