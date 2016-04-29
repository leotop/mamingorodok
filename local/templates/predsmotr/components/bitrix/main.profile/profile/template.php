<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?= ShowError($arResult["strProfileError"]); ?>
<?
function getPropertyHtml($arData) {
	if(empty($arData["TYPE"])) $arData["TYPE"] = 'text';

	$strTmp = '
	<div class="citem">
		<span>'.$arData["NAME"].'</span>'.(empty($arData["DESCRIPTION"])?'':'<p>'.$arData["DESCRIPTION"].'</p>');

	if($arData["TYPE"] == 'text')
		$strTmp .= '<input id="'.$arData["CNAME"].'" name="'.$arData["CNAME"].'" value="'.$arData["VALUE"].'" type="text">';
	elseif($arData["TYPE"] == 'textarea')
		$strTmp .= '<textarea name="'.$arData["CNAME"].'">'.$arData["VALUE"].'</textarea>';
	elseif($arData["TYPE"] == 'password')
		$strTmp .= '<input id="'.$arData["CNAME"].'" name="'.$arData["CNAME"].'" value="'.$arData["VALUE"].'" type="password">';

	$strTmp .= '</div>';

	return $strTmp;
}

if($arResult['DATA_SAVED'] == 'Y') echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<script type="text/javascript">
	<!--
	var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "reg";
	echo "'reg'";
}
?>];
	//-->

	var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>
<form method="post" name="form1" id="frmPersonal" class="jqtransform former" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
	<?= $arResult["BX_SESSION_CHECK"] ?>
	<input type="hidden" name="lang" value="<?= LANG ?>" />
	<input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />
	<input type="hidden" name="hash" value=<?= cSKTools::getHash(intval($arResult["ID"])) ?> />
	<input type="hidden" name="LOGIN" id="logins" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"] ?>" />
	<div class="cleft">
		<div class="citem">
			<span>Ваш аватар</span><br /><?
			if($arResult["arUser"]["PERSONAL_PHOTO"] > 0)
				$strImage = CFile::GetFileArray($arResult["arUser"]["PERSONAL_PHOTO"]);
			else $strImage = SITE_TEMPLATE_PATH."/images/profile_img.png";
			?>
			<img src="<?= $strImage ?>" alt="<?= $arResult["arUser"]["NAME"] ?> <?= $arResult["arUser"]["LAST_NAME"] ?>" title="<?= $arResult["arUser"]["NAME"] ?> <?= $arResult["arUser"]["LAST_NAME"] ?>"><?
		?>
			<div class="clear"></div><br />
			<div class="file">
				<input type="text" id="file_input" value="">

				<div class="filer">
					<?= $arResult["arUser"]["PERSONAL_PHOTO_INPUT"] ?>
				</div>
			</div>
		</div>
	</div>
	<div class="cright"><?
		$arData = array(
			"NAME" => "Электронная почта",
			"CNAME" => "EMAIL",
			"VALUE" => $arResult["arUser"]["EMAIL"]
		);
		echo getPropertyHtml($arData);

		if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '') {
			$arData = array(
				"NAME" => "Смена пароля",
				"CNAME" => "NEW_PASSWORD",
				"DESCRIPTION" => 'Для смены текущего пароля введите новый',
			   "TYPE" => "password"
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "",
				"CNAME" => "NEW_PASSWORD_CONFIRM",
				"DESCRIPTION" => "Введите новый пароль еще раз",
			   "TYPE" => 'password'
			);
			echo getPropertyHtml($arData);
		}

		?>

	</div>
	<div class="clear"></div>
	<div class="liner"></div>
	<div class="cleft">
		<?
		$arData = array("NAME" => "Фамилия", "CNAME" => "LAST_NAME", "VALUE" => $arResult["arUser"]["LAST_NAME"]);
		echo getPropertyHtml($arData);

		$arData = array("NAME" => "Имя", "CNAME" => "NAME", "VALUE" => $arResult["arUser"]["NAME"]);
		echo getPropertyHtml($arData);

		$arData = array("NAME" => "Отчество", "CNAME" => "SECOND_NAME", "VALUE" => $arResult["arUser"]["SECOND_NAME"]);
		echo getPropertyHtml($arData);
		?>
	</div>
	<div class="cright">
		<div class="citem">
			<span>Пол</span><br>
			<table class="sex">
				<tr>
					<td>
						<input type="radio" name="PERSONAL_GENDER" value="M" <? if ($arResult["arUser"]["PERSONAL_GENDER"] == 'M'): ?>checked<? endif ?> /><span class="pol">Мужской</span>
					</td>
					<td>
						<input type="radio" name="PERSONAL_GENDER" value="F" <? if ($arResult["arUser"]["PERSONAL_GENDER"] == 'F'): ?>checked<? endif ?> /><span class="pol">Женский</span>
					</td>
				</tr>
			</table>
		</div>
		<div class="citem ccalendar">
			<span>День рождения</span><br />
			<?$APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
				'SHOW_INPUT' => 'Y',
				'FORM_NAME' => 'form1',
				'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
				'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
				'SHOW_TIME' => 'N'
			), null, array('HIDE_ICONS' => 'Y'));?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="liner"></div>
	<div class="cleft">
		<?
		$arData = array("NAME" => "Основной телефон", "CNAME" => "PERSONAL_PHONE", "VALUE" => $arResult["arUser"]["PERSONAL_PHONE"]);
		echo getPropertyHtml($arData);

		$arData = array("NAME" => "Дополнительный телефон", "CNAME" => "UF_PHONE_ADD", "VALUE" => $arResult["arUser"]["UF_PHONE_ADD"]);
		echo getPropertyHtml($arData);
		?>
	</div>
	<div class="cright">
		<?
		$arData = array("NAME" => "Дополнительное контактное лицо", "CNAME" => "UF_PERSON_ADD", "VALUE" => $arResult["arUser"]["UF_PERSON_ADD"]);
		echo getPropertyHtml($arData);

		$arData = array("NAME" => "Телефон дополнительного контактного лица", "CNAME" => "UF_PERSON_ADD_PHONE", "VALUE" => $arResult["arUser"]["UF_PERSON_ADD_PHONE"]);
		echo getPropertyHtml($arData);
		?>
	</div>
	<div class="clear"></div>
	<div class="liner"></div>
	<div class="cleft">
		<input type="submit" name="save2" id="saveProfile" value="<?= (($arResult["ID"] > 0)?"Сохранить изменения":GetMessage("MAIN_ADD")) ?>">&nbsp;&nbsp;<input type="reset" value="Отмена">
		<input type="hidden" name="save" value="Y">
	</div>
<? if(false) { ?>
	<br /><br /><br /><br /><br /><br /><br />

	<div class="clear"></div>
	<table class="sex">
		<tr>
			<td>
				<input type="radio" name="PERSONAL_GENDER" value="M" <? if ($arResult["arUser"]["PERSONAL_GENDER"] == 'M'): ?>checked<? endif ?> /><span class="pol">Мальчик</span>
			</td>
			<td>
				<input type="radio" name="PERSONAL_GENDER" value="F" <? if ($arResult["arUser"]["PERSONAL_GENDER"] == 'F'): ?>checked<? endif ?> /><span class="pol">Девочка</span>
			</td>
		</tr>
	</table>
	<div class="clear"></div>

	<label><?= GetMessage("USER_BIRTHDAY_DT") ?> (<?= $arResult["DATE_FORMAT"] ?>)</label>

	<div class="clear"></div>
	<?
	$APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
			'SHOW_INPUT' => 'Y',
			'FORM_NAME' => 'form1',
			'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
			'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
			'SHOW_TIME' => 'N'
		), null, array('HIDE_ICONS' => 'Y'));
	?>
	<div class="clear"></div>

	<label>Электронная почта</label>

	<div class="clear"></div>
	<input type="text" name="EMAIL" id="mails" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"] ?>" />

	<div class="clear"></div>

	<label><?= GetMessage('USER_COUNTRY') ?></label>

	<div class="clear"></div>
	<?= $arResult["COUNTRY_SELECT"] ?>
	<div class="clear"></div>

	<label><?= GetMessage('USER_CITY') ?></label>

	<div class="clear"></div>
	<input type="text" name="PERSONAL_CITY" maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_CITY"] ?>" />

	<div class="clear"></div>

	<label><?= GetMessage('USER_ZIP') ?></label>

	<div class="clear"></div>
	<input type="text" name="PERSONAL_ZIP" class="zip" maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_ZIP"] ?>" />

	<div class="info-zip">Свой индекс можно узнать в <a href="#" class="greydot">справочнике</a></div>
	<div class="clear"></div>

	<label><?= GetMessage("USER_STREET") ?></label>

	<div class="clear"></div>
	<textarea cols="30" rows="5" name="PERSONAL_STREET"><?= $arResult["arUser"]["PERSONAL_STREET"] ?></textarea>

	<div class="clear"></div>
	Например, ул.Первомайская, д. 14 кв. 12
	<div class="clear"></div>

	<label>Контактный телефон</label>

	<div class="clear"></div>
	<input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>" />

	<div class="clear"></div>

	<label>О себе</label>

	<div class="clear"></div>
	<textarea cols="30" rows="5" name="PERSONAL_NOTES"><?= $arResult["arUser"]["PERSONAL_NOTES"] ?></textarea>

	<div class="clear"></div>

	<div class="input-f">
		<input type="submit" name="save2" id="saveProfile" value="<?= (($arResult["ID"] > 0)?"Сохранить изменения":GetMessage("MAIN_ADD")) ?>">&nbsp;&nbsp;<input type="reset" value="Отмена">
		<input type="hidden" name="save" value="Y">
	</div><?
}
	?>
</form><?
if($arResult["SOCSERV_ENABLED"])
{
	?>
	<div class="clear"></div>
	<div class="liner"></div>
	<div class="citem" id="soclink">
		<span>Привязка к соцсетям</span>
		<p>Привяжите учетную запись социальной сети и используйте ее для входа</p><?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "custom", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE" => "Y"
		),
		false
	);
		?>
	</div><?
}?>
<div class="clear"></div>
<div class="liner"></div>
<form method="post" name="frmDelete"class="jqtransform former" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
	<div class="citem">
		<span>Удалить аккаунт</span>
		<p>Вы можете удалить аккаунт и все данные, связанные с ним</p>
			<span onclick="confirmDeleteAccount();">
				<input type="button" name="btnDelete" id="deleteProfile" value="Удалить" />
			</span>
	</div>
</form>