<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
global $USER;
foreach($arResult["MESSAGES"] as $key => $arMessage):
	// $arUser = array();
	// if($arMessage["AUTHOR_ID"]>0){
	// $rsUser = $USER->GetByID($arMessage["AUTHOR_ID"]);
	// $arUser = $rsUser->Fetch();
	// }
	// $arResult["MESSAGES"][$key]["AUTHOR"] = $arUser;
	
	$mesRaiting = new IForumMessageRating;
	$arResult["MESSAGES"][$key]["RATING"] = $mesRaiting->IGetRating($arMessage["ID"]);
	
endforeach;
?>

