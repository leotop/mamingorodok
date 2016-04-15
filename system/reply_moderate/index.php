<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Модерация отзывов");

if($USER -> IsAdmin())
{
	if($_REQUEST["deleteSpam"] == "Y")
	{
		$strSql = "delete from b_forum_message where APPROVED='N' AND POST_DATE<='".date("Y-m-d H:i:s", time() - 60*60*24)."'";
		$rs = $DB->Query($strSql, false, $err_mess.__LINE__);
		
		// update forum
		$strSql = "SELECT COUNT(ID) as messageCnt from b_forum_message where APPROVED='N' AND FORUM_ID=1";
		$rsMessageCount = $DB->Query($strSql, false, $err_mess.__LINE__);
		$arMessageCount = $rsMessageCount -> Fetch();
		$DB->Query("UPDATE b_forum SET POSTS_UNAPPROVED=".$arMessageCount["messageCnt"]." WHERE ID=1", false, $err_mess.__LINE__);
		
		// update topics
		$DB->Query("UPDATE b_forum_topic SET POSTS_UNAPPROVED=0 WHERE FORUM_ID=1", false, $err_mess.__LINE__);
		
		$strSql = "SELECT TOPIC_ID, COUNT(ID) as messageCnt from b_forum_message where APPROVED='N' AND FORUM_ID=1 GROUP BY TOPIC_ID";
		$rsMessageCount = $DB->Query($strSql, false, $err_mess.__LINE__);
		while($arMessageCount = $rsMessageCount -> Fetch())
			$DB->Query("UPDATE b_forum_topic SET POSTS_UNAPPROVED=".$arMessageCount["messageCnt"]." WHERE ID=".$arMessageCount["TOPIC_ID"], false, $err_mess.__LINE__);
		
		BXClearCache(true, "/s1/bitrix/forum/");
		BXClearCache(true, "/s1/bitrix/forum.index/");
		BXClearCache(true, "/s1/bitrix/forum.statistic/");
		BXClearCache(true, "/s1/bitrix/forum.topic.list/");
		
		LocalRedirect("/system/reply_moderate/?clear_cache=Y");
	}
	?><a href="<?=$APPLICATION->GetCurPage()?>?deleteSpam=Y">Удалить все неодобренные отзывы, старше 24 часов</a><br><br><?
}

?><?$APPLICATION->IncludeComponent(
	"bitrix:forum",
	"",
	Array(
		"THEME" => "blue",
		"SHOW_TAGS" => "Y",
		"SHOW_AUTH_FORM" => "Y",
		"SHOW_NAVIGATION" => "Y",
		"SHOW_SUBSCRIBE_LINK" => "N",
		"SHOW_LEGEND" => "Y",
		"SHOW_STATISTIC" => "Y",
		"SHOW_NAME_LINK" => "Y",
		"SHOW_FORUMS" => "Y",
		"SHOW_FIRST_POST" => "N",
		"SHOW_AUTHOR_COLUMN" => "N",
		"TMPLT_SHOW_ADDITIONAL_MARKER" => "",
		"SMILES_COUNT" => "100",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"PATH_TO_ICON" => "/bitrix/images/forum/icon/",
		"PAGE_NAVIGATION_TEMPLATE" => "forum",
		"PAGE_NAVIGATION_WINDOW" => "5",
		"AJAX_POST" => "N",
		"WORD_WRAP_CUT" => "23",
		"WORD_LENGTH" => "50",
		"SEO_USER" => "N",
		"USE_LIGHT_VIEW" => "Y",
		"SEF_MODE" => "N",
		"CHECK_CORRECT_TEMPLATES" => "Y",
		"FID" => array("1"),
		"USER_PROPERTY" => array(),
		"FILES_COUNT" => "5",
		"HELP_CONTENT" => "",
		"RULES_CONTENT" => "",
		"FORUMS_PER_PAGE" => "10",
		"TOPICS_PER_PAGE" => "10",
		"MESSAGES_PER_PAGE" => "10",
		"PATH_TO_AUTH_FORM" => "",
		"TIME_INTERVAL_FOR_USER_STAT" => "10",
		"DATE_FORMAT" => "d.m.Y",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"IMAGE_SIZE" => "500",
		"EDITOR_CODE_DEFAULT" => "N",
		"SEND_MAIL" => "E",
		"SEND_ICQ" => "A",
		"SET_NAVIGATION" => "Y",
		"SET_TITLE" => "Y",
		"SET_PAGE_PROPERTY" => "Y",
		"USE_RSS" => "N",
		"SHOW_FORUM_ANOTHER_SITE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"CACHE_TIME_USER_STAT" => "60",
		"SHOW_VOTE" => "N",
		"SHOW_RATING" => "",
		"RATING_ID" => array(),
		"RATING_TYPE" => "",
		"VARIABLE_ALIASES" => Array(
			"FID" => "FID",
			"TID" => "TID",
			"MID" => "MID",
			"UID" => "UID"
		)
	),
false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>