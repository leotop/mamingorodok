<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:blog.menu",
	"",
	Array(
			"BLOG_VAR"				=> $arResult["ALIASES"]["blog"],
			"POST_VAR"				=> $arResult["ALIASES"]["post_id"],
			"USER_VAR"				=> $arResult["ALIASES"]["user_id"],
			"PAGE_VAR"				=> $arResult["ALIASES"]["page"],
			"PATH_TO_BLOG"			=> $arResult["PATH_TO_BLOG"],
			"PATH_TO_USER"			=> $arResult["PATH_TO_USER"],
			"PATH_TO_BLOG_EDIT"		=> $arResult["PATH_TO_BLOG_EDIT"],
			"PATH_TO_BLOG_INDEX"	=> $arResult["PATH_TO_BLOG_INDEX"],
			"PATH_TO_DRAFT"			=> $arResult["PATH_TO_DRAFT"],
			"PATH_TO_POST_EDIT"		=> $arResult["PATH_TO_POST_EDIT"],
			"PATH_TO_USER_FRIENDS"	=> $arResult["PATH_TO_USER_FRIENDS"],
			"PATH_TO_USER_SETTINGS"	=> $arResult["PATH_TO_USER_SETTINGS"],
			"PATH_TO_GROUP_EDIT"	=> $arResult["PATH_TO_GROUP_EDIT"],
			"PATH_TO_CATEGORY_EDIT"	=> $arResult["PATH_TO_CATEGORY_EDIT"],
			"PATH_TO_RSS_ALL"		=> $arResult["PATH_TO_RSS_ALL"],
			"BLOG_URL"				=> $arResult["VARIABLES"]["blog"],
			"SET_NAV_CHAIN"			=> $arResult["SET_NAV_CHAIN"],
			"GROUP_ID" 			=> $arParams["GROUP_ID"],
		),
	$component
);

?>
<div class="top15"></div>
<div id="BlogLeft">
<div class="items">
<?
$APPLICATION->IncludeComponent(
	"individ:blog.line",
	"",
	Array(
		"PATH_TO_BLOG"			=> $arResult["PATH_TO_BLOG"],
		"PATH_TO_USER"			=> $arResult["PATH_TO_USER"],
		"BLOG_VAR"				=> $arResult["ALIASES"]["blog"],
		"POST_VAR"				=> $arResult["ALIASES"]["post_id"],
		"PATH_TO_USER_FRIENDS"	=> $arResult["PATH_TO_USER_FRIENDS"],
		"BLOG_URL"				=> $arResult["VARIABLES"]["blog"],
		"SET_NAV_CHAIN"			=> $arResult["SET_NAV_CHAIN"],
		"GROUP_ID" 				=> $arParams["GROUP_ID"],
		"PATH_TO_POST"			=>	$arResult["PATH_TO_POST"],
		"CACHE_TYPE"			=> "N",
		"CACHE_TIME"			=> 0,
		"USE_SHARE" 			=> $arParams["USE_SHARE"],
		"SHARE_HIDE" 			=> $arParams["SHARE_HIDE"],
		"SHARE_TEMPLATE" 		=> $arParams["SHARE_TEMPLATE"],
		"SHARE_HANDLERS" 		=> $arParams["SHARE_HANDLERS"],
		"SHARE_SHORTEN_URL_LOGIN"	=> $arParams["SHARE_SHORTEN_URL_LOGIN"],
		"SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],		
		"SHOW_RATING" 			=> $arParams["SHOW_RATING"],
		"TITLE"					=> "Лента сообщений"
	)
	);

?>

</div>
</div>
<div id="BlogRight">
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/rightColumn.php", array("arResult"=>$arResult, "arParams"=>$arParams), array("MODE"=>"html") );?>
</div>