<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("test");
?>
<?     /*
    $arOffer["ID"] = 89442;  
    $price = CPrice::GetList( array(),array("PRODUCT_ID"=>$arOffer["ID"]))->Fetch();

    CSaleBasket::Add(array(
    "PRICE" => $price["PRICE"],
    "QUANTITY" => 1,
    "CURRENCY" => "RUB",
    "PRODUCT_ID" => $arOffer["ID"],
    "PRODUCT_PROVIDER_CLASS"=>"CCatalogProductProvider",
    "MODULE"=> "catalog",
    "NAME" => $arOffer["NAME"],
    "LID" => LANG,
    "DELAY" => "N",
    "CAN_BUY" => "Y",  
    ));   */


    //arshow(checkSKUactive(84128));

   
    $items = CIBlockELement::GetList(array(),array("IBLOCK_ID"=>2,"DETAIL_PICTURE"=>false),false,false,array("ID","CODE","IBLOCK_SECTION_ID","NAME","DETAIL_PAGE_URL"));
    while($arElement = $items->GetNext()) {
        $list[] = $arElement["ID"].";".$arElement["NAME"].";http://.mamingorodok.ru".$arElement["DETAIL_PAGE_URL"]; 
    }

    $fp = fopen($_SERVER["DOCUMENT_ROOT"].'/test/emptyItems.csv', 'w');

    foreach ($list as $line) {
        fputcsv($fp, explode(';', $line),";");
    }
    

?>

  <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>