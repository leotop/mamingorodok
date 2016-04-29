<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<?if($arParams["POPUP"]):?>
<div style="display:none">
<div id="bx_auth_float" class="bx-auth-float">
<?endif?>

<?if($arParams["~CURRENT_SERVICE"] <> ''):?>
<script type="text/javascript">
BX.ready(function(){BxShowAuthService('<?=CUtil::JSEscape($arParams["~CURRENT_SERVICE"])?>', '<?=$arParams["~SUFFIX"]?>')});
</script>
<?endif?>

<div class="bx-auth">
	<form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">

		
<?foreach($arParams["~AUTH_SERVICES"] as $service):?>
			<?if($service["CLASS"] == "CSocServVKontakte"):?>
			<a href="javascript:void(0)" onclick="VK.Auth.login(BxVKAuthInfo);" class="bx-ss-button vkontakte-button"></a>
			<?else:?>
				пили шаблон
			<?endif?>
			<?//=$service["FORM_HTML"]?>
			<?//print_R($service);?>
<?endforeach?>
<?foreach($arParams["~POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
		<input type="hidden" name="auth_service_id" value="" />
	</form>
</div>

<?if($arParams["POPUP"]):?>
</div>
</div>
<?endif?>