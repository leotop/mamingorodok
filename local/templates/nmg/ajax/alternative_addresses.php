<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

   
    $sistem_pay_id = $_REQUEST["sistem_pay_id"];  
       $_SESSION["PAY_SISTEM_ID_ACTIVE"] = $sistem_pay_id;      
?>