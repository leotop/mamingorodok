<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (CModule::IncludeModule("blog")):

foreach($arResult["ITEMS"] as $k=>$arItem){
	//print_R($arItem["ID"]);
	$arFilter = Array(   
		"IBLOCK_ID"=>REVIEWS_IBLOCK_ID,   
		"ACTIVE"=>"Y",    
		"PROPERTY_GROUP_PRODUCTS"=>$arItem["ID"]
		);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("PROPERTY_BLOG_POST_ID"));
	$post_id = 0;
	while($ar_fields = $res->GetNext()){  

		if(intval($ar_fields["PROPERTY_BLOG_POST_ID_VALUE"])>0){
			$post_id = $ar_fields["PROPERTY_BLOG_POST_ID_VALUE"];
		}
	}
	$arResult["ITEMS"][$k]["blog"] = "";
	if($post_id>0){
	$arPost = CBlogPost::GetByID($post_id);
	
	if(is_array($arPost))
		$arResult["ITEMS"][$k]["blog"] = $arPost;
	}
}

$have = array();
foreach($arResult["ITEMS"] as $k=>$arItem){
	foreach($arItem["PROPERTIES"] as $arProperty){
		//print_R($arProperty["CODE"]);
		if(!empty($arProperty["VALUE"])){
			//print_R($arProperty["CODE"]);
			$have[] = $arProperty["CODE"];
		}
	}
}
$arResult["HAVE"] = $have;

endif;
?>