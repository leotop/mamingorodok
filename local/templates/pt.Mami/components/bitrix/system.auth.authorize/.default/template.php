<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<div>
<?if($arResult["AUTH_SERVICES"]):?>
	<div class="bx-auth-title"><?echo GetMessage("AUTH_TITLE")?></div>
<?endif?>

	<form name="form_auth" class="jqtransform former" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
	
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>

		<label><?=GetMessage("AUTH_LOGIN")?></label>
		<div class="clear"></div>
		<input class="bx-auth-input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
		<div class="clear"></div>
		
		<label><?=GetMessage("AUTH_PASSWORD")?></label>
		<div class="clear"></div>
		<input class="bx-auth-input" type="password" name="USER_PASSWORD" maxlength="255" />
		<div class="clear"></div>
		
		<?if($arResult["CAPTCHA_CODE"]):?>
		<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
		<label><?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:</label>
		<div class="clear"></div>
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		<input class="bx-auth-input" type="text" name="captcha_word" maxlength="50" value="" size="15" />
		<div class="clear"></div>
			<?endif;?>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<div class="top15"></div><input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><span class="saveAuth">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></span>
			<div class="clear"></div>
<?endif?>
		
		<div class="top15"></div>
		<input type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" /></td>
		<div class="clear"></div>

<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
		<div class="top10"></div>
		<noindex>
			<p>
				<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
			</p>
		</noindex>
		<div class="clear"></div>
<?endif?>

<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
		<div class="top10"></div>
		<noindex>
			<p>
				<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a><br />
				<?=GetMessage("AUTH_FIRST_ONE")?> 
			</p>
		</noindex>
		<div class="clear"></div>
<?endif?>

	</form>
</div>

<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>
