<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<style>
    <?include('/templates/nmg/style_blog.css');?>
</style>
<?
    GLOBAL $USER;
    $intCartCnt = 0;
    if(CModule::IncludeModule("sale"))
    {
        $dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N", "CAN_BUY" => "Y"), false, false, array());
        while ($arItems = $dbBasketItems->Fetch())
            $intCartCnt += $arItems["QUANTITY"];
            arshow($arItems);
    } 
    $summ_price=0;
    $summ_discount=0;
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL",
            'CAN_BUY' => 'Y',
            'DELAY' => 'N'
        ),
        false,
        false,
        array()
    );
    while($BasketItems=$dbBasketItems->Fetch())    {
        $summ_price+=ceil(($BasketItems['PRICE']+$BasketItems['DISCOUNT_PRICE'])*$BasketItems['QUANTITY']);
        $summ_discount+=ceil($BasketItems['DISCOUNT_PRICE']*$BasketItems['QUANTITY']);

}?>
<input type="hidden" id="summ_discount" value="<?=$summ_discount?>"/>
<input type="hidden" id="summ_price" value="<?=$summ_price?>"/>
<a href="/basket/" class="sk-mybar--cart" title="Моя корзина">Моя корзина <span class="js-cartCnt">(<?=$intCartCnt?>)</span></a>
<div class="info_basket" style="position:absolute; right:0;">
    <div class="info_basket_arrow"></div>
    <div class="info_basket_content">
        <div class="info_field_1">
            <span style="float:left">Сумма без скидки</span>
            <span style="float:right; color:purple;"><?=($summ_price-$summ_discount)?> <span class="rouble">a</span></span></span>
        </div>

        <div class="info_field_2">
            <span style="float:left">Вы экономите</span>
            <span style="float:right; color:purple;"><?=$summ_discount?> <span class="rouble">a</span></span>
        </div>

        <div class="info_field_3">
            <span style="float:left">Итого со скидкой</span>
            <span style="float:right; color:orange;"><?=$summ_price?> <span class="rouble">a</span></span>
        </div>
        <div class="info_field_4" style="display:none;">
            <span style="float:left">Сумма заказа</span>
            <span style="float:right; color:#fc8533;"><?=$summ_price?> <span class="rouble">a</span></span>
        </div>
        <br><br>
        <a class="button button_one" href="/basket/order" style="text-decoration:none;"><span>ОФОРМИТЬ СО СКИДКОЙ</span></a>
        <a class="button button_2" href="/basket/order" style="text-decoration:none;"><span style="padding:20px 35px;">ОФОРМИТЬ ЗАКАЗ</span></a>
        <div class="free_delivery">
            <span class="free_del_remain" style="position:absolute;color:grey;bottom:150px;width:240px;">До бесплатной доставки осталось:</span>
            <span class="price_for_del" style="position:absolute;color:#ea5738;bottom:100px;font-size:27px;left:33%;"><?=(5000-$summ_price)?> <span class="rouble">a</span></span><br>
            <span class="we_send_u" style="position:absolute;color:grey;display:none;bottom:160px;">Мы доставим вам :</span><br><br>
            <span class="free_del" style="position:absolute;color:purple;font-weight:bold;display:none;bottom:130px;">БЕСПЛАТНО</span><br><br>
            <span class="super_message" style="position:absolute; color:orange; font-weight:bold;display:none;bottom:100px;">СУПЕР!</span>
            <div class="line_1">
                <img src="/bitrix/images/car_delivery.png" style="position:absolute;top:1px;right:0;">
            </div>
            <div class="line_2">
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    if ($(".free_del_remain").css("display")=="none") {
        $(".line_1").css("top", "-30px");
    }   
});
</script>