<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("���������");
?>
<p>�� ���� �������� ���������� ��� ������, ������� �� ������ �� ����������, �� �� �����-�� �������� �������� �������. �� ����������� ����� ��� ���������� "�������".</p>
<?$APPLICATION->IncludeComponent("sk:personal.wish.list", "personal_wish_list", Array(
	"AJAX_MODE" => "N",	// �������� ����� AJAX
		"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
		"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
		"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
		"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	),
	false
);?>          
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>