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
		<?if($dir==$arResult["urlToOwnBlog"]."post_edit/new/" || !$USER->IsAuthorized()):?>
		<div class="newWrite disactive"></div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>post_edit/new/" alt="Новая запись" title="Новая запись" class="newWrite"></a>
		<?endif?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]."feed/"):?>
		<div class="link">Лента сообщений</div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>feed/" class="link">Лента сообщений</a>
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
		<a href="<?=$arResult["urlToOwnBlog"]?>" class="link">Мой блог</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]."friends/"):?>
		<div class="link">Мои подписчики</div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>friends/" class="link">Мои подписчики</a>
		<?endif;?>
		
		<span class="blogLine"></span>
		<?
		}
		?>
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



