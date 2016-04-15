<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$strType = trim($_REQUEST["TYPE"]);
$strLocation = trim($_REQUEST["LOCATION"]);

if(strpos($_SERVER['HTTP_REFERER'], "mamingorodok.ru") !== false && strlen($strLocation) > 0 && preg_match("/[a-z0-9]/", $strLocation)) {
	if(empty($strType)) $strType = 'card';

	$arPath = array(
		"card" => $_SERVER["DOCUMENT_ROOT"].'/includes/card/'
	);

	$arSearchReplace = array();
	if($_REQUEST["MODE"] == "delivery-data" && intval($_REQUEST["ID"]) > 0 && in_array($GLOBALS["CGeoIP"]->getLocationID(), array(
			1732,
			2399
		))
	) {
		CModule::IncludeModule("iblock");
		$rsI = CIBlockElement::GetList(Array(), array(
			"ACTIVE" => "Y",
			"IBLOCK_ID" => 2,
			"ID" => intval($_REQUEST["ID"])
		), false, false, array(
			"ID",
			"IBLOCK_ID",
			"PROPERTY_ELEVATOR",
			"PROPERTY_WO_ELEVATOR"
		));
		if($arI = $rsI->GetNext()) {
			if($arI["PROPERTY_ELEVATOR_VALUE"] > 0 || $arI["PROPERTY_WO_ELEVATOR_VALUE"] > 0) {
				$strText
					= '<div class="oh3">Стоимость подъема</div>
<div class="sk-table-deliveri-price-wrap">
	<table class="sk-table-deliveri-price">';
				if($arI["PROPERTY_ELEVATOR_VALUE"] > 0) $strText
					.= '<tr>
			<td><span class="s_like">Стоимость подъема на лифте</span></td>
			<td>'.CurrencyFormat($arI["PROPERTY_ELEVATOR_VALUE"], "RUB").'</td>
		</tr>';

				if($arI["PROPERTY_WO_ELEVATOR_VALUE"] > 0) $strText
					.= '<tr>
			<td><span class="s_like">Стоимость подъема без лифта</span></td>
			<td>'.CurrencyFormat($arI["PROPERTY_WO_ELEVATOR_VALUE"], "RUB").'</td>
		</tr>';

				$strText
					.= '
	</table>
</div>';

				$arSearchReplace["<!--ELEVATOR-->"] = $strText;
			}
		}
	}

	$strPath = $arPath[$strType].'/'.$strLocation.'.php';
	if(file_exists($strPath)) echo str_replace(array_keys($arSearchReplace), array_values($arSearchReplace), file_get_contents($strPath));
}
?>