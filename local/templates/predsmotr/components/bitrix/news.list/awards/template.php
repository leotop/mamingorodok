<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?if(count($arResult["ITEMS"])>0):?>
<?foreach($arResult["ITEMS"] as $arItem):?>
				<div class="blockawards">
					<div class="imgaward"><?=ShowImage($arItem["PREVIEW_PICTURE"]["ID"],100,100)?></div>
					<div div="textaward">
						<div class="nameaward"><?=$arItem["NAME"]?></div>
						<div class="textaward"><?=$arItem["PREVIEW_TEXT"]?></div>
					</div>
					<div class="clear"></div>
				</div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>

<?else:?>
	<div class="notetext">Вы еше не получали наград.</div>
<?endif;?>
</div>
