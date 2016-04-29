<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
    
    $PROP = array();
    $value_id = iconv('UTF-8', 'Windows-1251', $_REQUEST["value_id"]);        
    $id_delivery = $_REQUEST["id_delivery"]; 
     arshow($_REQUEST);
    if($_POST["DELIVERY_ID"] != 1 or $arDelivery["ID"] != 1){ 
        $_SESSION["ADRESS"]["ID_DELIVERY"] = $id_delivery;
        $_SESSION["ADRESS"]["VALUE_ADRESS"] = $value_id; 
    }
    
?>