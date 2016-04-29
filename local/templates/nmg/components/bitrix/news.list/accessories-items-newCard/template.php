<?
if(!empty($arResult["ITEMS"]))
{ ?>
<?=showNoindex()?>
<div class="sk-accessory-block" id="detailAccessories"> 
	<!-- similar_block -->
	<div class="similar_block similar_block_right">
		<div class="crumbs_black">Рекомендуем</div>
		<ul class="sk-accessory-slider jcarousel jcarousel-skin-accessory"><?
	foreach($arResult["ITEMS"] as $akey => $arAccItem)
	{
		$smallImg = CFile::ResizeImageGet($arAccItem["PREVIEW_PICTURE"]["ID"], array("width"=>100, "height"=>100), BX_RESIZE_IMAGE_PROPORTIONAL);?>
			<li<?=($akey==count($arResult["ITEMS"])-1?' class="last-child"':'')?>>
				<div class="photo">
					<p><a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><img src="<?=$smallImg["src"]?>" alt="<?=$arAccItem["NAME"]?>" /><span>&nbsp;</span></a></p>
				</div>
				<div class="link"><a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><?=smart_trim($arAccItem["NAME"], 35)?></a></div>
				<span class="acess_price"><?=CurrencyFormat($arAccItem["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>
			</li><?
	}?>
		</ul>
	</div>
	<!-- END similar_block --> 
</div>
<?=showNoindex(false)?>
<?
}
?>
