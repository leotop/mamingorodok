<?
$FILTER_TITLE = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товары");
//print_R($_REQUEST);
global $arrFilter;
if(isset($_REQUEST["FILTER_PARAM"])){
	if(strpos($_REQUEST["FILTER_PARAM"],"?") !== false){
		$param = explode("?",$_REQUEST["FILTER_PARAM"]);
		$_REQUEST["FILTER_PARAM"] = $param[0];
	}
	$sort1 = "ACTIVE_FROM";
	if($_REQUEST["FILTER_PARAM"]=="new"){
		$GLOBALS["arrFilter"]["PROPERTY_NOVINKA_VALUE"] = "Да";
		$sort1 = "PROPERTY_NOVINKA";
		$APPLICATION->SetTitle("Новинки");
		$APPLICATION->AddChainItem("Новинки", "");

	}
	elseif($_REQUEST["FILTER_PARAM"]=="sale"){
		$GLOBALS["arrFilter"][">PROPERTY_OLD_PRICE"] = "0";
		$sort1 = "PROPERTY_OLD_PRICE";
		$APPLICATION->SetTitle("Скидки");
		$APPLICATION->AddChainItem("Скидки", "");
	}
	elseif($_REQUEST["FILTER_PARAM"]=="popular"){
		$sort1 = "PROPERTY_SALES_RATING";
		$GLOBALS["arrFilter"][">=PROPERTY_SALES_RATING"] = "0";
		$APPLICATION->SetTitle("Популярные товары");
		$APPLICATION->AddChainItem("Популярные товары", "");
	}
	elseif($_REQUEST["FILTER_PARAM"]=="desired"){
		$sort1 = "PROPERTY_WISH_RATING";
		$GLOBALS["arrFilter"][">PROPERTY_WISH_RATING"] = "0";
		$APPLICATION->SetTitle("Желанные товары");
		$APPLICATION->AddChainItem("Желанные товары", "");
	}
	
}
//print_R($arrFilter);
?><?$APPLICATION->IncludeComponent("bitrix:news.list", "titleList", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"NEWS_COUNT" => "20",
	"SORT_BY1" => $sort1,
	"SORT_ORDER1" => "desc",
	"SORT_BY2" => "ID",
	"SORT_ORDER2" => "desc",
	"FILTER_NAME" => "arrFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "OSOBEN",
		1 => "RAZMER_TOVARA",
		2 => "CH_VES",
		3 => "RAZMER_UPAK",
		4 => "CH_VES_UPAK",
		5 => "CH_VOZRAST_DO",
		6 => "CH_VOZRAST_OT",
		7 => "NOVINKA",
		8 => "CH_KROV_TYPE",
		9 => "CH_KROV_MATERIAL",
		10 => "CH_MEH_KACH",
		11 => "RAZMER_MATRAS",
		12 => "CH_KROV_KOLYSA",
		13 => "CH_DNO",
		14 => "CH_KROV_UROV_DNA",
		15 => "CH_MAX_GLUB",
		16 => "CH_SPINKI",
		17 => "CH_STENKI",
		18 => "CH_OPUSK_STENKA",
		19 => "CH_SEMN_STENKA",
		20 => "CH_REIKI",
		21 => "CH_YASHCIK",
		22 => "RAZMER_YASHCIKA",
		23 => "CH_KOMOD",
		24 => "CH_SILICON",
		25 => "ARTICUL",
		26 => "CH_VYSOTA_UPAK",
		27 => "CH_VYSOTA",
		28 => "CH_DLINA_MATRAS",
		29 => "CH_DLINA_UPAK",
		30 => "CH_DLINA",
		31 => "WISHES",
		32 => "PRICE",
		33 => "CH_PRICE",
		34 => "MINUS",
		35 => "PLUS",
		36 => "RATING",
		37 => "WISH_RATING",
		38 => "SALE_RATING",
		39 => "OLD_PRICE",
		40 => "STRANA",
		41 => "CH_SHIRINA_MATRAS",
		42 => "CH_SHIRINA_UPAK",
		43 => "CH_SHIRINA",
		44 => "VOTES",
		45 => "SALES_RATING",
		46 => "RECOMMENDED_BASKET",
		47 => "RATING_SUM",
		48 => "MODEL_3D",
		49 => "",
	),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_SHADOW" => "Y",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"PREVIEW_TRUNCATE_LEN" => "",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "Y",
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"PARENT_SECTION" => "",
	"PARENT_SECTION_CODE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Новости",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "Y",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>