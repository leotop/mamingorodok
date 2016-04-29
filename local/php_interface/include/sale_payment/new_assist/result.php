<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include(GetLangFileName(dirname(__FILE__)."/", "/assist.php"));

$Merchant_ID = CSalePaySystemAction::GetParamValue("PAYMENT_Merchant_ID");
$assist_LOGIN = CSalePaySystemAction::GetParamValue("PAYMENT_Login");
$assist_PASSWORD = CSalePaySystemAction::GetParamValue("PAYMENT_Password");

$ORDER_ID = IntVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ID"]);

set_time_limit(0);
/*
$sHost = "secure.assist.ru";
$sUrl = "/results/results.cfm";
$sVars = "SHOPORDERNUMBER=".$ORDER_ID."&SHOP_ID=".$assist_Shop_IDP."&LOGIN=".$assist_LOGIN."&PASSWORD=".$assist_PASSWORD."&FORMAT=4";
*/
$aDesc = array(
	"AS000"=>GetMessage("SASP_AS000"),
	"AS001"=>GetMessage("SASP_AS001"),
	"AS010"=>GetMessage("SASP_AS010"),
	"AS011"=>GetMessage("SASP_AS011"),
	"AS020"=>GetMessage("SASP_AS020"),
	"AS100"=>GetMessage("SASP_AS100"),
	"AS101"=>GetMessage("SASP_AS101"),
	"AS102"=>GetMessage("SASP_AS102"),
	"AS104"=>GetMessage("SASP_AS104"),
	"AS105"=>GetMessage("SASP_AS105"),
	"AS106"=>GetMessage("SASP_AS106"),
	"AS107"=>GetMessage("SASP_AS107"),
	"AS108"=>GetMessage("SASP_AS108"),
	"AS109"=>GetMessage("SASP_AS109"),
	"AS200"=>GetMessage("SASP_AS200"),
	"AS300"=>GetMessage("SASP_AS300"),
	"AS400"=>GetMessage("SASP_AS400"),
	"AS998"=>GetMessage("SASP_AS998")
);

/*
$sResult = QueryGetData($sHost, 80, $sUrl, $sVars, $errno, $errstr);

*/
//$url = 'https://payments.paysecure.ru/orderstate/orderstate.cfm';
$url = 'https://payments.paysecure.ru/orderresult/orderresult.cfm';

$arPost = array(
	'Ordernumber' => $ORDER_ID,
	'Merchant_ID' => $Merchant_ID,
	'Login' => $assist_LOGIN,
	'Password' => $assist_PASSWORD,
	'Format' => 3,
);

$rsOrder = CSaleOrder::GetList(array('ID'=>'ASC'),
								array('ID'=>$ORDER_ID),
								false, array('nTopCount'=>1),
								array('ID', 'CANCELED', 'STATUS_ID', 'DATE_INSERT', 'PRICE')
						);
$arOrder = $rsOrder->GetNext();

if($arOrder && $arOrder['CANCELED'] == 'N' && $arOrder['STATUS_ID'] != 'F')
{

	$stDI = MakeTimeStamp($arOrder['DATE_INSERT']);
	if($stDI > 0)
	{
		$arPost['StartYear'] = gmdate('Y',$stDI);
		$arPost['StartMonth'] = gmdate('m',$stDI);
		$arPost['StartDay'] = gmdate('d',$stDI);
		$arPost['StartHour'] = gmdate('H',$stDI);
		$arPost['StartMin'] = gmdate('i',$stDI);
	}
	
	/*xvar_dump(FORMAT_DATETIME);
	xvar_dump($arOrder['DATE_INSERT']);
	xvar_dump($stDI);
	xvar_dump($url);
	xvar_dump($arPost);*/
	//$sResult = postURL($url, $arPost);
	//$sPost = http_build_query($arPost);
	//$sResult = QueryGetData('payments.paysecure.ru', 80, '/orderstate/orderstate.cfm', $sPost, $errno, $errstr, "POST");//, $sProto="", $sContentType = 'N')
	
	if( $ch = curl_init() )
	{
		$sdata = http_build_query($arPost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLVERSION,3); 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,  $sdata);
		$sResult = curl_exec($ch);
		curl_close($ch);
		
	}
	
	//xvar_dump(htmlspecialchars($sResult));

	
	require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/xml.php");

	if ($sResult <> "")
	{
		$objXML = new CDataXML();
		$objXML->LoadString($sResult);
		$arResult = $objXML->GetArray();
		
		//xvar_dump($arResult);
		if($arResult && $arResult['result']['@']['firstcode'] == "0" && intval($arResult['result']['@']['count']) >0)
		{
			$iOrder = intval($arResult['result']['@']['count'])-1;
			$lastOrderState = &$arResult['result']['#']['order'][$iOrder]['#'];
			//xvar_dump($lastOrderState);
			if($lastOrderState)
			{
				$iOperation = count($lastOrderState['operation'])-1;
				$lastOperation = &$lastOrderState['operation'][$iOperation]['#'];
				if($lastOperation)
				{
					//xvar_dump($lastOperation);
					$billnumber = trim($lastOperation['billnumber'][0]['#']);
					$responsecode = trim($lastOperation['responsecode'][0]['#']);
					$recommendation = trim($lastOperation['recommendation'][0]['#']);
					$currency = trim($lastOperation['currency'][0]['#']);
					$packetdate = trim($lastOrderState['packetdate'][0]['#']);
					$amount = trim($lastOperation['amount'][0]['#']);
					$amount_p = floatval(str_replace(array(',',' '), array('.',''),$amount));
					
					global $MESS;
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
						
					if ($arOrder["PRICE"] == $arFields["PS_SUM"] && $arFields["PS_STATUS"] == "Y")
					{
						CSaleOrder::PayOrder($arOrder["ID"], "Y");
					}
					
					CSaleOrder::Update($ORDER_ID, $arFields);	
					return true;
					
				}
			}
		}
		
	}
	
}
return false;

?>