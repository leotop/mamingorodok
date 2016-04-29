<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixBasketComponent $component */
    $curPage = $APPLICATION->GetCurPage().'?'.$arParams["ACTION_VARIABLE"].'=';
    $arUrls = array(
        "delete" => $curPage."delete&id=#ID#",
        "delay" => $curPage."delay&id=#ID#",
        "add" => $curPage."add&id=#ID#",
    );
    unset($curPage);

    $arBasketJSParams = array(
        'SALE_DELETE' => GetMessage("SALE_DELETE"),
        'SALE_DELAY' => GetMessage("SALE_DELAY"),
        'SALE_TYPE' => GetMessage("SALE_TYPE"),
        'TEMPLATE_FOLDER' => $templateFolder,
        'DELETE_URL' => $arUrls["delete"],
        'DELAY_URL' => $arUrls["delay"],
        'ADD_URL' => $arUrls["add"]
    );
?>     



    
    

<script type="text/javascript">
    var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
    $APPLICATION->AddHeadScript($templateFolder."/script.js");

    if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
    {
    ?>
    <div id="warning_message">
        <?
            if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
            {
                foreach ($arResult["WARNING_MESSAGE"] as $v)
                    ShowError($v);
            }
        ?>
    </div>
    <?

        $normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
        $normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

        $delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
        $delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

        $subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
        $subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

        $naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
        $naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

    ?>
    <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
        <div id="basket_form_container">
            <div class="bx_ordercart">
                <div class="bx_sort_container">
                    <a href="javascript:void(0)" id="basket_toolbar_button" class="current" onclick="showBasketItemsList()"><?=GetMessage("SALE_BASKET_ITEMS")?><div id="normal_count" class="flat" style="display:none">&nbsp;(<?=$normalCount?>)</div></a>
                    <a href="javascript:void(0)" id="basket_toolbar_button_delayed" onclick="showBasketItemsList(2)" <?=$delayHidden?>><?=GetMessage("SALE_BASKET_ITEMS_DELAYED")?><div id="delay_count" class="flat">&nbsp;(<?=$delayCount?>)</div></a>
                    <a href="javascript:void(0)" id="basket_toolbar_button_subscribed" onclick="showBasketItemsList(3)" <?=$subscribeHidden?>><?=GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?><div id="subscribe_count" class="flat">&nbsp;(<?=$subscribeCount?>)</div></a>
                    <a href="javascript:void(0)" id="basket_toolbar_button_not_available" onclick="showBasketItemsList(4)" <?=$naHidden?>><?=GetMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?><div id="not_available_count" class="flat">&nbsp;(<?=$naCount?>)</div></a>
                </div>
                <?
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
                    include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
                ?>
                <div class="notificationForm">
                    <table class="notificationTable">
                        <tr>
                            <td>
                                Информирование о заказе
                            </td>
                            <td>
                                <?/*<label class="custom-radio"><input name="reg-check" id="sms-noti" value="1" type="checkbox"/><div></div><p>SMS-оповещение</p> </label> */?>  
                                <label class="custom-radio"><input name="reg-check" id="mail-noti" value="1" type="checkbox"/><div></div><p>Электронная почта</p> </label>   
                                <label class="custom-radio"><input name="reg-check" id="call-noti" value="1" type="checkbox"/><div></div><p>Звонок оператора</p> </label>   

                            </td>
                        </tr>
                    </table>
                </div>     
            </div>
        </div>
        <input type="hidden" name="BasketOrder" value="BasketOrder" />
         <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> 
    </form>
    <?
    }
    else
    {
        ShowError($arResult["ERROR_MESSAGE"]);
    }
?>


<?
global $USER;
if($USER->IsAdmin()){
   // arshow($arResult["ITEMS"]["AnDelCanBuy"][0]["CATALOG"]["ID"],true);
     //$arrFilter = array("PROPERTY_CATALOG_AVAILABLE_VALUE"=>"Y", "PROPERTY_NOVINKA_VALUE"=>"Да");
$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", "personal_Basket_BigData", Array(
	"RCM_TYPE" => "personal",	// Тип рекомендации
		"ID" => $arResult["ITEMS"]["AnDelCanBuy"][0]["ID"],	// Параметр ID продукта (для товарных рекомендаций)
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"IBLOCK_ID" => "2",	// Инфоблок
		"HIDE_NOT_AVAILABLE" => "Y",	// Не отображать товары, которых нет на складах
		"SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
		"PRODUCT_SUBSCRIPTION" => "N",	// Разрешить оповещения для отсутствующих товаров
		"SHOW_NAME" => "Y",	// Показывать название
		"SHOW_IMAGE" => "Y",	// Показывать изображение
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
		"PAGE_ELEMENT_COUNT" => "15",	// Количество элементов на странице
		"LINE_ELEMENT_COUNT" => "5",	// Количество элементов, выводимых в одной строке
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"SHOW_OLD_PRICE" => "N",	// Показывать старую цену
        "FILTER_NAME" => "arrFilter",
		"PRICE_CODE" => array(	// Тип цены
			0 => "Цена для выгрузки на сайт",
		),
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"CONVERT_CURRENCY" => "Y",	// Показывать цены в одной валюте
		"BASKET_URL" => "/personal/cart/",	// URL, ведущий на страницу с корзиной покупателя
		"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить частично заполненные свойства
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
		"SHOW_PRODUCTS_2" => "Y",	// Показывать товары каталога
		"CURRENCY_ID" => "RUB",	// Валюта, в которую будут сконвертированы цены
		"PROPERTY_CODE_2" => array(	// Свойства для отображения
			0 => "",
			1 => "NEWPRODUCT",
			2 => "MANUFACTURER",
			3 => "MATERIAL",
			4 => "COLOR",
			5 => "PROPERTY_OLD_PRICE_VALUE",
			6 => "",
		),
		"CART_PROPERTIES_2" => array(	// Свойства для добавления в корзину
			0 => "",
			1 => "NEWPRODUCT",
			2 => "",
		),
		"ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",	// Дополнительная картинка
		"LABEL_PROP_2" => "-",	// Свойство меток товара
		"PROPERTY_CODE_3" => array(	// Свойства для отображения
			0 => "",
			1 => "COLOR_REF",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "PROPERTY_OLD_PRICE_VALUE",
			5 => "",
		),
		"CART_PROPERTIES_3" => array(	// Свойства для добавления в корзину
			0 => "",
			1 => "COLOR_REF",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "",
		),
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",	// Дополнительная картинка
		"OFFER_TREE_PROPS_3" => "",	// Свойства для отбора предложений
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"COMPONENT_TEMPLATE" => ".default",
		"SHOW_FROM_SECTION" => "Y",	// Показывать товары из раздела
		"SECTION_ID" => "",	// ID раздела
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_ELEMENT_ID" => "",	// ID элемента, для которого будет выбран раздел
		"SECTION_ELEMENT_CODE" => "",	// Символьный код элемента, для которого будет выбран раздел
		"DEPTH" => "",	// Максимальная отображаемая глубина разделов
	),
	false
);
/*$APPLICATION->IncludeComponent(
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
        "FILTER_NAME" => "arrFilterBasket",
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
);*/ 
}
?>
