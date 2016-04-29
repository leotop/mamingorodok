<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if(empty($arResult))
	echo GetMessage("SONET_BLOG_EMPTY");
?>
<div class="consultation">
<h2 class="h2Consultation">Популярные записи</h2>
<?	
foreach($arResult as $arPost)
{
	?>
	
	<div class="item_content">
		<a href="/community/blog/<?=$arPost["BLOG_URL"]?>/"><?=$arPost["USER_NAME"]?></a> <img class="line" src="<?=SITE_TEMPLATE_PATH;?>/images/blog/right_line.png"> <a href="<?=$arPost["urlToPost"]?>"><?echo $arPost["TITLE"]; ?></a>
		</div>
	
	
	<?
	/**/

}

?>	
</div>