<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$arResult = array();

$arExport = array(array("URL", "h1", "title", "brand en", "brand ru"));

// производители
$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array("ACTIVE" => "Y", "IBLOCK_ID" => 5, "!CODE" => false), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_NAME_RUS", "CODE"));
while($arI = $rsI->GetNext())
	$arResult["PRODUCERS"][$arI["ID"]] = $arI;

// свойства каталога
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>2));
while ($arProp = $rsProp->Fetch())
	$arResult["PROP"][$arProp["ID"]] = $arProp;

// свойства каталога для ЧПУ
$rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array("ACTIVE" => "Y", "IBLOCK_ID" => 17), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "CODE"));
while($arI = $rsI->Fetch()) {
	$arI["ENUM"] = CIBlockPropertyEnum::GetByID($arI["PREVIEW_TEXT"]);
	$arResult["PROP_SEO"][$arI["DETAIL_TEXT"]][] = $arI;
}


// разделы
$rsSec = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME" => "ASC"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>2, "ID" => array(301, 319)), false, array("UF_PROP_TO_SHOW", "UF_H1", "UF_TITLE"));
while($arSec = $rsSec -> GetNext()) {
	$arResult["SECTIONS"][] = $arSec;
	$arExport[] = array($arSec["SECTION_PAGE_URL"], (empty($arSec["UF_H1"])?"Детские ".decapitalizeString($arSec["NAME"]):$arSec["UF_H1"]), $arSec["UF_TITLE"], "", "");

	// get section brands
	if(true) {
		$rsI = CIBlockElement::GetList(Array(), array("ACTIVE" => "Y", "IBLOCK_ID" => 2, "PROPERTY_CH_PRODUCER" => array_keys($arResult["PRODUCERS"])), array("PROPERTY_CH_PRODUCER"));
		while($arI = $rsI->GetNext()) {
			$arProducer = $arResult["PRODUCERS"][$arI["PROPERTY_CH_PRODUCER_VALUE"]];

			$strCategoryName = $arSec["NAME"];
			$strProducer = $arProducer["NAME"];
			$strProducerRus = $arProducer["PROPERTY_NAME_RUS_VALUE"];

			// получаем SEO параметры из инфоблока
			$strTmpTitle = '';
			$strTmpH1 = '';

			$rsTmp = CIBlockElement::GetList(Array("SORT" => "ASC"), array("ACTIVE" => "Y", "IBLOCK_ID" => 13, "PROPERTY_URL" => $arSec["SECTION_PAGE_URL"], "PROPERTY_CH_PRODUCER" => $arProducer["ID"]), false, false, array("ID", "IBLOCK_ID", "PROPERTY_TITLE", "PROPERTY_H1"));
			if($arTmp = $rsTmp->GetNext()) {
				$strTmpTitle = $arTmp["PROPERTY_TITLE_VALUE"];
				$strTmpH1 = $arTmp["PROPERTY_H1_VALUE"];
			}

			if(empty($strTmpH1)) $strTmpH1 = $strCategoryName.' '.$strProducer;
			if(empty($strTmpTitle))  $strTmpTitle = $strCategoryName.' '.$strProducer.(strlen($strProducerRus)>0? " (".$strProducerRus.")":'').' - выгодные цены - Мамин городок';

			$arExport[] = array($arSec["SECTION_PAGE_URL"]."proizvoditel_".$arProducer["CODE"]."/", $strTmpH1, $strTmpTitle, $strCategoryName.' '.$strProducer, (empty($strProducerRus)?'':$strCategoryName.' '.$strProducerRus));
		}
	}

	// get section types
	if(true) {
		foreach($arSec["UF_PROP_TO_SHOW"] as $intPropID) {
			$arProp = $arResult["PROP"][$intPropID];

			if(!empty($arResult["PROP_SEO"][$arProp["CODE"]])) {
				foreach($arResult["PROP_SEO"][$arProp["CODE"]] as $arProp) {
					$strCategoryName = $arSec["NAME"];

					if(strlen($arProp["ENUM"]["VALUE"])>0)
						$strProperty = $arProp["ENUM"]["VALUE"];
					else $strProperty = $arProp["NAME"];

					$strProdType = $strCategoryName." ".$strProperty;

					$strTmpTitle = '';
					$strTmpH1 = '';

					$arFilter = array("ACTIVE" => "Y", "IBLOCK_ID" => 13, "PROPERTY_URL" => $arSec["SECTION_PAGE_URL"], "PROPERTY_".$arProp["DETAIL_TEXT"] => $arProp["PREVIEW_TEXT"]);

					$rsTmp = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array("ID", "IBLOCK_ID", "PROPERTY_TITLE", "PROPERTY_H1"));
					if($arTmp = $rsTmp->GetNext()) {
						$strTmpTitle = $arTmp["PROPERTY_TITLE_VALUE"];
						$strTmpH1 = $arTmp["PROPERTY_H1_VALUE"];
					}

					if(empty($strTmpTitle)) $strTmpTitle = $strCategoryName." ".ToLower($strProperty)." по выгодной цене - купить ".ToLower($strCategoryName)." для детей в интернет-магазине «Мамин городок»";
					if(empty($strTmpH1)) $strTmpH1 = $strCategoryName.' '.ToLower($strProperty);

					$arExport[] = array($arSec["SECTION_PAGE_URL"]."tip-".$arProp["CODE"]."/", $strTmpH1, $strTmpTitle, "", "");
				}
			}
		}
	}
}

$strTmp = '';
foreach($arExport as $arTmp)
	$strTmp .= implode(';', $arTmp)."\r\n";

echo $strTmp;
// http://www.mamingorodok.ru/catalog/detskaya-mebel/proizvoditel_papaloni/