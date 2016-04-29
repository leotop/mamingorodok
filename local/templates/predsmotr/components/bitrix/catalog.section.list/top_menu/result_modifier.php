<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arViewModeList = array('LIST', 'LINE', 'TEXT', 'TILE');

$arDefaultParams = array(
	'VIEW_MODE' => 'LIST',
	'SHOW_PARENT_NAME' => 'Y',
	'HIDE_SECTION_NAME' => 'N'
);

$arParams = array_merge($arDefaultParams, $arParams);

if (!in_array($arParams['VIEW_MODE'], $arViewModeList))
	$arParams['VIEW_MODE'] = 'LIST';
if ('N' != $arParams['SHOW_PARENT_NAME'])
	$arParams['SHOW_PARENT_NAME'] = 'Y';
if ('Y' != $arParams['HIDE_SECTION_NAME'])
	$arParams['HIDE_SECTION_NAME'] = 'N';

$arResult['VIEW_MODE_LIST'] = $arViewModeList;

if (0 < $arResult['SECTIONS_COUNT'])
{
	if ('LIST' != $arParams['VIEW_MODE'])
	{
		$boolClear = false;
		$arNewSections = array();
		foreach ($arResult['SECTIONS'] as &$arOneSection)
		{
			if (1 < $arOneSection['RELATIVE_DEPTH_LEVEL'])
			{
				$boolClear = true;
				continue;
			}
			$arNewSections[] = $arOneSection;
		}
		unset($arOneSection);
		if ($boolClear)
		{
			$arResult['SECTIONS'] = $arNewSections;
			$arResult['SECTIONS_COUNT'] = count($arNewSections);
		}
		unset($arNewSections);
	}
}

if (0 < $arResult['SECTIONS_COUNT'])
{
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	if ('LINE' == $arParams['VIEW_MODE'] || 'TILE' == $arParams['VIEW_MODE'])
	{
		reset($arResult['SECTIONS']);
		$arCurrent = current($arResult['SECTIONS']);
		if (!isset($arCurrent['PICTURE']))
		{
			$boolPicture = true;
			$arSelect[] = 'PICTURE';
		}
		if ('LINE' == $arParams['VIEW_MODE'] && !array_key_exists('DESCRIPTION', $arCurrent))
		{
			$boolDescr = true;
			$arSelect[] = 'DESCRIPTION';
			$arSelect[] = 'DESCRIPTION_TYPE';
		}
	}
	if ($boolPicture || $boolDescr)
	{
		foreach ($arResult['SECTIONS'] as $key => $arSection)
		{
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext())
		{
			if (!isset($arMap[$arSection['ID']]))
				continue;
			$key = $arMap[$arSection['ID']];
			if ($boolPicture)
			{
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr)
			{
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
}


foreach ($arResult["SECTIONS"] as &$arSec) {
    $arSec["TITLE"] = strlen($arSec["~UF_MENU_TITLE"])<=0 ? $arSec["~NAME"] : $arSec["~UF_MENU_TITLE"];
}

foreach ($arResult["SECTIONS"] as &$arSec) {
    $rsSubsec= CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), array(
    "IBLOCK_ID"=>$arParams["IBLOCK_ID"], 
    "ACTIVE"=>"Y", 
    "GLOBAL_ACTIVE" => "Y", 
    "DEPTH_LEVEL" => 2, 
    "SECTION_ID" => $arSec["ID"]));
    
    while($arSubsec = $rsSubsec -> GetNext()) 
    {
        $arSec["SUBSECTIONS"][]= $arSubsec;
    }   
    
}


$brandList = CIBlockPropertyEnum::GetList(Array("VALUE"=>"ASC"),Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"CODE"=>"PROIZVODITEL"));
while($arBrand = $brandList->Fetch()) {
    //arshow($arBrand);
    $CODE = CUtil::Translit($arBrand["VALUE"],"ru",array("replace_space"=>"_","replace_other"=>"_"));
   $arResult["PRODUCERS"][$CODE] = array("NAME"=>$arBrand["VALUE"], "CODE"=>$CODE, "PROPERTY_MENU_LINK_VALUE" => "filter/proizvoditel-".$CODE."/");;
}

//arshow($arResult["PRODUCERS"]);


$arResult["SECTION_TO_PRODUCER"] = array();
$rsP = CIBlockElement::GetList(Array("SORT"=>"ASC"), array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "!PROPERTY_MENU_LINK"=>false), false, false, array("IBLOCK_ID", "PROPERTY_MENU_LINK", "ID","NAME","CODE"));
while($arP = $rsP -> GetNext())
{
   // arshow($arP);
    foreach($arP["PROPERTY_MENU_LINK_VALUE"] as $intSecID)
        $arResult["SECTION_TO_PRODUCER"][$intSecID][] = CUtil::Translit($arP["NAME"],"ru",array("replace_space"=>"_","replace_other"=>"_")); 
}

//arshow($arResult["SECTION_TO_PRODUCER"]);