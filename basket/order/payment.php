<?
define('NEED_AUTH', true);
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата заказа");?><br>
<?
$APPLICATION->IncludeComponent("individ:sale.order.payment",'',array('ORDER_ID_VALUE'=>$_REQUEST['ORDER_ID'], "DIE" => "N"), false);
?>
<script type="text/javascript">
	$(document).ready(function() {
		if($("#btnRBKPay").size() > 0) {
			$("#btnRBKPay").click();
		}
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
