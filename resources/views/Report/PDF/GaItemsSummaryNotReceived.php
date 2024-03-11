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

    $pdf->addInfo('Title',strtoupper("GA ITEMS SUMMARY (Not Received)"));
    $pdf->selectFont($defaultFont);

    $picture = base_path('public/image/letterhead.jpg');
    $pdf->addJpegFromFile($picture,$startW,$startH-$pdf->C2P(3.3),$endW-$startW,$pdf->C2P(3.5));
    $startH-=$rowH+$pdf->C2P(3.5);
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>GA ITEMS SUMMARY (Not Received)</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL: ".number_format(count($notReceivedReport))."</b>",'center');
    $startH-=$rowH;
    $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>AS OF ".$DateTime."</b>",'center');

    if(!empty($notReceivedReport)){
        $startH-=$rowH;
        $extend = $pdf->C2P(0.015);
        $pdf->setLineStyle(1);
        $fontSize = 9;
        $rowH = $pdf->C2P(0.6);

        //top
        $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
        //left corner
        $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
        //pbno divider
        $pdf->line($startW+$pdf->C2P(2.3),$startH+$extend,$startW+$pdf->C2P(2.3),$startH-$rowH-$extend);
        //memberId divider
        $pdf->line($startW+$pdf->C2P(4.6),$startH+$extend,$startW+$pdf->C2P(4.6),$startH-$rowH-$extend);
        //name divider
        $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
        //branch divider
        $pdf->line($startW+$pdf->C2P(15),$startH+$extend,$startW+$pdf->C2P(15),$startH-$rowH-$extend);
        //vote method divider
        $pdf->line($startW+$pdf->C2P(17.2),$startH+$extend,$startW+$pdf->C2P(17.2),$startH-$rowH-$extend);
        
        //right corner
        $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
        //bottom
        $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
        $startH-=$rowH;

        $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, "<b>Pb No</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(2.3), $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, "<b>Member ID</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(4.6), $startH+$pdf->C2P(0.18), $pdf->C2P(7.4), $fontSize, "<b>NAME</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, "<b>BRANCH</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(15), $startH+$pdf->C2P(0.18), $pdf->C2P(2.2), $fontSize, "<b>VOTE METHOD</b>",'center');

        $pdf->addTextWrap($startW+$pdf->C2P(17.2), $startH+$pdf->C2P(0.18), $pdf->C2P(3.4), $fontSize, "<b>DATE</b>",'center');

        foreach($notReceivedReport as $data){
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
                $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>ELECTION SUMMARY</b>",'center');
                $startH-=$rowH;
                $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>TOTAL VOTED: ".number_format(count($notReceivedReport))."</b>",'center');
                $startH-=$rowH;
                $pdf->addTextWrap($startW, $startH, $endW, $fontSize, "<b>AS OF ".$DateTime."</b>",'center');

                $startH-=$rowH;
                $extend = $pdf->C2P(0.015);
                $pdf->setLineStyle(1);
                $fontSize = 9;
                $rowH = $pdf->C2P(0.6);

                //top
                $pdf->line($startW-$extend,$startH,$endW+$extend,$startH);
                //left corner
                $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                //pbno divider
                $pdf->line($startW+$pdf->C2P(2.3),$startH+$extend,$startW+$pdf->C2P(2.3),$startH-$rowH-$extend);
                //memberId divider
                $pdf->line($startW+$pdf->C2P(4.6),$startH+$extend,$startW+$pdf->C2P(4.6),$startH-$rowH-$extend);
                //name divider
                $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                //branch divider
                $pdf->line($startW+$pdf->C2P(15),$startH+$extend,$startW+$pdf->C2P(15),$startH-$rowH-$extend);
                //vote method divider
                $pdf->line($startW+$pdf->C2P(17.2),$startH+$extend,$startW+$pdf->C2P(17.2),$startH-$rowH-$extend);
                //right corner
                $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                //bottom
                $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                $startH-=$rowH;

                $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, "<b>Pb No</b>",'center');

                $pdf->addTextWrap($startW+$pdf->C2P(2.3), $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, "<b>Member ID</b>",'center');

                $pdf->addTextWrap($startW+$pdf->C2P(4.6), $startH+$pdf->C2P(0.18), $pdf->C2P(7.4), $fontSize, "<b>NAME</b>",'center');

                $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, "<b>BRANCH</b>",'center');

                $pdf->addTextWrap($startW+$pdf->C2P(15), $startH+$pdf->C2P(0.18), $pdf->C2P(2.2), $fontSize, "<b>VOTE METHOD</b>",'center');

                $pdf->addTextWrap($startW+$pdf->C2P(17.2), $startH+$pdf->C2P(0.18), $pdf->C2P(3.4), $fontSize, "<b>DATE</b>",'center');

                //left corner
                $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                //pbno divider
                $pdf->line($startW+$pdf->C2P(2.3),$startH+$extend,$startW+$pdf->C2P(2.3),$startH-$rowH-$extend);
                //memberId divider
                $pdf->line($startW+$pdf->C2P(4.6),$startH+$extend,$startW+$pdf->C2P(4.6),$startH-$rowH-$extend);
                //name divider
                $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                //branch divider
                $pdf->line($startW+$pdf->C2P(15),$startH+$extend,$startW+$pdf->C2P(15),$startH-$rowH-$extend);
                //vote method divider
                $pdf->line($startW+$pdf->C2P(17.2),$startH+$extend,$startW+$pdf->C2P(17.2),$startH-$rowH-$extend);
                //right corner
                $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                //bottom
                $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                $startH-=$rowH;

                $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, $data["pbno"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(2.3), $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, $data["memberId"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(4.7), $startH+$pdf->C2P(0.18), $pdf->C2P(7.4), $fontSize, $data["name"],'left');

                $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, $data["branch"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(15), $startH+$pdf->C2P(0.18), $pdf->C2P(2.2), $fontSize, $data["voteMethod"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(17.2), $startH+$pdf->C2P(0.18), $pdf->C2P(3.4), $fontSize, $data["dateTime"],'center');
            }else{
                //left corner
                $pdf->line($startW,$startH+$extend,$startW,$startH-$rowH-$extend);
                //pbno divider
                $pdf->line($startW+$pdf->C2P(2.3),$startH+$extend,$startW+$pdf->C2P(2.3),$startH-$rowH-$extend);
                //memberId divider
                $pdf->line($startW+$pdf->C2P(4.6),$startH+$extend,$startW+$pdf->C2P(4.6),$startH-$rowH-$extend);
                //name divider
                $pdf->line($startW+$pdf->C2P(12),$startH+$extend,$startW+$pdf->C2P(12),$startH-$rowH-$extend);
                //branch divider
                $pdf->line($startW+$pdf->C2P(15),$startH+$extend,$startW+$pdf->C2P(15),$startH-$rowH-$extend);
                //vote method divider
                $pdf->line($startW+$pdf->C2P(17.2),$startH+$extend,$startW+$pdf->C2P(17.2),$startH-$rowH-$extend);
                //right corner
                $pdf->line($endW,$startH+$extend,$endW,$startH-$rowH-$extend);
                //bottom
                $pdf->line($startW-$extend,$startH-$rowH,$endW+$extend,$startH-$rowH);
                $startH-=$rowH;

                $pdf->addTextWrap($startW, $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, $data["pbno"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(2.3), $startH+$pdf->C2P(0.18), $pdf->C2P(2.3), $fontSize, $data["memberId"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(4.7), $startH+$pdf->C2P(0.18), $pdf->C2P(7.4), $fontSize, $data["name"],'left');

                $pdf->addTextWrap($startW+$pdf->C2P(12), $startH+$pdf->C2P(0.18), $pdf->C2P(3), $fontSize, $data["branch"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(15), $startH+$pdf->C2P(0.18), $pdf->C2P(2.2), $fontSize, $data["voteMethod"],'center');

                $pdf->addTextWrap($startW+$pdf->C2P(17.2), $startH+$pdf->C2P(0.18), $pdf->C2P(3.4), $fontSize, $data["dateTime"],'center');
            }
        }
    }
    $pdf->ezStream();
?>