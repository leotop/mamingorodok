<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($_SERVER['HTTP_REFERER']))
	$url = $_SERVER['HTTP_REFERER'];
else $url ="/";
LocalRedirect($url);
?>

<?
$pageId = "user";
//include("util_menu.php");        
?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:socialnetwork.user_profile",
    "",
    Array(
        "PATH_TO_USER" => $arResult["PATH_TO_USER"],
        "PATH_TO_USER_EDIT" => $arResult["PATH_TO_USER_PROFILE_EDIT"],
        "PATH_TO_USER_FRIENDS" => $arResult["PATH_TO_USER_FRIENDS"],
        "PATH_TO_USER_GROUPS" => $arResult["PATH_TO_USER_GROUPS"],
        "PATH_TO_USER_FRIENDS_ADD" => $arResult["PATH_TO_USER_FRIENDS_ADD"],
        "PATH_TO_USER_FRIENDS_DELETE" => $arResult["PATH_TO_USER_FRIENDS_DELETE"],
        "PATH_TO_MESSAGE_FORM" => $arResult["PATH_TO_MESSAGE_FORM"],
        "PATH_TO_MESSAGES_CHAT" => $arResult["PATH_TO_MESSAGES_CHAT"],
        "PATH_TO_MESSAGES_USERS_MESSAGES" => $arResult["PATH_TO_MESSAGES_USERS_MESSAGES"],
        "PATH_TO_USER_SETTINGS_EDIT" => $arResult["PATH_TO_USER_SETTINGS_EDIT"],
        "PATH_TO_SEARCH" => $arResult["PATH_TO_SEARCH"],
        "PATH_TO_SEARCH_INNER" => $arResult["PATH_TO_SEARCH_INNER"],
        "PATH_TO_GROUP" => $arResult["PATH_TO_GROUP"],
        "PATH_TO_GROUP_EDIT" => $arResult["PATH_TO_GROUP_EDIT"],
        "PATH_TO_GROUP_CREATE" => $arResult["PATH_TO_GROUP_CREATE"],
        "PATH_TO_USER_FEATURES" => $arResult["PATH_TO_USER_FEATURES"],
        "PAGE_VAR" => $arResult["ALIASES"]["page"],
        "USER_VAR" => $arResult["ALIASES"]["user_id"],
        "SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
        "SET_TITLE" => $arResult["SET_TITLE"],
        "USER_PROPERTY_MAIN" => $arResult["USER_PROPERTY_MAIN"],
        "USER_PROPERTY_CONTACT" => $arResult["USER_PROPERTY_CONTACT"],
        "USER_PROPERTY_PERSONAL" => $arResult["USER_PROPERTY_PERSONAL"],
        "USER_FIELDS_MAIN" => $arResult["USER_FIELDS_MAIN"],
        "USER_FIELDS_CONTACT" => $arResult["USER_FIELDS_CONTACT"],
        "USER_FIELDS_PERSONAL" => $arResult["USER_FIELDS_PERSONAL"],
        "PATH_TO_USER_FEATURES" => $arResult["PATH_TO_USER_FEATURES"],
        "DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],
        "SHORT_FORM" => "N",
        "ITEMS_COUNT" => $arParams["ITEM_MAIN_COUNT"],
        "PATH_TO_BLOG" => $arResult["PATH_TO_USER_BLOG"],
        "PATH_TO_POST" => $arResult["PATH_TO_USER_BLOG_POST"],
        "PATH_TO_USER_FORUM" => $arResult["PATH_TO_USER_FORUM"],
        "PATH_TO_USER_FORUM_TOPIC" => $arResult["~PATH_TO_USER_FORUM_TOPIC"],
        "PATH_TO_USER_FORUM_MESSAGE" => $arResult["~PATH_TO_USER_FORUM_MESSAGE"],
        "PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
        "SHOW_YEAR" => $arParams["SHOW_YEAR"],
        "FORUM_ID" => $arParams["FORUM_ID"],
        "SONET_USER_FIELDS_SEARCHABLE" => $arResult["USER_FIELDS_SEARCHABLE"],
        "SONET_USER_PROPERTY_SEARCHABLE" => $arResult["USER_PROPERTY_SEARCHABLE"],
        "PATH_TO_USER_SUBSCRIBE" => $arResult["PATH_TO_USER_SUBSCRIBE"],
        "PATH_TO_LOG" => $arResult["PATH_TO_LOG"],
        "PATH_TO_ACTIVITY" => $arResult["PATH_TO_ACTIVITY"],
        "PATH_TO_SUBSCRIBE" => $arResult["PATH_TO_SUBSCRIBE"],
        "PATH_TO_GROUP_SEARCH" => $arResult["PATH_TO_GROUP_SEARCH"],
        "CALENDAR_USER_IBLOCK_ID" => $arParams['CALENDAR_USER_IBLOCK_ID'],
        "BLOG_GROUP_ID" => $arParams["BLOG_GROUP_ID"],
        "TASK_IBLOCK_ID" => $arParams["TASK_IBLOCK_ID"],
        "TASK_VAR" => $arResult["ALIASES"]["task_id"],
        "TASK_ACTION_VAR" => $arResult["ALIASES"]["action"],
        "PATH_TO_GROUP_TASKS" => $arParams["PATH_TO_GROUP_TASKS"],
        "PATH_TO_GROUP_TASKS_TASK" => $arParams["PATH_TO_GROUP_TASKS_TASK"],
        "PATH_TO_GROUP_TASKS_VIEW" => $arParams["PATH_TO_GROUP_TASKS_VIEW"],
        "PATH_TO_USER_TASKS" => $arResult["PATH_TO_USER_TASKS"],
        "PATH_TO_USER_TASKS_TASK" => $arResult["PATH_TO_USER_TASKS_TASK"],
        "PATH_TO_USER_TASKS_VIEW" => $arResult["PATH_TO_USER_TASKS_VIEW"],
        "TASKS_FIELDS_SHOW" => $arParams["TASKS_FIELDS_SHOW"],
        "TASK_FORUM_ID" => $arParams["TASK_FORUM_ID"],
        "THUMBNAIL_LIST_SIZE" => 30,
        "NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
        "SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
        "CAN_OWNER_EDIT_DESKTOP" => $arParams["CAN_OWNER_EDIT_DESKTOP"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "PATH_TO_VIDEO_CALL" => $arResult["PATH_TO_VIDEO_CALL"],
        "PATH_TO_USER_CONTENT_SEARCH" => $arResult["PATH_TO_USER_CONTENT_SEARCH"],
        "USE_MAIN_MENU" => $arParams["USE_MAIN_MENU"],
        "SHOW_RATING"    =>    $arParams["SHOW_RATING"],
        "RATING_ID"    =>    $arParams["RATING_ID"],
        "BLOG_ALLOW_POST_CODE" => $arParams["BLOG_ALLOW_POST_CODE"],
    ),
    $component
);
?>