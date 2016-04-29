<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

processUserAvailNotify();

function getColorHtml($strSize, $arResult)
{
	ob_start();
	$arColor = $arResult["CS"][$strSize];
	$arStartOffer = $arResult["START_OFFERS_BY_SIZE"][$strSize];
	?><div id="colorData_<?=md5($strSize)?>">
	<div class="sk-product-color--head"><strong>Выберите цвет:</strong> <a href="#" class="sk-link-btt" data-last-value="<?=$arStartOffer["PROPERTY_COLOR_VALUE"]?>"><span class="sk-dotted"><?=$arStartOffer["PROPERTY_COLOR_VALUE"]?></span></a></span> </div>
	<div>
		<ul class="sk-product-color--slider jcarousel jcarousel-skin-color_chose"><?
		$intCnt = 0;
		foreach($arColor as $arOffer)
		{
			$smallImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MIDI_VALUE"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL);
			$bigImg = CFile::ResizeImageGet($arOffer["PROPERTY_PICTURE_MAXI_VALUE"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
			 ?>
			<li>
				<div class="sk-product-color--item<?=($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')?><?=($intCnt==0?' first':'')?>" data-color="<?=$arOffer["PROPERTY_COLOR_VALUE"]?>" data-img="<?=$bigImg["src"]?>" data-offerID="<?=$arOffer["ID"]?>" data-price="<?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>"<?=($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0?'data-old-price="'.number_format($arOffer["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ').'"':'')?>>
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
				</div>
			</li><?
			
			$intCnt++;
		}?>
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
<div id="current-url" style="display:none;"><?=$_SERVER["REDIRECT_URL"]?></div>
<div id="product-id" style="display:none;"><?=$arResult["ID"]?></div>
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
if(strlen($arResult["ACTION"]["PREVIEW_TEXT"])>0)
{?>
			<div class="sk-product-gift sk-product-gift_close"><div class="sk-product-gift-ico"></div>
				<div class="sk-product-gift_o"></div>
				<div class="sk-product-gift--head"><?=(strlen($arResult["ACTION"]["PROPERTY_TITLE_VALUE"])>0?$arResult["ACTION"]["PROPERTY_TITLE_VALUE"]:$arResult["ACTION"]["NAME"])?></div>
				<div class="sk-product-gift--cont"> <?=$arResult["ACTION"]["PREVIEW_TEXT"]?> </div>
			</div><?
}?>
			<div class="sk-product-img--zoom"><a href="/bitrix/templates/nmg/img/photo.jpg" class="fancybox" >Смотреть все фото и цвета </a></div>
		</div><?
$arCommonImg = array();
if($arResult["DETAIL_PICTURE"]["ID"]>0) $arCommonImg[] = $arResult["DETAIL_PICTURE"]["ID"];
if(!empty($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"])) $arCommonImg = array_merge($arCommonImg, $arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]);

if(!empty($arCommonImg))
{
?>
		<ul id="sk-tumb-slider" class="jcarousel jcarousel-skin-tumb sk-tumb"><?
	foreach($arCommonImg as $intCnt => $intImgID)
	{
		$smallImg = CFile::ResizeImageGet($intImgID, array("width"=>52, "height"=>44), BX_RESIZE_IMAGE_PROPORTIONAL);
		$bigImg = CFile::ResizeImageGet($intImgID, array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
	?>
			<li<?=($intCnt==0?' class="sk-tumb_active"':'')?>><a href="<?=$bigImg["src"]?>" title=""><img src="<?=$smallImg["src"]?>"  alt="" /></a></li><?
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
		<h3><?=$arResult["PROPERTIES"]["H1"]["VALUE"]?></h3>
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
					<ul class="sk-product-choose--item"><?
					foreach($arResult["CS"] as $strSize => $arFoo)
					{
						if($arResult["SIZE_AVAIL"][$strSize] == "Y")
							$htmlCross = '';
						else $htmlCross = '<div class="cross"></div>';?>
						<li<?=($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':'sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_SIZE_VALUE"]?' class="sk-product-choose--item_active"':'')?> id="lisize_<?=md5($strSize)?>"><a href="#" title="<?=$strSize?>" data-color="<?=$strSize?>"><?=$strSize?></a></li><?
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
				<div class="sk-product-price-buy"><a href="#" class="addToCartButton">Купить</a></div><?
				if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
				{?>
				<div class="sk-product-price-order"><a rel="nofollow" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить в 1 клик</a></div><?
				}?>
				<div class="sk-product-price-credit"><a href="#" title="В кредит за 1000 р">В кредит</a></div>
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
					<td><ul class="sk-sd-delvery">
							<li>
								<div class="sk-sd-delvery--head">Доставка</div>
							</li>
							<li><strong>Самовывоз:</strong> Условия</li>
							<li><strong>Курьер:</strong> с 24.01.2013</li>
							<li><strong>Регионы:</strong> от 2-х дней</li>
							<li> <a href="#" title="О доставке и оплате" class="sk-dotted">О доставке и оплате</a> </li>
						</ul></td>
					<td><ul class="sk-sd-options">
							<li class="sk-sd-options--back"><a href="#" title="30 дней на возврат товара" class="sk-dotted">14 дней на возврат товара</a></li>
							<li class="sk-sd-options--delveri"><a href="#" title="Доставка по всей России" class="sk-dotted">Доставка по всей России</a></li>
							<li class="sk-sd-options--pay"><a href="#" title="Более 10 способов оплаты" class="sk-dotted">Более 10 способов оплаты</a></li>
						</ul></td>
				</tr>
			</table>
		</div>
	</div>
	<!-- END product_block_info -->
	<div class="clear"></div>
</div>
<!-- END product_block -->
<div class="characteristic_block"> 
	
	<!-- Tabs -->
	<div class="sk-tab">
		<ul class="sk-tab--tabs">
			<li class="sk-tabs--item_active">
				<h2><a id="paramTabTitle" href="#features" title="Характеристики">Характеристики</a></h2>
			</li>
			<li>
				<h2><a href="#descr" title="Описание товара">Описание товара</a></h2>
			</li>
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
					<h3><?=$arResult["PROPERTIES"]["H1"]["VALUE"]?>: характеристики</h3>
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
						<div class="characteristic_text">
							<?=$strOtherProps?>
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
			<!--END  features tab--> 
			<!-- descr tab-->
			<div id="descr" class="sk-tab--item" style="display: none;"> 
				<div class="characteristic_info" style="clear:both;">
					<h3><?=$arResult["PROPERTIES"]["H1"]["VALUE"]?>: описание</h3>
					<?=str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), normalizeBR($arResult["DETAIL_TEXT"]))?>
				</div>
				<!-- END characteristic_info -->
			</div>
			<!--END descr tab --> 
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
                "CACHE_TIME" => "3600",
                "MESSAGES_PER_PAGE" => "0",
                "PAGE_NAVIGATION_TEMPLATE" => "",
                "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
                "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                "USE_CAPTCHA" => "Y",
                "PREORDER" => "Y",
                "SHOW_LINK_TO_FORUM" => "N",
                "FILES_COUNT" => "2"
                ),
                false
            );?>
				</div>
				<!-- END characteristic_info -->
			</div>
			<!--END comment --><?
			if(false)
			{?>
			<!-- video -->
			<div id="video" class="sk-tab--item" style="display: none;"> 
				<!-- characteristic_info -->
				<div class="characteristic_info">
					<h3>Видео</h3>
				</div>
				<!-- END characteristic_info -->
				
				<div class="sk-accessory-block "> 
					<!-- similar_block -->
					<div class="similar_block similar_block_right">
						<div class="crumbs_black">Рекомендуем</div>
						<ul class="sk-accessory-slider jcarousel jcarousel-skin-accessory">
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li>
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
							<li class="last-child">
								<div class="photo">
									<p><img src="/bitrix/templates/nmg/img/left-img.png" alt="" /><span>&nbsp;</span></p>
								</div>
								<div class="link"><a href="#" title="">Платья Sue Wong<br />
									Ombre Beaded Lo ...</a></div>
								<strong>15 000 <span class="rub">&#101;</span></strong> </li>
						</ul>
					</div>
					<!-- END similar_block --> 
				</div>
			</div>
			<!-- END video --> <?
			}?>
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























if(false)
{

processUserAvailNotify();

function getColorHtml($strSize, $arColor, $arStartOffer, $arResult)
{
	global $USER;
	ob_start();	

	if(strlen($arResult["ACTION"]["PREVIEW_TEXT"])>0)
	{
		$strHref = ($arResult["ACTION"]["PROPERTY_BLOG_POST_VALUE"]>0?'/community/group/blog_news/'.$arResult["ACTION"]["PROPERTY_BLOG_POST_VALUE"].'/':$arResult["ACTION"]["DETAIL_PAGE_URL"]); ?>
<div class="id_action">
<div>
	<?
		if($USER -> IsAdmin() || true)
		{
			if($_REQUEST["nopic"] == "Y") $arResult["ACTION"]["PREVIEW"]["SRC"] = '';
			if(strlen($arResult["ACTION"]["PREVIEW"]["SRC"])>0)
			{?>
	<div class="stock-item stock-item_card">
		<div class="gift_info ">
			<div class="gift_info_text">
				<div style="text-align: center;">Акция!</div>
				<?=$arResult["ACTION"]["PREVIEW_TEXT"]?>
			</div>
			<div class="gift_info_bg gift_info_bg_right"></div>
		</div>
		<?
			}?>
		<div class="stock-block<?=(strlen($arResult["ACTION"]["PREVIEW"]["SRC"])>0?' picture':' nopicture')?>">
			<?
			if(strlen($arResult["ACTION"]["PREVIEW"]["SRC"])>0)
			{
				if($arResult["ACTION"]["PREVIEW"]["CONTENT_TYPE"] != "application/x-shockwave-flash")
				{?>
			<img alt="<?=$arResult["ACTION"]["NAME"]?>" src="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" />
			<?
				} else { ?>
			<object width="<?=$arResult["ACTION"]["PREVIEW"]["WIDTH"]?>" height="<?=$arResult["ACTION"]["PREVIEW"]["HEIGHT"]?>" data="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" type="application/x-shockwave-flash">
				<param value="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" name="movie">
				<param value="high" name="quality">
				<param value="transparent" name="wmode">
				<noembedded><img src="<?=($arResult["ACTION"]["DETAIL_PICTURE"]>0?CFile::GetPath($arResult["ACTION"]["DETAIL_PICTURE"]):'/img/gift_bg.png')?>" title="<?=$arResult["ACTION"]["NAME"]?>"></noembedded>
			</object>
			<?
				}
				echo '</div>';
			} else {
					echo '<div style="text-align: center;">Акция!</div>'.$arResult["ACTION"]["PREVIEW_TEXT"];
			}
			?>
		</div>
		<?
		} else {
			if($arResult["ACTION"]["PREVIEW"]["CONTENT_TYPE"] != "application/x-shockwave-flash")
			{?>
		<img alt="<?=$arResult["ACTION"]["NAME"]?>" src="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" />
		<?
			/* <a title="<?=$arResult["ACTION"]["NAME"]?>" target="_blank" href="<?=$strHref?>"><img alt="<?=$arResult["ACTION"]["NAME"]?>" src="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" /></a>
			*/
			} else { ?>
		<object width="<?=$arResult["ACTION"]["PREVIEW"]["WIDTH"]?>" height="<?=$arResult["ACTION"]["PREVIEW"]["HEIGHT"]?>" data="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" type="application/x-shockwave-flash">
			<param value="<?=$arResult["ACTION"]["PREVIEW"]["SRC"]?>" name="movie">
			<param value="high" name="quality">
			<param value="transparent" name="wmode">
			<noembedded><img src="<?=($arResult["ACTION"]["DETAIL_PICTURE"]>0?CFile::GetPath($arResult["ACTION"]["DETAIL_PICTURE"]):'/img/gift_bg.png')?>" title="<?=$arResult["ACTION"]["NAME"]?>"></noembedded>
		</object>
		
		<!--</div>--> 
		<!--stock-block --> 
		<!--<div class="stock-block">
<div style="text-align: center;">Акция!</div> при покупке чего-то что то дарим <br>Вот что дарим: <a href="#">Матрас какой то</a>
</div> --> 
		
		<!-- END -->
		<?
			}
		}?>
	</div>
</div>
<?
		}	
		echo showNoindex();
	?>
<div id="colorData_<?=md5($strSize)?>" class="color_data">
	<h4>
		<?=count($arColor)?>
		<?=getEnd(count($arColor), "цвет")?>
	</h4>
	<div class="select_block">
		<div class="select_block_bg">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th class="selectedOfferMiniPic"><img height="33" src="<?=SITE_TEMPLATE_PATH?>/img/1.gif" /></th>
					<td class="td1 selectedOfferColor purple">Cмотреть цвета и цены</td>
					<td class="selectedOfferAvail"><span>&nbsp;</span></td>
				</tr>
			</table>
		</div>
		<div class="select_block_bg1">
			<div class="select_block_popap" id="select_block_popap">
				<table cellpadding="0" cellspacing="0">
					<?
	$colorsHasSamePrice = true;
	foreach($arColor as $arOffer)
	{
		if($arOffer["PRICE"]["PRICE"]["PRICE"] != $arStartOffer["PRICE"]["PRICE"]["PRICE"] && $arOffer["PRICE"]["PRICE"]["PRICE"]>0) $colorsHasSamePrice = false;
		?>
					<tr<?=($arOffer["PROPERTY_COLOR_CODE_VALUE"] == $arStartOffer["PROPERTY_COLOR_CODE_VALUE"]?' class="selected"':'')?> rel="<?=$arOffer["ID"]?>">
						<th class="miniPic"><a href="#" alt="<?=CFile::GetPath($arOffer["PROPERTY_PICTURE_MAXI_VALUE"])?>" class='cloud-zoom-gallery' rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=CFile::GetPath($arOffer["PROPERTY_PICTURE_MIDI_VALUE"])?>' "><img height="33" src="<?=CFile::GetPath($arOffer["PROPERTY_PICTURE_MINI_VALUE"])?>" alt="<?=$arOffer["PROPERTY_COLOR_VALUE"]?>" /></a></th>
						<td width="40">&nbsp;</td>
						<td class="td_1"><p>
								<?=$arOffer["PROPERTY_COLOR_VALUE"]?>
							</p></td>
						<?
		if(true)
		{?>
						<td class="td_3" style="display:none;"><p><span<?=($arOffer["CATALOG_QUANTITY"]>0?'':' class="navail"')?>>
								<?=getAvailText($arOffer["CATALOG_QUANTITY"])?>
								</span></p></td>
						<?
		}?>
						<td nowrap class="td_4"><?
		if($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0){
			?>
							<b>
							<?=CurrencyFormat($arOffer["PROPERTY_OLD_PRICE_VALUE"], $arOffer["PRICE"]["PRICE"]["CURRENCY"])?>
							</b>
							<?
		} else echo '&nbsp;';?></td>
						<td nowrap class="price"><?
		if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
			echo 'Нет в продаже';
		elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
			echo 'Новинка! Ожидаем поставку.';
		elseif($arOffer["PRICE"]["PRICE"]["PRICE"]>0) {
			?>
							<strong><span>
							<?=($arOffer["CATALOG_QUANTITY"]<=0?'<font title="Цена последней продажи">':'')?>
							<?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>
							<?=($arOffer["CATALOG_QUANTITY"]<=0?'</font>':'')?>
							</span> р</strong>
							<?
		}?></td>
						<td class="td_2"><?
		if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
		{
			?>
							<a rel="nofollow" class="botton addToCartButton" href="action=ADD2BASKET&id=<?=$arOffer["ID"]?>&quantity=1" title="В корзину">В корзину</a>
							<?
		} elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
			?>
							<a rel="nofollow" class="notifyMeButton" href="#na_<?=$arOffer["ID"]?>" title="Уведомить о поставке">Уведомить о поставке</a>
							<?
		}

		/*
		if($arOffer["CATALOG_QUANTITY"]<=0)
		{
			?><a class="notifyMeButton" href="#na_<?=$arOffer["ID"]?>" title="Уведомить о поставке">Уведомить о поставке</a><?
		} else {
			?><a class="botton addToCartButton" href="action=ADD2BASKET&id=<?=$arOffer["ID"]?>&quantity=1" rel="" title="В корзину">В корзину</a><?
		}
		*/?></td>
					</tr>
					<?
	}?>
				</table>
			</div>
		</div>
	</div>
</div>
<?
		echo showNoindex(false);
	
	$strHtml = ob_get_contents();
	ob_end_clean();
	return $strHtml;
}

$arStartOffer = $arResult["CS"][$arResult["START_SIZE"]][$arResult["START_COLOR"]];


$user_id = $USER->GetID();
$pr=0;
foreach($arResult["LINKED_ITEMS"] as $arElem)
    if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0) $pr++;
?>
<div id="current-url" style="display:none;">
	<?=$_SERVER["REDIRECT_URL"]?>
</div>
<div id="product-id" style="display:none;">
	<?=$arResult["ID"]?>
</div>
<div id="user-id" style="display:none;">
	<?=$user_id;?>
</div>
<div id="qu_count" style="display:none;">
	<?=$pr?>
</div>
<div id="sel_colorsize" style="display:none;">
	<?=$arResult["LINKED_ITEMS"][0]["ID"]?>
</div>
<span id="element-id" style="display:none;">
<?=intval($arResult["ID"])?>
</span>
<?
$arCommonImg = array();
if($arResult["DETAIL_PICTURE"]["ID"]>0) $arCommonImg[] = $arResult["DETAIL_PICTURE"]["ID"];
if(!empty($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"])) $arCommonImg = array_merge($arCommonImg, $arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]);
?>
<div class="product_block">
	<?
if(count($arCommonImg)>0)
{?>
	<div class="product_block_photo">
		<ul id="mycarousel" class="jcarousel jcarousel-skin-tango">
			<?
	$strFirstImg = '';
	foreach($arCommonImg as $intImgID)
	{
		if($intImgID>0)
		{
			$smallImg = CFile::ResizeImageGet($intImgID, array("width"=>52, "height"=>52), BX_RESIZE_IMAGE_PROPORTIONAL);
			$bigImg = CFile::ResizeImageGet($intImgID, array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
			
			if(empty($strFirstImg)) $strFirstImg = $bigImg["src"];
		?>
			<li><a href="#" alt="<?=CFile::GetPath($intImgID)?>" class='cloud-zoom-gallery' rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=$bigImg["src"]?>' "><img src="<?=$smallImg["src"]?>" alt="<?=$arResult["NAME"]?>" /></a></li>
			<?
		}
	}?>
		</ul>
		<div id="large">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td><a title="<?=$arResult["NAME"]?>" href="/inc/picture_view.php?ELEMENT_ID=<?=$arResult["ID"]?>&img_id=<?=$arResult["DETAIL_PICTURE"]["ID"]?>" class="fancybox cloud-zoom" id='zoom1' rel="useZoom: 'zoom1', adjustX:-70, smallImage: '<?=$bigImg["src"]?>' " alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img src="<?=$strFirstImg?>" title="<?=$arResult["NAME"]?>" alt="<?=$arResult["NAME"]?>" /></a></td>
				</tr>
			</table>
			<div class="soc_block">
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
$arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false));?>
			</div>
		</div>
	</div>
	<?
}

?>
	<div class="product_block_info">
		<div class="rating"> #RATING# #REPORT_COUNT# </div>
		<h1><?=$arResult["PROPERTIES"]["H1"]["VALUE"]?></h1>
		<input type="hidden" id="offerID" value="<?=(count($arResult["CS"][$arResult["START_SIZE"]])<2?$arStartOffer["ID"]:'')?>" />
		<input type="hidden" id="productID" value="<?=$arResult["ID"]?>" />
		<?

$arTmpSizeHtml = array();
foreach($arResult["CS"] as $strSize => $arColor)
	$arTmpSizeHtml[$strSize] = getColorHtml($strSize, $arResult["CS"][$strSize], $arResult["START_OFFERS_BY_SIZE"][$strSize], $arResult);

//echo '<pre>'.print_r($arResult["CS"], true).'</pre>';

if(count($arResult["CS"][$arResult["START_SIZE"]])>0)
{?>
		<a name="colorsHere" id="colorsHere"></a>
		<?
		echo $arTmpSizeHtml[$arResult["START_SIZE"]];
}
?>
		<div style="position:absolute; top:-10000px; right:100000px;" id="colorsStorageHere">
			<?
foreach($arTmpSizeHtml as $strSize => $strSizeHtml)
{
	if($strSize != $arResult["START_SIZE"])
		echo $strSizeHtml;
}
?>
		</div>
		<?

if(count($arResult["CS"])>1)
{?>
		<h4>
			<?=count($arResult["CS"])?>
			<?=getEnd(count($arResult["CS"]), "размер")?>
		</h4>
		<ul class="size_select">
			<?
	$intCnt = 1;
	foreach($arResult["CS"] as $strSize => $arFoo)
	{
		$arClass = array();
		if($strSize == $arResult["START_SIZE"]) $arClass[] = 'active';
		if($intCnt == 1 || $intCnt%6==0) $arClass[] = 'first';
		if($intCnt%5 == 0) $arClass[] = 'last';
		if($intCnt>6) $arClass[] = 'second_flow';
		
		if($arResult["SIZE_AVAIL"][$strSize] == "Y")
			$htmlCross = '';
		else $htmlCross = '<div class="cross"></div>';
			
		?>
			<li<?=(count($arClass)>0?' class="'.implode(" ", $arClass).'"':'')?> id="lisize_<?=md5($strSize)?>">
				<?=$htmlCross?>
				<?=$strSize?>
			</li>
			<?
		$intCnt++;
	}?>
		</ul>
		<div class="clear"></div>
		<?
}?>
		<div class="total_block">
			<div class="total_block_left">
				<div class="total_block_left_left"<?=(in_array($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"], array(2100916, 2100920))?' style="width:200px;"':'')?>>
					<?
if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
{?>
					<h5 class="old_cost">
						<?=CurrencyFormat($arStartOffer["PROPERTY_OLD_PRICE_VALUE"], $arStartOffer["PRICE"]["PRICE"]["CURRENCY"])?>
					</h5>
					<?
}?>
					<h5 class="cost">
						<?
if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
	echo '<strong>Новинка! Ожидаем поставку.</strong>';
elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
	echo 'Нет в продаже';
else {
	?>
						<?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?>
						<?=number_format($arStartOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?>
						<span>P</span>
						<?
}?>
					</h5>
					<?

if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
{
	?>
					<a id="addToCartButton" class="addToCartButton in_basket ToBasket<?=($arStartOffer["CATALOG_QUANTITY"]>0?'':' hidden')?>" href="#" title="В корзину">В корзину</a>
					<?
} elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
	?>
					<a title="Уведомить о поставке" id="notifyMeButton" style="display:block;" class="notifyMeButton in_basket ToBasket nAvail<?=($arStartOffer["CATALOG_QUANTITY"]<=0?'':' hidden')?>" href="#">Уведомить о поставке</a>
					<?
} else {
	?>
					<a class="similarItemsLink" href="#similarItems">Cмотреть похожие товары</a>
					<?
}?>
				</div>
				<div class="total_block_left_right">
					<?
if(false)
{?>
					<h5>Сэкономьте до 5%</h5>
					<p><a href="#" title="">Подробнее</a></p>
					<br />
					<p><a class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Быстрый заказ</a></p>
					<?
} else {
	if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
	{?>
					<p style="padding-top: 30px"><a rel="nofollow" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Быстрый заказ</a></p>
					<?
	}?>
					<?}?>
				</div>
			</div>
			<div class="total_block_right">
				<?
if(false)
{?>
				<div class="gift_block_1"> <img src="/bitrix/templates/nmg/img/gift_bg.png" class="photo_1" width="25" height="29" alt="" />
					<h5>Подарок при покупке!</h5>
					<a class="link_4" href="#" title="">Игрушка и прорезыватель</a>
					<div class="gift_info">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td><div class="photo">
										<p><img src="/bitrix/templates/nmg/img/photo5.jpg" width="145" height="108" alt="" /><span>&nbsp;</span></p>
									</div></td>
								<td class="last"><div class="photo">
										<p><img src="/bitrix/templates/nmg/img/photo4.jpg" width="160" height="125" alt="" /><span>&nbsp;</span></p>
									</div></td>
							</tr>
						</table>
						<div class="gift_info_text">Мягкая игрушка "Avent Cat" и Игрушка "Снеговик" с носом-морковкой в подарок</div>
						<div class="gift_info_bg"></div>
						<a class="close" href="#" title=""></a> </div>
				</div>
				<?
}?>
				<div class="gift_block_2" style="margin-top: 35px;"> <img src="/bitrix/templates/nmg/img/delivery_bg.png" class="photo" width="49" height="26" alt="" />
					<h5 id="deliveryPrice">Доставка</h5>
					<p>внутри МКАД<span id="deliveryDate"> с <b style="color: #805695;">
						<?=getDeliveryDate()?>
						</b></span></p>
				</div>
			</div>
		</div>
		<?=showNoindex()?>
		<div class="links"> #ADD_TO_WISH_LIST#
			#ADD_TO_COMPARE_LIST# <a rel="nofollow" href="#FriendsRecomend" class="showpUp adviseToFriendLink"><img src="/bitrix/templates/nmg/img/icon4.png" width="12" height="12" alt="Уже в списке малыша" /><span>Рекомендовать другу</span></a> </div>
		<?=showNoindex(false)?>
	</div>
	<div class="clear"></div>
</div>
<div class="characteristic_block">
<div class="characteristic_left">
<?

$strProps = '';

// producer info here
if(strlen($arResult["PRODUCER"]["NAME"])>0) $strProps .= '<li><h4>Производитель</h4><p>'.$arResult["PRODUCER"]["NAME"].'</p></li>';

/*if(strlen($arResult["PROPERTIES"]["CH_STRANA_1"]["VALUE"])>0)
	$strProps .= '<li><h4>Страна производителя</h4><p>'.$arResult["PROPERTIES"]["CH_STRANA_1"]["VALUE"].'</p></li>';
elseif(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0) */

if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
	$strProps .= '<li><h4>Страна производителя</h4><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].'</p></li>';

unset($arResult["PROPERTIES"]["CH_STRANA_1"]);

/*if(strlen($arResult["PROPERTIES"]["CH_STRANA"]["VALUE"])>0)
	$strProps .= '<li><h4>Страна производства</h4><p>'.$arResult["PROPERTIES"]["CH_STRANA"]["VALUE"].'</p></li>';
elseif(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0)*/

if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0) $strProps .= '<li><h4>Страна производства</h4><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].'</p></li>';
	
unset($arResult["PROPERTIES"]["CH_STRANA"]);
	
if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0) $strProps .= '<li><h4>Гарантия</h4><p>'.$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"].'</p></li>';


// other props here
foreach($arResult["PROPERTIES"] as $key => $arProp)
{
	if(in_array($arProp["ID"], $arResult["HARACTERISTICS"]))
	{
		if($arProp["MULTIPLE"] == "Y")
			$arTmp["DISPLAY_VALUE"] = implode(", ", $arProp["VALUE"]);
		else $arTmp = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult["PROPERTIES"][$key], "news_out");
		
		if($key!="CH_INSTR1" && $arProp["VALUE"] != '' && strpos($arProp["CODE"], "CH_") ===0 && $arProp["CODE"] !== "CH_PRODUCER")
		{
			$arTmp["DISPLAY_VALUE"] = prepareMultilineText($arTmp["DISPLAY_VALUE"]);
			
			/*if(strpos($arTmp["DISPLAY_VALUE"], "<BR><br />") !== false)
			{
				$arTmp["DISPLAY_VALUE"] = trim($arTmp["DISPLAY_VALUE"]);
				if(substr($arTmp["DISPLAY_VALUE"], -10) == "<BR><br />") $arTmp["DISPLAY_VALUE"] = substr($arTmp["DISPLAY_VALUE"], 0, strlen($arTmp["DISPLAY_VALUE"])-10);
				$arTmp["DISPLAY_VALUE"] = '&mdash; '.$arTmp["DISPLAY_VALUE"];
				$arTmp["DISPLAY_VALUE"] = str_replace("<BR><br />", "<br>&mdash;", trim($arTmp["DISPLAY_VALUE"]));
			}*/
			
			$strProps .= '<li><h4>'.$arProp["NAME"].'</h4>	<p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';
		}
	}
}

if(strlen($strProps)>0)
{ ?>
<h2>
	<?=$arResult["NAME"]?>
	: характеристики</h2>
<div class="characteristic_info">
	<ul>
		<?=$strProps?>
	</ul>
</div>
<div class="clear"></div>
<br />
<br />
<?
}

if(strlen($arResult["DETAIL_TEXT"])>0)
{
	$arResult["DETAIL_TEXT"] = normalizeBR($arResult["DETAIL_TEXT"]);?>
<h2>
	<?=$arResult["NAME"]?>
	: описание</h2>
<div class="headline">&nbsp;</div>
<div class="characteristic_text">
	<?
			echo prepareMultilineText($arResult["DETAIL_TEXT"]);
			//echo '<div><a class="fullTextLink" href="#">+ полное описание</a></div>';
			//echo '<div class="fullText hidden"><br>Ищете где купить '.ToLower($arResult["NAME"]).'? Цена на '.ToLower($arResult["NAME"]).' в нашем интернет магазине Вас приятно удивит!<p><a class="fullTextHideLink" href="#">скрыть описание</a></p></div>';
		
	/*$intStrPos = stripos($arResult["DETAIL_TEXT"], "<br");
	
	if($intStrPos<=0) $intStrPos = strlen($arResult["DETAIL_TEXT"]);
	$strPreview = substr($arResult["DETAIL_TEXT"], 0, $intStrPos);
	if($arResult["DETAIL_TEXT"] != $strPreview)
	{
		echo '<div>'.$strPreview.'<br><a class="fullTextLink" href="#">+ полное описание</a></div>';
		echo '<div class="fullText hidden">'.$arResult["DETAIL_TEXT"].'<br><br><p><a class="fullTextHideLink" href="#">скрыть описание</a></p></div>';
	} else echo $arResult["DETAIL_TEXT"];*/
			
	/*
	$intStrPos = stripos($arResult["DETAIL_TEXT"], "<br");
	
	if($intStrPos<=0) $intStrPos = strlen($arResult["DETAIL_TEXT"]);
	$strPreview = substr($arResult["DETAIL_TEXT"], 0, $intStrPos);
	if($arResult["DETAIL_TEXT"] != $strPreview)
	{
		echo '<div>'.$strPreview.'<br><a class="fullTextLink" href="#">+ полное описание</a></div>';
		echo '<div class="fullText hidden">'.$arResult["DETAIL_TEXT"].'<br><br>
			Ищете где купить '.ToLower($arResult["NAME"]).'? Цена на '.ToLower($arResult["NAME"]).' в нашем интернет магазине Вас приятно удивит!<p><a class="fullTextHideLink" href="#">скрыть описание</a></p></div>';
	} else echo $arResult["DETAIL_TEXT"].'<br><br>
			Ищете где купить '.ToLower($arResult["NAME"]).'? Цена на '.ToLower($arResult["NAME"]).' в нашем интернет магазине Вас приятно удивит!';
	*/
	?>
</div>
<div class="clear"></div>
<?
}?>
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












if(false)
{
?>
<div id="elementCatalog">
	<? // список свойств привязанных товаров для js ?>
	<?
global $USER; 
$user_id = $USER->GetID();
?>
	<?//xvar_dump($arResult["LINKED_ITEMS"]);
$pr=0;
foreach($arResult["LINKED_ITEMS"] as $arElem) {
    if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0)
        $pr++;
}
?>
	<div id="current-url" style="display:none;">
		<?=$_SERVER["REDIRECT_URL"]?>
	</div>
	<div id="product-id" style="display:none;">
		<?=$arResult["ID"]?>
	</div>
	<div id="user-id" style="display:none;">
		<?=$user_id;?>
	</div>
	<div id="qu_count" style="display:none;">
		<?=$pr?>
	</div>
	<div id="sel_colorsize" style="display:none;">
		<?=$arResult["LINKED_ITEMS"][0]["ID"]?>
	</div>
	<div id="linked-items" style="display:none;">
		<?foreach($arResult["LINKED_ITEMS"] as $arLinkedItem):?>
		<div class="item" id="linked-item-id-<?=$arLinkedItem["ID"]?>">
			<div class="element-id">
				<?=$arLinkedItem["ID"]?>
			</div>
			<div class="name">
				<?=$arLinkedItem["NAME"]?>
			</div>
			<div class="color">
				<?=$arLinkedItem["PROPERTY_COLOR_VALUE"]?>
			</div>
			<div class="color-code">
				<?=$arLinkedItem["PROPERTY_COLOR_CODE_VALUE"]?>
			</div>
			<div class="size">
				<?=$arLinkedItem["PROPERTY_SIZE_VALUE"]?>
			</div>
			<div class="price">
				<?=$arLinkedItem["PRICE"]?>
			</div>
			<div class="quantity">
				<?=$arLinkedItem["QUANTITY"]?>
			</div>
			<div class="old-price">
				<?=$arLinkedItem["PROPERTY_OLD_PRICE_VALUE"]?>
			</div>
			<div class="bonus-scores">
				<?=$arLinkedItem["PROPERTY_BONUS_SCORES_VALUE"]?>
			</div>
			<div class="articul">
				<?=$arLinkedItem["PROPERTY_ARTICUL_VALUE"]?>
			</div>
			<div class="mini-src">
				<?=MegaResizeImage($arLinkedItem["PROPERTY_PICTURE_MINI_VALUE"], 32, 32)?>
			</div>
			<?$file = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"],array("width"=>256,"height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL)?>
			<div class="midi-src">
				<?=$file["src"]?>
			</div>
			<?//$file2 = CFile::GetPath($arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"]);?>
			<?$file2 = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"],array("width"=>256,"height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT)?>
			<div class="midi-src-max">
				<?=$file2["src"]?>
			</div>
			<div class="midi-id">
				<?=$arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"]?>
			</div>
			<div class="maxi-id">
				<?=$arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"]?>
			</div>
			<?//$file = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"],array("width"=>640,"height"=>480),BX_RESIZE_IMAGE_PROPORTIONAL)?>
			<div class="maxi-src">
				<?=CFile::GetPath($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"])?>
			</div>
		</div>
		<?endforeach?>
	</div>
	<script>
	$(document).ready(function(){

		////////////////////////////////////////////////////////
		// Отмечаем самый минимальный по цене доступный товар //
		////////////////////////////////////////////////////////
		 var min_price = parseInt($('#linked-items .price').html());
		 var min_price_active = 0;
		// var min_price_product_id = 0;
		// var min_price_product_id_active = 0;
		
		$('#linked-items .item').each(function(){
			var current_price = parseInt($(this).find('.price').html());
			var current_product_id = $(this).find('.element-id').html();
			
			//наименьшая цена
			if (current_price < min_price)
			{
				min_price = current_price;
				min_price_product_id = current_product_id;
			}
			
			//наименьшая цена среди активных
			if (parseInt($(this).find('.quantity').html()) > 0)
			{
				//current_price = parseInt($(this).find('.price').html())
				if ((current_price < min_price_active && min_price_active > 0) || min_price_active == 0)
				{
					min_price_active = current_price;
					min_price_product_id_active = current_product_id;
				}
			}
			
		});
		
		//console.log(min_price_active);
		if(min_price_active>0)
			$("#Basketplash .Price").html("<span>&nbsp;</span> "+CurrencyFormat(min_price_active)+" <span>р</span>");
            
		var colors_count = $('.ColorList .item').size();
		var sizes_count = $('.SizeList .item').size();
		
		//console.log(colors_count);
		//console.log(sizes_count);
		if(colors_count>0)
			$("#Basketplash #colorVal").val("");
		
		if(sizes_count>2)
			$("#Basketplash #sizeVal").val("");
		// отмечем радибаттоны цвета и размера
		// $('#linked-items .item').each(function(){
			// if ($(this).find('.element-id').html() == min_price_product_id_active)
			// {
				// var color_code = $(this).find('.color-code').html();
				// var size = $(this).find('.size').html();
				// $('#color_'+color_code).click();
				// $('#size_'+size).click();
			// }
		// });
	});
</script>
	<? // получаем производителя ?>
	<?foreach($arResult["PROPERTIES"] as $key => $arProp):?>
	<?if (strpos($arProp["CODE"], "CH_") !== false):?>
	<?if($arProp["CODE"] == "CH_PRODUCER"):?>
	<?
			if(is_array($arProp["VALUE"]))
				$arProp["VALUE"] = $arProp["VALUE"][0];
				
			//print_R($arProp["VALUE"]);
            $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arProp["VALUE"]), false, false, array("ID", "IBLOCK_ID", "NAME"));
            if($obEl = $dbEl->GetNext())
            {
                $producer_value = $obEl["NAME"];
            }
            break;
            ?>
	<?else:?>
	<?continue;?>
	<?endif?>
	<?endif?>
	<?endforeach?>
	<?if ($_REQUEST["IS_AJAX"]):?>
	<script type="text/javascript">
    // массив id цветоразмеров вида arColorsSizes['white'][10] => id элемента 
    var arColorsSizesAJAX = new Array();
    <?foreach($arResult["LINKED_COLORS"] as $color):?>
        arColorsSizesAJAX['<?=$color?>'] = new Array();
        <?foreach($arResult["LINKED_SIZES"] as $size):?>
            <?if ($arResult["COLOR_SIZE"][$color][$size]["ID"] > 0):?>
                arColorsSizesAJAX['<?=$color?>']['<?=$size?>'] = <?=$arResult["COLOR_SIZE"][$color][$size]["ID"]?>;
            <?endif?>
        <?endforeach?>
    <?endforeach?>

</script>
	<?else:?>
	<script type="text/javascript">
    // массив id цветоразмеров вида arColorsSizes['white'][10] => id элемента 
    var arColorsSizes = new Array();
    <?foreach($arResult["LINKED_COLORS"] as $color):?>
        arColorsSizes['<?=$color?>'] = new Array();
        <?foreach($arResult["LINKED_SIZES"] as $size):?>
            <?if ($arResult["COLOR_SIZE"][$color][$size]["ID"] > 0):?>
                arColorsSizes['<?=$color?>']['<?=$size?>'] = <?=$arResult["COLOR_SIZE"][$color][$size]["ID"]?>;
            <?endif?>
        <?endforeach?>
    <?endforeach?>

</script>
	<?endif?>
	<?if (empty($arResult["PROPERTIES"]["VOTES"]["VALUE"])) $arResult["PROPERTIES"]["VOTES"]["VALUE"]=0;?>
	<span id="element-id" style="display:none;">
	<?=$arResult["ID"]?>
	</span>
	<div class="CatalogCenterColumn RExist">
		<div id="DetailPhotoChoose">
			<?//xvar_dump($arResult)?>
			<?if($arResult["PROPERTIES"]["MODEL_3D"]["VALUE"]!=''):?>
			<div class="rel"> <a class="ttp_lnk" onclick="window.open('/view360.php?idt=<?=$arResult["ID"]?>', 'wind1','width=900, height=600, resizable=no, scrollbars=yes, menubar=no')" href="javascript:" title="Подробная 3D - Модель"><i class="img360"></i></a> </div>
			<?endif;?>
			<div id="PictureBlock" clearfix>
				<?$file = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"],array("width"=>256,"height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT)?>
				<?$file =  $file["src"];?>
				<div id="midi-picture" class="DPicture clearfix">
					<div class="zoom-section">
						<?if (isset($_REQUEST["IS_AJAX"])):?>
						<img alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" src="<?=$file?>">
						<?else:?>
						<?if(file_exists($_SERVER["DOCUMENT_ROOT"].$arResult["DETAIL_PICTURE"]["SRC"])){?>
						<a href="/inc/picture_view.php?ELEMENT_ID=<?=$arResult["ID"]?>&img_id=<?=$arResult["DETAIL_PICTURE"]["ID"]?>" class="fancybox cloud-zoom"  id='zoom1' rel="adjustX: 30, adjustY:-4, zoomWidth: '400'" alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img src="<?=$file?>"></a>
						<?}else{?>
						<a href="#" class="fancybox"><img src=""></a>
						<?}?>
						<?endif?>
					</div>
				</div>
				<?//print_R($arResult["LINKED_COLORS_ITEMS"]);?>
				<?if(!$_REQUEST["IS_AJAX"]):?>
				<div class="DPictureListArea">
					<?$i=0;
        foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem) {
            if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0)
                $i++;
        }?>
					<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) > 5):?>
					<div class="prev"></div>
					<?endif?>
					<?//xvar_dump(count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 + $i)?>
					<?//$file = CFile::MakeFileArray($arResult["DETAIL_PICTURE"]["ID"]);
		///print_R($file);
		?>
					<div class="zoom-desc DPictureList<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) < 6):?>  DPictureListMargin<?endif;?><?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) > 5):?> DPictureListCarousel<?endif;?>">
						<ul>
							<?if(intval($arResult["DETAIL_PICTURE"]["ID"])>0):?>
							<?$picID = $arResult["DETAIL_PICTURE"]["ID"];?>
							<?$file = CFile::ResizeImageGet($picID, array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
							<?if($file!=false && file_exists($_SERVER["DOCUMENT_ROOT"].$file["src"])):?>
							<?$file2=CFile::ResizeImageGet($picID, array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,true);?>
							<li> <a href="#" alt="<?=CFile::GetPath($arResult["DETAIL_PICTURE"]["ID"])?>" class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?=$file2["src"]?>', zoomWidth: '400' ">
								<?=ShowImage($file["src"],32,32);?>
								</a>
								<?//echo $picID."--";?>
								<span class="midi-picture-src" style="display:none;">
								<?=$file2["src"]?>
								</span> <span class="maxi-picture-src" style="display:none;">
								<?=CFile::GetPath($arResult["DETAIL_PICTURE"]["ID"])?>
								</span> <span class="picture-id" style="display:none;">
								<?=$arResult["DETAIL_PICTURE"]["ID"]?>
								</span> </li>
							<?endif;?>
							<?endif?>
							<?foreach($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"] as $img_id):?>
							<?$file = CFile::ResizeImageGet($img_id, array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL);?>
							<?if($file!=false && file_exists($_SERVER["DOCUMENT_ROOT"].$file["src"])):?>
							<li>
								<?//print_R($file);?>
								<?$file2 = CFile::ResizeImageGet($img_id,  array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL)?>
								<a href="#" alt="<?=CFile::GetPath($img_id)?>" class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?=$file2["src"]?>', zoomWidth: '400' "><img src="<?=$file["src"]?>" /></a> <span class="midi-picture-src" style="display:none;">
								<?=$file2["src"]?>
								</span> <span class="maxi-picture-src" style="display:none;">
								<?=CFile::GetPath($img_id)?>
								</span> <span class="picture-id" style="display:none;">
								<?=$img_id?>
								</span> </li>
							<?endif;?>
							<?endforeach?>
							<?/*
            <?foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem): // изображения цветоразмеров (только разные цвета)?>
				
				<?if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0):?>
                <li>	
				
				<?//echo "sdfffffffffffffffffff";?>
				
					<?//print_R($arColorItem)?>
					<?$file = CFile::ResizeImageGet($arColorItem["PROPERTY_PICTURE_MINI_VALUE"],array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
                    <a href="#"><img src="<?=$file["src"]?>" /></a>
					<?$file = CFile::ResizeImageGet($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"],array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
                    <span class="midi-picture-src" style="display:none;"><?=$file["src"]?></span>
                    <span class="maxi-picture-src" style="display:none;"><?=CFile::GetPath($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])?></span>
                    <span class="picture-id" style="display:none;"><?=$arColorItem["PROPERTY_PICTURE_MAXI_VALUE"]?></span>
                </li>
				<?endif;?>
            <?endforeach?>
			*/?>
						</ul>
						<div class="clear"></div>
					</div>
					<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1) > 5):?>
					<div class="next"></div>
					<?endif?>
					<div class="clear"></div>
				</div>
				<div class="DPictureLnk"><a class="fancybox-detail bluedot" href="/inc/picture_view.php?ELEMENT_ID=<?=$arResult["ID"]?>">Смотреть все фотографии</a></div>
				<?endif?>
			</div>
			<div id="ChooseBlock">
				<?if($_REQUEST["IS_AJAX"]):?>
				<h1 style="margin-bottom:15px;">
					<?=$arResult["NAME"]?>
				</h1>
				<?else:?>
				<h1>
					<?=$arResult["NAME"]?>
				</h1>
				<?if(!empty($arResult["PROPERTIES"]["ARTICUL"]["VALUE"])):?>
				<div class="article">Артикул:
					<?=$arResult["PROPERTIES"]["ARTICUL"]["VALUE"];?>
				</div>
				<?endif;?>
				<div class="manufacturer"><span>Производитель:</span>&nbsp;
					<?=$producer_value?>
					<div class="clear"></div>
				</div>
				<?if(isset($arResult["PROPERTIES"]['STRANA']['VALUE'])):?>
				<div class="manufacturer">
					<div class="top5"></div>
					<span>Страна производителя:</span>&nbsp;&nbsp;&nbsp;
					<?=$arResult["PROPERTIES"]['STRANA']['VALUE']?>
					<?//print_R($arResult["PROPERTIES"]);?>
					<div class="clear"></div>
				</div>
				<?endif;?>
				<div class="actions">
					<?//print_R($arResult)?>
					#RATING#
					#REPORT_COUNT#
					<div class="clear"></div>
				</div>
				<?endif?>
				<?if (count($arResult["LINKED_SIZES_ITEMS"]) > 0):?>
				<div class="round_plash">
					<div class="rp_head"></div>
					<div class="rp_content">
						<div class="rp_content">
							<div class="clear"> </div>
							<form action="?">
								<div class="clear"> </div>
								<?if(count($arResult["LINKED_COLORS_ITEMS"])>1):?>
								<div class="ColorError">Выберите цвет</div>
								<?endif;?>
								<div class="Color">Цвет: <span> - </span></div>
								<div class="ColorList zoom-desc" <?if(intval($arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"])<=0):?>style="margin:0"<?endif;?>>
									<?foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem):?>
									<?if(file_exists($_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arColorItem["PROPERTY_PICTURE_MINI_VALUE"]))):?>
									<?$file2 = CFile::ResizeImageGet($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"],  array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL)?>
									<div class="item color-id-<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>"> <a href="#" alt="<?=CFile::GetPath($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?=$file2["src"]?>', zoomWidth: '400'">
										<label for="color_<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>">
											<?//echo " ".$arColorItem["PROPERTY_PICTURE_MINI_VALUE"]?>
											<img src="<?=MegaResizeImage($arColorItem["PROPERTY_PICTURE_MINI_VALUE"], 32, 32)?>" /> </label>
										<input type="radio" id="color_<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>" name="color" />
										</a> <span class="current-color-code" style="display:none;">
										<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>
										</span> <span class="current-color" style="display:none;">
										<?=$arColorItem["PROPERTY_COLOR_VALUE"]?>
										</span> </div>
									<?endif;?>
									<?endforeach?>
									<div class="clear"></div>
								</div>
								<?if(count($arResult["LINKED_SIZES_ITEMS"])>1):?>
								<div class="SizeError">Выберите размер</div>
								<div class="Size">Размер: <span>-</span></div>
								<div class="SizeList">
									<?foreach($arResult["LINKED_SIZES_ITEMS"] as $arSizeItem):?>
									<div class="item size-id-<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>">
										<input type="radio" name="size" id="size_<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>" />
										<label for="size_<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>">
											<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>
										</label>
										<span class="current-size" style="display:none;">
										<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>
										</span> </div>
									<?endforeach?>
									<div class="clear"></div>
									<div class="clear"></div>
								</div>
								<?else:?>
								<?//print_r($arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]);?>
								<div class="SizeList hide">
									<div class="item size-id-<?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?>">
										<input type="hidden" name="size" id="size_<?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?>" />
										<span class="current-size" style="display:none;">
										<?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?>
										</span> </div>
								</div>
								<?endif;?>
							</form>
							<?if(strlen($arResult["PROPERTIES"]['URL_SIZE']['VALUE'])>0):?>
							<a class="dotted_a how" href="<?=$arResult["PROPERTIES"]['URL_SIZE']['VALUE']?>">Как выбрать размер?</a>
							<?endif;?>
						</div>
					</div>
					<div class="rp_footer"></div>
				</div>
				<?endif?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?if ($_REQUEST["IS_AJAX"]):?>
	<div class="clear"></div>
	<div class="price-layer">
		<div class="price"><span>&nbsp;</span> 15 000 <span>р</span></div>
		<a href="#" class="add-to-basket-me"></a>
		<div class="clear"></div>
	</div>
	<?endif?>
	<?if ($_REQUEST["IS_AJAX"]):?>
	<div class="clear"></div>
	<?else:?>
	<?//print_R();?>
	<div class="CatalogRightColumn">
		<div class="yellow_plash" id="Basketplash">
			<div class="ytp"></div>
			<div class="yc">
				<?//xvar_dump($arResult["PROPERTIES"]["QU_ACTIVE"])?>
				<?if($arResult["PROPERTIES"]["QU_ACTIVE"]["VALUE"] == "Y"):?>
				<div class="Quantity" style="text-align: center;">Количество<br />
					<input id="Quantity_val" value="1" type="text" style="width: 45px;" />
				</div>
				<?endif?>
				<?if(isset($arResult["DISPLAY_PROPERTIES"]["OLD_PRICE"]["VALUE"])):?>
				<div class="OldPrice">
					<?=$arResult["DISPLAY_PROPERTIES"]["OLD_PRICE"]["VALUE"]?>
					<span>р</span></div>
				<?endif?>
				<div class="Price"><span>&nbsp;</span>
					<?=$arResult["DISPLAY_PROPERTIES"]["PRICE"]["VALUE"]?>
					<span>р</span></div>
				<div id="priceNote" class="gray smallest">Цена может зависеть от цвета или размера</div>
				<input type="hidden" id="colorVal" value="<?=$arResult["LINKED_COLORS"][0]?>">
				<input type="hidden" id="sizeVal" value="<?=$arResult["LINKED_SIZES"][0]?>">
				<a class="ToBasket" href="#"></a>
				<?/*<div class="ball">3.5 балла за покупку</div>*/?>
			</div>
			<div class="ybt"></div>
		</div>
		<div class="Delivery"> <a href="/how-to-buy/#delivery">Способы доставки</a><br>
			<br>
		</div>
		<div class="Share"> #ADD_TO_WISH_LIST#
			#ADD_TO_COMPARE_LIST#
			<div class="action" id="Recomend">
				<div class="DIcon" ></div>
				<a href="#FriendsRecomend" class="showpUp">Рекомендовать другу</a>
				<div class="clear"></div>
			</div>
			<div class="soci">
				<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
$arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false));?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="CatalogCenterColumn RExist">
		<div class="goods">
			<h2>
				<?=substr($arResult["NAME"],0,75)?>
				<?if(strlen($arResult["NAME"])>75):?>
				...
				<?endif?>
				описание</h2>
			<div class="description">
				<?=$arResult["DETAIL_TEXT"]?>
			</div>
			<?if(!empty($arResult["PROPERTIES"]["CH_INSTR1"]["VALUE"])):?>
			<div class="description">
				<p class="bold">Инструкция:</p>
				<?$arFile = CFile::GetFileArray($arResult["PROPERTIES"]["CH_INSTR1"]["VALUE"]);?>
				<p><a target="_blank" href="<?=$arFile["SRC"]?>">
					<?=$arFile["ORIGINAL_NAME"]?>
					</a></p>
			</div>
			<?endif;?>
		</div>
	</div>
	<div class="CatalogRightColumn">
		<div class="short_block want">
			<h3>Хотят</h3>
			<div class="sub"><!--#UWANT#--></div>
		</div>
		<div class="short_block have">
			<h3>Уже имеют</h3>
			<div class="sub"><!--#UHAVE#--></div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="DetailSmallCenterColumn" id="haract">
		<div class="goods">
			<h2>Характеристики</h2>
			<div class="choose"> <span class="active"> <span> <a href="#">Основные</a> </span> </span> <span> <span> <a href="#">Все</a> </span> </span> </div>
			<div class="clear"></div>
			<div class="TabProp">
				<h3>Общие характеристики</h3>
				<table class="DProp">
					<?foreach($arResult["PROPERTIES"] as $key => $arProp):?>
					<?if($key!="CH_INSTR1"):?>
					<?//print_R($arProp);?>
					<?if($arProp["VALUE"]!=''):?>
					<?if (strpos($arProp["CODE"], "CH_") !== false):?>
					<?if($arProp["CODE"] == "CH_PRODUCER"):?>
					<?
								
                                $arProp["VALUE"] = $producer_value;
								continue;
                            ?>
					<?endif?>
					<tr<?if (!in_array($arProp["ID"],$arResult["HARACTERISTICS"])):?> class="DHidePropTr"<?endif?>>
						<td class="DNameTD"><div class="DName">
								<?=$arProp["NAME"]?>
							</div>
							<div class="Dsep"></div></td>
						<td class="DValueTD"><?if(is_array($arProp["VALUE"])):?>
							<?if(isset($arProp["VALUE"]["TYPE"]) && ($arProp["VALUE"]["TYPE"]=="TEXT" || $arProp["VALUE"]["TYPE"]=="HTML" || $arProp["VALUE"]["TYPE"]=="text" || $arProp["VALUE"]["TYPE"]=="html")):?>
							<?if($arProp["VALUE"]["TYPE"]=="HTML" || $arProp["VALUE"]["TYPE"]=="html"):?>
							<?=$arProp["~VALUE"]["TEXT"]?>
							<?else:?>
							<pre><?=$arProp["VALUE"]["TEXT"]?>
</pre>
							<?endif;?>
							<?else:?>
							<?=implode(", ",$arProp["VALUE"])?>
							<?endif;?>
							<?else:?>
							<?=$arProp["VALUE"]?>
							<?endif?></td>
					</tr>
					<?endif?>
					<?endif;?>
					<?endif;?>
					<?endforeach?>
				</table>
			</div>
		</div>
	</div>
	<?endif?>
</div>
<?
///////////////////////////////////////
// Всплывающие окна для всякой хрени //
///////////////////////////////////////    
?>
<?global $USER;?>
<div id="FriendsRecomend" class="CatPopUp<?if (!$USER->IsAuthorized()):?> FriendsRecomendSmallVar<?endif?>">
	<div class="white_plash">
		<div class="exitpUp"></div>
		<div class="cn tl"></div>
		<div class="cn tr"></div>
		<div class="content">
			<div class="content">
				<div class="content">
					<div class="clear"></div>
					<div class="title">Рекомендовать другу</div>
					<form class="jqtransform" action="?">
						<div class="data">
							<div class="left_part">
								<label for="femail">Электронный адрес</label>
								<div class="clear"></div>
								<input type="text" id="femail" style="width:216px;"/>
								<div class="clear"></div>
								<input type="submit" class="sbm" value="Рекомендовать">
							</div>
							<?
		global $USER;
		$APPLICATION->IncludeComponent("individ:socialnetwork.user_friends", "sendmail", array(
	"SET_NAV_CHAIN" => "N",
	"ITEMS_COUNT" => "10",
	"ID" => $USER->GetID()
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
						</div>
						<div class="clear"></div>
					</form>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="cn bl"></div>
		<div class="cn br"></div>
	</div>
</div>
<div id="msgBasket" class="CatPopUp">
	<div class="white_plash">
		<div class="exitpUp"></div>
		<div class="cn tl"></div>
		<div class="cn tr"></div>
		<div class="content">
			<div class="content">
				<div class="content">
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="cn bl"></div>
		<div class="cn br"></div>
	</div>
</div><?
}
}?>