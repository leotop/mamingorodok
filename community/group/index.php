<?
global $NO_BROAD;
$NO_BROAD = true;
$IS_HIDE = true;
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Блог");
$APPLICATION->SetPageProperty("description", "Блог интернет-магазина «Мамин городок»");
?>
<?
$APPLICATION->IncludeComponent(
	"individ:group.blog", 
	".default", 
	array(
		"MESSAGE_COUNT" => "10",
		"PERIOD_DAYS" => "30",
		"MESSAGE_COUNT_MAIN" => "6",
		"BLOG_COUNT_MAIN" => "6",
		"COMMENTS_COUNT" => "25",
		"MESSAGE_LENGTH" => "100",
		"BLOG_COUNT" => "20",
		"DATE_TIME_FORMAT" => "d.m.Y",
		"NAV_TEMPLATE" => "",
		"SMILES_COUNT" => "4",
		"IMAGE_MAX_WIDTH" => "800",
		"IMAGE_MAX_HEIGHT" => "800",
		"EDITOR_RESIZABLE" => "Y",
		"EDITOR_DEFAULT_HEIGHT" => "300",
		"EDITOR_CODE_DEFAULT" => "N",
		"COMMENT_EDITOR_RESIZABLE" => "Y",
		"COMMENT_EDITOR_DEFAULT_HEIGHT" => "200",
		"COMMENT_EDITOR_CODE_DEFAULT" => "N",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/community/group/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_TIME_LONG" => "604800",
		"PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
		"SET_TITLE" => "Y",
		"SET_NAV_CHAIN" => "N",
		"USER_PROPERTY" => array(
		),
		"BLOG_PROPERTY" => array(
		),
		"BLOG_PROPERTY_LIST" => array(
		),
		"POST_PROPERTY" => array(
		),
		"POST_PROPERTY_LIST" => array(
		),
		"USE_ASC_PAGING" => "N",
		"NOT_USE_COMMENT_TITLE" => "N",
		"SHOW_RATING" => "Y",
		"COMMENT_ALLOW_VIDEO" => "N",
		"SHOW_SPAM" => "N",
		"NO_URL_IN_COMMENTS" => "",
		"NO_URL_IN_COMMENTS_AUTHORITY" => "",
		"ALLOW_POST_CODE" => "Y",
		"USE_GOOGLE_CODE" => "Y",
		"THEME" => "blue",
		"GROUP_ID" => array(
			0 => "2",
			1 => "",
		),
		"SHOW_NAVIGATION" => "N",
		"USER_PROPERTY_NAME" => "",
		"PERIOD_NEW_TAGS" => "",
		"PERIOD" => "",
		"COLOR_TYPE" => "Y",
		"WIDTH" => "100%",
		"SEO_USER" => "Y",
		"NAME_TEMPLATE" => "#NOBR##LAST_NAME# #NAME##/NOBR#",
		"SHOW_LOGIN" => "Y",
		"USE_SHARE" => "Y",
		"SHARE_HIDE" => "N",
		"SHARE_TEMPLATE" => "",
		"SHARE_HANDLERS" => array(
			0 => "vk",
			1 => "lj",
			2 => "facebook",
			3 => "twitter",
		),
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_SHORTEN_URL_KEY" => "",
		"PATH_TO_SONET_USER_PROFILE" => "/club/user/#user_id#/",
		"PATH_TO_MESSAGES_CHAT" => "/club/messages/chat/#user_id#/",
		"ALLOW_POST_MOVE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"group" => "top-authors/",
			"blog" => "#blog#/",
			"user" => "#user_id#/user/",
			"user_friends" => "#blog#/friends/",
			"search" => "search/",
			"user_settings" => "#blog#/user_settings.php",
			"user_settings_edit" => "#blog#/user_settings_edit.php?id=#user_id#",
			"group_edit" => "#blog#/group_edit.php",
			"blog_edit" => "#blog#/blog_edit.php",
			"category_edit" => "#blog#/category_edit.php",
			"post_edit" => "#blog#/post_edit/#post_id#/",
			"draft" => "nocategory/#category_id#/",
			"moderation" => "#blog#/category/#category_id#/",
			"trackback" => POST_FORM_ACTION_URI."&blog=#blog#&id=#post_id#&page=trackback",
			"post" => "#blog#/#post_id#/",
			"post_rss" => "#blog#/rss/#type#/#post_id#",
			"rss" => "#blog#/rss/#type#",
			"rss_all" => "rss/#type#/#group_id#",
		),
		"VARIABLE_ALIASES" => array(
			"user_settings_edit" => array(
				"user_id" => "id",
			),
			"trackback" => array(
				"blog" => "blog",
				"post_id" => "id",
			),
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>