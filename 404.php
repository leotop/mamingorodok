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

$APPLICATION->SetTitle("—траница не найдена");
?>
<div class="jtext">
    <p>  сожалению, страница, к которой ¬ы обратились, не найдена на нашем сервере.</p>
    <p>¬озможно, она устарела, была удалена или перемещена. ƒл€ поиска нужной информации воспользуйтесь формой поиска расположенной в левом верхнем углу или навигационным меню.</p>
    <p><a href="/" title="mamingorodok.ru">ѕерейти на главную</a></p>
</div>


 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>