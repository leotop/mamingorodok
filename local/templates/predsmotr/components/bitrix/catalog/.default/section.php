<?

//arshow($_REQUEST);
$APPLICATION->IncludeComponent("energosoft:energosoft.nivoslider", "index_slider", array(
		"ES_INCLUDE_JQUERY" => "N",
		"ES_TYPE" => "advertising",
		"ADV_TYPE" => "INDEX_BANNER",
		"ADV_NOINDEX" => "N",
		"ADV_COUNT" => "7",
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
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
		"ES_ID" => "_4facd227e1681"
	),
	false
);?><?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");


if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
{
	$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arResult["VARIABLES"]["SECTION_CODE"], "ACTIVE"=>"Y"), false);
	if($arS = $rsS -> GetNext()) {
		if($arS["DEPTH_LEVEL"] == 1) {
			if(isset($_REQUEST["propertyCode"])) { // || isset($_REQUEST["producerCode"])
				ShowError("������ �� ������");
				@define("ERROR_404", "Y");
				if($arParams["SET_STATUS_404"]==="Y")
					CHTTP::SetStatus("404 Not Found");
				return;
			}
		}

		$arResult["VARIABLES"]["SECTION_ID"] = $arS["ID"];
	} else $arResult["VARIABLES"]["SECTION_ID"] = -1;
} else $arResult["VARIABLES"]["SECTION_ID"] = -1;

if($arResult["VARIABLES"]["SECTION_ID"] == -1 && !isset($_REQUEST["brendCode"])) {
	ShowError("������ �� ������");
	@define("ERROR_404", "Y");
	if($arParams["SET_STATUS_404"]==="Y")
		CHTTP::SetStatus("404 Not Found");
	return;
}

if($arS["DEPTH_LEVEL"] == 1 && !isset($_REQUEST["set_filter"]) && $arS["ID"] != 432)
{
	// ��������� ������������ �� ������
	$rsSection = CIBlockSectionCache::GetList(array(),  array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "SECTION_ID"=>$arResult["VARIABLES"]["SECTION_ID"]), false, array("NAME","UF_DESCR_TITLE","UF_DESCR_TITLE"));
	if(count($rsSection)>0) $IS_PARENT_SECTION = true;
		
	$rsSection = CIBlockSectionCache::GetList(array(),  array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ID"=>$arResult["VARIABLES"]["SECTION_ID"]), false, array("NAME","UF_DESCR_TITLE","UF_DESCR_TITLE"));
	if(count($rsSection)>0)
	{
		$arSect = $rsSection[0];
		$CURRENT_SECTION_NAME = $arSect["NAME"];
		$CURRENT_SECTION_DESCRIPTION = $arSect["DESCRIPTION"];
		$CURRENT_SECTION_DESCRIPTION_TITLE = $arSect["UF_DESCR_TITLE"];
		$APPLICATION->AddChainItem($CURRENT_SECTION_NAME);
	}

	?><?$APPLICATION->IncludeComponent(
	"bitrix:advertising.banner",
	"catalog_depth_1",
	Array(
		"TYPE" => "CATALOG_DEPTH_1",
		"NOINDEX" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0"
	),
false
);?><?
	
	$arResultTMP = array();
	$rsSec = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME" => "ASC"), array("IBLOCK_ID"=>$arS["IBLOCK_ID"], "ACTIVE"=>"Y", "SECTION_ID"=>$arS["ID"], "DEPTH_LEVEL"=>2), false, array("UF_*"));
	while($arSec = $rsSec -> GetNext())
		$arResultTMP[] = $arSec;
	
	if(count($arResultTMP)>0)
	{
		$intColPerLine = 4;
		$intCnt = 0;
		$arTd = array();
		?>
<table class="catalogLevel1"><?
		foreach($arResultTMP as $arSec)
		{
			if($intCnt>0 && $intCnt%4==0)
			{
				echo '<tr>'.implode(" ", $arTd["TITLE"]).'</tr><tr>'.implode(" ", $arTd["PICTURE"]).'</tr><tr>'.implode(" ", $arTd["LINKS"]).'</tr><tr class="catalogLevel1Spacer"><td colspan="100%"></td></tr>';
				$arTd = array();
				$intCnt = 0;
			}
			
			$arTd["TITLE"][] = '<td class="title'.($intCnt==3?' last':'').'"><a href="'.$arSec["SECTION_PAGE_URL"].'" title="'.$arSec["NAME"].'">'.smart_trim($arSec["NAME"], 35).'</a></td>';
			$arTd["PICTURE"][] = '<td class="picture'.($intCnt==3?' last':'').'">'.($arSec["PICTURE"]>0?'<a href="'.$arSec["SECTION_PAGE_URL"].'"><img src="'.CFile::GetPath($arSec["PICTURE"]).'" alt="'.$arSec["NAME"].'"></a>':'&nbsp;').'</td>';
			$strLinks = '';
			if(count($arSec["UF_LINK_TEXT"])>0)
			{
				foreach($arSec["UF_LINK_TEXT"] as $intTextCnt => $strText)
				{
					$strTextCutted = smart_trim($strText, 25);
					if($arSec["UF_LINK_HREF"][$intTextCnt] != '')
						$strLinks .= '<a href="'.$arSec["UF_LINK_HREF"][$intTextCnt].'" title="'.$strText.'">'.$strTextCutted.'</a>&nbsp;�<br>';
					else $strLinks .= $strTextCutted.'<br>';
				}
			}
			
			$arTd["LINKS"][] = '<td class="links'.($intCnt==3?' last':'').'">'.$strLinks.'</td>';
			$intCnt++;
		}

		if(count($arTd)>0)
		{
			for($i=$intCnt;$i<4;$i++)
			{
				$arTd["TITLE"][] = '<td class="noborder '.($i==3?'last':'').'">&nbsp;</td>';
				$arTd["PICTURE"][] = '<td class="noborder '.($i==3?'last':'').'">&nbsp;</td>';
				$arTd["LINKS"][] = '<td class="noborder '.($i==3?'last':'').'">&nbsp;</td>';
			}

			echo '<tr>'.implode(" ", $arTd["TITLE"]).'</tr><tr>'.implode(" ", $arTd["PICTURE"]).'</tr><tr>'.implode(" ", $arTd["LINKS"]).'</tr>';
		}?>
</table><?
	}
	
	$arFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ID' =>$arResult["VARIABLES"]["SECTION_ID"]);
	$rsSection = CIBlockSectionCache::GetList(array(), $arFilter, false, array("UF_TITLE","UF_DESCRIPTION","UF_KEYWORDS"));
	if(count($rsSection)==1)
		$arResult["META"] = $rsSection[0];
		
	 if(isset($arResult["META"]["UF_TITLE"]) && !empty($arResult["META"]["UF_TITLE"]))
	 {
		$APPLICATION->SetPageProperty("headertitle",$arResult["META"]["UF_TITLE"]);
		$APPLICATION->SetPageProperty("title",$arResult["META"]["UF_TITLE"]);
		$APPLICATION->SetTitle($arResult["META"]["UF_TITLE"]);
	 } else  $APPLICATION->SetPageProperty("headertitle",$CURRENT_SECTION_NAME);
	 
	if(isset($arResult["META"]["UF_KEYWORDS"]) && !empty($arResult["META"]["UF_KEYWORDS"]))
		$APPLICATION->SetPageProperty("keywords",$arResult["META"]["UF_KEYWORDS"]);
	
	if(isset($arResult["META"]["UF_DESCRIPTION"]) && !empty($arResult["META"]["UF_DESCRIPTION"]))
		$APPLICATION->SetPageProperty("description",$arResult["META"]["UF_DESCRIPTION"]);
} else {
	// ��������� ������������ �� ������

	$rsSection = CIBlockSectionCache::GetList(array(),  array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "SECTION_ID"=>$arResult["VARIABLES"]["SECTION_ID"]), false, array("NAME","UF_DESCR_TITLE","UF_DESCR_TITLE"));
	if(count($rsSection)>0) $IS_PARENT_SECTION = true;

	$rsSection = CIBlockSectionCache::GetList(array(),  array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ID"=>$arResult["VARIABLES"]["SECTION_ID"]), false, array("NAME","UF_DESCR_TITLE","UF_DESCR_TITLE"));
	if(count($rsSection)>0)
	{
		$arSect = $rsSection[0];
		$CURRENT_SECTION_NAME = $arSect["NAME"];
	    $CURRENT_SECTION_DESCRIPTION = $arSect["DESCRIPTION"];
	    $CURRENT_SECTION_DESCRIPTION_TITLE = $arSect["UF_DESCR_TITLE"];
	}

if ($IS_PARENT_SECTION && !isset($_REQUEST["set_filter"])) // empty($GLOBALS["arrLeftFilter"])
{
	echo '<br>';
	$APPLICATION->AddChainItem($CURRENT_SECTION_NAME);
	$GLOBALS["arrFilterNew"]["PROPERTY_NEW_VALUE"] = "Y";
	?><?$APPLICATION->IncludeComponent("bitrix:catalog.section", "main-block-new", array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	   // "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"ELEMENT_SORT_FIELD" => "PROPERTY_NEW",
		"ELEMENT_SORT_ORDER" => "desc",
		"PAGE_ELEMENT_COUNT" => "8",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LINE_ELEMENT_COUNT" => "4",
		"FILTER_NAME" => "arrFilterNew",
		"PROPERTY_CODE" => array(
			0 => "NEW",
			1 => "PRICE",
			2 => "OLD_PRICE",
			3 => "WISHES",
			4 => "RATING",
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
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER"=>"Y",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N"
		),
		false
	);?>
   <? $GLOBALS["arrFilterDiscount"][">PROPERTY_OLD_PRICE"] = "0";?>
	<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "main-block-sk", array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		//"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"ELEMENT_SORT_FIELD" => "PROPERTY_NEW",
		"ELEMENT_SORT_ORDER" => "desc",
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGE_ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "4",
		"FILTER_NAME" => "arrFilterDiscount",
		"PROPERTY_CODE" => array(
			0 => "NEW",
			1 => "PRICE",
			2 => "OLD_PRICE",
			3 => "WISHES",
			4 => "RATING",
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
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER"=>"Y",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N"
		),
		false
	);?>
	<?$GLOBALS["arrFilterPopular"][">PROPERTY_SALES_RATING"] = "0";?>
	<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "main-block-tovar", array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		//"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"ELEMENT_SORT_FIELD" => "PROPERTY_SALES_RATING",
		"INCLUDE_SUBSECTIONS" => "Y",
		"ELEMENT_SORT_ORDER" => "desc",
		"PAGE_ELEMENT_COUNT" => "8",
		"LINE_ELEMENT_COUNT" => "4",
		"FILTER_NAME" => "arrFilterPopular",
		"PROPERTY_CODE" => array(
			0 => "NEW",
			1 => "PRICE",
			2 => "OLD_PRICE",
			3 => "WISHES",
			4 => "RATING",
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
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER"=>"Y",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "N"
		),
		false
	);?>
	<?$GLOBALS["arrFilterProducers"]["PROPERTY_PROMOBLOCK_LINK"] = $arResult["VARIABLES"]["SECTION_ID"];?>
	<?$APPLICATION->IncludeComponent("bitrix:news.list", "producers.list", array(
		//"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "5",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arrFilterProducers",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_SHADOW" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER"=>"Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "�������",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"AJAX_OPTION_ADDITIONAL" => ""
		),
		false
	);?><?
	if (strlen($CURRENT_SECTION_DESCRIPTION) > 0)
	{?>
		<div class="goods">
			<h2><?=$CURRENT_SECTION_DESCRIPTION_TITLE?></h2>
			<div class="description">
				<?=$CURRENT_SECTION_DESCRIPTION?>
			</div>
		</div><?
	}
	
	$arFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], 'ID' =>$arResult["VARIABLES"]["SECTION_ID"]);
	$rsSection = CIBlockSectionCache::GetList(array(), $arFilter, false, array("UF_TITLE","UF_DESCRIPTION","UF_KEYWORDS"));
	if(count($rsSection)==1)
		$arResult["META"] = $rsSection[0];
	
	 if(isset($arResult["META"]["UF_TITLE"]) && !empty($arResult["META"]["UF_TITLE"]))
		$APPLICATION->SetPageProperty("headertitle",$arResult["META"]["UF_TITLE"]);

	if(isset($arResult["META"]["UF_KEYWORDS"]) && !empty($arResult["META"]["UF_KEYWORDS"]))
		$APPLICATION->SetPageProperty("keywords",$arResult["META"]["UF_KEYWORDS"]);
	
	if(isset($arResult["META"]["UF_DESCRIPTION"]) && !empty($arResult["META"]["UF_DESCRIPTION"]))
		$APPLICATION->SetPageProperty("description",$arResult["META"]["UF_DESCRIPTION"]);
} else {  // ���� ��������� �������
	if(!empty($_REQUEST["orderby"]))
		$orderby = $_REQUEST["orderby"];
	else $orderby = "SORT";

	if(!empty($_REQUEST["sort"]))
		$sort = $_REQUEST["sort"];
	else $sort = "ASC";

    //echo "test" ;
    //global $arrLeftFilter; 
    //arshow($arrLeftFilter);
    
	ob_start();?>
<?$APPLICATION->IncludeComponent(
		"individ:catalog.section",
		"",
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => $orderby,
			"ELEMENT_SORT_ORDER" => $sort,
			 "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"FILTER_NAME" => "arrLeftFilter", //$arParams["FILTER_NAME"],
			"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => "Y",
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
	
			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
	
			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
	
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
	
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"ADD_SECTIONS_CHAIN" => "Y",
		   "BY_LINK" => empty($_REQUEST["brendCode"])?'':'Y'
			//"SEARCH" => ($_REQUEST["set_filter"]=="Y"?"Y":"")
		),
		$component
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
}

// ����������� ����� ��� �������, ������� � ������ ���������
foreach($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"] as $compare_list_item)
    $arCompareList[] = $compare_list_item["ID"];
if (!empty($arCompareList))
{?>
    <script>
        var arCompareList = <?=json_encode($arCompareList);?>;  
        //console.log(arCompareList);
        
        $('.itemMain').each(function(){
            
            // ��������� ���� �� ������� � ������ ���������
            for(i=0; i<arCompareList.length; i++)  // in_array 
            {
                var checkbox = $(this).find('.add-to-compare-list-ajax');
                if (checkbox.val() == arCompareList[i])
                    checkbox.attr('checked', 'checked');
            }    
        })
    </script><?
}

}?>