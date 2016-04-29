<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb"=>3), array("MODE"=>"html") );?>
<?echo ShowError($arResult["ERROR_MESSAGE"]); ?>
<?
function PrintPropsForm($arSource=Array(), $PRINT_TITLE = "", $arParams)
{
	?><div class="Form"><?
	if (!empty($arSource))
	{ 
		?>	
		<?
		foreach($arSource as $arProperties)
		{
			if($arProperties["SHOW_GROUP_NAME"] == "Y")
			{ 
				?>
				
						<h2 class="h2head"><?= $arProperties["GROUP_NAME"] ?></h2>
					
				<?
			}
			?>
			
					<?
					//print_R($arProperties);
					if($arProperties["REQUIED_FORMATED"]=="Y")
					{
						?><div class="red bold"><?= $arProperties["NAME"] ?></div><?
					}
					else{
					?>
					<div class="bold"><?= $arProperties["NAME"] ?></div>
					<?
					}
					?>
				
					<?
					if($arProperties["TYPE"] == "CHECKBOX")
					{
						?>
						<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
						<?
					}
					elseif($arProperties["TYPE"] == "TEXT")
					{
						?>
						<?if($arProperties["ID"]==1){
							$zn = explode(" ",$arProperties["VALUE"]);
							if(isset($zn[1]))
								$arProperties["VALUE"] = $zn[1];
						}?>
						<?if($arProperties["ID"]==2){
							$zn = explode(" ",$arProperties["VALUE"]);
							if(isset($zn[1]))
								$arProperties["VALUE"] = $zn[1];
							else
								$arProperties["VALUE"] = "";
						}?>
						<input type="text" maxlength="250" class="filter" id="filter_<?=$arProperties["ID"]?>" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>">
						<div class="red error error_<?=$arProperties["ID"]?>"></div>
						<?
						if($arProperties["ID"]==3){
						?>	
							<div class="clear"></div>
							<div class="inf">Например: 8 950 2233</div>
						<?
						}
					}
					elseif($arProperties["TYPE"] == "SELECT")
					{
						?>
						<select name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "MULTISELECT")
					{
						?>
						<select multiple name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "TEXTAREA")
					{
						//print_r();
						?>
						<textarea class="filter" id="filter_<?=$arProperties["ID"]?>" rows="<?=$arProperties["SIZE2"]?>" cols="70" name="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
						<div class="red error error2 error_<?=$arProperties["ID"]?>"></div>
						<?
						if($arProperties["ID"]==6){
						?>
							<div class="clear"></div>
							<div class="inf">подъезд, код, домофон и т.д.</div>
						<?
						}
					}
					elseif ($arProperties["TYPE"] == "LOCATION")
					{
						$value = 0;
						foreach ($arProperties["VARIANTS"] as $arVariant) 
						{
							if ($arVariant["SELECTED"] == "Y") 
							{
								$value = $arVariant["ID"]; 
								break;
							}
						}
						
						if ($arParams["USE_AJAX_LOCATIONS"] == "Y"):
							$GLOBALS["APPLICATION"]->IncludeComponent(
								'individ:sale.ajax.locations', 
								'', 
								array(
									"AJAX_CALL" => "N", 
									"COUNTRY_INPUT_NAME" => "COUNTRY_".$arProperties["FIELD_NAME"],
									"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
									"CITY_OUT_LOCATION" => "Y",
									"COUNTRY"=>19,
									"ALLOW_EMPTY_CITY" => $arParams["ALLOW_EMPTY_CITY"],
									"LOCATION_VALUE" => $value,
								),
								null,
								array('HIDE_ICONS' => 'Y')
							);
						else:
						?>
						<select name="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["ID"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
						endif;
					}
					elseif ($arProperties["TYPE"] == "RADIO")
					{
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["ID"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>> <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["ID"]?>"><?=$arVariants["NAME"]?></label><br />
							<?
						}
					}

					if (strlen($arProperties["DESCRIPTION"]) > 0)
					{
						?><br /><small><?echo $arProperties["DESCRIPTION"] ?></small><?
					}
					?>
					
			<div class="clear"></div>
			<?
		}
		?>
		</div>
		<?
		return true;
	}
	return false;
}
?>
<br />
<script language="JavaScript">
							function SetContact(enabled)
							{
								if(enabled)
									document.getElementById('loadhide').style.display="block";
								else
									document.getElementById('loadhide').style.display="none";
							}
							</script>
<table border="0" class="profiler" cellspacing="0" cellpadding="5" width="100%">
	<tr class="head">
		<th colspan="2">ФИО</th>
		<th>Местоположение</th>
		<th>Адрес</th>
	</tr>
	<?$checekd = false;?>
	
	<?foreach($arResult["USER_PROFILES"] as $arUserProfiles)
		{?>
		<tr <?if ($arUserProfiles["CHECKED"]=="Y"):?>class="select"<?endif?>>
		<td class="first"><input type="radio" class="prof" name="PROFILE_ID" id="ID_PROFILE_ID_<?= $arUserProfiles["ID"] ?>" value="<?= $arUserProfiles["ID"];?>"<?if ($arUserProfiles["CHECKED"]=="Y") {$checekd=true; echo " checked";}?> onClick="SetContact(false)">
		</td>
		<td>
			<?=$arUserProfiles["USER_PROPS_VALUES"][0]["VALUE"]?> <?=$arUserProfiles["USER_PROPS_VALUES"][1]["VALUE"]?>
		</td>
		<td><?=$arUserProfiles["USER_PROPS_VALUES"][3]["VALUE_FORMATED"]?></td>
		<td><?=$arUserProfiles["USER_PROPS_VALUES"][4]["VALUE_FORMATED"]?></td>
		</tr>
	<?	}?>
	<tr>
		<td class="first">
			<input type="radio" name="PROFILE_ID" class="prof" id="ID_PROFILE_ID_0" value="0"<?if ($checekd==false) echo " checked";?> onClick="SetContact(true)">
		</td>
		<td colspan="3">
		Создать новый профиль доставки
		</td>
	</tr>
</table>			
			<div id="loadhide">
			<?
			PrintPropsForm($arResult["PRINT_PROPS_FORM"]["USER_PROPS_Y"], GetMessage("SALE_NEW_PROFILE_TITLE"), $arParams);
			?>
			</div>
			<?
			if ($arResult["USER_PROFILES_TO_FILL"]=="Y")
			{
				?>
				<script language="JavaScript">
					$(document).ready(function() {
						setTimeout('SetContact(<?echo ($checekd==false)?"true":"false";?>)',150);
					});
				</script>
				<?
			}
			?>		
		
			<input type="submit" name="contButton"  class="btnSend" value="Продолжить">