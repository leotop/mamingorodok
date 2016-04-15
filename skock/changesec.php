<?
die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
	"ACTIVE" => "Y",
	"IBLOCK_ID" => 2,
   "PROPERTY_CH_PRODUCER" => 11505
), false, false, array(
	"ID",
	"IBLOCK_ID"
));
echo $rsI -> SelectedRowsCount().'<br><br><br>';

$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
	"ACTIVE" => "Y",
	"IBLOCK_ID" => 2,
	"PROPERTY_CH_PRODUCER" => 11506
), false, false, array(
	"ID",
	"IBLOCK_ID"
));
echo $rsI -> SelectedRowsCount().'<br><br><br>';

//$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
//	"ACTIVE" => "Y",
//	"IBLOCK_ID" => 2,
//	"PROPERTY_CH_PRODUCER" => 47632
//), false, false, array(
//	"ID",
//	"IBLOCK_ID"
//));
//echo $rsI -> SelectedRowsCount().'<br><br><br>';

//$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
//	"ACTIVE" => "Y",
//	"IBLOCK_ID" => 2,
//	"PROPERTY_CH_PRODUCER" => 52900
//), false, false, array(
//	"ID",
//	"IBLOCK_ID"
//));
//echo $rsI -> SelectedRowsCount().'<br><br><br>';