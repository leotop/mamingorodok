<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="bottommenu">
<ul>
<?
$i=0;
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li <?if($i==0) echo "id='nostyle'"?>><a href="<?=$arItem["LINK"]?>"  class="selected"><?=$arItem["TEXT"]?></a></li>
	<?else:?>
		<li <?if($i==0) echo "id='nostyle'"?>><a href="<?=$arItem["LINK"]?>" ><?=$arItem["TEXT"]?></a></li>
	<?endif?>
	<?$i++;?>
<?endforeach?>

</ul>
</div>
<?endif?>