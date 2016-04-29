<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$intLocationID = $GLOBALS["CGeoIP"] -> getLocationID();
$strDeliveryDate = date("d.m.Y", getDeliveryDate(true));

function getColorHtml($strSize, $arResult)
{

	ob_start();

	$arColor = $arResult["CS"][$strSize];
	$arStartOffer = $arResult["START_OFFERS_BY_SIZE"][$strSize];


	?><div id="colorData_<?=md5($strSize)?>">
	<div class="sk-product-color--head"><span class="s_like">Выберите цвет:</span> <a href="#" class="sk-link-btt" data-last-value="<?=$arStartOffer["PROPERTY_COLOR_VALUE"]?>"><span class="sk-dotted"><?=$arStartOffer["PROPERTY_COLOR_VALUE"]?></span></a></div>
	<div>
		<ul class="sk-product-color--slider jcarousel jcarousel-skin-color_chose<?=(count($arResult["CS"])>1?'_one':'')?>">
			<li><?
		
		$itemsPerLi = (count($arResult["CS"])>1?1:2);
		$intCnt = 0;
		foreach($arColor as $arOffer)
		{
			$strH1orName = $arResult["SEO_H1_FROM_NAME"] == "Y" ? $arResult["NAME"].' '.$arOffer["PROPERTY_COLOR_VALUE"] : $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];

			$smallImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MIDI_VALUE"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL);
			$bigImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
			if($intCnt%$itemsPerLi == 0 && $intCnt>0)
				echo '</li><li>';?>		
				<a id="smallOffer<?=$arOffer["ID"]?>" href="<?=$bigImg["src"]?>" alt="<?=CFile::GetPath($arOffer["PROPERTY_PICTURE_MAXI_VALUE"])?>"  rel="useZoom:'zoom2'"  class="cloud-zoom-gallery sk-product-color--item<?=($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')?><?=($intCnt==0?' first':'')?>" data-code="<?=$arOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?>" data-color="<?=$arOffer["PROPERTY_COLOR_VALUE"]?>" data-img="<?=$bigImg["src"]?>" data-offerID="<?=$arOffer["ID"]?>" data-price="<?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>"<?=($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0?'data-old-price="'.number_format($arOffer["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ').'"':'')?>>
				<div class="sk-product-color--img"> <img src="<?=(empty($smallImg["src"])?'/img/no_photo_52x52.png':$smallImg["src"])?>" titile="" alt="<?=$strH1orName?>"> </div>
					<div class="sk-product-color--price">
						<span class="s_like"><span><?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?></span> р</span><?
			
			/*
			if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
				echo 'Нет в продаже';
			elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
				echo 'Новинка! Ожидаем поставку.';
			elseif($arOffer["PRICE"]["PRICE"]["PRICE"]>0) {
				?><strong><span><?=($arOffer["CATALOG_QUANTITY"]<=0?'<font title="Цена последней продажи">':'')?><?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?><?=($arOffer["CATALOG_QUANTITY"]<=0?'</font>':'')?></span> р</strong><?
			}
			*/?></div>
				</a><?
			
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

$strH1orName = $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];
$bigImg = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);

$user_id = $USER->GetID();
$pr=0;
foreach($arResult["LINKED_ITEMS"] as $arElem)
    if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0) $pr++;

$arTmpSizeHtml = array();
foreach($arResult["CS"] as $strSize => $arColor)
	$arTmpSizeHtml[$strSize] = getColorHtml($strSize, $arResult);
	
?>
<!-- product_block -->
<span itemscope itemtype="http://data-vocabulary.org/Product">
<div class="product_block"> 
	<!-- product_block_photo -->
	<div class="product_block_photo">
            
    
		<div id="large" class="sk-product-img">
            
            <?$APPLICATION->IncludeFile("/includes/shields.php",array("props" => $arResult["PROPERTIES"], 
                "align" => array("top" => "10px", "left" => "10px", "right" => "auto", "bottom" => "auto")),
                array("SHOW_BORDER" => false))?>
        
			<table>
				<tr>
					<td><a href="<?=$bigImg["src"]?> " alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?> " id='zoom2'  class="cloud-zoom sk-product-images" rel="useZoom: 'zoom2', adjustX:0,adjusty:-50, zoomWidth: '300'"><img src="<?=$bigImg["src"]?>" title="<?=$arResult["NAME"]?>" alt="<?=$strH1orName?>" data-last-img="<?=$bigImg["src"]?>" itemprop="image"/></a></td>
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
if(!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) $arCommonImg = array_merge($arCommonImg, $arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]);

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
		
		$strGallery .= '<li  '.(strlen($strGallery)>0?'':' class="sk-tumb_active"').'><a id="gallery'.$intImgID.'" class="cloud-zoom-gallery"   data-orig='.CFile::GetPath($intImgID).' alt="'.CFile::GetPath($intImgID).'" href="'.$galleryBigImg["src"].'" title="" rel="useZoom: \'zoom1\', zoomWidth: \'400\'"><img src="'.$smallImg["src"].'"  alt="" /></a></li>';
	?>
			<li<?=($intCnt==0?' class="sk-tumb_active"':'')?>><a id="small<?=$intImgID?>" class="cloud-zoom-gallery"  href="<?=$bigImg["src"]?>" alt="<?=CFile::GetPath($intImgID)?>"   title="" rel="useZoom: 'zoom2', zoomWidth: '400'"><img src="<?=$smallImg["src"]?>"  alt="<?=$strH1orName?>" /></a></li><?
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
		<h1 itemprop="name"><?=$strH1orName?></h1>
		<input type="hidden" id="offerID" value="<?=$arStartOffer["ID"]?>" />
		<input type="hidden" id="productID" value="<?=$arResult["ID"]?>" />
		<div class="sk-product-price-bar">
			<div class="sk-product-colorchoose-wrap">
				<div id="skProductColor" class="sk-product-color">
					<?=$arTmpSizeHtml[$arStartOffer["PROPERTY_SIZE_VALUE"]]?>
				</div><?
				if(count($arResult["CS"])>1)
				{
					$strTmp = '';
					$strSelectedSize = '';
					foreach($arResult["CS"] as $strSize => $arFoo)
					{
						if($arResult["SIZE_AVAIL"][$strSize] == "Y")
							$htmlCross = '';
						else $htmlCross = '<div class="cross"></div>';

						if($strSize == $arStartOffer["PROPERTY_SIZE_VALUE"]) $strSelectedSize = $strSize;

						$strTmp .= '
						<li'.($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':' sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_SIZE_VALUE"]?' class="sk-product-choose--item_active"':'').' id="lisize_'.md5($strSize).'"><a href="#" title="'.$strSize.'" data-color="'.$strSize.'">'.$strSize.'</a></li>';
					}?>
				<div class="sk-product-choose">
					<div class="sk-product-choose--head"><span class="s_like"><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0?'Выберите '.$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].':':'Выберите размер:')?></span> <span id="sizeLabel"><?=$strSelectedSize?></span>
					</div>
					<ul class="sk-product-choose--item" id="sk-product-choose--item"><?=$strTmp?>
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
						<div class="sk-product-price-one">
                            <?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>  <span style="position: absolute; left: -9000px">руб.</span><span class="rub">&#101;</span><?
					
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
				<div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);" href="#" class="addToCartButton">Купить</a></div><?
				if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
				{?>
				<div class="sk-product-price-order"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy1click', 'card']);" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить в 1 клик</a></div><?
				}
				?>
				<div class="sk-product-price-credit"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy_credit', 'card']);" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит - <span id="creditprice"></span> р.</a></div>
			</div>
		</div>
		<div class="sk-small-description-wrap">
			<table class="sk-small-description">
				<tr>
					<td><ul class="sk-sd-features">
							<li>
								<div class="sk-sd-features--head">Характеристики</div>
							</li>
							<li<?=(empty($arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"])?' class="hidden"':'')?> id="CODE_1C_CONT"><span class="s_like">Код товара:</span> <span id="CODE_1C"><?=$arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?></span></li><?
							if(strlen($arResult["PRODUCER"]["NAME"])>0)
							{?>
							<li><span class="s_like">Производитель:</span> <?=$arResult["PRODUCER"]["NAME"]?></li><?
							}
							if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
							{?>
							<li><span class="s_like">Страна:</span> <?=$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0?' ('.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].')':'')?></li><?
							}
							
							if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0)
							{?>
							<li><span class="s_like">Гарантия:</span> <?=$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"]?></li><?
							}?>
							<li><a id="allParamLink" href="#" title="Все характеристики" class="sk-dotted">Все характеристики</a></li>
						</ul></td>
					<td>
						<ul class="sk-sd-delvery">
							<li>
								<div class="sk-sd-delvery--head">Доставка<?=($arResult["PROPERTIES"]["SBOR"]["VALUE"]>0 && in_array($intLocationID, array(1732, 2399))?' и сборка':'')?></div>
							</li><?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
{
	$strMos = '<span class="s_like">Срок:</span> до 2-х месяцев';
	$strOther = '<span class="s_like">Срок:</span> около 2-х месяцев';
} else {
	$strConstruct = '';
	if($arResult["PROPERTIES"]["SBOR"]["VALUE"] > 0)
		$strConstruct .= '<li><span class="s_like">Сборка:</span> '.CurrencyFormat($arResult["PROPERTIES"]["SBOR"]["VALUE"], "RUB").'</li>';

	$strDeliveryData = '';
	if($intLocationID == 1732) {
		$strDeliveryData = '<li><span class="s_like">Дата доставки:</span> '.$strDeliveryDate.'</li>
		<li><span class="s_like">Стоимость:</span> '.($arStartOffer["PRICE"]["PRICE"]["PRICE"] < 3000?'300р. внутри МКАД':'бесплатно внутри МКАД').'</li>';
		if(false)
			$strDeliveryData .= '<li><span class="s_like">Сборка:</span> стоимость сборки (только если указано)';
	} elseif($intLocationID == 2399) {
		$strDeliveryData = '<li><span class="s_like">Дата доставки:</span> '.$strDeliveryDate.'</li>
		<li><span class="s_like">Стоимость:</span> '.($arStartOffer["PRICE"]["PRICE"]["PRICE"] < 3000?'300р. + 30 р./км':'30 р./км').'</li>';
	} else {
		$strDeliveryData = '<li><span class="s_like">Срок доставки:</span> от 2-х дней.</li>
<li>Стоимость доставки зависит от веса, объема и расстояния.</li>';
	}

	//$strMos = '<span class="s_like">Дата доставки:</span> с '.$strDeliveryDate;
	//$strOther = '<span class="s_like">Сроки:</span> от 2-х дней';
}

							if(false) { ?>
							<li class="sk-drop">
								<span class="s_like">Регион:</span>
									<a href="#" class="sk-link-btt"><span class="sk-dotted" id="deliveryRegion">Москва и МО</span></a>
									<ul class="sk-dropdown-menu" id="deliveryDropDown">
										<li><a data-name="Доставка по Москве и Подмосковью" id="moscowDeliveryData" data-str1='<?=$strMos?>' data-str2='' data-popup="delivery-moskow" href="#">Москва и МО</a></li>
										<li><a data-str1='<?=$strOther?>' data-str2="<span class='s_like'>Стоимость</span> от 350 р" data-popup="delivery-region" data-name="Доставка по регионам" href="#">Регионы</a></li>
									</ul>
							</li>
							<li id="deliveryStr1"></li>
							<li id="deliveryStr2"></li><?
							}
							?>
							<?=$strDeliveryData.$strConstruct?>
							<li> <a id="deliveryShowLink" data-id="<?=$arResult["ID"]?>" href="#" title="Доставка по Москве и Подмосковью" class="sk-popup-open sk-dotted" data-popup-name="<?=(in_array($intLocationID, array(1732, 2399))?'delivery-moskow':'delivery-region')?>" >О доставке<?=($arResult["PROPERTIES"]["SBOR"]["VALUE"]>0 && in_array($intLocationID, array(1732, 2399))?' и сборке':'')?></a> </li>
						</ul>
					</td>
					<td>
						<ul class="sk-sd-options">
							<li class="sk-sd-options--back"><a href="#" title="14 дней на возврат товара!" class="sk-dotted sk-popup-open" data-popup-name="cash_back" >14 дней на возврат товара</a></li>
							<li class="sk-sd-options--delveri"><a href="#" title="Доставка по всей России" class="sk-dotted sk-popup-open" data-popup-name="delivery_russia">Доставка по всей России</a></li>
							<li class="sk-sd-options--pay"><a href="#" title="Способы оплаты" class="sk-dotted sk-popup-open" data-popup-name="pay_method">Более 10 способов оплаты</a></li>
						</ul>
					</td>
				</tr>
			</table>
		</div>

	</div>
	<!-- END product_block_info -->
	<div class="clear"></div><?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916 || $arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100933)
{?>
	<!-- Если товара нет -->
	<div class="sk-noproduct">
		<div class="sk-noproduct--cont">Нет в продаже
			<br> <a rel="nofollow" class="notifyMeButton" href="#ng_<?=$arResult["ID"]?>" title="Уведомить о поставке">Уведомить о поставке</a><br> <a href="#" onclick="animateTo('#similarItems'); return false;" title="Смотреть аналоги">Смотреть аналоги</a><span class="sk-noproduct--arrow"></span></div>
		<div class="sk-noproduct--overlap"></div>
	</div>
	<!-- END Если товара нет --><?
}?><?
	if(false)
	{?>
		<?=showNI()?>
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
		<?=showNI(false)?>
		<?=showNI()?>
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
		<?=showNI(false)?><?
	}?>
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
					<a href="<?=$strStartBigImage?>" id='zoom1' alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="cloud-zoom" rel="useZoom: 'zoom1', adjustX:0,adjusty:-50, zoomWidth:500, zoomHeight:408" ><img id="galleryCurrentImage" src="<?=$strStartBigImage?>"  data-last="<?=$strStartBigImage?>" alt=""></a>
				</div>

			</div>
			<div class="sk-gallery--color--holder">
				<div class="sk-gallery--avl-price">
					Доступные цвета для этой модели
				</div>
				<div class="sk-gallery-color" id="galleryListPreview"><div class="sk-gallery-color-scroll">
				<!-- Color Items-->
<?
$intGallryCnt = 0;
foreach($arResult["CS"] as $strSize => $arColor)
{
	if(count($arResult["CS"])>0)
		$strSizeHash = 'data-sizehash="'.md5($strSize).'"';
	else $strSizeHash = '';
	
	foreach($arColor as $arItem)
	{
		$strH1orName = $arResult["SEO_H1_FROM_NAME"] == "Y" ? $arResult["NAME"].' '.$arItem["PROPERTY_COLOR_VALUE"] : $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];
		if(count($arResult["CS"])>1)
			$strGalleryItemName = ToLower($arItem["PROPERTY_SIZE_VALUE"]).' цвет '.ToLower($arItem["PROPERTY_COLOR_VALUE"]);
		else $strGalleryItemName = $arItem["PROPERTY_COLOR_VALUE"];
		
		$smallImg = CFile::ResizeImageGet($arItem["PROPERTY_PICTURE_MIDI_VALUE"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL); 
		$galleryBigImg = CFile::ResizeImageGet($arItem["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL);?>
					<a<?=($intGallryCnt>13?' style="display:none;"':'')?> title="<?=$strGalleryItemName?>" class="sk-gallery-color-item cloud-zoom-gallery" id="galleryOffer<?=$arItem["ID"]?>" <?=$strSizeHash?> data-orig="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" data-img="<?=$galleryBigImg["src"]?>" href="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" alt="<?=CFile::GetPath($arItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=$galleryBigImg["src"]?>' ">
						<div class="sk-gallery-color--img">
							<img src="<?=$smallImg["src"]?>" alt="<?=$strH1orName?>">
							<span>Выбрать</span>
						</div>
						<div class="sk-gallery-color--body">
							<div class="sk-gallery-color--head"><?=smart_trim($strGalleryItemName, 19)?></div>
							<div class="sk-gallery-color--price"><?
		if($arItem["PRICE"]["PRICE"]["PRICE"]>0)
			echo number_format($arItem["PRICE"]["PRICE"]["PRICE"], 0, '', ' ').'<span class="rub">e</span>'; ?></div>
						</div>
					</a><?
		$intGallryCnt++;
	}
}
?>
					<!-- END Color Items-->	
					</div>														
				</div><?
if($intGallryCnt>14)
{?>
				<!-- <div class="sk-gallery--all-price"><a href="#" onclick="$('#galleryListPreview a:hidden').show(); $(this).parent().hide(); return false;" title="Показать все цвета">Показать все цвета</a></div> -->

				<div class="sk-gallery--all-price"><a href="#" title="Показать все цвета">Показать все цвета</a></div><?
}?>
			</div>
		</div>

		<div class="sk-gallery-overlap"></div>
	</div>
	<!-- END Галерея -->
</div>
<!--noindex-->
<input type="hidden" id="lastClickedImage" value="" />
<div id="current-url" style="display:none;"><?=$_SERVER["REDIRECT_URL"]?></div>
<div id="product-id" style="display:none;"><?=$arResult["ID"]?></div>
<div id="productPrice" style="display:none;"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></div>
<div id="user-id" style="display:none;"><?=$user_id;?></div>
<div id="qu_count" style="display:none;"><?=$pr?></div>
<div id="sel_colorsize" style="display:none;"><?=$arResult["LINKED_ITEMS"][0]["ID"]?></div>
<span id="element-id" style="display:none;"><?=intval($arResult["ID"])?></span>
<!--/noindex-->
<!-- END product_block -->
</span>
<?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916 || $arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100933)
{
	$APPLICATION->IncludeComponent("sk:catalog.like.items", "newCardNotAvailable1", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"ELEMENT_ID" => $arResult["ID"],	// Родительский элемент
	"SECTION_ID" => $arResult["SECTION"]["ID"],	// Родительский раздел
	"strFilter" => "arrLikeFilter",	// Внешний фильтр
	"IBLOCK_TYPE" => "catalog",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "2",	// Код информационного блока
	"NEWS_COUNT" => "20",	// Количество новостей на странице
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	),
	false
);
} else {?>
<div class="characteristic_block"> 	
	<!-- Tabs -->
	<div class="sk-tab">
		<ul class="sk-tab--tabs">
			<li class="sk-tabs--item_active">
				<div class="oh3"><a id="paramTabTitle" href="#features" title="Характеристики">Характеристики</a></div>
			</li><?
			if(!empty($arResult["DETAIL_TEXT"]))
			{?>
			<li>
				<div class="oh3"><a href="#descr" title="Описание товара">Описание товара</a></div>
			</li><?
			}?>
			<li>
				<div class="oh3"><a id="commentTabTitle" href="#comment" title="Отзывы">Отзывы</a></div>
			</li><?
			if(is_array($arResult["PROPERTIES"]["VIDEO"]["VALUE"]) && count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])) { ?>
			<li class="sk-tabs--item_video">
				<div class="oh3"><a href="#video" title="Видео">Видео (<?=count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])?>)</a></div>
			</li><?
			}?>
		</ul><?		
$strProps = '';
if(!empty($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]))
{
	$strProps .= '<li><div class="oh4">'.$arResult["PROPERTIES"]["CML2_ARTICLE"]["NAME"].'</div>	<p>'.$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"].'</p></li>';
	unset($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]);
}
if(strlen($arResult["PRODUCER"]["NAME"])>0) $strProps .= '<li><div class="oh4">Производитель</div><p>'.$arResult["PRODUCER"]["NAME"].'</p></li>';
if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
	$strProps .= '<li><div class="oh4">Страна производителя</div><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].'</p></li>';
unset($arResult["PROPERTIES"]["CH_STRANA_1"]);
if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0) $strProps .= '<li><div class="oh4">Страна производства</div><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].'</p></li>';
unset($arResult["PROPERTIES"]["CH_STRANA"]);	
if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0) $strProps .= '<li><div class="oh4">Гарантия</div><p>'.$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"].'</p></li>';

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
				$strProps .= '<li><div class="oh4">'.$arProp["NAME"].'</div>	<p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';
			else $strOtherProps .= '<div class="characteristic_info-head">'.$arProp["NAME"].'</div>'.str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), $arTmp["DISPLAY_VALUE"]).'<br><br>';
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
						<div class="characteristic_info-head">Типовые характеристики</div>
						<ul class="sk-characteristic-list">
							<?=$strProps?>
						</ul><?
						if(!empty($arResult["PROPERTIES"]["CH_KOL_KOMPLEKT_TE"]["VALUE"]["TEXT"]))
						{
							$strSet = str_replace(array("<br>", "\n"), array("", "</li><li>"), $arResult["PROPERTIES"]["CH_KOL_KOMPLEKT_TE"]["~VALUE"]["TEXT"]);?>
						<div class="sk-equip">
							<div class="characteristic_info-head">Комплектация</div>
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
				<!-- END characteristic_info --><?
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
					}?>
			</div>
			<!--END  features tab--><?
	if(!empty($arResult["DETAIL_TEXT"]))
	{
		$strAddon = '';
		if(!empty($arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"]) && !empty($arResult["PRODUCER"]["~PROPERTY_NAME_RUS_VALUE"]))
			$strAddon = ' ('.$arResult["PRODUCER"]["~PROPERTY_NAME_RUS_VALUE"].' '.$arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"].')';
		?>
			<!-- descr tab-->
			<div id="descr" class="sk-tab--item" style="display: none;"> 
				<div class="characteristic_info" style="clear:both;">
					<p><b class="characteristic_info-head"><?=$strH1orName.$strAddon?></b></p><br>
					<span itemprop="description"><?=str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), normalizeBR($arResult["DETAIL_TEXT"]))?></span>
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
					<div class="oh2"><?=$strH1orName?> - отзывы</div>
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
			<div id="video" class="sk-tab--item" style="display: none;">
				<div class="characteristic_info" style="clear:both;"><?
				foreach($arResult["PROPERTIES"]["VIDEO"]["~VALUE"] as $intCnt => $strVideo) {
					if(empty($arResult["PROPERTIES"]["VIDEO"]["DESCRIPTION"][$intCnt]))
						$strTitle = $arResult["NAME"].' - видеообзор';
					else $strTitle = $arResult["PROPERTIES"]["VIDEO"]["DESCRIPTION"][$intCnt]; ?>
				<div class="sk-videotab-item">
					<div class="characteristic_info-head"><?=$strTitle?></div>
					<?=$strVideo?>
				</div> <?
				} ?>
				</div>
			</div>
		</div>
	</div>
	<!-- END Tabs--><?
	if(false)
	{?>
	
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
	--> <?
	}?>
</div>
<?
if(is_array($arResult["PROPERTIES"]["LIKE"]["VALUE"]))
	$GLOBALS["arrLikeFilter"]["ID"] = $arResult["PROPERTIES"]["LIKE"]["VALUE"];
?><?$APPLICATION->IncludeComponent("sk:catalog.like.items", "newCard1", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"ELEMENT_ID" => $arResult["ID"],	// Родительский элемент
	"SECTION_ID" => $arResult["SECTION"]["ID"],	// Родительский раздел
	"strFilter" => "arrLikeFilter",	// Внешний фильтр
	"IBLOCK_TYPE" => "catalog",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "2",	// Код информационного блока
	"NEWS_COUNT" => "5",	// Количество новостей на странице
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
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
<?
if($USER -> IsAdmin()) {
	$APPLICATION->IncludeComponent(
		"mailru:comments.list",
		".default",
		array(
			"clientId" => 10183, // Id клиента в Mail.Ru
			"onPage" => 5, // Количество отзывов на страницу
			"pager" => 2, // Тип листалки, значения 1 (постраничная) или 2 (ajax-овая)
			"offerId" => $arResult["ID"], // id элемента (товара), нужно подставлять динамически в зависимости от текущей страницы
			"backgroundColor" => "#B7BF84", // Цвет фона
			"fontColor" => "#CF004E", // Цвет текста
		),
		false
	);
}
?>