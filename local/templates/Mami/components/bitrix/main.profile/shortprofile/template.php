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
	<input type="hidden" name="EMAIL" id="mails" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" />

	<label><?=GetMessage('NEW_PASSWORD_REQ')?></label>
	<div class="clear"></div>
	<input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" />
	<div class="clear"></div>
	
	<label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
	<div class="clear"></div>
	<input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" />
	<div class="clear"></div>
	
	
	
	<div class="input-f">
	<input type="submit" name="save2" id="saveProfile" value="Сохранить пароль">&nbsp;&nbsp;<input type="reset" value="Отмена">
	<input type="hidden" name="save" value="Y">
	</div>
</form>