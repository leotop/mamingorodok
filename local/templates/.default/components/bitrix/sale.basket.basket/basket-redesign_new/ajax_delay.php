<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");    
    if($_POST['id'] && $_POST['sign']){

        $dbBasketItems = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array("ID" => $_POST['id']),
            false,
            false,
            array("ID", "PRICE", "QUANTITY")
        );

        $arItem = $dbBasketItems->Fetch() ;

        if($_POST['sign']=='up'){
            $arFields = array(
                "QUANTITY" => $arItem["QUANTITY"]+1
            );
            CSaleBasket::Update($arItem["ID"], $arFields);    
        }
        else{
            $arFields = array(
                "QUANTITY" => $arItem["QUANTITY"]-1
            );
            CSaleBasket::Update($arItem["ID"], $arFields);    
        } 
                                              
        echo ($arFields["QUANTITY"]);  


    }
?>