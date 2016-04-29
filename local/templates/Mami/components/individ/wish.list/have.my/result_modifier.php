<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if(CModule::IncludeModule("forum")){
	foreach($arResult["ITEMS"] as $k=>$post){
		$arResult["ITEMS"][$k]["REVIEW"] = "";
		if(!empty($post["PROPERTY_PRODUCT_ID_VALUE"])){
			//echo $post["PROPERTY_PRODUCT_ID_VALUE"];
			$db_res2 = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>"1","PARAM2"=>$post["PROPERTY_PRODUCT_ID_VALUE"],"AUTHOR_ID"=>$arParams["USER_ID"]));
			if($ar_res2 = $db_res2->Fetch())
			{
				$arResult["ITEMS"][$k]["REVIEW"] = $ar_res2["ID"];
			}


		}
	}
}
?>