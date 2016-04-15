<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("тест");

// if($USER->IsAdmin()){   //arshow($arResult["SECTION"]["ID"]); 
        // if(is_array($arResult["PROPERTIES"]["LIKE"]["VALUE"]))
        // $GLOBALS["arrLikeFilter"]["ID"] = $arResult["PROPERTIES"]["LIKE"]["VALUE"];
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.bigdata.products", 
            "personal_Information", 
            array(
                "RCM_TYPE" => "similar_view",
                "ID" => 11555,
                "IBLOCK_TYPE" => "1c_catalog",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "HIDE_NOT_AVAILABLE" => "Y",
                "SHOW_DISCOUNT_PERCENT" => "Y",
                "PRODUCT_SUBSCRIPTION" => "N",
                "SHOW_NAME" => "Y",
                "SHOW_IMAGE" => "Y",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "PAGE_ELEMENT_COUNT" => "5",
                "LINE_ELEMENT_COUNT" => "5",
                "TEMPLATE_THEME" => "blue",
                "DETAIL_URL" => "",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "SHOW_OLD_PRICE" => "N",
                "PRICE_CODE" => array(
                    0 => "Розничная",
                ),
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "CONVERT_CURRENCY" => "Y",
                "BASKET_URL" => "/personal/cart/",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "SHOW_PRODUCTS_2" => "Y",
                "CURRENCY_ID" => "RUB",
                "PROPERTY_CODE_2" => array(
                    0 => "",
                    1 => "NEWPRODUCT",
                    2 => "MANUFACTURER",
                    3 => "MATERIAL",
                    4 => "COLOR",
                    5 => "OLD_PRICE_VALUE",
                    5 => "PROPERTY_OLD_PRICE_VALUE"
                ),
                "CART_PROPERTIES_2" => array(
                    0 => "",
                    1 => "NEWPRODUCT",
                    2 => "",
                ),
                "ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
                "LABEL_PROP_2" => "-",
                "PROPERTY_CODE_3" => array(
                    0 => "",
                    1 => "COLOR_REF",
                    2 => "SIZES_SHOES",
                    3 => "SIZES_CLOTHES",
                    4 => "OLD_PRICE_VALUE",
                    4 => "PROPERTY_OLD_PRICE_VALUE",
                ),
                "CART_PROPERTIES_3" => array(
                    0 => "",
                    1 => "COLOR_REF",
                    2 => "SIZES_SHOES",
                    3 => "SIZES_CLOTHES",
                    4 => "",
                ),
                "ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
                "OFFER_TREE_PROPS_3" => array(
                ),
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "COMPONENT_TEMPLATE" => "personal_Information",
                "SHOW_FROM_SECTION" => "Y",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "SECTION_ELEMENT_ID" => "",
                "SECTION_ELEMENT_CODE" => "",
                "DEPTH" => ""
            ),
            false
        );
 
?> <?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?> 