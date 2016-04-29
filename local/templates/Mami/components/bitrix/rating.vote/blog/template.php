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
				<span class="rating-vote-plus" onclick="showMassageErrorRating(); return false;"></span>
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
				<span class="rating-vote-plus" onclick="showMassageErrorRating(); return false;"></span>
			</span> 
		<?
	}
	else
	{
		?>
			<span class="rating-vote">
				<span id="rating-vote-<?=CUtil::JSEscape(htmlspecialchars($arResult['VOTE_ID']))?>-result" class="rating-vote-result"><?if($arResult['TOTAL_VALUE']>0):?>+<?endif?><?=htmlspecialchars($arResult['TOTAL_VALUE'])?></span>
				<span class="rating-vote-plus" onclick="showMassageErrorRating(); return false;"></span>
			</span> 
		<?
	}
}
request_once("html.php");
?>