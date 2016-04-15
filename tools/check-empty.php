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


    function file_force_download($file) {
        if (file_exists($file)) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    $items = CIBlockELement::GetList(array(),array("IBLOCK_ID"=>2,"DETAIL_PICTURE"=>false),false,false,array("ID","CODE","IBLOCK_SECTION_ID","NAME","DETAIL_PAGE_URL"));
    while($arElement = $items->GetNext()) {
        $list[] = $arElement["ID"].";".$arElement["NAME"].";http://.mamingorodok.ru".$arElement["DETAIL_PAGE_URL"]; 
    }

    $fp = fopen($_SERVER["DOCUMENT_ROOT"].'/tools/emptyItems.csv', 'w');

    foreach ($list as $line) {
        fputcsv($fp, explode(';', $line),";");
    }

    echo "Выгрузка завершена!";

    file_force_download($_SERVER["DOCUMENT_ROOT"].'/tools/emptyItems.csv');

?>

  <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>