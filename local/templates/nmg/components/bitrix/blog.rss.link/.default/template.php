<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult))
{
	?>
	<div>
		<a href="<?=$arResult[0]["url"]?>" title="<?=$arResult[0]["name"]?>" class="rss-icon"></a>
	</div>
	<?
}
?>