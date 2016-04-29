<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="consultation">
		<h2 class="h2Consultation">Последние комментарии</h2>
<?
foreach($arResult as $arComment)
{
	?>
	<div class="item_content">
		
		<?
			
	if (COption::GetOptionString("blog", "allow_alias", "Y") == "Y" && (strlen($arComment["urlToBlog"]) > 0 || strlen($arComment["urlToAuthor"]) > 0) && array_key_exists("ALIAS", $arComment["BlogUser"]) && strlen($arComment["BlogUser"]["ALIAS"]) > 0)
		$arTmpUser = array(
			"NAME" => "",
			"LAST_NAME" => "",
			"SECOND_NAME" => "",
			"LOGIN" => "",
			"NAME_LIST_FORMATTED" => $arComment["BlogUser"]["~ALIAS"],
			);
	elseif (strlen($arComment["urlToBlog"]) > 0 || strlen($arComment["urlToAuthor"]) > 0)
		$arTmpUser = array(
			"NAME" => $arComment["arUser"]["~NAME"],
			"LAST_NAME" => $arComment["arUser"]["~LAST_NAME"],
			"SECOND_NAME" => $arComment["arUser"]["~SECOND_NAME"],
			"LOGIN" => $arComment["arUser"]["~LOGIN"],
			"NAME_LIST_FORMATTED" => "",
		);
	?>
	<?if(strlen($arComment["urlToBlog"])>0)
	{
		<?
		$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.user.link",
			'',
			array(
				"ID" => $arComment["arUser"]["ID"],
				"HTML_ID" => "blog_new_comments_".$arComment["arUser"]["ID"],
				"NAME" => $arTmpUser["NAME"],
				"LAST_NAME" => $arTmpUser["LAST_NAME"],
				"SECOND_NAME" => $arTmpUser["SECOND_NAME"],
				"LOGIN" => $arTmpUser["LOGIN"],
				"NAME_LIST_FORMATTED" => $arTmpUser["NAME_LIST_FORMATTED"],
				"USE_THUMBNAIL_LIST" => "N",
				"PROFILE_URL" => $arComment["urlToAuthor"],
				"PROFILE_URL_LIST" => $arComment["urlToBlog"],							
				"PATH_TO_SONET_MESSAGES_CHAT" => $arParams["~PATH_TO_MESSAGES_CHAT"],
				"PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
				"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
				"SHOW_YEAR" => $arParams["SHOW_YEAR"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
				"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
				"PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
				"PATH_TO_SONET_USER_PROFILE" => $arParams["~PATH_TO_SONET_USER_PROFILE"],
				"INLINE" => "Y",
				"SEO_USER" => $arParams["SEO_USER"],
			),
			false,
			array("HIDE_ICONS" => "Y")
		);
		?>
		<?
	}
	elseif(strlen($arComment["urlToAuthor"])>0)
	{
		<?
		$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.user.link",
			'',
			array(
				"ID" => $arComment["arUser"]["ID"],
				"HTML_ID" => "blog_new_comments_".$arComment["arUser"]["ID"],
				"NAME" => $arTmpUser["NAME"],
				"LAST_NAME" => $arTmpUser["LAST_NAME"],
				"SECOND_NAME" => $arTmpUser["SECOND_NAME"],
				"LOGIN" => $arTmpUser["LOGIN"],
				"NAME_LIST_FORMATTED" => $arTmpUser["NAME_LIST_FORMATTED"],
				"USE_THUMBNAIL_LIST" => "N",
				"PROFILE_URL" => $arComment["urlToAuthor"],
				"PATH_TO_SONET_MESSAGES_CHAT" => $arParams["~PATH_TO_MESSAGES_CHAT"],
				"PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
				"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
				"SHOW_YEAR" => $arParams["SHOW_YEAR"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
				"SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
				"PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
				"PATH_TO_SONET_USER_PROFILE" => $arParams["~PATH_TO_SONET_USER_PROFILE"],
				"INLINE" => "Y",
				"SEO_USER" => $arParams["SEO_USER"],
			),
			false,
			array("HIDE_ICONS" => "Y")
		);
		?>
		<?
	}
	else
	{
		?>
		<?=$arComment["AuthorName"]?>
	
	<?}?>
	
	<img class="line" src="<?=SITE_TEMPLATE_PATH;?>/images/blog/right_line.png"> 
	<a href="<?=$arComment["urlToComment"]?>" class="grey"><?=$arComment["TEXT_FORMATED"]?></a>
	<a href="/community/group/1/1/" >По-моему это правильно</a>
	</div>
	
	<?
}
?>	
</div>