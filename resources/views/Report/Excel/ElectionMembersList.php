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
    $normalC->setTextWrap();
    $normalC->setLocked();
    $normalC->setBorder(1);
    
    $normalR = $xls->addFormat(array('Size' => 10));
    $normalR->setFontFamily('Arial');
    $normalR->setAlign("right");
    $normalR->setAlign("vcenter");
    $normalR->setTextWrap();
    $normalR->setBold();
    $normalR->setLocked();
    $normalR->setBorder(1);

    $title = "Election Members List";
    $sheet = $xls->addWorksheet($title);
    $xls->send($title.".xls");

    $fields = array(
        array('Pb No',15),
        array('Member ID',15),
        array('NAME',25),
        array('BIRTHDATE',15),
        array('AGE',15),
        array('AGE BRACKET',15),
        array('BRANCH',15),
        array('VOTE METHOD',15),
        array('DATE VOTED',15),
        array('ISSUED BY',15),
        array('DATE RECEIVED',15),
    );

    $c = $r = 0;
    $rowHeaderH = 24;
    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;

    foreach($electionMemberList as $data){
        $c = 0;
        $sheet->writeString($r,$c,$data["pbno"],$normalC);$c++;
        $sheet->writeString($r,$c,$data["memberId"],$normalC);$c++;
        $sheet->write($r,$c,$data["name"],$normal);$c++;
        $sheet->write($r,$c,$data["birthdate"],$normalC);$c++;
        $sheet->write($r,$c,$data["age"],$normalC);$c++;
        $sheet->write($r,$c,$data["ageBracket"],$normalC);$c++;
        $sheet->write($r,$c,$data["branch"],$normalC);$c++;
        $sheet->write($r,$c,$data["voteMethod"],$normalC);$c++;
        $sheet->write($r,$c,$data["dateVoted"],$normalC);$c++;
        $sheet->write($r,$c,$data["issuedBy"],$normalC);$c++;
        $sheet->write($r,$c,$data["dateReceived"],$normalC);$c++;
        $r++;
    }
    
    $xls->close();
    die;
?>
    