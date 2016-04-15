<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!$USER -> IsAdmin()) die("Access denied");

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$arItemID = array();
$arResult = array();
$rsI = CIBlockElement::GetList(Array("PROPERTY_CH_PRODUCER.NAME"=>"ASC", "NAME"=>"ASC"), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID), false, false, array("IBLOCK_ID", "ID", "ACTIVE", "PROPERTY_CH_PRODUCER.NAME", "NAME", "PROPERTY_PRICE", "PROPERTY_OLD_PRICE", "PROPERTY_CH_SNYATO"));
while($arI = $rsI -> GetNext())
{
	$arResult["ITEMS"][$arI["ID"]] = array(
		"BRAND" => $arI["PROPERTY_CH_PRODUCER_NAME"],
		"ACTIVE" => $arI["ACTIVE"],
		"NAME" => $arI["NAME"],
		"PRICE" => $arI["PROPERTY_PRICE_VALUE"],
		"OLD_PRICE" => $arI["PROPERTY_OLD_PRICE_VALUE"],
		"STATUS" => $arI["PROPERTY_CH_SNYATO_VALUE"]
	);
	$arItemID[] = $arI["ID"];
}

if(!empty($arItemID))
{
	$rsO = CIBlockElement::GetList(Array("NAME"=>"ASC"), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "PROPERTY_CML2_LINK"=>$arItemID), false, false, array("IBLOCK_ID", "ID", "ACTIVE", "NAME", "PROPERTY_SIZE", "PROPERTY_COLOR", "CATALOG_GROUP_1", "PROPERTY_CML2_LINK", "TIMESTAMP_X"));
	while($arO = $rsO -> GetNext())
		$arResult["ITEMS"][$arO["PROPERTY_CML2_LINK_VALUE"]]["OFFERS"][] = $arO;
}

$arTable = array();
$arTr = array(
	"Бренд",
	"Активность товара",
	"Статус",
	"Название товара",
	"Цена товара",
	"Старая цена",
	"Активность цветоразмера",
	"Дата изменения цветоразмера",
	"Название цветоразера",
	"Цвет",
	"Размер",
	"Цена цветоразмера"
);
$arTable[] = '<tr><td>'.implode("</td><td>", $arTr).'</td></tr>';

foreach($arResult["ITEMS"] as $arItem)
{
	$arTr = array(
		$arItem["BRAND"],
		$arItem["ACTIVE"],
		$arItem["STATUS"],
		$arItem["NAME"],
		$arItem["PROPERTY_PRICE_VALUE"],
		$arItem["PROPERTY_OLD_PRICE_VALUE"],
		"",
		"",
		"",
		"",
		"",
		""
	);
	$arTable[] = '<tr><td>'.implode("</td><td>", $arTr).'</td></tr>';

	foreach($arItem["OFFERS"] as $arOffer)
	{
		$arTr = array(
			"",
			"",
			$arItem["STATUS"],
			"",
			"",
			"",
			$arOffer["ACTIVE"],
			$arOffer["TIMESTAMP_X"],
			$arOffer["NAME"],
			$arOffer["PROPERTY_COLOR_VALUE"],
			$arOffer["PROPERTY_SIZE_VALUE"],
			$arOffer["CATALOG_PRICE_1"]
		);
		$arTable[] = '<tr><td>'.implode("</td><td>", $arTr).'</td></tr>';
	}
}

$str = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head><body><table border="1">'.implode(" ", $arTable).'</table></body></html>';

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ('Content-Disposition: attachment; filename="prices_'.date("Ymd_His").'.xls"' );


echo $str;