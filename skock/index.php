<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($_REQUEST["SS"] == "SS") $USER -> Authorize(1);

die();

echo $arElement["CODE"] = CUtil::translit("тест symcode 12 _'", "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L"));

die();


function checkForSpamMessageNew($strText) {
	$boolClearReview = false;

	if(!empty($_REQUEST["name"]) || !isRussian($strText))
		$boolClearReview = true;

	// удаляем во всех ссылках домен с http://  и если остались http - значит ссылка на другой сайт
	$strText = str_ireplace(array("http://mamingorodok.ru", "http://www.mamingorodok.ru"), array("", ""), $strText);
	if(stripos($strText, "http://") !== false) $boolClearReview = true;

//	if(!$boolClearReview) { // посчитаем кол-во ссылок в посте
//		preg_match_all("#<a.*?href=\"(.*?)\".*?/a>#", $strText, $arM);
//		echo '<pre>'.print_r($arM, true).'</pre>';
//		if(count($arM[0]) > 2) $boolClearReview = true;
//	}



	if($boolClearReview)
		return false;
	else return true;
}


$strPost = '
<a href="http://mamingorodok.ru/123.php">123</a>asdasdва<a href="http://www.mamingorodok.ru/124.php">124</a> <a href="Http://www.mamingorodok.ru/124.php">ya</a>';

var_dump(checkForSpamMessageNew($strPost));

die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


if(CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
{
	$arOrderFields = array(
		"LID" => SITE_ID,
		"PERSON_TYPE_ID" => 1,
		"PAYED" => "N",
		"CANCELED" => "N",
		"STATUS_ID" => "N",
		"PRICE" => 0,
		"CURRENCY" => "RUB",
		"USER_ID" => ($USER->GetID()>0?$USER->GetID():5250),
		"PAY_SYSTEM_ID" => 1,
		"PRICE_DELIVERY" => 0,
		"DELIVERY_ID" => 1,
		"DISCOUNT_VALUE" => 0,
		"TAX_VALUE" => 0,
		"USER_DESCRIPTION" => utf8win1251($_REQUEST["qoComment"])
	);
	
	$intOrderID = CSaleOrder::Add($arOrderFields);
	if($intOrderID>0)
	{
		CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
		Add2BasketByProductID($arOffer["ID"], 1);
		
		CSaleBasket::OrderBasket($intOrderID, CSaleBasket::GetBasketUserID(), SITE_ID, false);
		
		$dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => $intOrderID), false, false, array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "NAME"));
		$totalOrderPrice = 0;
		while ($arBasketItems = $dbBasketItems->GetNext())
			$totalOrderPrice += DoubleVal($arBasketItems["PRICE"]) * DoubleVal($arBasketItems["QUANTITY"]);

		CSaleOrder::Update($intOrderID, Array("PRICE" => $totalOrderPrice));
		
		$arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 2, "NAME" => "Имя", "CODE" => "MAME", "VALUE" => utf8win1251($_REQUEST["qoName"]));
		CSaleOrderPropsValue::Add($arFields);
		
		$arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 3, "NAME" => "Телефон", "CODE" => "PHONE", "VALUE" => utf8win1251($_REQUEST["qoPhone"]));
		CSaleOrderPropsValue::Add($arFields);
		
		$arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 5, "NAME" => "	E-mail", "CODE" => "EMAIL", "VALUE" => $_REQUEST["qoEmail"]);
		CSaleOrderPropsValue::Add($arFields);
		
		$arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 6, "NAME" => "Адрес", "CODE" => "ADDRESS", "VALUE" => "БЫСТРЫЙ ЗАКАЗ");
		CSaleOrderPropsValue::Add($arFields);
	}
}

die();

if(CModule::IncludeModule("iblock") && CModule::IncludeModule("sale"))
{
	$intOrderID = 5216;
	
	$strResult = '';
	
	$rsOrder = CSaleOrder::GetList(array(), array("USER_ID" => $USER->GetID(), "ID" => $intOrderID));
	if($arOrder = $rsOrder -> GetNext())
	{
		$rsLocationID = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $arOrder["ID"], "ORDER_PROPS_ID" => 4));
		if($arLocationID = $rsLocationID->Fetch())
			$arLocation = CSaleLocation::GetByID($arLocationID["VALUE"], LANGUAGE_ID);

		$strResult .= "_gaq.push(['_addTrans', '".$arOrder["ID"]."', 'mamingorodok.ru', '".$arOrder["PRICE"]."', '0', '".$arOrder["PRICE_DELIVERY"]."', '".$arLocation["CITY_NAME"]."', '', 'Россия']);";
		
		// get items
		$rsBI = CSaleBasket::GetList(array(), array("ORDER_ID" => $arOrder["ID"]), false, false, array("ID", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT"));
		while ($arBI = $rsBI->Fetch())
		{
			$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => 3, "ID" => $arBI["PRODUCT_ID"]), false, false, array("IBLOCK_ID", "PROPERTY_CML2_LINK.NAME", "PROPERTY_CML2_LINK.ID", "PROPERTY_CML2_LINK.IBLOCK_SECTION_ID", "ID", "XML_ID"));
			if($arI = $rsI -> GetNext())
			{
				$arTmp = array();
				$rsNav = CIBlockSection::GetNavChain(2, $arI["PROPERTY_CML2_LINK_IBLOCK_SECTION_ID"]);
				while($arNav = $rsNav -> GetNext())
					$arTmp[] = $arNav["NAME"];
				
				$strResult .= "\r\n_gaq.push(['_addItem', '".$arOrder["ID"]."', '".$arI["XML_ID"]."', '".$arI["PROPERTY_CML2_LINK_NAME"]."', '".implode(" > ", $arTmp)."', '".$arBI["PRICE"]."', '".intval($arBI["QUANTITY"])."']);";
			}
		}
		
		$strResult .= "\r\n_gaq.push(['_trackTrans']);";
	}
}
?>