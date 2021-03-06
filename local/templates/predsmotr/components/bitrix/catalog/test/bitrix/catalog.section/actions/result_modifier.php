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
        $arResult["META"]["H1"] = "������� ".decapitalizeString($arResult["SECTION"]["NAME"]);

    if($GLOBALS["SET_SEO"]["type"] == 'producer')
    {
        $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
        $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];
        $strProducerRus = $GLOBALS["SET_SEO"]["DATA"]["PROPERTY_NAME_RUS_VALUE"];

        $arResult["META"]["H2"] = capitalizeString($arResult["SECTION"]["NAME"]).' ��� ����� '.(strlen($strProducerRus)>0?$strProducerRus:$strProducer);
    } else {
        if(strlen($arResult["SECTION"]["UF_H2"])<=0)
            $arResult["META"]["H2"] = capitalizeString($arResult["SECTION"]["NAME"]).' ��� �����';
    }

    $strDecapitalizedTitle = decapitalizeString($arResult["SECTION"]["NAME"]);
    $strDecapitalizedTitlePad = decapitalizeString($arResult["META"]["UF_NAME_PAD"]);

    if(strlen($arResult["META"]["UF_TITLE"])<=0)
        $arResult["META"]["UF_TITLE"] = "������� ".$strDecapitalizedTitle." �� �������� ���� - ������ ".$strDecapitalizedTitle." ��� ����� � ��������� �� ������ - ��������-������� ".$strDecapitalizedTitlePad." ������ �������";

    if(strlen($arResult["META"]["UF_DESCRIPTION"])<=0)
        $arResult["META"]["UF_DESCRIPTION"] = "������� ".$strDecapitalizedTitle." ��������� ��������! ���������� �������� ��� ������ �� 3 000 ������ �� ������! ������� ����� � ��������-�������� ".$strDecapitalizedTitlePad." ������ �������.";

    //�������� ������

    $arResult["SEO"] = getSEOParams();

    //arshow($arResult["SEO"],true);


    //�������� ��������������
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

    $intIBlockID = $arParams["IBLOCK_ID"];
    $mxResult = CCatalogSKU::GetInfoByProductIBlock(
        $intIBlockID
    );

    foreach($arResult["ITEMS"] as $k=>$arItem)
    {



        $ar_res = "";
        //$ar_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arItem["ID"]), true);



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
                if ($price < $minPrice) $minPrice=$price; //��������� ��� ���� ��������� �����������
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


    // linking here

    if($arResult["SECTION"]["ID"]>0)
    {
        // cache this block for all pagenav for this section

        $strLink = '';

        // brend
        $arBrend = array();
        $rsP = CIBlockElement::GetList(Array("PROPERTY_PROIZVODITEL_VALUE" => "ASC"), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "!PROPERTY_CH_SNYATO" => 2100916, "SECTION_ID" => $arResult["SECTION"]["ID"], "INCLUDE_SUBSECTIONS"=>"Y"), array("PROPERTY_PROIZVODITEL"), false, array("IBLOCK_ID", "ID"));
        while($arP = $rsP -> GetNext()) {
            $arBrend[] = '<a href="'.$arResult["SECTION"]["SECTION_PAGE_URL"].'filter/proizvoditel-'.CUtil::Translit($arP["PROPERTY_PROIZVODITEL_VALUE"],"ru",array("replace_space"=>"_","replace_other"=>"")).'/">'.$arP["PROPERTY_PROIZVODITEL_VALUE"].'</a>';
        }
        if(count($arBrend)>0) $strLink .= '<div class="linkBrend">������: '.implode(" | ", $arBrend).'</div>';
        unset($arBrend);


        $links = CIBlockElement::GetList(array("NAME"=>"ASC"),array("IBLOCK_ID"=>25,"PROPERTY_SECTION"=>$arResult["SECTION"]["ID"]),false,false,array("NAME","PROPERTY_LINK"));
        while($arLink = $links->Fetch()) {
            $arProps[] = '<a href="'.$arLink["PROPERTY_LINK_VALUE"].'">'.$arLink["NAME"].'</a>';
        }

        if(count($arProps)>0) $strLink .= '<div class="linkBrend">������� �������: '.implode(" | ", $arProps).'</div>';



        $arResult["SEO_LINKING"] = $strLink;
    }


    if(isset($allpar) && is_object($this->__component))
    {
        $this->__component->arResult["ALLELEMENT"] = $allpar;
        $this->__component->SetResultCacheKeys(array("ALLELEMENT"));
    }



?>
