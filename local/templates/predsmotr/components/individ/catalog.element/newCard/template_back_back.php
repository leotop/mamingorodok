<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

processUserAvailNotify();

$strDeliveryDate = getDeliveryDate();

function getColorHtml($strSize, $arResult)
{
	ob_start();
	$arColor = $arResult["CS"][$strSize];
	$arStartOffer = $arResult["START_OFFERS_BY_SIZE"][$strSize];
	?><div id="colorData_<?=md5($strSize)?>">
	<div class="sk-product-color--head"><strong>Выберите цвет:</strong> <a href="#" class="sk-link-btt" data-last-value="<?=$arStartOffer["PROPERTY_COLOR_VALUE"]?>"><span class="sk-dotted"><?=$arStartOffer["PROPERTY_COLOR_VALUE"]?></span></a></span> </div>
	<div>
		<!-- jcarousel-skin-color_chose - слайдер в 2 строки. jcarousel-skin-color_chose_one - слайдер в одну строку -->
		<ul class="sk-product-color--slider jcarousel jcarousel-skin-color_chose<?=(count($arResult["CS"])>1?'_one':'')?>">
			<li><?
		
		$itemsPerLi = (count($arResult["CS"])>1?1:2);
		$intCnt = 0;
		foreach($arColor as $arOffer)
		{
			$smallImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MIDI_VALUE"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL);
			$bigImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
			if($intCnt%$itemsPerLi == 0 && $intCnt>0)
				echo '</li><li>';?>			
				<div id="smallOffer<?=$arOffer["ID"]?>" class="sk-product-color--item<?=($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')?><?=($intCnt==0?' first':'')?>" data-color="<?=$arOffer["PROPERTY_COLOR_VALUE"]?>" data-img="<?=$bigImg["src"]?>" data-offerID="<?=$arOffer["ID"]?>" data-price="<?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>"<?=($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0?'data-old-price="'.number_format($arOffer["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ').'"':'')?>>
					<div class="sk-product-color--img"> <img src="<?=$smallImg["src"]?>" titile="" alt=""> </div>
					<div class="sk-product-color--price">
						<strong><span><?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?></span> р</strong><?
			
			/*
			if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
				echo 'Нет в продаже';
			elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
				echo 'Новинка! Ожидаем поставку.';
			elseif($arOffer["PRICE"]["PRICE"]["PRICE"]>0) {
				?><strong><span><?=($arOffer["CATALOG_QUANTITY"]<=0?'<font title="Цена последней продажи">':'')?><?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?><?=($arOffer["CATALOG_QUANTITY"]<=0?'</font>':'')?></span> р</strong><?
			}
			*/?></div>
				</div><?
			
			$intCnt++;
		}?>
			<li>
		</ul>
	</div>
</div><?

	$strHtml = ob_get_contents();
	ob_end_clean();
	return $strHtml;
}


$arStartOffer = $arResult["CS"][$arResult["START_SIZE"]][$arResult["START_COLOR"]];

$bigImg = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);

$user_id = $USER->GetID();
$pr=0;
foreach($arResult["LINKED_ITEMS"] as $arElem)
    if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0) $pr++;

$arTmpSizeHtml = array();
foreach($arResult["CS"] as $strSize => $arColor)
	$arTmpSizeHtml[$strSize] = getColorHtml($strSize, $arResult);
	
?>
<input type="hidden" id="lastClickedImage" value="" />
<div id="current-url" style="display:none;"><?=$_SERVER["REDIRECT_URL"]?></div>
<div id="product-id" style="display:none;"><?=$arResult["ID"]?></div>
<div id="productPrice" style="display:none;"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></div>
<div id="user-id" style="display:none;"><?=$user_id;?></div>
<div id="qu_count" style="display:none;"><?=$pr?></div>
<div id="sel_colorsize" style="display:none;"><?=$arResult["LINKED_ITEMS"][0]["ID"]?></div>
<span id="element-id" style="display:none;"><?=intval($arResult["ID"])?></span>
<!-- product_block -->
<div class="product_block"> 
	<!-- product_block_photo -->
	<div class="product_block_photo">
		<div id="large" class="sk-product-img">
			<table>
				<tr>
					<td><a href="#"><img src="<?=$bigImg["src"]?>" title="<?=$arResult["NAME"]?>" alt="image01.jpg" data-last-img="<?=$bigImg["src"]?>"/></a></td>
				</tr>
			</table><?
			if($arResult["ACTIVE"] == "N")
			echo '<div class="element_inactive">Деактивирован</div>';
if(strlen($arResult["ACTION"]["PREVIEW_TEXT"])>0)
{?>
			<div class="sk-product-gift sk-product-gift_close"><div class="sk-product-gift-ico"></div>
				<div class="sk-product-gift_o"></div>
				<div class="sk-product-gift--head"><?=(strlen($arResult["ACTION"]["PROPERTY_TITLE_VALUE"])>0?$arResult["ACTION"]["PROPERTY_TITLE_VALUE"]:$arResult["ACTION"]["NAME"])?></div>
				<div class="sk-product-gift--cont"> <?=$arResult["ACTION"]["PREVIEW_TEXT"]?> </div>
			</div><?
}?>
			<div class="sk-product-img--zoom"><a href="#" class="">Смотреть все фото и цвета </a></div>
		</div><?
$arCommonImg = array();
if($arResult["DETAIL_PICTURE"]["ID"]>0) $arCommonImg[] = $arResult["DETAIL_PICTURE"]["ID"];
if(!empty($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"])) $arCommonImg = array_merge($arCommonImg, $arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]);

$strGallery = '';
if(!empty($arCommonImg))
{
?>
		<ul id="sk-tumb-slider" class="jcarousel jcarousel-skin-tumb sk-tumb"><?
	foreach($arCommonImg as $intCnt => $intImgID)
	{
		$smallImg = CFile::ResizeImageGet($intImgID, array("width"=>52, "height"=>44), BX_RESIZE_IMAGE_PROPORTIONAL);
		$bigImg = CFile::ResizeImageGet($intImgID, array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
		$galleryBigImg = CFile::ResizeImageGet($intImgID, array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL);
		
		if($intCnt == 0) $strStartBigImage = $galleryBigImg["src"];
		
		$strGallery .= '<li  '.(strlen($strGallery)>0?'':' class="sk-tumb_active"').'"><a id="gallery'.$intImgID.'" class="cloud-zoom-gallery"   data-orig='.CFile::GetPath($intImgID).' alt="'.$galleryBigImg["src"].'" href="'.$galleryBigImg["src"].'" title="" rel="useZoom: \'zoom1\', zoomWidth: \'400\'"><img src="'.$smallImg["src"].'"  alt="" /></a></li>';
	?>
			<li<?=($intCnt==0?' class="sk-tumb_active"':'')?>><a id="small<?=$intImgID?>" class="" href="<?=$bigImg["src"]?>" title=""><img src="<?=$smallImg["src"]?>"  alt="" /></a></li><?
	}?>
		</ul><?
}?>
		<div class="soc_block"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
$arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false)); ?></div>
	</div>
	<!-- EDN product_block_photo --> 
	<!-- product_block_info -->
	<div class="product_block_info">
		<ul class="sk-product-info-bar">
			<li>
				<?=showNoindex()?>
				<div class="links "> #ADD_TO_WISH_LIST#
					<!-- <a href="#" title=""><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="" /><span>К сравнению</span></a>--> 
				</div>
				<?=showNoindex(false)?>
			</li>
			<li class="sk-product-info-bar--devider">|</li>
			<li>
				<div class="rating detailPage"> #RATING# #REPORT_COUNT# </div>
			</li>
		</ul>
		<h1><?=$arResult["PROPERTIES"]["SEO_H1"]["VALUE"]?></h1>
		<input type="hidden" id="offerID" value="<?=$arStartOffer["ID"]?>" />
		<input type="hidden" id="productID" value="<?=$arResult["ID"]?>" />
		<div class="sk-product-price-bar">
			<div class="sk-product-colorchoose-wrap">
				<div id="skProductColor" class="sk-product-color">
					<?=$arTmpSizeHtml[$arStartOffer["PROPERTY_SIZE_VALUE"]]?>
				</div><?
				if(count($arResult["CS"])>1)
				{ ?>
				<div class="sk-product-choose">
					<div class="sk-product-choose--head"><strong><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0?$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"]:'Выберите размер:')?></strong> <span></span>
					</div>
					<ul class="sk-product-choose--item" id="sk-product-choose--item"><?
					foreach($arResult["CS"] as $strSize => $arFoo)
					{
						if($arResult["SIZE_AVAIL"][$strSize] == "Y")
							$htmlCross = '';
						else $htmlCross = '<div class="cross"></div>';?>
						<li<?=($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':' sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_SIZE_VALUE"]?' class="sk-product-choose--item_active"':'')?> id="lisize_<?=md5($strSize)?>"><a href="#" title="<?=$strSize?>" data-color="<?=$strSize?>"><?=$strSize?></a></li><?
					}?>
					</ul>
				</div><?
				}?>
			</div>
			<div class="sk-product-price-holder">
				<div class="sk-product-price">
					<div class="sk-product-price--cont" id="priceHere"><?
				if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
				{?>
						<div class="sk-product-price-old"><?=$arStartOffer["PROPERTY_OLD_PRICE_VALUE"]?> <span class="rub">&#101;</span></div>
						<div class="sk-product-price-new<?=($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923?' sk-product-price-new-preorder':'')?>"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>  <span class="rub">&#101;</span><?
					
						/*
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
	echo '<strong>Новинка! Ожидаем поставку.</strong>';
elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
	echo 'Нет в продаже';
else {
	?><?
}
*/?></div><?
				} else {

					?>
						<div class="sk-product-price-one"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>  <span class="rub">&#101;</span><?
					
						/*
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
	echo '<strong>Новинка! Ожидаем поставку.</strong>';
elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
	echo 'Нет в продаже';
else {
	?><?
}
*/


					?></div><?
				}
				if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
				{ ?>
					<span class="sk-item-preorder">под заказ</span><?
				}?>
					</div>
				</div>
				<div class="sk-product-price-buy"><a rel="nofollow" href="#" class="addToCartButton">Купить</a></div><?
				if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
				{?>
				<div class="sk-product-price-order"><a rel="nofollow" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить в 1 клик</a></div><?
				}
				
				if($USER -> IsAdmin())
				{?>
				<div class="sk-product-price-credit"><a rel="nofollow" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит</a></div><?
				}?>
			</div>
		</div>
		<div class="sk-small-description-wrap">
			<table class="sk-small-description">
				<tr>
					<td><ul class="sk-sd-features">
							<li>
								<div class="sk-sd-features--head">Характеристики</div>
							</li><?
							if(strlen($arResult["PRODUCER"]["NAME"])>0)
							{?>
							<li><strong>Производитель:</strong> <?=$arResult["PRODUCER"]["NAME"]?></li><?
							}
							if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
							{?>
							<li><strong>Страна:</strong> <?=$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0?' ('.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].')':'')?></li><?
							}
							
							if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0)
							{?>
							<li><strong>Гарантия:</strong> <?=$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"]?></li><?
							}?>
							<li><a id="allParamLink" href="#" title="Все характеристики" class="sk-dotted">Все характеристики</a></li>
						</ul></td>
					<td>
						<ul class="sk-sd-delvery">
							<li>
								<div class="sk-sd-delvery--head">Доставка</div>
							</li><?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
{
	$strMos = '<strong>Срок:</strong> до 2-х месяцев';
	$strOther = '<strong>Срок:</strong> около 2-х месяцев';
} else {
	$strMos = '<strong>Дата доставки:</strong> с '.$strDeliveryDate;
	$strOther = '<strong>Сроки:</strong> от 2-х дней';
}?>
							<li class="sk-drop">
								<strong>Регион:</strong>
									<a rel="nofollow" href="#" class="sk-link-btt"><span class="sk-dotted" id="deliveryRegion">Москва и МО</span></a>
									<ul class="sk-dropdown-menu" id="deliveryDropDown">
										<li><a rel="nofollow" id="moscowDeliveryData" data-str1="<?=$strMos?>" data-str2="" data-popup="delivery-moskow" href="#">Москва и МО</a></li>
										<li><a rel="nofollow" data-str1="<?=$strOther?>" data-str2="<strong>Стоимость</strong> от 350 р" data-popup="delivery-region" href="#">Регионы</a></li>
									</ul>
							</li>
							<li id="deliveryStr1"></li>
							<li id="deliveryStr2"></li>
							<li> <a rel="nofollow" id="deliveryShowLink" href="#" title="О доставке и оплате" class="sk-popup-open sk-dotted" data-popup-name="delivery-moskow" >О доставке и оплате</a> </li>
						</ul></td>
					<td><ul class="sk-sd-options">
							<li class="sk-sd-options--back"><a rel="nofollow" href="#" title="14 дней на возврат товара" class="sk-dotted sk-popup-open" data-popup-name="cash-back" >14 дней на возврат товара</a></li>
							<li class="sk-sd-options--delveri"><a rel="nofollow" href="#" title="Доставка по всей России" class="sk-dotted sk-popup-open" data-popup-name="delivery-russia">Доставка по всей России</a></li>
							<li class="sk-sd-options--pay"><a rel="nofollow" href="#" title="Более 10 способов оплаты" class="sk-dotted sk-popup-open" data-popup-name="pay-metod">Более 10 способов оплаты</a></li>
						</ul></td>
				</tr>
			</table>
		</div>

	</div>
	<!-- END product_block_info -->
	<div class="clear"></div><?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
{?>
	<!-- Если товара нет -->
	<div class="sk-noproduct">
		<div class="sk-noproduct--cont">Нет в продаже<br> <a href="#" onclick="animateTo('#similarItems'); return false;" title="Смотреть аналоги">Смотреть аналоги</a><span class="sk-noproduct--arrow"></span></div>
		<div class="sk-noproduct--overlap"></div>
	</div>
	<!-- END Если товара нет --><?
}?>
	<!-- Попап-->
		<!-- -->
		<?=showNoindex(true, true)?>
		<div class="popup_block" id="credit"  data-popup-head="Купить в кредит" style="display: none;">
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/credit.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>

		<div class="popup_block" id="pickup"  data-popup-head="Самовывоз возможен по 100% предоплате" style="display: none;">
		<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/pickup.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<!-- -->

		<!-- -->
		<div class="popup_block" id="cash-back" data-popup-head="14 дней на возврат товара!" style="display: none;">
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/cash_back.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<!-- -->

		<!-- -->
		<div class="popup_block" id="delivery-moskow"  data-popup-head="Доставка по Москве и Подвосковью" style="display: none;">
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/delivery_and_payment.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<!-- -->
		
		<!-- -->
		<div class="popup_block" id="delivery-region"  data-popup-head="Доставка по регионам" style="display: none;">
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/delivery_and_payment_region.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<!-- -->

		<!-- -->
		<div class="popup_block" id="pay-metod"   data-popup-head="Способы оплаты" style="display: none;"> 
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/pay_method.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>

		<!-- -->
		<div class="popup_block" id="delivery-russia"  data-popup-head="Доставка по всей России" style="display: none;">
			<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/card/delivery_russia.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<!-- -->
<?=showNoindex(false, true)?>
	<!-- END Попап -->
	<!-- Галерея -->
	<div class="sk-gallery-holder" style="display: none;">
		<div class="sk-gallery" >
			<div class="sk-gallery--close"><a href="#" title="Закрыть"></a></div>
			<div class="sk-gallery--img--holder">
				<div class="sk-gallery-slider">
					<ul id="sk-tumb-gallery-slider" class="jcarousel jcarousel-skin-tumb sk-tumb-gall ">
						<?=$strGallery?>
					</ul>
				</div>
				<div class="sk-gallery--img">
					<a href="<?=$strStartBigImage?>" id='zoom1' alt="<?=$strStartBigImage?>" class="" rel="useZoom: 'zoom1', adjustX:-70,adjusty:-50, zoomWidth:575, zoomHeight:508" ><img id="galleryCurrentImage" src="<?=$strStartBigImage?>"  data-last="<?=$strStartBigImage?>" alt=""></a>
				</div>

			</div>
			<div class="sk-gallery--color--holder">
				<div class="sk-gallery--avl-price">
					Доступные цвета для этой модели
				</div>
				<div class="sk-gallery-color">
				<!-- Color Items-->
<?
foreach($arResult["CS"] as $strSize => $arColor)
{
	if(count($arResult["CS"])>0)
		$strSizeHash = 'data-sizehash="'.md5($strSize).'"';
	else $strSizeHash = '';
	
	foreach($arColor as $arItem)
	{
		if(count($arResult["CS"])>1)
			$strGalleryItemName = ToLower($arItem["PROPERTY_SIZE_VALUE"]).' цвет '.ToLower($arItem["PROPERTY_COLOR_VALUE"]);
		else $strGalleryItemName = $arItem["PROPERTY_COLOR_VALUE"];
		
		$smallImg = CFile::ResizeImageGet($arItem["PROPERTY_PICTURE_MIDI_VALUE"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL); 
		$galleryBigImg = CFile::ResizeImageGet($arItem["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL);?>
					<a title="<?=$strGalleryItemName?>" class="sk-gallery-color-item cloud-zoom-gallery" id="galleryOffer<?=$arItem["ID"]?>"<?=$strSizeHash?> data-orig="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" data-img="<?=$galleryBigImg["src"]?>" href="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" alt="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=$galleryBigImg["src"]?>' ">
						<div class="sk-gallery-color--img">
							<img src="<?=$smallImg["src"]?>" title="">
							<span>Выбрать</span>
						</div>
						<div class="sk-gallery-color--body">
							<div class="sk-gallery-color--head"><?=smart_trim($strGalleryItemName, 19)?></div>
							<div class="sk-gallery-color--price"><?
		if($arItem["PRICE"]["PRICE"]["PRICE"]>0)
			echo number_format($arItem["PRICE"]["PRICE"]["PRICE"], 0, '', ' ').'<span class="rub">e</span>'; ?></div>
						</div>
					</a><?
	}
}
?>
					<!-- END Color Items-->															
				</div><?
if(false)
{?>
				<div class="sk-gallery--all-price"><a href="#" title="Показать все цены">Показать все цены</a></div><?
}?>
			</div>
		</div>

		<div class="sk-gallery-overlap"></div>
	</div>
	<!-- END Галерея -->
</div>
<!-- END product_block --><?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
{
	$APPLICATION->IncludeComponent(
		"sk:catalog.like.items",
		"newCardNotAvailable",
		Array(
			"AJAX_MODE" => "N",
			"ELEMENT_ID" => $arResult["ID"],
			"SECTION_ID" => $arResult["SECTION"]["ID"],
			"strFilter" => "arrLikeFilter",
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => "2",
			"NEWS_COUNT" => "20",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"AJAX_OPTION_HISTORY" => "N"
		),
		false
	);
} else {?>
<div class="characteristic_block"> 	
	<!-- Tabs -->
	<div class="sk-tab">
		<ul class="sk-tab--tabs">
			<li class="sk-tabs--item_active">
				<h2><a id="paramTabTitle" href="#features" title="Характеристики">Характеристики</a></h2>
			</li><?
			if(!empty($arResult["DETAIL_TEXT"]))
			{?>
			<li>
				<h2><a href="#descr" title="Описание товара">Описание товара</a></h2>
			</li><?
			}?>
			<li>
				<h2><a id="commentTabTitle" href="#comment" title="Отзывы">Отзывы</a></h2>
			</li><?
			if(false)
			{?>
			<li>
				<h2><a href="#video" title="Видео">Видео</a></h2>
			</li><?
			}?>
		</ul><?		
$strProps = '';
if(!empty($arResult["PROPERTIES"]["ARTICUL"]["VALUE"]))
{
	$strProps .= '<li><h4>'.$arResult["PROPERTIES"]["ARTICUL"]["NAME"].'</h4>	<p>'.$arResult["PROPERTIES"]["ARTICUL"]["VALUE"].'</p></li>';
	unset($arResult["PROPERTIES"]["ARTICUL"]["VALUE"]);
}
if(strlen($arResult["PRODUCER"]["NAME"])>0) $strProps .= '<li><h4>Производитель</h4><p>'.$arResult["PRODUCER"]["NAME"].'</p></li>';
if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
	$strProps .= '<li><h4>Страна производителя</h4><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].'</p></li>';
unset($arResult["PROPERTIES"]["CH_STRANA_1"]);
if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0) $strProps .= '<li><h4>Страна производства</h4><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].'</p></li>';
unset($arResult["PROPERTIES"]["CH_STRANA"]);	
if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0) $strProps .= '<li><h4>Гарантия</h4><p>'.$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"].'</p></li>';

$strOtherProps = '';
$strOtherPropsHidden = '';

foreach($arResult["PROPERTIES"] as $key => $arProp)
{
	if(in_array($arProp["ID"], $arResult["HARACTERISTICS"]))
	{
		if(in_array($arProp["CODE"], array("CH_KOL_KOMPLEKT_TE"))) continue;
		
		if($arProp["MULTIPLE"] == "Y")
			$arTmp["DISPLAY_VALUE"] = implode(", ", $arProp["VALUE"]);
		else $arTmp = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult["PROPERTIES"][$key], "news_out");
		
		if($key!="CH_INSTR1" && $arProp["VALUE"] != '' && strpos($arProp["CODE"], "CH_") ===0 && $arProp["CODE"] !== "CH_PRODUCER")
		{
			$arTmp["DISPLAY_VALUE"] = prepareMultilineText($arTmp["DISPLAY_VALUE"]);			
			
			if(in_array($arProp["ID"], $arResult["TYPICAL_OPTIONS"]))
				$strProps .= '<li><h4>'.$arProp["NAME"].'</h4>	<p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';
			else $strOtherProps .= '<h5 class="characteristic_info-head">'.$arProp["NAME"].'</h5>'.str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), $arTmp["DISPLAY_VALUE"]).'<br><br>';
		}
	}
}
?>
		<div class="sk-tab--content"> 
			<!-- features tab -->
			<div id="features" class="sk-tab--item" style="display: block;"> 
				<!-- characteristic_info -->
				<div class="characteristic_info">
					<div class="sk-column sk-colum_44">
						<h5 class="characteristic_info-head">Типовые характеристики</h5>
						<ul class="sk-characteristic-list">
							<?=$strProps?>
						</ul><?
						if(!empty($arResult["PROPERTIES"]["CH_KOL_KOMPLEKT_TE"]["VALUE"]["TEXT"]))
						{
							$strSet = str_replace(array("<br>", "\n"), array("", "</li><li>"), $arResult["PROPERTIES"]["CH_KOL_KOMPLEKT_TE"]["~VALUE"]["TEXT"]);?>
						<div class="sk-equip">
							<h5>Комплектация</h5>
							<ul class="sk-characteristic--list">
								<li><?=$strSet?></li>
							</ul>
						</div><?
						}?>
					</div><?
					if(!empty($strOtherProps))
					{?>
					<div class="sk-column sk-colum_56 "> 
						<!-- characteristic_text -->
						<div class="characteristic_text" id="characteristicDiv">
							<div id="characteristicDivInner">
								<?=$strOtherProps?>
							</div>
						</div><?
						if(false)
						{?>
						<div class="sk-characteristic-more-btt"><a href="#" class="sk-dotted" title="Показать все">Показать все</a></div><?
						}?>
						<!-- END characteristic_text --> 
					</div><?
					}?>
				</div>
				<!-- END characteristic_info -->
				<!--noindex--><?
					if (count($arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"])>0)
					{
		$GLOBALS["arrAccFilter"]["ID"] = $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"];?>
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "accessories-items-newCard", array(
			"IBLOCK_TYPE" => "catalog",
			"IBLOCK_ID" => CATALOG_IBLOCK_ID,
			"NEWS_COUNT" => "99",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "arrAccFilter",
			"FIELD_CODE" => array(
				0 => "",
				1 => "NAME",
				2 => "PREVIEW_PICTURE",
				3 => "",
			),
			"PROPERTY_CODE" => array(
				0 => "RATING",
				1 => "OLD_PRICE",
				2 => "PRICE",
				3 => "",
			),
			"CHECK_DATES" => "Y",
			"DETAIL_URL" => "",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_SHADOW" => "Y",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "Y",
			"PREVIEW_TRUNCATE_LEN" => "",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"SET_TITLE" => "N",
			"SET_STATUS_404" => "N",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"ADD_SECTIONS_CHAIN" => "N",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Новости",
			"PAGER_SHOW_ALWAYS" => "Y",
			"PAGER_TEMPLATE" => "",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "Y",
			"AJAX_OPTION_ADDITIONAL" => ""
			),
			false
		);
			?><?
	}?><!--/noindex-->
			</div>
			<!--END  features tab--><?
	if(!empty($arResult["DETAIL_TEXT"]))
	{?>
			<!-- descr tab-->
			<div id="descr" class="sk-tab--item" style="display: none;"> 
				<div class="characteristic_info" style="clear:both;">
					<?=str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), normalizeBR($arResult["DETAIL_TEXT"]))?>
				</div>
				<!-- END characteristic_info -->
			</div>
			<!--END descr tab --> <?
	}?>
			<!--comment -->
			<div id="comment" class="sk-tab--item" style="display: none;"> 
				<!-- characteristic_info -->
				<div class="characteristic_info" style="height:auto;">
					<a name="review"></a>
					<?$APPLICATION->IncludeComponent("individ:forum.topic.reviews2", "all-comments-newCard", array(
            "FORUM_ID" => "1",
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_ID" => $arResult["ID"],
            "POST_FIRST_MESSAGE" => "N",
            "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                        [url=#LINK#]#TITLE#[/url]
                        #BODY#",
            "URL_TEMPLATES_READ" => "",
            "URL_TEMPLATES_DETAIL" => "",
            "URL_TEMPLATES_PROFILE_VIEW" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0",
            "MESSAGES_PER_PAGE" => "10",
            "PAGE_NAVIGATION_TEMPLATE" => "",
            "DATE_TIME_FORMAT" => "d.m.Y",
            "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
            "USE_CAPTCHA" => "Y",
            "PREORDER" => "N",
            "SHOW_LINK_TO_FORUM" => "N",
            "FILES_COUNT" => "2"
            ),
            false
        );?><?$APPLICATION->IncludeComponent("individ:forum.topic.reviews", "add-comment", array(
                "FORUM_ID" => "1",
                "IBLOCK_TYPE" => $arResult["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arResult["IBLOCK_ID"],
                "ELEMENT_ID" => $arResult["ID"],
                "POST_FIRST_MESSAGE" => "N",
                "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                            [url=#LINK#]#TITLE#[/url]
                            #BODY#",
                "URL_TEMPLATES_READ" => "",
                "URL_TEMPLATES_DETAIL" => "",
                "URL_TEMPLATES_PROFILE_VIEW" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "0",
                "MESSAGES_PER_PAGE" => "0",
                "PAGE_NAVIGATION_TEMPLATE" => "",
                "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
                "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                "USE_CAPTCHA" => "N",
                "PREORDER" => "Y",
                "SHOW_LINK_TO_FORUM" => "N",
                "FILES_COUNT" => "2"
                ),
                false
            );?>
				</div>
				<!-- END characteristic_info -->
			</div>
			<!--END comment -->
		</div>
	</div>
	<!-- END Tabs--> 
	
	<!--
		<div class="characteristic_left">
			<div class="headline">Характеристики</div>



			<div class="clear"></div><br /><br />
			
			<div class="headline">Описание</div>
			<div class="characteristic_text">
				<h5>роватка-маятник Лаванда АБ 21.3 из натурального бука - идеальный выбор перв</h5>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
			</div>
			<div class="clear"></div><br /><br />
			
			<div class="headline">Отзывы</div>
			<div class="characteristic_text">
				<ul class="comment_list">
					<li>
						<div class="headline_info">
							<img src="/bitrix/templates/nmg/img/pic1.png" width="40" class="photo" height="40" alt="" />
							<h6><a href="#" title="">Анастасия Иванова</a></h6>
							<p><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span></p>
							<div class="rating">
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<b>12 марта 2012</b>
							</div>
						</div>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p>
					</li>
					<li>
						<div class="headline_info">
							<img src="/bitrix/templates/nmg/img/pic1.png" width="40" class="photo" height="40" alt="" />
							<h6><a href="#" title="">Анастасия Иванова</a></h6>
							<p><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span></p>
							<div class="rating">
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<span class="on"></span>
								<b>12 марта 2012</b>
							</div>
						</div>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
			
			<div class="headline">Ваш отзыв</div>
			<div class="your_comment">
				<div class="your_comment_headline">
					<b>Ваша оценка:</b>
					<span>ужасно</span>
					<span>плохо</span>
					<span class="active">удовлетворительно</span>
					<span>хорошо</span>
					<span>отлично</span>
				</div>
				<div class="input_1"><textarea cols="" rows="" name=""></textarea></div>
				<input type="submit" class="input_2" value="Добавить отзыв" />
				<div class="input_info">За отзыв вы получите 1 балл.</div>
			</div>
			<div class="clear"></div>
			
		</div>
		<div class="characteristic_right">
			
			<div class="crumbs indent2">Также рекомендуем</div>
			
			<div class="similar_block similar_block_right">
				<ul>
					<li>
						<div class="photo"><p><img src="/bitrix/templates/nmg/img/photo.jpg" width="105" height="120" alt="" /><span>&nbsp;</span></p></div>
						<div class="rating">
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
						</div>
						<div class="link"><a href="#" title="">Платья Sue Wong<br />Ombre Beaded Lo ...</a></div>
						<strong>15 000 р</strong>
					</li>
					<li>
						<div class="photo"><p><img src="/bitrix/templates/nmg/img/photo.jpg" width="105" height="120" alt="" /><span>&nbsp;</span></p></div>
						<div class="rating">
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
							<span class="on"></span>
						</div>
						<div class="link"><a href="#" title="">Платья Sue Wong<br />Ombre Beaded Lo ...</a></div>
						<strong>15 000 р</strong>
					</li>
				</ul>	
			</div>
			
			<div class="crumbs indent1">Хотят</div>
			<div class="right_text"><a href="#" title="">23 пользователя</a></div>
			
			<div class="crumbs indent1">Уже имеют</div>
			<div class="right_text"><a href="#" title="">7 друзей</a></div>
			
		</div>
	--> 
</div>
<?
if(is_array($arResult["PROPERTIES"]["LIKE"]["VALUE"]))
	$GLOBALS["arrLikeFilter"]["ID"] = $arResult["PROPERTIES"]["LIKE"]["VALUE"];
?><?$APPLICATION->IncludeComponent(
"sk:catalog.like.items",
"newCard",
Array(
	"AJAX_MODE" => "N",
	"ELEMENT_ID" => $arResult["ID"],
	"SECTION_ID" => $arResult["SECTION"]["ID"],
	"strFilter" => "arrLikeFilter",
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"NEWS_COUNT" => "5",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "N",
	"AJAX_OPTION_HISTORY" => "N"
),
false
);?><?
}
?>
<div class="clear"></div>
<div style="position:absolute; top:-10000px; right:100000px;" id="colorsStorageHere"><?
foreach($arTmpSizeHtml as $strSize => $strSizeHtml)
{
	if($strSize != $arResult["START_SIZE"])
		echo $strSizeHtml;
} ?>
</div>
<input type="hidden" id="cartPrice" value="<?=$arResult["CART_PRICE"]?>">
<script type="text/javascript">
	$(document).ready(function() {
		var obTR = $("#colorsHere").next().find(".select_block_bg1").find("tr");
		if(obTR.length == 1)
		{
			obTR.click();
			$("#colorsHere").next().find(".select_block_bg").unbind("click");
		}
	});

	var arDelivery = new Array;<?
foreach($arResult["DELIVERY"] as $intCnt => $arDelivery)
{?>
	arDelivery[<?=$intCnt?>] = new Array;
	arDelivery[<?=$intCnt?>][0] = <?=$arDelivery["ORDER_PRICE_FROM"]?>;
	arDelivery[<?=$intCnt?>][1] = <?=$arDelivery["ORDER_PRICE_TO"]?>;
	arDelivery[<?=$intCnt?>][2] = <?=$arDelivery["PRICE"]?>;
			<?
}?>
</script>