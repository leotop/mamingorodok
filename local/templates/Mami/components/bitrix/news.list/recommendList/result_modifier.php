<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

if(isset($_REQUEST["SECTION_CODE"])){
	if(preg_match("/[a-zA-Z_\-0-9]+?/is",$_REQUEST["SECTION_CODE"])){
		$arFilter = Array(
			'IBLOCK_ID'=>REVIEWS_IBLOCK_ID, 
			'ACTIVE'=>'Y',
			"=CODE"=>$_REQUEST["SECTION_CODE"]
			);  
		$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array("UF_RECOMEND_SHOW")); 
		if($ar_result = $db_list->GetNext())  {  
			//print_R($ar_result);
			if(!empty($ar_result["UF_RECOMEND_SHOW"]))
				$ar_result["DESCRIPTION"] = $ar_result["UF_RECOMEND_SHOW"];
			$arResult["INFO"] = $ar_result;
		}
	}
}

global $USER;
$user_id = $USER->GetID();

foreach($arResult["ITEMS"] as $key=>$arItem):
	$arResult["ITEMS"][$key]["POST_URL"] = "";
	if($arItem["PROPERTIES"]["BLOG_POST_ID"]["VALUE"]>0){
		$blogs[] = $arItem["PROPERTIES"]["BLOG_POST_ID"]["VALUE"];
		$blogs2[$arItem["PROPERTIES"]["BLOG_POST_ID"]["VALUE"]] = $key;
		//echo "<br>";
	}
	
	$SORT = Array("DATE_PUBLISH" => "DESC", "NAME" => "ASC");
	$arFilter = Array(
		"ID"=>$blogs
		);	

	$dbPosts = CBlogPost::GetList(
			$SORT,
			$arFilter
		);

	while ($arPost = $dbPosts->Fetch())
	{
		
		$url = CComponentEngine::MakePathFromTemplate(htmlspecialcharsBack($arPost["PATH"]), array("post_id" => $arPost["ID"]));
		$arResult["ITEMS"][$blogs2[$arPost["ID"]]]["POST_URL"] = $url;
	}
endforeach;

foreach($arResult["ITEMS"] as $key=>$arItem):	
	if($arItem["PROPERTIES"]["LOOK_REC_LIST"]["VALUE"]=="Y"){

		
		   
		
		//добавляем в элементы каталоги товары из Каталога
		if(count($arItem["PROPERTIES"]["GROUP_PRODUCTS"]["VALUE"])>0){
			$tovars = array();
			
			$ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arItem["PROPERTIES"]["GROUP_PRODUCTS"]["VALUE"][0]), true);

			  $arResult["ITEMS"][$key]["COUNT_REPORTS"] = $ar_res;


				$arFilter = Array(   
					"IBLOCK_ID"=>CATALOG_IBLOCK_ID,    
					"ID"=>$arItem["PROPERTIES"]["GROUP_PRODUCTS"]["VALUE"],
					'ACTIVE'=>'Y',
					);
				$resTovar = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("*"));
				while($ar_fieldsTovar = $resTovar->GetNextElement()){ 
					$el = $ar_fieldsTovar->GetFields();
					$el["PROPERTY"] = $ar_fieldsTovar->GetProperties();
					if(in_array($el["ID"],$el["PROPERTY"]["THUMB_REC"]["VALUE"])){
						$el["THUMB"] = "Y";
					}
					else{
						$el["THUMB"] = "N";
					}
					$arFilter = Array(  
					"IBLOCK_ID"=>OFFERS_IBLOCK_ID,
					"ACTIVE"=>"Y",    
					"PROPERTY_MAIN_PRODUCT" => $el["ID"]
					);
					
					CModule::IncludeModule("catalog");
					$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
					$buy = 0;
					while($ar_fields = $res->GetNext()){  
						$ar_res = CCatalogProduct::GetByID($ar_fields["ID"]);
						if(intval($ar_res["QUANTITY"])>0)
							$buy++;
					}

					$el["HAVEBUY"]="N";
					if($buy>0){
						$el["HAVEBUY"]="Y";
					}
					
					$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $el["ID"], "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID ), false, false, array("ID", "IBLOCK_ID"));
					if($obEl = $dbEl->GetNext()) {   
						$el["IN_WISH"] = true;
						}
					else
						$el["IN_WISH"] = false;
						$tovars[] = $el;
					}
				
			
			$arResult["ITEMS"][$key]["TOVAR"] = $tovars;
		}
		else{
			unset($arResult["ITEMS"][$key]);
		}
		//end добавляем в элементы каталоги товары из Каталога
	
	}
endforeach;
//echo "<pre>";
//print_R($arResult);
//echo "</pre>";
?>

