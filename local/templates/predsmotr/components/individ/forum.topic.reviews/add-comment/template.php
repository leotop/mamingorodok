<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if ($arResult["SHOW_POST_FORM"] != "Y")
{
	echo ShowNote("Вы уже оставили отзыв о товаре.");
	return;
};

if (empty($arResult["ERROR_MESSAGE"]) && !empty($arResult["OK_MESSAGE"])) echo ShowNote($arResult["OK_MESSAGE"]);?>
<div class="headline">Ваш отзыв</div>
<div class="your_comment" id="comment">
	<div class="your_comment_headline" id="commentAddRating"> <b>Ваша оценка:</b>  <span class="active">отлично</span> <span>хорошо</span> <span>удовлетворительно</span></div>
	<form name="REPLIER<?=$arParams["form_index"]?>" id="REPLIER<?=$arParams["form_index"]?>" action="<?=POST_FORM_ACTION_URI?>#postform"<?
    ?> method="POST" enctype="multipart/form-data" onsubmit="return ValidateForm(this, '<?=$arParams["AJAX_TYPE"]?>');"<?
    ?> onkeydown="if(null != init_form){init_form(this)}" onmouseover="if(init_form){init_form(this)}" class="reviews-form">
		<input type="hidden" name="back_page" value="<?=$arResult["CURRENT_PAGE"]?>" />
		<input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
		<input type="hidden" name="SECTION_ID" value="<?=$arResult["ELEMENT"]["IBLOCK_SECTION_ID"]?>" />
		<input type="hidden" name="save_product_review" value="Y" />
		<input type="hidden" name="preview_comment" value="N" />
		<input type="hidden" id="rating-mark" name="rating" value="4" />
	<?=bitrix_sessid_post()?>
		<a name="review_anchor"></a><?
if (!empty($arResult["ERROR_MESSAGE"]))
{ ?>
		<div class="reviews-note-box reviews-note-error">
			<div class="reviews-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"], "reviews-note-error");?></div>
		</div><?
}

if (!$arResult["IS_AUTHORIZED"]):
?>
		<div class="reviews-reply-fields2">
			<div class="reviews-reply-field-user">
				<div class="reviews-reply-field reviews-reply-field-author"><label for="REVIEW_AUTHOR<?=$arParams["form_index"]?>"><?=GetMessage("OPINIONS_NAME")?><?
					?><span class="reviews-required-field">*</span></label>
					<span><input name="REVIEW_AUTHOR" id="REVIEW_AUTHOR<?=$arParams["form_index"]?>" size="30" type="text" value="" tabindex="<?=$tabIndex++;?>" /></span></div><?		
	if ($arResult["FORUM"]["ASK_GUEST_EMAIL"]=="Y")
	{ ?>
				<div class="reviews-reply-field-user-sep">&nbsp;</div>
				<div class="reviews-reply-field reviews-reply-field-email"><label for="REVIEW_EMAIL<?=$arParams["form_index"]?>"><?=GetMessage("OPINIONS_EMAIL")?></label>
					<span><input type="text" name="REVIEW_EMAIL" id="REVIEW_EMAIL<?=$arParams["form_index"]?>" size="30" value="<?=$arResult["REVIEW_EMAIL"]?>" tabindex="<?=$tabIndex++;?>" /></span></div><?
	}?>
				<div class="reviews-clear-float"></div>
			</div>
		</div><?
endif;
?>
		<input type="text" name="name" value="" class="nameclass" />
		<div class="input_1">
			<textarea cols="" rows="" name="REVIEW_TEXT" id="REVIEW_TEXT" tabindex="<?=$tabIndex++;?>"><?=$arResult["REVIEW_TEXT"];?></textarea>
		</div><?
if (strLen($arResult["CAPTCHA_CODE"]) > 0)
{
?>
		<div class="reviews-reply-field reviews-reply-field-captcha">
			<input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>"/>
			<div class="reviews-reply-field-captcha-label">
				<label for="captcha_word"><?=GetMessage("F_CAPTCHA_PROMT")?><span class="reviews-required-field">*</span></label>
				<input type="text" size="30" name="captcha_word" tabindex="<?=$tabIndex++;?>" autocomplete="off" />
			</div>
			<div class="reviews-reply-field-captcha-image">
				<img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CAPTCHA_CODE"]?>" alt="<?=GetMessage("F_CAPTCHA_TITLE")?>" />
			</div>
		</div><?
}?>
		<input type="submit" id="send" class="input_2" value="Добавить отзыв" /><?
if(false)
{?>
		<div class="input_info">За отзыв вы получите 1 балл.</div><?
}?>
	</form>
</div>
<div class="clear"></div>