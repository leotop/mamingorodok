<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������� ������ ��� �������������");
$APPLICATION->SetPageProperty("description", "������� ������� ��� ����� � ������������� � ��������-�������� ������ ������ʻ, ������ ������ ��� ������������� �� ������ ���� � ��������� �� ������.");
$APPLICATION->SetPageProperty("keywords", "������ ��� ������������� � �������� ��������, ���� �� ������ ��� �����");
$APPLICATION->SetPageProperty("title", "������ ������ ��� ������������� � ��������-�������� � ������, ���� ������� ��� ����� � ������������� � ���������");
?><?php
$APPLICATION->IncludeComponent(
	"mailru:comments.list",
	".default",
	array(
		"clientId" => 10183, // Id ������� � Mail.Ru
		"onPage" => 5, // ���������� ������� �� ��������
		"pager" => 2, // ��� ��������, �������� 1 (������������) ��� 2 (ajax-����)
		"offerId" => $arResult["ID"], // id �������� (������), ����� ����������� ����������� � ����������� �� ������� ��������
		"backgroundColor" => "#B7BF84", // ���� ����
		"fontColor" => "#CF004E", // ���� ������
	),
	false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>