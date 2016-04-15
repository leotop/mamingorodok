<?
$IS_BASKET = true;
$IS_HIDE = true;
$IS_DETAIL = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<div class="reviews">
	<?
	$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "narrow", array(
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"COLUMNS_LIST" => array(
		0 => "NAME",
		1 => "PRICE",
		2 => "TYPE",
		3 => "QUANTITY",
		4 => "DELETE",
		5 => "DELAY",
		6 => "WEIGHT",
		7 => "DISCOUNT",
	),
	"PATH_TO_ORDER" => "/basket/order/".($USER->IsAuthorized()?'':'auth/'),
	"HIDE_COUPON" => "N",
	"QUANTITY_FLOAT" => "N",
	"PRICE_VAT_SHOW_VALUE" => "N",
	"SET_TITLE" => "N"
	),
	false
);
	?>

        <?$GLOBALS["arrFilterNew"]["PROPERTY_RECOMMENDED_BASKET_VALUE"] = "Y";?>
        <?$APPLICATION->IncludeComponent("bitrix:catalog.top", "recommend_basket", array(
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
            0 => "Цена для выгрузки на сайт",
        ),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"PRODUCT_PROPERTIES" => array(
		0 => "RECOMMENDED_BASKET",
	),
	"USE_PRODUCT_QUANTITY" => "N"
	),
	false
);?>


</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>