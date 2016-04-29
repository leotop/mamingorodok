<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

function getPropertyHtml($arData) {
	if(empty($arData["TYPE"])) $arData["TYPE"] = 'text';

	$strTmp = '
	<div class="citem">
		<span>'.$arData["NAME"].'</span>'.(empty($arData["DESCRIPTION"])?'':'<p>'.$arData["DESCRIPTION"].'</p>');

	if($arData["TYPE"] == 'text')
		$strTmp .= '<input id="'.$arData["CNAME"].'" name="'.$arData["CNAME"].'" value="'.$arData["VALUE"].'" type="text">';
	elseif($arData["TYPE"] == 'textarea')
		$strTmp .= '<textarea name="'.$arData["CNAME"].'">'.$arData["VALUE"].'</textarea>';

	$strTmp .= '</div>';

	return $strTmp;
}

if(!$arResult["NEW_PROFILE"] && !empty($arResult["ERROR"]))
	echo '<div class="errorp">'.implode("<br />", $arResult["ERROR"]).'</div><br />';
if(!$arResult["NEW_PROFILE"] && !empty($arResult["NOTE"]))
	echo '<div class="notep">'.implode("<br />", $arResult["NOTE"]).'</div><br />';


$intLocationCnt = 0;

foreach($arResult["USER_PROFILES"] as $arProfile) {
	?>
	<form class="jqtransform" method="post" action="<?=$APPLICATION->GetCurPage()?>">
	<div>
		<input type="hidden" name="frmSent" value="Y">
		<input type="hidden" name="profileID" value="<?=$arProfile["ID"]?>">
		<div class="cleft"><?
			$arData = array(
				"NAME" => "Почтовый индекс",
				"DESCRIPTION" => 'Узнать индекс можно на сайте <a href="http://www.russianpost.ru/rp/servise/ru/home/postuslug/searchops" target="_blank">Почты России</a>',
				"CNAME" => "ORDER_PROP_26",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][26]["VALUE_FORMATED"]
			);
			echo getPropertyHtml($arData);

			echo '<div class="citem"><span>Местоположение</span>';

			$GLOBALS["APPLICATION"]->IncludeComponent(
				"bitrix:sale.ajax.locations",
				"jqtransform",
				array(
					"AJAX_CALL" => "N",
					"COUNTRY_INPUT_NAME" => "COUNTRY_ORDER_PROP_4_".$intLocationCnt,
					"REGION_INPUT_NAME" => "REGION_ORDER_PROP_4_".$intLocationCnt,
					"CITY_INPUT_NAME" => "ORDER_PROP_4_".$intLocationCnt,
					"CITY_OUT_LOCATION" => "Y",
					"LOCATION_VALUE" => $arProfile["USER_PROPS_VALUES"][4]["VALUE"],
					"ORDER_PROPS_ID" => 4,
					"ONCITYCHANGE" => "",
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);
			$intLocationCnt++;
			echo '</div>';


			$arData = array(
				"NAME" => "Адрес",
				"DESCRIPTION" => 'Улица, дом, корпус, квартира',
				"CNAME" => "ORDER_PROP_6",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][6]["VALUE_FORMATED"]
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Телефон",
				"CNAME" => "ORDER_PROP_3",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][3]["VALUE_FORMATED"]
			);
			echo getPropertyHtml($arData);
			?>
		</div>
		<div class="cright">
			<?
			$arData = array(
				"NAME" => "Фамилия получателя",
				"CNAME" => "ORDER_PROP_27",
				"VALUE" => ''
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Имя",
				"CNAME" => "ORDER_PROP_2",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][2]["VALUE_FORMATED"]
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Отчество",
				"CNAME" => "ORDER_PROP_28",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][28]["VALUE_FORMATED"]
			);
			echo getPropertyHtml($arData);

			echo '<br />';

			$arData = array(
				"NAME" => "Примечание",
				"CNAME" => "ORDER_PROP_29",
				"VALUE" => $arProfile["USER_PROPS_VALUES"][29]["VALUE_FORMATED"],
			   "TYPE" => "textarea"
			);
			echo getPropertyHtml($arData);
			?>
		</div>
		<input type="submit" name="btnDelete" class="btnSend fr top10" value="Удалить">
		<input type="submit" name="btnSave" class="btnSend fr top10" value="Сохранить">
	</div>
	</form>
	<div class="clear"></div>
	<div class="liner"></div><?
}

?>
<br />
<a name="new_profile"></a>

<form class="jqtransform" method="post" action="<?=$APPLICATION->GetCurPage()?>#new_profile">
	<div class="ad_new">
		<span class="ad_new_add">+ Добавить адрес</span>
		<?
		if($arResult["NEW_PROFILE"] && !empty($arResult["ERROR"]))
			echo '<div class="errorp">'.implode("<br />", $arResult["ERROR"]).'</div>';
		else echo '<br />';
		?>
		<br />
		<input type="hidden" name="frmSent" value="Y">
		<input type="hidden" name="newProfile" value="Y">
		<div class="cleft">
			<?
			$arData = array(
				"NAME" => "Почтовый индекс",
			   "DESCRIPTION" => 'Узнать индекс можно на сайте <a href="http://www.russianpost.ru/rp/servise/ru/home/postuslug/searchops" target="_blank">Почты России</a>',
			   "CNAME" => "ORDER_PROP_26",
			   "VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_26"]:'')
			);
			echo getPropertyHtml($arData);

			echo '<div class="citem"><span>Местоположение</span>';

			$GLOBALS["APPLICATION"]->IncludeComponent(
				"bitrix:sale.ajax.locations",
				"jqtransform",
				array(
					"AJAX_CALL" => "N",
					"COUNTRY_INPUT_NAME" => "COUNTRY_ORDER_PROP_4",
					"REGION_INPUT_NAME" => "REGION_ORDER_PROP_4",
					"CITY_INPUT_NAME" => "ORDER_PROP_4",
					"CITY_OUT_LOCATION" => "Y",
					"LOCATION_VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_4"]:''),
					"ORDER_PROPS_ID" => 4,
					"ONCITYCHANGE" => "",
				),
				null,
				array('HIDE_ICONS' => 'Y')
			);
			echo '</div>';


			$arData = array(
				"NAME" => "Адрес",
				"DESCRIPTION" => 'Улица, дом, корпус, квартира',
				"CNAME" => "ORDER_PROP_6",
				"VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_6"]:'')
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Телефон",
				"CNAME" => "ORDER_PROP_3",
				"VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_3"]:'')
			);
			echo getPropertyHtml($arData);
			?>
		</div>
		<div class="cright">
			<?
			$arData = array(
				"NAME" => "Фамилия получателя",
				"CNAME" => "ORDER_PROP_27",
				"VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_27"]:'')
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Имя",
				"CNAME" => "ORDER_PROP_2",
				"VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_2"]:'')
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Отчество",
				"CNAME" => "ORDER_PROP_28",
				"VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_28"]:'')
			);
			echo getPropertyHtml($arData);

			$arData = array(
				"NAME" => "Примечание",
				"CNAME" => "ORDER_PROP_29",
				"TYPE" => "textarea",
			   "VALUE" => ($arResult["NEW_PROFILE"]?$arResult["POST"]["ORDER_PROP_29"]:'')
			);
			echo getPropertyHtml($arData);
			?>
		</div>
		<div class="clear"></div>
		<input type="submit" name="btnSave" class="btnSend fr top10" value="Сохранить">
	</div>
</form>