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
		<a href="<?=$arResult["urlToOwnBlog"]?>post_edit/new/" alt="����� ������" title="����� ������" class="newWrite"></a>
		<?endif?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]."feed/"):?>
		<div class="link">����� ���������</div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>feed/" class="link">����� ���������</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir=="/community/group/"):?>
		<div class="link">����������</div>
		<?else:?>
		<a href="/community/group/" class="link">����������</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]):?>
		<div class="link">��� ����</div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>" class="link">��� ����</a>
		<?endif;?>
		<span class="blogLine"></span>
		<?if($dir==$arResult["urlToOwnBlog"]."friends/"):?>
		<div class="link">��� ����������</div>
		<?else:?>
		<a href="<?=$arResult["urlToOwnBlog"]?>friends/" class="link">��� ����������</a>
		<?endif;?>
		
		<span class="blogLine"></span>
		<?
		}
		?>
		<div class="search">
		<?$APPLICATION->IncludeComponent("bitrix:search.form", "searchBlog", Array(
	"PAGE" => "#SITE_DIR#community/blog/search/",	// �������� ������ ����������� ������ (�������� ������ #SITE_DIR#)
	),
	false
);?>
		</div>
	</div>
	<div class="blogRightMenu"></div>
</div>



