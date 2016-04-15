<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

echo 'Выборка GetNext';
$rsI = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => array(39535, 36924)), false, false, array("ID", "IBLOCK_ID", "PROPERTY_CH_SEASON"));
while($arI = $rsI->GetNext())
{
	echo '<pre>'.print_r($arI, true).'</pre>';
}

echo 'Выборка GetNextElement -> GetProperties()';
$rsI = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => array(39535, 36924)));
while($obI = $rsI->GetNextElement())
{
	$arP = $obI -> GetProperties();
	
	echo '<pre>'.print_r($arP["CH_SEASON"], true).'</pre>';
}
?>