<?php
    error_reporting(0);
    require_once(app_path('Includes/excel/spreadsheet/Writer.php'));
    $xls = new Spreadsheet_Excel_Writer();
    $header = $xls->addFormat(array('Size' => 12));
    $header->setLocked();
    $header->setBold();
    $header->setFontFamily('Arial');
    $header->setAlign("center");
    $header->setAlign("vcenter");

    $subheader = $xls->addFormat(array('Size' => 10));
    $subheader->setLocked();
    $subheader->setFontFamily('Arial');
    $subheader->setAlign("center");
    $subheader->setAlign("vcenter");
 
    $subheaderB = $xls->addFormat(array('Size' => 10));
    $subheaderB->setLocked();
    $subheaderB->setFontFamily('Arial');
    $subheaderB->setAlign("center");
    $subheaderB->setAlign("vcenter");
    $subheaderB->setBold();

    $subheaderName = $xls->addFormat(array('Size' => 10));
    $subheaderName->setLocked();
    $subheaderName->setFontFamily('Arial');
    $subheaderName->setAlign("left");
    $subheaderName->setAlign("vcenter");
    $subheaderName->setBold();

    $normal = $xls->addFormat(array('Size' => 10));
    $normal->setFontFamily('Arial');
    $normal->setAlign("left");
    $normal->setAlign("vcenter");
    $normal->setTextWrap();
    $normal->setLocked();
    
    $normalC = $xls->addFormat(array('Size' => 10));
    $normalC->setFontFamily('Arial');
    $normalC->setAlign("center");
    $normalC->setAlign("vcenter");
    $normalC->setLocked();
    
    $normalR = $xls->addFormat(array('Size' => 10));
    $normalR->setFontFamily('Arial');
    $normalR->setAlign("right");
    $normalR->setAlign("vcenter");
    $normalR->setBold();
    $normalR->setLocked();

    $title = "GA Items Summary";
    $sheet = $xls->addWorksheet($title);
    $xls->send($title.".xls");

    $fields = array(
        array('#',10),
        array('Subject Code',20),
        array('Subject Description',40),
        array('Section Code',20),
        array('Units',10),
        array('Hours',10),
        array('Schedule',40),
        array("Student Count",15),
        array("Rooms",15)
    );

    $c = $r = 0;
    $fieldCount =  count($fields)-1;
    $rowHeaderH = 20;
    // $sheet->setRow($r,$rowHeaderH);
    // $sheet->write($r,$c,$schoolName,$header);    
    // $sheet->mergeCells($r,$c,$r,$fieldCount);
    // $r++;

    // $sheet->setRow($r,$rowHeaderH);
    // $sheet->write($r,$c,$schoolAddress,$subheader);    
    // $sheet->mergeCells($r,$c,$r,$fieldCount);
    // $r+=2;

    // $sheet->setRow($r,$rowHeaderH);
    // $sheet->write($r,$c,$title,$header);    
    // $sheet->mergeCells($r,$c,$r,$fieldCount);
    // $r++;

    // $sheet->setRow($r,$rowHeaderH);
    // $sheet->write($r,$c,"Date Printed ".$datePrinted,$subheader);    
    // $sheet->mergeCells($r,$c,$r,$fieldCount);
    // $r+=2;

    // foreach($fields as $fieldinfo):
    //     list($caption,$colwidth) = $fieldinfo;
    //     $sheet->setRow($r,$rowHeaderH);
    //     $sheet->setColumn($c,$c,$colwidth);
    //     $sheet->write($r,$c,$caption,$subheaderB);$c++;
    // endforeach;
    // $r++;
    // $counter = 1;
    // foreach($reportData as $facultyName => $facultyLoad){
    //     $c = 0;
    //     list($fName,$fCode) = explode("|",$facultyName);
    //     $sheet->setRow($r,$rowHeaderH);
    //     $sheet->write($r,$c,$counter,$subheaderB);$c++;
    //     $sheet->write($r,$c," ".$fCode . "    " .$fName,$subheaderName);$c++;
    //     $counter++;
    //     $r++;

    //     $totalUnits = 0;
    //     $totalHours = 0;

    //     foreach($facultyLoad as $flData){
    //         $c = 1;
    //         if(strlen($flData['SubjDesc']) <= 50){
    //             $sheet->setRow($r,$rowHeaderH);
    //         }
    //         $sheet->write($r,$c,$flData['SubjCode'],$normalC);$c++;
    //         $sheet->write($r,$c,$flData['SubjDesc'],$normal);$c++;
    //         $sheet->write($r,$c,$flData['SectCode'],$normal);$c++;
    //         $sheet->write($r,$c,$flData['Units'],$normalC);$c++;
    //         $sheet->write($r,$c,$flData['Hours'],$normalC);$c++;
    //         $sheet->write($r,$c,$flData['Schedule'],$normal);$c++;
    //         $sheet->write($r,$c,$flData['StudentCount'],$normalC);$c++;
    //         $sheet->write($r,$c,$flData['Rooms'],$normalC);$c++;
    //         $r++;
    //         $totalUnits += $flData['Units'];
    //         $totalHours += $flData['Hours'];
    //     }
    //     $c = 3;
    //     $sheet->setRow($r,$rowHeaderH);
    //     $sheet->write($r,$c,"Total:",$normalR);$c++;
    //     $sheet->write($r,$c,$totalUnits,$subheaderB);$c++;
    //     $sheet->write($r,$c,$totalHours,$subheaderB);$c++;
    //     $r++;
    // }
    $xls->close();
    die;
?>
    