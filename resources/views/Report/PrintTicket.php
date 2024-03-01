<?php
    $pdf = new App\Includes\Cezpdf("LONG","PORTRAIT");
    $pdf->selectFont('Includes/fonts/Calibri.afm');
    $h = $pdf->ez['pageHeight'];
    $w = $pdf->ez['pageWidth'];
    $fontSize = 13;
    $margin = $pdf->C2P(0.5);
    $row = $pdf->C2P(0.5);
    $hT = $h-$margin;
    $wT = $w-($margin*2);
    $pdf->addInfo('Title',strtoupper("TICKETS PRINTING"));
    
    foreach($ticketList as $branch => $ticket){
        dd($ticket);
    }
    $pdf->ezStream();
?>