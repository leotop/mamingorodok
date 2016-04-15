<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


if (!CModule::IncludeModule("iblock")){
	return;
}
global $USER;
$mail = array();
if($_REQUEST["do"]=='addEvents'){
	if(preg_match("/[a-zA-Z0-9\_\-]+?@[a-zA-Z0-9\_\-\.]+\.[a-zA-Z]{2,}/is",$_REQUEST["mail"])){
		$mail[] = $_REQUEST["mail"];
	}
	
	if(preg_match("/^[0-9\|]+?$/is",$_REQUEST["users"])){
		$arUsers = explode("||",$_REQUEST["users"]);
		foreach($arUsers as $user){
			$user = intval($user);
			if($user>0){
				$rsUser = CUser::GetByID($user);
				$arUser = $rsUser->Fetch();
				if(!empty($arUser["EMAIL"])){
					$mail[] =$arUser["EMAIL"];
				}
			}
		}
	}
	
	$product_id = intval($_REQUEST["product_id"]);
	
	if (!$USER->IsAuthorized()) {
		$name = "Guest";
	}
	else{
		$name = "";
		$name = $USER->GetFullName();
		if(empty($name)){
			$name = $USER->GetLogin();
		}
	}
	
	$res = CIBlockElement::GetByID($product_id);
	if($ar_res = $res->GetNext()){
		//print_R($ar_res);
		$tovar_name = $ar_res["NAME"];
		$tovar_link = $ar_res["DETAIL_PAGE_URL"];
		$tovar_img = CFile::GetPath($ar_res["DETAIL_PICTURE"]);
	}
	
	$arEventFields = array(
		"EMAIL_TO" => implode(",", $mail),
		"USER_NAME" => $name,
		"TOVAR_NAME" => $tovar_name,
		"TOVAR_LINK" => $tovar_link,
		"TOVAR_IMG" => $tovar_img
	);
	
	
	///print_r($mail);
	//$arrSITE =  CAdvContract::GetSiteArray($CONTRACT_ID);
	$id = CEvent::Send(RECOMEND_USER_SEND, SITE_ID, $arEventFields);
	echo $id ;
}


if($_REQUEST["do"]=='addListEvent'){
	if(preg_match("/[a-zA-Z0-9\_\-]+?@[a-zA-Z0-9\_\-\.]+\.[a-zA-Z]{2,}/is",$_REQUEST["mail"])){
		$mail[] = $_REQUEST["mail"];
	}
	
	if(preg_match("/^[0-9\|]+?$/is",$_REQUEST["users"])){
		$arUsers = explode("||",$_REQUEST["users"]);
		foreach($arUsers as $user){
			$user = intval($user);
			if($user>0){
				$rsUser = CUser::GetByID($user);
				$arUser = $rsUser->Fetch();
				if(!empty($arUser["EMAIL"])){
					$mail[] =$arUser["EMAIL"];
				}
			}
		}
	}
	
	$product_id = intval($_REQUEST["product_id"]);
	
	if (!$USER->IsAuthorized()) {
		$name = "Guest";
		$link ="";
	}
	else{
		$name = "";
		$name = $USER->GetFullName();
		if(empty($name)){
			$name = $USER->GetLogin();
		}
		$link = "/community/user/".$USER->GetID()."/";
	}
	
	$arEventFields = array(
		"EMAIL_TO" => implode(",", $mail),
		"USER_NAME" => $name,
		"USER_LINK" => "http://".$_SERVER['SERVER_NAME'].$link,
	);
	
	
	///print_r($mail);
	//$arrSITE =  CAdvContract::GetSiteArray($CONTRACT_ID);
	$id = CEvent::Send(RECOMEND_LIST_SEND, SITE_ID, $arEventFields);
	echo $id ;
}

?>