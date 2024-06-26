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

}