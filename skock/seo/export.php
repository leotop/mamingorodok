<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!$USER -> IsAdmin()) die();

CModule::IncludeModule("iblock");



$strResult = '';
$strResult .= implode(";", array("1 ID", "2 NAME", "3 RPAD", "4 VPAD", "5 TYPE"))."\r\n";

$rsSec = CIBlockSection::GetList(Array("left_margin"=>"ASC"), array( "IBLOCK_ID"=>2), false, array("ID", "NAME", "UF_NAME_PAD", "UF_NAME_VPAD"));
while($arSec = $rsSec -> GetNext())
	$strResult .= implode(";", $arResult[] = array($arSec["ID"], $arSec["NAME"], $arSec["UF_NAME_PAD"], $arSec["UF_NAME_VPAD"], "S"))."\r\n";

$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array( "IBLOCK_ID" =>2), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_NAME_RPAD", "PROPERTY_NAME_VPAD"));
while($arI = $rsI->GetNext())
	$strResult .= implode(";", array($arI["ID"], str_replace(array(";"), "", $arI["NAME"]), $arI["PROPERTY_NAME_RPAD_VALUE"], $arI["PROPERTY_NAME_VPAD_VALUE"], "E"))."\r\n";

echo $strResult;