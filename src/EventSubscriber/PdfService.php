<?php

namespace App\EventSubscriber;

use Dompdf\Dompdf;
use Dompdf\Options; 

class PdfService {


   private $dompdf ;
   
   public function __construct()
   {
    $this->dompdf = new Dompdf();

    $pdfopt = new Options();

    $pdfopt->set('defaultFont','Garamond');

    $this->dompdf->setOptions($pdfopt);

   

   }

   public function showPdfFile($html){
    $this->dompdf->loadHtml($html);
    $this->dompdf->render();

    $this->dompdf->stream("deatail.pdf",[
        'Attachement'=>false
    ]);

   }

   public function generateBinaryPdf($html){
    $this->dompdf->loadHtml($html);

    $this->dompdf->render();

    

    $this->dompdf->output();
   }

}