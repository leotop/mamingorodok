<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
global $USER;
$user_id = $USER->GetID();
    
?>
    <div class="choose" style="width:350px;">
        <?if ($user_id > 0):?>
            <span><span><a href="/community/user/<?=$user_id?>/friends/">���</a></span></span>
            <span><span><a href="/community/user/<?=$user_id?>/friends/invite/">���������� ������</a></span></span>
        <?endif?>
        <span class="active"><span><a href="/community/search/">����� �� �����</a></span></span>
        <div class="clear"></div>
    </div>
<?$APPLICATION->IncludeComponent(
	"individ:socialnetwork.user_search",
	"",
	Array(
		"SET_NAV_CHAIN" => $arResult["SET_NAV_CHAIN"],
		"SET_TITLE" => $arResult["SET_TITLE"],
		"USER_VAR" => $arResult["ALIASES"]["user_id"],
		"PAGE_VAR" => $arResult["ALIASES"]["page"],
		"PATH_TO_USER" => $arResult["PATH_TO_USER"],
		"PATH_TO_SEARCH" => $arResult["PATH_TO_SEARCH"],
		"PATH_TO_SEARCH_INNER" => $arResult["PATH_TO_SEARCH_INNER"],
		"ITEMS_COUNT" => $arParams["ITEM_DETAIL_COUNT"],
		"DATE_TIME_FORMAT" => $arResult["DATE_TIME_FORMAT"],
		"USER_FIELDS_SEARCH_SIMPLE" => $arResult["USER_FIELDS_SEARCH_SIMPLE"],
		"USER_FIELDS_SEARCH_ADV" => $arResult["USER_FIELDS_SEARCH_ADV"],
		"USER_PROPERTIES_SEARCH_SIMPLE" => $arResult["USER_PROPERTIES_SEARCH_SIMPLE"],
		"USER_PROPERTIES_SEARCH_ADV" => $arResult["USER_PROPERTIES_SEARCH_ADV"],
		"USER_FIELDS_LIST" => $arResult["USER_FIELDS_LIST"],
		"USER_PROPERTY_LIST" => $arResult["USER_PROPERTY_LIST"],
		"USER_FIELDS_SEARCHABLE" => $arResult["USER_FIELDS_SEARCHABLE"],
		"USER_PROPERTY_SEARCHABLE" => $arResult["USER_PROPERTY_SEARCHABLE"],
		"SHOW_YEAR" => $arParams["SHOW_YEAR"],
		"PATH_TO_USER_FRIENDS_ADD" => $arResult["PATH_TO_USER_FRIENDS_ADD"],
		"PATH_TO_MESSAGE_FORM" => $arResult["PATH_TO_MESSAGE_FORM"],
		"PATH_TO_MESSAGES_CHAT" => $arResult["PATH_TO_MESSAGES_CHAT"],
		"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
		"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
		"PATH_TO_VIDEO_CALL" => $arResult["PATH_TO_VIDEO_CALL"],
		"ALLOW_RATING_SORT"	=>	$arParams["ALLOW_RATING_SORT"],
		"SHOW_RATING"	=>	$arParams["SHOW_RATING"],
		"RATING_ID"	=>	$arParams["RATING_ID"],
	),
	$component
);
?>
