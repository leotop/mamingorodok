<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arResult['VOTE_AVAILABLE'] == 'Y')
{
	if ($arResult['USER_HAS_VOTED'] == 'N')
	{
		?>
			<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>" class="rating-vote">
				<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-result" class="rating-vote-result"><?if($arResult['TOTAL_VALUE']>0):?>+<?endif?><?=htmlspecialchars($arResult['TOTAL_VALUE'])?></span>
				<a id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-plus" class="rating-vote-plus"  onclick="RatingVoting('<?=CUtil::JSEscape(htmlspecialchars($arResult['ENTITY_TYPE_ID']))?>', '<?=CUtil::JSEscape(htmlspecialchars($arResult['ENTITY_ID']))?>',  '<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_RAND']))?>', 'plus');return false;" href="#plus"></a>
			</span> 
		<?
	}
	else
	{
		?>
			<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>" class="rating-vote rating-vote-disabled">
				<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-result" class="rating-vote-result"><?if($arResult['TOTAL_VALUE']>0):?>+<?endif?><?=htmlspecialchars($arResult['TOTAL_VALUE'])?></span>
				<span class="rating-vote-plus" onclick="showMassageErrorRating('<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>'); return false;"></span>
			</span> 
		<?
	}
} 
else
{
	if ($arResult['ALLOW_VOTE']['ERROR_TYPE'] == 'COUNT_VOTE') 
	{
		?>
			<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>" class="rating-vote rating-vote-disabled">
				<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-result" class="rating-vote-result"><?if($arResult['TOTAL_VALUE']>0):?>+<?endif?><?=htmlspecialchars($arResult['TOTAL_VALUE'])?></span>
				<span class="rating-vote-plus" onclick="showMassageErrorRating('<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>'); return false;"></span>
			</span> 
		<?
	}
	else
	{
		?>
			<span class="rating-vote">
				<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-result" class="rating-vote-result"><?if($arResult['TOTAL_VALUE']>0):?>+<?endif?><?=htmlspecialchars($arResult['TOTAL_VALUE'])?></span>
				<span class="rating-vote-plus" onclick="showMassageErrorRating('<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>'); return false;"></span>
			</span> 
		<?
	}
}
global $USER;
if($USER->IsAuthorized()){
echo '<div id="NoRatingMsg" class="CatPopUp NoRatingMsg'.CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID'])).'">
<div class="white_plash">
<div class="exitpUp"></div>
<div class="cn tl"></div>
<div class="cn tr"></div>
<div class="content">
<div class="content">
<div class="content">
<div class="clear"></div>
	Ваш голос уже учтен.
<div class="clear"></div>
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>';
}
else{
echo '<div id="NoRatingMsg" class="CatPopUp NoRatingMsg2 NoRatingMsg'.CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID'])).'">
<div class="white_plash">
<div class="exitpUp"></div>
<div class="cn tl"></div>
<div class="cn tr"></div>
<div class="content">
<div class="content">
<div class="content">
<div class="clear"></div>
	Для голосования вам необходимо <a href="/personal/registaration/">зарегистрироваться</a><br /> или <a href="/personal/auth/">войти на сайт</a>.
<div class="clear"></div>
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>';
}
?>