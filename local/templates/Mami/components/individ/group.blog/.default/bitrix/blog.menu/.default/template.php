<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

?>

<?
global $APPLICATION, $USER;
$dir = $APPLICATION->GetCurDir();
?>
<div class="blogMenu">
	<div class="blogLeftMenu"></div>
	<div class="blogCenterMenu">
		<?
		if(strlen($arResult["urlToOwnBlog"])>0)
		{
		?>
		<?if($dir=="/community/group/".$arResult["Blog"]["URL"]."/post_edit/new/" || !$USER->IsAuthorized() || empty($arResult["Blog"]["URL"])):?>
		<div class="newWrite disactive"></div>
		<?else:?>
		<a href="/community/group/<?=$arResult["Blog"]["URL"]?>/post_edit/new/" alt="Новая запись" title="Новая запись" class="newWrite"></a>
		<?endif?>
		<span class="blogLine"></span>
		<?if($dir=="/community/group/".$arResult["Blog"]["URL"]."feed/"):?>
		<div class="link">Лента сообщений</div>
		<?else:?>
		<a href="/community/blog/<?=$arResult["OwnBlog"]["URL"]?>/feed/" class="link">Лента сообщений</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir=="/community/group/"):?>
		<div class="link">Сообщества</div>
		<?else:?>
		<a href="/community/group/" class="link">Сообщества</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]):?>
		<div class="link">Мой блог</div>
		<?else:?>
		<a href="/community/blog/<?=$arResult["OwnBlog"]["URL"]?>/" class="link">Мой блог</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]."friends/"):?>
		<div class="link">Мои подписчики</div>
		<?else:?>
		<a href="/community/blog/<?=$arResult["OwnBlog"]["URL"]?>/friends/" class="link">Мои подписчики</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?
		}
		else{
		?>
			<a href="#showMsg" alt="Новая запись" title="Новая запись" class="newWrite"></a>
		<?}?>
		<div class="search">
		<?$APPLICATION->IncludeComponent("bitrix:search.form", "searchBlog", Array(
	"PAGE" => "#SITE_DIR#community/blog/search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
	),
	false
);?>
		</div>
	</div>
	<div class="blogRightMenu"></div>
</div>
<div class="no_slide">
	<div class="white_plash sliddd">
		<div class="exitpUp"></div>
		<div class="cn tl"></div>
		<div class="cn tr"></div>
		<div class="content">
		<div class="content">
		<div class="content">
		<div class="clear"></div>
		Для голосования вам необходимо <a href="/personal/registaration/">зарегистрироваться</a><br />или <a href="/personal/auth/">войти на сайт</a>.
		<div class="clear"></div>
		</div>
		</div>
		</div>
		<div class="cn bl"></div>
		<div class="cn br"></div>
	</div>
</div>


