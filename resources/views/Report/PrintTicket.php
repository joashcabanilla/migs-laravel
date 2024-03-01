<?php
    error_reporting(0); 
    $pdf = new App\Includes\Cezpdf("LONG","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    $fontSize = 15;
    $margin = $pdf->C2P(0.5);
    $row = $pdf->C2P(0.5);
    $hT = $h-$margin;
    $wT = $w-($margin*2);
    $pdf->addInfo('Title',strtoupper("TICKETS PRINTING"));
    $pdf->selectFont($defaultFont);

    $ticketCtr = 0;

    foreach($ticketList as $ticket){
        $ticketCtr++;
        $pdf->setColor(0.00,0.00,0.00);
        if($ticketCtr <= 3){
            $hT-=$row;
            $pdf->addTextWrap($margin, $hT, $wT, $fontSize, "<b>".$ticket["name"]."</b>",'center');
            $hT-=$row+$pdf->C2P(9);
            $pdf->addJpegFromFile(base_path("public/image/ticketborder.jpeg"),$margin*4,$hT,$wT-($margin*5.6),$pdf->C2P(9.3));
            $pdf->setColor(0.70,0.00,0.00);
            $pdf->addTextWrap($margin, $hT+$pdf->C2P(0.4), $wT-$pdf->C2P(2), $fontSize, "<b>".$ticket["ticketNo"]."</b>",'right');
        }else{
            $ticketCtr = 0;
            $pdf->ezNewPage();
            $hT = $h-$margin;
            $hT-=$row;
            $pdf->addTextWrap($margin, $hT, $wT, $fontSize, "<b>".$ticket["name"]."</b>",'center');
            $hT-=$row+$pdf->C2P(9);
            $pdf->addJpegFromFile(base_path("public/image/ticketborder.jpeg"),$margin*4,$hT,$wT-($margin*5.6),$pdf->C2P(9.3));
            $pdf->setColor(0.70,0.00,0.00);
            $pdf->addTextWrap($margin, $hT+$pdf->C2P(0.4), $wT-$pdf->C2P(2), $fontSize, "<b>".$ticket["ticketNo"]."</b>",'right');
        }
        $hT-=$row;
    }
    $pdf->ezStream();
?>