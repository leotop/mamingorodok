<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<form name="bform" class="jqtransform former" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">
	<div class="input-f">
	<p>
	<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
	</p>
	</div>
<?//=GetMessage("AUTH_GET_CHECK_STRING")?>
	<?/*<label><?=GetMessage("AUTH_LOGIN")?></label>
	<div class="clear"></div>
			<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
	<div class="text-f">
	&nbsp;&nbsp;&nbsp;<?=GetMessage("AUTH_OR")?>
	</div>
	<div class="clear"></div>*/?>
	<label>����������� �����</label>
	<div class="clear"></div>
			<input type="text" name="USER_EMAIL" maxlength="255" />
	<div class="clear"></div>
	<div class="input-f">
		<input type="submit" name="send_account_info" id="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
	</div>
<div class="input-f">
<p>
<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p> 
</div>
</form>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
