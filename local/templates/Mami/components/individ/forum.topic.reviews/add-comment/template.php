<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if ($arResult["SHOW_POST_FORM"] != "Y"):
	echo ShowNote("Вы уже оставили отзыв о товаре.");
	return;
endif;

if (empty($arResult["ERROR_MESSAGE"]) && !empty($arResult["OK_MESSAGE"])):
?> 
	<?=ShowNote($arResult["OK_MESSAGE"]);?>
<?
endif;

?>

<div id="comment" class="commentForm">
    <div class="leftTR"></div>
    <div class="leftBR"></div>
    <div class="rightTR"></div>
    <div class="rightBR"></div>
    <div class="info">
        <div class="fll">Ваша оценка:</div>
        <ul class="score">
            <li><a href="#">ужасно</a></li>
            <li><a href="#">плохо</a></li>
            <li><a href="#">удовлетворительно</a></li>
            <li><a href="#">хорошо</a></li>
            <li><a href="#" class="selected">отлично</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="top15"></div>

<form name="REPLIER<?=$arParams["form_index"]?>" id="REPLIER<?=$arParams["form_index"]?>" action="<?=POST_FORM_ACTION_URI?>#postform"<?
    ?> method="POST" enctype="multipart/form-data" onsubmit="return ValidateForm(this, '<?=$arParams["AJAX_TYPE"]?>');"<?
    ?> onkeydown="if(null != init_form){init_form(this)}" onmouseover="if(init_form){init_form(this)}" class="reviews-form">


<a name="review_anchor"></a>
<?
if (!empty($arResult["ERROR_MESSAGE"])): 
?>
<div class="reviews-note-box reviews-note-error">
	<div class="reviews-note-box-text"><?=ShowError($arResult["ERROR_MESSAGE"], "reviews-note-error");?></div>
</div>
<?
endif;
?>

	<input type="hidden" name="back_page" value="<?=$arResult["CURRENT_PAGE"]?>" />
	<input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
	<input type="hidden" name="SECTION_ID" value="<?=$arResult["ELEMENT"]["IBLOCK_SECTION_ID"]?>" />
	<input type="hidden" name="save_product_review" value="Y" />
	<input type="hidden" name="preview_comment" value="N" />
	<?=bitrix_sessid_post()?>
<?
/* GUEST PANEL */
if (!$arResult["IS_AUTHORIZED"]):
?>
	<div class="reviews-reply-fields2">
		<div class="reviews-reply-field-user">
			<div class="reviews-reply-field reviews-reply-field-author"><label for="REVIEW_AUTHOR<?=$arParams["form_index"]?>"><?=GetMessage("OPINIONS_NAME")?><?
				?><span class="reviews-required-field">*</span></label>
				<span><input name="REVIEW_AUTHOR" id="REVIEW_AUTHOR<?=$arParams["form_index"]?>" size="30" type="text" value="" tabindex="<?=$tabIndex++;?>" /></span></div>
<?		
	if ($arResult["FORUM"]["ASK_GUEST_EMAIL"]=="Y"):
?>
			<div class="reviews-reply-field-user-sep">&nbsp;</div>
			<div class="reviews-reply-field reviews-reply-field-email"><label for="REVIEW_EMAIL<?=$arParams["form_index"]?>"><?=GetMessage("OPINIONS_EMAIL")?></label>
				<span><input type="text" name="REVIEW_EMAIL" id="REVIEW_EMAIL<?=$arParams["form_index"]?>" size="30" value="<?=$arResult["REVIEW_EMAIL"]?>" tabindex="<?=$tabIndex++;?>" /></span></div>
<?
	endif;
?>
			<div class="reviews-clear-float"></div>
		</div>
	</div>
<?
endif;
?>

		
		<div class="reviews-reply-field reviews-reply-field-text">
			<textarea class="post_message" cols="55" rows="14" name="REVIEW_TEXT" id="REVIEW_TEXT" tabindex="<?=$tabIndex++;?>"><?=$arResult["REVIEW_TEXT"];?></textarea>
		</div>
		
<?

/* CAPTHCA */
if (strLen($arResult["CAPTCHA_CODE"]) > 0):
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
		</div>
<?
endif;
/* ATTACH FILES */
if ($arResult["SHOW_PANEL_ATTACH_IMG"] == "Y"):
?>
		<div class="reviews-reply-field reviews-reply-field-upload">
<?
$iCount = 0;
if (!empty($arResult["REVIEW_FILES"])):
	foreach ($arResult["REVIEW_FILES"] as $key => $val):
	$iCount++;
	$iFileSize = intVal($val["FILE_SIZE"]);
	$size = array(
		"B" => $iFileSize, 
		"KB" => round($iFileSize/1024, 2), 
		"MB" => round($iFileSize/1048576, 2));
	$sFileSize = $size["KB"].GetMessage("F_KB");
	if ($size["KB"] < 1)
		$sFileSize = $size["B"].GetMessage("F_B");
	elseif ($size["MB"] >= 1 )
		$sFileSize = $size["MB"].GetMessage("F_MB");
?>
			<div class="reviews-uploaded-file">
				<input type="hidden" name="FILES[<?=$key?>]" value="<?=$key?>" />
				<input type="checkbox" name="FILES_TO_UPLOAD[<?=$key?>]" id="FILES_TO_UPLOAD_<?=$key?>" value="<?=$key?>" checked="checked" />
				<label for="FILES_TO_UPLOAD_<?=$key?>"><?=$val["ORIGINAL_NAME"]?> (<?=$val["CONTENT_TYPE"]?>) <?=$sFileSize?>
					( <a href="/bitrix/components/bitrix/forum.interface/show_file.php?action=download&amp;fid=<?=$key?>"><?=GetMessage("F_DOWNLOAD")?></a> )
				</label>
			</div>
<?
	endforeach;
endif;

if ($iCount < $arParams["FILES_COUNT"]):
$iFileSize = intVal(COption::GetOptionString("forum", "file_max_size", 50000));
$size = array(
	"B" => $iFileSize, 
	"KB" => round($iFileSize/1024, 2), 
	"MB" => round($iFileSize/1048576, 2));
$sFileSize = $size["KB"].GetMessage("F_KB");
if ($size["KB"] < 1)
	$sFileSize = $size["B"].GetMessage("F_B");
elseif ($size["MB"] >= 1 )
	$sFileSize = $size["MB"].GetMessage("F_MB");
?>
			<div class="reviews-upload-info" style="display:none;" id="upload_files_info_<?=$arParams["form_index"]?>">
<?
if ($arParams["FORUM"]["ALLOW_UPLOAD"] == "F"):
?>
				<span><?=str_replace("#EXTENSION#", $arParams["FORUM"]["ALLOW_UPLOAD_EXT"], GetMessage("F_FILE_EXTENSION"))?></span>
<?
endif;
?>
				<span><?=str_replace("#SIZE#", $sFileSize, GetMessage("F_FILE_SIZE"))?></span>
			</div>
<?
			
	for ($ii = $iCount; $ii < $arParams["FILES_COUNT"]; $ii++):
?>

			<div class="reviews-upload-file" style="display:none;" id="upload_files_<?=$ii?>_<?=$arParams["form_index"]?>">
				<input name="FILE_NEW_<?=$ii?>" type="file" value="" size="30" />
			</div>
<?
	endfor;
?>
			<a href="javascript:void(0);" onclick="AttachFile('<?=$iCount?>', '<?=($ii - $iCount)?>', '<?=$arParams["form_index"]?>', this); return false;">
				<span><?=($arResult["FORUM"]["ALLOW_UPLOAD"]=="Y") ? GetMessage("F_LOAD_IMAGE") : GetMessage("F_LOAD_FILE") ?></span>
			</a>
<?
endif;
?>
		</div>
<?
endif;
?>
<?

?>
    <input id="send" class="purple fll" name="send_button" type="submit" value="Добавить отзыв" tabindex="<?=$tabIndex++;?>" <?
        ?>onclick="this.form.preview_comment.value = 'N';" />
    <input type="hidden" id="rating-mark" name="rating" value="4" />
  <!--  <div class="pd15">За отзыв вы получите 1 балл.</div>-->
    <div class="clear"></div>
</div>
</form>
    
<script type="text/javascript">
function AttachFile(iNumber, iCount, sIndex, oObj)
{
	var element = null;
	var bFined = false;
	iNumber = parseInt(iNumber);
	iCount = parseInt(iCount);
	
	document.getElementById('upload_files_info_' + sIndex).style.display = 'block';
	for (var ii = iNumber; ii < (iNumber + iCount); ii++)
	{
		element = document.getElementById('upload_files_' + ii + '_' + sIndex);
		if (!element || typeof(element) == null)
			break;
		if (element.style.display == 'none')
		{
			bFined = true;
			element.style.display = 'block';
			break;
		}
	}
	var bHide = (!bFined ? true : (ii >= (iNumber + iCount - 1)));
	if (bHide == true)
		oObj.style.display = 'none';
}

if (typeof oErrors != "object")
	var oErrors = {};
oErrors['no_topic_name'] = "<?=CUtil::addslashes(GetMessage("JERROR_NO_TOPIC_NAME"))?>";
oErrors['no_message'] = "<?=CUtil::addslashes(GetMessage("JERROR_NO_MESSAGE"))?>";
oErrors['max_len'] = "<?=CUtil::addslashes(GetMessage("JERROR_MAX_LEN"))?>";
oErrors['no_url'] = "<?=CUtil::addslashes(GetMessage("FORUM_ERROR_NO_URL"))?>";
oErrors['no_title'] = "<?=CUtil::addslashes(GetMessage("FORUM_ERROR_NO_TITLE"))?>";
oErrors['no_path'] = "<?=CUtil::addslashes(GetMessage("FORUM_ERROR_NO_PATH_TO_VIDEO"))?>";
if (typeof oText != "object")
	var oText = {};
oText['author'] = " <?=CUtil::addslashes(GetMessage("JQOUTE_AUTHOR_WRITES"))?>:\n";
oText['enter_url'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_URL"))?>";
oText['enter_url_name'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_URL_NAME"))?>";
oText['enter_image'] = "<?=CUtil::addslashes(GetMessage("FORUM_TEXT_ENTER_IMAGE"))?>";
oText['list_prompt'] = "<?=CUtil::addslashes(GetMessage("FORUM_LIST_PROMPT"))?>";
oText['video'] = "<?=CUtil::addslashes(GetMessage("FORUM_VIDEO"))?>";
oText['path'] = "<?=CUtil::addslashes(GetMessage("FORUM_PATH"))?>:";
oText['preview'] = "<?=CUtil::addslashes(GetMessage("FORUM_PREVIEW"))?>:";
oText['width'] = "<?=CUtil::addslashes(GetMessage("FORUM_WIDTH"))?>:";
oText['height'] = "<?=CUtil::addslashes(GetMessage("FORUM_HEIGHT"))?>:";

oText['BUTTON_OK'] = "<?=CUtil::addslashes(GetMessage("FORUM_BUTTON_OK"))?>";
oText['BUTTON_CANCEL'] = "<?=CUtil::addslashes(GetMessage("FORUM_BUTTON_CANCEL"))?>";
oText['smile_hide'] = "<?=CUtil::addslashes(GetMessage("F_HIDE_SMILE"))?>";

if (typeof oHelp != "object")
	var oHelp = {};

function reply2author(name)
{
	<?if ($arResult["FORUM"]["ALLOW_BIU"] == "Y"):?>
	document.REPLIER.REVIEW_TEXT.value += "[B]"+name+"[/B] \n";
	<?else:?>
	document.REPLIER.REVIEW_TEXT.value += name+" \n";
	<?endif;?>
	return false;
}
</script>