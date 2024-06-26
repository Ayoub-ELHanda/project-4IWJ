<?php

// src/Service/PdfService.php

namespace App\Service;

use Knp\Snappy\Pdf;

class PdfService
{
    private Pdf $knpSnappyPdf;

    public function __construct(Pdf $knpSnappyPdf)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
    }

    public function generatePdf(string $html): string
    {
        return $this->knpSnappyPdf->getOutputFromHtml($html);
    }
}
