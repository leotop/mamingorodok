<?
//<title>Yandex</title>
set_time_limit(0);

global $USER, $APPLICATION;
$bTmpUserCreated = False;

if (!isset($USER) || !is_a($GLOBALS['USER'], 'CUser'))
{
	$bTmpUserCreated = True;
	if (isset($USER))
	{
		$USER_TMP = $USER;
	}
	
	$USER = new CUser();
}

$arYandexFields = array('store','pickup','delivery','local_delivery_cost','vendor', 'vendorCode', 'model', 'author', 'name', 'publisher', 'year', 'ISBN', 'volume', 'part', 'language', 'binding', 'page_extent', 'table_of_contents', 'performed_by', 'performance_type', 'storage', 'format', 'recording_length', 'series', 'artist', 'title', 'year', 'media', 'starring', 'director', 'originalName', 'country', 'description', 'sales_notes', 'promo', 'aliases', 'provider', 'tarifplan', 'xCategory', 'additional', 'worldRegion', 'region', 'days', 'dataTour', 'hotel_stars', 'room', 'meal', 'included', 'transport', 'price_min', 'price_max', 'options', 'manufacturer_warranty', 'country_of_origin', 'downloadable', 'param', 'place', 'hall', 'hall_part', 'is_premiere', 'is_kids', 'date');

if (!function_exists("yandex_replace_special"))
{
	function yandex_replace_special($arg)
	{
		if (in_array($arg[0], array("&quot;", "&amp;", "&lt;", "&gt;")))
			return $arg[0];
		else
			return " ";
	}
}

if (!function_exists("yandex_text2xml"))
{
	function yandex_text2xml($text, $bHSC = false)
	{
		$text = $GLOBALS['APPLICATION']->ConvertCharset($text, LANG_CHARSET, 'windows-1251');
		
		if ($bHSC)
			$text = htmlspecialchars($text);
		$text = preg_replace("/[\x1-\x8\xB-\xC\xE-\x1F]/", "", $text);
		$text = str_replace("'", "&apos;", $text);
		return $text; 
	}
}

if (!function_exists('yandex_get_value'))
{
	function yandex_get_value($arOffer, $param, $PROPERTY)
	{
		global $IBLOCK_ID;
		static $arProperties = null, $arUserTypes = null;
		
		if (!is_array($arProperties))
		{
			$dbRes = CIBlockProperty::GetList(
				array('id' => 'asc'), 
				array('IBLOCK_ID' => $IBLOCK_ID, 'CHECK_PERMISSIONS' => 'N')
			);
			
			while ($arRes = $dbRes->Fetch())
			{
				$arProperties[$arRes['ID']] = $arRes;
			}
		}
		
		$strProperty = '';
		$bParam = substr($param, 0, 6) == 'PARAM_';
		if (is_array($arProperties[$PROPERTY]))
		{
			$PROPERTY_CODE = $arProperties[$PROPERTY]['CODE'];
			
			$arProperty = $arOffer['PROPERTIES'][$PROPERTY_CODE] ? $arOffer['PROPERTIES'][$PROPERTY_CODE] : $arOffer['PROPERTIES'][$PROPERTY];
			
			$value = '';
			$description = '';
			switch ($arProperties[$PROPERTY]['PROPERTY_TYPE'])
			{
				case 'E':
					$dbRes = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $arProperties[$PROPERTY]['LINK_IBLOCK_ID'], 'ID' => $arProperty['VALUE']), false, false, array('NAME'));
					while ($arRes = $dbRes->Fetch())
					{
						$value .= ($value ? ', ' : '').$arRes['NAME'];
					}
				break;
				case 'G':
					$dbRes = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $arProperty['LINK_IBLOCK_ID'], 'ID' => $arProperty['VALUE']));
					while ($arRes = $dbRes->Fetch())
					{
						$value .= ($value ? ', ' : '').$arRes['NAME'];
					}
				break;
				case 'L':
					if ($arProperty['VALUE'])
					{
						if (is_array($arProperty['VALUE']))
							$value .= implode(', ', $arProperty['VALUE']);
						else
							$value .= $arProperty['VALUE'];
					}

				break;

				
				default: 
					if ($bParam && $arProperty['WITH_DESCRIPTION'] == 'Y')
					{
						$description = $arProperty['DESCRIPTION'];
						$value = $arProperty['VALUE'];
					}
					else
					{
						$value = is_array($arProperty['VALUE']) ? implode(', ', $arProperty['VALUE']) : $arProperty['VALUE'];
					}
			}
			
			// !!!! check multiple properties and properties like CML2_ATTRIBUTES
			
			if ($bParam)
			{
				if (is_array($description))
				{
					foreach ($value as $key => $val)
					{
						$strProperty .= $strProperty ? "\n" : "";
						$strProperty .= '<param name="'.yandex_text2xml($description[$key], true).'">'.yandex_text2xml($val).'</param>';
					}
				}
				else
				{
					$strProperty .= '<param name="'.yandex_text2xml($arProperties[$PROPERTY]['NAME'], true).'">'.yandex_text2xml($value).'</param>';
				}
			}
			else
			{
				$param_h = yandex_text2xml($param, true);
				$strProperty .= '<'.$param_h.'>'.yandex_text2xml($value).'</'.$param_h.'>';
			}
		}

		return $strProperty;
		//if (is_callable(array($arParams["arUserField"]["USER_TYPE"]['CLASS_NAME'], 'getlist')))
	}
}

$strExportErrorMessage = "";
if ($XML_DATA && CheckSerializedData($XML_DATA))
{
	$XML_DATA = unserialize(stripslashes($XML_DATA));
	if (!is_array($XML_DATA)) $XML_DATA = array();
}

$GLOBALS['IBLOCK_ID'] = IntVal($IBLOCK_ID);
$db_iblock = CIBlock::GetByID($IBLOCK_ID);
if (!($ar_iblock = $db_iblock->Fetch()))
	$strExportErrorMessage .= "Information block #".$IBLOCK_ID." does not exist.\n";
else
{
	$SETUP_SERVER_NAME = trim($SETUP_SERVER_NAME);

	if (strlen($SETUP_SERVER_NAME) <= 0)
	{
		if (strlen($ar_iblock['SERVER_NAME']) <= 0)
		{
			$rsSite = CSite::GetList(($b="sort"), ($o="asc"), array("LID" => $ar_iblock["LID"]));
			if($arSite = $rsSite->Fetch())
				$ar_iblock["SERVER_NAME"] = $arSite["SERVER_NAME"];
			if(strlen($ar_iblock["SERVER_NAME"])<=0 && defined("SITE_SERVER_NAME"))
				$ar_iblock["SERVER_NAME"] = SITE_SERVER_NAME;
			if(strlen($ar_iblock["SERVER_NAME"])<=0)
				$ar_iblock["SERVER_NAME"] = COption::GetOptionString("main", "server_name", "");
		}
	}
	else
	{
		$ar_iblock['SERVER_NAME'] = $SETUP_SERVER_NAME;
	}
}

if (strlen($strExportErrorMessage)<=0)
{
	$bAllSections = False;
	$arSections = array();
	if (is_array($V))
	{
		foreach ($V as $key => $value)
		{
			if (trim($value)=="0")
			{
				$bAllSections = True;
				break;
			}
			
			if (IntVal($value)>0)
			{
				$arSections[] = IntVal($value);
			}
		}
	}

	if (!$bAllSections && count($arSections)<=0)
		$strExportErrorMessage .= "Section list is not set.\n";
}

$SETUP_FILE_NAME = Rel2Abs("/", $SETUP_FILE_NAME);
/*
if (strtolower(substr($SETUP_FILE_NAME, strlen($SETUP_FILE_NAME)-4)) != ".csv")
	$SETUP_FILE_NAME .= ".csv";
*/
global $NochekMoreParam;
if($NochekMoreParam!=true){
if (!$bTmpUserCreated && $GLOBALS["APPLICATION"]->GetFileAccessPermission($SETUP_FILE_NAME) < "W")
	$strExportErrorMessage .= str_replace("#FILE#", $SETUP_FILE_NAME, "Not enough access rights to replace file #FILE#")."<br>";
}
if (strlen($strExportErrorMessage)<=0)
{
	if($NochekMoreParam!=true){
	CheckDirPath($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME);
	}
	if(!isset($_SERVER["DOCUMENT_ROOT"]) || empty($_SERVER["DOCUMENT_ROOT"]))
		$_SERVER["DOCUMENT_ROOT"] = "/data/mamingorodok.ru/docs";
	file_put_contents("/data/mamingorodok.ru/docs/imp_ya.txt", var_export(array($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME), true));
	if (!$fp = @fopen($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME, "wb"))
	{
		$strExportErrorMessage .= "Can not open \"".$_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME."\" file for writing.\n";
	}
	else
	{
		
		if (!@fwrite($fp, '<?if (!isset($_GET["referer1"]) || strlen($_GET["referer1"])<=0) $_GET["referer1"] = "yandext";?>'))
		{
			$strExportErrorMessage .= "Can not write in \"".$_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME."\" file.\n";
			@fclose($fp);
		}
		else
		{
			fwrite($fp, '<?if (!isset($_GET["referer2"])) $_GET["referer2"] = "";?>');
		}
	}
}

if (strlen($strExportErrorMessage)<=0)
{
	@fwrite($fp, '<? header("Content-Type: text/xml; charset=windows-1251");?>');
	@fwrite($fp, '<? echo "<"."?xml version=\"1.0\" encoding=\"windows-1251\"?".">"?>');
	@fwrite($fp, "\n<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n");
	@fwrite($fp, "<yml_catalog date=\"".Date("Y-m-d H:i")."\">\n");
	@fwrite($fp, "<shop>\n");

	@fwrite($fp, "<name>".htmlspecialchars($APPLICATION->ConvertCharset(COption::GetOptionString("main", "site_name", ""), LANG_CHARSET, 'windows-1251'))."</name>\n");

	@fwrite($fp, "<company>".htmlspecialchars($APPLICATION->ConvertCharset(COption::GetOptionString("main", "site_name", ""), LANG_CHARSET, 'windows-1251'))."</company>\n");
	@fwrite($fp, "<url>http://".htmlspecialchars($ar_iblock['SERVER_NAME'])."</url>\n");

	$strTmp = "<currencies>\n";

	if ($arCurrency = CCurrency::GetByID('RUR'))
		$RUR = 'RUR';
	else
		$RUR = 'RUB';

	$arCurrencyAllowed = array($RUR, 'USD', 'EUR', 'UAH', 'BYR', 'KZT');

	$BASE_CURRENCY = CCurrency::GetBaseCurrency();
	if (is_array($XML_DATA['CURRENCY']))
	{
		foreach ($XML_DATA['CURRENCY'] as $CURRENCY => $arCurData)
		{
			if (in_array($CURRENCY, $arCurrencyAllowed))
			{
				$strTmp.= "<currency id=\"".$CURRENCY."\""
				." rate=\"".($arCurData['rate'] == 'SITE' ? CCurrencyRates::ConvertCurrency(1, $CURRENCY, $RUR) : $arCurData['rate'])."\""
				.($arCurData['plus'] > 0 ? ' plus="'.intval($arCurData['plus']).'"' : '') 
				." />\n";
			}
		}
	}
	else
	{
		$db_acc = CCurrency::GetList(($by="sort"), ($order="asc"));
		while ($arAcc = $db_acc->Fetch())
		{
			if (in_array($arAcc['CURRENCY'], $arCurrencyAllowed))
				$strTmp.= "<currency id=\"".$arAcc["CURRENCY"]."\" rate=\"".(CCurrencyRates::ConvertCurrency(1, $arAcc["CURRENCY"], $RUR))."\"/>\n";
		}
	}
	$strTmp.= "</currencies>\n";

	@fwrite($fp, $strTmp);

	//*****************************************//

	$arSelect = array("ID", "LID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE", "DETAIL_PICTURE", "DETAIL_TEXT", "DETAIL_TEXT_TYPE", "LANG_DIR", "DETAIL_PAGE_URL");
	
	$db_res = CCatalogGroup::GetGroupsList(array("GROUP_ID"=>2));
	$arPTypes = array();
	while ($ar_res = $db_res->Fetch())
	{
		if (!in_array($ar_res["CATALOG_GROUP_ID"], $arPTypes))
		{
			$arPTypes[] = $ar_res["CATALOG_GROUP_ID"];
			$arSelect[] = "CATALOG_GROUP_".$ar_res["CATALOG_GROUP_ID"];
		}
	}
	
	$strTmpCat = "";
	$strTmpOff = "";

	$arAvailGroups = array();
	if (!$bAllSections)
	{
		for ($i = 0; $i < count($arSections); $i++)
		{
			$filter_tmp = $filter;
			$db_res = CIBlockSection::GetNavChain($IBLOCK_ID, $arSections[$i]);
			$curLEFT_MARGIN = 0;
			$curRIGHT_MARGIN = 0;
			while ($ar_res = $db_res->Fetch())
			{
				$curLEFT_MARGIN = IntVal($ar_res["LEFT_MARGIN"]);
				$curRIGHT_MARGIN = IntVal($ar_res["RIGHT_MARGIN"]);
				$arAvailGroups[] = array(
					"ID" => IntVal($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
					);
			}

			$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, ">LEFT_MARGIN"=>$curLEFT_MARGIN, "<RIGHT_MARGIN"=>$curRIGHT_MARGIN, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
			$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
			while ($ar_res = $db_res->Fetch())
			{
				$arAvailGroups[] = array(
					"ID" => IntVal($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
					);
			}
		}
		$cnt_arAvailGroups = count($arAvailGroups);
		for ($i = 0; $i < $cnt_arAvailGroups-1; $i++)
		{
			if (!isset($arAvailGroups[$i])) continue;

			for ($j = $i + 1; $j < $cnt_arAvailGroups; $j++)
			{
				if (!isset($arAvailGroups[$j])) continue;

				if ($arAvailGroups[$i]["ID"]==$arAvailGroups[$j]["ID"])
				{
					unset($arAvailGroups[$j]);
				}
			}
		}
	}
	else
	{
		$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
		$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
		while ($ar_res = $db_res->Fetch())
		{
			$arAvailGroups[] = array(
				"ID" => IntVal($ar_res["ID"]),
				"IBLOCK_SECTION_ID" => IntVal($ar_res["IBLOCK_SECTION_ID"]),
				"NAME" => $ar_res["NAME"]
				);
		}
	}

	$arSectionIDs = array();
	foreach ($arAvailGroups as $key => $value)
	{
		$strTmpCat.= "<category id=\"".$value["ID"]."\"".(IntVal($value["IBLOCK_SECTION_ID"])>0?" parentId=\"".$value["IBLOCK_SECTION_ID"]."\"":"").">".yandex_text2xml($value["NAME"], true)."</category>\n";
		$arSectionIDs[] = $value["ID"];
	}

	//*****************************************//
	

	$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "!PROPERTY_IMPORT2YM"=>2100912);
	////<!----------------------------
	//// Допил инди Темы4
		if (isset($XML_DATA["AVAILABILITY"]))
			$AVAILABILITY = $XML_DATA["AVAILABILITY"];
		else
			$AVAILABILITY = 1;
			
		if (isset($XML_DATA["NULL_PRICE"]))
			$NULL_PRICE = $XML_DATA["NULL_PRICE"];
		else
			$NULL_PRICE = 0;
		// if($NULL_PRICE==0){
			// $filter["!PROPERTY_PRICE"]="";
		// }
	////ИНФО
	////$AVAILABILITY - Выгружать только имеющиеся в наличии товары	
	////$NULL_PRICE - Выгружать товары с ценой 0
	////------------------------------>>
	
	if (!$bAllSections)
	{
		$filter["INCLUDE_SUBSECTIONS"] = "Y";
		$filter["SECTION_ID"] = $arSectionIDs;
	}
	
	$res = CIBlockElement::GetList(array(), $filter, false, false, $arSelect);
	$db_acc = new CIBlockResult($res);
	
	$total_sum = 0;
	$is_exists = false;
	$cnt = 0;

	while ($obElement = $db_acc->GetNextElement())
	{
		$arAcc = $obElement->GetFields();
		
			$arAcc["PROPERTIES"] = $obElement->GetProperties();
			
		///<!-- допил
			$arFilter = Array(   
				"IBLOCK_ID"=>OFFERS_IBLOCK_ID, 
				"ACTIVE"=>"Y",    
				"PROPERTY_CML2_LINK"=>$arAcc["ID"]   
			);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("*"));
			$IDs = array();
			while($ar_fields = $res->GetNext())
			{
				$arAcc["SUB_PRODUCT"][$ar_fields["ID"]]["INFO"] = $ar_fields;
				$IDs[] = $ar_fields["ID"];
			}
			
			$QUANTITY = 0;
			$MIN_PRICE = 0;
			$MIN_CUR = "";
			
			$productHasOfeerWithQuantityMoreThan2 = false;
			
			if(count($IDs))
			{
				$arFilter = array("ID"=>$IDs);
				$res = CCatalogProduct::GetList( Array("SORT"=>"ASC"), $arFilter, false,false,array("*"));
				
				$arTmpQuantity = array();
				
				while($ar_fields = $res->GetNext())
				{
					$arTmpQuantity[$ar_fields["ID"]] = $ar_fields["QUANTITY"];
					$arAcc["SUB_PRODUCT"][$ar_fields["ID"]]["CATALOG"] = $ar_fields;
					$QUANTITY += $ar_fields["QUANTITY"];
					if($ar_fields["QUANTITY"]>=3) $productHasOfeerWithQuantityMoreThan2 = true;
				}
				
				$db_res = CPrice::GetList(array(), array("PRODUCT_ID" => $IDs)	);
				while ($ar_res = $db_res->Fetch())
				{
					if($arTmpQuantity[$ar_res["PRODUCT_ID"]]>=3)
					{
						if($MIN_PRICE==0 && $ar_res["PRICE"]>0)
						{
							$MIN_PRICE = $ar_res["PRICE"];
							$MIN_CUR = $ar_res["CURRENCY"];
						}
						
						if($ar_res["PRICE"]>0 && $MIN_PRICE>$ar_res["PRICE"])
						{
							$MIN_PRICE = $ar_res["PRICE"];
							$MIN_CUR = $ar_res["CURRENCY"];
						}
					
						$arAcc["SUB_PRODUCT"][$ar_res["PRODUCT_ID"]]["PRICE"] = $ar_res;
					}
				}
			}
			
			if(!$productHasOfeerWithQuantityMoreThan2) continue; // Хотя бы один цветоразмер (характеристика) есть в наличии в количестве 3 и более (>=3).
			
			$res = CIBlockElement::GetByID($arAcc["PROPERTIES"]["CH_PRODUCER"]["VALUE"]);
			if($ar_res = $res->GetNext()) 
				$arAcc["PROPERTIES"]["CH_PRODUCER"]["VALUE"] = $ar_res["NAME"];
			if(empty($arAcc["PROPERTIES"]["manufacturer_warrant"]["VALUE"])){
				$arAcc["PROPERTIES"]["manufacturer_warrant"]["VALUE"] = "true";
			}
			

			
		
		
		
		
		//Не выгружаем товары которых нет в наличии
		if($AVAILABILITY==1 && $QUANTITY<=0){
			continue;
		}
		
		//Не выгружаем товары у которых цена 0
		if($NULL_PRICE==0 && $MIN_PRICE==0){
			continue;
		}
		///--->>>
		
		if (CModule::IncludeModule("sale")){
		
		//Москва
		$DELIVERY_LOCATION = 1732;
		
		
		$arFilter = array(
				//"LID" => SITE_ID,
				"!ID"=>"2",
				//"+<=ORDER_PRICE_FROM" => $MIN_PRICE,
				//">=ORDER_PRICE_TO" => $MIN_PRICE,
				"ACTIVE" => "Y",
				"LOCATION" => $DELIVERY_LOCATION        
			);
		$db_dtype = CSaleDelivery::GetList(   
			array(            
				"SORT" => "ASC",
				"NAME" => "ASC"        
			),    
			$arFilter ,    false,    false,    array());
			$price_devel = -1;
			$tt = array();
			while ($ar_dtype = $db_dtype->Fetch()){  
				if($ar_dtype["ID"]==2)
					continue;
				$tt[] = $ar_dtype;
				if($ar_dtype["PRICE"]>$price_devel)
					$price_devel = $ar_dtype["PRICE"];
						
			}
			//if($MIN_PRICE<2000 && $MIN_PRICE>1000){
				//print_R($tt);
			//die($price_devel);
			//}
			foreach($tt as $k=>$t){

				if($t["ORDER_PRICE_FROM"]<=$MIN_PRICE){
				
					
					if($t["ORDER_PRICE_TO"]>0 && $t["ORDER_PRICE_TO"]>=$MIN_PRICE){
						if($price_devel>$t["PRICE"])
							$price_devel  = $t["PRICE"];
					}
					else{
						if($price_devel>$t["PRICE"])
							$price_devel  = $t["PRICE"];
					}
				}
			}		
						
					// if($MIN_PRICE<2000 && $MIN_PRICE>1000)
						// print_R($ar_dtype);
				
					
				// if($price_devel>$ar_dtype["PRICE"])
					// $price_devel = $ar_dtype["PRICE"];
					// $price_devel = explode(".",$price_devel);
					// $price_devel= $price_devel[0];
					$price_devel = intval($price_devel);
			//die($price_devel);
			
		}
		
		//$XML_DATA['TYPE'] == 'vendor.model'
		///<!-- допил
		$str_QUANTITY = $QUANTITY;
		///--->>>
		//$str_QUANTITY_TRACE = $arAcc["CATALOG_QUANTITY_TRACE"];
		if ($str_QUANTITY <= 0)
			$str_AVAILABLE = ' available="false"';
		else
			$str_AVAILABLE = ' available="true"';
		
		// TODO: use PRICE setting. this code is only for PRICE=0

		///<!-- допил
		$minPrice = $MIN_PRICE;
		$minPriceRUR = $MIN_PRICE;
		$minPriceGroup = $XML_DATA['PRICE'];
		$minPriceCurrency = $BASE_CURRENCY;
		///--->>>
		
		

		//if ($minPrice <= 0) continue;

		$bNoActiveGroup = True;
		$strTmpOff_tmp = "";
		$db_res1 = CIBlockElement::GetElementGroups($arAcc["ID"]);
		while ($ar_res1 = $db_res1->Fetch())
		{
			if (in_array(IntVal($ar_res1["ID"]), $arSectionIDs))
			{
				$strTmpOff_tmp.= "<categoryId>".$ar_res1["ID"]."</categoryId>\n";
				$bNoActiveGroup = False;
			}
		}
		if ($bNoActiveGroup) continue;

		if (strlen($arAcc['DETAIL_PAGE_URL']) <= 0) $arAcc['DETAIL_PAGE_URL'] = '/';
		else $arAcc['DETAIL_PAGE_URL'] = str_replace(' ', '%20', $arAcc['DETAIL_PAGE_URL']);
		
		if (is_array($XML_DATA) && $XML_DATA['TYPE'] && $XML_DATA['TYPE'] != 'none')
			$str_TYPE = ' type="'.htmlspecialchars($XML_DATA['TYPE']).'"';
		else
			$strType = '';
			
		$strTmpOff.= "<offer id=\"".$arAcc["ID"]."\"".$str_TYPE.$str_AVAILABLE.">\n";
		$strTmpOff.= "<url>http://".$ar_iblock['SERVER_NAME'].htmlspecialchars($arAcc["~DETAIL_PAGE_URL"]).(strstr($arAcc['DETAIL_PAGE_URL'], '?') === false ? '?' : '&amp;')."r1=<?echo \$_GET[\"referer1\"] ?>&amp;r2=<?echo \$_GET[\"referer2\"] ?></url>\n";

		$strTmpOff.= "<price>".$minPrice."</price>\n";
		$strTmpOff.= "<currencyId>".$minPriceCurrency."</currencyId>\n";

		$strTmpOff.= $strTmpOff_tmp;

		if (IntVal($arAcc["DETAIL_PICTURE"])>0 || IntVal($arAcc["PREVIEW_PICTURE"])>0)
		{
			$pictNo = IntVal($arAcc["DETAIL_PICTURE"]);
			if ($pictNo<=0) $pictNo = IntVal($arAcc["PREVIEW_PICTURE"]);

			$db_file = CFile::GetByID($pictNo);
			if ($ar_file = $db_file->Fetch())
			{
				$strFile = "/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".$ar_file["FILE_NAME"];
				$strFile = str_replace("//", "/", $strFile);
				$strTmpOff.="<picture>http://".$ar_iblock['SERVER_NAME'].implode("/", array_map("rawurlencode", explode("/", $strFile)))."</picture>\n";
			}
		}

		$y = 0;
		//die(print_R($arYandexFields));
		foreach ($arYandexFields as $key)
		{
			switch ($key)
			{
				case 'name':
					if (is_array($XML_DATA) && ($XML_DATA['TYPE'] == 'vendor.model' || $XML_DATA['TYPE'] == 'artist.title'))
						continue;
					
					$strTmpOff.= "<name>".yandex_text2xml($arAcc["NAME"], true)."</name>\n";
				break;
				case 'description': 
					$strTmpOff.= 
						"<description>".
						yandex_text2xml(TruncateText(
							($arAcc["DETAIL_TEXT_TYPE"]=="html"? 
							strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arAcc["~DETAIL_TEXT"])) : $arAcc["DETAIL_TEXT"]),
							512), true).
						"</description>\n";
				break;
				case 'param':
					if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && is_array($XML_DATA['XML_DATA']['PARAMS']))
					{
						foreach ($XML_DATA['XML_DATA']['PARAMS'] as $key => $prop_id)
						{
							if ($prop_id)
							{
								$strTmpOff .= yandex_get_value($arAcc, 'PARAM_'.$key, $prop_id)."\n";
							}
						}
					}
				break;
				
				case 'model':
				case 'title':
					if (!is_array($XML_DATA) || !is_array($XML_DATA['XML_DATA']) || !$XML_DATA['XML_DATA'][$key])
					{
						if (
							$key == 'model' && $XML_DATA['TYPE'] == 'vendor.model'
							|| 
							$key == 'title' && $XML_DATA['TYPE'] == 'artist.title'
						)

						$strTmpOff.= "<".$key.">".TruncateText(yandex_text2xml($arAcc["NAME"], true),255)."</".$key.">\n";
					}
					else 
						$strTmpOff.= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key]);
				break;
				///<!-- допил
				case "manufacturer_warranty":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						$strTmpOff.= "<".$key.">".yandex_text2xml($arAcc["PROPERTIES"]["manufacturer_warrant"]["VALUE"], true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;
				case "vendor":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						$strTmpOff.= "<".$key.">".yandex_text2xml($arAcc["PROPERTIES"]["CH_PRODUCER"]["VALUE"], true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;
				case "country_of_origin":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						if(!empty($arAcc["PROPERTIES"]["STRANA"]["VALUE"]))
							$strTmpOff.= "<".$key.">".yandex_text2xml($arAcc["PROPERTIES"]["STRANA"]["VALUE"], true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;
				case "local_delivery_cost":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						$strTmpOff.= "<".$key.">".yandex_text2xml(intval($price_devel), true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;
				/*case "pickup":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						$strTmpOff.= "<".$key.">".yandex_text2xml("true", true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;
				case "delivery":
					if (is_array($XML_DATA) && $XML_DATA['TYPE'] == 'vendor.model'){
						$strTmpOff.= "<".$key.">".yandex_text2xml("true", true)."</".$key.">\n";
					}
					else{
						if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
					}
				break;*/
				////---->>>>
				case 'year':
					$y++;
					if ($XML_DATA['TYPE'] == 'artist.title')
					{
						if ($y == 1) continue;
					}
					else
					{
						if ($y > 1) continue;
					}
					
					// no break here
					
				default:
					if (is_array($XML_DATA) && is_array($XML_DATA['XML_DATA']) && $XML_DATA['XML_DATA'][$key])
						$strTmpOff .= yandex_get_value($arAcc, $key, $XML_DATA['XML_DATA'][$key])."\n";
			}
		}
		
		$strTmpOff.= "</offer>\n";
	}
	
	@fwrite($fp, "<categories>\n");
	@fwrite($fp, $strTmpCat);
	@fwrite($fp, "</categories>\n");

	@fwrite($fp, "<offers>\n");
	@fwrite($fp, $strTmpOff);
	@fwrite($fp, "</offers>\n");

	@fwrite($fp, "</shop>\n");
	@fwrite($fp, "</yml_catalog>\n");

	@fclose($fp);
}

if ($bTmpUserCreated) 
{
	unset($USER);
	
	if (isset($USER_TMP))
	{
		$USER = $USER_TMP;
		unset($USER_TMP);
	}
}
?>