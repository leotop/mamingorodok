<?
$IS_BASKET = true;
$IS_HIDE = true;
$HIDE_LEFT_COLUMN = true;
$IS_DETAIL = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ќформление заказа");
?>
	<div class="reviews">
		<?
		$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	".default", 
	array(
		"ALLOW_PAY_FROM_ACCOUNT" => "N",
		"SHOW_MENU" => "N",
		"CITY_OUT_LOCATION" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"PROP_1" => array(
		),
		"PATH_TO_BASKET" => "/basket/index.php",
		"PATH_TO_PERSONAL" => "index.php",
		"PATH_TO_AUTH" => "/auth.php",
		"PATH_TO_PAYMENT" => "payment.php",
		"USE_AJAX_LOCATIONS" => "Y",
		"SHOW_AJAX_DELIVERY_LINK" => "S",
		"SET_TITLE" => "Y",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"PAY_FROM_ACCOUNT" => "Y",
		"ALLOW_AUTO_REGISTER" => "N",
		"DELIVERY_NO_AJAX" => "N",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"ALLOW_NEW_PROFILE" => "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
		)
	),
	false
);
		?>

	</div>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>