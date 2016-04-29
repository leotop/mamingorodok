<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<form method="post" class="jqtransform former" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
	<?if (strlen($arResult["BACKURL"]) > 0): ?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">
		<label><?=GetMessage("AUTH_LOGIN")?> * </label>
		<div class="clear"></div>
			<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
		<div class="clear"></div>
	
		<label><?=GetMessage("AUTH_CHECKWORD")?> * </label>
		<div class="clear"></div>
			<input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" />
		<div class="clear"></div>
	
		<label><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?> * </label>
		<div class="clear"></div>
			<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" />
		<div class="clear"></div>
	
		<label><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?> * </label>
		<div class="clear"></div>
			<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"  />
		<div class="clear"></div>
	<div class="input-f">
	<input type="submit" name="change_pwd" id="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
	</div>
<div class="input-f">
<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
<p>
</div>
<div class="input-f">
<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p>
</div>

</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>