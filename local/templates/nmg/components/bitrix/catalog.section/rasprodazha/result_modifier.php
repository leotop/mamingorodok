<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("forum"))
    return;
    
//-------------------------------------------------------------------------------------------------------
if($arParams["SECTION_ID"]>0)
{
    $arFilter = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'ID'=>$arParams["SECTION_ID"]);
    $db_list = CIBlockSection::GetList(Array(), $arFilter, false, 
        array("UF_HARACTERISTICS","UF_DESCRIPTION","UF_TITLE","UF_KEYWORDS", 
            "UF_H1", "UF_H2", "UF_NAME_PAD", "UF_SITEMAP_PROP", "UF_DESCR_PREVIEW"));
    if($ar_result = $db_list->GetNext())
    {
        //arshow($ar_result);
        $arResult["SECTION"] = $ar_result;

        $arResult["UF_HARACTERISTICS"] = $ar_result["UF_HARACTERISTICS"];
        $arResult["META"]["UF_DESCRIPTION"] = $ar_result["UF_DESCRIPTION"];
        $arResult["META"]["UF_TITLE"] = $ar_result["UF_TITLE"];
        $arResult["META"]["UF_KEYWORDS"] = $ar_result["UF_KEYWORDS"];
        $arResult["META"]["UF_NAME_PAD"] = (strlen($ar_result["UF_NAME_PAD"])>0?$ar_result["UF_NAME_PAD"]:$arResult["SECTION"]["NAME"]);
        $arResult["META"]["H1"] = $arResult["SECTION"]["UF_H1"];
        $arResult["META"]["H2"] = $arResult["SECTION"]["UF_H2"];
        $arResult["~UF_DESCR_PREVIEW"] = $ar_result["~UF_DESCR_PREVIEW"];
    }
}


   
if(strlen($arResult["SECTION"]["UF_H1"])<=0)
    $arResult["META"]["H1"] = "Детские ".decapitalizeString($arResult["SECTION"]["NAME"]);

if($GLOBALS["SET_SEO"]["type"] == 'producer')
{
    $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
    $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];
    $strProducerRus = $GLOBALS["SET_SEO"]["DATA"]["PROPERTY_NAME_RUS_VALUE"];

    $arResult["META"]["H2"] = capitalizeString($arResult["SECTION"]["NAME"]).' для детей '.(strlen($strProducerRus)>0?$strProducerRus:$strProducer);
} else {
    if(strlen($arResult["SECTION"]["UF_H2"])<=0)
        $arResult["META"]["H2"] = capitalizeString($arResult["SECTION"]["NAME"]).' для детей';
}

$strDecapitalizedTitle = decapitalizeString($arResult["SECTION"]["NAME"]);
$strDecapitalizedTitlePad = decapitalizeString($arResult["META"]["UF_NAME_PAD"]);

if(strlen($arResult["META"]["UF_TITLE"])<=0)
    $arResult["META"]["UF_TITLE"] = "Детские ".$strDecapitalizedTitle." по выгодной цене - купить ".$strDecapitalizedTitle." для детей с доставкой по Москве - интернет-магазин ".$strDecapitalizedTitlePad." «Мамин городок»";

if(strlen($arResult["META"]["UF_DESCRIPTION"])<=0)
    $arResult["META"]["UF_DESCRIPTION"] = "Детские ".$strDecapitalizedTitle." отличного качества! Бесплатная доставка при заказе от 3 000 рублей по Москве! Большой выбор в интернет-магазине ".$strDecapitalizedTitlePad." «Мамин городок».";

//Получаем бренды    
$arParams["BREND"] = $_REQUEST["brendCode"];
if($arParams["BREND"]) $arParams["brendID"] = $_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"][0];
    
if($arParams["BREND"])
{
    $arResult["BREND_SECTIONS"] = array();
    $rsSec = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME" => "ASC"), array("IBLOCK_ID"=>2, "ACTIVE"=>"Y", "PROPERTY"=>array("CH_PRODUCER" => $_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"])), false);
    while($arSec = $rsSec -> GetNext())
        $arResult["BREND_SECTIONS"][$arSec["ID"]] = $arSec;

    $rsB = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>5, "ID"=>$arParams["brendID"]), false, false, array("ID", "NAME", "PROPERTY_NAME_RUS", "CODE"));
    if($arB = $rsB -> GetNext()) $arResult["BREND"] = $arB;

    $arResult["SEO"]["TITLE"] = $arResult["BREND"]["NAME"].(empty($arB["PROPERTY_NAME_RUS_VALUE"])?'':' ('.$arB["PROPERTY_NAME_RUS_VALUE"].')').' - детские товары - Мамин городок';
    $arResult["SEO"]["H1"] = $arResult["BREND"]["NAME"];
} else $arResult["SEO"] = getSEOParams(); 

//Получаем характеристики
foreach($arResult["UF_HARACTERISTICS"] as $v){
    $res = CIBlockProperty::GetByID($v, $arParams["IBLOCK_ID"]);
    if($ar_res = $res->GetNext()){
        $propp[] = $ar_res['CODE'];
        $prop1[] = array("NAME"=>$ar_res['NAME'],"CODE"=>$ar_res['CODE']);
    }
}

if(is_array($propp)){
    $arSelect = $propp;
    $arResult["UF_HARACTERISTICS"] = $prop1;
}

$arIds=array();
foreach ($arResult["ITEMS"] as $arItem) 
{
    $arIds[]=$arItem["ID"]; 
}

// actions
if($arResult["SECTION"]["DEPTH_LEVEL"] == 2 || $arParams["SEARCH"] == "Y")
{
    $strSearch = '';
    foreach($arIds as $intID)
        $strSearch .= (strlen($strSearch)>0?' || ':'').'#'.$intID.'#';
    
    if(strlen($strSearch)>0)
    {
        $rsAction = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>18, "ACTIVE"=>"Y", "DATE_ACTIVE"=>"Y", "?PROPERTY_ITEMS"=>$strSearch), false, false, array("ID", "NAME", "PROPERTY_BLOG_POST", "PROPERTY_PREVIEW", "DETAIL_PAGE_URL", "DETAIL_PICTURE", "PROPERTY_ITEMS", "PREVIEW_TEXT", "PREVIEW_TEXT_TYPE", "PROPERTY_SPECOFFER"));
        while($arAction = $rsAction->GetNext())
        {
            $arActionItems = explode("#", substr($arAction["PROPERTY_ITEMS_VALUE"], 1, strlen($arAction["PROPERTY_ITEMS_VALUE"])-2));
            foreach($arActionItems as $intActionItem)
                $arResult["ACTIONS_ITEMS"][$intActionItem] = $arAction["ID"];
            
            if($arAction["PROPERTY_PREVIEW_VALUE"]>0)
                $arAction["PREVIEW"] = CFile::GetFileArray($arAction["PROPERTY_PREVIEW_VALUE"]);
            
            $arResult["ACTIONS"][$arAction["ID"]] = $arAction;
        }
    }
}

//-------------------------------------------------------------------------------------------------------            

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
    $intIBlockID = $arParams["IBLOCK_ID"]; 
    $mxResult = CCatalogSKU::GetInfoByProductIBlock( 
    $intIBlockID 
    ); 
    if (is_array($mxResult)) 
    { 

        $rsOffers = CIBlockElement::GetList(array("PRICE"=>"ASC"),array('IBLOCK_ID' => $mxResult['IBLOCK_ID'], 'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $arItem["ID"])); 
        if ($arOffer = $rsOffers->GetNext()) 
        {             
            $db=CPrice::GetList(array(),array("ID" => $arOffer["ID"]),false,false,array());
            $ob=$db->Fetch();
        } 
    } 
    $ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arItem["ID"]), true);
    
    

    $arResult["ITEMS"][$k]["COUNT_REPORTS"] = $ar_res;

    $qq = 0;
    $arFilter = Array(
        "IBLOCK_ID"=>OFFERS_IBLOCK_ID,
        "ACTIVE"=>"Y",
        "PROPERTY_CML2_LINK"=>$arItem["ID"]
    );
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
    $minPrice=PHP_INT_MAX;
    while($ar_fields = $res->GetNext()){
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
            if ($price < $minPrice) $minPrice=$price; //вычисляем мин цену торгового предложения
        } 
        if($ar_res["QUANTITY"]>0 && $price >0)
            $qq++;
        }
    $arResult["ITEMS"][$k]["OFFER_MIN_PRICE"]=$minPrice;
         
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
            //arshow($arResult["SECTION"]);
            $arSubSec = array();
            $rsSub = CIBlockSection::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), 
                array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "SECTION_ID" => $arResult["SECTION"]["ID"]), false);
            while($arSub = $rsSub -> GetNext())
            {
                //arshow($arSub);
                $arSubSec[] = '<a href="'.$arSub["SECTION_PAGE_URL"].'">'.$arSub["NAME"].'</a>';    
            }

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
                    //echo $intPropID;
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
                //arshow($arProps);
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
    /*
    if($GLOBALS["SET_SEO"]["type"] == 'producer')
{
    $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
    $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];
    $strProducerRus = $GLOBALS["SET_SEO"]["DATA"]["PROPERTY_NAME_RUS_VALUE"];
    
    //if(empty($arResult["SEO"]["TITLE"]))
        //$arResult["SEO"]["TITLE"] = $strProducer.", ".$strCategoryName.' '.$strProducer.", купить ".$strCategoryName.' '.$strProducer." - отзывы, цены, фото на детские ".$strCategoryName." ".$strProducer." для новорожденных – интернет-магазин «Мамин городок».";
    if(empty($arResult["SEO"]["TITLE"]))
        $arResult["SEO"]["TITLE"] = $strCategoryName.' '.$strProducer.(strlen($strProducerRus)>0? " (".$strProducerRus.")":'').' - выгодные цены - Мамин городок';
        //$arResult["SEO"]["TITLE"] = "Детские ".ToLower($strCategoryName)." ".$strProducer.(strlen($strProducerRus)>0? " (".$strProducerRus.")":'')." купить по выгодной цене - интернет-магазин «Мамин городок»";

    
    //if(empty($arResult["SEO"]["DESCRIPTION"]))
        //$arResult["SEO"]["DESCRIPTION"] =  'Интернет магазин «Мамин городок» предлагает вам в ассортименте : '.$strCategoryName.' '.$strProducer.', большой выбор, низкие цены.';
    if(empty($arResult["SEO"]["DESCRIPTION"]))
        $arResult["SEO"]["DESCRIPTION"] =  $strCategoryName." ".$strProducer.(strlen($strProducerRus)>0? " (".$strProducerRus.")":'')." с бесплатной доставкой по Москве! Большой выбор и отличное качество в интернет-магазине «Мамин городок».";
        
    if(empty($arResult["SEO"]["KEYWORDS"]))
        $arResult["SEO"]["KEYWORDS"] = $strCategoryName.' '.$strProducer.', детские '.$strCategoryName.' '.$strProducer.', '.$strCategoryName.' '.$strProducer.' для детей, '.$strCategoryName.' '.$strProducer.' цены, '.$strCategoryName.' '.$strProducer.' купить';
    
    $arResult["NAME"] = $strCategoryName.' '.$strProducer;

    $strTitleAlt = $strCategoryName.' '.$strProducer;
    if(empty($arResult["META"]["UF_TITLE"]))
        $arResult["META"]["UF_TITLE"] = $strTitleAlt;

    if(!empty($strTitleAlt))
        $arResult["PATH"][] = array("NAME" => $strTitleAlt);
    else $arResult["PATH"][] = array("NAME" => $strCategoryName.' '.$strProducer);
} elseif($GLOBALS["SET_SEO"]["type"] == 'property') {
    //echo '<pre>'.print_r($GLOBALS["SET_SEO"], true).'</pre>';
    $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
    
    if(strlen($GLOBALS["SET_SEO"]["DATA"]["ENUM"]["VALUE"])>0)
        $strProperty = $GLOBALS["SET_SEO"]["DATA"]["ENUM"]["VALUE"];
    else $strProperty = $GLOBALS["SET_SEO"]["DATA"]["NAME"];
    
    $strProdType = $strTitleAlt = $strCategoryName." ".ToLower($strProperty);
    
    //if(empty($arResult["SEO"]["TITLE"]))
        //$arResult["SEO"]["TITLE"] = $strCategoryName." ".$strProperty.', купить '.$strCategoryName." ".$strProperty.' - отзывы, цены, фото на детские '.$strCategoryName." ".$strProperty.' – интернет-магазин «Мамин городок».';
     if(empty($arResult["SEO"]["TITLE"]))
        $arResult["SEO"]["TITLE"] = $strCategoryName." ".ToLower($strProperty)." по выгодной цене - купить ".ToLower($strCategoryName)." для детей в интернет-магазине «Мамин городок»";
 
  
    
    if(empty($arResult["SEO"]["KEYWORDS"]))
        $arResult["SEO"]["KEYWORDS"] = $strProdType.', детские '.$strProdType.', '.$strProdType.' для детей';
    
    //if(empty($arResult["SEO"]["DESCRIPTION"]))
        //$arResult["SEO"]["DESCRIPTION"] = 'Интернет магазин «Мамин городок» предлагает вам в ассортименте : '.$strProdType.', большой выбор, низкие цены.';
    
    if(empty($arResult["SEO"]["DESCRIPTION"]))
        $arResult["SEO"]["DESCRIPTION"] = $strCategoryName.' '.$strProperty.' в наличии! Огромный выбор, быстрая доставка, выгодные цены!.';
    
    if(empty($arResult["META"]["UF_TITLE"]))
        $arResult["META"]["UF_TITLE"] = $strProdType;

    $strCustomBCTitle = $GLOBALS["SET_SEO"]["DATA"]["PROPERTY_BREADCRUMB_TITLE_VALUE"];

    if(!empty($strTitleAlt))
        $arResult["PATH"][] = array("NAME" => $strTitleAlt);
    else $arResult["PATH"][] = array("NAME" => (!empty($strCustomBCTitle)?$strCustomBCTitle:$strProperty." ".ToLower(substr($strCategoryName, 0, 1).substr($strCategoryName, 1))));
} else {
    $strTitleAlt = 'Детские '.ToLower($arResult["NAME"]);
}


foreach($arResult["ITEMS"] as $arItem)
{
    if($arResult["SECTION"]["DEPTH_LEVEL"] == 2) $arResult["ITEM_PATH"][$arItem["ID"]] = $arResult["SECTION"]["ID"];
    
    if($arParams["brendID"]>0)
        $arResult["ITEMS"][$arItem["IBLOCK_SECTION_ID"]][] = $arItem;
}

//arshow($arResult["ITEMS"]);



if(!is_array($_SESSION[""])) $_SESSION["ITEM_PATH"] = array();
if(!is_array($arResult["ITEM_PATH"])) $arResult["ITEM_PATH"] = array();
if(is_array($arResult["ITEM_PATH"]) && count($arResult["ITEM_PATH"])>0)
    $_SESSION["ITEM_PATH"] =  $arResult["ITEM_PATH"] + $_SESSION["ITEM_PATH"];
//echo '<pre>'.print_r($arResult["ITEM_PATH"], true).'</pre>';
//echo '<pre>'.print_r($_SESSION["ITEM_PATH"], true).'</pre>';

if($_REQUEST["set_filter"] != "Y")
{
    if(strlen($arResult["SEO"]["TITLE"])<=0) $arResult["SEO"]["TITLE"] = $arResult["META"]["UF_TITLE"];
    if(strlen($arResult["SEO"]["KEYWORDS"])<=0) $arResult["SEO"]["KEYWORDS"] = $arResult["META"]["UF_KEYWORDS"];
    if(strlen($arResult["SEO"]["DESCRIPTION"])<=0) $arResult["SEO"]["DESCRIPTION"] = $arResult["META"]["UF_DESCRIPTION"];
}*/


?>
