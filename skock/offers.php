<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

processUserAvailNotify();

die();
$rsO = CIBlockElement::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>3, "!PROPERTY_PICTURE_MAXI"=>false, ">ID"=>32661), false, array("nTopCount"=>750), array("ID", "PROPERTY_PICTURE_MAXI"));
while($arO = $rsO -> GetNext())
{
	echo $arO["ID"].'<br>';
	$arImg = CFile::ResizeImageGet($arO["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>256, "height"=>256), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
	CIBlockElement::SetPropertyValues($arO["ID"], 3, CFile::MakeFileArray($arImg["src"]), "PICTURE_MIDI");
}


?>