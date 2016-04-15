<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.compare.list", ".default", array(
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
    "AJAX_MODE" => "N",
    "AJAX_OPTION_SHADOW" => "Y",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "DETAIL_URL" => "",
	"CACHE_TYPE" => "N",
 	"CACHE_TIME" => "0",
    "COMPARE_URL" => "compare.php",
    "NAME" => "CATALOG_COMPARE_LIST",
    "AJAX_OPTION_ADDITIONAL" => ""
    ),
    false
);?>

<?echo count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])?>


<?else:?>

    <?CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("Страница не найдена");?>

<?endif?>