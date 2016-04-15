<?
global $NO_BROAD;
$NO_BROAD = true;
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("����");
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?
$APPLICATION->IncludeComponent("bitrix:blog.menu", ".default", array(
	"BLOG_URL" => $arResult["VARIABLES"]["blog"],
	"PATH_TO_BLOG" => "/community/blog/#blog#/",
	"PATH_TO_BLOG_INDEX" => $arResult["PATH_TO_BLOG_INDEX"],
	"PATH_TO_DRAFT" => $arResult["PATH_TO_DRAFT"],
	"PATH_TO_POST_EDIT" => $arResult["PATH_TO_POST_EDIT"],
	"PATH_TO_USER" => "/community/user/#user_id#/",
	"PATH_TO_USER_FRIENDS" => $arResult["PATH_TO_USER_FRIENDS"],
	"PATH_TO_USER_SETTINGS" => $arResult["PATH_TO_USER_SETTINGS"],
	"PATH_TO_GROUP_EDIT" => $arResult["PATH_TO_GROUP_EDIT"],
	"PATH_TO_BLOG_EDIT" => $arResult["PATH_TO_BLOG_EDIT"],
	"PATH_TO_CATEGORY_EDIT" => $arResult["PATH_TO_CATEGORY_EDIT"],
	"SET_NAV_CHAIN" => "N",
	"BLOG_VAR" => $arResult["ALIASES"]["blog"],
	"POST_VAR" => $arResult["ALIASES"]["post_id"],
	"PAGE_VAR" => $arResult["ALIASES"]["page"],
	"USER_VAR" => $arResult["ALIASES"]["user_id"]
	),
	$component
);
?>
<div class="top15"></div>
<div id="BlogLeft">
<div class="items">
<?$APPLICATION->IncludeComponent("individ:blog.popular_posts", "big", array(
	"GROUP_ID" => "2",
	"BLOG_URL" => "",
	"MESSAGE_COUNT" => "6",
	"PERIOD_DAYS" => "7",
	"MESSAGE_LENGTH" => "200",
	"PREVIEW_WIDTH" => "100",
	"PREVIEW_HEIGHT" => "100",
	"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
	"PATH_TO_BLOG" => "/community/group/#blog#/",
	"PATH_TO_POST" => "/community/group/#blog#/",
	"PATH_TO_USER" => "/community/group/#user_id#/",
	"PATH_TO_GROUP_BLOG_POST" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "86400",
	"PATH_TO_SMILE" => "",
	"BLOG_VAR" => "",
	"POST_VAR" => "",
	"USER_VAR" => "",
	"PAGE_VAR" => "",
	"SEO_USER" => "N"
	),
	false
);?>

    <?
CModule::IncludeModule('iblock');
$APPLICATION->IncludeComponent(
        "individ:blog.post.comment",
        "comments", 
        Array(
                "BLOG_VAR"        => $arResult["ALIASES"]["blog"],
                "USER_VAR"        => $arResult["ALIASES"]["user_id"],
                "PAGE_VAR"        => $arResult["ALIASES"]["page"],
                "POST_VAR"            => $arResult["ALIASES"]["post_id"],
                "PATH_TO_BLOG"    => $arResult["PATH_TO_BLOG"],
                "PATH_TO_POST"    => $arResult["PATH_TO_POST"],
                "PATH_TO_USER"    => $arResult["PATH_TO_USER"],
                "PATH_TO_SMILE"    => $arResult["PATH_TO_SMILE"],
                "BLOG_URL"        => $arResult["VARIABLES"]["blog"],
                "ID"            => $arResult["VARIABLES"]["post_id"],
                "CACHE_TYPE"    => $arResult["CACHE_TYPE"],
                "CACHE_TIME"    => $arResult["CACHE_TIME"],
                "COMMENTS_COUNT" => $arResult["COMMENTS_COUNT"],
                "DATE_TIME_FORMAT"    => $arResult["DATE_TIME_FORMAT"],
                "USE_ASC_PAGING"    => $arParams["USE_ASC_PAGING"],
                "NOT_USE_COMMENT_TITLE"    => $arParams["NOT_USE_COMMENT_TITLE"],
                "GROUP_ID"             => $arParams["GROUP_ID"],
                "SEO_USER"            => $arParams["SEO_USER"],
                "NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
                "SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
                "PATH_TO_CONPANY_DEPARTMENT" => $arParams["PATH_TO_CONPANY_DEPARTMENT"],
                "PATH_TO_SONET_USER_PROFILE" => $arParams["PATH_TO_SONET_USER_PROFILE"],
                "PATH_TO_MESSAGES_CHAT" => $arParams["PATH_TO_MESSAGES_CHAT"],
                "PATH_TO_VIDEO_CALL" => $arParams["PATH_TO_VIDEO_CALL"],
                "SHOW_RATING" => $arParams["SHOW_RATING"],
                "SMILES_COUNT" => $arParams["SMILES_COUNT"],
                "IMAGE_MAX_WIDTH" => $arParams["IMAGE_MAX_WIDTH"],
                "IMAGE_MAX_HEIGHT" => $arParams["IMAGE_MAX_HEIGHT"],
                "EDITOR_RESIZABLE" => $arParams["COMMENT_EDITOR_RESIZABLE"],
                "EDITOR_DEFAULT_HEIGHT" => $arParams["COMMENT_EDITOR_DEFAULT_HEIGHT"],
                "EDITOR_CODE_DEFAULT" => $arParams["COMMENT_EDITOR_CODE_DEFAULT"],
                "ALLOW_VIDEO" => $arParams["COMMENT_ALLOW_VIDEO"],
                "ALLOW_POST_CODE" => $arParams["ALLOW_POST_CODE"],
                "SHOW_SPAM" => $arParams["SHOW_SPAM"],
                "NO_URL_IN_COMMENTS" => $arParams["NO_URL_IN_COMMENTS"],
                "NO_URL_IN_COMMENTS_AUTHORITY" => $arParams["NO_URL_IN_COMMENTS_AUTHORITY"],
            ),
        $component 
    );
?>
</div>
</div>
<div id="BlogRight">
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/rightColumn.php", array("arResult"=>$arResult, "arParams"=>$arParams), array("MODE"=>"html") );?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>