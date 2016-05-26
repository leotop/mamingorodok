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
	"sale_ajax_order", 
	array(
		"ALLOW_NEW_PROFILE" => "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_BASKET" => "/basket/index.php",
		"PATH_TO_PERSONAL" => "index.php",
		"PATH_TO_PAYMENT" => "payment.php",
		"PATH_TO_AUTH" => "/auth/",
		"PAY_FROM_ACCOUNT" => "Y",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"ALLOW_AUTO_REGISTER" => "N",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "Y",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"SET_TITLE" => "Y",
		"USE_PREPAYMENT" => "N",
		"DISABLE_BASKET_REDIRECT" => "Y",
		"PRODUCT_COLUMNS" => array(
			0 => "PROPERTY_TSVET",
		),
		"PROP_1" => "",
		"PROP_2" => "",
		"COMPONENT_TEMPLATE" => "sale_ajax_order",
		"COMPATIBLE_MODE" => "Y",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PRICE_FORMATED",
			1 => "PROPERTY_TSVET",
		),
		"ADDITIONAL_PICT_PROP_2" => "-",
		"ADDITIONAL_PICT_PROP_3" => "-",
		"BASKET_IMAGES_SCALING" => "standard",
		"ALLOW_USER_PROFILES" => "N",
		"TEMPLATE_THEME" => "blue",
		"SHOW_ORDER_BUTTON" => "final_step",
		"SHOW_TOTAL_ORDER_BUTTON" => "N",
		"SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
		"SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
		"SHOW_DELIVERY_LIST_NAMES" => "Y",
		"SHOW_DELIVERY_INFO_NAME" => "Y",
		"SHOW_DELIVERY_PARENT_NAMES" => "Y",
		"SKIP_USELESS_BLOCK" => "Y",
		"BASKET_POSITION" => "after",
		"SHOW_BASKET_HEADERS" => "N",
		"DELIVERY_FADE_EXTRA_SERVICES" => "N",
		"SHOW_COUPONS_BASKET" => "Y",
		"SHOW_COUPONS_DELIVERY" => "Y",
		"SHOW_COUPONS_PAY_SYSTEM" => "Y",
		"SHOW_NEAREST_PICKUP" => "N",
		"DELIVERIES_PER_PAGE" => "8",
		"PAY_SYSTEMS_PER_PAGE" => "8",
		"PICKUPS_PER_PAGE" => "5",
		"SHOW_MAP_IN_PROPS" => "N",
		"PROPS_FADE_LIST_1" => "",
		"SERVICES_IMAGES_SCALING" => "standard",
		"PRODUCT_COLUMNS_HIDDEN" => "",
		"USE_YM_GOALS" => "N",
		"USE_CUSTOM_MAIN_MESSAGES" => "N",
		"USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
		"USE_CUSTOM_ERROR_MESSAGES" => "N"
	),
	false
);
/*        $APPLICATION->IncludeComponent(
	"individ:sale.order.full", 
	"mamiOrder", 
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
		"COMPONENT_TEMPLATE" => "mamiOrder"
	),
	false
);       */
    ?>

	</div>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>