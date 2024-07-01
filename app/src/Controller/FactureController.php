<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DevisRepository;

#[Route('/facture')]
class FactureController extends AbstractController
{
    private $knpSnappyPdf;

    public function __construct(Pdf $knpSnappyPdf)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
    }

    #[Route('/', name: 'facture_index', methods: ['GET'])]
    public function index(FactureRepository $factureRepository): Response
    {
     //check permittion 
    if (!$this->getUser()) {
        return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
    }
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'facture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }        
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $facture->setUser($user);
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'facture_show', methods: ['GET'])]
    public function show(Facture $facture): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }
                    return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    #[Route('/{id}/edit', name: 'facture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }        
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'facture_delete', methods: ['POST'])]
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }        
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index');
    }

    #[Route('/generate/{devisId}', name: 'facture_generate', methods: ['GET'])]
    public function generate(EntityManagerInterface $entityManager, DevisRepository $devisRepository, $devisId): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }
        $devis = $devisRepository->find($devisId);

        if (!$devis) {
            throw $this->createNotFoundException('The Devis does not exist');
        }

        $facture = new Facture();
        $facture->setMail($devis->getMail());
        $facture->setNomClient($devis->getNomClient());
        $facture->setTelephone($devis->getTelephone());
        $facture->setUser($devis->getUser());
        $facture->setDate(new \DateTimeImmutable());
        foreach ($devis->getProduits() as $produit) {
            $facture->addProduit($produit);
        }
        $facture->setTotalPrix($devis->getTotalPrix());

        $entityManager->persist($facture);
        $entityManager->flush();

        return $this->redirectToRoute('facture_index', ['id' => $facture->getId()]);
    }

    #[Route('/{id}/pdf', name: 'facture_pdf', methods: ['GET'])]
    public function pdf(Facture $facture): Response
    {
                //check permittion 
                if (!$this->getUser()) {
                    return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
            }
        $html = $this->renderView('facture/pdf.html.twig', [
            'facture' => $facture,
        ]);

        $pdfContent = $this->knpSnappyPdf->getOutputFromHtml($html);

        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="facture.pdf"',
            ]
        );
    }
}