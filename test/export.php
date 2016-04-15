<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
 <a href="catalog.csv">скачать файл</a>
<?


    $sectionID = array();
    //собирам разделы каталога
    $sections = CIBlockSection::GetTreeList( array("IBLOCK_ID"=>2));
    while($arSection = $sections->Fetch()) {
        $sectionID[$arSection["ID"]] = $arSection["CODE"];  
    }

    $list = array('"ID";"Название";"Ссылка"');

    $els = CIBLockElement::GetList(array(), array("IBLOCK_ID"=>2), false, false, array("ID","CODE","IBLOCK_SECTION_ID","NAME"));
    while($arElement = $els->Fetch()) {
        $list[] = $arElement["ID"].";".$arElement["NAME"].";http://test2.mamingorodok.ru/catalog/".$sectionID[$arElement["IBLOCK_SECTION_ID"]]."/".$arElement["CODE"]."/";
    }

    arshow($list);
    /* 
    $list = array (
    'aaa,bbb,ccc,dddd',
    '123,456,789',
    '"aaa","bbb"'
    );      */


                                 
    $fp = fopen($_SERVER["DOCUMENT_ROOT"].'/test/catalog.csv', 'w');

    foreach ($list as $line) {
        fputcsv($fp, explode(';', $line),";");
    }

    fclose($fp);



?>