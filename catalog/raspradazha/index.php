<?
    $showSravn = true;
    $HIDE_LEFT_COLUMN = true;
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    $APPLICATION->SetTitle("Распродажа");                   
?> 
<div class="news">
    <? 
        global $arrFilterSpecial;
        $arrFilterSpecial["!PROPERTY_RASPRODAZHA"] = false;
    ?>
    <?
        $APPLICATION->IncludeComponent("kombox:filter", "catalog_filter", Array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => 2,
            "FILTER_NAME" => "arrFilterSpecial",
            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SAVE_IN_SESSION" => "N",
            "INCLUDE_JQUERY" => "N",
            "MESSAGE_ALIGN" => "LEFT",
            "MESSAGE_TIME" => "5",
            "CLOSED_PROPERTY_CODE" => array(),
            "CLOSED_OFFERS_PROPERTY_CODE" => array(),
            "SORT" => "N",
            "SORT_ORDER" => "ASC",
            "FIELDS" => array(),
            "PRICE_CODE" => array( 
                0 => "Цена для выгрузки на сайт",
            ),
            "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
            "XML_EXPORT" => "Y",
            "SECTION_TITLE" => "NAME",
            "SECTION_DESCRIPTION" => "DESCRIPTION",
            "IS_SEF" => "Y",
            "SEF_BASE_URL" => "/catalog/rasprodazha/",
            "SECTION_PAGE_URL" => "#SECTION_CODE#/",
            "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
            ),
            false
        ); 
    ?>
    <?if (CModule::IncludeModule("iblock"))
        {
            $arFilter = array(
                "ACTIVE" => "Y",
                "GLOBAL_ACTIVE" => "Y",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            );
            if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
            {
                $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
            }
            elseif($arResult["VARIABLES"]["SECTION_ID"]>0)
            {
                $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
            }

            $obCache = new CPHPCache;
            if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
            {
                $arCurSection = $obCache->GetVars();
            }
            else
            {
                $arCurSection = array();
                $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
                $dbRes = new CIBlockResult($dbRes);

                if(defined("BX_COMP_MANAGED_CACHE"))
                {
                    global $CACHE_MANAGER;
                    $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                    if ($arCurSection = $dbRes->GetNext())
                    {
                        $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
                    }
                    $CACHE_MANAGER->EndTagCache();
                }
                else
                {
                    if(!$arCurSection = $dbRes->GetNext())
                        $arCurSection = array();
                }

                $obCache->EndDataCache($arCurSection);
            }    arshow($arParams);
        }      
    ?>

    <?
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section", 
            "rasprodazha", 
            array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "ELEMENT_SORT_FIELD" => "NAME",
                "ELEMENT_SORT_ORDER" => "asc",
                "PAGE_ELEMENT_COUNT" => "32",
                "INCLUDE_SUBSECTIONS" => "Y",
                "LINE_ELEMENT_COUNT" => "4",
                "FILTER_NAME" => "arrFilterSpecial",
                "PROPERTY_CODE" => array(
                    0 => "ACTION",
                    1 => "RATING",
                    2 => "DISCOUNT",
                    3 => "HIT",
                    4 => "NOVINKA",
                    5 => "OLD_PRICE",
                    6 => "PRICE",
                    7 => "WISHES",
                    8 => "NOVINKA",
                    9 => "",
                ),
                "SECTION_URL" => "",
                "DETAIL_URL" => "",
                "BASKET_URL" => "/personal/basket.php",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "CACHE_FILTER" => "Y",
                "DISPLAY_COMPARE" => "N",
                "PRICE_CODE" => array(
                    0 => "Цена для выгрузки на сайт",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_PROPERTIES" => array(
                ),
                "USE_PRODUCT_QUANTITY" => "N",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "SHOW_ALL_WO_SECTION" => "Y",
                "SEARCH" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "META_KEYWORDS" => "-",
                "META_DESCRIPTION" => "-",
                "BROWSER_TITLE" => "-",
                "ADD_SECTIONS_CHAIN" => "N",
                "SET_TITLE" => "Y",
                "SET_STATUS_404" => "N",
                "PAGER_TEMPLATE" => ".default",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "PAGER_TITLE" => "Товары",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
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
                "OFFERS_CART_PROPERTIES" => array(
                ),
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER2" => "desc",
                "HIDE_NOT_AVAILABLE" => "N",
                "OFFERS_SORT_FIELD2" => "id",
                "OFFERS_SORT_ORDER2" => "desc",
                "OFFERS_LIMIT" => "5",
                "SET_BROWSER_TITLE" => "Y",
                "SET_META_KEYWORDS" => "Y",
                "SET_META_DESCRIPTION" => "Y",
                "CONVERT_CURRENCY" => "N",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PARTIAL_PRODUCT_PROPERTIES" => "N"
            ),
            false
        );

        $content = ob_get_contents();

        if(isset($GLOBALS["ALLELEMENT"]))
        {
            $allelement = $GLOBALS["ALLELEMENT"];

            unset($GLOBALS["ALLELEMENT"]);
            foreach($allelement as $k=>$v)
            {
                $result = CacheRatingReviews::GetByID($v);

                if(is_array($result))
                {
                    $count = $result["FORUM_MESSAGE_CNT"];
                    if($count>0)
                        $textR = '<i title="'.$result["DETAIL_PAGE_URL"].'#reports" class="comment grey">'.$count.' '.RevirewsLang($count,true).'</i>';
                    else $textR = '<i title="'.$result["DETAIL_PAGE_URL"].'#comment" class="comment grey">'.RevirewsLang($count,true).'</i>';

                    $content = str_replace('#REPORT_COUNT_'.$v.'#', $textR, $content); 
                }
            }
        }

        ob_end_clean();

        echo $content;
        //nclude($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/nmg/components/bitrix/catalog/test/section.php")
    ?> 
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
