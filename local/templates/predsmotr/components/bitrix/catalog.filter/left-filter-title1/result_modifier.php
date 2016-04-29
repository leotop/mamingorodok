<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(isset($_REQUEST["FILTER_PARAM"])){
	$sort2="PROPERTY_PRICE";
	$arrFilter =array();
	if(strpos($_REQUEST["FILTER_PARAM"],"?") !== false){
		$param = explode("?",$_REQUEST["FILTER_PARAM"]);
		$_REQUEST["FILTER_PARAM"] = $param[0];
	}
	$sort1 = "SORT";
	if($_REQUEST["FILTER_PARAM"]=="new"){
		$arrFilter["PROPERTY_NEW_VALUE"] = "Y";

	}
	elseif($_REQUEST["FILTER_PARAM"]=="sale"){
		$arrFilter[">PROPERTY_OLD_PRICE"] = "0";
	}
	elseif($_REQUEST["FILTER_PARAM"]=="popular"){
		$sort1 = "PROPERTY_SALE_RATING";
		$arrFilter[">=PROPERTY_SALE_RATING"] = "0";

	}
	elseif($_REQUEST["FILTER_PARAM"]=="desired"){
		$sort1 = "PROPERTY_WISH_RATING";
		$arrFilter[">PROPERTY_WISH_RATING"] = "0";
	}
	
}

//мин цена
$arFilter = Array(   "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", ">PROPERTY_PRICE"=>"0" );
$arFilter = array_merge($arFilter,$arrFilter);

$res = CIBlockElement::GetList(Array($sort1=>"DESC", $sort2=>"ASC"), $arFilter, false, Array("nPageSize"=>1), array("PROPERTY_PRICE"));

if($ar_fields = $res->GetNext()){ 
	//print_R($ar_fields);
	$arResult["MIN_PRICE"] = $ar_fields["PROPERTY_PRICE_VALUE"];
}

//макс цена
$arFilter = Array(   "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", ">PROPERTY_PRICE"=>"0" );
$arFilter = array_merge($arFilter,$arrFilter);
$res = CIBlockElement::GetList(Array($sort2=>"DESC",$sort1=>"DESC"), $arFilter, false, Array("nPageSize"=>1), array("PROPERTY_PRICE"));

if($ar_fields = $res->GetNext()){ 
	$arResult["MAX_PRICE"] = $ar_fields["PROPERTY_PRICE_VALUE"];
}

//производители
$arFilter = Array( "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y" );
$arFilter = array_merge($arFilter,$arrFilter);
$res = CIBlockElement::GetList(Array($sort1=>"DESC", $sort2=>"DESC"), $arFilter, false, false, array("PROPERTY_CH_PRODUCER","PROPERTY_PRICE"));

$arResult["PRODUCER"] = array();
$tempP = array();
while($ar_fields = $res->GetNext()){ 
	
	if(!in_array($ar_fields["PROPERTY_CH_PRODUCER_VALUE"],$tempP)){
		$tempP[] = $ar_fields["PROPERTY_CH_PRODUCER_VALUE"];
		$arFilter = Array(   "IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ID"=>$ar_fields["PROPERTY_CH_PRODUCER_VALUE"] );
		$res2 = CIBlockElement::GetList(Array($sort1=>"DESC"), $arFilter, false, false, array("ID", "NAME"));
		if($ar_fields2 = $res2->GetNext()){ 	
			$arResult["PRODUCER"][] = $ar_fields2;
			
		}
	}
	if(isset($arResult["PRODUCERS"][$ar_fields["PROPERTY_CH_PRODUCER_VALUE"]][$ar_fields["PROPERTY_PRICE_VALUE"]]))
		$arResult["PRODUCERS"][$ar_fields["PROPERTY_CH_PRODUCER_VALUE"]][$ar_fields["PROPERTY_PRICE_VALUE"]]++ ;
	else
		$arResult["PRODUCERS"][$ar_fields["PROPERTY_CH_PRODUCER_VALUE"]][$ar_fields["PROPERTY_PRICE_VALUE"]] = 1;
}

//print_R($arResult["PRODUCERS"]);
//цены
$arFilter = Array( "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y" );
$arFilter = array_merge($arFilter,$arrFilter);
$res = CIBlockElement::GetList(Array($sort1=>"DESC", $sort2=>"DESC"), $arFilter, false, false, array("PROPERTY_PRICE"));
while($ar_fields = $res->GetNext()){ 
	$arResult["PRICES"][] = '"'.$ar_fields["PROPERTY_PRICE_VALUE"].'"';
}

//$arResult["PRICES"] = array_unique($arResult["PRICES"]);
$arResult["PRICES"] = implode(", ",$arResult["PRICES"]);


//подсказки
foreach($arResult["arrProp"] as $k=>$v){
	$arFilter = Array(   "IBLOCK_ID"=>HINTS_IBLOCK_ID, "PROPERTY_PROP"=>$k );
	$res2 = CIBlockElement::GetList(Array($sort1=>"DESC"), $arFilter, false, false, array("ID","NAME","PREVIEW_TEXT"));
	if($ar_fields2 = $res2->GetNext()){ 
		$ar_fields2["KEY"] = $k;
		$arResult["HINTS"][$v["CODE"]] = $ar_fields2;
	}
}


?>
