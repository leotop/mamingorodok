<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");

file_put_contents($_SERVER["DOCUMENT_ROOT"].'/skock/payment.php', '<br><br>'.date("d.m.Y H:i:s").' <pre>'.print_r($_REQUEST, true).'</pre>', FILE_APPEND);

?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID" => "6",
		"PERSON_TYPE_ID" => "1"
	),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>