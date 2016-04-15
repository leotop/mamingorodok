<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"basket-redesign", 
	array(
		"COMPONENT_TEMPLATE" => "basket-redesign",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "DELETE",
			3 => "DELAY",
			4 => "TYPE",
			5 => "PRICE",
			6 => "QUANTITY",
			7 => "SUM",
		),
		"PATH_TO_ORDER" => "/personal/order.php",
		"HIDE_COUPON" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"USE_PREPAYMENT" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"ACTION_VARIABLE" => "action",
		"OFFERS_PROPS" => array(
		),
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N"
	),
	false
);?><?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>