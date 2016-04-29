<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(isset($_POST["backurl"]) && $arResult['SHOW_ERRORS'] != 'Y' && !$arResult['ERROR'] && ($_GET['login']=='yes' || $_GET['logout'] == 'yes'))
	LocalRedirect($_POST["backurl"]);
?>

<?if($arResult["FORM_TYPE"] == "login"):?>
<a href="#auth" class="enter">Войти на сайт</a>
<div class="auth" id="frnd">
	<div class="white_plash">
	<div class="close"></div>
	<div class="cn tl"></div>
	<div class="cn tr"></div>
	<div class="content"><div class="content deborder"><div class="content"> <div class="clear"></div>
<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

<form method="post" target="_top" action="/personal/auth/?login=yes">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<?if($key!="TYPE" && $key!="AUTH_FORM" && $key!="change_pwd" && $key!="USER_CHECKWORD"):?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endif;?>
<?endforeach;?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<table width="95%" class="mainAuthTabl">
		<tr>
			<td colspan="2">
			<div class="top5"></div>
			<div class="bold">Электронная почта</div>
			<table cellSpacing="0" cellPadding="0" id="autTbl" border="0" width="100%">
				<tr>
					<td width="10px"><div class="authStart"></div></td>
					<td><div class="authInput"><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" /></div>
					<div class="clear"></div>
					</td>
					<td width="10px"><div class="authEnd"></div></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="bold top5">Пароль</div>
			<table cellSpacing="0" cellPadding="0" border="0" id="autTbl" width="100%">
				<tr>
					<td width="10px"><div class="authStart"></div></td>
					<td><div class="authInput"><input type="password" name="USER_PASSWORD" maxlength="50"/></div>
					<div class="clear"></div>
					</td>
					<td width="10px"><div class="authEnd"></div></td>
				</tr>
			</table>
			</td>
		</tr>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
		<tr>
			<td colspan="2">
			<div class="top5"></div>
			<noindex><a href="/personal/profile/forgot-password/" rel="nofollow">Восстановить пароль</a></noindex></td>
		</tr>
<?endif?>
        <tr>
            <td colspan="2">
            <noindex><a href="/personal/registaration/?backurl=<?=$arResult["BACKURL"]?>" rel="nofollow" class="reg"><?=GetMessage("AUTH_REGISTER")?></a></noindex></td>
        </tr>
<?if ($arResult["CAPTCHA_CODE"]):?>
		<tr>
			<td colspan="2">
			<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
			<input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
<?endif?>
		<tr>
			<td colspan="2">
			<div class="top15"></div>
			<input type="submit" name="Login" class="purple login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<div class="clear"></div>
			<div class="top15"></div>
			<span class="bold">Войти с помощью профиля</span> 
			<div class="soc">
			<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
		"POPUP"=>"N",
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
</div>
			</td>
		</tr>
	</table>
	<div class="top5"></div>
</form>


	</div></div></div>
	<div class="cn bl"></div>
	<div class="cn br"></div>
	</div>
	</div>
<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>" id="logout">
	
	
	<?
	global $USER;
	$rsUser = CUser::GetByID($USER->GetID());
	$arUser = $rsUser->Fetch();
		
		$name = "";
		if(!empty($arUser["NAME"])){
			$name = $arUser["NAME"];
		}
		
		if(!empty($arUser["LAST_NAME"])){
			if(!empty($name))
				$name .= " ".$arUser["LAST_NAME"];
			else
				$name = $arUser["LAST_NAME"];
		}
		
		if(!empty($arUser["SECOND_NAME"])){
			if(!empty($name))
				$name .= " ".$arUser["SECOND_NAME"];
			else
				$name = $arUser["SECOND_NAME"];
		}
		
		$arResult["USER_NAME"] = $name;
	?>
	<?if(!empty($arResult["USER_NAME"])):?>
		

		<!--a href="</?=$arResult["PROFILE_URL"]?>" title="</?=GetMessage("AUTH_PROFILE")?>"></?=$arResult["USER_NAME"]?></a-->
		<a href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_NAME"]?></a>
	<?else:?>
		<!--a href="</?=$arResult["PROFILE_URL"]?>" title="</?=GetMessage("AUTH_PROFILE")?>"></?=$arResult["USER_LOGIN"]?></a-->
		<a href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_LOGIN"]?></a>
	<?endif?>
	
	<?foreach ($arResult["GET"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
	<input type="hidden" name="logout" value="yes" />
	<a href="#" class="exit" onClick='document.getElementById("logout").submit()'><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>
</form>
<?endif?>