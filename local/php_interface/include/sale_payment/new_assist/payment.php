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
$sucUrl = str_replace('#ORDER_ID#',$orderID,$sucUrl);

$failUrl = (strlen(CSalePaySystemAction::GetParamValue("FAIL_URL")) > 0) ? CSalePaySystemAction::GetParamValue("FAIL_URL") : "http://".$SERVER_NAME_tmp;
$failUrl = str_replace('#ORDER_ID#',$orderID,$failUrl);

if(0!== strpos($sucUrl,'http://'))
{
	$arSite = GetSiteInfo(SITE_ID);
	$sucUrl = 'http://'.$arSite['SERVER_NAME'].$sucUrl;
}
if(0!== strpos($failUrl,'http://'))
{
	$arSite = GetSiteInfo(SITE_ID);
	$failUrl = 'http://'.$arSite['SERVER_NAME'].$failUrl;
}

$PAYMENT_Language = (strlen(CSalePaySystemAction::GetParamValue("PAYMENT_Language")) > 0) ? CSalePaySystemAction::GetParamValue("PAYMENT_Language") : "RU";

$BillTitle = $orderID.GetMessage("SASP_ORDER_FROM").$dateInsert;

?>
<FORM ACTION="https://payments.paysecure.ru/pay/order.cfm" target="_blank" METHOD="POST" accept-charset="UTF-8">

<?echo GetMessage("SASP_PROMT")?><br>
<?echo GetMessage("SASP_ACCOUNT_NO")?> <?= $BillTitle ?><br>
<?echo GetMessage("SASP_ORDER_SUM")?> <b class="totalbill"><?echo SaleFormatCurrency(($_REQUEST["type"]=="emoney"?$shouldPay*1.045:$shouldPay),$currency); /*SaleFormatCurrency($shouldPay,
 $currency)*/ ?></b><br>
<br>
<INPUT TYPE="HIDDEN" NAME="Merchant_ID" VALUE="<?= (CSalePaySystemAction::GetParamValue("PAYMENT_Merchant_ID")) ?>"/>
<INPUT TYPE="HIDDEN" NAME="OrderNumber" VALUE="<?= $orderID ?>">
<INPUT TYPE="HIDDEN" NAME="OrderAmount" VALUE="<?= (str_replace(array(",", ' '), array(".", ''), $shouldPay)) ?>"/>

<INPUT TYPE="HIDDEN" NAME="Delay" VALUE="0"/>

<INPUT TYPE="HIDDEN" NAME="Language" VALUE="<?=PAYMENT_Language?>"/>

<?
$Country = trim(CSalePaySystemAction::GetParamValue("Country"));
$State = trim(CSalePaySystemAction::GetParamValue("State"));
$City = trim(CSalePaySystemAction::GetParamValue("City"));
?>
<?if(strlen($Country) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Country" VALUE="<?=$Country?>"/>
<?endif;?>
<?if(strlen($State) > 0):?>
<INPUT TYPE="HIDDEN" NAME="State" VALUE="<?=$State?>"/>
<?endif;?>
<?if(strlen($City) > 0):?>
<INPUT TYPE="HIDDEN" NAME="City" VALUE="<?=$City?>"/>
<?endif;?>


<INPUT TYPE="HIDDEN" NAME="URL_RETURN_OK" VALUE="<?=$sucUrl?>"/>
<INPUT TYPE="HIDDEN" NAME="URL_RETURN_NO" VALUE="<?=$failUrl?>"/>
<INPUT TYPE="HIDDEN" NAME="OrderCurrency" VALUE="<?=(($currency == "RUB") ? "RUR" :($currency)) ?>"/>

<?if ($valTmp = CSalePaySystemAction::GetParamValue("PAYMENT_TestMode")):?>
<INPUT TYPE="HIDDEN" NAME="TestMode" VALUE="1"/>
<?endif;?>

<?
$FIRST_NAME = trim(CSalePaySystemAction::GetParamValue("FIRST_NAME"));
$LAST_NAME = trim(CSalePaySystemAction::GetParamValue("LAST_NAME"));
$MIDDLE_NAME = trim(CSalePaySystemAction::GetParamValue("MIDDLE_NAME"));
$EMAIL = trim(CSalePaySystemAction::GetParamValue("EMAIL"));
$PHONE = trim(CSalePaySystemAction::GetParamValue("PHONE"));
$ADDRESS = trim(CSalePaySystemAction::GetParamValue("ADDRESS"));
$arNt = explode(' ',$FIRST_NAME);
$arN = array();
foreach($arNt as $n)
{
	$n = trim($n);
	if(strlen($n) > 0)
		$arN[] = $n;
}
$CarN = count($arN);

if(strlen($LAST_NAME) <= 0 && $CarN > 1)
{
	$FIRST_NAME = $arN[0];
	$LAST_NAME = $arN[1];
}
if(strlen($MIDDLE_NAME) <= 0 && $CarN > 2)
{
	$FIRST_NAME = $arN[0];
	$MIDDLE_NAME = $arN[1];
	$LAST_NAME = $arN[2];
}

?>
<?if(strlen($FIRST_NAME) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Firstname" VALUE="<?=$FIRST_NAME?>"/>
<?endif;?>
<?if(strlen($MIDDLE_NAME) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Middlename" VALUE="<?=$MIDDLE_NAME?>"/>
<?endif;?>
<?if(strlen($LAST_NAME) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Lastname" VALUE="<?=$LAST_NAME?>"/>
<?endif;?>
<?if(strlen($EMAIL) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Email" VALUE="<?=$EMAIL?>"/>
<?endif;?>
<?if(strlen($PHONE) > 0):?>
<INPUT TYPE="HIDDEN" NAME="MobilePhone" VALUE="<?=$PHONE?>"/>
<?endif;?>
<?if(strlen($ADDRESS) > 0):?>
<INPUT TYPE="HIDDEN" NAME="Address" VALUE="<?=$ADDRESS?>"/>
<?endif;?>



<INPUT TYPE="HIDDEN" NAME="Comment" VALUE="<?echo $BillTitle?>"/>


<INPUT TYPE="HIDDEN" NAME="CardPayment" VALUE="<?echo ($_REQUEST["type"]=="card" && IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_CardPayment")) == 1) ? 1 : 0?>"/>
<INPUT TYPE="HIDDEN" NAME="YMPayment" VALUE="<?echo ($_REQUEST["type"]=="emoney" && IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_YMPayment")) == 1) ? 1 : 0?>"/>
<INPUT TYPE="HIDDEN" NAME="WMPayment" VALUE="<?echo ($_REQUEST["type"]=="emoney" && IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_WMPayment")) == 1) ? 1 : 0?>"/>
<INPUT TYPE="HIDDEN" NAME="QIWIPayment" VALUE="<?echo ($_REQUEST["type"]=="emoney" && IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_QIWIPayment")) == 1) ? 1 : 0?>"/>
<INPUT TYPE="HIDDEN" NAME="AssistIDPayment" VALUE="<?echo (false && IntVal(CSalePaySystemAction::GetParamValue("PAYMENT_AssistIDPayment")) == 1) ? 1 : 0?>"/>



<INPUT TYPE="SUBMIT" class="inputbutton" NAME="Submit" VALUE="<?echo GetMessage("SASP_ACTION")?>"/>

</form>
     <br/><br/><br/>
<h3><?echo GetMessage("SASP_NOTES_TITLE")?></h3>
<p align="justify"><?echo GetMessage("SASP_NOTES")?></p>
<p align="justify"><h3><?echo GetMessage("SASP_NOTES_TITLE1")?></h3>
<p align="justify"><?echo GetMessage("SASP_NOTES1")?></p>
