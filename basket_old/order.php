<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ќформление заказа");
?>
<?$APPLICATION->IncludeComponent(
	"sk:order.add",
	"",
	Array(
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => $_REQUEST["ID"],
		"strFilter" => "20",
		"ELEMENT_ID" => "20",
		"SECTION_ID" => "20",
		"NEWS_COUNT" => "20",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>