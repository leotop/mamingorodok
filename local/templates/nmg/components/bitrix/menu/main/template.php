<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="mainmenu">
<table width="100%" cellspacing="0" cellpadding="0" border="0" >
<?
$i=1;
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<td><a href="<?=$arItem["LINK"]?>" id="mainmenu0<?=$i?>" class="menuhover selected"></a><a href="<?=$arItem["LINK"]?>" id="mainmenu<?=$i?>" class="selected"><?=$arItem["TEXT"]?></a></td>
	<?else:?>
		<td><a href="<?=$arItem["LINK"]?>" id="mainmenu0<?=$i?>" class="menuhover"></a><a href="<?=$arItem["LINK"]?>" id="mainmenu<?=$i?>"><?=$arItem["TEXT"]?></a></td>
	<?endif?>
	<?$i++;?>
<?endforeach?>

</table>
</div>
<?endif?>