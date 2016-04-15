<?
    $showSravn = true;
    $HIDE_LEFT_COLUMN = true;
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Сравнить");
?>


<?$APPLICATION->IncludeComponent(
        "bitrix:catalog.compare.result", 
        ".default", 
        array(
            "NAME" => "CATALOG_COMPARE_LIST",
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "FIELD_CODE" => array(
                0 => "NAME",
                1 => "PREVIEW_PICTURE",
            ),
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "CH_WEIGHT",
                2 => "PRICE",
                3 => "CH_TYPE",
                4 => "",
            ),
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_ORDER" => "asc",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_SHADOW" => "Y",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "DETAIL_URL" => "",
            "BASKET_URL" => "/personal/basket.php",
            "ACTION_VARIABLE" => "action",
            "PRODUCT_ID_VARIABLE" => "id",
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "PRICE_CODE" => array(
                0=> "Цена для выгрузки на сайт"
            ),
            "USE_PRICE_COUNT" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "PRICE_VAT_INCLUDE" => "Y",
            "DISPLAY_ELEMENT_SELECT_BOX" => "N",
            "ELEMENT_SORT_FIELD_BOX" => "name",
            "ELEMENT_SORT_ORDER_BOX" => "asc",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COMPONENT_TEMPLATE" => ".default",
            "OFFERS_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "OFFERS_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "ELEMENT_SORT_FIELD_BOX2" => "id",
            "ELEMENT_SORT_ORDER_BOX2" => "desc",
            "HIDE_NOT_AVAILABLE" => "N",
            "CONVERT_CURRENCY" => "N"
        ),
        false
    );?>
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog.compare.list", 
    ".default", 
    array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => CATALOG_IBLOCK_ID,
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "DETAIL_URL" => "",
        "COMPARE_URL" => "compare.php",
        "NAME" => "CATALOG_COMPARE_LIST",
        "AJAX_OPTION_ADDITIONAL" => "",
        "COMPONENT_TEMPLATE" => ".default",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id"
    ),
    false
    );?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>