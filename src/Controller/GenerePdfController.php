<?php

namespace App\Controller;

use App\Entity\Guardian;
use App\Repository\EleveRepository;
use App\Repository\GuardianRepository;
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenerePdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_genere_pdf')]
    public function index(PdfService $pdf, EleveRepository $eleveRepository)
    {

        $html = $this->render('eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);

        $pdf->showPdfFile($html);

        // return $this->render('genere_pdf/index.html.twig', [
        //     'controller_name' => 'GenerePdfController',
        // ]);
    }
}
