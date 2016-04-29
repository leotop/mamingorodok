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
		<div class="notetext"><?= GetMessage("SONET_C34_T_PROMT") ?></div>
		<form method="post" name="form1" class="jqtransform" action="<?=POST_FORM_ACTION_URI?>" enctype="multipart/form-data">
			<div class="clear"></div>
			<div><label><?= GetMessage("SONET_C34_T_USER") ?>:</label></div>
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
			<div><label><?= GetMessage("SONET_C34_T_MESSAGE") ?><span class="required-field">*</span>:</label></div>
			<div class="clear"></div>			
			<?
				$rsUser = CUser::GetByID($USER->GetID());
				$arUser = $rsUser->Fetch();

				$name = "";
				if(!empty($arUser["NAME"]))
					$name = $arUser["NAME"];
					
				if(!empty($arUser["LAST_NAME"]))
					if(!empty($name))
						$name .= " ".$arUser["LAST_NAME"];
					else
						$name = $arUser["LAST_NAME"];
				
				if(empty($name))
					$name = $arUser["LOGIN"];
				?>
			<div><textarea name="MESSAGE" style="width:540px" rows="5"><?if(!empty($_POST["MESSAGE"])):?><?= htmlspecialcharsex($_POST["MESSAGE"]); ?><?else:?>Привет! Добавь меня в свой список друзей! <?=$name?>
			<?endif;?></textarea></div>
			<div class="clear"></div>
			<input type="hidden" name="SONET_USER_ID" value="<?= $arResult["User"]["ID"] ?>">
			<?=bitrix_sessid_post()?>
			<br />
			<input type="submit" name="save" value="<?= GetMessage("SONET_C34_T_SAVE") ?>">
			<input type="hidden" name="save" value="<?= GetMessage("SONET_C34_T_SAVE") ?>">
		</form>
		</div>
		<?
	}
	else
	{
		?>
		<div class="addFr">
		<div class="notetext"><?= GetMessage("SONET_C34_T_SUCCESS") ?></div>
		<?if ($arResult["CurrentUserPerms"]["Operations"]["viewprofile"]):?>
			<a href="<?= $arResult["Urls"]["User"] ?>"><?= $arResult["User"]["NAME_FORMATTED"]; ?></a>
		<?endif;?>
		</div>
		<?
	}
}
?>