<?
global $NO_BROAD;
$NO_BROAD = false;
$HIDE_LEFT_COLUMN = true;

define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddChainItem("�������", "/community/profile/");
$APPLICATION->AddChainItem("�������������� ������", "");
if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0)
    LocalRedirect($backurl);

$APPLICATION->SetTitle("�����������");
?>
<div id="CatalogCenterColumn" class="LExist">
<?ShowNote("�� ���������������� � ������� ������������.");?>
<p><a href="<?=SITE_DIR?>">��������� �� ������� ��������</a></p>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>