<?

$showSravn = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetPageProperty("keywords", "��������-������� ����� �������");
$APPLICATION->SetPageProperty("title", "�������� ������� ������� ����������� �������");
$APPLICATION->SetTitle("�������");
$order = $APPLICATION->GetCurPageParam("sort=price",array("sort"), false);
?>         

<?
/*$APPLICATION->IncludeComponent(
    "bitrix:catalog", 
    ".default", 
    array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "2",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/catalog/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_'FILTER'" => "N",
        "CACHE_GROUPS" => "Y",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "N",
        "USE_FILTER" => "N",
        "USE_REVIEW" => "N",
        "USE_COMPARE" => "N",
        "PRICE_CODE" => array(
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRICE_VAT_SHOW_VALUE" => "N",
        "SHOW_TOP_ELEMENTS" => "N",
        "PAGE_ELEMENT_COUNT" => "18",
        "LINE_ELEMENT_COUNT" => "3",
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "LIST_PROPERTY_CODE" => array(
            0 => "OLD_PRICE",
            1 => "PRICE",
            2 => "WISHES",
            3 => "RATING",
            4 => "VOTES",
            5 => "CH_TYPE",
            6 => "CH_PODUCER",
            7 => "",
        ),
        "INCLUDE_SUBSECTIONS" => "Y",
        "LIST_META_KEYWORDS" => "-",
        "LIST_META_DESCRIPTION" => "-",
        "LIST_BROWSER_TITLE" => "NAME",
        "DETAIL_PROPERTY_CODE" => array(
            0 => "OLD_PRICE",
            1 => "PRICE",
            2 => "WISHES",
            3 => "RATING",
            4 => "VOTES",
            5 => "CH_PRODUCER",
            6 => "",
        ),
        "DETAIL_META_KEYWORDS" => "keywords",
        "DETAIL_META_DESCRIPTION" => "description",
        "DETAIL_BROWSER_TITLE" => "title",
        "LINK_IBLOCK_TYPE" => "catalog",
        "LINK_IBLOCK_ID" => "3",
        "LINK_PROPERTY_SID" => "CML2_LINK",
        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
        "USE_ALSO_BUY" => "N",
        "DISPLAY_TOP_PAGER" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "������",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "HIDE_NOT_AVAILABLE" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "N",
        "USE_ELEMENT_COUNTER" => "Y",
        "CONVERT_CURRENCY" => "N",
        "USE_PRODUCT_QUANTITY" => "Y",
        "ADD_PROPERTIES_TO_BASKET" => "Y",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "PARTIAL_PRODUCT_PROPERTIES" => "N",
        "PRODUCT_PROPERTIES" => array(
        ),
        "OFFERS_CART_PROPERTIES" => array(
        ),
        "SECTION_COUNT_ELEMENTS" => "Y",
        "SECTION_TOP_DEPTH" => "2",
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER2" => "desc",
        "LIST_OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "LIST_OFFERS_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "LIST_OFFERS_LIMIT" => "5",
        "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
        "DETAIL_OFFERS_FIELD_CODE" => array(
            0 => "",
            1 => "",
        ),
        "DETAIL_OFFERS_PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "USE_STORE" => "N",
        "OFFERS_SORT_FIELD" => "sort",
        "OFFERS_SORT_ORDER" => "asc",
        "OFFERS_SORT_FIELD2" => "id",
        "OFFERS_SORT_ORDER2" => "desc",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "SEF_URL_TEMPLATES" => array(
            "sections" => "",
            "section" => "#SECTION_CODE#/",
            "element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
            "compare" => "compare.php?action=#ACTION_CODE#",
        ),
        "VARIABLE_ALIASES" => array(
            "compare" => array(
                "ACTION_CODE" => "action",
            ),
        )
    ),
    false
);*/
?> 
            <? 
            if($_COOKIE["namber_order"] == "checked"){
              $arrFilter["!PROPERTY_1498"] = false;
            }elseif($_COOKIE["namber_order"] == ""){
              $arrFilter["!PROPERTY_1498"] = true;
            }                    
            ?>

<? $url_code = explode( '/', $APPLICATION->GetCurPage() );
   if($_GET["orderby"]){$sort_od = $_GET["orderby"];}else{$sort_od = "HAS_PREVIEW_PICTURE";};
     if($_GET["sort"]){$sort_a_d = $_GET["sort"];}else{$sort_a_d = "desc";};
 //   if($USER->IsAdmin()){  
         $arFilter = array('IBLOCK_ID' => 2);
     $rsParentSection = CIBlockSection::GetList( array(), $arFilter , false, Array('UF_SORT_TYPE_USER')); 
           while($rsParentSection_1 = $rsParentSection->Fetch()){
              if($url_code[2] == $rsParentSection_1["CODE"]){
                $xml_id_page = $rsParentSection_1['UF_SORT_TYPE_USER'];  
              }
           }
           Cmodule::IncludeModule('iblock');
            $rsEnum = CUserFieldEnum::GetList(array(), array("ID" => $xml_id_page))->GetNext();//$ID - id �������� ����������������� ���� ���� ������
            $xml_code_page = $rsEnum["XML_ID"];
             
     if($sort_od != "HAS_PREVIEW_PICTURE" and $_GET["orderby"] == ""){
         $code_section = $xml_code_page;
     }else{
         $code_section = $sort_od;
     }
    // arshow($code_section,true); 
   // }
$APPLICATION->IncludeComponent("bitrix:catalog", "catalog_new", Array(
	"IBLOCK_TYPE" => "catalog",	// ��� ���������
		"IBLOCK_ID" => "2",	// ��������
		"BASKET_URL" => "/personal/basket.php",	// URL, ������� �� �������� � �������� ����������
		"ACTION_VARIABLE" => "action",	// �������� ����������, � ������� ���������� ��������
		"PRODUCT_ID_VARIABLE" => "id",	// �������� ����������, � ������� ���������� ��� ������ ��� �������
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// �������� ����������, � ������� ���������� ��� ������
		"SEF_MODE" => "Y",	// �������� ��������� ���
		"SEF_FOLDER" => "/catalog/",	// ������� ��� (������������ ����� �����)
		"AJAX_MODE" => "N",	// �������� ����� AJAX
		"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
		"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
		"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
		"CACHE_TYPE" => "A",	// ��� �����������
		"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
		"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
		"CACHE_GROUPS" => "N",	// ��������� ����� �������
		"SET_TITLE" => "N",	// ������������� ��������� ��������
		"SET_STATUS_404" => "N",	// ������������� ������ 404
		"USE_FILTER" => "Y",	// ���������� ������
		"USE_REVIEW" => "N",	// ��������� ������
		"USE_COMPARE" => "N",	// ��������� ��������� �������
		"PRICE_CODE" => array(	// ��� ����
			0 => "���� ��� �������� �� ����",
		),
		"USE_PRICE_COUNT" => "N",	// ������������ ����� ��� � �����������
		"SHOW_PRICE_COUNT" => "1",	// �������� ���� ��� ����������
		"PRICE_VAT_INCLUDE" => "Y",	// �������� ��� � ����
		"PRICE_VAT_SHOW_VALUE" => "N",	// ���������� �������� ���
		"SHOW_TOP_ELEMENTS" => "Y",	// �������� ��� ���������
		"PAGE_ELEMENT_COUNT" => "20",	// ���������� ��������� �� ��������
		"LINE_ELEMENT_COUNT" => "4",	// ���������� ���������, ��������� � ����� ������ �������
		"ELEMENT_SORT_FIELD" => "PROPERTY_1498",	// �� ������ ���� ��������� ������ � �������
		"ELEMENT_SORT_ORDER" => "desc",	// ������� ���������� ������� � �������
		"ELEMENT_SORT_FIELD2" => $code_section,	// ���� ��� ������ ���������� ������� � �������
		"ELEMENT_SORT_ORDER2" => $sort_a_d,	// ������� ������ ���������� ������� � �������
		"LIST_PROPERTY_CODE" => array(	// ��������
			0 => "CATALOG_AVAILABLE",
			1 => "CH_TYPE",
			2 => "CH_PODUCER",
			3 => "PROPERTY_1498",
			4 => "PREVIEW_PICTURE",
			5 => "HAS_PREVIEW_PICTURE",
			6 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",	// ���������� �������� ����������� �������
		"LIST_META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� �������� �������
		"LIST_META_DESCRIPTION" => "-",	// ���������� �������� �������� �� �������� �������
		"LIST_BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� �������� �������
		"DETAIL_PROPERTY_CODE" => array(	// ��������
			0 => "PROIZVODITEL",
			1 => "SOSTAV_KOMPLEKTA",
			2 => "BALDAKHIN",
			3 => "TIP_LYULKI",
			4 => "CHTO_VYBIRAEM",
			5 => "MATERIAL_BUTYLOCHKI_1",
			6 => "POTOK",
			7 => "OBEM_BUTYLOCHKI_ML",
			8 => "ANTI_KOLIKOVYY_KLAPAN",
			9 => "LYULKA",
			10 => "TIP_1",
			11 => "TIP_TOVARA",
			12 => "STATUS_TOVARA",
			13 => "OBEM_UPAKOVKI_M3",
			14 => "VOZRAST_OT_LET",
			15 => "MODEL",
			16 => "VID_TRANSFORMATSII",
			17 => "S_RUCHKAMI",
			18 => "NARUZHNIY_MATERIAL",
			19 => "MEKHOVOY",
			20 => "DLYA_PROGULOK",
			21 => "VES_UPAKOVKI_KG",
			22 => "UTEPLITEL",
			23 => "MATERIAL_PODKLADA",
			24 => "DLINA_SM_3",
			25 => "SHIRINA_SM",
			26 => "VYSOTA_SM",
			27 => "VES_KG_2",
			28 => "GLUBINA_SM",
			29 => "SKLADNOY",
			30 => "VID",
			31 => "MATERIAL_RYUKZAKI_KENGURU",
			32 => "POLOZHENIE_REBYENKA",
			33 => "TIP_SLINGA",
			34 => "NOVINKA",
			35 => "CEMNYY_CHEKHOL",
			36 => "TEKHNOLOGIYA_ZIMA_LETO",
			37 => "KACHANIE",
			38 => "REGULIROVKA_NAKLONA_SPINKI",
			39 => "REMEN_BEZOPASNOSTI",
			40 => "PODVESNYE_IGRUSHKI",
			41 => "TRANSFORMER",
			42 => "RADIUS_DEYSTVIYA_M",
			43 => "TIP_SIGNALA",
			44 => "RAZMER_SPALNOGO_MESTA",
			45 => "SEMNYY_STOLIK",
			46 => "REGULIROVKA_VYSOTY_STULCHIKA",
			47 => "RAZDELITEL_NOZHEK",
			48 => "PROKHODIMOST",
			49 => "MANEVRENOST",
			50 => "VID_18",
			51 => "RAZMER_V_SLOZHENNOM_VIDE_VKHDKH_SH_SM",
			52 => "POL",
			53 => "TIP_IGRUSHKI",
			54 => "TIP_STULCHIKA",
			55 => "KOLESIKI",
			56 => "TIP_AKSESSUARA",
			57 => "RAZVIVAET",
			58 => "REGULIRUEMYY_NAKLON_SPINKI",
			59 => "PODSTAVKA_POD_NOZHKI",
			60 => "REMEN_BEZOPASNOSTI_1",
			61 => "KORZINA",
			62 => "TIP_MANEZHA",
			63 => "KOLESA",
			64 => "PELENALNYY_STOLIK",
			65 => "KOLYBEL",
			66 => "ZHESTKOE_DNO",
			67 => "MATRAC_V_KOMPLEKTE",
			68 => "ELEKTRONNYY_BLOK",
			69 => "IMPORT2YM_1",
			70 => "TIP_2",
			71 => "VID_TOVARA",
			72 => "KOLICHESTVO_KOLES",
			73 => "NAZNACHENIE",
			74 => "TIP_STOLIKA",
			75 => "NA_VYPISKU",
			76 => "SEZON",
			77 => "KOLICHESTVO_DETALEY",
			78 => "SERIYA",
			79 => "DLYA_DOMA",
			80 => "DLYA_ULITSY",
			81 => "TIP_KOLYASKI",
			82 => "KOLICHESTVO_MEST",
			83 => "MEKHANIZM_SKLADYVANIYA",
			84 => "GRUPPA",
			85 => "GOD_TESTA",
			86 => "ADAC_ITOGOVYY_REZULTAT",
			87 => "ADAC_BEZOPASNOST",
			88 => "ADAC_ISPOLZOVANIE_ERGONOMIKA_DO_2011G_",
			89 => "SEZON_1",
			90 => "SOLNTSEZASHCHITNYY_KOZYREK",
			91 => "SILIKONOVYE_NAKLADKI",
			92 => "STRANA_PROIZVODITELYA",
			93 => "TIP_KOLES",
			94 => "GABARITY_V_SLOZHENNOM_VIDE",
			95 => "SHIRINA_SHASSI_SM",
			96 => "VES_SHASSI_KG",
			97 => "VES_LYULKI_KG",
			98 => "VES_PROGULOCHNOGO_BLOKA_KG",
			99 => "VES_AVTOKRESLA_PERENOSKI_KG",
			100 => "GABARITY_SPALNOGO_MESTA",
			101 => "GABARITY_SPALNOGO_MESTA_V_PROGULOCHNOM_BLOKE",
			102 => "POLOZHENIE_REBENKA_1",
			103 => "GORIZONTALNOE_POLOZHENIE_SPINKI_1",
			104 => "REGULIROVKA_NAKLONA_SPINKI_2",
			105 => "AMORTIZATORY",
			106 => "REMNI_BEZOPASNOSTI",
			107 => "LYULKA_PERENOSKA",
			108 => "BAMPER",
			109 => "PODNOZHKA",
			110 => "REGULIROVKA_PODNOZHKI",
			111 => "REGULIROVKA_RUCHKI_PO_VYSOTE",
			112 => "CHEKHOL_NA_NOZHKI",
			113 => "KORZINA_1",
			114 => "SUMKA",
			115 => "NASOS",
			116 => "NAKIDKA_NA_NOZHKI",
			117 => "RAZMER_SPALNOGO_MESTA_1",
			118 => "TOLSHCHINA_SM",
			119 => "PRUZHINY",
			120 => "SEMNYY_CHEKHOL_1",
			121 => "DOZHDEVIK",
			122 => "MATERIAL_KOMODA",
			123 => "NALICHIE_VANNOCHKI",
			124 => "NALICHIE_PELENALNOGO_STOLIKA",
			125 => "KOL_VO_YASHCHIKOV",
			126 => "TIP_KONVERTA",
			127 => "PROTIVOMOSKITNAYA_SETKA",
			128 => "PODSTAKANNIK_1",
			129 => "KOLYASKA_TRANSFORMER_DELTIM_VOYAGER",
			130 => "STATUS_NOMENKLATURY",
			131 => "ODEYALO",
			132 => "RASPRODAZHA",
			133 => "GARANTIYA_PROIZVODITELYA",
			134 => "VID_TEKHNIKI",
			135 => "TIP_MOLOKOOTSOSA",
			136 => "REGULIROVKA_RITMA",
			137 => "REGULIROVKA_SKOROSTI",
			138 => "TIP_PODOGREVATELYA",
			139 => "TAYMER",
			140 => "TIP_STERILIZATORA",
			141 => "KOL_VO_BUTYLOCHEK",
			142 => "OBEM_VANNY_L",
			143 => "TIP_TERMOMETRA",
			144 => "PRIMENENIE",
			145 => "VID_25",
			146 => "UTEPLENNYY",
			147 => "AKTSIYA",
			148 => "VOZRAST_DO_LET",
			149 => "VIDY_TRANSFORMATSIY",
			150 => "KHIT_PRODAZH",
			151 => "ARTICUL",
			152 => "PLUS",
			153 => "MINUS",
			154 => "PRICE",
			155 => "LIKE",
			156 => "manufacturer_warrant",
			157 => "OLD_PRICE",
			158 => "ACCESSORIES",
			159 => "VIDEO",
			160 => "keywords",
			161 => "WISHES",
			162 => "NAME_VPAD",
			163 => "NAME_RPAD",
			164 => "SELLOUT",
			165 => "OLD_PRICE_TEXT",
			166 => "PRICE_TEXT",
			167 => "VOTES",
			168 => "RATING_SUM",
			169 => "FORUM_MESSAGE_CNT",
			170 => "FORUM_TOPIC_ID",
			171 => "STUL_TOVAR",
			172 => "SBOR",
			173 => "ELEVATOR",
			174 => "WO_ELEVATOR",
			175 => "_",
			176 => "__1",
			177 => "__2",
			178 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",	// ���������� �������� ����� �������� �� ��������
		"DETAIL_META_DESCRIPTION" => "-",	// ���������� �������� �������� �� ��������
		"DETAIL_BROWSER_TITLE" => "-",	// ���������� ��������� ���� �������� �� ��������
		"LINK_IBLOCK_TYPE" => "1c_catalog",	// ��� ���������, �������� �������� ������� � ������� ���������
		"LINK_IBLOCK_ID" => "3",	// ID ���������, �������� �������� ������� � ������� ���������
		"LINK_PROPERTY_SID" => "CML2_LINK",	// ��������, � ������� �������� �����
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",	// URL �� ��������, ��� ����� ������� ������ ��������� ���������
		"USE_ALSO_BUY" => "N",	// ���������� ���� "� ���� ������� ��������"
		"DISPLAY_TOP_PAGER" => "Y",	// �������� ��� �������
		"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
		"PAGER_TITLE" => "������",	// �������� ���������
		"PAGER_SHOW_ALWAYS" => "Y",	// �������� ������
		"PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
		"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
		"PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
		"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
		"HIDE_NOT_AVAILABLE" => "Y",	// �� ���������� ������, ������� ��� �� �������
		"ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
		"ADD_ELEMENT_CHAIN" => "N",	// �������� �������� �������� � ������� ���������
		"USE_ELEMENT_COUNTER" => "Y",	// ������������ ������� ����������
		"CONVERT_CURRENCY" => "N",	// ���������� ���� � ����� ������
		"USE_PRODUCT_QUANTITY" => "Y",	// ��������� �������� ���������� ������
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// ��������� � ������� �������� ������� � �����������
		"PRODUCT_PROPS_VARIABLE" => "prop",	// �������� ����������, � ������� ���������� �������������� ������
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// ��������� ��������� � ������� ������, � ������� ��������� �� ��� ��������������
		"PRODUCT_PROPERTIES" => "",	// �������������� ������, ����������� � �������
		"OFFERS_CART_PROPERTIES" => "",	// �������� �����������, ����������� � �������
		"SECTION_COUNT_ELEMENTS" => "Y",	// ���������� ���������� ��������� � �������
		"SECTION_TOP_DEPTH" => "2",	// ������������ ������������ ������� ��������
		"LIST_OFFERS_FIELD_CODE" => array(	// ���� �����������
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(	// �������� �����������
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_LIMIT" => "5",	// ������������ ���������� ����������� ��� ������ (0 - ���)
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",	// ������������ ��� ������ �� ����������, ���� �� ����� ������ ��������
		"DETAIL_OFFERS_FIELD_CODE" => array(	// ���� �����������
			0 => "",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(	// �������� �����������
			0 => "",
			1 => "",
		),
		"USE_STORE" => "Y",	// ���������� ���� "���������� ������ �� ������"
		"OFFERS_SORT_FIELD" => "shows",	// �� ������ ���� ��������� ����������� ������
		"OFFERS_SORT_ORDER" => "asc",	// ������� ���������� ����������� ������
		"OFFERS_SORT_FIELD2" => "shows",	// ���� ��� ������ ���������� ����������� ������
		"OFFERS_SORT_ORDER2" => "asc",	// ������� ������ ���������� ����������� ������
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// �������� ����������, � ������� ���������� ���������� ������
		"FILTER_NAME" => "arrFilter",	// ������
		"FILTER_FIELD_CODE" => array(	// ����
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(	// ��������
			0 => "",
			1 => "PROPERTY_1498",
			2 => "DETAIL_TEXT",
			3 => "",
		),
		"FILTER_PRICE_CODE" => array(	// ��� ����
			0 => "���� ��� �������� �� ����",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(	// ���� �����������
			0 => "",
			1 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(	// �������� �����������
			0 => "",
			1 => "",
		),
		"STORES" => "",	// ������
		"USE_MIN_AMOUNT" => "Y",	// ���������� ������ ������� ���������� ���������� � �������������
		"USER_FIELDS" => array(	// ���������������� ����
			0 => "",
			1 => "",
		),
		"FIELDS" => array(	// ����
			0 => "",
			1 => "",
		),
		"MIN_AMOUNT" => "10",	// ��������, ���� �������� ��������� "����"
		"SHOW_EMPTY_STORE" => "Y",	// ���������� ����� ��� ���������� �� ��� ������
		"SHOW_GENERAL_STORE_INFORMATION" => "N",	// ���������� ����� ���������� �� �������
		"STORE_PATH" => "/store/#store_id#",	// ������ ���� � �������� STORE (������������ �����)
		"MAIN_TITLE" => "������� �� �������",	// ��������� �����
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"PRODUCT_DISPLAY_MODE" => "N",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "-",
			1 => "",
		),
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"MESS_BTN_BUY" => "������",
		"MESS_BTN_ADD_TO_BASKET" => "� �������",
		"MESS_BTN_COMPARE" => "���������",
		"MESS_BTN_DETAIL" => "���������",
		"MESS_NOT_AVAILABLE" => "��� � �������",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"SECTIONS_VIEW_MODE" => "TEXT",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"OFFERS_FIELDS" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_PROPERTIES" => array(
			0 => "",
			1 => "",
		),
		"COMPONENT_TEMPLATE" => "test",
		"TOP_ELEMENT_COUNT" => "4",	// ���������� ��������� ���������
		"TOP_LINE_ELEMENT_COUNT" => "4",	// ���������� ���������, ��������� � ����� ������ �������
		"TOP_ELEMENT_SORT_FIELD" => "shows",	// �� ������ ���� ��������� ������ � �������
		"TOP_ELEMENT_SORT_ORDER" => "PROPERTY_1498",	// ������� ���������� ������� � �������
		"TOP_ELEMENT_SORT_FIELD2" => "shows",	// ���� ��� ������ ���������� ������� � �������
		"TOP_ELEMENT_SORT_ORDER2" => "asc",	// ������� ������ ���������� ������� � �������
		"TOP_PROPERTY_CODE" => array(	// ��������
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_FIELD_CODE" => array(	// ���� �����������
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_PROPERTY_CODE" => array(	// �������� �����������
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_LIMIT" => "4",	// ������������ ���������� ����������� ��� ������ (0 - ���)
		"DETAIL_SET_CANONICAL_URL" => "N",	// ������������� ������������ URL
		"SHOW_DEACTIVATED" => "N",	// ���������� ���������������� ������
		"USE_MAIN_ELEMENT_SECTION" => "N",	// ������������ �������� ������ ��� ������ ��������
		"SET_LAST_MODIFIED" => "N",	// ������������� � ���������� ������ ����� ����������� ��������
		"PAGER_BASE_LINK_ENABLE" => "N",	// �������� ��������� ������
		"SHOW_404" => "N",	// ����� ����������� ��������
		"MESSAGE_404" => "",	// ��������� ��� ������ (�� ��������� �� ����������)
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "#SECTION_CODE#/filter/#SMART_FILTER_PATH#/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");