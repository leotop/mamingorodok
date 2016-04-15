<?
    $NO_BROAD = true;
    $IS_MAIN = true;

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Детские товары для новорожденных");
    $APPLICATION->SetPageProperty("description", "Каталог товаров для детей и новорожденных в интернет-магазине «МАМИН ГОРОДОК», купить товары для новорожденных по низкой цене с доставкой по Москве.");
    $APPLICATION->SetPageProperty("keywords", "товары для новорожденных в интернет магазине, цены на товары для детей");
    $APPLICATION->SetPageProperty("title", "Купить товары для новорожденных в интернет-магазине в Москве, цена товаров для детей и новорожденных с доставкой");
?>
<?$APPLICATION->IncludeComponent(
	"energosoft:energosoft.nivoslider", 
	"index_slider", 
	array(
		"ES_INCLUDE_JQUERY" => "N",
		"ES_TYPE" => "advertising",
		"ADV_TYPE" => "INDEX_BANNER",
		"ADV_NOINDEX" => "N",
		"ADV_COUNT" => "19",
		"ES_WITDH" => "770",
		"ES_HEIGHT" => "290",
		"ES_THEME" => "default",
		"ES_EFFECT" => "fold",
		"ES_RIBBON" => "",
		"ES_SLICES" => "10",
		"ES_BOXCOLS" => "6",
		"ES_BOXROWS" => "4",
		"ES_ANIMSPEED" => "500",
		"ES_PAUSETIME" => "5000",
		"ES_DIRECTIONNAV" => "N",
		"ES_DIRECTIONNAVHIDE" => "N",
		"ES_CONTROLNAV" => "Y",
		"ES_CONTROLNAVALIGN" => "center",
		"ES_PAUSEONHOVER" => "Y",
		"ES_SHOWCAPTION" => "Y",
		"ES_CAPTIONOPACITY" => "0.8",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"ES_ID" => "_4facd227e1681",
		"COMPONENT_TEMPLATE" => "index_slider"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?> 
<?if ($GLOBALS["APPLICATION"]->GetCurPage() == "/"){
$arrFilterNew = array("PROPERTY_CATALOG_AVAILABLE_VALUE"=>"Y", "PROPERTY_NOVINKA_VALUE"=>"Да");

/*global $USER;
if($USER->IsAdmin()){ */

$APPLICATION->IncludeComponent(
    "bitrix:catalog.top", 
    "main-block_nmg", 
    array(
        "VIEW_MODE" => "BANNER",
        "TEMPLATE_THEME" => "blue",
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "-",
        "LABEL_PROP" => "-",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_CLOSE_POPUP" => "Y",
        "ROTATE_TIMER" => "30",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_COMPARE" => "Сравнить",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "2",
        "ELEMENT_SORT_FIELD" => "rand",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "arrFilterNew",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SEF_MODE" => "N",
        "DISPLAY_COMPARE" => "Y",
        "COMPARE_PATH" => "",
        "CACHE_FILTER" => "N",
        "ELEMENT_COUNT" => "4",
        "LINE_ELEMENT_COUNT" => "4",
        "PROPERTY_CODE" => array(
            0 => "CATALOG_AVAILABLE",
            1 => "AVAILABLE",
            2 => "DISCOUNT",
            3 => "HIT",
            4 => "NOVINKA",
            5 => "",
        ),
        "OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "rand",
        "OFFERS_SORT_FIELD2" => "timestamp_x",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFERS_LIMIT" => "5",
        "PRICE_CODE" => array(
            0 => "base",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(
            0 => "CATALOG_AVAILABLE",
        ),
        "ADD_TO_BASKET_ACTION" => "ADD",
        "USE_PRODUCT_QUANTITY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "HIDE_NOT_AVAILABLE" => "Y",
        "OFFERS_CART_PROPERTIES" => array(
        ),
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "COMPONENT_TEMPLATE" => "main-block_nmg",
        "SHOW_PAGINATION" => "Y"
    ),
    false
);    

$arrFilterNew = array("PROPERTY_CATALOG_AVAILABLE_VALUE"=>"Y", "PROPERTY_KHIT_PRODAZH_VALUE"=>"Да");

$APPLICATION->IncludeComponent(
    "bitrix:catalog.top", 
    "main-block_nmg", 
    array(
        "VIEW_MODE" => "BANNER",
        "TEMPLATE_THEME" => "blue",
        "PRODUCT_DISPLAY_MODE" => "N",
        "ADD_PICT_PROP" => "-",
        "LABEL_PROP" => "-",
        "SHOW_DISCOUNT_PERCENT" => "N",
        "SHOW_OLD_PRICE" => "N",
        "SHOW_CLOSE_POPUP" => "Y",
        "ROTATE_TIMER" => "30",
        "MESS_BTN_BUY" => "Купить",
        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
        "MESS_BTN_DETAIL" => "Подробнее",
        "MESS_BTN_COMPARE" => "Сравнить",
        "MESS_NOT_AVAILABLE" => "Нет в наличии",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "2",
        "ELEMENT_SORT_FIELD" => "rand",
        "ELEMENT_SORT_ORDER" => "asc",
        "ELEMENT_SORT_FIELD2" => "name",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "arrFilterNew",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SEF_MODE" => "N",
        "DISPLAY_COMPARE" => "Y",
        "COMPARE_PATH" => "",
        "CACHE_FILTER" => "N",
        "ELEMENT_COUNT" => "4",
        "LINE_ELEMENT_COUNT" => "4",
        "PROPERTY_CODE" => array(
            0 => "CATALOG_AVAILABLE",
            1 => "AVAILABLE",
            2 => "DISCOUNT",
            3 => "HIT",
            4 => "NOVINKA",
            5 => "",
        ),
        "OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "rand",
        "OFFERS_SORT_FIELD2" => "timestamp_x",
        "OFFERS_SORT_ORDER2" => "desc",
        "OFFERS_LIMIT" => "5",
        "PRICE_CODE" => array(
            0 => "base",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(
            0 => "CATALOG_AVAILABLE",
        ),
        "ADD_TO_BASKET_ACTION" => "ADD",
        "USE_PRODUCT_QUANTITY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "HIDE_NOT_AVAILABLE" => "Y",
        "OFFERS_CART_PROPERTIES" => array(
        ),
        "CONVERT_CURRENCY" => "Y",
        "CURRENCY_ID" => "RUB",
        "COMPONENT_TEMPLATE" => "main-block_nmg",
        "SHOW_PAGINATION" => "Y"
    ),
    false
); 


//}?>
<?}?>
<? /* ?>
<section class="special_offer"> 
    <h1 class="oh3" style="margin-left:25px;">Детские товары для новорожденных</h1>
    <br><br>
    <a href="/catalog/show-special/?prop=NOVINKA" > 
        <p class="oh3" style="margin-left:25px;">Новинки</p>
    </a> <?
        global $shieldFilter;
        $shieldFilter=array("PROPERTY_NOVINKA_VALUE" => 'Да', "PROPERTY_CATALOG_AVAILABLE_VALUE" => 'Y', "!PREVIEW_PICTURE"=>false);
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.top", 
            "main-block_nmg_new", 
            array(
                "VIEW_MODE" => "SECTION",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_OLD_PRICE" => "N",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "SHOW_CLOSE_POPUP" => "N",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "ELEMENT_SORT_FIELD" => "rand",
                "ELEMENT_SORT_ORDER" => "desc",
                "FILTER_NAME" => "shieldFilter",
                "SECTION_URL" => "",
                "DETAIL_URL" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "40",
                "LINE_ELEMENT_COUNT" => "1",
                "PROPERTY_CODE" => array(
                    0 => "ACTION",
                    1 => "NOVINKA",
                    2 => "RASPRODAZHA",
                    3 => "KHIT_PRODAZH",
                    4 => "",
                ),
                "OFFERS_LIMIT" => "5",
                "PRICE_CODE" => array(
                    0 => "Цена для выгрузки на сайт",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "BASKET_URL" => "/personal/basket.php",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "USE_PRODUCT_QUANTITY" => "N",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRODUCT_PROPERTIES" => array(
                ),
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "HIDE_NOT_AVAILABLE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "TEMPLATE_THEME" => "blue",
                "ADD_PICT_PROP" => "-",
                "LABEL_PROP" => "-",
                "MESS_BTN_COMPARE" => "Сравнить",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER2" => "desc",
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
                "OFFERS_CART_PROPERTIES" => array(
                ),
                "PRODUCT_DISPLAY_MODE" => "N",
                "CACHE_NOTES" => "",
                "COMPONENT_TEMPLATE" => "main-block_nmg_new",
                "SEF_MODE" => "N"
            ),
            false
    );?> <a href="/catalog/show-special/?prop=NOVINKA" >Все новинки</a> </section> <section class="special_offer"> <a href="/catalog/show-special/?prop=KHIT_PRODAZH" > 
        <p class="oh3" style="margin-left:25px;">Хит продаж</p>
    </a> <?
        $shieldFilter=array("PROPERTY_KHIT_PRODAZH_VALUE" => 'Да', "PROPERTY_CATALOG_AVAILABLE_VALUE" => 'Y', "!PREVIEW_PICTURE"=>false);
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.top", 
            "main-block_nmg_new", 
            array(
                "VIEW_MODE" => "SECTION",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_OLD_PRICE" => "N",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "SHOW_CLOSE_POPUP" => "N",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "ELEMENT_SORT_FIELD" => "rand",
                "ELEMENT_SORT_ORDER" => "desc",
                "FILTER_NAME" => "shieldFilter",
                "SECTION_URL" => "",
                "DETAIL_URL" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "40",
                "LINE_ELEMENT_COUNT" => "1",
                "PROPERTY_CODE" => array(
                    0 => "ACTION",
                    1 => "NOVINKA",
                    2 => "RASPRODAZHA",
                    3 => "KHIT_PRODAZH",
                    4 => "",
                ),
                "OFFERS_LIMIT" => "5",
                "PRICE_CODE" => array(
                    0 => "Цена для выгрузки на сайт",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "BASKET_URL" => "/personal/basket.php",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "USE_PRODUCT_QUANTITY" => "N",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRODUCT_PROPERTIES" => array(
                ),
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "HIDE_NOT_AVAILABLE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "TEMPLATE_THEME" => "blue",
                "ADD_PICT_PROP" => "-",
                "LABEL_PROP" => "-",
                "MESS_BTN_COMPARE" => "Сравнить",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER2" => "desc",
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
                "OFFERS_CART_PROPERTIES" => array(
                ),
                "COMPONENT_TEMPLATE" => "main-block_nmg_new",
                "SEF_MODE" => "N"
            ),
            false
    );?> <a href="/catalog/show-special/?prop=KHIT_PRODAZH" >Все хиты продаж</a> </section> 

<?
    $arSelect = Array("ID", "NAME");
    $arFilter = Array("IBLOCK_ID"=>2, "PROPERTY_RASPRODAZHA_VALUE" => 'Да', "!PREVIEW_PICTURE"=>false, "PROPERTY_CATALOG_AVAILABLE_VALUE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    if ($res->SelectedRowsCount() > 0) {
        $Element_curent = "Y";
    }

?> 
<?if($Element_curent == "Y"){?>

    <section class="special_offer"> <a href="/catalog/show-special/?prop=RASPRODAZHA" > 

            <p class="oh3" style="margin-left:25px;">Распродажа</p>
        </a> <?
            $shieldFilter=array("PROPERTY_RASPRODAZHA_VALUE" => 'Да', "!PREVIEW_PICTURE"=>false, "PROPERTY_CATALOG_AVAILABLE_VALUE" => "Y");
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.top", 
                "main-block_nmg_new", 
                array(
                    "VIEW_MODE" => "SECTION",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "SHOW_CLOSE_POPUP" => "N",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "2",
                    "ELEMENT_SORT_FIELD" => "rand",
                    "ELEMENT_SORT_ORDER" => "desc",
                    "FILTER_NAME" => "shieldFilter",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "DISPLAY_COMPARE" => "N",
                    "ELEMENT_COUNT" => "40",
                    "LINE_ELEMENT_COUNT" => "1",
                    "PROPERTY_CODE" => array(
                        0 => "CATALOG_AVAILABLE",
                        1 => "ACTION",
                        2 => "NOVINKA",
                        3 => "RASPRODAZHA",
                        4 => "KHIT_PRODAZH",
                        5 => "",
                    ),
                    "OFFERS_LIMIT" => "5",
                    "PRICE_CODE" => array(
                        0 => "Цена для выгрузки на сайт",
                    ),
                    "USE_PRICE_COUNT" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "BASKET_URL" => "/personal/basket.php",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRODUCT_PROPERTIES" => array(
                    ),
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "N",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "CONVERT_CURRENCY" => "Y",
                    "TEMPLATE_THEME" => "blue",
                    "ADD_PICT_PROP" => "-",
                    "LABEL_PROP" => "-",
                    "MESS_BTN_COMPARE" => "Сравнить",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER2" => "desc",
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
                    "OFFERS_CART_PROPERTIES" => array(
                    ),
                    "COMPONENT_TEMPLATE" => "main-block_nmg_new",
                    "SEF_MODE" => "N",
                    "CURRENCY_ID" => "RUB"
                ),
                false
            );?> <a href="/catalog/show-special/?prop=RASPRODAZHA" >Все товары со скидкой</a> 
    </section> 
    <?}?>
*/?>
    
<br clear="all" />

<br />
<?$APPLICATION->IncludeComponent(
    "bitrix:blog.blog",
    "blog_news_nmg",
    Array(
        "YEAR" => $year,
        "MONTH" => $month,
        "DAY" => $day,
        "CATEGORY_ID" => $category,
        "BLOG_URL" => "blog_news",
        "FILTER_NAME" => "",
        "MESSAGE_COUNT" => "6",
        "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
        "NAV_TEMPLATE" => "",
        "IMAGE_MAX_WIDTH" => "600",
        "IMAGE_MAX_HEIGHT" => "600",
        "PATH_TO_BLOG" => "/community/group/",
        "PATH_TO_BLOG_CATEGORY" => "",
        "PATH_TO_POST" => "/community/group/#blog#/#post_id#/",
        "PATH_TO_POST_EDIT" => "",
        "PATH_TO_USER" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_TIME_LONG" => "3600",
        "PATH_TO_SMILE" => "/bitrix/images/blog/smile/",
        "SET_NAV_CHAIN" => "N",
        "SET_TITLE" => "N",
        "POST_PROPERTY_LIST" => array(),
        "SHOW_RATING" => "N",
        "BLOG_VAR" => "",
        "POST_VAR" => "",
        "USER_VAR" => "",
        "PAGE_VAR" => ""
    )
    );?> 
    
<p class="about_err">Сообщить об ошибке: выделить текст и нажать Ctrl+Enter</p>

 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>