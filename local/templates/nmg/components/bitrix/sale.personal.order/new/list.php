<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($USER -> IsAdmin()) { ?>
<p>На этой странице отображены все Ваши заказы, которые ожидают оплаты.</P><?$APPLICATION->IncludeComponent(
	"sk:personal.order.unpayed",
	"",
	Array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?><?
} else {
	$APPLICATION->IncludeComponent(
		"bitrix:sale.personal.order.list",
		"list",
		array(
			"PATH_TO_DETAIL" => $arResult["PATH_TO_DETAIL"],
			"PATH_TO_CANCEL" => $arResult["PATH_TO_CANCEL"],
			"PATH_TO_COPY" => $arResult["PATH_TO_LIST"].'?ID=#ID#',
			"PATH_TO_BASKET" => $arParams["PATH_TO_BASKET"],
			"SAVE_IN_SESSION" => $arParams["SAVE_IN_SESSION"],
			"ORDERS_PER_PAGE" => 0,
			"SET_TITLE" =>$arParams["SET_TITLE"],
			"ID" => $arResult["VARIABLES"]["ID"],
			"NAV_TEMPLATE" => $arParams["NAV_TEMPLATE"],
		),
		$component
	);
}
?>
