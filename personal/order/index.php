<?
$HIDE_LEFT_COLUMN = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��� ������");
//$_REQUEST["filter_canceled"] = 'Y';
?><?$APPLICATION->IncludeComponent("bitrix:sale.personal.order", "new", Array(
	"SEF_MODE" => "N",	// �������� ��������� ���
	"ORDERS_PER_PAGE" => "20",	// ���������� ������� �� ����� ��������
	"PATH_TO_PAYMENT" => "/personal/order/payment/",	// �������� ����������� ��������� �������
	"PATH_TO_BASKET" => "/basket/order/payment/",	// �������� � ��������
	"SET_TITLE" => "Y",	// ������������� ��������� ��������
	"SAVE_IN_SESSION" => "Y",	// ��������� ��������� ������� � ������ ������������
	"NAV_TEMPLATE" => "",	// ��� ������� ��� ������������ ���������
	"PROP_1" => "",	// �� ���������� �������� ��� ���� ����������� "���������� ����" (s1)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>