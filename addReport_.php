<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if (!CModule::IncludeModule("iblock"))
	return;
global $USER;
$userid = intval($_REQUEST["userid"]);
$useridthis = $USER->GetID();
$typeClass = new IBlogType;
if (CModule::IncludeModule("blog")):
$arBlog = CBlog::GetByOwnerID($useridthis);
if(is_array($arBlog))
		$first = $arBlog["ID"];
	
if(intval($first)>0){
	$arResult = array();
	$arResult["REPORT_USER"] = $userid;
	
	$arFilter = Array(
		"ID"=>$tovarid
	);
	$arSelect = Array("ID", "NAME", "PROPERTY_PRODUCT_ID","DETAIL_PAGE_URL");
	
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	if($arFields = $res->GetNext()){  
		if(intval($arFields["PROPERTY_PRODUCT_ID_VALUE"])>0){
			$tovarid = $arFields["PROPERTY_PRODUCT_ID_VALUE"];
		}
		else 
			$tovarid = $arFields["NAME"];
	}
	$res = CIBlockElement::GetByID($tovarid);
		if($ar_res = $res->GetNext())
			$tov = $ar_res;
	$arResult["TOVAR_ID"] = $tovarid;
	$arResult = serialize($arResult);
	
	$arFields = array(
		"TITLE" => "Report #".$userid.$tovarid,
		"DETAIL_TEXT" => $arResult,
		"BLOG_ID" => $first,
		"AUTHOR_ID" => $useridthis,
		"DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
		"DATE_PUBLISH" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
		"PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
		"ENABLE_TRACKBACK" => 'N',
		"ENABLE_COMMENTS" => 'Y',
		//"PERMS_P" => $PERMS_P,
		//"PERMS_C" => $PERMS_C
	);

	$newID = CBlogPost::Add($arFields);
	
	if(IntVal($newID)>0)
	{
		$type = ADD_REPORT_TYPE;
		//echo $type." ".$newID;
		if($typeClass->ISetType($newID,$type)){
			echo "good";
			
			$rsUser = CUser::GetByID($userid);
			$arUser = $rsUser->Fetch();

			$name = "";
			if(!empty($arUser["NAME"]))
				$name = $arUser["NAME"];
				
			if(!empty($arUser["LAST_NAME"]))
				if(!empty($name))
					$name .= " ".$arUser["LAST_NAME"];
				else
					$name = $arUser["LAST_NAME"];
			
			if(empty($name))
				$name = $arUser["LOGIN"];
			
			$arEventFields = array(
				"EMAIL_TO" => $arUser["EMAIL"],
				"USER_NAME" => $name,
				"TOVAR_LINK" => $tov["DETAIL_PAGE_URL"],
				"TOVAR_NAME" => $tov["NAME"],
				"USER_LINK" => "http://".$_SERVER['SERVER_NAME']."/community/user/".$arUser["ID"]."/",
			);
			
			
			//
			$id = CEvent::Send(REPORT_REQUEST_SEND, SITE_ID, $arEventFields);
			echo $id;
		}
		else echo "error";
		
	}
	else
	{
		if ($ex = $APPLICATION->GetException())
			echo $ex->GetString();
			
	}
}
endif					
?>