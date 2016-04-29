<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	$arFilter = Array(   
	"IBLOCK_ID"=>CERTIFICATES_PRESENT_IBLOCK_ID,    
	"ACTIVE"=>"Y",   
	"PROPERTY_USER_PRESENT"=>$arParams["USER_ID"],
	"PROPERTY_STATUS"=>CERTIFICATE_STATUS_OK
	);
	$resUs = array();
	$resUsT = array();
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("PROPERTY_USER_BY"));
	
	while($ar_fields = $res->GetNext()){  
		$id = $ar_fields["PROPERTY_USER_BY_VALUE"];
		if(!in_array($id,$resUsT)){
			$rsUser = CUser::GetByID($id);
			
			if($arUser = $rsUser->Fetch()){
				$arBlog = CBlog::GetByOwnerID($id);

				$arUser["BLOG"] = $arBlog;
				$name = "";
				if(!empty($arUser["NAME"])){
					$name = $arUser["NAME"];
				}
				
				if(!empty($arUser["LAST_NAME"])){
					if(!empty($name)){
						$name .= " ".$arUser["LAST_NAME"];
					}
					else{
						$name = $arUser["LAST_NAME"];
					}
				}
				
				if(empty($name)){
					$name = $arUser["LOGIN"];
				}
				
				$arUser["LOOK_NAME"] = $name;
				$resUs[] = $arUser;
				$resUsT[] = $arUser["ID"];
			}
		}
	}
	$arResult["USERS"] = $resUs;

    // список статусов пользователей 
    $arStatusList = GetStatusList();
    $arResult["STATUS"] = GetStatusByRatingValue($arResult["UF_USER_RATING"], $arStatusList);
	
	$arFilter = Array(   
		"IBLOCK_ID"=>PRESENTER_IBLOCK_ID,    
		"ACTIVE"=>"Y",    
		"PROPERTY_USERS"=>$arParams["USER_ID"]
	);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC",), $arFilter, false,false,array("NAME"));
	while($ar_fields = $res->GetNext()){  
		$arResult["AWARDS"][] = $ar_fields["NAME"];
	}

?>