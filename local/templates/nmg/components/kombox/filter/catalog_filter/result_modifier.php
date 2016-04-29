<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
    //сортировка полей фильтра. Сначала отмеченные поля, потом все остальные. Неотмеченные сортируются по алфавиту
    function cmp($a, $b)
    {
        if(!$a["CHECKED"] && !$b["CHECKED"]){
            if ($a["VALUE"] == $b["VALUE"]) {
                return 0;
            }
            return ($a["VALUE"] < $b["VALUE"]) ? -1 : 1; 
        }else{
            if ($a["CHECKED"] == $b["CHECKED"]) {
                return 0;
            }
            return ($a["CHECKED"] > $b["CHECKED"]) ? -1 : 1; 
        } 
    }

?>
<?
    $checkSection = false;
    if ($arResult["SECTION"]["ID"] > 0) {
        $section = CIBlockSection::GetList(array(),array("ID"=>$arResult["SECTION"]["ID"]))->Fetch();  
        if ($section["DEPTH_LEVEL"] == 1) {
            $checkSection = true;  
        }
    }


    $propNames = array();
    $propVals = array();

    foreach ($arResult["ITEMS"] as $key=>$arItem) {
        $propNames[$arItem["CODE_ALT"]] = $arItem["NAME"];

        //в разделах первого уровня оставляем только 3 свойства - цена, производитель и тип товара
        if ($checkSection) {
            //arshow($arItem,true); 
            if ($checkSection && $arItem["CODE"] != "PROIZVODITEL" && $arItem["CODE"] != "TIP_TOVARA" && $arItem["CODE_ALT"] != "price") {
                unset($arResult["ITEMS"][$key]); 
                continue ;
            }
        }

        //сортировка полей фильтра
        uasort($arItem["VALUES"], "cmp"); 
        $select = 0;  
        foreach ($arItem["VALUES"] as $val=>$ar){
            $propVals[$arItem["CODE_ALT"]][$ar["HTML_VALUE_ALT"]] = $ar["VALUE"];

            if($ar["CHECKED"]){
                $select++;
            }
        } 
        $arItem["SELECTED_ITEMS"] = $select;
        $arResult["ITEMS"][$key] = $arItem;  

        // $arResult["ELEMENT_COUNT"]["1493"][$key] = $arItem;
    }


    // arshow($arResult["ITEMS"],true);

    //добавление хлебных крошек. доработка в шаблоне catalog.section, а вывод в section.php
    $request = $arResult["REQUEST"];
    krsort($request);
    reset($request);
    $url = $APPLICATION->GetCurPage()."filter/";

    unset($_SESSION["additionalNavChain"]);

    foreach ($request as $prop=>$vals) {
        if ((is_array($vals) && count($vals) > 1) || substr_count($prop,"price") > 0 /*|| (substr_count($prop,"proizvoditel") <=0 && substr_count($prop,"tip") <=0)*/) {
            continue;
        }
        else {

            foreach ($vals as $val){
                $v = $val; 
            }
            $url .= $prop."-".$v."/";
            $_SESSION["additionalNavChain"][] = array(
                "NAME"=> $propVals[$prop][$v],
                "URL"=> $url
            );                      
        }
    }


?>