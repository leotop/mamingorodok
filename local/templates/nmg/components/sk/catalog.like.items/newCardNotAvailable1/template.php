<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

 
if(count($arResult["ITEMS"])>0)
{ ?><a name="similarItems" id="similarItems"></a><br>
<div class="crumbs_black crumbs_black_big ">Аналогичные модели</div>
<div class="similar_block">
	<ul><?
	foreach($arResult["ITEMS"] as $arItem)
	{
		?>
		<li><?
		if($arItem["PREVIEW_PICTURE"]["ID"]>0)
		{
			$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"],
				array("width" => 160, 'height' => 130),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);?>
			<div class="photo">
				<p><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=$arItem["NAME"]?>" /></a><span>&nbsp;</span></p>
			</div><?
		}
		
		$textR = '';
		$rsReply = CacheRatingReviews::GetByID($arItem["ID"]);
	
		if(is_array($rsReply))
		{
			$count = $rsReply["FORUM_MESSAGE_CNT"];
			if($count>0)
				$textR = '<a href="'.$rsReply["DETAIL_PAGE_URL"].'#reports" class="comment grey">'.$count.' '.RevirewsLang($count,true).'</a>';
			else $textR = '<a href="'.$rsReply["DETAIL_PAGE_URL"].'#comment" class="comment grey">'.RevirewsLang($count,true).'</a>';
		}
		
		$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $textR, 'Raiting'=>$arElement["PROPERTY_RATING_VALUE"]), array("MODE"=>"html"));
			?>
			<div class="link"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><?=smart_trim($arItem['NAME'], 45)?></a></div>
			<span class="fat similar_price"><?=CurrencyFormat($arItem["PROPERTY_PRICE_VALUE"], "RUB")?></span><?
		if($arItem["PROPERTY_OLD_PRICE_VALUE"]>0)
		{?>
			<i><?=CurrencyFormat($arItem["PROPERTY_OLD_PRICE_VALUE"], "RUB")?></i><?
		};?>
		</li><?
	}?>
	</ul>
</div><?
}?>