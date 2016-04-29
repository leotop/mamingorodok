<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="consultation">
		<h2 class="h2Consultation">Последние комментарии</h2>
<?
foreach($arResult as $arComment)
{
	//print_R($arComment["AUTHOR_NAME"]);
	?>
	<div class="item_content">
	<?if(!empty($arComment["AuthorName"])):?>
		<?$name = $arComment["AuthorName"];?>
	<?else:?>
		<?$name = $arComment["arUser"]["LOGIN"];?>
	<?endif?>
	<?if(!empty($arComment["Blog"]["URL"])):?>
		<a href="/community/blog/<?=$arComment["Blog"]["URL"]?>/"><?=$name?></a>
	<?else:?>
		<?=$name?>
	<?endif?>
	
	<img class="line" src="<?=SITE_TEMPLATE_PATH;?>/images/blog/right_line.png"> 
	<a href="<?=$arComment["urlToComment"]?>" class="grey"><?=substr($arComment["TEXT_FORMATED"],0,100)."..."?></a>
	</div>
	
	<?
}
?>	
</div>