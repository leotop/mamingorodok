<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult))
{
	$previousLevel = 0;
	foreach($arResult as $arItem)
	{
		if($arItem["DEPTH_LEVEL"] == 1)
		{
			if($previousLevel == 2) echo '</ul>';
			echo '<h3>'.$arItem["TEXT"].'</h3>';
			if($arItem["IS_PARENT"]) echo '<ul class="submenu">';
		} else {
			?><li><a<?=($arItem["SELECTED"]?' class="active"':'')?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a></li><?
		}
		$previousLevel = $arItem["DEPTH_LEVEL"];
}

if ($previousLevel == 2) echo '</ul>';
}?>