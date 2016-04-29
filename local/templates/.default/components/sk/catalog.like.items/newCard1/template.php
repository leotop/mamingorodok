<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(count($arResult["ITEMS"])>0)
{ ?><a name="similarItems"></a>
<div class="crumbs_black crumbs_black_big ">Похожие товары</div>
<div class="similar_block">
	<ul><?
	foreach($arResult["ITEMS"] as $arItem)
	{   
		?>
		<li><?
		if($arItem["PREVIEW_PICTURE"]["ID"]>0)
		{
           // arshow($arItem["PREVIEW_PICTURE"],true);
			$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"]["ID"],
				array("width" => 160, 'height' => 130),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				false
			);
        }else{
            $arFileTmp["src"] = "/img/no_foto.jpg";
            $arFileTmp["width"] = "130";
            $arFileTmp["height"] = "130";   
        }?>   
			<div class="photo">
				<p><a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>"><img width="<?=$arFileTmp["width"]?>" height="<?=$arFileTmp["height"]?>" src="<?=$arFileTmp["src"]?>" alt="<?=$arItem["NAME"]?>" /></a><span>&nbsp;</span></p>
			</div><?
	
		
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
		<span class="acess_price">Цена:&nbsp;<?=number_format($arItem["PROPERTY_PRICE_VALUE"], 0, '.', ' ' )?><div class="rub_none">руб.</div><span class="rub"> a</span><?
		if($arItem["PROPERTY_OLD_PRICE_VALUE"]>0)
		{?>
			<i><?=number_format($arItem["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ' )?><div class="rub_none">руб.</div><span class="rub"> a</span>?></i><?
		};?>
		</li><?
	}?>
	</ul>
</div><?
} else { ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".similarItemsLink").hide();
	});
</script><?	
}?>