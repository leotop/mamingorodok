<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

    $strType = trim($_REQUEST["TYPE"]);
    $strLocation = trim($_REQUEST["LOCATION"]);
    $strTemplate = ($_REQUEST["strTemplate"] == "left-filter-layer1"?$_REQUEST["strTemplate"]:"left-filter");

    if(strpos($_SERVER['HTTP_REFERER'], "mamingorodok.ru") !== false)
    {
        $arTmp = parse_url($_SERVER["HTTP_REFERER"]);
        $APPLICATION->SetCurPage($arTmp["path"], $arTmp["QUERY_STRING"]);

        $APPLICATION->IncludeComponent("individ:catalog.filter", $strTemplate, array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "FILTER_NAME" => "arrLeftFilter",
            "FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "CURRENT_CATALOG_LEVEL" => ($_REQUEST["strTemplate"] == "left-filter-layer1"?1:2),
            "SECTION_ID" => intval($_REQUEST["section_id"]),
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "",
            ),
            "LIST_HEIGHT" => "5",
            "TEXT_WIDTH" => "20",
            "NUMBER_WIDTH" => "5",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "SAVE_IN_SESSION" => "N",
            "PRICE_CODE" => array(
                0 => "Цена для выгрузки на сайт",
            ),
            ),
            false
        );
    ?>
    <script type="text/javascript">
        $(function() {
            $(".filter").jqTransform();
        });
    </script><?
    }
?>