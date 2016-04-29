<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_REQUEST["frmFBSent"]) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) !== false && strlen($_REQUEST["fbNameLast"])<=0)
{
	$_REQUEST["fbName"] = iconv('UTF-8', 'Windows-1251', htmlspecialchars(trim($_REQUEST["fbName"])));
	$_REQUEST["fbEmail"] = iconv('UTF-8', 'Windows-1251', htmlspecialchars(trim($_REQUEST["fbEmail"])));
	$_REQUEST["fbPhone"] = iconv('UTF-8', 'Windows-1251', htmlspecialchars(trim($_REQUEST["fbPhone"])));
	$_REQUEST["fbComment"] = iconv('UTF-8', 'Windows-1251', htmlspecialchars(trim($_REQUEST["fbComment"])));
	
	$arErr = array();
	if(strlen($_REQUEST["fbName"])<=2) $arErr[] = 'Не заполнено поле "Имя"';
	if(!check_email($_REQUEST["fbEmail"])) $arErr[] = 'Не заполнено поле "Email"';
	if(strlen($_REQUEST["fbPhone"])<=2) $arErr[] = 'Не заполнено поле "Телефон"';
	if(strlen($_REQUEST["fbComment"])<=2) $arErr[] = 'Не заполнено поле "Ваш вопрос"';
	
	if(count($arErr)<=0)
	{
		$arEventFields = array(
			"NAME" => $_REQUEST["fbName"],
			"EMAIL" => $_REQUEST["fbEmail"],
			"PHONE" => $_REQUEST["fbPhone"],
			"MESSAGE" => $_REQUEST["fbComment"],
			"EMAIL_TO" => COption::GetOptionString("main", "email_from", "")
		);
		CEvent::Send("FEEDBACK_HEAD", SITE_ID, $arEventFields);
		
		$arEventFields["EMAIL_TO"] = $_REQUEST["fbEmail"];
		CEvent::Send("FEEDBACK_HEAD", SITE_ID, $arEventFields);
		
		echo '<script type="text/javascript"> $(document).ready(function() { $("#fbForm").find("input:visible").each(function() { if(($(this).attr("name"))) $(this).val("") }); showNotify("В ближайшее время ответ на ваше сообщение будет отправлен на указанный адрес.", "Ваш вопрос успешно отправлен"); }); </script>';
	} else echo showHtmlNote(implode("<br />", $arErr), true);
}
?>