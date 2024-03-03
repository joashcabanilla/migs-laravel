<?php
    error_reporting(0); 
    $pdf = new App\Includes\Cezpdf("LONG","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    $fontSize = 11;
    $startW = $pdf->C2P(1);
    $startH = $h-$startW;

    $pdf->addInfo('Title',strtoupper("TICKETS PRINTING"));
    $pdf->selectFont($defaultFont);

    function generateLine($pdf, $top, $col, $w1, $w2, $h1, $h2){
        $extend = $pdf->C2P(0.015);

        if($top == 1){
            //top
            $pdf->line($w1-$extend,$h1,$w2+$extend,$h1);
        }

        if($col == 1){
            //left corner
            $pdf->line($w1,$h1+$extend,$w1,$h2-$extend);
        }

        //right corner
        $pdf->line($w2,$h1+$extend,$w2,$h2-$extend);

        //bottom
        $pdf->line($w1-$extend,$h2,$w2+$extend,$h2);

    }

    $ticketCtr = 0;
    foreach($ticketList as $ticket){
        $extend = $pdf->C2P(0.015);
        $pdf->setLineStyle(1);
        $ticketW = $pdf->C2P(9.5);
        $rowH = $pdf->C2P(5);
        $ticketH = $startH;
        $ticketH-=$rowH;

        $ticketCtr++;

        if($ticketCtr <= 10){
            if($ticketCtr % 2 == 0){
                generateLine($pdf, 1, 2, $ticketW, $ticketW+$ticketW, $startH, $ticketH);
                $startH-=$rowH;
            }else{
                generateLine($pdf, 1, 1, $startW, $ticketW, $startH, $ticketH);
            }
        }else{
            $pdf->ezNewPage();
            $startH = $h-$startW;
            $ticketCtr = 0;
        }
        
    }
    $pdf->ezStream();
?>