<?
header("Content-type: text/html; charset=windows-1251");
define("STOP_STATISTICS", true);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$intOrderID = intval($_REQUEST["orderID"]);
$intUserID = $USER -> GetID();
$strText = trim($_REQUEST["orderQuestion"]);

if($intOrderID > 0 && $intUserID > 0 && strpos($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"]) !== false) {
	$boolSent = false;

	$arError = array();

	if(empty($strText))
		$arError[] = 'Вы не указали текст вопроса.';
	elseif (CModule::IncludeModule("iblock") && CModule::IncludeModule("sale")) {
		$arFilter = Array(
			"USER_ID" => $intUserID,
			"ID" => $intOrderID
		);
		$rsOrder = CSaleOrder::GetList(array(), $arFilter);
		if($arOrder = $rsOrder -> GetNext()) {

			$arResult["PROP"] = array();
			$rsOrderProp = CSaleOrderPropsValue::GetOrderProps($intOrderID);
			while ($arProps = $rsOrderProp->Fetch()) {
				$arProp[$arProps["ORDER_PROPS_ID"]] = $arProps["VALUE"];
			}

			$arName = array();
			if(!empty($arProp[27])) $arName[] = $arProp[27];
			if(!empty($arProp[2])) $arName[] = $arProp[2];
			if(!empty($arProp[28])) $arName[] = $arProp[28];

			$arContacts = array();
			if(!empty($arProp[3])) $arContacts[] = $arProp[3];
			if(!empty($arProp[9])) $arContacts[] = $arProp[9];
			if(!empty($arProp[5])) $arContacts[] = $arProp[5];

			$strOrderList = "";
			$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC"),
				array("ORDER_ID" => $arOrder["ID"]),
				false,
				false,
				array("ID", "NAME", "QUANTITY", "PRICE")
			);
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				$strOrderList .= $arBasketItems["NAME"]." - ".intval($arBasketItems["QUANTITY"])." - ".CurrencyFormat(intval($arBasketItems["PRICE"]*$arBasketItems["QUANTITY"]), "RUB")."\n";
			}

			$arEventFields = array(
				"NAME" => implode(" ", $arName),
			   "CONTACTS" => implode("; ", $arContacts),
			   "ORDER_ID" => $arOrder["ID"],
			   'ORDER_LIST' => $strOrderList,
			   'QUESTION' => cSKTools::prePropcessRequestData($strText, true),
			   'LINK' => 'http://'.$_SERVER["HTTP_HOST"].'/bitrix/admin/sale_order_detail.php?ID='.$arOrder["ID"].'&filter=Y&set_filter=Y&lang=ru'
			);

			$intNewEvent = CEvent::Send("ORDER_QUESTION", SITE_ID, $arEventFields);
			if($intNewEvent > 0) {
				$boolSent = true;
				$strNote = 'Ваш вопрос успешно отправлен.';
			}
		}
	}

	if(!$boolSent && empty($arError)) $arError[] = 'Ошибка отправки вопроса.';

	if(!empty($arError))
		echo '<!--error-->'.implode("<br />", $arError);
	else echo $strNote;
}