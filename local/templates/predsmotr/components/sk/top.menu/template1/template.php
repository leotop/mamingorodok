<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();



function formatItem($arI, $arResult)
{?>
	<div class="sk-menu-offer-item"><?
	if($arI["PREVIEW_PICTURE"]) {
		if($arResult["ITEM2ACTION"][$arI["ID"]])
		{
			$arAction = $arResult["ACTIONS"][$arResult["ITEM2ACTION"][$arI["ID"]]];
			$isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;

			if($isSpecOffer)
			{?>
				<div class="wrap-specialoffert">
				<a href="<?=$arI['DETAIL_PAGE_URL']?>" title="Спецпредложение!" class="btt-specialoffert">Спецпредложение!</a></div><?
			}?>
			<div class="prize"><?
			if(!$isSpecOffer)
			{?>
				<a href="#" target="_blank"><div class="gift_bg"></div></a><?
			}?>
			<div class="gift_info ">
				<div class="gift_info_text">
					<div style="text-align: center;">Акция!</div> <?=$arAction["PREVIEW_TEXT"]?>
				</div><div class="gift_info_bg"></div></div></div><?
		}
		?>
	<a href="<?=$arI["DETAIL_PAGE_URL"]?>" title="<?=$arI['~NAME']?>"><div class="photo"><p><?=ShowImage($arI["PREVIEW_PICTURE"], 160, 160)?><span>&nbsp;</span></p></div></a><?
	} ?>
		<div class="link"><a href="<?=$arI["DETAIL_PAGE_URL"]?>" title="<?=$arI['~NAME']?>"><?=smart_trim($arI['NAME'], 50)?></a></div>
	<span class="s_like"><?=str_replace("р", ' <span class="rub">&#101;</span>', CurrencyFormat($arI["PROPERTY_PRICE_VALUE"], "RUB"))?></span><?
	if($arI["PROPERTY_OLD_PRICE_VALUE"]>0)
	{?>
		<i><?=CurrencyFormat($arI["PROPERTY_OLD_PRICE_VALUE"], "RUB")?></i><?
	}
	?>
	</div><?
}

?>


<?

if($USER -> IsAdmin()) { ?>




  <div class="wrap-sk-menu-abc">
    <ul class="sk-menu-abc">
<li>Бренды:</li>
      <li><a href="#">A</a></li>
      <li><a href="#">B</a></li>
      <li><a href="#">C</a>
        <ul class="sk-menu-abc-sub">
          <li><a href="#">Casualplay</a></li>
          <li><a href="#">Chepe</a></li>
          <li><a href="#">Chicco</a></li>
          <li><a href="#">Christ</a></li>
          <li><a href="#">Clek</a></li>
          <li><a href="#">Clippasafe</a></li>
          <li><a href="#">Cloud factory</a></li>
          <li><a href="#">Concord</a></li>
        </ul>
      </li>
      <li><a href="#">D</a></li>
      <li><a href="#">E</a></li>
      <li><a href="#">F</a></li>
      <li><a href="#">G</a></li>
      <li><a href="#">H</a></li>
      <li><a href="#">I</a></li>
      <li><a href="#">J</a></li>
      <li><a href="#">K</a></li>
      <li><a href="#">L</a></li>
      <li><a href="#">M</a></li>
      <li><a href="#">N</a></li>
      <li><a href="#">O</a></li>
      <li><a href="#">P</a></li>
      <li><a href="#">Q</a></li>
      <li><a href="#">R</a></li>
      <li><a href="#">S</a></li>
      <li><a href="#">T</a></li>
      <li><a href="#">U</a></li>
      <li><a href="#">V</a></li>
      <li><a href="#">W</a></li>
      <li><a href="#">X</a></li>
      <li><a href="#">Y</a></li>
      <li><a href="#">Z</a></li>
      <li><a href="#">А-Я</a></li>
      <li><a href="#">123</a></li>
      <li><a href="#">Все</a></li>
    </ul>
  </div>

<? } ?>
<!-- New menu-->
<div class="sk-menu">


	<ul class="sk-menu_main"><?
		foreach($arResult["SECTIONS"] as $arSection) {
			$arSec = $arSection["DATA"];
			?>
		<li<?=(strlen($arSec["TITLE"]) < 13 ? ' class="sk-menu-oneline"' : '')?> data-for="topSec<?= $arSec["ID"] ?>">
			<a href="<?= $arSec["SECTION_PAGE_URL"] ?>" title="<?= $arSec["NAME"] ?>"><?=$arSec["TITLE"]?></a></li><?
		} ?>
		<li class="sk-menu-oneline sk-menu-brand" data-for="brand"><a href="#" title="">Бренды</a></li>
	</ul>
	<div class="sk-menu-dropdown"><?
		foreach($arResult["SECTIONS"] as $arSec) {
			$intRootSectionID = $arSec["DATA"]["ID"]; ?>
		<div class="sk-menu-dropdown--item" data-name="topSec<?= $arSec["DATA"]["ID"] ?>" style="display: none;">
			<table>
				<tr>
					<td>
						<div class="sk-menu-dropdown--head"><?=$arSec["DATA"]["NAME"]?></div>
						<ul class="sk-menu_sub"><?
							foreach($arSec["SUBSECTIONS"] as $arSubSec) {
								?>
								<li><a href="<?= $arSubSec["SECTION_PAGE_URL"] ?>" title="<?=$arSubSec["NAME"]?>"><?=$arSubSec["NAME"]?></a>
								</li><?
							}?>
						</ul>
					</td><?
					$strProducers = '';
					foreach($arResult["SECTION_TO_PRODUCER"][$intRootSectionID] as $intProdID)
					{
						$arProd = $arResult["PRODUCERS"][$intProdID];
						$strProducers .= '<li><a href="/catalog/'.$arSec["DATA"]["CODE"].'/proizvoditel_'.$arProd["CODE"].'/" title="'.$arProd["NAME"].'">'.$arProd["NAME"].'</a></li>';
					}

					if(strlen($strProducers)>0)
					{ ?>
					<td>
						<div class="sk-menu-dropdown--head">Популярные бренды</div>
						<ul class="sk-menu_sub"><?=$strProducers?></ul>
					</td><?
					}

					if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_BEST"]])
					{?>
					<td>
						<div class="sk-menu-offer-head">Самый лучший</div>
						<?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_BEST"]], $arResult)?>
					</td><?
					}

					if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_POPULAR"]])
					{ ?>
					<td>
						<div class="sk-menu-offer-head">Самый популярный</div>
						<?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_POPULAR"]], $arResult)?>
					</td><?
					}

					if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_RECOMMEND"]])
					{ ?>
					<td>
						<div class="sk-menu-offer-head">Мы рекомендуем</div>
						<?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_RECOMMEND"]], $arResult)?>
					</td><?
					} ?>
				</tr>
			</table>
			</div><?
		}

		$intColCnt = 7;
		$intItemsPerCol = ceil((count($arResult["PRODUCERS"]) + 15) / 6);
		?>
		<div class="sk-menu-dropdown--item" data-name="brand" style="display: none;">
			<div class="sk-menu-dropdown--head sk-menu-dropdown--head_brand">Бренды по алфавиту</div>
			<table class="sk-menu-brandlist">
				<tr>
					<td><?
						$strLastLetter = '';
						$intCurrentCnt = 0;
						foreach($arResult["PRODUCERS"] as $arProd) {
							$strLetter = ToUpper(substr($arProd["NAME"], 0, 1));
							if($intCurrentCnt >= $intItemsPerCol) {
								echo '</td><td>';
								$intCurrentCnt = 0;
							}

							if($strLetter != $strLastLetter) {
								echo '<div class="sk-menu-brandlist-letter">'.$strLetter.'</div>';
								$intCurrentCnt++;
							}

							$strLastLetter = $strLetter;

							echo '<i title="/catalog/brend-'.$arProd["CODE"].'/">'.$arProd["NAME"].'</i>';

							$intCurrentCnt++;
						}?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>