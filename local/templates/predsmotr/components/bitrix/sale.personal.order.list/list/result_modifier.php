<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

$arParams["PATH_TO_PAYMENT"] = '/personal/order/payment/';
$arResult["ORDER_BY_STATUS"] = Array();

$arFilter = Array();
$arFilter["USER_ID"] = IntVal($USER->GetID());
$arFilter["CANCELED"] = "Y";

$by = (strlen($_REQUEST["by"])>0 ? $_REQUEST["by"]: "ID");
$order = (strlen($_REQUEST["order"])>0 ? $_REQUEST["order"]: "DESC");
$dbOrder = CSaleOrder::GetList(Array($by => $order), $arFilter);
while($arOrder = $dbOrder->GetNext()) {
	$arOrder["FORMATED_PRICE"] = SaleFormatCurrency($arOrder["PRICE"], $arOrder["CURRENCY"]);
	$arOrder["CAN_CANCEL"] = (($arOrder["CANCELED"]!="Y" && $arOrder["STATUS_ID"]!="F" && $arOrder["PAYED"]!="Y") ? "Y" : "N");

	$arOrder["URL_TO_DETAIL"] = CComponentEngine::MakePathFromTemplate($arParams["PATH_TO_DETAIL"], Array("ID" => $arOrder["ID"]));
	$arOrder["URL_TO_COPY"] = CComponentEngine::MakePathFromTemplate($arParams["PATH_TO_COPY"], Array("ID" => $arOrder["ID"]))."COPY_ORDER=Y";
	$arOrder["URL_TO_CANCEL"] = CComponentEngine::MakePathFromTemplate($arParams["PATH_TO_CANCEL"], Array("ID" => $arOrder["ID"]))."CANCEL=Y";

	$arOBasket = Array();
	$dbBasket = CSaleBasket::GetList(($b="NAME"), ($o="ASC"), array("ORDER_ID"=>$arOrder["ID"]));
	while ($arBasket = $dbBasket->Fetch())
	{
		$arBasket["NAME~"] = $arBasket["NAME"];
		$arBasket["NOTES~"] = $arBasket["NOTES"];
		$arBasket["NAME"] = htmlspecialcharsEx($arBasket["NAME"]);
		$arBasket["NOTES"] = htmlspecialcharsEx($arBasket["NOTES"]);
		$arBasket["QUANTITY"] = DoubleVal($arBasket["QUANTITY"]);

		$arOBasket[] = $arBasket;
	}

	$arResult["ORDERS"][] = Array(
		"ORDER" =>$arOrder,
		"BASKET_ITEMS" =>$arOBasket,
	);
}

foreach($arResult["ORDERS"] as $intCnt => $val)
{
	$arOrder = $val["ORDER"];
	if (IntVal($arOrder["PAY_SYSTEM_ID"]) > 0)
	{
		$arPaySys = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"], $arOrder["PERSON_TYPE_ID"]);
		$val["ORDER"]["PAY_SYSTEM"] = $arPaySys;
		$val["ORDER"]["PAY_SYSTEM"]["NAME"] = htmlspecialcharsEx($arResult["PAY_SYSTEM"]["NAME"]);
	}

	if ($val["ORDER"] != "Y" && $val["ORDER"]["CANCELED"] != "Y")
	{
		if (IntVal($val["ORDER"]["PAY_SYSTEM_ID"]) > 0)
		{
			$dbPaySysAction = CSalePaySystemAction::GetList(
				array(),
				array(
					"PAY_SYSTEM_ID" => $val["ORDER"]["PAY_SYSTEM_ID"],
					"PERSON_TYPE_ID" => $val["ORDER"]["PERSON_TYPE_ID"]
				),
				false,
				false,
				array("NAME", "ACTION_FILE", "NEW_WINDOW", "PARAMS", "ENCODING")
			);
			if ($arPaySysAction = $dbPaySysAction->Fetch())
			{
				if (strlen($arPaySysAction["ACTION_FILE"]) > 0)
				{
					$val["ORDER"]["CAN_REPAY"] = "Y";
					if ($arPaySysAction["NEW_WINDOW"] == "Y")
					{
						$val["ORDER"]["PAY_SYSTEM"]["PSA_ACTION_FILE"] = htmlspecialcharsbx($arParams["PATH_TO_PAYMENT"]).'?ORDER_ID='.$val["ORDER"]["ID"];
					}
					else
					{
						CSalePaySystemAction::InitParamArrays($arOrder, $ID, $arPaySysAction["PARAMS"]);

						$pathToAction = $_SERVER["DOCUMENT_ROOT"].$arPaySysAction["ACTION_FILE"];
						$pathToAction = str_replace("\\", "/", $pathToAction);
						while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
							$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);
						if (file_exists($pathToAction))
						{
							if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
								$pathToAction .= "/payment.php";
							$val["ORDER"]["PAY_SYSTEM"]["PSA_ACTION_FILE"] = $pathToAction;
						}

						if(strlen($arPaySysAction["ENCODING"]) > 0)
						{
							define("BX_SALE_ENCODING", $arPaySysAction["ENCODING"]);
							AddEventHandler("main", "OnEndBufferContent", "ChangeEncoding");
							function ChangeEncoding($content)
							{
								global $APPLICATION;
								header("Content-Type: text/html; charset=".BX_SALE_ENCODING);
								$content = $APPLICATION->ConvertCharset($content, SITE_CHARSET, BX_SALE_ENCODING);
								$content = str_replace("charset=".SITE_CHARSET, "charset=".BX_SALE_ENCODING, $content);
							}
						}

					}
				}
			}
		}
	}

	if($val["ORDER"]["CANCELED"] == "Y")
		$arResult["ORDER_BY_STATUS"]["CANCELED"][] = $val;
	else $arResult["ORDER_BY_STATUS"][$val["ORDER"]["STATUS_ID"]][] = $val;
}

if(!empty($arResult["ORDER_BY_STATUS"]["CANCELED"])) {
	$arResult["INFO"]["STATUS"]["CANCELED"]["NAME"] = '"Отменен"';
}

?>