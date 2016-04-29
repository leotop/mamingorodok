<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
//$arResult["urlToPost"] = $arResult["Post"]["PATH"];
    //echo "<pre>";
    //var_export($arResult);
   // echo "</pre>";

global $APPLICATION;
if ($arResult["bSoNet"] && $arResult["BlogUser"]["AVATAR_file"] !== false)
{
	unset($arResult["BlogUser"]["AVATAR_img"]);
}
$rsUser = CUser::GetList(
	$by, 
	$order,		
	array(			
		"ID" => $arResult["Post"]["AUTHOR_ID"],		
	),		
	array(			
		"SELECT" => 
		array(	
			"NAME",
			"LAST_NAME",
			"LOGIN",
			"PERSONAL_PHOTO",
			"UF_USER_RATING",			
			),		
		)	
	);
$name = "";
$foto = "";
$rat = 0;
if($arUser = $rsUser->Fetch())	{
	
	if(!empty($arUser["NAME"])){
		$name = $arUser["NAME"];
	}
	if(!empty($arUser["LAST_NAME"])){
		if(!empty($name)){
			$name .=" ".$arUser["LAST_NAME"];
		}
		else{
			$name =$arUser["LAST_NAME"];
		}
	}
	
	if(empty($name)) $name = $arUser["LOGIN"];
	if(intval($arUser["PERSONAL_PHOTO"])>0){
		$foto = $arUser["PERSONAL_PHOTO"];
	}
	
	$rsGender = CUserFieldEnum::GetList(array(), 
		array(			
			"ID" => $arUser["UF_USER_RATING"],		
			)
		);		
	
	if($arGender = $rsGender->GetNext())			
		$rat = $arGender["VALUE"];	

}
if(empty($name)){
	$name = $arResult["NAME"];
}
if(empty($foto)){
	$foto = SITE_TEMPLATE_PATH."/images/profile_img.png";
}

$arResult["LOOK_NAME"] = $name;
$arResult["LOOK_FOTO"] = $foto;
$arResult["RATING"] = $rat;


$typePost = new IBlogType;

	$act = "";

	$TYPE = $typePost->IGetType($arResult["Post"]["ID"]);

	$arResult["Post"]["TYPE"] = $TYPE;
	if($TYPE!=BLOG_TYPE)
		 unset($arResult["urlToEdit"]);
		 
	if($TYPE==FRIEND_TYPE){
		$param = unserialize($arResult["Post"]["~DETAIL_TEXT"]);
		$rsUser = CUser::GetByID($param["FRIEND"]);
		if($arUser = $rsUser->Fetch()){

		$name = "";
		if(!empty($arUser["NAME"])){
			$name = $arUser["NAME"];
		}
		
		if(!empty($arUser["LAST_NAME"])){
			if(!empty($name))
				$name .= " ".$arUser["LAST_NAME"];
			else
				$name = $arUser["LAST_NAME"];
		}	
		
		if(empty($name))
			$name = $arUser["LOGIN"];
		
			$arResult["Post"]["FRIEND_NAME"] = $name;
			$arResult["Post"]["FRIEND_PHOTO"] = 0;
			$arResult["Post"]["FRIEND_PHOTO"] = $arUser["PERSONAL_PHOTO"];
			$arResult["Post"]["FRIEND_BLOG"] = "";
			$arBlog = CBlog::GetByOwnerID($arUser["ID"]);
			if(is_array($arBlog))
				$arResult["Post"]["FRIEND_BLOG"] = $arBlog["URL"];


			$APPLICATION->SetTitle("Сообщение о дружбе");
		}
	}

	if($TYPE==WISHLIST_TYPE){

		$param = unserialize($arResult["Post"]["~DETAIL_TEXT"]);
		$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
		$arFilter = Array(
				"ID"=>$param["ADD_ELEMENT_ID"]
				);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($arFields = $res->GetNext()){  
 
			$arResult["Post"]["PRODUCT"] = $arFields;
		}
		$arResult["Post"]["COUNT"] = $param["COUNT"];
		
		if(isset($param["GENDER"]))	$arResult["Post"]["GENDER"]=$param["GENDER"];
		else $arResult["Post"]["GENDER"]="M";
		
		$APPLICATION->SetTitle("Сообщение о желаниях");
	}
	
	if($TYPE==CERTIFICATE_TYPE){
		//print_R($CurPost);
		$param = unserialize($arResult["Post"]["~DETAIL_TEXT"]);
		
		//print_R($param);
		
		$rsUser = CUser::GetByID($param["USER_TO"]);
		$arUser = $rsUser->Fetch();

		$arResult["Post"]["USER_TO"] = $arUser;
		
		$res = CIBlockElement::GetByID($param["CERTIFICATE"]);
		if($ar_res = $res->GetNext()){
			$arResult["Post"]["CERTIFICATE"] = $ar_res;
		}
		
		$db_props = CIBlockElement::GetProperty(CERTIFICATES_IBLOCK_ID, $param["CERTIFICATE"], array("sort" => "asc"), Array("CODE"=>"PRICE"));
		if($ar_props = $db_props->Fetch())	
			$arResult["Post"]["CERTIFICATE"]["PRICE"] = intval($ar_props["VALUE"]);
		
	}
	
	if($TYPE==ADD_COMMENT_TYPE){

		$param = unserialize($arResult["Post"]["~DETAIL_TEXT"]);
		$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
		$arFilter = Array(
				"ID"=>$param["ELEMENT_ID"]
				);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($arFields = $res->GetNext()){  
 
			$arResult["Post"]["PRODUCT"] = $arFields;
		}

		
		$rsUser = CUser::GetByID($param["USER_ID"]);
		$arUser = $rsUser->Fetch();
		
		if($arUser["PERSONAL_GENDER"]=="F") 
			$arResult["Post"]["USER_GENDER"] = "F";
		else
			$arResult["Post"]["USER_GENDER"] = "M";
		
		$APPLICATION->SetTitle("Сообщение о желаниях");
	}
	
	if($TYPE==ADD_REPORT_TYPE){
		$param = unserialize($arResult["Post"]["~DETAIL_TEXT"]);
		$arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
		$arFilter = Array(
				"ID"=>$param["TOVAR_ID"]
				);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		if($arFields = $res->GetNext()){  
 
			$arResult["Post"]["PRODUCT"] = $arFields;
		}

		$rsUser = CUser::GetByID($param["REPORT_USER"]);
		if($arUser = $rsUser->Fetch()){
			$name = "";
			if(!empty($arUser["NAME"])){
				$name = $arUser["NAME"];
			}
			if(!empty($arUser["LAST_NAME"])){
				if(!empty($name))
					$name .= " ".$arUser["LAST_NAME"];
				else
					$name = $arUser["LAST_NAME"];
			}
			if(empty($name))
				$name = $arUser["LOGIN"];
			
				$arResult["Post"]["REPORT_USER"] = $name;
				$arResult["Post"]["REPORT_USER_PHOTO"] = 0;
				$arResult["Post"]["REPORT_USER_PHOTO"] = $arUser["PERSONAL_PHOTO"];
				$arResult["Post"]["REPORT_USER_BLOG"] = "";
				//echo $arUser["ID"];
				$arBlog = CBlog::GetByOwnerID($arUser["ID"]);
				if(is_array($arBlog))
					$arResult["Post"]["REPORT_USER_BLOG"] = $arBlog["URL"];
		}
						
		$rsUser = CUser::GetByID($param["USER_ID"]);
		$arUser = $rsUser->Fetch();
		
		if($arUser["PERSONAL_GENDER"]=="F") 
			$arResult["Post"]["GENDER"] = "F";
		else
			$arResult["Post"]["GENDER"] = "M";
			
		$APPLICATION->SetTitle("Сообщение о запросе на отзыв");
	}
		
?>