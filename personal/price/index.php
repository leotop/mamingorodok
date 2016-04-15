<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// ob_start();
// var_dump($_POST);
// echo "\n================\n\n";
// $l = ob_get_contents();
// ob_end_clean();
// $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/resassist.txt','w');
// if($fp)
// {
	// fputs($fp, $l);
	// fclose($fp);
// }


$MESS["SASP_AS000"]="ÀÂÒÎÐÈÇÀÖÈß ÓÑÏÅØÍÎ ÇÀÂÅÐØÅÍÀ";
$MESS["SASP_AS001"]="ÀÂÒÎÐÈÇÀÖÈß ÓÑÏÅØÍÎ ÇÀÂÅÐØÅÍÀ (Ñ CVC2)";
$MESS["SASP_AS010"]="ÏÐÅÄÀÂÒÎÐÈÇÀÖÈß ÓÑÏÅØÍÎ ÇÀÂÅÐØÅÍÀ";
$MESS["SASP_AS011"]="ÏÐÅÄÀÂÒÎÐÈÇÀÖÈß ÓÑÏÅØÍÎ ÇÀÂÅÐØÅÍÀ (Ñ CVC2)";
$MESS["SASP_AS020"]="ÏÎÑÒÀÂÒÎÐÈÇÀÖÈß ÓÑÏÅØÍÎ ÇÀÂÅÐØÅÍÀ";
$MESS["SASP_AS100"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ";
$MESS["SASP_AS101"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Îøèáî÷íûé íîìåð ïëàòåæíîãî ñðåäñòâà";
$MESS["SASP_AS102"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Íåäîñòàòî÷íî ñðåäñòâ";
$MESS["SASP_AS104"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Íåâåðíûé ñðîê äåéñòâèÿ êàðòû";
$MESS["SASP_AS105"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Ïðåâûøåí ëèìèò";
$MESS["SASP_AS106"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Íåâåðíûé PIN";
$MESS["SASP_AS107"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Îøèáêà ïðèåìà äàííûõ";
$MESS["SASP_AS108"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Ïîäîçðåíèå íà ìîøåííè÷åñòâî";
$MESS["SASP_AS109"]="ÎÒÊÀÇ Â ÀÂÒÎÐÈÇÀÖÈÈ. Ïðåâûøåí ëèìèò îïåðàöèé Assist";
$MESS["SASP_AS200"]="ÏÎÂÒÎÐÈÒÅ ÀÂÒÎÐÈÇÀÖÈÞ";
$MESS["SASP_AS300"]="ÀÂÒÎÐÈÇÀÖÈß Â ÏÐÎÖÅÑÑÅ. ÆÄÈÒÅ";
$MESS["SASP_AS400"]="ÏËÀÒÅÆÀ Ñ ÒÀÊÈÌÈ ÏÀÐÀÌÅÒÐÀÌÈ ÍÅ ÑÓÙÅÑÒÂÓÅÒ";
$MESS["SASP_AS998"]="ÎØÈÁÊÀ ÑÈÑÒÅÌÛ. Ñâÿæèòåñü ñ ASSIST";


$merchant_id = trim($_POST['merchant_id']); //1
$ordernumber = intval($_POST['ordernumber']); // 2
$billnumber = trim($_POST['billnumber']);
$orderamount = floatval($_POST['orderamount']);
$ordercurrency = trim($_POST['ordercurrency']); 
$amount = trim($_POST['amount']); //3
$currency = trim($_POST['currency']); //4

$packetdate = trim($_POST['packetdate']);
$checkvalue = trim($_POST['checkvalue']);
$orderstate = trim($_POST['orderstate']); //5
$responsecode = trim($_POST['responsecode']);
$approvalcode = trim($_POST['approvalcode']);


$message = trim($_POST['message']);
$customermessage = trim($_POST['customermessage']);
$recommendation = trim($_POST['recommendation']);



if($ordernumber <= 0)
	ResponseErrorXML(5, 107); 
if(strlen($merchant_id) <= 0)
	ResponseErrorXML(5, 100); 
if(strlen($billnumber) <= 0)
	ResponseErrorXML(5, 143); 
if(strlen($packetdate) <= 0)
	ResponseErrorXML(5, 104);
if(strlen($amount) <= 0)
	ResponseErrorXML(5, 108);
if(strlen($checkvalue) <= 0)
	ResponseErrorXML(5, 158);


	
	
		
CModule::IncludeModule('sale');
global $APPLICATION;

$rsOrder = CSaleOrder::GetList(array('ID'=>'ASC'),
								array('ID'=>$ordernumber),
								false, array('nTopCount'=>1)
								
						);
$arOrder = $rsOrder->GetNext();

if($arOrder)
{
	
	
	$amount_p = floatval(str_replace(array(',',' '), array('.',''),$amount));
	$price_p = floatval(str_replace(array(',',' '), array('.',''), $arOrder['PRICE']));
	
	// ob_start();
	// echo "\r\namount\r\n";
	// var_dump($amount);
	// echo "\r\namount_fl\r\n";
	// var_dump(floatval($amount));
	// echo "\r\namount_p\r\n";
	// var_dump($ammount_p);
	// echo "\r\nprice\r\n";
	// var_dump($arOrder['PRICE']);
	// echo "\r\nprice_p\r\n";
	// var_dump($price_p);
	// echo "\r\n----Temi4----\r\n";
	// $l = ob_get_contents();
	// ob_end_clean();
	// $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/resassist.txt','a');
	// if($fp)
	// {
		// fputs($fp, $l);
		// fclose($fp);
	// }

	if($amount_p != $price_p)
		ResponseErrorXML(5, 108); 

	
	$rsPSA = CSalePaySystemAction::GetList(
						array(),
						array(
								"PAY_SYSTEM_ID" => $arOrder["PAY_SYSTEM_ID"],
								"PERSON_TYPE_ID" => $arOrder["PERSON_TYPE_ID"]
							),
						false,
						false,
						array("NAME", "ACTION_FILE", "NEW_WINDOW", "PARAMS", "ENCODING")
					);
	if($arPaySysAction = $rsPSA->Fetch())
	{
		CSalePaySystemAction::InitParamArrays($arOrder, $ID, $arPaySysAction["PARAMS"]);
		$SecretWord = CSalePaySystemAction::GetParamValue("PAYMENT_SecretWord");
		
		//uppercase(md5(uppercase(md5(MySecret)+md5(merchant_id+ordernumber+amount+currency+orderstate))))
		$MyCheckvalue = strtoupper(md5(strtoupper(md5($SecretWord).md5($merchant_id.$ordernumber.$amount.$currency.$orderstate))));
		if($MyCheckvalue != $checkvalue)
			ResponseErrorXML(5, 158); 
	
		
		
		$Mymerchant_id = CSalePaySystemAction::GetParamValue("PAYMENT_Merchant_ID");
		if($Mymerchant_id != $merchant_id)
			ResponseErrorXML(5, 100); 
			
		
			$arFields = array(
					"PS_STATUS" => ($responsecode == 'AS000' ? 'Y' : 'N'),
					"PS_STATUS_CODE" => $responsecode,
					"PS_STATUS_DESCRIPTION" => $MESS['SASP_'.$responsecode],
					"PS_STATUS_MESSAGE" => $recommendation,
					"PS_SUM" => $amount_p,
					"PS_CURRENCY" => str_replace('RUR','RUB',$currency),
					"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
					"PAY_VOUCHER_NUM" => $billnumber, 
					"PAY_VOUCHER_DATE"=>$packetdate,
				);
			if ($arOrder["PRICE"] == $amount && $arFields["PS_STATUS"] == "Y")
			{
				CSaleOrder::PayOrder($arOrder["ID"], "Y");
			}
			
			CSaleOrder::Update($arOrder["ID"], $arFields);
		
			ResponseGoodXML($billnumber, $packetdate);
	}
	else
		ResponseErrorXML(1, 0); 

}
else
	ResponseErrorXML(5, 107); 



function ResponseGoodXML($p1, $p2)
{
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	header("Content-Type: text/xml; charset=UTF-8");
	echo GoodResponce($p1, $p2);
	
	
	// ob_start();
	// var_dump($p1);
	// var_dump($p2);
	// $l = ob_get_contents();
	// ob_end_clean();
	// $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/resassist.txt','a');
	// if($fp)
	// {
		// fputs($fp, $l);
		// fclose($fp);
	// }
	
	die();
}

function ResponseErrorXML($p1, $p2)
{
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	ob_end_clean();
	header("Content-Type: text/xml; charset=UTF-8");
	echo ErrorResponce($p1, $p2);
	
	
	// ob_start();
	// echo "--Error--\r\n";
	// var_dump($p1);
	// var_dump($p2);
	// $l = ob_get_contents();
	// ob_end_clean();
	// $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/resassist.txt','a');
	// if($fp)
	// {
		// fputs($fp, $l);
		// fclose($fp);
	// }
	
	die();
}

function GoodResponce($billnumber, $packetdate)
{
	return '<?xml version="1.0" encoding="UTF-8"?><pushpaymentresult firstcode="0" secondcode="0"><order><billnumber>'.$billnumber.'</billnumber><packetdate>'.$packetdate.'</packetdate></order></pushpaymentresult>';
}

function ErrorResponce($firstcode = 0,$secondcode = 0)
{
	return '<?xml version="1.0" encoding="UTF-8"?><pushpaymentresult firstcode="'.$firstcode.'" secondcode="'.$secondcode.'"></pushpaymentresult>';
}

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");



?>