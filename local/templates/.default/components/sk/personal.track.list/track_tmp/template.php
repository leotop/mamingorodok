<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(count($arResult["ITEMS"]) > 0) { ?>
<form class="jqtransform">
	<table class="sale_basket_basket data-table">
		<tr class="firstLine">
			<th class="th1" colspan="2">Товар</th>
			<th class="th2">Цена</th>
			<th class="th3"></th>
			<th class="th4"></th>
		</tr><?
	foreach($arResult["ITEMS"] as $intID => $arI) {
		if($arI["IMAGE"] > 0) {
			$arFileTmp = CFile::ResizeImageGet(
				$arI["IMAGE"],
				array("width" => 100, 'height' => 100),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);
		}
		?>
		<tr>
			<td class="td1"><a href="<?=$APPLICATION->GetCurPage()?>?deleteID=<?=$arI["TRACK_ID"]?>" class="delete"></a></td>
			<td class="td2">
				<div class="bskt_img">
					<img src='<?=$arFileTmp["src"];?>'></div>
				<div class="bskt_info">
					<div class="bskt_lnk"><a href="<?=$arI["DETAIL_PAGE_URL"]?>"><?=$arI["NAME"]?></a></div>
					<div class="bskt_rtg"></div><?
					if(!empty($arI["PROPERTY_COLOR_NAME"]))
						echo '<div class="bskt_color">Цвет: '.$arI["PROPERTY_COLOR_NAME"].'</div>';
					if(!empty($arI["PROPERTY_SIZE_VALUE"]))
						echo '<div class="bskt_size">'.(empty($arI["PROPERTY_MAIN_PRODUCT_PROPERTY_CH_VYBIRAEM_VALUE"])?'Размер':$arI["PROPERTY_MAIN_PRODUCT_PROPERTY_CH_VYBIRAEM_VALUE"]).': '.$arI["PROPERTY_SIZE_VALUE"].'</div>'; ?>
				</div>
				<div class="clear"></div>
			</td>
			<td class="td3"><?
				if(isset($arI["MIN_PRICE"]))
					echo CurrencyFormat(intval($arI["MIN_PRICE"]), "RUB");
				else echo CurrencyFormat(intval($arI["CATALOG_PRICE_1"]), "RUB");
				 ?> </td>
			<td class="td4"></td>
			<td class="td5"><? if(!isset($arI["MIN_PRICE"]) && $arI["CATALOG_CAN_BUY_1"] == "Y") { ?><a onclick="return addProductToCart(<?=$arI["ID"]?>);" class="fr" href="<?=$arI["DETAIL_PAGE_URL"]?>"><input type="button" value="Купить"></a><? } ?></td>
		</tr><?
	}
	?>
	</table>
</form><?
} else echo 'Ваш список ожидания пуст';
//arshow($arResult);
