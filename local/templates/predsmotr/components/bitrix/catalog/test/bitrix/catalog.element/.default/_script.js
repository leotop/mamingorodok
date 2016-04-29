$(function() {
	$('.select_block_popap').jScrollPane({showArrows: true});
});

$(document).ready(function() {
	currentDeliveryPrice = getDeliveryPrice($("#cartPrice").val(), parseFloat(toNum($("h5.cost").html())));
	if(parseInt(currentDeliveryPrice)>0)
		strDeliveryPrice = 'Доставка '+currentDeliveryPrice;
	else strDeliveryPrice = currentDeliveryPrice;
	
	$("#deliveryPrice").html(strDeliveryPrice);
	
	jQuery('#mycarousel').jcarousel({
		vertical: true,
		scroll: 1
	});
    // скрываем списоки размеров или цветов, если они пустые
    var colors_count = $('.ColorList .item').size();
    var sizes_count = $('.SizeList .item').size();
    
    if (colors_count == 1) $('.ColorList input').click();
    if (sizes_count < 2)
	{
        $('.SizeList').hide();
		$('.SizeList input').eq(0).click();
	}
	
	///////////////////////////////////////////////////////
		// Отмечаем самый минимальный по цене доступный товар //
		////////////////////////////////////////////////////////
		 var min_price = parseInt($('#linked-items .price').html());
		 var min_price_active = 0;
		// var min_price_product_id = 0;
		// var min_price_product_id_active = 0;
		
		$('#linked-items .item').each(function(){
			var current_price = parseInt($(this).find('.price').html());
			var current_product_id = $(this).find('.element-id').html();
			
			//наименьшая цена
			if (current_price < min_price)
			{
				min_price = current_price;
				min_price_product_id = current_product_id;
			}
			
			//наименьшая цена среди активных
			if (parseInt($(this).find('.quantity').html()) > 0)
			{
				//current_price = parseInt($(this).find('.price').html())
				if ((current_price < min_price_active && min_price_active > 0) || min_price_active == 0)
				{
					min_price_active = current_price;
					min_price_product_id_active = current_product_id;
				}
			}
			
		});
		
		//console.log(min_price_active);
		if(min_price_active>0)
			$("#Basketplash .Price").html("<span>&nbsp;</span> "+CurrencyFormat(min_price_active)+" <span>р</span>");
            
		var colors_count = $('.ColorList .item').size();
		var sizes_count = $('.SizeList .item').size();
		
		//console.log(colors_count);
		//console.log(sizes_count);
		if(colors_count>0)
			$("#Basketplash #colorVal").val("");
		
		if(sizes_count>2)
			$("#Basketplash #sizeVal").val("");
		// отмечем радибаттоны цвета и размера
		// $('#linked-items .item').each(function(){
			// if ($(this).find('.element-id').html() == min_price_product_id_active)
			// {
				// var color_code = $(this).find('.color-code').html();
				// var size = $(this).find('.size').html();
				// $('#color_'+color_code).click();
				// $('#size_'+size).click();
			// }
		// });
	
	if(window.location.hash == "#showOffers")
	{
		if(($(".size_select")).length<=0 && ($(".select_block_bg:visible")).length<=0)
			orderItem();
		else if(($(".select_block_bg:visible")).length>0) $(".select_block_bg").click();
	}
});