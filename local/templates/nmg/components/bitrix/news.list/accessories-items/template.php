<?
if(!empty($arResult["ITEMS"]))
{ ?>
<?=showNoindex()?>
<div class="crumbs indent2">Также рекомендуем</div>
<div class="similar_block similar_block_right">
	<ul><?
	foreach($arResult["ITEMS"] as $akey => $arAccItem)
	{?>
		<li>
			<div class="photo">
				<p><a rel="nofollow" href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><img src="<?=$arAccItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arAccItem["NAME"]?>" /><span>&nbsp;</span></a></p>
			</div>
			<?=showRating($arAccItem["PROPERTIES"]["RATING"]["VALUE"])?>
			<div class="link"><a rel="nofollow" href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><?=smart_trim($arAccItem["NAME"], 45)?></a></div>
			<strong><?=CurrencyFormat($arAccItem["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></strong>
		</li><?
	}?>
	</ul>
</div>
<?=showNoindex(false)?><?
}
?>