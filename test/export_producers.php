<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
 <a href="catalog.csv">скачать файл</a>
<?


    $sectionID = array();
    //собирам разделы каталога
    $sections = CIBlockSection::GetTreeList( array("IBLOCK_ID"=>2));
    while($arSection = $sections->Fetch()) {
        $sectionID[$arSection["ID"]] = $arSection["CODE"];  
    }

    $list = array('"Внешний код";"Производитель"');

    $els = CIBLockElement::GetList(array(), array("IBLOCK_ID"=>2), false, false, array("XML_ID", "PROPERTY_CH_PRODUCER"));
    while($arElement = $els->Fetch()) {
        if ($arElement["PROPERTY_CH_PRODUCER_VALUE"] != "") { 
        $manufact=CIBlockElement::GetList(array(), array("IBLOCK_ID"=>5,"ID"=>$arElement["PROPERTY_CH_PRODUCER_VALUE"]), false, false, array("NAME"));
        while ($arProducers=$manufact->Fetch()) { 
        $list[] = $arElement["XML_ID"].";".$arProducers["NAME"];
        }
    }
    }
  //  arshow($list);
    /* 
    $list = array (
    'aaa,bbb,ccc,dddd',
    '123,456,789',
    '"aaa","bbb"'
    );      */


                                 
    $fp = fopen($_SERVER["DOCUMENT_ROOT"].'/test/producers.csv', 'w');

    foreach ($list as $line) {
        fputcsv($fp, explode(';', $line),";");
    }

    fclose($fp);



?>