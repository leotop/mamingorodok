<?
setlocale(LC_ALL, "ru_RU.cp1251"); 
setlocale(LC_NUMERIC, "C"); 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<div style="width:610px;"></div>
<?$APPLICATION->IncludeComponent("bitrix:catalog.element", "detail.pictures.popup", array(
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => "2",
    "ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
    "ELEMENT_CODE" => "",
    "SECTION_ID" => $_REQUEST["SECTION_ID"],
    "SECTION_CODE" => "",
    "PROPERTY_CODE" => array(
        0 => "IMG_BIG",
        1 => "",
    ),
    "SECTION_URL" => "",
    "DETAIL_URL" => "",
    "BASKET_URL" => "/personal/basket.php",
    "ACTION_VARIABLE" => "action",
    "PRODUCT_ID_VARIABLE" => "id",
    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
    "PRODUCT_PROPS_VARIABLE" => "prop",
    "SECTION_ID_VARIABLE" => "SECTION_ID",
    "CACHE_TYPE" => "N",
    "CACHE_TIME" => "36000000",
    "CACHE_GROUPS" => "Y",
    "META_KEYWORDS" => "-",
    "META_DESCRIPTION" => "-",
    "BROWSER_TITLE" => "-",
    "SET_TITLE" => "Y",
    "SET_STATUS_404" => "N",
    "ADD_SECTIONS_CHAIN" => "Y",
    "PRICE_CODE" => array(
    ),
    "USE_PRICE_COUNT" => "N",
    "SHOW_PRICE_COUNT" => "1",
    "PRICE_VAT_INCLUDE" => "Y",
    "PRICE_VAT_SHOW_VALUE" => "N",
    "PRODUCT_PROPERTIES" => array(
    ),
    "USE_PRODUCT_QUANTITY" => "N",
    "LINK_IBLOCK_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "LINK_PROPERTY_SID" => "",
    "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#"
    ),
    false
);?>