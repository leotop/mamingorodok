<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["MESSAGES"]))
{ ?>
<h2><?=$arResult["ELEMENT"]["PRODUCT"]["NAME"]?>: ������</h2>
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
		<li class="comment top15<?=($i>2?' hidden':'')?>" id="review<?=$arMessage["ID"]?>">
			<a name="message<?=$arMessage["ID"]?>"></a>
			<div class="headline_info"> <img src="/bitrix/templates/nmg/images/profile_img.png" width="40" class="photo" height="40" alt="" />
				<h6><a href="/community/user/<?=$arMessage["AUTHOR_ID"]?>/" title="<?=$strName?>"><?=$strName?></a></h6><?
		if(false)
		{?>
				<p><img src="/bitrix/templates/nmg/images/profile_img.png" width="16" height="16" alt="" /><span><a href="#" title="">����</a>, 1 ���</span><img src="/bitrix/templates/nmg/images/profile_img.png" width="16" height="16" alt="" /><span><a href="#" title="">����</a>, 1 ���</span></p><?
		}?>
				<div class="rating"> <?=showRating($arMessage["RATING"], false)?> <b><?=$arMessage["POST_DATE"]?></b> </div>
			</div>
			<p><?=$arMessage["POST_MESSAGE_TEXT"]?></p>
		</li><?
		$i++;
	}
	if($i>1)
	{ ?>
		<li class="hidden">
			<a id="closeAllReview" class="design_links" href="#">������� ������</a>
		</li><?
	}
	
	if(count($arResult["MESSAGES"])>2)
	{ ?>
		<li><a id="showAllReview" class="design_links" href="#">��� <?=count($arResult["MESSAGES"])?> <?=getEnd(count($arResult["MESSAGES"]), "�����")?></a></li><?
	}?>
	</ul>
</div>
<div class="clear"></div><?
}?>
