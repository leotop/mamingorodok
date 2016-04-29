<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?
include(GetLangFileName(dirname(__FILE__)."/", "/assist.php"));

$psTitle = "New Assist (одностадийный)";
$psDescription = GetMessage("SALE_ASSIST_DESCRIPTION");

$arPSCorrespondence = array(
		"PAYMENT_Merchant_ID" => array(
				"NAME" => GetMessage("SALE_ASSIST_SHOP_IDP_NAME"), 
				"DESCR" => GetMessage("SALE_ASSIST_SHOP_IDP_DESCR"),
				"VALUE" => "",
				"TYPE" => ""
			),
		"PAYMENT_Login" => array(
				"NAME" => GetMessage("SALE_ASSIST_SHOP_LOGIN_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_SHOP_LOGIN_DESCR"),
				"VALUE" => "",
				"TYPE" => ""
			),
		"PAYMENT_Password" => array(
				"NAME" => GetMessage("SALE_ASSIST_SHOP_PASSWORD_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_SHOP_PASSWORD_DESCR"),
				"VALUE" => "",
				"TYPE" => ""
			),
		"PAYMENT_SecretWord" => array(
				"NAME" => 'Секретное слово',
				"DESCR" => 'Для проверки получения оплаты',
				"VALUE" => "",
				"TYPE" => ""
			),
			
		"SHOULD_PAY" => array(
				"NAME" => GetMessage("SALE_ASSIST_SHOULD_PAY"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_SHOULD_PAY"),
				"VALUE" => "SHOULD_PAY",
				"TYPE" => "ORDER"
			),
		"CURRENCY" => array(
				"NAME" => GetMessage("SALE_ASSIST_CURRENCY"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_CURRENCY"),
				"VALUE" => "CURRENCY",
				"TYPE" => "ORDER"
			),

		"ORDER_ID" => array(
				"NAME" => GetMessage("SALE_ASSIST_ORDER_ID"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_ORDER_ID"),
				"VALUE" => "ID",
				"TYPE" => "ORDER"
			),
		"DATE_INSERT" => array(
				"NAME" => GetMessage("SALE_ASSIST_DATE_INSERT"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_DATE_INSERT"),
				"VALUE" => "DATE_INSERT",
				"TYPE" => "ORDER"
			),
		// URL_RETURN_OK 
		"SUCCESS_URL" => array(
				"NAME" => GetMessage("SALE_ASSIST_SUCCESS_URL"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_SUCCESS_URL"),
				"VALUE" => "/personal/order/result/ok/",
				"TYPE" => ""
			),
		// URL_RETURN_NO
		"FAIL_URL" => array(
				"NAME" => GetMessage("SALE_ASSIST_FAIL_URL"),
				"DESCR" => GetMessage("SALE_ASSIST_DESC_FAIL_URL"),
				"VALUE" => "/personal/order/result/error/",
				"TYPE" => ""
			),
		'PAYMENT_Language' => array(
				"NAME" => 'Язык юр.лица или предприятия',
				"DESCR" => 'Язык авторизационных страниц',
				"VALUE" => "RU",
				"TYPE" => ""
		),
		
		'PAYMENT_isConvert' => array(
				"NAME" => 'Признак конвертации валюты заказа',
				"DESCR" => '0 - не конвертировать, 1 – не конвертировать при возможности, 2 - всегда конвертировать в базовую валюту',
				"VALUE" => "1",
				"TYPE" => "",
		),
			
		
		//Firstname
		"FIRST_NAME" => array(
				"NAME" => GetMessage("SALE_ASSIST_FIRST_NAME_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_FIRST_NAME_DESC"),
				"VALUE" => "FIRST_NAME",
				"TYPE" => "PROPERTY"
			),
		//Middlename
		"MIDDLE_NAME" => array(
				"NAME" => GetMessage("SALE_ASSIST_MIDDLE_NAME_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_MIDDLE_NAME_DESC"),
				"VALUE" => "",
				"TYPE" => ""
			),
		// Lastname
		"LAST_NAME" => array(
				"NAME" => GetMessage("SALE_ASSIST_LAST_NAME_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_LAST_NAME_DESC"),
				"VALUE" => "",
				"TYPE" => ""
			),
		//Email
		"EMAIL" => array(
				"NAME" => GetMessage("SALE_ASSIST_EMAIL_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_EMAIL_DESC"),
				"VALUE" => "EMAIL",
				"TYPE" => "PROPERTY"
			),
		// Address
		"ADDRESS" => array(
				"NAME" => GetMessage("SALE_ASSIST_ADDRESS_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_ADDRESS_DESC"),
				"VALUE" => "ADDRESS",
				"TYPE" => "PROPERTY"
			),
		"PHONE" => array(
				"NAME" => GetMessage("SALE_ASSIST_PHONE_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PHONE_DESC"),
				"VALUE" => "PHONE",
				"TYPE" => "PROPERTY"
			),
			
		"Country" => array(
				"NAME" => 'Страна покупателя',
				"DESCR" => '',
				"VALUE" => "RUS",
				"TYPE" => ""
			),
		
		"State" => array(
				"NAME" => 'Регион покупателя',
				"DESCR" => '',
				"VALUE" => "77",
				"TYPE" => ""
			),
			
		"City" => array(
				"NAME" => 'Город покупателя',
				"DESCR" => '',
				"VALUE" => "Москва",
				"TYPE" => ""
			),
		
		
		"PAYMENT_CardPayment" => array(
				"NAME" => GetMessage("SALE_ASSIST_PAYMENT_CardPayment_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PAYMENT_CardPayment_DESC"),
				"VALUE" => "1",
				"TYPE" => ""
			),
		"PAYMENT_YMPayment" => array(
				"NAME" => GetMessage("SALE_ASSIST_PAYMENT_YMPayment_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PAYMENT_YMPayment_DESC"),
				"VALUE" => "1",
				"TYPE" => ""
			),
		"PAYMENT_WMPayment" => array(
				"NAME" => GetMessage("SALE_ASSIST_PAYMENT_WMPayment_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PAYMENT_WMPayment_DESC"),
				"VALUE" => "1",
				"TYPE" => "",
			),
		"PAYMENT_QIWIPayment" => array(
				"NAME" => GetMessage("SALE_ASSIST_PAYMENT_QIWIPayment_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PAYMENT_QIWIPayment_DESC"),
				"VALUE" => "1",
				"TYPE" => "",
			),
		"PAYMENT_AssistIDPayment" => array(
				"NAME" => GetMessage("SALE_ASSIST_PAYMENT_AssistIDPayment_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_PAYMENT_AssistIDPayment_DESC"),
				"VALUE" => "1",
				"TYPE" => "",
			),
		

		"PAYMENT_TestMode" => array(
				"NAME" => GetMessage("SALE_ASSIST_DEMO_NAME"),
				"DESCR" => GetMessage("SALE_ASSIST_DEMO_DESC"),
				"VALUE" => "1",
				"TYPE" => "",
			),
	);
?>
