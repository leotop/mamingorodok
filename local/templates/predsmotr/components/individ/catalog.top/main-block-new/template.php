<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(count($arResult["ROWS"])>0)
{?>
<div class="main_product_headline">
	<h3>Новинки</h3><?
	if(false)
	{?>
	<a href="/catalog/title/new/" title="Показать все">Показать все</a><?
	}?>
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
			if(strlen($arFileTmp["src"])>0)
			{?>
		<div class="photo">
			<p><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=$arElement['NAME']?>" /></a><span>&nbsp;</span></p>
		</div><?
			}?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?>
		<div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><?=smart_trim($arElement['NAME'], 49)?></a></div>
		<strong><?=CurrencyFormat($arElement["PROPERTIES"]['PRICE']["VALUE"], "RUB")?></strong>
	</li><?
		}
	}?>
</ul><?
}
?>
<div class="clear"></div>