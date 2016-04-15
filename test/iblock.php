<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?      /*
    //скрипт связи элементов ИБ
    $emptyFROM = array();  //элементы в новом ИБ без артикулов
    $emptyTO = array();
    $elsFROM = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>26), false, false, array("PROPERTY_CML2_ARTICLE","ID","NAME","XML_ID"));
    echo "всего элементов в ИБ 26: ".$elsFROM->SelectedRowsCount();
    //собираем элементы из нового ИБ
    while($arElsFrom = $elsFROM->Fetch()) {
        //arshow($arElsFrom);
        //если у элемента нет артикула - записываем его в спец. массив
        if (!$arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]) {
            $emptyFROM[$arElsFrom["ID"]] = $arElsFrom["NAME"];   
        }
        //если артикул есть - пытаемся найти в старом ИБ соответствующий товар          
        else {
            $elTO = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>2,"PROPERTY_ARTICUL"=>$arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]), false, false, array("ID"));  
            //если нашли товар с совпадающим артикулом, перезаписываем у него внешний код
            if($arElTo = $elTO->Fetch()) {
                $el = new CIBlockElement;                

                $arLoadProductArray = Array(
                    "XML_ID" => $arElsFrom["XML_ID"]
                );        
              //  $res = $el->Update($arElTo["ID"], $arLoadProductArray);    
            }
            //если товар не нашли, пишем артикул в соответствующий массив
            else {
                $emptyTO[$arElsFrom["ID"]] = $arElsFrom["PROPERTY_CML2_ARTICLE_VALUE"]; 
            }       

        }     
    }
    echo "<br>элементов без артикулов в ИБ 26: ".count($emptyFROM)."<br>";
    arshow($emptyFROM);
    echo "<br>элементов не найдено в ИБ 2: ".count($emptyTO)."<br>";
    arshow($emptyTO); 
    */
    
    //элементы из ИБ 2, которые не обновились 12.03
    
    $notUpdate = array();
    $els = CIBLockElement::GetList(array(), array("IBLOCK_ID"=>2, "<=TIMESTAMP_X"=>date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT")), mktime(0,0,0,03,12,2015))), false, false, array("ID","PROPERTY_ARTICUL"));
    while($arElement = $els->Fetch()) {
       $notUpdate[$arElement["ID"]] = $arElement["PROPERTY_ARTICUL_VALUE"];
    }
    echo "не обновлено элементов: ".count($notUpdate);
    arshow($notUpdate);
?>