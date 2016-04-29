<?
if (!CModule::IncludeModule("forum")) return false;

$arSelect = array(
    "ID", 
    "IBLOCK_ID", 
    "NAME", 
    "DETAIL_PICTURE", 
    "PROPERTY_OLD_PRICE", 
    "PROPERTY_IMG_BIG", 
    "PROPERTY_SIZE", 
    "PROPERTY_COLOR_CODE", 
    "PROPERTY_COLOR_IMAGE",
    "PROPERTY_COLOR",
    "PROPERTY_ARTICUL",
    "PROPERTY_PICTURE_MINI",
    "PROPERTY_PICTURE_MIDI",
    "PROPERTY_PICTURE_MAXI",
	"CATALOG_GROUP_1"
);


$arResult["COLORS_HAS_SAME_PRICE"] = true;
$arResult["START_OFFERS_BY_SIZE"] = array();
$tmpPrice = 0;
$floatMinPrice = 100000000;
$arOffers = array();
$arResult["CS"] = array();
$arResult["SIZE_AVAIL"] = array();
$rsOffers = CIBlockElement::GetList(array("PROPERTY_SERVICE_QSORT"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MAIN_PRODUCT"=>$arResult["ID"]), false, false, $arSelect);
while($arOffer = $rsOffers -> Getnext())
{
	$arOffer["CATALOG_QUANTITY"] = 2; // всегда в наличии
	
	$arOffer["PRICE"] = CCatalogProduct::GetOptimalPrice($arOffer["ID"], 1, $USER->GetUserGroupArray());
	
	if(!isset($arResult["CS"][$arOffer["PROPERTY_SIZE_VALUE"]]["AVAIL"])) $arResult["CS"][$arOffer["PROPERTY_SIZE_VALUE"]]["AVAIL"] = array();
	if(!isset($arResult["CS"][$arOffer["PROPERTY_SIZE_VALUE"]]["NAVAIL"])) $arResult["CS"][$arOffer["PROPERTY_SIZE_VALUE"]]["NAVAIL"] = array();
	
	if($arOffer["PRICE"]["PRICE"]["PRICE"] <= 0)
		$arOffer["CATALOG_QUANTITY"] = 0;
	elseif($arResult["COLORS_HAS_SAME_PRICE"]) {
		if($tmpPrice == 0)
			$tmpPrice = $arOffer["PRICE"]["PRICE"]["PRICE"];
		elseif($tmpPrice != $arOffer["PRICE"]["PRICE"]["PRICE"])
			$arResult["COLORS_HAS_SAME_PRICE"] = false;
	}
	
	$arResult["CS"][$arOffer["PROPERTY_SIZE_VALUE"]][($arOffer["CATALOG_QUANTITY"]>0?"AVAIL":"NAVAIL")][$arOffer["PROPERTY_COLOR_CODE_VALUE"]] = $arOffer;
	
	if($arOffer["CATALOG_QUANTITY"]>0) $arResult["SIZE_AVAIL"][$arOffer["PROPERTY_SIZE_VALUE"]] = 'Y';
	
	if($floatMinPrice>$arOffer["PRICE"]["PRICE"]["PRICE"] && (!isset($arResult["START_SIZE"]) || $arOffer["CATALOG_QUANTITY"]>0) && $arOffer["PRICE"]["PRICE"]["PRICE"]>0)
	{
		$floatMinPrice = $arOffer["PRICE"]["PRICE"]["PRICE"];
		$arResult["START_SIZE"] = $arOffer['PROPERTY_SIZE_VALUE'];
		$arResult["START_COLOR"] = $arOffer["PROPERTY_COLOR_CODE_VALUE"]; // dont need
	}
		
	if(
		!isset($arResult["START_OFFERS_BY_SIZE"][$arOffer['PROPERTY_SIZE_VALUE']])
			||
		(
			$arResult["START_OFFERS_BY_SIZE"][$arOffer['PROPERTY_SIZE_VALUE']]["PRICE"]["PRICE"]["PRICE"]>$arOffer["PRICE"]["PRICE"]["PRICE"]
				&&
			$arOffer["CATALOG_QUANTITY"]>0
		)
	)
		$arResult["START_OFFERS_BY_SIZE"][$arOffer['PROPERTY_SIZE_VALUE']] = $arOffer;
}

ksort($arResult["CS"]);
foreach($arResult["CS"] as $strSize => $arData)
{
	$arResult["CS"][$strSize] = array_merge($arData["AVAIL"], $arData["NAVAIL"]);
}

/*$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MAIN_PRODUCT"=>$arResult["ID"]), false, false, $arSelect);    
while($obEl = $dbEl->GetNext())    
{
    $arBasePrice = CPrice::GetBasePrice($obEl["ID"], false, false); // обязательно false false!!
	$pr = explode(".", $arBasePrice["PRICE"]);
	if(isset($pr[1]))
	{
		$pr2 = intval($pr[1]);
		if($pr2==0)
			$arBasePrice["PRICE"] = $pr[0];
	}
    $obEl["PRICE"] = $arBasePrice["PRICE"];
    
    $ar_res = CCatalogProduct::GetByID($obEl["ID"]);
    $obEl["QUANTITY"] = $ar_res["QUANTITY"];
	
    $arResult["LINKED_ITEMS"][] = $obEl;
	
    if (!in_array($obEl["PROPERTY_COLOR_CODE_VALUE"], $arResult["LINKED_COLORS"]))
    {
		if(intval($obEl["PRICE"])>0){
        $arResult["LINKED_COLORS"][] = $obEl["PROPERTY_COLOR_CODE_VALUE"];
        $arResult["LINKED_COLORS_ITEMS"][] = $obEl;
		}
    }
	
    if (!in_array($obEl["PROPERTY_SIZE_VALUE"], $arResult["LINKED_SIZES"]))
    {
		if(intval($obEl["PRICE"])>0){
        $arResult["LINKED_SIZES"][] = $obEl["PROPERTY_SIZE_VALUE"];
        $arResult["LINKED_SIZES_ITEMS"][] = $obEl;
		}
    }
	
    $arResult["COLOR_SIZE"][$obEl["PROPERTY_COLOR_CODE_VALUE"]][$obEl["PROPERTY_SIZE_VALUE"]] = $obEl;
}
SortArray( $arResult["LINKED_COLORS_ITEMS"], "PRICE");*/


// аксессуары 
if(!empty($arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]))
{
    $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]), false, false, array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_PRICE", "PROPERTY_OLD_PRICE", "PROPERTY_RATING"));    
    while($obEl = $dbEl->GetNext())
        $arResult["ACCESSORIES_ITEMS"][] = $obEl;
}

$arTmpSections = array();
$rsElementSections = CIBlockElement::GetElementGroups($arResult["ID"], true);
while($arElementSection = $rsElementSections->Fetch())
	$arTmpSections[] = $arElementSection["ID"];

$arResult["HARACTERISTICS"] = array();
if(count($arTmpSections)>0)
{
	$db_list = CIBlockSection::GetList(array(), array('IBLOCK_ID'=>$arResult["IBLOCK_ID"], "ID"=>$arTmpSections), false,array("ID","UF_HARACTERISTICS"));
	while($ar_result = $db_list->GetNext())
		$arResult["HARACTERISTICS"] = array_merge($arResult["HARACTERISTICS"], $ar_result["UF_HARACTERISTICS"]);
}
$arResult["HARACTERISTICS"] = array_unique($arResult["HARACTERISTICS"]);

$db_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>1,"PARAM2"=>$arResult["ID"]));
$arResult["PROPERTIES"]["VOTES"]["VALUE"] = $db_res -> SelectedRowsCount();


$arResult["CART_PRICE"] = 0;
$dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array());
while ($arItems = $dbBasketItems->Fetch())
	$arResult["CART_PRICE"] += $arItems["PRICE"] * $arItems["QUANTITY"];
		
// delivery
$rsDelivery = CSaleDelivery::GetList(array("SORT" => "ASC", "NAME" => "ASC" ), array("LID" => SITE_ID, "ACTIVE" => "Y", "NAME"=>"курьером по Москве и МО"), false, false, array());
while($arDelivery = $rsDelivery -> GetNext())
	$arResult["DELIVERY"][] = $arDelivery;
?>