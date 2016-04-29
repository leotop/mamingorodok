<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("forum"))
	return;

if($arParams["brendID"]>0)
{
	$arTmp = array();
	foreach($arResult["ITEMS"] as $intSecID => $arItems)
	{
		foreach($arItems as $arItem)
			$arTmp[] = $arItem;
	}

	$arResult["ITEMS"] = $arTmp;
}

$arResult["TD_WIDTH"] = round(100/$arParams["LINE_ELEMENT_COUNT"])."%";
$arResult["nRowsPerItem"] = 1; //Image, Name and Properties
$arResult["bDisplayPrices"] = false;
foreach($arResult["ITEMS"] as $arItem)
{
	if(count($arItem["PRICES"])>0 || is_array($arItem["PRICE_MATRIX"]))
		$arResult["bDisplayPrices"] = true;
	if($arResult["bDisplayPrices"])
		break;
}



foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arItem["ID"]), true);

	$arResult["ITEMS"][$k]["COUNT_REPORTS"] = $ar_res;

	$qq = 0;
	$arFilter = Array(
		"IBLOCK_ID"=>OFFERS_IBLOCK_ID,
		"ACTIVE"=>"Y",
		"PROPERTY_MAIN_PRODUCT"=>$arItem["ID"]
	);
	//print_R($arFilter);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
	while($ar_fields = $res->GetNext()){
		//print_R($ar_fields);
		$ar_res = CCatalogProduct::GetByID($ar_fields["ID"]);
		$price = 0;
		$db_res2 = CPrice::GetList(
        array(),
        array(
                "PRODUCT_ID" => $ar_fields["ID"]
            )
			);
		if ($ar_res2 = $db_res2->Fetch())
		{
			$price = intval($ar_res2["PRICE"]);
		}
		if($ar_res["QUANTITY"]>0 && $price >0)
			$qq++;
		}
	$arResult["ITEMS"][$k]["COUNT_SKLAD"] = $qq;
}

if($arResult["bDisplayPrices"])
	$arResult["nRowsPerItem"]++; // Plus one row for prices
$arResult["bDisplayButtons"] = $arParams["DISPLAY_COMPARE"] || count($arResult["PRICES"])>0;
foreach($arResult["ITEMS"] as $arItem)
{
	$allpar[] = $arItem["ID"];
	if($arItem["CAN_BUY"])
		$arResult["bDisplayButtons"] = true;
	if($arResult["bDisplayButtons"])
		break;

}
if($arResult["bDisplayButtons"])
	$arResult["nRowsPerItem"]++; // Plus one row for buttons

//array_chunk
$arResult["ROWS"] = array();
if($arParams["brendID"]>0)
{
	$lastSecId = 0;
	foreach($arResult["ITEMS"] as $intCnt => $arItem)
	{
		if(count($arRow) == $arParams["LINE_ELEMENT_COUNT"] || ($intCnt && $arItem["IBLOCK_SECTION_ID"] != $lastSecId))
		{
			$arResult["ROWS"][] = $arRow;
			$arRow = array();
		}
		$arRow[] = $arItem;

		if($arItem["IBLOCK_SECTION_ID"] != $lastSecId) $lastSecId = $arItem["IBLOCK_SECTION_ID"];
	}
	$arResult["ROWS"][] = $arRow;
} else {
	while(count($arResult["ITEMS"])>0)
	{
		$arRow = array_splice($arResult["ITEMS"], 0, $arParams["LINE_ELEMENT_COUNT"]);
		while(count($arRow) < $arParams["LINE_ELEMENT_COUNT"])
			$arRow[]=false;
		$arResult["ROWS"][]=$arRow;
	}
}

//print_R($arParams["SECTION_ID"]);


// linking here
if($arResult["SECTION"]["ID"]>0)
{
	// cache this block for all pagenav for this section

	ob_start();
	$obCache = new CPageCache;
	if($obCache->StartDataCache(86400, "SEOLinking|".$arResult["SECTION"]["ID"], "/"))
	{
		$strLink = '';

		// brend
		$arBrend = array();
		$rsP = CIBlockElement::GetList(Array("PROPERTY_CH_PRODUCER.NAME" => "ASC"), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "!PROPERTY_CH_SNYATO" => 2100916, "SECTION_ID" => $arResult["SECTION"]["ID"], "INCLUDE_SUBSECTIONS"=>"Y"), array("PROPERTY_CH_PRODUCER", "PROPERTY_CH_PRODUCER.CODE", "PROPERTY_CH_PRODUCER.NAME"), false, array("IBLOCK_ID", "ID"));
		while($arP = $rsP -> GetNext())
			$arBrend[] = '<a href="'.$arResult["SECTION"]["SECTION_PAGE_URL"].'proizvoditel_'.$arP["PROPERTY_CH_PRODUCER_CODE"].'/">'.$arP["PROPERTY_CH_PRODUCER_NAME"].'</a>';

		if(count($arBrend)>0) $strLink .= '<div class="linkBrend">Бренды: '.implode(" | ", $arBrend).'</div>';
		unset($arBrend);

		if($arResult["SECTION"]["DEPTH_LEVEL"] == 1)
		{
			$arSubSec = array();
			$rsSub = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "SECTION_ID" => $arResult["SECTION"]["ID"]), false);
			while($arSub = $rsSub -> GetNext())
				$arSubSec[] = '<a href="'.$arSub["SECTION_PAGE_URL"].'">'.$arSub["NAME"].'</a>';

			if(count($arSubSec)>0)
				$strLink .= '<div class="linkBrend">Быстрый переход: '.implode(" | ", $arSubSec).'</div>';
		} else {
			// properties
			if(count($arResult["SECTION"]["UF_SITEMAP_PROP"])>0)
			{
				// get prop sef data
				$rsSEF = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "ACTIVE"=>"Y"), false, false, array("PREVIEW_TEXT", "DETAIL_TEXT", "CODE"));
				while($arSEF = $rsSEF -> GetNext())
					$arResultSEF[$arSEF["DETAIL_TEXT"]][$arSEF["PREVIEW_TEXT"]] = $arSEF["CODE"];

				// get all prop
				foreach($arResult["SECTION"]["UF_SITEMAP_PROP"] as $intPropID)
				{
					$rsProp = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$intPropID));
					while($arProp = $rsProp -> GetNext())
					{
						$arResultPROP[$arProp["ID"]] = array("CODE" => $arProp["CODE"], "NAME" => $arProp["NAME"]);
						if($arProp["PROPERTY_TYPE"] == "L")
						{
							$rsEnum = CIBlockProperty::GetPropertyEnum($arProp["CODE"], Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID));
							while($arEnum = $rsEnum -> GetNext())
								$arResultPROP[$arProp["ID"]]["ENUM"][$arEnum["ID"]] = $arEnum["VALUE"];
						}
					}
				}

				// get full SEO filter prop
				$arAllSEOPropFilter = array("PROPERTY_URL" => $arResult["SECTION"]["SECTION_PAGE_URL"]);
				$rsSEOProp = CIBlock::GetProperties(13, Array());
				while($arSEOProp = $rsSEOProp -> GetNext())
				{
					if(strpos($arSEOProp["CODE"], "CH_") === 0)
						$arAllSEOPropFilter["PROPERTY_".$arSEOProp["CODE"]] = false;
				}

				$arProps = array();
				foreach($arResult["SECTION"]["UF_SITEMAP_PROP"] as $intPropID)
				{
					foreach($arResultPROP[$intPropID]["ENUM"] as $intEnumID => $strEnum)
					{
						if(isset($arResultSEF[$arResultPROP[$intPropID]["CODE"]][$intEnumID]))
						{
							// check existance
							$rsCnt = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "!PROPERTY_CH_SNYATO" => 2100916, "PROPERTY_".$arResultPROP[$intPropID]["CODE"] => $intEnumID), false, array("nTopCount"=>1), array("ID"));
							if($rsCnt>0)
							{
								$strPropLink = $arResult["SECTION"]["SECTION_PAGE_URL"].'tip-'.$arResultSEF[$arResultPROP[$intPropID]["CODE"]][$intEnumID].'/';

								// get H1 from SEO IB
								$strPropH1 = '';
								$arCurrSEOPropFilter = $arAllSEOPropFilter;
								$arCurrSEOPropFilter["PROPERTY_".$arResultPROP[$intPropID]["CODE"]] = $intEnumID;
								$rsSEO = CIBlockElement::GetList(Array(), array_merge(array("IBLOCK_ID" => 13, "ACTIVE" => "Y"), $arCurrSEOPropFilter), false, array("nTopCount"=>1), array("ID", "IBLOCK_ID", "PROPERTY_H1"));
								if($arSeo = $rsSEO -> GetNext())
									$strPropH1 = $arSeo["PROPERTY_H1_VALUE"];


								$arProps[] = '<a href="'.$strPropLink.'">'.(!empty($strPropH1)?$strPropH1:$arResult["SECTION"]["NAME"].' '.ToLower($strEnum)).'</a>';
							}
						}
					}
				}
				if(count($arProps)>0) $strLink .= '<div class="linkBrend">Быстрый переход: '.implode(" | ", $arProps).'</div>';

				unset($arResultSEF);
				unset($arResultPROP);
			}
		}

		echo $strLink;

		$obCache->EndDataCache();
	}

	$arResult["SEO_LINKING"] = ob_get_contents();
	ob_end_clean();
}
    

	if(isset($allpar) && is_object($this->__component))
	{
		$this->__component->arResult["ALLELEMENT"] = $allpar;
		//$this->__component->arResult["META"] = $arResult["META"];
		$this->__component->SetResultCacheKeys(array("ALLELEMENT"));
	}

    
?>
