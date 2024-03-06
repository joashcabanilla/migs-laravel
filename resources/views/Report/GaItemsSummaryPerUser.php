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

    $pdf->addInfo('Title',strtoupper("GA ITEMS SUMMARY REPORT"));
    $pdf->selectFont($defaultFont);

    $picture = base_path('public/image/letterhead.jpg');
    $pdf->addJpegFromFile($picture,$startW,$startH-$pdf->C2P(3.3),$endW-$startW,$pdf->C2P(3.5));
    $startH-=$rowH+$pdf->C2P(3.5);
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>GA ITEMS SUMMARY REPORT</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>REGISTERED BY: ".$encoderName."</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL REGISTERED: ".number_format(count($memberList))."</b>",'center');

    if(!empty($memberList)){
        $startH-=$rowH;
        $extend = $pdf->C2P(0.015);
        $pdf->setLineStyle(1);
        $fontSize = 10;
        $rowH = $pdf->C2P(0.6);

        //top
        $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
        //left corner
        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
        //pbno divider
        $pdf->line($startW+$pdf->C2P(2.5),$startH+$extend,$startW+$pdf->C2P(2.5),$startH-$rowH-$extend);
        //memberId divider
        $pdf->line($startW+$pdf->C2P(5),$startH+$extend,$startW+$pdf->C2P(5),$startH-$rowH-$extend);
        //name divider
        $pdf->line($startW+$pdf->C2P(14),$startH+$extend,$startW+$pdf->C2P(14),$startH-$rowH-$extend);
        //vote method divider
        $pdf->line($startW+$pdf->C2P(17),$startH+$extend,$startW+$pdf->C2P(17),$startH-$rowH-$extend);
        //right corner
        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
        //bottom
        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
        $startH-=$rowH;

        $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(2.5), $fontSize, "<b>Pbno</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(2.5), $startH+$pdf->C2P(0.18), $pdf->C2P(2.5), $fontSize, "<b>Member ID</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(5), $startH+$pdf->C2P(0.18), $pdf->C2P(9), $fontSize, "<b>NAME</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(14), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, "<b>VOTE METHOD</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(17), $startH+$pdf->C2P(0.18), $pdf->C2P(3.6), $fontSize, "<b>DATE TIME</b>",'center');

        foreach($memberList as $member){
            //left corner
            $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
            //pbno divider
            $pdf->line($startW+$pdf->C2P(2.5),$startH+$extend,$startW+$pdf->C2P(2.5),$startH-$rowH-$extend);
            //memberId divider
            $pdf->line($startW+$pdf->C2P(5),$startH+$extend,$startW+$pdf->C2P(5),$startH-$rowH-$extend);
            //name divider
            $pdf->line($startW+$pdf->C2P(14),$startH+$extend,$startW+$pdf->C2P(14),$startH-$rowH-$extend);
            //vote method divider
            $pdf->line($startW+$pdf->C2P(17),$startH+$extend,$startW+$pdf->C2P(17),$startH-$rowH-$extend);
            //right corner
            $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
            //bottom
            $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
            $startH-=$rowH;
        }
    }

    $pdf->ezStream();
?>