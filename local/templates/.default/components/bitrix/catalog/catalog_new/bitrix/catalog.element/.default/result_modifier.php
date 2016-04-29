<?



    CModule::IncludeModule("highloadblock"); 
    use Bitrix\Highloadblock as HL; 
    use Bitrix\Main\Entity;

    //���������� ������ ����� �� HL ��������� � ID = $id, ���� � ������� ��������� ��������� 
    //����� ��� ���������� ���� ������, ��� ���������� ������ 
    function GetFromHighload($id,$select,$filter)
    {
        $hlbl = $id; //"ID  Highload ���������" 
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();  
        // get entity 
        $entity = HL\HighloadBlockTable::compileEntity($hlblock); 

        $main_query = new Entity\Query($entity);
        $main_query->setSelect($select);

        $main_query->setFilter($filter);

        $result = $main_query->exec();
        $result = new CDBResult($result);

        if ($result->SelectedRowsCount() === 1)
        {
            return $result->Fetch();
        }
        else if ($result->SelectedRowsCount() > 1)
        {
            while($row = $result->Fetch())
            {
                $data[]=$row;
            }
            return $data;
        }
        return null;
    }

    //�������� ������ �������� �� ����������� ����
    function GetHeaderString($key)
    {
        $header=array(
            "UF_DESCRIPTION" => "��������",
            "UF_PLYUSY" => "�����",
            "UF_MINUSY" => "������",
            "UF_OSOBENNOSTI" => "�����������",
            "UF_KOLPROGBLOKTEXT" => "����������� ����",
            "UF_KOLLULKATEXT" => "������",
            "UF_KOLRUCHKATEXT" => "�����",
            "UF_KOLKOLESATEXT" => "������",
            "UF_KOLSHASSITEXT" => "�����",
            "UF_AVTKREPLENTEXT" => "��������� ������ � ����",
            "UF_AVTREGULTEXT" => "�������",
            "UF_AVTDOPHARKI" => "�������������",
            "UF_KOLKOMPLEKTTEXT" => "��������",
            "UF_KOLSAFETYTEXT" => "������������",
            "UF_KOLGABARITY" => "��������"
        );

        return $header[$key];
    }

    $id=1;
    $select=array(
        "UF_DESCRIPTION",
        "UF_PLYUSY",
        "UF_MINUSY",
        "UF_OSOBENNOSTI",
        "UF_KOLPROGBLOKTEXT",
        "UF_KOLLULKATEXT",
        "UF_KOLRUCHKATEXT",
        "UF_KOLKOLESATEXT",
        "UF_KOLSHASSITEXT",
        "UF_AVTKREPLENTEXT",
        "UF_AVTREGULTEXT",
        "UF_AVTDOPHARKI",
        "UF_KOLKOMPLEKTTEXT",
        "UF_KOLSAFETYTEXT",
        "UF_KOLGABARITY"
    );
    $filter=array("UF_ARTIKUL" => $arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]);  //����� �������� �� ��������
    $data=GetFromHighload($id,$select,$filter);



    foreach ($data as $key => $val)
    {
        if ($key!="UF_KOLKOMPLEKTTEXT")  //�������� ������������
        {
            if ( trim(strip_tags($val))!="" )
            {
                $arOtherProp[$key]=array("key" => GetHeaderString($key),"value" => $val);     
            }
        }
        else
        {
            $arResult[$key]=$val;    
        }        
    }

    $arResult["OTHER_PROPERTIES"]=$arOtherProp;

    $id=2;
    $select=array("UF_AKSESSUAR");       //������� ��� ������
    $filter=array("UF_NOMENKLATURA" => $arResult["XML_ID"]); //����� �������� �� �������� ����
   
    
    $data=GetFromHighload($id,$select,$filter);
    
    if(count($data) > 1){
        foreach($data as $row)
        {
            $arXML_ID[]= $row["UF_AKSESSUAR"];
        }
    }else if ($data["UF_AKSESSUAR"]){
        $arXML_ID[] = $data["UF_AKSESSUAR"];
    }

                              

    if (is_array($arXML_ID) && count($arXML_ID) > 0) {
        $db=CIBlockElement::GetList(array(),array("XML_ID" => $arXML_ID, "ACTIVE" => 'Y'),false,false,
            array("PREVIEW_PICTURE","DETAIL_PAGE_URL","NAME","PROPERTY_PRICE"));
        while($ob=$db->GetNext())
        {
            $arResult["ACCESSORIES"][]= $ob;
        }
    }     

    if (!CModule::IncludeModule("forum")) return false;       
    

    if($arResult["PROPERTIES"]["CH_PRODUCER"]["VALUE"]>0)
    {
        $temp=GetProducerByID($arResult["PROPERTIES"]["CH_PRODUCER"]["VALUE"]);   //�.�. init.php
        if ($temp) $arResult["PRODUCER"]= $temp;
    }

 

    if ($arSection["ID"] > 0) {
        $obSection = CIBlockSection::GetList(array(), array("ID" => $arSection["ID"]), false, array("UF_NAME_SINGLE"))->GetNext();
    }



    $arSection["UF_NAME_SINGLE"] = $obSection["UF_NAME_SINGLE"];
    
    

    // seo section
    if(strlen($arResult["PROPERTIES"]["title"]["VALUE"])<=0)
    {
        if(strlen($arResult["PROPERTIES"]["SEO_MODEL"]["VALUE"])>0 && strlen($arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"])>0)
            $arResult["PROPERTIES"]["title"]["VALUE"] = capitalizeString($arSection["UF_NAME_SINGLE"])." ".$arResult["PROPERTIES"]["SEO_TYPE"]["VALUE"]." ".$arResult["PRODUCER"]["NAME"]." ".$arResult["PROPERTIES"]["SEO_MODEL"]["VALUE"]." - ������ ".$arResult["PRODUCER"]["PROPERTY_NAME_RUS_VALUE"]." ".(!empty($arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"])?$arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"].' ':'')."�� �������� ���� - ��������, ������ - ����� �������";
        else $arResult["PROPERTIES"]["title"]["VALUE"] = $arResult["NAME"];
    }

    if(strlen($arResult["PROPERTIES"]["description"]["VALUE"])<=0)
        $arResult["PROPERTIES"]["description"]["VALUE"] = capitalizeString($arSection["UF_NAME_SINGLE"])." ".$arResult["PROPERTIES"]["SEO_TYPE"]["VALUE"]." ".$arResult["PROPERTIES"]["SEO_MODEL"]["VALUE"]." �� ".$arResult["PRODUCER"]["NAME"].". �������� ������ � ��������� � ��������-�������� ������ �������.";

    if(strlen($arResult["PROPERTIES"]["SEO_H1"]["VALUE"])<=0)
    {
        if(strlen($arResult["PROPERTIES"]["SEO_MODEL"]["VALUE"])>0)
            $arResult["PROPERTIES"]["SEO_H1"]["VALUE"] = capitalizeString($arSection["UF_NAME_SINGLE"])." ".$arResult["PROPERTIES"]["SEO_TYPE"]["VALUE"]." ".$arResult["PRODUCER"]["NAME"]." ".$arResult["PROPERTIES"]["SEO_MODEL"]["VALUE"];
        else {
            $arResult["SEO_H1_FROM_NAME"] = 'Y';
            $arResult["PROPERTIES"]["SEO_H1"]["VALUE"] = $arResult["NAME"];
        }
    }          

    $arSelect = array(
        "ID", 
        "IBLOCK_ID", 
        "NAME",
        "XML_ID", 
        "DETAIL_PICTURE", 
        "PROPERTY_OLD_PRICE", 
        "PROPERTY_IMG_BIG", 
        "PROPERTY_SIZE", 
        "PROPERTY_COLOR_CODE", 
        "PROPERTY_COLOR_IMAGE",
        "PROPERTY_COLOR",
        "PROPERTY_CML2_ARTICLE",
        "PROPERTY_PICTURE_MINI",
        "PROPERTY_PICTURE_MIDI",
        "PROPERTY_PICTURE_MAXI",
        "PROPERTY_ELEMENT_XML_1C",
        "CATALOG_GROUP_1",
        "PROPERTY_TSVET",
        "PROPERTY_RAZMER",
        "PROPERTY_SHASSI" 

    );


    $strStartColor = '';
    $strStartSize = '';

    $arResult["COLORS_HAS_SAME_PRICE"] = true;
    $arResult["START_OFFERS_BY_SIZE"] = array();
    $tmpPrice = 0;
    $floatMinPrice = 100000000;
    // $floatMinPrice=GetOfferMinPrice($arParams["IBLOCK_ID"],$arOffer["ID"]);
    $arOffers = array();
    $arResult["CS"] = array();
    $arResult["SIZE_AVAIL"] = array();
    $rsOffers = CIBlockElement::GetList(array("PROPERTY_SERVICE_QSORT"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MAIN_PRODUCT"=>$arResult["ID"]/*, ">CATALOG_QUANTITY"=>0*/), false, false, $arSelect);

    
    
    //�������� ID �������� ���� ����

    $priceType = CCatalogGroup::GetList( array(), array("NAME"=>$arParams["PRICE_CODE"]), false, false, array())->Fetch();


    $priceType["ID"] = $arResult["PRICES_ALLOW"][0]; //������� ������ ID ����


    while($arOffer = $rsOffers -> GetNext())
    {

        // arshow($arOffer,true);
        // if(!empty($arOffer["PROPERTY_SHASSI_VALUE"])){
        //                 $offerSize= $arOffer["PROPERTY_SHASSI_VALUE"];
        //        } else {
        //            
        //        }
        $offerSize= $arOffer["PROPERTY_RAZMER_VALUE"];
        $offerColor= $arOffer["PROPERTY_TSVET_VALUE"];
        $offerChassis = $arOffer["PROPERTY_SHASSI_VALUE"];

        //        arshow($offerChassis);

        if (empty($offerSize))    //���� ������ �� �����
        {
            $arOffer["PROPERTY_RAZMER_VALUE"] = "��������";
            $offerSize="��������";
        }

        if (empty($offerColor))  //���� ���� �� �����
        {
            $arOffer["PROPERTY_TSVET_VALUE"] = "���� �� �����";
            $offerColor="���� �� �����";
        }

        //$arOffer["CATALOG_QUANTITY"] = 2; // ������ � �������   

        $obPrice=CPrice::GetList(array(),array("PRODUCT_ID" => $arOffer["ID"], "CATALOG_GROUP_ID" => $priceType["ID"]),false,false,array("PRICE"))->Fetch();
        //$arOffer["PRICE"] = CCatalogProduct::GetOptimalPrice($arOffer["ID"], 1, $USER->GetUserGroupArray());
        $arOffer["PRICE"] = $obPrice["PRICE"];

        //arshow($arOffer);  //94406    

        if(!isset($arResult["CS"][$offerSize]["AVAIL"]))
        { 
            //   $arResult["CS"][$offerSize]["AVAIL"] = array();
        }
        if(!isset($arResult["CS"][$offerSize]["NAVAIL"]))
        { 
            //   $arResult["CS"][$offerSize]["NAVAIL"] = array();
        }

        if($arOffer["PRICE"] <= 0)
            $arOffer["~CATALOG_QUANTITY"] = 0;
        elseif($arResult["COLORS_HAS_SAME_PRICE"]) {
            if($tmpPrice == 0)
                $tmpPrice = $arOffer["PRICE"];
            elseif($tmpPrice != $arOffer["PRICE"])
                $arResult["COLORS_HAS_SAME_PRICE"] = false;
        }


        $arResult["CS"][$offerSize]/*[($arOffer["CATALOG_QUANTITY"] > 0 ? "AVAIL":"NAVAIL")]*/[$offerColor] = $arOffer;   //��������� ��� ���� ����� ���������� avail � navail ���� ��� ������ �� ������������, � ������ ��������� � ����
        //        arshow($arOffer); 
        $arResult["ALL_COLOR"][$arOffer["ID"]]= $arOffer;
        
        if (!empty($arOffer["PROPERTY_SHASSI_VALUE"])) { 
            $arResult["CS"]["CHASSI"][$arOffer["ID"]] = $arOffer;   //��������� ��� ���� ����� ���������� avail � navail ���� ��� ������ �� ������������, � ������ ��������� � ����
        }

        if($arOffer["~CATALOG_QUANTITY"]>0) $arResult["SIZE_AVAIL"][$offerSize] = 'Y';

        if($floatMinPrice > $arOffer["PRICE"] && $arOffer["PRICE"] > 0 && $arOffer["CATALOG_QUANTITY"] > 0 && !isset($arResult["START_SIZE"]))
        //  if($floatMinPrice > 0 && $arOffer["CATALOG_QUANTITY"] > 0 && !isset($arResult["START_SIZE"]))
        {
            $floatMinPrice = $arOffer["PRICE"];

            $arResult["START_SIZE"] = $offerSize;    
            $arResult["START_COLOR"] = $offerColor; // dont need

        }                



        if( (!isset($arResult["START_OFFERS_BY_SIZE"][$offerSize]) && $arOffer["PRICE"] > 0 && $arOffer["~CATALOG_QUANTITY"] > 0) || ($arResult["START_OFFERS_BY_SIZE"][$offerSize]["PRICE"] > $arOffer["PRICE"] && $arOffer["~CATALOG_QUANTITY"]>0)) 
        {
            $arResult["START_OFFERS_BY_SIZE"][$offerSize] = $arOffer;
        }


        if(strlen($strStartColor)<=0) $strStartColor = $offerColor;
        if(strlen($strStartSize)<=0) $strStartSize = $offerSize;

    }

    
    // arshow($arResult["CS"]);

    ksort($arResult["CS"]);
    foreach($arResult["CS"] as $strSize => $arData)
    {
        // $arResult["CS"][$strSize] = array_merge($arData["AVAIL"], $arData["NAVAIL"]);   //���������, ��� ���� ���� ���, ���� avail � navail ����� �� ���������� � ����� �� ��������������
    }


    // ���� ���� ������� - �� ������ ��������� ����������� - ������ ������

    if(strlen($arResult["START_SIZE"])<=0)
        $arResult["START_SIZE"] = $strStartSize;

    if(strlen($arResult["START_COLOR"])<=0)
        $arResult["START_COLOR"] = $strStartColor;


    // ���������� 
    if(!empty($arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]))
    {  
        $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]), false, false, array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_PRICE", "PROPERTY_OLD_PRICE", "PROPERTY_RATING"));    
        while($obEl = $dbEl->GetNext())
            $arResult["ACCESSORIES_ITEMS"][] = $obEl;
    }
    
      


    $arTmpSections = array();
    $rsElementSections = CIBlockElement::GetElementGroups($arResult["ID"], true);
    while($arElementSection = $rsElementSections->Fetch())
        $arTmpSections[] = $arElementSection["ID"];

        

    $arResult["HARACTERISTICS"] = array();
    $arResult["TYPICAL_OPTIONS"] = array();
    if(count($arTmpSections)>0)
    {
        $db_list = CIBlockSection::GetList(array(), array('IBLOCK_ID'=>$arResult["IBLOCK_ID"], "ID"=>$arTmpSections), false,array("ID","UF_HARACTERISTICS", "UF_TYPICAL_OPTIONS"));
        while($ar_result = $db_list->GetNext())
        {
            //arshow($ar_result);
            $arResult["HARACTERISTICS"] = array_merge($arResult["HARACTERISTICS"], $ar_result["UF_HARACTERISTICS"]);
            $arResult["TYPICAL_OPTIONS"] = array_merge($arResult["TYPICAL_OPTIONS"], $ar_result["UF_TYPICAL_OPTIONS"]);
        }
    }

   

    $arResult["HARACTERISTICS"] = array_unique($arResult["HARACTERISTICS"]);
    $arResult["TYPICAL_OPTIONS"] = array_unique($arResult["TYPICAL_OPTIONS"]);

    $db_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>1,"PARAM2"=>$arResult["ID"]));
    $arResult["PROPERTIES"]["VOTES"]["VALUE"] = $db_res -> SelectedRowsCount();

     

    $arResult["CART_PRICE"] = 0;
    $dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array());
    while ($arItems = $dbBasketItems->Fetch())
        $arResult["CART_PRICE"] += $arItems["PRICE"] * $arItems["QUANTITY"];
        
          

    // delivery
    $rsDelivery = CSaleDelivery::GetList(array("SORT" => "ASC", "NAME" => "ASC" ), array("LID" => SITE_ID, "ACTIVE" => "Y", "NAME"=>"�������� �� ������ � ��"), false, false, array());
    while($arDelivery = $rsDelivery -> GetNext())
        $arResult["DELIVERY"][] = $arDelivery;
    
 

?>