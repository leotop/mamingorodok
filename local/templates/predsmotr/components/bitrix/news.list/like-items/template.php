<?
if(!empty($arResult["ITEMS"]))
{ ?>
<div class="crumbs indent1">Похожие товары</div>
<div class="similar_block">
	<ul><?
	foreach($arResult["ITEMS"] as $arLikeItem)
	{?>
		<li>
			<div class="photo">
				<p><img src="<?=$arLikeItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arLikeItem["NAME"]?>" /><span>&nbsp;</span></p>
			</div>
			<?=showRating($arLikeItem["PROPERTIES"]["RATING"]["VALUE"])?>
			<div class="link"><a href="<?=$arLikeItem["DETAIL_PAGE_URL"]?>" title="<?=$arLikeItem["NAME"]?>"><?=smart_trim($arLikeItem["NAME"], 50)?></a></div>
			<strong><?=CurrencyFormat($arLikeItem["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></strong>
		</li><?
	}?>
	</ul>
</div><?
}
?>