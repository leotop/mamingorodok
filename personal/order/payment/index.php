<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Оплата заказа");

if($_REQUEST["SET_PAYMENT"]=="Y" && CModule::IncludeModule("sale")) {
	$intOrderID = intval($_REQUEST["ORDER_ID"]);
	$intPaymentID = intval($_REQUEST["paymentID"]);

	if($intOrderID>0 && $intPaymentID>0) {
		$arFilter = Array(
			"USER_ID" => $USER->GetID(),
			"ID" => $intOrderID
		);
		$rsOrders = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
		if($arOrder = $rsOrders -> GetNext()) {
			$rsPayment = CSalePaySystem::GetList(array(), Array("ACTIVE"=>"Y", "PERSON_TYPE_ID"=>1, "ID" => $intPaymentID));
			if($arPayment = $rsPayment -> GetNext()) {
				CSaleOrder::Update($arOrder["ID"], array("PAY_SYSTEM_ID" => $arPayment["ID"]));
				if(in_array($arPayment["ID"], array(1, 5))) LocalRedirect("/personal/order/?ID=".$arOrder["ID"]);
			}
		}
	}
}

?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment",
	"",
	Array(
	)
);?>
	<script src="/bitrix/templates/nmg/js/jquery-1.6.1.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function() {
			$("#btnRBKPay").click().hide().after("Идет перенаправление на страницу оплаты...");
		});
	</script><?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>