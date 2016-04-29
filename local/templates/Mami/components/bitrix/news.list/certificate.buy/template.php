<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="certificate-val">
<?$i=0;?>
	<form class="jqtransform" >
<?foreach($arResult["ITEMS"] as $arItem):?>
	
	<div class="certificate-item">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
	<?=ShowImage($arItem["PREVIEW_PICTURE"]["ID"],70,70, 'class="flcr"');?>
	<?endif;?>
	<div class="right-right">
	<?=$arItem["DISPLAY_PROPERTIES"]["PRICE"]["VALUE"]?> руб.
	<input class="number" id="number_<?=$arItem["ID"]?>" type="text" value="1">
	<input class="check" type="checkbox" value="<?=$arItem["ID"]?>">
	<div class="nodisplay" id="cerf_<?=$arItem["ID"]?>"><?=$arItem["DISPLAY_PROPERTIES"]["PRICE"]["VALUE"]?></div>
	</div>
	</div>
	<?$i++;?>
	<?if($i==2){
	?>
	<div class="clear"></div>
	<?
	$i=0;
	}?>
<?endforeach;?>
	</form>
<?if($arParams["DISPLAY_BOTTOM_PAGER"] && !empty($arResult["NAV_STRING"])):?>
	<div class="clear"></div>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
	<div class="clear"></div>
	<br />
	<div class="sum nodisplay">Выбрано на <span class="showsum">0</span> <span>рублей</span></div>
	<div class="clear"></div>
	<input type="submit" value="Купить" class="purple" id="certificateBuyBtn"><br>
	<p class="infopay">Оплата производится через систему <a href="http://www.assist.ru/">Assist</a> банковской картой</p>
	<p class="infopayinfo"><a href="/certificates/">Как использовать сертификат?</a></p>
</div>
