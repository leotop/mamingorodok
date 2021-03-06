<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include_once(GetLangFileName(dirname(__FILE__)."/", "/assist.php"));

//return url
//price format
$SERVER_NAME_tmp = "";
if (defined("SITE_SERVER_NAME"))
	$SERVER_NAME_tmp = SITE_SERVER_NAME;
if (strlen($SERVER_NAME_tmp)<=0)
	$SERVER_NAME_tmp = COption::GetOptionString("main", "server_name", "");

$dateInsert = (strlen(CSalePaySystemAction::GetParamValue("DATE_INSERT")) > 0) ? CSalePaySystemAction::GetParamValue("DATE_INSERT") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"];
$orderID = (strlen(CSalePaySystemAction::GetParamValue("ORDER_ID")) > 0) ? CSalePaySystemAction::GetParamValue("ORDER_ID") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"];
$shouldPay = (strlen(CSalePaySystemAction::GetParamValue("SHOULD_PAY")) > 0) ? CSalePaySystemAction::GetParamValue("SHOULD_PAY") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"];
$currency = (strlen(CSalePaySystemAction::GetParamValue("CURRENCY")) > 0) ? CSalePaySystemAction::GetParamValue("CURRENCY") : $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"];
$sucUrl = (strlen(CSalePaySystemAction::GetParamValue("SUCCESS_URL")) > 0) ? CSalePaySystemAction::GetParamValue("SUCCESS_URL") : "http://".$SERVER_NAME_tmp;
$failUrl = (strlen(CSalePaySystemAction::GetParamValue("FAIL_URL")) > 0) ? CSalePaySystemAction::GetParamValue("FAIL_URL") : "http://".$SERVER_NAME_tmp;

?>
<FORM ACTION="https://payments.paysecure.ru/pay/order.cfm" target="_blank" METHOD="POST">
<font class="tablebodytext">
<?echo GetMessage("SASP_PROMT")?><br>
<?echo GetMessage("SASP_ACCOUNT_NO")?> <?= $orderID.GetMessage("SASP_ORDER_FROM").$dateInsert ?><br>
<?echo GetMessage("SASP_ORDER_SUM")?> <b><?echo SaleFormatCurrency($shouldPay, $currency) ?></b><br>
<br>
<INPUT TYPE="HIDDEN" NAME="Merchant_ID" VALUE="<?= (CSalePaySystemAction::GetParamValue("SHOP_IDP")) ?>">
<INPUT TYPE="HIDDEN" NAME="OrderNumber" VALUE="<?= $orderID ?>">
<INPUT TYPE="HIDDEN" NAME="OrderAmount" VALUE="<?= (str_replace(",", ".", $shouldPay)) ?>">
<INPUT TYPE="HIDDEN" NAME="Delay" VALUE="0">
<INPUT TYPE="HIDDEN" NAME="Language" VALUE="RU">
<INPUT TYPE="HIDDEN" NAME="URL_RETURN_OK" VALUE="<?= (CSalePaySystemAction::GetParamValue("SUCCESS_URL")) ?>">
<INPUT TYPE="HIDDEN" NAME="URL_RETURN_NO" VALUE="<?= (CSalePaySystemAction::GetParamValue("FAIL_URL")) ?>">
<INPUT TYPE="HIDDEN" NAME="OrderCurrency" VALUE="<?=(($currency == "RUB") ? "RUR" :($currency)) ?>">

<?if ($valTmp = CSalePaySystemAction::GetParamValue("DEMO")):?>
<INPUT TYPE="HIDDEN" NAME="TestMode" VALUE="1">
<?endif;?>

<INPUT TYPE="HIDDEN" NAME="CardPayment" VALUE="<?echo (IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_CardPayment")) == 1) ? 1 : 0?>">
<INPUT TYPE="HIDDEN" NAME="YMPayment" VALUE="1">

<INPUT TYPE="HIDDEN" NAME="WMPayment" VALUE="<?echo (IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_WebMoneyPayment")) == 1) ? 1 : 0?>">
<INPUT TYPE="HIDDEN" NAME="PayCashPayment" VALUE="<?echo (IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_PayCashPayment")) == 1) ? 1 : 0?>">
<INPUT TYPE="HIDDEN" NAME="AssistIDPayment" VALUE="<?echo (IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_AssistIDCCPayment")) == 1) ? 1 : 0?>">
<INPUT TYPE="HIDDEN" NAME="QIWIPayment" VALUE="<?echo (IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_EPBeelinePayment")) == 1) ? 1 : 0?>">

<INPUT TYPE="SUBMIT" NAME="Submit" VALUE="<?echo GetMessage("SASP_ACTION")?>">
</font>
</form>
     <br/><br/><br/>
<h3><?echo GetMessage("SASP_NOTES_TITLE")?></h3>
<p align="justify"><?echo GetMessage("SASP_NOTES")?></p>
<p align="justify"><h3><?echo GetMessage("SASP_NOTES_TITLE1")?></h3>
<p align="justify"><?echo GetMessage("SASP_NOTES1")?></p>
