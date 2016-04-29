<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="CatBanners">
    <div class="left"><?=$APPLICATION->ShowBanner('catalog_center_left')?></div>
    <div class="right"><?=$APPLICATION->ShowBanner('catalog_center_right')?></div>
    <div class="clear"></div>
	<input type="hidden" id="nohide" value="1">
</div>


        <?$GLOBALS["arrFilterNew"]["PROPERTY_NEW_VALUE"] = "Y";?>
        <?$APPLICATION->IncludeComponent("individ:catalog.top", "main-block-new", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "ELEMENT_SORT_FIELD" => "PROPERTY_NEW",
            "ELEMENT_SORT_ORDER" => "desc",
            "ELEMENT_COUNT" => "4",
            "LINE_ELEMENT_COUNT" => "4",
            "FILTER_NAME" => "arrFilterNew",
            "PROPERTY_CODE" => array(
                0 => "NEW",
                1 => "PRICE",
                2 => "OLD_PRICE",
                3 => "WISHES",
                4 => "RATING",
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
			"CACHE_FILTER"=>"Y",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_COMPARE" => "N",
            "PRICE_CODE" => array(
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_PROPERTIES" => array(
            ),
            "USE_PRODUCT_QUANTITY" => "N"
            ),
            false
        );?>



            <?$GLOBALS["arrFilterDiscount"][">PROPERTY_OLD_PRICE"] = "0";?>
            <?$APPLICATION->IncludeComponent("individ:catalog.top", "main-block-sale", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "ELEMENT_SORT_FIELD" => "PROPERTY_OLD_PRICE",
                "ELEMENT_SORT_ORDER" => "desc",
                "ELEMENT_COUNT" => "4",
                "LINE_ELEMENT_COUNT" => "4",
                "FILTER_NAME" => "arrFilterDiscount",
                "PROPERTY_CODE" => array(
                    0 => "NEW",
                    1 => "PRICE",
                    2 => "OLD_PRICE",
                    3 => "WISHES",
                    4 => "RATING",
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
				"CACHE_FILTER"=>"Y",
                "DISPLAY_COMPARE" => "N",
                "PRICE_CODE" => array(
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_PROPERTIES" => array(
                ),
                "USE_PRODUCT_QUANTITY" => "N"
                ),
                false
            );?>

		  <?$GLOBALS["arrFilterPopular"][">=PROPERTY_SALES_RATING"] = "0";?>
        <?$APPLICATION->IncludeComponent("individ:catalog.top", "main-block-popular", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "ELEMENT_SORT_FIELD" => "PROPERTY_SALES_RATING",
            "ELEMENT_SORT_ORDER" => "desc",
            "ELEMENT_COUNT" => "8",
            "LINE_ELEMENT_COUNT" => "4",
            "FILTER_NAME" => "arrFilterPopular",
            "PROPERTY_CODE" => array(
                0 => "NEW",
                1 => "PRICE",
                2 => "OLD_PRICE",
                3 => "WISHES",
                4 => "RATING",
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
			"CACHE_FILTER"=>"Y",
            "DISPLAY_COMPARE" => "N",
            "PRICE_CODE" => array(
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_PROPERTIES" => array(
            ),
            "USE_PRODUCT_QUANTITY" => "N"
            ),
            false
        );?>


		<?$GLOBALS["arrFilterWish"][">PROPERTY_WISH_RATING"] = "0";?>
        <?$APPLICATION->IncludeComponent("individ:catalog.top", "main-block-having", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "ELEMENT_SORT_FIELD" => "PROPERTY_WISH_RATING",
            "ELEMENT_SORT_ORDER" => "desc",
            "ELEMENT_COUNT" => "8",
            "LINE_ELEMENT_COUNT" => "4",
            "FILTER_NAME" => "arrFilterWish",
            "PROPERTY_CODE" => array(
                0 => "NEW",
                1 => "PRICE",
                2 => "OLD_PRICE",
                3 => "WISHES",
                4 => "RATING",
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
			"CACHE_FILTER"=>"Y",
            "DISPLAY_COMPARE" => "N",
            "PRICE_CODE" => array(
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_PROPERTIES" => array(
            ),
            "USE_PRODUCT_QUANTITY" => "N"
            ),
            false
        );?>
