<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if ($arResult["NEED_AUTH"] == "Y")
{
	$APPLICATION->AuthForm("");
}
elseif (strlen($arResult["FatalError"])>0)
{
	?>
	<span class='errortext'><?=$arResult["FatalError"]?></span><br /><br />
	<?
}
else
{
	if(strlen($arResult["ErrorMessage"])>0)
	{
		?>
		<span class='errortext'><?=$arResult["ErrorMessage"]?></span><br /><br />
		<?
	}

	if ($arResult["ShowForm"] == "Input")
	{
		?>
		<div class="addFr">
		<form method="post" class="jqtransform" name="form1" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">
			<div class="notetext"><?= GetMessage("SONET_C35_T_PROMT") ?></div>
			
				<div class="clear"></div>
			<div><label><?= GetMessage("SONET_C35_T_USER") ?>:</label></div>
			<div class="clear"></div>
			<div>
						<b><?
						if ($arResult["CurrentUserPerms"]["Operations"]["viewprofile"])
							echo "<a href=\"".$arResult["Urls"]["User"]."\">";
						echo $arResult["User"]["NAME_FORMATTED"];
						if ($arResult["CurrentUserPerms"]["Operations"]["viewprofile"])
							echo "</a>";
						?></b>
			</div>
			<div class="clear"></div>
			<input type="hidden" name="SONET_USER_ID" value="<?= $arResult["User"]["ID"] ?>">
			<?=bitrix_sessid_post()?>
			<br />
			<input type="submit" name="save" value="<?= GetMessage("SONET_C35_T_SAVE") ?>">
			<input type="hidden" name="save" value="<?= GetMessage("SONET_C35_T_SAVE") ?>">
			<input type="reset" name="cancel" value="<?= GetMessage("SONET_C35_T_CANCEL") ?>" OnClick="window.location='<?= $arResult["Urls"]["User"] ?>'">
		</form>
		</div>
		<?
	}
	else
	{
		?>
		<div class="addFr">
		<div class="notetext"><?= GetMessage("SONET_C35_T_SUCESS") ?></div>
		<?if ($arResult["CurrentUserPerms"]["Operations"]["viewprofile"]):?>
			<a href="<?= $arResult["Urls"]["User"] ?>"><?= $arResult["User"]["NAME_FORMATTED"]; ?></a>
		<?endif;?>
		</div>
		<?
	}
}
?>