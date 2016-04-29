<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?><input type="hidden" id="nohide" value="1"><?
if(is_array($arResult["ROWS"]) && count($arResult["ROWS"])>0)
{ ?>
<div class="main_product_headline">
	<h3>Скидки</h3>
	<div class="clear"></div>
</div>
<ul class="main_product_list"><?
	foreach($arResult["ROWS"] as $arItems)
	{
		foreach($arItems as $intCnt => $arElement)
		{
			$arFileTmp = CFile::ResizeImageGet(
				$arElement["PREVIEW_PICTURE"],
				array("width" => 105, 'height' => 120),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);
			?>
	<li<?=(($intCnt+1)%4==0?' class="last"':'')?>><?
			if(strlen($arElement['NAME'])>0)
			{
				if(strlen($arFileTmp["src"])>0)
				{?>
		<div class="photo">
			<p><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=$arElement['NAME']?>" /></a><span>&nbsp;</span></p>
		</div><?
				}?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?>
		<div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><?=smart_trim($arElement['NAME'], 40)?></a></div>
		<strong><?=($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"]<=0?'от ':'')?><?=CurrencyFormat($arElement["PROPERTIES"]['PRICE']["VALUE"], "RUB")?></strong><?
				if($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"]>0)
				{
					?><i class="oldprice"><?=CurrencyFormat($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"], "RUB")?></i><?
				}
			}?>
	</li><?
		}
	}?>
</ul><?
}
?>
<div class="clear"></div>