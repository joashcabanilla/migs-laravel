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

    $title = "GA Items Summary";
    $sheet = $xls->addWorksheet($title);
    $xls->send($title.".xls");

    $fields = array(
        array('USERNAME',40),
        array('BRANCH',40),
        array('VOTE METHOD',20),
        array('TOTAL REGISTERED',20),
        array('DATE',20)
    );

    $c = $r = 0;
    $fieldCount =  count($fields)-1;
    $rowHeaderH = 20;
    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"GA ITEMS SUMMARY REPORT",$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r++;

    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"TOTAL REGISTERED: " . number_format(count($memberList)),$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r++;

    $sheet->setRow($r,$rowHeaderH);
    $sheet->write($r,$c,"AS OF " . $DateTime,$header);    
    $sheet->mergeCells($r,$c,$r,$fieldCount);
    $r+=2;

    foreach($fields as $fieldinfo):
        list($caption,$colwidth) = $fieldinfo;
        $sheet->setRow($r,$rowHeaderH);
        $sheet->setColumn($c,$c,$colwidth);
        $sheet->write($r,$c,$caption,$subheaderB);$c++;
    endforeach;
    $r++;

    foreach($SummaryReport as $username => $voteMethod){
        foreach($voteMethod as $method => $dates){
            foreach($dates as $date => $count){
                $c = 0;
                $sheet->setRow($r,$rowHeaderH);
                $sheet->write($r,$c,$username,$normal);$c++;
                $sheet->write($r,$c,$branchUserList[$username],$normalC);$c++;
                $sheet->write($r,$c,$method,$normalC);$c++;
                $sheet->write($r,$c,number_format(count($count)),$normalC);$c++;
                $sheet->write($r,$c,$date,$normalC);$c++;
                $r++;
            }
        }
    }
    $xls->close();
    die;
?>
    