<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?=ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<script type="text/javascript">
<!--
var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
//-->

var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>
<form method="post" name="form1" class="jqtransform former" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
<?=$arResult["BX_SESSION_CHECK"]?>
<input type="hidden" name="lang" value="<?=LANG?>" />
<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
	
	<input type="hidden" name="LOGIN" id="logins" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
	
	<div class="input-f">
	<?
	if (strlen($arResult["arUser"]["PERSONAL_PHOTO"])>0)
	{
	?>
	<?
		$rsFile = CFile::GetPath($arResult["arUser"]["PERSONAL_PHOTO"]);
	?>
		<div class="personal_photo">
		<img src="<?=$rsFile?>" alt="<?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?>" title="<?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?>" height="157px">
		</div>
	<?
	}
	else
	{
	?>
	<?=ShowImage(SITE_TEMPLATE_PATH."/images/profile_img.png",157,157);?>		
	<?
	}
	?>
	<table class="foto-form-personal">
	<tr><td>
	<label>Изменить фотографию</label>
	</td></tr>
	<tr><td>	
	<input type="text" id="file_input" value="">
	<div class="filer">
	<?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
	</div>
	</td></tr>
	</table>
	</div>
	<div class="clear"></div>
	
	<label><?=GetMessage('LAST_NAME')?></label>
	<div class="clear"></div>
	<input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage('NAME')?></label>
	<div class="clear"></div>
	<input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage('SECOND_NAME')?></label>
	<div class="clear"></div>
	<input type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
	<div class="clear"></div>
    
	<label>Пол</label>
	<div class="clear"></div>
	<table class="sex">
	<tr><td>
	<input type="radio" name="PERSONAL_GENDER" value="M" <?if($arResult["arUser"]["PERSONAL_GENDER"]=='M'):?>checked<?endif?> /><span class="pol">Мальчик</span>
	</td><td>
	<input type="radio" name="PERSONAL_GENDER" value="F" <?if($arResult["arUser"]["PERSONAL_GENDER"]=='F'):?>checked<?endif?> /><span class="pol">Девочка</span>
	</td></tr>
	</table>
	<div class="clear"></div>
	
	<label><?=GetMessage("USER_BIRTHDAY_DT")?> (<?=$arResult["DATE_FORMAT"]?>)</label>
	<div class="clear"></div>
	<?
	$APPLICATION->IncludeComponent(
		'bitrix:main.calendar',
		'',
		array(
			'SHOW_INPUT' => 'Y',
			'FORM_NAME' => 'form1',
			'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
			'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
			'SHOW_TIME' => 'N'
		),
		null,
		array('HIDE_ICONS' => 'Y')
	);
	?>
	<div class="clear"></div>
	
	<label>Электронная почта</label>
	<div class="clear"></div>
	<input type="text" name="EMAIL" id="mails" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage('USER_COUNTRY')?></label>
	<div class="clear"></div>
	<?=$arResult["COUNTRY_SELECT"]?>
	<div class="clear"></div>
	
	<label><?=GetMessage('USER_CITY')?></label>
	<div class="clear"></div>
	<input type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage('USER_ZIP')?></label>
	<div class="clear"></div>
	<input type="text" name="PERSONAL_ZIP" class="zip" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>" /> <div class="info-zip">Свой индекс можно узнать в <a href="#" class="greydot">справочнике</a></div>
	<div class="clear"></div>
	
	<label><?=GetMessage("USER_STREET")?></label>
	<div class="clear"></div>
	<textarea cols="30" rows="5" name="PERSONAL_STREET"><?=$arResult["arUser"]["PERSONAL_STREET"]?></textarea>
	<div class="clear"></div>
	Например, ул.Первомайская, д. 14 кв. 12
	<div class="clear"></div>
	
	<label>Контактный телефон</label>
	<div class="clear"></div>
	<input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
	<div class="clear"></div>
	
	<label>О себе</label>
	<div class="clear"></div>
	<textarea cols="30" rows="5" name="PERSONAL_NOTES"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></textarea>
	<div class="clear"></div>
	
	<div class="input-f">
	<input type="submit" name="save2" id="saveProfile" value="<?=(($arResult["ID"]>0) ? "Сохранить изменения" : GetMessage("MAIN_ADD"))?>">&nbsp;&nbsp;<input type="reset" value="Отмена">
	<input type="hidden" name="save" value="Y">
	</div>
</form>