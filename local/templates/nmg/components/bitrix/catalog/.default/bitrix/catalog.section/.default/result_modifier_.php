<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!CModule::IncludeModule("forum"))
	return;
?>
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



foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arItem["ID"]), true);

	$arResult["ITEMS"][$k]["COUNT_REPORTS"] = $ar_res;
	
	$qq = 0;
	$arFilter = Array(   
		"IBLOCK_ID"=>OFFERS_IBLOCK_ID,    
		"ACTIVE"=>"Y", 
		"PROPERTY_MAIN_PRODUCT"=>$arItem["ID"]
	);
	//print_R($arFilter);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
	while($ar_fields = $res->GetNext()){  
		//print_R($ar_fields);
		$ar_res = CCatalogProduct::GetByID($ar_fields["ID"]);
		if($ar_res["QUANTITY"]>0)
			$qq++;
		}
	$arResult["ITEMS"][$k]["COUNT_SKLAD"] = $qq;
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


//print_R($arParams["SECTION_ID"]);

//print_r($v);
if(intval($arParams["SECTION_ID"])>0){
	 $arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'ID'=>$arParams["SECTION_ID"]);
	 $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("UF_HARACTERISTICS","UF_DESCRIPTION","UF_TITLE","UF_KEYWORDS"));
	 while($ar_result = $db_list->GetNext())  {
		//$arResult["PROPERTY"] = $ar_result["NAME"];
		$arResult["UF_HARACTERISTICS"] = $ar_result["UF_HARACTERISTICS"];
		$arMeta["UF_DESCRIPTION"] = $ar_result["UF_DESCRIPTION"];
		$arMeta["UF_TITLE"] = $ar_result["UF_TITLE"];
		$arMeta["UF_KEYWORDS"] = $ar_result["UF_KEYWORDS"];
		//print_r($ar_result["UF_HARACTERISTICS"]);
	}
	if(isset($arMeta) && is_object($this->__component))
	{
		$this->__component->arResult["META"] = $arMeta;
		$this->__component->SetResultCacheKeys(array("META"));
	}
}

?>
