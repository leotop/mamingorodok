<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");

$arr_id_item_set_add = explode(', ', $_POST["id"]);

foreach($arr_id_item_set_add as $id_item_set_add){
   $res_set_add = CIBlockElement::GetByID($id_item_set_add);
   $rsPrices = CPrice::GetList(array(), array('PRODUCT_ID' => $id_item_set_add)); 
   $arPrice = $rsPrices->Fetch();
   $ar_res_set_add = $res_set_add->GetNext();   
   $arFields = array(
         "PRODUCT_ID" => $ar_res_set_add["ID"],
         "PRICE" => $arPrice["PRICE"],
         "CURRENCY" => $arPrice["CURRENCY"],
         "LID" => LANG,
         "MODULE" => "catalog",
         "NAME" => $ar_res_set_add["NAME"],
         "DETAIL_PAGE_URL" => $ar_res_set_add["DETAIL_PAGE_URL"]
      );

CSaleBasket::Add($arFields);
}   ?>
<div id="message-body"><?
    ?><h1>Товар успешно добавлен в корзину</h1></li><li style="text-align:center;">
    <a class="gray" onclick="_gaq.push(['_trackEvent', 'Button', 'ContinueBuy', 'Continue']); $('.popupContainer').hide(); $('.overlay').remove(); return false;" href="#">продолжить выбор товаров</a>&nbsp;&nbsp;&nbsp;<a onclick="_gaq.push(['_trackEvent', 'Button', 'OrderCart', 'Order']);" href="/basket/">перейти к оформлению заказа</a>
</li>
</div>
<? 
?>