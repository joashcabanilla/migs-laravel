<?php

    $pdf = new App\Includes\Cezpdf("LETTER","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    $fontSize = 13;
    $startW = $pdf->C2P(0.5);
    $rowH = $pdf->C2P(0.5);
    $startH = $h-$startW;
    $endW = $w-($startW*2);

    $pdf->addInfo('Title',strtoupper("ELECTION SUMMARY"));
    $pdf->selectFont($defaultFont);

    $picture = base_path('public/image/letterhead.jpg');
    $pdf->addJpegFromFile($picture,$startW,$startH-$pdf->C2P(3.3),$endW,$pdf->C2P(3.5));
    $startH-=$rowH+$pdf->C2P(3.5);
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>NOVADECI ELECTION 2024</b>",'center');
    $startH-=$rowH+$pdf->C2P(0.2);
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>VOTES TALLY AS OF ".strtoupper($DateTime)."</b>",'center');

    $startH-=$rowH;
    $extend = $pdf->C2P(0.015);
    $pdf->setLineStyle(1);

    $rowH = $pdf->C2P(0.8);
    $startW += $rowH;
    $endW -= $rowH;
    foreach($votesTally as $position => $candidates){
        //top
        $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
        //left corner
        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
        //right corner
        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
        //bottom
        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
        $startH-=$rowH;

        //left corner
        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
        //candidates divider
        $pdf->line($startW+$pdf->C2P(14),$startH+$extend,$startW+$pdf->C2P(14),$startH-$rowH-$extend);
        //right corner
        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
        //bottom
        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
        $fontSize = 15;
        $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.25), $endW, $fontSize, "<b>".$position."</b>",'center');
        $startH-=$rowH;

        $fontSize = 13;
        $pdf->addTextWrap($startW+$pdf->C2P(0.3), $startH+$pdf->C2P(0.25), $pdf->C2P(13.8), $fontSize, "<b>CANDIDATES</b>",'left');
        $pdf->addTextWrap($startW+$pdf->C2P(14), $startH+$pdf->C2P(0.25),$pdf->C2P(4.1), $fontSize, "<b>VOTES</b>",'center');

        uasort($candidates, function($a, $b){
            return count($b) - count($a);
        });

        foreach($candidates as $name => $candidate){
            //left corner
            $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
            //candidates divider
            $pdf->line($startW+$pdf->C2P(14),$startH+$extend,$startW+$pdf->C2P(14),$startH-$rowH-$extend);
            //right corner
            $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
            //bottom
            $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
            $startH-=$rowH;

            $fontSize = 13;
            $pdf->addTextWrap($startW+$pdf->C2P(0.3), $startH+$pdf->C2P(0.25), $pdf->C2P(13.8), $fontSize, strtoupper($name),'left');
            $votes = gettype($candidate) == "array" ? number_format(count($candidate)) : number_format($candidate);
            $pdf->addTextWrap($startW+$pdf->C2P(14), $startH+$pdf->C2P(0.25),$pdf->C2P(4.1), $fontSize, $votes,'center');
        }
        $startH-=$pdf->C2P(0.25);
    }

    $startH-=$pdf->C2P(0.25);
    $startH-=$rowH;
    $pdf->line($startW-$extend,$startH,$pdf->C2P(8),$startH);
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.25), $pdf->C2P(4), $fontSize, "<b>Elecom Chairman</b>",'left');

    $startH-=$rowH;
    $pdf->line($startW-$extend,$startH,$pdf->C2P(8),$startH);
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.25), $pdf->C2P(4), $fontSize, "<b>Audit Chairman</b>",'left');

    $startH-=$rowH;
    $pdf->line($startW+$pdf->C2P(12),$startH,$endW,$startH);
    $startH-=$rowH;
    $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.25), $pdf->C2P(4), $fontSize, "<b>MIS Manager</b>",'left');
    $pdf->ezStream();
?>