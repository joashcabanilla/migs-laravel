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

    $title = "Election Summary";
    $sheet = $xls->addWorksheet($title);
    $xls->send($title.".xls");

    $fields = array(
        array('Pb No',20),
        array('Member ID',20),
        array('First Name',20),
        array('Middle Name',20),
        array('Last Name',20),
        array('BIRTHDATE',20),
        array('BRANCH',20),
        array('VOTE METHOD',20),
        array('DATE',20)
    );

    $c = $r = 0;
    $fieldCount =  count($fields)-1;
    $rowHeaderH = 20;
    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"ELECTION SUMMARY",$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r++;

    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"TOTAL VOTED: ".number_format(count($electionSummary)),$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r++;

    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"AS OF ".$DateTime,$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r+=2;

    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;

    foreach($electionSummary as $data){
        $c = 0;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->writeString($r,$c,$data["pbno"],$normalC);$c++;
        $sheet->writeString($r,$c,$data["memberId"],$normalC);$c++;
        $sheet->write($r,$c,$data["firstName"],$normal);$c++;
        $sheet->write($r,$c,$data["MiddleName"],$normal);$c++;
        $sheet->write($r,$c,$data["LastName"],$normal);$c++;
        $sheet->write($r,$c,$data["birthdate"],$normalC);$c++;
        $sheet->write($r,$c,$data["branch"],$normalC);$c++;
        $sheet->write($r,$c,$data["voteMethod"],$normalC);$c++;
        $sheet->write($r,$c,$data["dateTime"],$normalC);$c++;
        $r++;
    }
    
    $xls->close();
    die;
?>
    