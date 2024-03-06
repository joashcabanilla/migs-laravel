<?php

    $pdf = new App\Includes\Cezpdf("LONG","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    
    $startW = $pdf->C2P(1);
    $startH = $h-$startW;

    $pdf->addInfo('Title',strtoupper("GA ITEMS SUMMARY REPORT"));
    $pdf->selectFont($defaultFont);

    dd($memberList);
    $pdf->ezStream();
?>