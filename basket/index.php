<?
    $IS_BASKET = true;
    $IS_HIDE = true;
    $HIDE_LEFT_COLUMN = true;
    $IS_DETAIL = true;

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Корзина");
?>
<style>
.centered {
    position:relative;
}
</style><br><br>
<div class="reviews">
    <?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"basket-redesign_new", 
	array(
		"COMPONENT_TEMPLATE" => "basket-redesign_new",
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
		"PATH_TO_ORDER" => "/basket/order/",
		"HIDE_COUPON" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"USE_PREPAYMENT" => "N",
		"QUANTITY_FLOAT" => "N",
		"SET_TITLE" => "Y",
		"ACTION_VARIABLE" => "action",
		"OFFERS_PROPS" => array(
		),
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"USE_GIFTS" => "Y",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "undefined",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N"
	),
	false
);

    ?>
    <?$GLOBALS["arrFilterNew"]["PROPERTY_RECOMMENDED_BASKET_VALUE"] = "Y";?>
    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"main-block_nmg", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"ELEMENT_SORT_FIELD" => "name",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_COUNT" => "5",
		"LINE_ELEMENT_COUNT" => "5",
		"FILTER_NAME" => "arrFilterNew",
		"PROPERTY_CODE" => array(
			0 => "RATING",
			1 => "RECOMMENDED_BASKET",
			2 => "OLD_PRICE",
			3 => "PRICE",
			4 => "",
		),
		"SECTION_URL" => "/catalog/#SECTION_CODE#/",
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#CODE#/",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(
			0 => "base",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "main-block_nmg",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "Y",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "5",
		"SEF_MODE" => "Y",
		"CACHE_FILTER" => "N",
		"CONVERT_CURRENCY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"SEF_RULE" => "",
		"VIEW_MODE" => "SECTION",
		"PRODUCT_DISPLAY_MODE" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"TEMPLATE_THEME" => "blue"
	),
	false
);?>


</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>