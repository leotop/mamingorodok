<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if(isset($_POST["backurl"]) && $arResult['SHOW_ERRORS'] != 'Y' && !$arResult['ERROR'] && ($_GET['login']=='yes' || $_GET['logout'] == 'yes'))
	LocalRedirect($_POST["backurl"]);
?>

<?if($arResult["FORM_TYPE"] == "login"):?>
<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>
<span><i title="#" class="aEnter">Войти / Регистрация</i></span>
	<div class="enter_popap">
		<form id="frmLogin" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>"><?///personal/auth/?login=yes?>
			<?if($arResult["BACKURL"] <> ''):?>
				<input type="hidden" name="backurl" value="<?=$_SERVER["REQUEST_URI"]?>" />
			<?endif?>
			<?foreach ($arResult["POST"] as $key => $value):?>
				<?if($key!="TYPE" && $key!="AUTH_FORM" && $key!="change_pwd" && $key!="USER_CHECKWORD"):?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?endif;?>
			<?endforeach;?>
			<input type="hidden" name="AUTH_FORM" value="Y" />
			<input type="hidden" name="TYPE" value="AUTH" />
		<ul>
			<li>Электронная почта</li>
			<li><input type="text" name="USER_LOGIN" class="input1" value="<?=$arResult["USER_LOGIN"]?>" /></li>
			<li>Пароль</li>
			<li><input name="USER_PASSWORD" type="password" class="input1" value="" /></li>
            <li><input onclick="$('#frmLogin').submit();" type="submit" class="input2" name="logoutButton" value="Войти" /></li>
            <li><a onclick="document.location.href='/personal/registaration/?backurl=<?=$arResult["BACKURL"]?>';" class="input2" href="/personal/registaration/?backurl=<?=$arResult["BACKURL"]?>" title="Регистрация">Регистрация</a></li>
			<li><a onclick="document.location.href='/personal/profile/forgot-password/';" class="input1" href="/personal/profile/forgot-password/" title="Восстановить пароль">Восстановить пароль</a></li>
			</ul></form><ul>
			<li class="last"><span class="soc-auth-title-c">Войти с помощью профиля</span><?
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
?></li>
		</ul>
		<a class="close1" href="#" title=""></a>
	</div><?
//if($arResult["FORM_TYPE"] == "login")
else:
?>
<form action="<?=$_SERVER["REQUEST_URI"]?>" id="logout">
	<input type="hidden" name="logout" value="yes" /><?
	foreach ($arResult["GET"] as $key => $value):
		?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?
	endforeach;
	?><span><?
	$arResult["USER_NAME"] = $USER->GetFullName();
	if(strlen($arResult["USER_NAME"])>0)
	{
		?><a onclick="document.location.href='/community/profile/';" href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_NAME"]?></a><?
	} else {
		?><a onclick="document.location.href='/community/profile/';" href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_LOGIN"]?></a><?
	}
	?>	<a href="#" class="exit" onClick='document.getElementById("logout").submit()'><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a></span>
</form>
<?endif?>