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
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL REGISTERED: ".number_format(count($memberList))."</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>AS OF ".$DateTime."</b>",'center');

    if(!empty($SummaryReport)){
        $startH-=$rowH;
        $extend = $pdf->C2P(0.015);
        $pdf->setLineStyle(1);
        $fontSize = 10;
        $rowH = $pdf->C2P(0.6);

        //top
        $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
        //left corner
        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
        //username divider
        $pdf->line($startW+$pdf->C2P(9),$startH+$extend,$startW+$pdf->C2P(9),$startH-$rowH-$extend);
        //vote method divider
        $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
        //total registered divider
        $pdf->line($startW+$pdf->C2P(16),$startH+$extend,$startW+$pdf->C2P(16),$startH-$rowH-$extend);
        //right corner
        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
        //bottom
        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
        $startH-=$rowH;

        $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(9), $fontSize, "<b>USERNAME</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(9), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, "<b>VOTE METHOD</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(4), $fontSize, "<b>TOTAL REGISTERED</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(16), $startH+$pdf->C2P(0.18), $pdf->C2P(4.6), $fontSize, "<b>DATE</b>",'center');

        foreach($SummaryReport as $username => $voteMethod){
            foreach($voteMethod as $method => $dates){
                foreach($dates as $date => $count){
                    if($startH < 80){
                        $pdf->ezNewPage();
                        $fontSize = 11;
                        $startW = $pdf->C2P(0.5);
                        $rowH = $pdf->C2P(0.5);
                        $startH = $h-$startW;
                        $endW = $w-$startW;

                        $picture = base_path('public/image/letterhead.jpg');
                        $pdf->addJpegFromFile($picture,$startW,$startH-$pdf->C2P(3.3),$endW-$startW,$pdf->C2P(3.5));
                        $startH-=$rowH+$pdf->C2P(3.5);
                        $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>GA ITEMS SUMMARY REPORT</b>",'center');
                        $startH-=$rowH;
                        $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL REGISTERED: ".number_format(count($memberList))."</b>",'center');
                        $startH-=$rowH;
                        $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>AS OF ".$DateTime."</b>",'center');

                        $startH-=$rowH;
                        $extend = $pdf->C2P(0.015);
                        $pdf->setLineStyle(1);
                        $fontSize = 10;
                        $rowH = $pdf->C2P(0.6);

                        //top
                        $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
                        //left corner
                        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                        //username divider
                        $pdf->line($startW+$pdf->C2P(9),$startH+$extend,$startW+$pdf->C2P(9),$startH-$rowH-$extend);
                        //vote method divider
                        $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                        //total registered divider
                        $pdf->line($startW+$pdf->C2P(16),$startH+$extend,$startW+$pdf->C2P(16),$startH-$rowH-$extend);
                        //right corner
                        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                        //bottom
                        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                        $startH-=$rowH;

                        $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(9), $fontSize, "<b>USERNAME</b>",'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(9), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, "<b>VOTE METHOD</b>",'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(4), $fontSize, "<b>TOTAL REGISTERED</b>",'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(16), $startH+$pdf->C2P(0.18), $pdf->C2P(4.6), $fontSize, "<b>DATE</b>",'center');

                        //left corner
                        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                        //username divider
                        $pdf->line($startW+$pdf->C2P(9),$startH+$extend,$startW+$pdf->C2P(9),$startH-$rowH-$extend);
                        //vote method divider
                        $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                        //total registered divider
                        $pdf->line($startW+$pdf->C2P(16),$startH+$extend,$startW+$pdf->C2P(16),$startH-$rowH-$extend);
                        //right corner
                        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                        //bottom
                        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                        $startH-=$rowH;
    
                        $pdf->addTextWrap($startW+$pdf->C2P(0.2), $startH+$pdf->C2P(0.18), $pdf->C2P(9), $fontSize,$username,'left');
    
                        $pdf->addTextWrap($startW+$pdf->C2P(9), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize,$method,'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(4), $fontSize,number_format(count($count)),'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(16), $startH+$pdf->C2P(0.18), $pdf->C2P(4.6), $fontSize, $date,'center');
                    }else{
                        //left corner
                        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                        //username divider
                        $pdf->line($startW+$pdf->C2P(9),$startH+$extend,$startW+$pdf->C2P(9),$startH-$rowH-$extend);
                        //vote method divider
                        $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                        //total registered divider
                        $pdf->line($startW+$pdf->C2P(16),$startH+$extend,$startW+$pdf->C2P(16),$startH-$rowH-$extend);
                        //right corner
                        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                        //bottom
                        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                        $startH-=$rowH;
    
                        $pdf->addTextWrap($startW+$pdf->C2P(0.2), $startH+$pdf->C2P(0.18), $pdf->C2P(9), $fontSize,$username,'left');
    
                        $pdf->addTextWrap($startW+$pdf->C2P(9), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize,$method,'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(4), $fontSize,number_format(count($count)),'center');

                        $pdf->addTextWrap($startW+$pdf->C2P(16), $startH+$pdf->C2P(0.18), $pdf->C2P(4.6), $fontSize, $date,'center');
                    }   
                }
            }
        }
    }
    $pdf->ezStream();
?>