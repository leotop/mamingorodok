<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$intPaySystem = intval($_REQUEST["pay_system"]);
$intOrderID = intval($_REQUEST["ORDER_ID"]);

CModule::IncludeModule("sale");


$rsOrder = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), array("USER_ID" => $USER->GetID(), "ID" => $intOrderID));
if($arOrder = $rsOrder -> GetNext())
{
	if($arPaySys = CSalePaySystem::GetByID($intPaySystem, 1))
	{ // set pay system
		CSaleOrder::Update($arOrder["ID"], array("PAY_SYSTEM_ID"=>$arPaySys["ID"]));
		if($intPaySystem != 5) LocalRedirect("/basket/order/payment.php?ORDER_ID=".$arOrder["ID"].(isset
		($_REQUEST["type"])?'&type='.$_REQUEST["type"]:''));
	} else LocalRedirect("/index.php");
} else LocalRedirect("/index.php");

?>