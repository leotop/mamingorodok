<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$pageId = "user_friends";
//include("util_menu.php");
//include("util_profile.php");

global $USER;
$current_user_id = $USER->GetID();
$user_id = $arResult["VARIABLES"]["user_id"];


?>

<? // ���� ������������ ������� ���� ������ ������ ?>
<?if ($current_user_id == $user_id):?>    

    <div class="choose" style="width:350px;">
        <span class="active"><span><a href="/community/user/<?=$user_id?>/friends/">���</a></span></span>
        <span><span><a href="/community/user/<?=$user_id?>/friends/invite/">���������� ������</a></span></span>
        <span><span><a href="/community/search/">����� �� �����</a></span></span>
        <div class="clear"></div>
    </div>
<?
    $APPLICATION->IncludeComponent(
        "individ:socialnetwork.user_friends", 
        "my", 
        Array(
            "PATH_TO_USER" => $arResult["PATH_TO_USER"],
            "USER_VAR" => $arResult["ALIASES"]["user_id"],
            "PATH_TO_USER_FRIENDS_ADD" => $arResult["PATH_TO_USER_FRIENDS_ADD"],
            "PATH_TO_SEARCH" => $arResult["PATH_TO_SEARCH"],
            "PATH_TO_SEARCH_EXTERNAL" => $arParams["PATH_TO_SEARCH_EXTERNAL"],
            "PATH_TO_USER_FRIENDS_DELETE" => $arResult["PATH_TO_USER_FRIENDS_DELETE"],
            "PATH_TO_MESSAGES_CHAT" => $arResult["PATH_TO_MESSAGES_CHAT"],
            "ID" => $arResult["VARIABLES"]["user_id"],
            "SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
            "SET_TITLE" => $arResult["SET_TITLE"],
            "ITEMS_COUNT" => $arParams["ITEM_DETAIL_COUNT"],
            "PATH_TO_LOG" => $arResult["PATH_TO_LOG"],
            "THUMBNAIL_LIST_SIZE" => 30,
            "NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
            "SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
            "DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],        
            "SHOW_YEAR" => $arParams["SHOW_YEAR"],        
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
            "PATH_TO_VIDEO_CALL" => $arResult["PATH_TO_VIDEO_CALL"],
        ),
        $component 
    );
    
?>


<?else: // ���� ������� ����� ������ ������?>


<?$APPLICATION->IncludeComponent("individ:user.profile.top", "", array(
    "USER_ID" => $user_id,
    "CURRENT_USER_ID" => $current_user_id,
    "IS_FRIENDS" => CSocNetUserRelations::IsFriends($user_id, $current_user_id),
    "CURRENT_PAGE" => "FRIENDS"
));?>
<?
$APPLICATION->IncludeComponent(
    "individ:socialnetwork.user_friends", 
    "", 
    Array(
        "PATH_TO_USER" => $arResult["PATH_TO_USER"],
        "USER_VAR" => $arResult["ALIASES"]["user_id"],
        "PATH_TO_USER_FRIENDS_ADD" => $arResult["PATH_TO_USER_FRIENDS_ADD"],
        "PATH_TO_SEARCH" => $arResult["PATH_TO_SEARCH"],
        "PATH_TO_SEARCH_EXTERNAL" => $arParams["PATH_TO_SEARCH_EXTERNAL"],
        "PATH_TO_USER_FRIENDS_DELETE" => $arResult["PATH_TO_USER_FRIENDS_DELETE"],
        "PATH_TO_MESSAGES_CHAT" => $arResult["PATH_TO_MESSAGES_CHAT"],
        "ID" => $arResult["VARIABLES"]["user_id"],
        "SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
        "SET_TITLE" => $arResult["SET_TITLE"],
        "ITEMS_COUNT" => $arParams["ITEM_DETAIL_COUNT"],
        "PATH_TO_LOG" => $arResult["PATH_TO_LOG"],
        "THUMBNAIL_LIST_SIZE" => 30,
        "NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
        "SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
        "DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],        
        "SHOW_YEAR" => $arParams["SHOW_YEAR"],        
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
        "PATH_TO_VIDEO_CALL" => $arResult["PATH_TO_VIDEO_CALL"],
    ),
    $component 
);
?>


<?endif?>