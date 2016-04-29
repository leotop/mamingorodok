<?
foreach($arResult["Friends"]["List"] as $key=>$arFriend)
{
    $rsUser = CUser::GetByID($arFriend["USER_ID"]);
    $arUser = $rsUser->Fetch();
    $arResult["Friends"]["List"][$key]["PARAMS"] = $arUser;
}




?>  

