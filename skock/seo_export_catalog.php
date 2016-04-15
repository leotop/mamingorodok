<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$arExport = array();

function generateSeoData($arSec, $strType = false, $arType = array()) {
	$arMeta["UF_TITLE"] = $arSec["UF_TITLE"];
	$arMeta["UF_NAME_PAD"] = (strlen($arSec["UF_NAME_PAD"])>0?$arSec["UF_NAME_PAD"]:$arSec["NAME"]);
	$arMeta["H1"] = $arSec["UF_H1"];

	if(strlen($arSec["UF_H1"])<=0)
		$arMeta["H1"] = "Детские ".decapitalizeString($arSec["NAME"]);

	$strDecapitalizedTitle = decapitalizeString($arSec["NAME"]);
	$strDecapitalizedTitlePad = decapitalizeString($arSec["UF_NAME_PAD"]);

	if(strlen($arMeta["UF_TITLE"])<=0)
		$arMeta["UF_TITLE"] = "Детские ".$strDecapitalizedTitle." по выгодной цене - купить ".$strDecapitalizedTitle." для детей с доставкой по Москве - интернет-магазин ".$strDecapitalizedTitlePad." «Мамин городок»";

	$arSeo = array();

	if(!empty($strType)) {
		$arSeoFilter = array(
			"IBLOCK_ID" => 13,
		   "PROPERTY_URL" => $arSec["SECTION_PAGE_URL"]
		);

		if($strType == "producer")
			$arSeoFilter["PROPERTY_CH_PRODUCER"] = $arType["ID"];

		$rsSEO = CIBlockElement::GetList(Array(), $arSeoFilter, false, false, array("PROPERTY_TITLE", "PROPERTY_H1"));
		if($arSEO = $rsSEO -> GetNext())
		{
			$arSeo = array(
				"TITLE" => $arSEO["PROPERTY_TITLE_VALUE"],
				"H1" => $arSEO["PROPERTY_H1_VALUE"],
			);
		}
	}

	if($strType == "producer") {
		$strCategoryName = $arSec["NAME"];
		$strProducer = $arType["NAME"];
		$strProducerRus = $arType["RUSNAME"];


		if(empty($arSeo["TITLE"]))
			$arSeo["TITLE"] = $strCategoryName.' '.$strProducer.(strlen($strProducerRus)>0? " (".$strProducerRus.")":'').' - выгодные цены - Мамин городок';

		$strTitleAlt = $strCategoryName.' '.$strProducer;
		if(empty($arSeo["TITLE"]))
			$arSeo["TITLE"] = $strTitleAlt;

		$arMeta["H1"] = $strCategoryName.' '.$strProducer;
	}

	if(strlen($arSeo["TITLE"])<=0) $arSeo["TITLE"] = $arMeta["UF_TITLE"];
	if(strlen($arSeo["H1"])<=0) $arSeo["H1"] = $arMeta["H1"];

	return $arSeo;
}

$arAllProducers = array();
$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
	"ACTIVE" => "Y",
	"IBLOCK_ID" => 5
), false, false, array(
	"ID", "IBLOCK_ID", "NAME", "PROPERTY_NAME_RUS", "CODE"
));
while($arI = $rsI->GetNext()) {
	$arP = array(
		"ID" => $arI["ID"],
		"NAME" => $arI["NAME"],
		"RUSNAME" => $arI["PROPERTY_NAME_RUS_VALUE"],
	   "CODE" => $arI["CODE"]
	);
	$arAllProducers[$arP["ID"]] = $arP;
}

// get all prop
$arAllProps = array();
$rsProps = CIBlock::GetProperties(2, Array(), Array());
while($arProps = $rsProps -> Fetch())
	$arAllProps[$arProps["ID"]] = $arProps;

$rsSEOProp = CIBlock::GetProperties(13, Array());
while($arSEOProp = $rsSEOProp -> GetNext())
{
	if(strpos($arSEOProp["CODE"], "CH_") === 0)
		$arAllSEOPropFilter["PROPERTY_".$arSEOProp["CODE"]] = false;
}

// get prop sef data
$rsSEF = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "ACTIVE"=>"Y"), false, false, array("PREVIEW_TEXT", "DETAIL_TEXT", "CODE"));
while($arSEF = $rsSEF -> GetNext())
	$arResultSEF[$arSEF["DETAIL_TEXT"]][$arSEF["PREVIEW_TEXT"]] = $arSEF["CODE"];

$arResultPROP = array();

$rsSec = CIBlockSection::GetList(Array(
	"left_margin" => "ASC"
), array(
	"ACTIVE" => "Y",
	"IBLOCK_ID" => 2), false, array("NAME", "SECTION_PAGE_URL", "UF_TITLE", "UF_H1", "UF_NAME_PAD", "DEPTH_LEVEL", "UF_SITEMAP_PROP"));
while($arSec = $rsSec->GetNext()) {
	if($arSec["DEPTH_LEVEL"] == 1) {
		$arExport[] = array("URL" => $arSec["SECTION_PAGE_URL"], "TITLE" => $arSec["NAME"], "H1" => "");

		// tag - producer
		$rsI = CIBlockElement::GetList(Array(), array(
			"ACTIVE" => "Y",
			"IBLOCK_ID" => 2,
			"SECTION_ID" => $arSec["ID"],
			"INCLUDE_SUBSECTIONS" => "Y"
		), array("IBLOCK_ID", "PROPERTY_CH_PRODUCER"));
		while($arI = $rsI->GetNext()) {
			$arProducer = $arAllProducers[$arI["PROPERTY_CH_PRODUCER_VALUE"]];
			$arSeo = generateSeoData($arSec, "producer", $arProducer);

			$arExport[] = array("URL" => $arSec["SECTION_PAGE_URL"].'proizvoditel_'.$arProducer["CODE"].'/', "TITLE" => $arSeo["TITLE"], "H1" => $arSeo["H1"]);
		}
	} else {
		$arSeo = generateSeoData($arSec);
		$arExport[] = array("URL" => $arSec["SECTION_PAGE_URL"], "TITLE" => $arSeo["TITLE"], "H1" => $arSeo["H1"]);

		// tag - producer
		$rsI = CIBlockElement::GetList(Array(), array(
			"ACTIVE" => "Y",
			"IBLOCK_ID" => 2,
			"SECTION_ID" => $arSec["ID"],
			"INCLUDE_SUBSECTIONS" => "Y"
		), array("IBLOCK_ID",  "PROPERTY_CH_PRODUCER"));
		while($arI = $rsI->GetNext()) {
			$arProducer = $arAllProducers[$arI["PROPERTY_CH_PRODUCER_VALUE"]];
			$arSeo = generateSeoData($arSec, "producer", $arProducer);

			$arExport[] = array("URL" => $arSec["SECTION_PAGE_URL"].'proizvoditel_'.$arProducer["CODE"].'/', "TITLE" => $arSeo["TITLE"], "H1" => $arSeo["H1"]);
		}

		// tag - type
		foreach($arSec["UF_SITEMAP_PROP"] as $intPropID)
		{
			$arCurrentPropStruct = $arAllProps[$intPropID];
			if($arCurrentPropStruct["PROPERTY_TYPE"] == "L" && !isset($arResultPROP[$intPropID])) {
				$arResultPROP[$intPropID] = array("CODE" => $arCurrentPropStruct["CODE"], "NAME" => $arCurrentPropStruct["NAME"]);

				$rsEnum = CIBlockProperty::GetPropertyEnum($arCurrentPropStruct["CODE"], Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID));
				while($arEnum = $rsEnum -> GetNext())
					$arResultPROP[$arCurrentPropStruct["ID"]]["ENUM"][$arEnum["ID"]] = $arEnum["VALUE"];
			}
		}

		// get full SEO filter prop
		$arCurrentSEOPropFilter = $arAllSEOPropFilter;
		$arCurrentSEOPropFilter["PROPERTY_URL"] = $arSec["SECTION_PAGE_URL"];

		$arProps = array();
		foreach($arSec["UF_SITEMAP_PROP"] as $intPropID)
		{
			foreach($arResultPROP[$intPropID]["ENUM"] as $intEnumID => $strEnum)
			{
				if(isset($arResultSEF[$arResultPROP[$intPropID]["CODE"]][$intEnumID]))
				{
					// check existance
					$rsCnt = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "!PROPERTY_CH_SNYATO" => 2100916, "PROPERTY_".$arResultPROP[$intPropID]["CODE"] => $intEnumID), false, array("nTopCount"=>1), array("ID"));
					if($rsCnt>0)
					{
						$strPropLink = $arSec["SECTION_PAGE_URL"].'tip-'.$arResultSEF[$arResultPROP[$intPropID]["CODE"]][$intEnumID].'/';

						// get H1 from SEO IB
						$strPropH1 = '';
						$arCurrSEOPropFilter = $arCurrentSEOPropFilter;
						$arCurrSEOPropFilter["PROPERTY_".$arResultPROP[$intPropID]["CODE"]] = $intEnumID;
						$rsSEO = CIBlockElement::GetList(Array(), array_merge(array("IBLOCK_ID" => 13, "ACTIVE" => "Y"), $arCurrSEOPropFilter), false, array("nTopCount"=>1), array("ID", "IBLOCK_ID", "PROPERTY_H1", "PROPERTY_TITLE"));
						if($arSeo = $rsSEO -> GetNext()) {
							$strH1 = $arSeo["PROPERTY_H1_VALUE"];
							$strTitle = $arSeo["PROPERTY_TITLE_VALUE"];
						}


						$arExport[] = array("URL" => $strPropLink, "TITLE" => $strTitle, "H1" => $strH1);
					}
				}
			}
		}

	}
}

$strOut = "URL;TITLE;H1\r\n";
foreach($arExport as $arE)
	$strOut .= implode(";", $arE)."\r\n";

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: ".date("r"));
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=export.csv");

//echo '<html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"></head><body>'.$strOut.'</body></html>';
echo $strOut;