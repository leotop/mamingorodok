<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("sale")) {
	$arFields = array(
		"ORDER_ID" => 11699,
		"ORDER_PROPS_ID" => 24,
		"NAME" => "Источник",
		"CODE" => "SOURCE",
		"VALUE" => '123s'
	);
	CSaleOrderPropsValue::Add($arFields);
}
die();


require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/itees.wikimart/include.php');

//$appId = COption::GetOptionString('itees.wikimart', 'general_api_id', '');
//$appSecret = COption::GetOptionString('itees.wikimart', 'general_api_secret', '');
//$obMerchantClient = new Wikimart\MerchantAPIClient\Client('http://merchant.wikimart.ru', $appId, $appSecret);



//$obResult = $obMerchantClient->methodGetOrder(2260557);
//var_dump($obResult);


IteesWikiMart::WikimartOrdersAgent();



die();

$intOrderID = 11081;
$rsWikiOrderID = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 25));
if ($arWikiOrderID = $rsWikiOrderID->Fetch()) {
	$intWikiOrderID = $arWikiOrderID["VALUE"];

	if($intWikiOrderID > 0) {
		require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/itees.wikimart/include.php');

		$appId = COption::GetOptionString('itees.wikimart', 'general_api_id', '');
		$appSecret = COption::GetOptionString('itees.wikimart', 'general_api_secret', '');

		$cWikiClient = $obMerchantClient  = new Wikimart\MerchantAPIClient\Client('http://merchant.wikimart.ru', $appId, $appSecret);
		$obResult = $cWikiClient ->methodSetOrderStatus( $intOrderID, "confirmed", null, iconv("windows-1251", "utf-8", 'Магазин принял заказ'));
		if($obResult -> getHttpCode() == 200)
			return true;
		else {
			$APPLICATION->ThrowException($obResult -> getError());
			return false;
		}
	}
}

	?>