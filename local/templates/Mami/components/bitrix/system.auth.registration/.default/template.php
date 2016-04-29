<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

ShowMessage($arParams["~AUTH_RESULT"]);
?>
<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
<p><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
<?endif?>
<noindex>
<form method="post" class="jqtransform former" action="<?=$arResult["AUTH_URL"]?>" name="bform">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="REGISTRATION" />
	
	<label><?=GetMessage("AUTH_LAST_NAME")?></label>
	<div class="clear"></div>
	<input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage("AUTH_NAME")?></label>
	<div class="clear"></div>
	<input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage("AUTH_LOGIN_MIN")?> <span class="starrequired">*</span></label>
	<div class="clear"></div>
	<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage("AUTH_PASSWORD_REQ")?> <span class="starrequired">*</span></label>
	<div class="clear"></div>
	<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
	<div class="clear"></div>
	
	<label><?=GetMessage("AUTH_CONFIRM")?> <span class="starrequired">*</span></label>
	<div class="clear"></div>
	<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" />
	<div class="clear"></div>
	
	<label>Ёлектронна€ почта: <span class="starrequired">*</span></label>
	<div class="clear"></div>
	<input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" />
	<div class="clear"></div>
	
<?// ********************* User properties ***************************************************?>
<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<label><?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></label>
	<div class="clear"></div>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
	<label><?=$arUserField["EDIT_FORM_LABEL"]?>: <?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?></label>
	<div class="clear"></div>
			<?$APPLICATION->IncludeComponent(
				"bitrix:system.field.edit",
				$arUserField["USER_TYPE"]["USER_TYPE_ID"],
				array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
	<div class="clear"></div>
	<?endforeach;?>
<?endif;?>
<?// ******************** /User properties ***************************************************

	/* CAPTCHA */
	if ($arResult["USE_CAPTCHA"] == "Y")
	{
		?>
		<label><?=GetMessage("CAPTCHA_REGF_TITLE")?></label>
		<div class="clear"></div>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		<div class="clear"></div>
		<label><?=GetMessage("CAPTCHA_REGF_PROMT")?>: <span class="starrequired">*</span></label>
		<div class="clear"></div>
		<input type="text" name="captcha_word" maxlength="50" value="" />
		<div class="clear"></div>
		<?
	}
	/* CAPTCHA */
	?>
	<div class="input-f">
	<input type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" /></td>
	</div>
	<div class="input-f">
		<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
	</div>
	<div class="input-f">
		<p><a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
	</div>

</form>
</noindex>
<script type="text/javascript">
document.bform.USER_NAME.focus();
</script>

<?endif?>