<?php
    $pdf = new App\Includes\Cezpdf("LETTER","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    $fontSize = 11;
    $startW = $pdf->C2P(0.5);
    $rowH = $pdf->C2P(0.5);
    $startH = $h-$startW;
    $endW = $w-$startW;

    $pdf->addInfo('Title',strtoupper("ELECTION SUMMARY"));
    $pdf->selectFont($defaultFont);

    $picture = base_path('public/image/letterhead.jpg');
    $pdf->addJpegFromFile($picture,$startW,$startH-$pdf->C2P(3.3),$endW-$startW,$pdf->C2P(3.5));
    $startH-=$rowH+$pdf->C2P(3.5);
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>ELECTION SUMMARY</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL VOTED:</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>AS OF ".$DateTime."</b>",'center');
    $pdf->ezStream();
?>