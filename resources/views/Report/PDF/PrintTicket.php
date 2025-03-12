<?php

    $pdf = new App\Includes\Cezpdf("LONG","PORTRAIT");
    $defaultFont = base_path("app/Includes/fonts/Calibri.afm"); 
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    
    $startW = $pdf->C2P(1);
    $startH = $h-$startW;

    $pdf->addInfo('Title',strtoupper("TICKETS PRINTING"));
    $pdf->selectFont($defaultFont);

    function generateLine($pdf, $top, $col, $w1, $w2, $h1, $h2){
        $pdf->setLineStyle(3);
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

    function generateData($pdf, $startW, $infoH, $ticketW, $ticket){
        $pdf->setLineStyle(1);
        $fontSize = 65;
        $ticket = (object) $ticket;
        $label48 = base_path('public/image/49.jpg');
        $infoH-= $pdf->C2P(4.3);   
        $pdf->addJpegFromFile($label48,$startW+$pdf->C2P(0.8),$infoH+$pdf->C2P(0.2),$pdf->C2P(7.5),$pdf->C2P(3));
        $infoH+=$pdf->C2P(4.3);
        
        $fontSize = 11;
        $ticketW -= $pdf->C2P(1);
        //ticket no
       $pdf->setColor(255,0.00,0.00);
        $infoH -= $pdf->C2P(0.5); 
        $pdf->addTextWrap($startW, $infoH-$pdf->C2P(0.4), $ticketW-$pdf->C2P(0.6), $fontSize+3, "<b>".$ticket->ticketNo."</b>",'right');

        //mem id / pb no
        $pdf->setColor(0,0,0,1);
        $infoH -= $pdf->C2P(1);
        $infoW = $startW+$pdf->C2P(0.5);
        $pdf->addTextWrap($infoW, $infoH, $pdf->C2P(2.2), $fontSize, "<b>MEM ID/PB#:</b>",'left');
        $pdf->line($infoW+$pdf->C2P(2.2),$infoH-$pdf->C2P(0.1),$infoW+$pdf->C2P(7.6),$infoH-$pdf->C2P(0.1));
        $infoW += $pdf->C2P(2.3);
        $pdf->addTextWrap($infoW, $infoH, $pdf->C2P(4), $fontSize, "<b>".$ticket->pbno."</b>",'left');
        
        //name
        $pdf->setColor(0,0,0,1);
        $infoH -= $pdf->C2P(0.75);
        $infoW = $startW+$pdf->C2P(0.5);
        $pdf->addTextWrap($infoW, $infoH, $pdf->C2P(1.2), $fontSize, "<b>NAME:</b>",'left');
        $infoW += $pdf->C2P(1.3);
        $text = "<b>".$ticket->name."</b>";
        $text = $pdf->addTextWrap($infoW, $infoH,$pdf->C2P(6.5),$fontSize,$text,'left');
        while(!empty($text)){
            $infoH -= $pdf->C2P(0.5);
            $text = $pdf->addTextWrap($infoW, $infoH,$pdf->C2P(6.5),$fontSize,$text,'left');
        }
        $infoW -= $pdf->C2P(1.3);
        $pdf->line($infoW+$pdf->C2P(1.2),$infoH-$pdf->C2P(0.1),$infoW+$pdf->C2P(7.6),$infoH-$pdf->C2P(0.1));

        //contact
        $pdf->setColor(0,0,0,1);
        $infoH -= $pdf->C2P(0.75);
        $infoW = $startW+$pdf->C2P(0.5);
        $pdf->addTextWrap($infoW, $infoH, $pdf->C2P(2.3), $fontSize, "<b>CONTACT NO:</b>",'left');
        $pdf->line($infoW+$pdf->C2P(2.3),$infoH-$pdf->C2P(0.1),$infoW+$pdf->C2P(7.6),$infoH-$pdf->C2P(0.1));
        $infoW += $pdf->C2P(2.4);
        $pdf->addTextWrap($infoW, $infoH, $pdf->C2P(4), $fontSize, "<b>".$ticket->contact."</b>",'left');
    }

    $ticketCtr = 0;
    
    foreach($ticketList as $ticket){
        $extend = $pdf->C2P(0.015);
        $ticketW = $pdf->C2P(9.9);
        $rowH = $pdf->C2P(4.4);
        $ticketH = $startH;
        $ticketH-=$rowH;

        $ticketCtr++;

        if($ticketCtr <= 14){
            if($ticketCtr % 2 == 0){
                generateLine($pdf, 1, 2, $ticketW, $ticketW+($ticketW-$startW), $startH, $ticketH);
                $startH-=$rowH;
                $infoH = $ticketH + $rowH;
                generateData($pdf, $ticketW, $infoH, $ticketW, $ticket);
            }else{
                generateLine($pdf, 1, 1, $startW, $ticketW, $startH, $ticketH);
                $infoH = $ticketH + $rowH;
                generateData($pdf, $startW, $infoH, $ticketW, $ticket);
            }
        }else{
            $pdf->ezNewPage();
            $startH = $h-$startW;
            $ticketH = $startH;
            $ticketH-=$rowH;
            generateLine($pdf, 1, 1, $startW, $ticketW, $startH, $ticketH);
            $infoH = $ticketH + $rowH;
            generateData($pdf, $startW, $infoH, $ticketW, $ticket);
            $ticketCtr = 1;
        }
    }
    $pdf->ezStream();
?>