<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����");
?><?$APPLICATION->IncludeComponent("bitrix:catalog.search", "searchNew", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "catalog",	// ��� ���������
		"IBLOCK_ID" => "2",	// ��������
		"ELEMENT_SORT_FIELD" => "sort",	// �� ������ ���� ��������� ��������
		"ELEMENT_SORT_ORDER" => "asc",	// ������� ���������� ���������
		"ELEMENT_SORT_FIELD2" => "id",	// ���� ��� ������ ���������� ���������
		"ELEMENT_SORT_ORDER2" => "desc",	// ������� ������ ���������� ���������
		"HIDE_NOT_AVAILABLE" => "N",	// �� ���������� ������, ������� ��� �� �������
		"PAGE_ELEMENT_COUNT" => "30",	// ���������� ��������� �� ��������
		"LINE_ELEMENT_COUNT" => "3",	// ���������� ��������� ��������� � ����� ������ �������
		"PROPERTY_CODE" => array(	// ��������
			0 => "",
			1 => "",
		),
		"OFFERS_FIELD_CODE" => array(	// ���� �����������
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(	// �������� �����������
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",	// �� ������ ���� ��������� ����������� ������
		"OFFERS_SORT_ORDER" => "asc",	// ������� ���������� ����������� ������
		"OFFERS_SORT_FIELD2" => "id",	// ���� ��� ������ ���������� ����������� ������
		"OFFERS_SORT_ORDER2" => "desc",	// ������� ������ ���������� ����������� ������
		"OFFERS_LIMIT" => "5",	// ������������ ���������� ����������� ��� ������ (0 - ���)
		"SECTION_URL" => "",	// URL, ������� �� �������� � ���������� �������
		"DETAIL_URL" => "",	// URL, ������� �� �������� � ���������� �������� �������
		"BASKET_URL" => "/personal/basket.php",	// URL, ������� �� �������� � �������� ����������
		"ACTION_VARIABLE" => "action",	// �������� ����������, � ������� ���������� ��������
		"PRODUCT_ID_VARIABLE" => "id",	// �������� ����������, � ������� ���������� ��� ������ ��� �������
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// �������� ����������, � ������� ���������� ���������� ������
		"PRODUCT_PROPS_VARIABLE" => "prop",	// �������� ����������, � ������� ���������� �������������� ������
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// �������� ����������, � ������� ���������� ��� ������
		"AJAX_MODE" => "N",	// �������� ����� AJAX
		"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
		"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
		"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
		"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
		"CACHE_TYPE" => "A",	// ��� �����������
		"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
		"DISPLAY_COMPARE" => "N",	// �������� ������ ���������
		"PRICE_CODE" => array(	// ��� ����
			0 => "���� ��� �������� �� ����",
			1 => "base",
			2 => "���������",
		),
		"USE_PRICE_COUNT" => "N",	// ������������ ����� ��� � �����������
		"SHOW_PRICE_COUNT" => "1",	// �������� ���� ��� ����������
		"PRICE_VAT_INCLUDE" => "Y",	// �������� ��� � ����
		"USE_PRODUCT_QUANTITY" => "N",	// ��������� �������� ���������� ������
		"CONVERT_CURRENCY" => "N",	// ���������� ���� � ����� ������
		"OFFERS_CART_PROPERTIES" => "",	// �������� ����������� ����������� � �������
		"RESTART" => "Y",	// ������ ��� ����� ���������� (��� ���������� ���������� ������)
		"NO_WORD_LOGIC" => "N",	// ��������� ��������� ���� ��� ���������� ����������
		"USE_LANGUAGE_GUESS" => "N",	// �������� ��������������� ��������� ����������
		"CHECK_DATES" => "N",	// ������ ������ � �������� �� ���� ����������
		"PAGER_TEMPLATE" => ".default",	// ������ ������������ ���������
		"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
		"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
		"PAGER_TITLE" => "������",	// �������� ���������
		"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
		"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
		"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>