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
		$price = 0;
		$db_res2 = CPrice::GetList(
        array(),
        array(
                "PRODUCT_ID" => $ar_fields["ID"]
            )
			);
		if ($ar_res2 = $db_res2->Fetch())
		{
			$price = intval($ar_res2["PRICE"]);
		}
		if($ar_res["QUANTITY"]>0 && $price >0)
			$qq++;
		}
	$arResult["ITEMS"][$k]["COUNT_SKLAD"] = $qq;
}

if($arResult["bDisplayPrices"])
	$arResult["nRowsPerItem"]++; // Plus one row for prices
$arResult["bDisplayButtons"] = $arParams["DISPLAY_COMPARE"] || count($arResult["PRICES"])>0;
foreach($arResult["ITEMS"] as $arItem)
{
	$allpar[] = $arItem["ID"];
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


	if(isset($allpar) && is_object($this->__component))
	{
		$this->__component->arResult["ALLELEMENT"] = $allpar;
		//$this->__component->arResult["META"] = $arResult["META"];
		$this->__component->SetResultCacheKeys(array("ALLELEMENT"));
	}


?>
