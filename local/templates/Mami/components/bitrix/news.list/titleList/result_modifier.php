<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
CModule::IncludeModule("forum");


foreach($arResult["ITEMS"] as $k=>$v){ 

			if($v["ID"]>0){
				$ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$v["ID"]), true);

			  $arResult["ITEMS"][$key]["COUNT_REPORTS"] = $ar_res;

			}

 $arFilter = Array('IBLOCK_ID'=>CATALOG_IBLOCK_ID, 'ID'=>$v["IBLOCK_SECTION_ID"]);
 $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("UF_HARACTERISTICS"));
 while($ar_result = $db_list->GetNext())  {
	//$arResult["PROPERTY"] = $ar_result["NAME"];
	$arResult["ITEMS"][$k]["UF_HARACTERISTICS"] = $ar_result["UF_HARACTERISTICS"];
 }
//print_R($arResult["ROWS"]);
}
?>

