<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?>
<style>
.info_basket {
   position:relative;
    -webkit-box-shadow: 0 0 4px 4px rgba(0,0,0,0.1);
    box-shadow: 0 0 4px 4px rgba(0,0,0,0.1);
    z-index:1002;
    width:275px;
    display:none;
}
.info_basket_arrow {
 /* margin-top: -9px; */
  width: 15px;
  height:15px;
  transform: rotate(45deg);
  background-color: #fff;
  margin-top: -7px;
  position: absolute;
  right: 20px;
  -webkit-box-shadow: 0 0 4px 4px rgba(0,0,0,0.1);
  box-shadow: 0 0 4px 4px rgba(0,0,0,0.1);
}
.info_basket_content {
  width: 225px;
  padding:24px;
  position:relative;
  background-color: #fff;
}
.info_field {
    border-bottom:1px solid grey;
    line-height:3px;
    min-height:8px;
    padding-bottom:10px;
}
.button {
    color:white;
    padding:20px 35px;
    background-color:orange;
    font-weight:bold;
}
.free_delivery {
    margin-top:35px;
}
.line_1 {
    display:inline-block;
    border-bottom:1px solid purple;
    padding-top:35px;
    width:100%;
    position:relative;
}
.line_2 {
    display:inline-block;
    border-bottom:1px solid #c5c5c5;
    padding-top:35px;
   /* width:50%;*/
    margin-left:-4px;
}
.my_basket {
    padding-bottom:35px;
}
</style>
<!--<span class="my_basket">Моя корзина</span> <br><br><br>
<div class="info_basket">
<div class="info_basket_arrow"></div>
    <div class="info_basket_content">
    <div class="info_field">
    <span style="float:left">Сумма без скидки</span>
    <span style="float:right; color:purple;">1234 Р</span>
    </div>
    <br>
    <div class="info_field">
    <span style="float:left">Вы экономите</span>
    <span style="float:right; color:purple;">1234 Р</span>
    </div>
    <br>
    <div class="info_field">
    <span style="float:left">Итого со скидкой</span>
    <span style="float:right; color:orange;">1234 Р</span>
    </div>
    <div class="info_field" style="display:none;">
    <span style="float:left">Сумма заказа</span>
    <span style="float:right; color:orange;">1234 Р</span>
    </div>
    <br><br><br>
    <span class="button">ОФОРМИТЬ СО СКИДКОЙ</span>
    <span class="button" style="display:none;padding:20px 55px;">ОФОРМИТЬ ЗАКАЗ</span>
    <div class="free_delivery">
    <span class="free_del_remain" style="position:absolute;color:grey;bottom:155px;">До бесплатной доставки осталось:</span><br><br>
    <span class="price_for_del" style="position:absolute;color:purple;font-weight:bold;bottom:125px;">500 Р</span><br><br>
    <span class="we_send_u" style="position:absolute;color:grey;display:none;bottom:155px;">Мы доставим вам :</span><br><br>
    <span class="free_del" style="position:absolute;color:purple;font-weight:bold;display:none;bottom:125px;">БЕСПЛАТНО</span><br><br>
    <span class="super_message" style="position:absolute; color:orange; font-weight:bold;display:none;bottom:95px;">СУПЕР!</span>
    <div class="line_1">
    <img src="/bitrix/images/car_delivery.png" style="position:absolute;top:1px;right:0;">
    </div>
    <div class="line_2">
    </div>
    </div>
    </div>
</div>
<script>
line1_width=$(".line_1").width();
line2_width=100-line1_width;
$(".line_2").css("width", line2_width+"%");
$(".my_basket").mouseover(function(){
   $(".info_basket").css("display", "block"); 
});
$(".info_basket").mouseover(function(){
   $(".info_basket").css("display", "block"); 
});
$(".my_basket").mouseout(function(){
   $(".info_basket").css("display", "none"); 
});
$(".info_basket").mouseout(function(){
   $(".info_basket").css("display", "none"); 
});
if ($(".line_1").width()=="100") {
    $(".free_del_remain, .price_for_del").css("display", "none");
    $(".we_send_u, .free_del").css("display", "inline");
}
</script>  --> <?
$dbBasketItems = CSaleBasket::GetList(
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
        array()
        );
while($BasketItems=$dbBasketItems->Fetch())    {
arshow($BasketItems);  
} ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>