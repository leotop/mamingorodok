<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult["FORM_TYPE"] == "login"):?>

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

<form method="post" target="_top" class="jqtransform former" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	
	<label>Электронная почта</label>
	<div class="clear"></div>
	<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" />
	<div class="clear"></div>
	
	<label>Пароль</label>
	<div class="clear"></div>
	<input type="password" name="USER_PASSWORD" maxlength="50"/>
	<div class="clear"></div>		

<?if ($arResult["CAPTCHA_CODE"]):?>
	<label><?=GetMessage("AUTH_CAPTCHA_PROMT")?>:</label>
	<div class="clear"></div>
	<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
	<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
	<div class="clear"></div>
	<input type="text" name="captcha_word" maxlength="50" value="" />	
	<div class="clear"></div>
<?endif?>
	<div class="clear"></div>
			<div class="top15"></div>
			<input type="submit" name="Login" class="login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
			<div class="clear"></div>
<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
	<div class="input-f">
		<noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex>
		</div>
<?endif?>

<?if($arResult["AUTH_SERVICES"]):?>
		
				<label><?=GetMessage("socserv_as_user_form")?></label>
				<div class="clear"></div>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
	<div class="clear"></div>	
<?endif?>
	<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<div class="input-f">
			<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow">Восстановить пароль</a></noindex>
			</div>
<?endif?>
</form>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
		"POPUP"=>"Y",
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>" class="jqtransform former">
	<div class="top15"></div>
	Вы авторизовались, как 
	<?if(!empty($arResult["USER_NAME"])):?>
		<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_NAME"]?></a>.
	<?else:?>
		<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_LOGIN"]?></a>.
	<?endif?>
	
	<?foreach ($arResult["GET"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
	<input type="hidden" name="logout" value="yes" />
	<a href="#" class="exit" onClick='document.getElementById("logout").submit()'><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>
</form>
<?endif?>