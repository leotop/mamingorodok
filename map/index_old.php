<?
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("����� �����");
?>
<div class="map">
<h1>����� �����</h1>

<div class="reviews">
	<?
	$APPLICATION->IncludeComponent("bitrix:main.map", "sitemap", Array(
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "3600",	// ����� ����������� (���.)
	"SET_TITLE" => "Y",	// ������������� ��������� ��������
	"LEVEL" => "3",	// ������������ ������� ����������� (0 - ��� �����������)
	"COL_NUM" => "1",	// ���������� �������
	"SHOW_DESCRIPTION" => "N",	// ���������� ��������
	),
	false
);
	?>
</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>