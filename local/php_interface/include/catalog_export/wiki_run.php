<?
//<title>Wikimart</title>
set_time_limit(0);

global $USER, $APPLICATION;
$bTmpUserCreated = False;

if (!isset($USER) || !is_a($GLOBALS['USER'], 'CUser'))
{
	$bTmpUserCreated = True;
	if (isset($USER))
		$USER_TMP = $USER;
	
	$USER = new CUser();
}

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

		if (intval($value)>0)
		{
			$arSections[] = intval($value);
		}
	}
}

if (!$bAllSections && count($arSections)<=0)
{
	$arRunErrors[] = GetMessage('YANDEX_ERR_NO_SECTION_LIST');
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
	//$SETUP_FILE_NAME = '/bitrix/catalog_export/testy.php';
	if (!$fp = @fopen($_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME, "wb"))
	{
		$strExportErrorMessage .= "Can not open \"".$_SERVER["DOCUMENT_ROOT"].$SETUP_FILE_NAME."\" file for writing.\n";
	}
	else
	{
		
		if (!@fwrite($fp, '<?if (!isset($_GET["referer1"]) || strlen($_GET["referer1"])<=0) $_GET["referer1"] = "wikimart";?>'))
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
	
	$arCurrencyAllowed = array('RUB', 'USD', 'EUR', 'UAH', 'BYR', 'KZT');

	$BASE_CURRENCY = str_replace("RUB", "RUR", CCurrency::GetBaseCurrency());
	if (is_array($XML_DATA['CURRENCY']))
	{
		foreach ($XML_DATA['CURRENCY'] as $CURRENCY => $arCurData)
		{
			if (in_array($CURRENCY, $arCurrencyAllowed))
			{
				$strTmp.= "<currency id=\"".str_replace("RUB", "RUR", $CURRENCY)."\""
				." rate=\"".($arCurData['rate'] == 'SITE' ? CCurrencyRates::ConvertCurrency(1, $CURRENCY, "RUB") : $arCurData['rate'])."\""
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
	
	$arTmpCat = array();
	$strTmpOff = "";

	$arAvailGroups = array();
	if (!$bAllSections)
	{
		for ($i = 0, $intSectionsCount = count($arSections); $i < $intSectionsCount; $i++)
		{
			$filter_tmp = $filter;
			$db_res = CIBlockSection::GetNavChain($IBLOCK_ID, $arSections[$i]);
			$curLEFT_MARGIN = 0;
			$curRIGHT_MARGIN = 0;
			while ($ar_res = $db_res->Fetch())
			{
				$curLEFT_MARGIN = intval($ar_res["LEFT_MARGIN"]);
				$curRIGHT_MARGIN = intval($ar_res["RIGHT_MARGIN"]);
				$arAvailGroups[$ar_res["ID"]] = array(
					"ID" => intval($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => intval($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
				);
				if ($intMaxSectionID < $ar_res["ID"])
					$intMaxSectionID = $ar_res["ID"];
			}

			$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, ">LEFT_MARGIN"=>$curLEFT_MARGIN, "<RIGHT_MARGIN"=>$curRIGHT_MARGIN, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
			$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
			while ($ar_res = $db_res->Fetch())
			{
				$arAvailGroups[$ar_res["ID"]] = array(
					"ID" => intval($ar_res["ID"]),
					"IBLOCK_SECTION_ID" => intval($ar_res["IBLOCK_SECTION_ID"]),
					"NAME" => $ar_res["NAME"]
				);
				if ($intMaxSectionID < $ar_res["ID"])
					$intMaxSectionID = $ar_res["ID"];
			}
		}
	}
	else
	{
		$filter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y", "IBLOCK_ACTIVE"=>"Y", "GLOBAL_ACTIVE"=>"Y");
		$db_res = CIBlockSection::GetList(array("left_margin"=>"asc"), $filter);
		while ($ar_res = $db_res->Fetch())
		{
			$arAvailGroups[$ar_res["ID"]] = array(
				"ID" => intval($ar_res["ID"]),
				"IBLOCK_SECTION_ID" => intval($ar_res["IBLOCK_SECTION_ID"]),
				"NAME" => $ar_res["NAME"]
			);
			if ($intMaxSectionID < $ar_res["ID"])
				$intMaxSectionID = $ar_res["ID"];
		}
	}

	$arSectionIDs = array();
	foreach ($arAvailGroups as &$value)
	{
		$strTmpCat.= "<category id=\"".$value["ID"]."\"".(intval($value["IBLOCK_SECTION_ID"])>0?" parentId=\"".$value["IBLOCK_SECTION_ID"]."\"":"").">".yandex_text2xml($value["NAME"], true)."</category>\n";

		$arTmpCat[$value["ID"]] = "<category id=\"".$value["ID"]."\"".(IntVal($value["IBLOCK_SECTION_ID"])>0?" parentId=\"".$value["IBLOCK_SECTION_ID"]."\"":"").">".yandex_text2xml($value["NAME"], true)."</category>\n";
		$arSectionIDs[] = $value["ID"];
	}
	if (isset($value))
		unset($value);

	if (!empty($arAvailGroups))
		$arSectionIDs = array_keys($arAvailGroups);

	$intMaxSectionID += 100000000;

	$arAvailableSections = $arTmpCat;

	
	// actions
	$arResult["ACTION_ITEMS"] = array();
	$rsA = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>18, "ACTIVE"=>"Y", "ACTIVE_DATE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "PROPERTY_ITEMS"));
	while($arA = $rsA -> Fetch())
		$arResult["ACTION_ITEMS"] = array_merge($arResult["ACTION_ITEMS"], explode("#", $arA));
	$arResult["ACTION_ITEMS"] = array_unique($arResult["ACTION_ITEMS"]);
	
	
	$strResult = '';
	$strNL = "\n";
	$intMaxSectionID = max($arSectionIDs);
	$arLiveSections = array();

	$strOfferFileTmp = $_SERVER["DOCUMENT_ROOT"]."/upload/tmp_wiki_".rand(100,999).".tmp";
	$tmpHandle = fopen($strOfferFileTmp, "w");

	$arSelectAddon = array("PROPERTY_CH_PRODUCER.NAME", "PROPERTY_CH_STRANA_1.NAME");
	$arItemsFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "!SECTION_ID"=>false, "!PROPERTY_IMPORT2YM"=>2100912, "!PROPERTY_CH_SNYATO"=>2100916);

	if(!empty($PRODUCER))
		$arItemsFilter["!PROPERTY_CH_PRODUCER"] = $PRODUCER;

	foreach($V as $intKey => $intVal)
		if($intVal <= 0) unset($V[$intKey]);

	if(!empty($V)) {
		$arSectionIDs = array_intersect($arSectionIDs, $V);
		foreach($arTmpCat as $intKey => $foo) {
			if(!in_array($intKey, $arSectionIDs)) unset($arTmpCat[$intKey]);
		}
	}

	if (!$bAllSections)
	{
		$arItemsFilter["INCLUDE_SUBSECTIONS"] = "Y";
		$arItemsFilter["SECTION_ID"] = $arSectionIDs;
	}

	$arItemsFilter["ID"] = CIBlockElement::SubQuery("PROPERTY_CML2_LINK", array("IBLOCK_ID" => 3, "!PROPERTY_CML2_LINK" => false));

	$rsItems = CIBlockElement::GetList(array(), $arItemsFilter, false, false, array_merge($arSelect, $arSelectAddon));

	while ($obElement = $rsItems -> GetNextElement())
	{
		$arAcc = $obElement->GetFields();
		$arAcc["PROPERTIES"] = $obElement->GetProperties();
		
		$boolIsAvailable = !($arAcc["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923);
		$boolIsActionItem = in_array($arAcc["ID"], $arResult["ACTION_ITEMS"]);

		$arOffersFilter = Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arAcc["ID"]);

		$rsOffersSize = CIBlockElement::GetList(Array(), $arOffersFilter, array("PROPERTY_SIZE"));
		$intOfferSizeCnt = $rsOffersSize -> SelectedRowsCount();

		$rsOffers = CIBlockElement::GetList(Array(), $arOffersFilter, false, false, array("ID", "IBLOCK_ID", "CATALOG_GROUP_1", "PROPERTY_PICTURE_MAXI", "PROPERTY_COLOR", "PROPERTY_SIZE"));

		if($rsOffers -> SelectedRowsCount() > 0) {
			$intItemSection = 0;
			$bNoActiveGroup = true;

			$rsTmpSections = CIBlockElement::GetElementGroups($arAcc["ID"]);
			while ($arTmpSection = $rsTmpSections->Fetch())
			{
				if (isset($arTmpCat[$arTmpSection["ID"]]))
				{
					$strOfferCat = '<categoryId>'.$arTmpSection["ID"].'</categoryId>'.$strNL;
					$intItemSection = $arTmpSection["ID"];
					$bNoActiveGroup = false;
				}
			}

			if ($bNoActiveGroup) continue;

			$arLiveSections[$intItemSection] = false;
			if($arAvailGroups[$intItemSection]["IBLOCK_SECTION_ID"]>0) $arLiveSections[$arAvailGroups[$intItemSection]["IBLOCK_SECTION_ID"]] = false;

			while($arOffer = $rsOffers -> GetNext())
			{
				$strResult = '';

				$offerMinPrice = 0;
				if ($arPrice = CCatalogProduct::GetOptimalPrice($arOffer["ID"], 1, array(2), 'N', array(), $ar_iblock['LID']))
				{
					$offerMinPrice = $arPrice['DISCOUNT_PRICE'];
					$offerMinPriceCurrency = $arPrice["CURRENCY"];
				}

				//if($arOffer["CATALOG_QUANTITY"]>2 && $offerMinPrice>=500)
				if((empty($PRICE_FROM) || $offerMinPrice >= $PRICE_FROM) && (empty($PRICE_TO) || $offerMinPrice <= $PRICE_TO))
				{

					if($intOfferSizeCnt>1)
					{
						if(!empty($arAcc["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"]))
							$strName = $arAcc["NAME"].', '.$arAcc["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].' - '.$arOffer["PROPERTY_SIZE_VALUE"].', цвет - '.$arOffer["PROPERTY_COLOR_VALUE"];
						else $strName = $arAcc["NAME"].', размер - '.$arOffer["PROPERTY_SIZE_VALUE"].', цвет - '.$arOffer["PROPERTY_COLOR_VALUE"];
					} else $strName = $arAcc["NAME"].", ".$arOffer["PROPERTY_COLOR_VALUE"];

					$strUrl = str_replace(' ', '%20', 'http://'.$ar_iblock['SERVER_NAME'].htmlspecialchars($arAcc["~DETAIL_PAGE_URL"]).
							(strstr($arAcc['DETAIL_PAGE_URL'], '?') === false ? '?' : '&amp;').'utm_source=wikimart&amp;utm_medium=cpc&amp;utm_campaign=mamingorodok.ru')."&amp;showOffer=".$arOffer["ID"];


					$strResult .= '<offer id="'.$arOffer["ID"].'" type="vendor.model" available="'.($boolIsAvailable?'true':'false').'">'.$strNL;
					$strResult .= '<url>'.$strUrl.'</url>'.$strNL;
					$strResult .= '<price>'.$offerMinPrice.'</price>'.$strNL;
					$strResult .= '<currencyId>RUR</currencyId>'.$strNL;
					$strResult .= $strOfferCat;

					if (IntVal($arOffer["PROPERTY_PICTURE_MAXI_VALUE"])>0)
					{
						$picID = IntVal($arOffer["PROPERTY_PICTURE_MAXI_VALUE"]);
						$db_file = CFile::GetByID($picID);
						if ($ar_file = $db_file->Fetch())
						{
							$strFile = "/".(COption::GetOptionString("main", "upload_dir", "upload"))."/".$ar_file["SUBDIR"]."/".$ar_file["FILE_NAME"];
							$strFile = str_replace("//", "/", $strFile);
							$strResult .= "<picture>http://".$ar_iblock['SERVER_NAME'].implode("/", array_map("rawurlencode", explode("/", $strFile)))."</picture>".$strNL;
						}
					}

					$strResult .= '<store>false</store>'.$strNL;
					$strResult .= '<pickup>false</pickup>'.$strNL;
					$strResult .= '<delivery>true</delivery>'.$strNL;
					$strResult .= '<local_delivery_cost>'.($offerMinPrice>3000?0:300).'</local_delivery_cost>'.$strNL;
					$strResult .= '<vendor>'.yandex_text2xml($arAcc["PROPERTY_CH_PRODUCER_NAME"], true).'</vendor>'.$strNL;
					$strResult .= '<model>'.yandex_text2xml($strName, true).'</model>'.$strNL;
					$strResult .= '<description>'.yandex_text2xml(TruncateText(($arAcc["DETAIL_TEXT_TYPE"]=="html"?strip_tags(preg_replace_callback("'&[^;]*;'", "yandex_replace_special", $arAcc["~DETAIL_TEXT"])) : $arAcc["DETAIL_TEXT"]), 512), true).'</description>'.$strNL;
					$strResult .= '<sales_notes>'.($boolIsActionItem?'Акция! ':'').'Официальная поставка! Принимаем карты!</sales_notes>'.$strNL;
					if(!empty($arAcc["PROPERTIES"]["manufacturer_warrant"]["VALUE"]))
						$strResult .= '<manufacturer_warranty>'.$arAcc["PROPERTIES"]["manufacturer_warrant"]["VALUE"].'</manufacturer_warranty>'.$strNL;
					if(!empty($arAcc["PROPERTY_CH_STRANA_1_NAME"]))
						$strResult .= '<country_of_origin>'.yandex_text2xml($arAcc["PROPERTY_CH_STRANA_1_NAME"]).'</country_of_origin>'.$strNL;

					if($intItemSection == 319) // кроватки
					{
						$strResult .= '<param name="Тип">'.yandex_text2xml($arAcc["PROPERTIES"]["CH_KROV_TYPE"]["VALUE"]).'</param>'.$strNL;
						if(stripos($arAcc["PROPERTIES"]["CH_MEH_KACH"]["VALUE"], "маятн") !== false)
							$strResult .= '<param name="Маятниковый механизм">есть</param>'.$strNL;
					} elseif($intItemSection == 315) { // коляски
						$arKolType = array(
							2100520 => "Прогулочная",
							2100518 => 'Универсальная',
							2100517 => 'Транспортная система',
							2100519 => 'Люлька',
							2100516 => 'Трансформер'
						);
						$arKolBlock = array(
							2100521 => 'один',
							2100522 => 'два (для двойни)'
						);
						$arKolPack = array(
							2100525 => 'трость',
							2100526 => 'книжка'
						);
						$arKolWheels = array(
							2100581 => 'три точки опоры',
							2100582 => 'четыре точки опоры'
						);

						$strResult .= '<param name="Тип">'.(isset($arKolType[$arAcc["PROPERTIES"]["CH_KOL_TYPE"]["VALUE_ENUM_ID"]])?$arKolType[$arAcc["PROPERTIES"]["CH_KOL_TYPE"]["VALUE_ENUM_ID"]]:$arAcc["PROPERTIES"]["CH_KOL_TYPE"]["VALUE"]).'</param>'.$strNL;
						$strResult .= '<param name="Количество блоков">'.(isset($arKolBlock[$arAcc["PROPERTIES"]["CH_KOL_MEST"]["VALUE_ENUM_ID"]])?$arKolBlock[$arAcc["PROPERTIES"]["CH_KOL_MEST"]["VALUE_ENUM_ID"]]:$arAcc["PROPERTIES"]["CH_KOL_MEST"]["VALUE_ENUM_ID"]).'</param>'.$strNL;
						$strResult .= '<param name="Механизм складывания">'.(isset($arKolPack[$arAcc["PROPERTIES"]["CH_KOL_TYPE_SKLAD"]["VALUE_ENUM_ID"]])?$arKolPack[$arAcc["PROPERTIES"]["CH_KOL_TYPE_SKLAD"]["VALUE_ENUM_ID"]]:$arAcc["PROPERTIES"]["CH_KOL_TYPE_SKLAD"]["VALUE_ENUM_ID"]).'</param>'.$strNL;
						$strResult .= '<param name="Конструкция">'.(isset($arKolWheels[$arAcc["PROPERTIES"]["CH_KOL_KOLVO_KOLES"]["VALUE_ENUM_ID"]])?$arKolWheels[$arAcc["PROPERTIES"]["CH_KOL_KOLVO_KOLES"]["VALUE_ENUM_ID"]]:$arAcc["PROPERTIES"]["CH_KOL_KOLVO_KOLES"]["VALUE_ENUM_ID"]).'</param>'.$strNL;
						$strResult .= '<param name="Перекладина перед ребенком">'.$arAcc["PROPERTIES"]["CH_KOL_PEREKLAD"]["VALUE"].'</param>'.$strNL;
					} elseif($intItemSection == 305) { // автокресла
						$strResult .= '<param name="Группа">'.$arAcc["PROPERTIES"]["CH_AK_GROUP"]["VALUE"].'</param>'.$strNL;
						if($arAcc["PROPERTIES"]["CH_AK_KREPL_TYPE"]["VALUE_ENUM_ID"] == 2100587)
							$strResult .= '<param name="Крепление Isofix">есть</param>'.$strNL;
					}

					$strResult.= "</offer>\n";
					@fwrite($tmpHandle, $strResult);
					$strResult = '';
				}
			}
		}
	}
	
	foreach($arTmpCat as $intID => $strSection)
	{
		if(!isset($arLiveSections[$intID])) unset($arTmpCat[$intID]);
	}
	
	
	@fwrite($fp, "<categories>\n");
	@fwrite($fp, implode("", $arAvailableSections));
	@fwrite($fp, "</categories>\n");

	@fwrite($fp, "<offers>\n");
	@fwrite($fp, file_get_contents($strOfferFileTmp));
	unlink($strOfferFileTmp);
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