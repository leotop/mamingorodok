<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?

    
global $APPLICATION;

foreach($arResult as &$arEl){
    $typePost = new IBlogType;

    $act = "";

    $TYPE = $typePost->IGetType($arEl["ID"]);

    $arEl["Post"]["TYPE"] = $TYPE;
    /*if($TYPE!=BLOG_TYPE)
         unset($arResult["urlToEdit"]);*/
         
    if($TYPE==FRIEND_TYPE){
        $param = unserialize($arEl["~DETAIL_TEXT"]);
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
            
                $arEl["Post"]["FRIEND_NAME"] = $name;
                $arEl["Post"]["FRIEND_PHOTO"] = 0;
                $arEl["Post"]["FRIEND_PHOTO"] = $arUser["PERSONAL_PHOTO"];
                $arEl["Post"]["FRIEND_BLOG"] = "";
                $arBlog = CBlog::GetByOwnerID($arUser["ID"]);
                if(is_array($arBlog))
                    $arEl["Post"]["FRIEND_BLOG"] = $arBlog["URL"];

                $APPLICATION->SetTitle("Сообщение о дружбе");
        }
    }

    if($TYPE==WISHLIST_TYPE){
        $param = unserialize($arEl["~DETAIL_TEXT"]);
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
        $arFilter = Array(
                "ID"=>$param["ADD_ELEMENT_ID"]
                );
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($arFields = $res->GetNext()){  
 
            $arEl["Post"]["PRODUCT"] = $arFields;
        }
        $arEl["Post"]["COUNT"] = $param["COUNT"];
        
        if(isset($param["GENDER"]))    $arEl["Post"]["GENDER"]=$param["GENDER"];
        else $arEl["Post"]["GENDER"]="M";
        
        $APPLICATION->SetTitle("Сообщение о желаниях");
    }
    
    if($TYPE==CERTIFICATE_TYPE){
        $param = unserialize($arEl["~DETAIL_TEXT"]);
        
        $rsUser = CUser::GetByID($param["USER_TO"]);
        $arUser = $rsUser->Fetch();

        $arEl["Post"]["USER_TO"] = $arUser;
        
        $res = CIBlockElement::GetByID($param["CERTIFICATE"]);
        if($ar_res = $res->GetNext()){
            $arEl["Post"]["CERTIFICATE"] = $ar_res;
        }
        
        $db_props = CIBlockElement::GetProperty(CERTIFICATES_IBLOCK_ID, $param["CERTIFICATE"], array("sort" => "asc"), Array("CODE"=>"PRICE"));
        if($ar_props = $db_props->Fetch())    
            $arEl["Post"]["CERTIFICATE"]["PRICE"] = intval($ar_props["VALUE"]);
        
    }
    
    if($TYPE==ADD_COMMENT_TYPE){

        $param = unserialize($arEl["~DETAIL_TEXT"]);
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
        $arFilter = Array(
                "ID"=>$param["ELEMENT_ID"]
                );
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($arFields = $res->GetNext()){  
 
            $arEl["Post"]["PRODUCT"] = $arFields;
        }

        
        $rsUser = CUser::GetByID($param["USER_ID"]);
        $arUser = $rsUser->Fetch();
        
        if($arUser["PERSONAL_GENDER"]=="F") 
            $arEl["Post"]["USER_GENDER"] = "F";
        else
            $arEl["Post"]["USER_GENDER"] = "M";
        
        $APPLICATION->SetTitle("Сообщение о желаниях");
    }
    
    if($TYPE==ADD_REPORT_TYPE){
        $param = unserialize($arEl["~DETAIL_TEXT"]);
        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
        $arFilter = Array(
                "ID"=>$param["TOVAR_ID"]
                );
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($arFields = $res->GetNext()){  
 
            $arEl["Post"]["PRODUCT"] = $arFields;
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
            
                $arEl["Post"]["REPORT_USER"] = $name;
                $arEl["Post"]["REPORT_USER_PHOTO"] = 0;
                $arEl["Post"]["REPORT_USER_PHOTO"] = $arUser["PERSONAL_PHOTO"];
                $arEl["Post"]["REPORT_USER_BLOG"] = "";
                //echo $arUser["ID"];
                $arBlog = CBlog::GetByOwnerID($arUser["ID"]);
                if(is_array($arBlog))
                    $arEl["Post"]["REPORT_USER_BLOG"] = $arBlog["URL"];
        }
                        
        $rsUser = CUser::GetByID($param["USER_ID"]);
        $arUser = $rsUser->Fetch();
        
        if($arUser["PERSONAL_GENDER"]=="F") 
            $arEl["Post"]["GENDER"] = "F";
        else
            $arEl["Post"]["GENDER"] = "M";
            
        $APPLICATION->SetTitle("Сообщение о запросе на отзыв");
    }    
 }
    
   
?>