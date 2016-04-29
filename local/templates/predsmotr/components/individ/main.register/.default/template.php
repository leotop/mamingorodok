<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<?if($USER->IsAuthorized()):?>
<div class="input-f">
	<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>
</div>
<?else:?>
<?
//print_R($arResult);
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>

<form method="POST" class="jqtransform former" action="/personal/registaration/" name="regform" enctype="multipart/form-data">
<input type='hidden' name='REGISTER[LOGIN]' value='' id='login'>
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>
<?//print_R()
$moreDiv = false;
$param = $arResult["SHOW_FIELDS"][0];
$arResult["SHOW_FIELDS"][0] = $arResult["SHOW_FIELDS"][3];
//print_R($arResult["SHOW_FIELDS"][0]);
unset($arResult["SHOW_FIELDS"][3]);
?>
<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
		<?if($FIELD=="PERSONAL_PHOTO"):?>
		<?$moreDiv = true;?>
		<div class="showMoreRegInfo"><a href="#" class="showMoreRegInfoLink">Показать все поля</a>
		<br>
		Вы можете заполнить все поля сразу или сделать это позже<br>при оформлении заказа или заполнении профиля
		</div>
		<div class="moreRegInfo">
		<?endif?>
		<label><?=GetMessage("REGISTER_FIELD_".$FIELD)?>:<?if ($arResult["REQUIRED_FIELDS_FLAGS"][$FIELD] == "Y"):?><span class="starrequired">*</span><?endif?></label>
		<div class="clear"></div>	
			<?
	switch ($FIELD)
	{
		case "PASSWORD":
		case "CONFIRM_PASSWORD":
			?><input size="30" type="password" name="REGISTER[<?=$FIELD?>]" /><?
		break;

		case "PERSONAL_GENDER":
			?>
			<div class="clear"></div>
			<table class="sex">
			<tr><td>
			<input type="radio" name="REGISTER[<?=$FIELD?>]" value="M" checked /><span class="pol">Мальчик</span>
			</td><td>
			<input type="radio" name="REGISTER[<?=$FIELD?>]" value="F" /><span class="pol">Девочка</span>
			</td></tr>
			</table>
			<?
		break;

		case "PERSONAL_COUNTRY":
		case "WORK_COUNTRY":
			?><select name="REGISTER[<?=$FIELD?>]"><?
			foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
			{
				?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
			<?
			}
			?></select><?
		break;

		case "PERSONAL_PHOTO":
		case "WORK_LOGO":
			?>
			
			<div class="input-f">
			<?=showIImage(SITE_TEMPLATE_PATH."/images/profile_img.png",157,157);?>	
			<table class="foto-form-personal">
			<tr><td>
			<label>Изменить фотографию</label>
			</td></tr>
			<tr><td>	
			
			<input type="text" id="file_input2" value="">
			<div class="filer"><input size="30" type="file" id="<?=$FIELD?>" name="REGISTER_FILES_<?=$FIELD?>" /></div>
			</td></tr>
			</table>
			</div>
			<div class="clear"></div>
			<?
		break;

		case "PERSONAL_NOTES":
		case "WORK_NOTES":
		case "PERSONAL_STREET":
			?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult["VALUES"][$FIELD]?></textarea><?
		break;
		default:
			if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
			?><input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" /><?
				if ($FIELD == "PERSONAL_BIRTHDAY")
					$APPLICATION->IncludeComponent(
						'bitrix:main.calendar',
						'',
						array(
							'SHOW_INPUT' => 'N',
							'FORM_NAME' => 'regform',
							'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
							'SHOW_TIME' => 'N'
						),
						null,
						array("HIDE_ICONS"=>"Y")
					);
				?><?
	}?><div class="clear"></div>
<?endforeach?>
<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<tr><td colspan="2"><?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></td></tr>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
	<tr><td><?=$arUserField["EDIT_FORM_LABEL"]?>:<?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?></td><td>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"],
				array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
	<?endforeach;?>
<?endif;?>
	<?if($moreDiv):?>
	</div>
	<?endif?>
<?// ******************** /User properties ***************************************************?>
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
		<tr>
			<td colspan="2"><b><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></b></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</td>
		</tr>
		<tr>
			<td><?=GetMessage("REGISTER_CAPTCHA_PROMT")?>:<span class="starrequired">*</span></td>
			<td><input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
	<?
}
/* !CAPTCHA */
?>
	<div class="input-f">
		<input type="submit" id="regBtnClick" name="register_submit_button2" value="<?=GetMessage("AUTH_REGISTER")?>" />
		<input type="hidden" name="register_submit_button" value="yes" />
	</div>
	<div class="input-f">
		<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
	</div>
</form>
<?endif?>