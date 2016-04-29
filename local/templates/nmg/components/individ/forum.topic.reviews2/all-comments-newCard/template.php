<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//arshow($arResult);
if(!empty($arResult["MESSAGES"]))
{ ?>
<div id="reports"></div>
<div class="headline">&nbsp;</div>
<div class="characteristic_text">
	<ul class="comment_list" id="reviewListContainer"><?
	$i = 0;
	foreach($arResult["MESSAGES"] as $key => $arMessage)
	{
		$strName = $arMessage["AUTHOR"]["NAME"];
		if(strlen($arMessage["AUTHOR"]["LAST_NAME"])>0) $strName .= (strlen($strName)>0?' ':'').$arMessage["AUTHOR"]["LAST_NAME"];
		if(strlen($strName)<=0) $strName = $arMessage["AUTHOR"]["LOGIN"];
		?>
		<span itemscope itemtype="http://data-vocabulary.org/Review">
			<li class="comment top15<?=($i>2?' hidden':'')?>" id="review<?=$arMessage["ID"]?>">
				<a name="message<?=$arMessage["ID"]?>"></a>
				<div class="headline_info"> <img src="/bitrix/templates/nmg/images/profile_img.png" width="40" class="photo" height="40" alt="" />
					<h6><a href="/community/user/<?=$arMessage["AUTHOR_ID"]?>/" title="<?=$strName?>"><?=$strName?></a></h6><?
			if(false)
			{?>
					<p><img src="/bitrix/templates/nmg/images/profile_img.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span><img src="/bitrix/templates/nmg/images/profile_img.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span></p><?
			}?>
					
					<div class="rating"> <?=showRating($arMessage["RATING"], false)?> <b><time itemprop="dtreviewed" datetime="<?=$arMessage["POST_DATE"]?>"><?=$arMessage["POST_DATE"]?></time></b> </div>
				</div>
				<p><span itemprop="summary"><?=$arMessage["POST_MESSAGE_TEXT"]?></span></p>
			</li>
		</span>
		<?
		$i++;
	}
	if($i>1)
	{ ?>
		<li class="hidden">
			<a id="closeAllReview" class="design_links" href="#">Закрыть отзывы</a>
		</li><?
	}
	
	if(count($arResult["MESSAGES"])>2)
	{ ?>
		<li><a id="showAllReview" class="design_links" href="#">Все <?=count($arResult["MESSAGES"])?> <?=getEnd(count($arResult["MESSAGES"]), "отзыв")?></a></li><?
	}?>
	</ul>
</div>
<div class="clear"></div><?
}?>
