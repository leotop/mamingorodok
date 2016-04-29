<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $current_section_id=$arParams["SECTION_ID"];
    $current_iblock_id=$arParams["IBLOCK_ID"];
    // название текущей секции (для вывода в блоке "Ваш выбор")
    if($current_section_id > 0) {
        $res = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $current_iblock_id, "ID" => $current_section_id), false);
        if($arSect = $res->GetNext()) {
            $current_section_name = $arSect["NAME"];
            $parent_section_id = $arSect["IBLOCK_SECTION_ID"];
        }
        //echo $parent_section_id;
        $arResult["current_section_name"] = $current_section_name;
        $arResult["parent_section_id"] = $parent_section_id;
    }
    
    // получаем инфу о родительском разделе
    if($arParams["CURRENT_CATALOG_LEVEL"] == 2)
    {
        $rsSec = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>$current_iblock_id, "ID"=>$arResult["parent_section_id"], "ACTIVE"=>"Y"), false);
        if($arSec = $rsSec -> GetNext())
            $arResult["PARENT_SECTION_URL"] = $arSec["SECTION_PAGE_URL"];
    } else $arResult["PARENT_SECTION_URL"] = '/catalog/';