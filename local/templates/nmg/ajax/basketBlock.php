<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "template1", Array(
    "PATH_TO_BASKET" => "/basket/",    // Страница корзины
        "PATH_TO_ORDER" => "/basket/order/",    // Страница оформления заказа
        "SHOW_DELAY" => "Y",    // Показывать отложенные товары
        "SHOW_NOTAVAIL" => "Y",    // Показывать товары, недоступные для покупки
        "SHOW_SUBSCRIBE" => "Y",    // Показывать товары, на которые подписан покупатель
    ),
    false
);?>