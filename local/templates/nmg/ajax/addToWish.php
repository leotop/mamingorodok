<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); 

    $el = new CIBlockElement;
    $productID = intval($_REQUEST['addDataId']);

    $PROP = array();
    $PROP["PRODUCT_ID"] = $productID;  
    $PROP["STATUS"] = "41";      
    $PROP["USER_ID"] = $USER->GetID();        

    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(), 
        "IBLOCK_SECTION_ID" => false,          
        "IBLOCK_ID"      => 8,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $productID,
        "ACTIVE"         => "Y",            
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        echo $PRODUCT_ID;
    else
        echo "Error: ".$el->LAST_ERROR;

?>