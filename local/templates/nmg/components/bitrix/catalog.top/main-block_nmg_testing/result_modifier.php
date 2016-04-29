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
foreach($arResult["ROWS"] as $arItems)
    {          
        foreach($arItems as $intCnt => $arElement)
        {                                      
            $rezz = CIBlockSection::GetByID($arElement["IBLOCK_SECTION_ID"]);
            if ($ar_rezz = $rezz->GetNext()){
                //arshow($ar_rezz['IBLOCK_SECTION_ID']);
                $arResult['ShowElements'][$ar_rezz['IBLOCK_SECTION_ID']][]=$arElement;
                //$arResult['ShowSecName'][$ar_rezz['IBLOCK_SECTION_ID']] = $ar_rezz['NAME'];
                $rezult = CIBlockSection::GetByID($ar_rezz['IBLOCK_SECTION_ID']);
                if ($ar_rezult = $rezult -> GetNext()){ 
                    $arResult['ShowSecName'][$ar_rezz['IBLOCK_SECTION_ID']] = $ar_rezult['NAME'] ;
                }      
            }   
        }
    }                        
?>
