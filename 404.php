<?
//header("Status: 404 Not Found");
$IS_DETAIL = true;

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$arTmp = parse_url($_SERVER["REQUEST_URI"]);
if(!preg_match("/\.[a-z]{3,4}/", $arTmp["path"]) && substr($arTmp["path"], -1) !== "/")
{
	//die($_SERVER["REQUEST_URI"]);
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://'.$_SERVER['HTTP_HOST'].$arTmp["path"].'/'.(strlen($arTmp["query"])>0?'?'.$arTmp["query"]:''));
	exit();
}

$APPLICATION->SetTitle("�������� �� �������");
?>
<div class="jtext">
    <p>� ���������, ��������, � ������� �� ����������, �� ������� �� ����� �������.</p>
    <p>��������, ��� ��������, ���� ������� ��� ����������. ��� ������ ������ ���������� �������������� ������ ������ ������������� � ����� ������� ���� ��� ������������� ����.</p>
    <p><a href="/" title="mamingorodok.ru">������� �� �������</a></p>
</div>


 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>