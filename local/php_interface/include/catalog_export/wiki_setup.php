<?
//<title>Wikimart</title>
include(GetLangFileName($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/catalog/lang/", "/export_setup_templ.php"));

ClearVars();

$strYandexError = "";

if(($ACTION == 'EXPORT_EDIT' || $ACTION == 'EXPORT_COPY') && $STEP == 1) {
	if(isset($arOldSetupVars['IBLOCK_ID'])) $IBLOCK_ID = $arOldSetupVars['IBLOCK_ID'];
	if(isset($arOldSetupVars['SETUP_FILE_NAME'])) $SETUP_FILE_NAME = str_replace(COption::GetOptionString("catalog", "export_default_path", "/bitrix/catalog_export/"), '', $arOldSetupVars['SETUP_FILE_NAME']);
	if(isset($arOldSetupVars['SETUP_PROFILE_NAME'])) $SETUP_PROFILE_NAME = $arOldSetupVars['SETUP_PROFILE_NAME'];
	if(isset($arOldSetupVars['V'])) $V = $arOldSetupVars['V'];
	if(isset($arOldSetupVars['PRODUCER'])) $PRODUCER = $arOldSetupVars['PRODUCER'];
	if(isset($arOldSetupVars['XML_DATA'])) {
		if(get_magic_quotes_gpc()) {
			$XML_DATA = base64_encode(stripslashes($arOldSetupVars['XML_DATA']));
		}
		else {
			$XML_DATA = base64_encode($arOldSetupVars['XML_DATA']);
		}
	}
	if(isset($arOldSetupVars['SETUP_SERVER_NAME'])) $SETUP_SERVER_NAME = $arOldSetupVars['SETUP_SERVER_NAME'];
}

if($STEP > 1) {
	$IBLOCK_ID = IntVal($IBLOCK_ID);
	//if(empty($IBLOCK_ID)) $IBLOCK_ID = 2;
	$arIBlockres = CIBlock::GetList(Array("sort" => "asc"), Array("ID" => IntVal($IBLOCK_ID)));
	$arIBlockres = new CIBlockResult($arIBlockres);
	if($IBLOCK_ID <= 0 || !($arIBlock = $arIBlockres->GetNext())) $strYandexError .= GetMessage("CET_ERROR_NO_IBLOCK1")." #".$IBLOCK_ID." ".GetMessage("CET_ERROR_NO_IBLOCK2")."<br>";

	if(strlen($SETUP_FILE_NAME) <= 0) $strYandexError .= GetMessage("CET_ERROR_NO_FILENAME")."<br>";

	if(strlen($strYandexError) <= 0) {
		$bAllSections = False;
		$arSections = array();
		if(is_array($V)) {
			foreach($V as $key => $value) {
				if(trim($value) == "0") {
					$bAllSections = True;
					break;
				}
				if(IntVal($value) > 0) {
					$arSections[] = IntVal($value);
				}
			}
		}

		if(!$bAllSections && count($arSections) <= 0) $strYandexError .= GetMessage("CET_ERROR_NO_GROUPS")."<br>";
	}

	if($ACTION == "EXPORT_SETUP" && strlen($SETUP_PROFILE_NAME) <= 0) $strYandexError .= GetMessage("CET_ERROR_NO_PROFILE_NAME")."<br>";

	if(strlen($strYandexError) > 0) {
		$STEP = 1;
	}
}

echo ShowError($strYandexError);

?>
	<style>
		.brand-block {
			float: left;
			width: 25%;
			padding-right: 15px;
		}
	</style><?

if($STEP == 1) {
	//if(empty($IBLOCK_ID)) $IBLOCK_ID = 2;
	if(CModule::IncludeModule("iblock")) {
		// Get IBlock list
		?>
		<form method="post" name="wiki_setup_form" action="<? echo $APPLICATION->GetCurPage() ?>">
		<?= bitrix_sessid_post() ?>
		<?
		if ($ACTION == 'EXPORT_EDIT' || $ACTION == 'EXPORT_COPY')
		{
		?><input type="hidden" name="PROFILE_ID" value="<? echo intval($PROFILE_ID); ?>"><?
		}
		?>
		<script type="text/javascript">
			var TreeSelected = new Array();
			<?
			$intCountSelected = 0;
			if (isset($V) && is_array($V) && !empty($V))
			{
				foreach ($V as $oneKey)
				{
					?>TreeSelected[<? echo $intCountSelected ?>] = <? echo intval($oneKey); ?>;
			<?
			$intCountSelected++;
			}
		}
		?>
			function ClearSelected() {
				TreeSelected = new Array();
			}
		</script>
		<table width="100%" class="edit-table">
		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">1.&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<select name="IBLOCK_ID" id="IBLOCK_ID" OnChange="document.getElementById('id_ifr').src='/bitrix/tools/catalog_export/wiki_util.php?IBLOCK_ID='+this[this.selectedIndex].value;">
					<option value=""><? echo GetMessage("CET_SELECT_IBLOCK"); ?> -&gt;</option>
					<?
					$iblocks = CIBlock::GetList(array("SORT" => "ASC"));
					while ($ar = $iblocks->GetNext())
					{
					?>
					<option value="<? echo $ar['ID'] ?>" <? if(IntVal($ar['ID']) == $IBLOCK_ID) echo "selected"; ?>><? echo $ar['NAME'] ?></option><?
					}
					?>
				</select> <br><br>
			</td>
		</tr>

		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">2.1&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<? // Get sections list ?>
				<font class="text"><b><? echo GetMessage("CET_SELECT_GROUP"); ?></b></font><br>
				<table border=0>
					<tr>
						<td>
							<div id="tree"></div>
						</td>
					</tr>
				</table>

				<script type="text/javascript">
					clevel = 0;

					function buildNoMenu() {
						var buffer;
						buffer = '<br><table border="0" cellspacing="0" cellpadding="0">';
						buffer += '<tr><td><font class="text" style="color: #A9A9A9;"><?echo CUtil::JSEscape(GetMessage("CET_FIRST_SELECT_IBLOCK"));?></font></td></tr>';
						buffer += '</table>';
						document.getElementById('tree').innerHTML = buffer;
					}

					function buildMenu() {
						var i;
						var buffer;
						var imgSpace;

						buffer = '<br><table border="0" cellspacing="0" cellpadding="0">';
						buffer += '<tr>';
						buffer += '<td colspan="2" valign="top" align="left"><input type="checkbox" name="V[]" value="0" id="v0"' + (BX.util.in_array(0, TreeSelected) ? ' checked' : '') + '><label for="v0"><font class="text"><b><?echo CUtil::JSEscape(GetMessage("CET_ALL_GROUPS"));?></b></font></label></td>';
						buffer += '</tr>';

						for (i in Tree[0]) {
							if (!Tree[i]) {
								space = '<input type="checkbox" name="V[]" value="' + i + '" id="V' + i + '"' + (BX.util.in_array(i, TreeSelected) ? ' checked' : '') + '><label for="V' + i + '"><font class="text">' + Tree[0][i][0] + '</font></label>';
								imgSpace = '';
							}
							else {
								space = '<input type="checkbox" name="V[]" value="' + i + '"' + (BX.util.in_array(i, TreeSelected) ? ' checked' : '') + '><a href="javascript: collapse(' + i + ')"><font class="text"><b>' + Tree[0][i][0] + '</b></font></a>';
								imgSpace = '<img src="/bitrix/images/catalog/load/plus.gif" width="13" height="13" id="img_' + i + '" OnClick="collapse(' + i + ')">';
							}

							buffer += '<tr>';
							buffer += '<td width="20" valign="top" align="center">' + imgSpace + '</td>';
							buffer += '<td id="node_' + i + '">' + space + '</td>';
							buffer += '</tr>';
						}

						buffer += '</table>';

						document.getElementById('tree').innerHTML = buffer;
						//BX.adminPanel.modifyFormElements('wiki_setup_form');
					}

					function collapse(node) {
						if (document.getElementById('table_' + node) == null) {
							var i;
							var buffer;
							var imgSpace;

							buffer = '<table border="0" id="table_' + node + '" cellspacing="0" cellpadding="0">';

							for (i in Tree[node]) {
								if (!Tree[i]) {
									space = '<input type="checkbox" name="V[]" value="' + i + '" id="V' + i + '"' + (BX.util.in_array(i, TreeSelected) ? ' checked' : '') + '><label for="V' + i + '"><font class="text">' + Tree[node][i][0] + '</font></label>';
									imgSpace = '';
								}
								else {
									space = '<input type="checkbox" name="V[]" value="' + i + '"' + (BX.util.in_array(i, TreeSelected) ? ' checked' : '') + '><a href="javascript: collapse(' + i + ')"><font class="text"><b>' + Tree[node][i][0] + '</b></font></a>';
									imgSpace = '<img src="/bitrix/images/catalog/load/plus.gif" width="13" height="13" id="img_' + i + '" OnClick="collapse(' + i + ')">';
								}

								buffer += '<tr>';
								buffer += '<td width="20" align="center" valign="top">' + imgSpace + '</td>';
								buffer += '<td id="node_' + i + '">' + space + '</td>';
								buffer += '</tr>';
							}

							buffer += '</table>';

							document.getElementById('node_' + node).innerHTML += buffer;
							document.getElementById('img_' + node).src = '/bitrix/images/catalog/load/minus.gif';
						}
						else {
							var tbl = document.getElementById('table_' + node);
							tbl.parentNode.removeChild(tbl);
							document.getElementById('img_' + node).src = '/bitrix/images/catalog/load/plus.gif';
						}
						//BX.adminPanel.modifyFormElements('wiki_setup_form');
					}

					function changeStyle(node, action) {
						docStyle = document.getElementById('node_' + node).style;

						with (docStyle) {
							if (action == 'to') {
								backgroundColor = '#e5e5e5';
							}
							else {
								backgroundColor = '#ffffff';
							}
						}
					}

					//-->
				</script>

				<iframe src="/bitrix/tools/catalog_export/wiki_util.php?IBLOCK_ID=<?= intval($IBLOCK_ID) ?>" id="id_ifr" name="ifr" style="display:none"></iframe>
				<br><br>
			</td>
		</tr>
		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">2.2&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<font class="text"><b>Исключить бренды</b></font><br><?
				$rsI = CIBlockElement::GetList(Array("NAME" => "ASC"), array(
					"ACTIVE" => "Y",
					"IBLOCK_ID" => 5
				), false, false, array(
					"ID",
					"IBLOCK_ID",
					"NAME",
					"ID"
				));
				while($arI = $rsI->GetNext()) {
					echo '<div class="brand-block"><input'.(in_array($arI["ID"], $PRODUCER)?' checked="checked"':'').' name="PRODUCER[]" id="P'.$arI["ID"].'" value="'.$arI["ID"].'" type="checkbox"><label for="P'.$arI["ID"].'"><font class="text">'.$arI["NAME"].'</font></label></div>';
				}?><br><br>
			</td>
		</tr>
		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">2.3&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<font class="text"><b>Цена</b></font><br> от
				<input type="text" name="PRICE_FROM" value="<?= $arOldSetupVars["PRICE_FROM"] ?>" class="price-input"> до
				<input name="PRICE_TO" value="<?= $arOldSetupVars["PRICE_TO"] ?>" type="text" class="price-input">
			</td>
		</tr>
		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">3.&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<script type="text/javascript">
					function showDetailPopup() {
						if (null == obDetailWindow) {
							var s = BX('IBLOCK_ID');
							var obDetailWindow = new BX.CAdminDialog({
								'content_url': '/bitrix/tools/catalog_export/wiki_detail.php?lang=<?=LANGUAGE_ID?>&bxpublic=Y&IBLOCK=' + s[s.selectedIndex].value,
								'width': 900, 'height': 550,
								'resizable': true
							});
							obDetailWindow.Show();
						}
					}

					function setDetailData(data) {
						BX('XML_DATA').value = data;
					}
				</script>
				<font class="text"><?= GetMessage('CAT_DETAIL_PROPS') ?>: </font>
				<button onclick="showDetailPopup(); return false;"><?= GetMessage('CAT_DETAIL_PROPS_RUN') ?></button>
				<input type="hidden" id="XML_DATA" name="XML_DATA" value="<? echo (strlen($XML_DATA) > 0 ? $XML_DATA : ''); ?>" />
			</td>
			</td>
		</tr>
		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">4.&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<font class="text">
					<? echo GetMessage("CET_SERVER_NAME"); ?>
					<input type="text" name="SETUP_SERVER_NAME" value="<? echo (strlen($SETUP_SERVER_NAME) > 0)?htmlspecialchars($SETUP_SERVER_NAME):'' ?>" size="50" />
					<input type="button" onclick="this.form['SETUP_SERVER_NAME'].value = window.location.host;" value="<? echo htmlspecialchars(GetMessage('CET_SERVER_NAME_SET_CURRENT')) ?>" />
				</font> <br><br>
			</td>
		</tr>

		<tr>
			<td width="0%" valign="top">
				<font class="text" style="font-size: 20px;">5.&nbsp;&nbsp;&nbsp;</font>
			</td>
			<td width="100%" valign="top">
				<font class="text">
					<? echo GetMessage("CET_SAVE_FILENAME"); ?>
					<b><?= COption::GetOptionString("catalog", "export_default_path", "/bitrix/catalog_export/") ?></b><input type="text" name="SETUP_FILE_NAME" value="<? echo (strlen($SETUP_FILE_NAME) > 0)?htmlspecialchars($SETUP_FILE_NAME):"wiki.php" ?>" size="50" />
				</font> <br><br>
			</td>
		</tr>

		<? if($ACTION == "EXPORT_SETUP"): ?>
			<tr>
				<td width="0%" valign="top">
					<font class="text" style="font-size: 20px;">6.&nbsp;&nbsp;&nbsp;</font>
				</td>
				<td width="100%" valign="top">
					<font class="text">
						<? echo GetMessage("CET_PROFILE_NAME"); ?>
						<input type="text" name="SETUP_PROFILE_NAME" value="<? echo htmlspecialchars($SETUP_PROFILE_NAME) ?>" size="30">
					</font> <br><br>
				</td>
			</tr>
		<?
		else:
			echo '<input type="hidden" name="SETUP_PROFILE_NAME" value="'.htmlspecialchars($SETUP_PROFILE_NAME).'" />';
		endif;?>

		<tr>
			<td width="0%" valign="top">

			</td>
			<td width="100%" valign="top">
				<input type="hidden" name="lang" value="<? echo LANGUAGE_ID ?>">
				<input type="hidden" name="ACT_FILE" value="<? echo htmlspecialchars($_REQUEST["ACT_FILE"]) ?>">
				<input type="hidden" name="ACTION" value="<? echo htmlspecialchars($ACTION) ?>">
				<input type="hidden" name="STEP" value="<? echo intval($STEP) + 1 ?>">
				<input type="hidden" name="SETUP_FIELDS_LIST" value="V,IBLOCK_ID,SETUP_SERVER_NAME,SETUP_FILE_NAME,XML_DATA,PRODUCER,PRICE_FROM,PRICE_TO">
				<input type="submit" value="<? echo ($ACTION == "EXPORT")?GetMessage("CET_EXPORT"):GetMessage("CET_SAVE") ?>">
			</td>
		</tr>
		</table>
		</form>
	<?
	}
}
elseif($STEP == 2) {
	$SETUP_FILE_NAME = COption::GetOptionString("catalog", "export_default_path", "/bitrix/catalog_export/").$SETUP_FILE_NAME;

	$FINITE = True;
}
?>