<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("test");
?>

<?
    /*

    $res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>3, array(
        "LOGIC" => "OR",
        array("PROPERTY_MAIN_PRODUCT"=>false, "!PROPERTY_CML2_LINK"=>false),
        array("!PROPERTY_MAIN_PRODUCT"=>false, "PROPERTY_CML2_LINK"=>false),
        ),), false, false, array("ID","PROPERTY_MAIN_PRODUCT","PROPERTY_CML2_LINK"));
    while ($aRes = $res->Fetch()) {
        arshow($aRes);
        if (!$aRes["PROPERTY_CML2_LINK_VALUE"]) {
            $PROPERTY_CODE = "CML2_LINK";
            $PROPERTY_VALUE = $aRes["PROPERTY_MAIN_PRODUCT_VALUE"];
        }
        else {
            $PROPERTY_CODE = "MAIN_PRODUCT";
            $PROPERTY_VALUE = $aRes["PROPERTY_CML2_LINK_VALUE"]; 
        }

        CIBlockElement::SetPropertyValuesEx($aRes["ID"], 3, array($PROPERTY_CODE => $PROPERTY_VALUE));  
    }
    */
?>