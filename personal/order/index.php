<?
$HIDE_LEFT_COLUMN = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои заказы");
//$_REQUEST["filter_canceled"] = 'Y';
?><?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "new", Array(
	"SEF_MODE" => "N",	// Включить поддержку ЧПУ
	"ORDERS_PER_PAGE" => "20",	// Количество заказов на одной странице
	"PATH_TO_PAYMENT" => "/personal/order/payment/",	// Страница подключения платежной системы
	"PATH_TO_BASKET" => "/basket/order/payment/",	// Страница с корзиной
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"SAVE_IN_SESSION" => "Y",	// Сохранять установки фильтра в сессии пользователя
	"NAV_TEMPLATE" => "",	// Имя шаблона для постраничной навигации
	"PROP_1" => "",	// Не показывать свойства для типа плательщика "Физическое лицо" (s1)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>