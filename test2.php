<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("test");

?>
<?   
    //Get array of rules          
    $rsRules = CIBlockElement::GetList(Array("SORT"=>"ASC"), array("IBLOCK_ID"=>30), false, false, array("ID", "NAME", "PROPERTY_PRICE_LOW", "PROPERTY_PRICE_HIGH", "PROPERTY_PRICE_DELIVERY"));
    while($arRule = $rsRules -> GetNext())
    { 
        $arRules[]=$arRule;
    }
    echo calcYandexDelivery(4700, $arRules);
?>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>