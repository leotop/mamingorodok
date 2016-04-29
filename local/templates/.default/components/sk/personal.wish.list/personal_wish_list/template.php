<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
     
if(count($arResult["ITEMS"]) > 0) { ?>
	<form id="frmWishlist" action="<?=$APPLICATION->GetCurPage()?>" class="jqtransform">
		<table class="sale_basket_basket data-table">
			<tr class="firstLine">
				<th colspan="2">Товар</th>
				<th class="th4">Цена</th>
			</tr><?
			foreach($arResult["ITEMS"] as $intID => $arI) {
                
				if($arI["PROPERTY_PRODUCT_ID_PREVIEW_PICTURE"] > 0) {
					$arFileTmp = CFile::ResizeImageGet(
						$arI["PROPERTY_PRODUCT_ID_PREVIEW_PICTURE"],
						array("width" => 100, 'height' => 100),
						BX_RESIZE_IMAGE_PROPORTIONAL,
						false
					);
				} ?>
				<tr>
				<td class="td1"><a data-id="<?=$arI["ID"]?>" href="<?=$APPLICATION->GetCurPage()?>?deleteID=<?=$arI["ID"]?>" class="delete js-wish-delete"></a></td>
				<td>
					<div class="bskt_img">
						<a href="<?=$arI["PROPERTY_PRODUCT_ID_DETAIL_PAGE_URL"]?>"><img src='<?=$arFileTmp["src"];?>'></a>
					</div>
					<div class="bskt_info">
						<div class="bskt_lnk"><a href="<?=$arI["PROPERTY_PRODUCT_ID_DETAIL_PAGE_URL"]?>"><?=$arI["PROPERTY_PRODUCT_ID_NAME"]?></a></div>
						<div class="bskt_rtg"></div><?
						echo '<div class="bskt_color">Статус: '.$arI["PROPERTY_STATUS_VALUE"].'</div>'; ?>
					</div>
					<div class="clear"></div>
				</td>
				<td class="td4">от <?=GetOfferMinPrice(2,$arI["PROPERTY_PRODUCT_ID_VALUE"]);?> </td>
				</tr><?
			} ?>
		</table>
	</form>                                  
<?
} else echo 'Ваш вишлист пуст.';
