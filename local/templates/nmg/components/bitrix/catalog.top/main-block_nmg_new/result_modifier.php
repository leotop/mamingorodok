<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    $arResult["TD_WIDTH"] = round(100/$arParams["LINE_ELEMENT_COUNT"])."%";
    $arResult["nRowsPerItem"] = 1; //Image, Name and Properties
    $arResult["bDisplayPrices"] = false;
    foreach($arResult["ITEMS"] as $arItem)
    {
        if(count($arItem["PRICES"])>0 || is_array($arItem["PRICE_MATRIX"]))
            $arResult["bDisplayPrices"] = true;
        if($arResult["bDisplayPrices"])
            break;
    }
    if($arResult["bDisplayPrices"])
        $arResult["nRowsPerItem"]++; // Plus one row for prices
    $arResult["bDisplayButtons"] = $arParams["DISPLAY_COMPARE"] || count($arResult["PRICES"])>0;
    foreach($arResult["ITEMS"] as $arItem)
    {
        if($arItem["CAN_BUY"])
            $arResult["bDisplayButtons"] = true;
        if($arResult["bDisplayButtons"])
            break;
    }
    if($arResult["bDisplayButtons"])
        $arResult["nRowsPerItem"]++; // Plus one row for buttons

    //array_chunk
    $arResult["ROWS"] = array();
    while(count($arResult["ITEMS"])>0)
    {
        $arRow = array_splice($arResult["ITEMS"], 0, $arParams["LINE_ELEMENT_COUNT"]);
        while(count($arRow) < $arParams["LINE_ELEMENT_COUNT"])
            $arRow[]=false;
        $arResult["ROWS"][]=$arRow; 
    }

    $sectionList = array();
    $sections = CIBlockSection::GetList(array(),array("IBLOCK_ID"=>$arParams["IBLOCK_ID"]),false,array("ID","NAME","IBLOCK_SECTION_ID"));
    while($arSection = $sections->Fetch()) {
        $sectionList[$arSection["ID"]] = $arSection;
    }
    
    //arshow($sectionList,true);

    foreach($arResult["ROWS"] as $arItems)
    {          
        foreach($arItems as $intCnt => $arElement)
        {                                      

            //arshow($ar_rezz['IBLOCK_SECTION_ID']);
            $arResult['ShowElements'][$sectionList[$arElement['IBLOCK_SECTION_ID']]['IBLOCK_SECTION_ID']][]= $arElement;
            //$arResult['ShowSecName'][$ar_rezz['IBLOCK_SECTION_ID']] = $ar_rezz['NAME'];

            $arResult['ShowSecName'][$sectionList[$arElement['IBLOCK_SECTION_ID']]['IBLOCK_SECTION_ID']] =  $sectionList[$arElement['IBLOCK_SECTION_ID']]['NAME'];
        }
    }                        
?>
