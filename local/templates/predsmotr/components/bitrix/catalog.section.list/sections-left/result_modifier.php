<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["SECTIONS"] as $key => $arSection):
	// $arSection["ID"]
	$arFilter = Array(
		'IBLOCK_ID'=>CATALOG_IBLOCK_ID, 
		'ACTIVE'=>'Y',
		"SECTION_ID"=>$arSection["ID"]
	);  
	$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter);
	while($ar_result = $db_list->GetNext())  {
		$arResult["SECTIONS"][$key]["SUBSECTION"][] = $ar_result;
	}
endforeach
?>

