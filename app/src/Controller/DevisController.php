<?php

// src/Controller/DevisController.php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devis')]
class DevisController extends AbstractController
{
    
    private $knpSnappyPdf;

    public function __construct(Pdf $knpSnappyPdf)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
    }

    #[Route('/', name: 'devis_index', methods: ['GET'])]
    public function index(DevisRepository $devisRepository): Response
    {
        //check permittion 
        if (!$this->getUser()) {
                 return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        return $this->render('devis/index.html.twig', [
            'devis' => $devisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'devis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
            //check permittion 
        if (!$this->getUser()) {
                return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the currently logged-in user
            $user = $this->getUser();
            
            // Set the user on the Devis entity
            $devis->setUser($user);
            $entityManager->persist($devis);
            $entityManager->flush();
    
            return $this->redirectToRoute('devis_index');
        }
    
        return $this->render('devis/new.html.twig', [
            'devis' => $devis,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{id}', name: 'devis_show', methods: ['GET'])]
    public function show(Devis $devis): Response
    {
            //check permittion 
            if (!$this->getUser()) {
                return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        return $this->render('devis/show.html.twig', [
            'devis' => $devis,
        ]);
    }

    #[Route('/{id}/edit', name: 'devis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Devis $devis, EntityManagerInterface $entityManager): Response
    {
        //check permittion 
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('devis_index');
        }

        return $this->render('devis/edit.html.twig', [
            'devis' => $devis,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devis, EntityManagerInterface $entityManager): Response
    {
             //check permittion 
        if (!$this->getUser()) {
                return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        if ($this->isCsrfTokenValid('delete'.$devis->getId(), $request->request->get('_token'))) {
            $entityManager->remove($devis);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devis_index');
    }

    #[Route('/{id}/pdf', name: 'devis_pdf', methods: ['GET'])]
    public function pdf(Devis $devis): Response
    {
            //check permittion 
        if (!$this->getUser()) {
                return $this->redirectToRoute('app_login'); // Redirect to login page if not authenticated
        }
        $html = $this->renderView('devis/pdf.html.twig', [
            'devis' => $devis,
        ]);

        $pdfContent = $this->knpSnappyPdf->getOutputFromHtml($html);

        return new Response(
            $pdfContent,
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="devis.pdf"',
            ]
        );
    }
}
