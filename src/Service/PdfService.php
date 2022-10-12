<?php

namespace App\Service;

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct(){

        $this->domPdf = new Dompdf();
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');
        $pdfOptions->set('defaultPaperOrientation', 'portrait');


        $this->domPdf->setOptions($pdfOptions);
    }

     public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf", [
            'Attachement' => true
        ]);
    }

    public function generateBinaryPDF($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }

}
