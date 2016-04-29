<?
$i=0;
foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem) {
    if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0)
        $i++;
}?>
<div id="FPictureBlock">
<h1><?=$arResult["NAME"]?></h1>

<?
$color_name = "";
foreach($arResult["LINKED_ITEMS"] as $k=>$v):
	if($v["PROPERTY_PICTURE_MAXI_VALUE"]==$_REQUEST["IMG_ID"])
		$color_name = $v["PROPERTY_COLOR_VALUE"];
endforeach
?>


<div class="DPicture bpictureCenter">
	<div class="rel">
    <?$arImage = CFile::GetFileArray($_REQUEST["IMG_ID"]);?>
    <?if ($_REQUEST["IMG_ID"] > 0):?>
		<?=ShowImage($arImage["SRC"],500,500,"border='0'")?>
    <?else:?>
		<?=ShowImage($arResult["DETAIL_PICTURE"]["ID"],500,500,"border='0'")?>
    <?endif?>
		<?if(!empty($color_name)):?>
			<div class="colorO">÷вет: <?=$color_name?></div>
		<?endif;?>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	
	<div class="DPictureListArea2">
	<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 + $i) > 10):?>
		<div class="prev"></div>
	<?endif?>
	<div class="DPictureList<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 + $i) > 10):?> DPictureListCarousel2<?else:?> DPictureListCarouselNwsSize2<?endif;?>">
		<ul>
			<li>
				<a href="/inc/picture_view.php?ELEMENT_ID=<?=$_REQUEST["ELEMENT_ID"]?>&IMG_ID=<?=$arResult["DETAIL_PICTURE"]["ID"]?>"><img src="<?=MegaResizeImage($arResult["DETAIL_PICTURE"]["ID"], 64, 64)?>" /></a>
				<span class="midi-picture-src" style="display:none;"><?=MegaResizeImage($arResult["DETAIL_PICTURE"]["ID"], 256, 256)?></span>
				<span class="picture-id" style="display:none;"><?=$arResult["DETAIL_PICTURE"]["ID"]?></span>
			</li><?
		foreach($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"] as $img_id)
		{?>
			<li>
				<a href="/inc/picture_view.php?ELEMENT_ID=<?=$_REQUEST["ELEMENT_ID"]?>&IMG_ID=<?=$img_id?>"><img src="<?=MegaResizeImage($img_id, 32, 32)?>" /></a>
			</li><?
		}
		
		if(false)
		{
		foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem) // изображени€ цветоразмеров (только разные цвета)
		{
			if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0)
			{?>
			<li>
				<a href="/inc/picture_view.php?ELEMENT_ID=<?=$_REQUEST["ELEMENT_ID"]?>&IMG_ID=<?=$arColorItem["PROPERTY_PICTURE_MAXI_VALUE"]?>"><img src="<?=MegaResizeImage($arColorItem["PROPERTY_PICTURE_MINI_VALUE"], 64, 64)?>" /></a>
				<span class="midi-picture-src" style="display:none;"><?=MegaResizeImage($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"], 256, 256)?></span>
				<span class="picture-id" style="display:none;"><?=$arColorItem["PROPERTY_PICTURE_MAXI_VALUE"]?></span>
			</li><?
			}
		}
		}?>            
		</ul>
		<div class="clear"></div>
	</div>
	<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 + $i) > 10):?>
		<div class="next"></div>
	<?endif?>
	<div class="clear"></div>
	</div>
	
</div>
</div>