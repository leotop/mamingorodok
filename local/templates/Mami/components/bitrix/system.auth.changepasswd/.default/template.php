<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="auth_form_auth">
<?global $NO_BROAD;?>
<?
	if($NO_BROAD):
	$arCrumb=array(
		"0"=>array("URL"=>"/", "NAME"=>"Мамин городок"),
		"1"=>array("URL"=>"/personal/profile/", "NAME"=>"Мой профиль"),
		"2"=>array("URL"=>"/personal/profile/forgot-password/", "NAME"=>"Восстановление пароля"),
	);
	?>
	<div class="underline"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/bread_crumb.php', array('arCrumb'=>$arCrumb));?>
	</div>
<?endif;?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<?if(!empty($arParams["~AUTH_RESULT"])):?>
<script>
		$(".enter").click(function(){
			document.location = "/personal/auth/";
		});
</script>
<?endif;?>
<form method="post" class="jqtransform former" action="<?=$arResult["AUTH_FORM"]?>" name="bform" style="margin-left:10px;">
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
	<input type="hidden" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
	</div>
<div class="input-f">
<p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
<p><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></p>
<p>
</div>
<div class="input-f">
<a href="/personal/auth/"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p>
</div>

</form>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>