<script>
<?if ($summ_discount==0) {?>
$(".info_basket_content .info_field:nth-child(1), .info_basket_content .info_field:nth-child(2), .info_basket_content .info_field:nth-child(3)").css("display", "none");
$(".info_basket_content .info_field:last-child").css("display", "block");
$(".button_1").css("display", "none");
$(".button_2").css("display", "inline");
<? } ?>
<?if ($summ_price<5000) {?>
summ_price=<?=$summ_price?>;
$(".line_1").css("width", ((summ_price/5000)*100)+"%");
<?} else {?>
$(".line_1").css("width", "100%");
<?}?>
line1_width=$(".line_1").width();
if (line1_width<25) {
    $(".line_1 img").css("left", "0");
}
line2_width=100-line1_width;
$(".line_2").css("width", line2_width+"%");
$(".sk-mybar li:last-child").mouseover(function(){
   $(".info_basket").css("display", "block"); 
});
$(".info_basket").mouseover(function(){
   $(".info_basket").css("display", "block"); 
});
$(".sk-mybar li:last-child").mouseout(function(){
   $(".info_basket").css("display", "none"); 
});
$(".info_basket").mouseout(function(){
   $(".info_basket").css("display", "none"); 
});
if ($(".line_1").width()=="100") {
    $(".free_del_remain, .price_for_del").css("display", "none");
    $(".we_send_u, .free_del").css("display", "inline");
}
</script>