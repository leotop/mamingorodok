<?
    $IS_BASKET = true;
    $IS_HIDE = true;
    $HIDE_LEFT_COLUMN = true;
    $IS_DETAIL = true;

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Корзина");
?>
<div class="reviews">
    <?
        $APPLICATION->IncludeComponent(
            "bitrix:sale.basket.basket", 
            "mamiBasket", 
            array(
                "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
                "COLUMNS_LIST" => array(
                    0 => "PROPERTY_TSVET",
                    1 => "PROPERTY_RAZMER",
                    2 => "PROPERTY_PICTURE_MAXI",
                    3 => "PROPERTY_SHASSI",
                ),
                "PATH_TO_ORDER" => "/basket/order/".($USER->IsAuthorized()?"":"auth/"),
                "HIDE_COUPON" => "N",
                "QUANTITY_FLOAT" => "N",
                "PRICE_VAT_SHOW_VALUE" => "N",
                "SET_TITLE" => "N",
                "USE_PREPAYMENT" => "N",
                "ACTION_VARIABLE" => "action"
            ),
            false
        );
    ?>
    <?

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
		"ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "4",
		"FILTER_NAME" => "arrFilterNew",
		"PROPERTY_CODE" => array(
			0 => "CATALOG_AVAILABLE",
			1 => "RATING",
			2 => "RECOMMENDED_BASKET",
			3 => "OLD_PRICE",
			4 => "PRICE",
			5 => "",
		),
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
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
			0 => "RECOMMENDED_BASKET",
		),
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "main-block_nmg",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "N",
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
		"SEF_MODE" => "N",
		"CACHE_FILTER" => "N",
		"CONVERT_CURRENCY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		)
	),
	false
);?>


</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>