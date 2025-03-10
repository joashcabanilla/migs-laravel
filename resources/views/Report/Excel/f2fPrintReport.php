<?php
    error_reporting(0);
    require_once(app_path('Includes/excel/spreadsheet/Writer.php'));
    $xls = new Spreadsheet_Excel_Writer();
    $header = $xls->addFormat(array('Size' => 11));
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
    $subheaderB->setBorder(1);

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
    $normal->setBorder(1);
    
    $normalC = $xls->addFormat(array('Size' => 10));
    $normalC->setFontFamily('Arial');
    $normalC->setAlign("center");
    $normalC->setAlign("vcenter");
    $normalC->setLocked();
    $normalC->setBorder(1);
    
    $normalR = $xls->addFormat(array('Size' => 10));
    $normalR->setFontFamily('Arial');
    $normalR->setAlign("right");
    $normalR->setAlign("vcenter");
    $normalR->setBold();
    $normalR->setLocked();
    $normalR->setBorder(1);

    $title = "ELECTION";
    $sheet = $xls->addWorksheet($title);
    $xls->send($title.".xls");

    $fields = array(
        array('PB NO',20),
        array('MEMBER ID',20),
        array('MEMBER NAME',35),
        array('BIRTHDATE',20),
        array('CANDIDATE',35)
    );

    $c = $r = 0;
    $fieldCount =  count($fields)-1;
    $rowHeaderH = 20;
    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"ELECTION REPORT",$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r++;

    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;

    foreach($election as $data){
        $c = 0;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->write($r,$c,$data["pbno"],$normal);$c++;
        $sheet->write($r,$c,$data["memberId"],$normalC);$c++;
        $sheet->write($r,$c,$data["memberName"],$normalC);$c++;
        $sheet->write($r,$c,$data["birthdate"],$normalC);$c++;
        $sheet->write($r,$c,$data["candidate"],$normalC);$c++;
        $r++;
    }

    $r++;
    foreach($count as $candidate => $count){
        $c = 0;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->write($r,$c,$candidate,$normal);$c++;
        $sheet->write($r,$c,number_format(count($count)),$normalC);$c++;
        $r++;
    }
    $xls->close();
    die;
?>
    