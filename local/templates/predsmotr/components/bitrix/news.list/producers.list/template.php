<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="goods">
    <h2>Популярные производители</h2>
    <div class="manufacturer_list">
<?foreach($arResult["ITEMS"] as $key => $arItem):?>
	
    <?if(!empty($arItem["PREVIEW_PICTURE"]["ID"])):?>
    <div class="item<?if($key == 0):?> first<?endif?><?if($key+1 == count($arResult["ITEMS"])):?> last<?endif?>">
		<a href="?arrLeftFilter_pf[CH_PRODUCER][]=<?=$arItem["ID"]?>&set_filter=Y"><?=ShowImage($arItem["PREVIEW_PICTURE"]["ID"],150,150)?></a>
	</div>
    <?endif;?>
<?endforeach?>
<div class="clear"></div>        
    </div>
</div>
<?endif;?>