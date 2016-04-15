<?
$IS_REVIEWS = true;
$showSravn = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������");



if(isset($_REQUEST["SECTION_CODE"])){
	if(preg_match("/[a-zA-Z0-9_]+/i",$_REQUEST["SECTION_CODE"])){
		$arrFilter["SECTION_CODE"] = $_REQUEST["SECTION_CODE"];
	}
	if(isset($GLOBALS["arrFilter_pf"])){
		//print_R($GLOBALS["arrFilter_pf"]);
		$arrFilter = array_merge($arrFilter,$GLOBALS["arrFilter_pf"]);
	}

$arFilter = Array('IBLOCK_ID' => REVIEWS_IBLOCK_ID, 'CODE' =>$_REQUEST["SECTION_CODE"]);
$rsSection = CIBlockSection::GetList(array(), $arFilter, false, array("UF_TITLE","UF_DESCRIPTION","UF_KEYWORDS"));
if($arSection = $rsSection->Fetch()) {
    
    $META = $arSection;
}
 if(isset($META["UF_TITLE"]) && !empty($META["UF_TITLE"])){
	$APPLICATION->SetPageProperty("headertitle",$META["UF_TITLE"]);
	}
if(isset($META["UF_KEYWORDS"]) && !empty($META["UF_KEYWORDS"]))
	$APPLICATION->SetPageProperty("keywords",$META["UF_KEYWORDS"]);
	if(isset($META["UF_DESCRIPTION"]) && !empty($META["UF_DESCRIPTION"])){
	$APPLICATION->SetPageProperty("description",$META["UF_DESCRIPTION"]);
		
	}
}
?>


<?$APPLICATION->IncludeComponent("individ:recomend.list", "recommendList1", Array(
	"IBLOCK_TYPE" => "catalog",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "7",	// ��� ��������������� �����
	"NEWS_COUNT" => "20",	// ���������� �������� �� ��������
	"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
	"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
	"FILTER_NAME" => "arrFilter",	// ������
	"FIELD_CODE" => array(	// ����
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// ��������
		0 => "LOOK_REC_LIST",
		1 => "BLOG_POST_ID",
		2 => "",
	),
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
	"AJAX_MODE" => "N",	// �������� ����� AJAX
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
	"CACHE_FILTER" => "Y",	// ���������� ��� ������������� �������
	"CACHE_GROUPS" => "Y",	// ��������� ����� �������
	"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "Y",	// �������� ������ � ������� ���������
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
	"PARENT_SECTION" => "",	// ID �������
	"PARENT_SECTION_CODE" => "",	// ��� �������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
	"PAGER_TITLE" => "�������",	// �������� ���������
	"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
	"PAGER_TEMPLATE" => "",	// �������� �������
	"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
	"PAGER_SHOW_ALL" => "Y",	// ���������� ������ "���"
	"DISPLAY_DATE" => "Y",	// �������� ���� ��������
	"DISPLAY_NAME" => "Y",	// �������� �������� ��������
	"DISPLAY_PICTURE" => "Y",	// �������� ����������� ��� ������
	"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
	"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>