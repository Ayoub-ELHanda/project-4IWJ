<?php

namespace App\Controller;

use App\Repository\DevisRepository;
use App\Repository\FactureRepository;
use App\Repository\ClientRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function Dashboard(DevisRepository $devisRepository,FactureRepository $factureRepository,ClientRepository $clientRepository ): Response
    {
        $factureList = $devisRepository->findAll();
        $totalfactureAmount = array_reduce($factureList, function($total, $facture) {
            return $total + $facture->getTotalPrix();
        }, 0);

        $factureCount = count($factureList);
        $clientCount = $clientRepository->count([]);

        $devisList = $devisRepository->findAll();
        $totalDevisAmount = array_reduce($devisList, function($total, $devis) {
            return $total + $devis->getTotalPrix();
        }, 0);


        return $this->render('admin/Dashboard.html.twig', [
            'controller_name' => 'MainController',
            'devisList' => $devisList,
            'totalDevisAmount' => $totalDevisAmount,
            'factureList' => $factureList,
            'totalfactureAmount' => $totalfactureAmount,
            'factureCount' => $factureCount,
            'clientCount' => $clientCount,

        ]);
    }
}
