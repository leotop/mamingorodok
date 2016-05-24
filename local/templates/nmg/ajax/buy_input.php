<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$produktID = $_POST["id"];

$offer_id_basket = "";
$dbBasketItems = CSaleBasket::GetList(    // Проверка наналичие торгового предложения в корзине
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
        false,
        false,
        array("ID", "NAME", "PRODUCT_ID")
    );
while ($arItems = $dbBasketItems->Fetch())
{
    if (strlen($arItems["CALLBACK_FUNC"]) > 0)
    {
        CSaleBasket::UpdatePrice($arItems["ID"]);
        $arItems = CSaleBasket::GetByID($arItems["ID"]);
    }

    if($produktID == $arItems["PRODUCT_ID"]){
        $offer_id_basket = true;
        echo $offer_id_basket;
   }
}
