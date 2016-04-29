$(document).ready(function() {
	//обновление колличества
  $(".QUANTITY").live("blur",function(){
	var count = parseInt($(this).val(),10);
	var id = parseInt($(this).attr("id"),10);
	if(count>0){
		$.ajax({
			type: "POST",
			url: '/ajaxBasket.php',
			data: "do=updateQuantity&id="+id+"&count="+count,
			dataType: "json",
			success: function(data) {
				//alert(data);
				if(data.error==0){
					$(".priceid"+id).text(data.value);
					$(".allPrice").text(data.allValue);
					$(".allPriceSale").text(data.allValueSale);
					if($(this).hasClass("hasError"))
						$(this).removeClass("hasError");
				}
				else{
					if(!$(this).hasClass("hasError"))
						$(this).addClass("hasError");
				}
				
		  }
		});
	}
	else{
		if(!$(this).hasClass("hasError"))
			$(this).addClass("hasError");
	}
  });
  
  $(".sale_basket_basket").delegate(".delete","click",function(){
	var id = parseInt($(this).attr("href"),10);
	if(id>0){
		$.ajax({
			type: "POST",
			url: '/ajaxBasket.php',
			data: "do=deleteElement&id="+id,
			dataType: "json",
			success: function(data) {
				if(data.error==0){
					$(".allPrice").text(data.allValue);
					$(".allPriceSale").text(data.allValueSale);
					$(".line"+id).remove();
					$("#allPriceFull").val(data.allValue);
					$(".firstLine").after("<tr class='del"+id+"'><td colspan='8' class='infoline'>Товар "+data.name+" был удален. <a class='grey repearElement' href="+id+">Отменить удаление</a></td></tr>");
					if(data.SALE>0){
						if(data.SERTIFICATE==1)
							$(".allSum .certificate").html(data.SERTIFICATE+" сертификат на сумму "+data.SALE+" руб.");
						else if( 1 < data.SERTIFICATE < 5)
							$(".allSum .certificate").html(data.SERTIFICATE+" сертификата на сумму "+data.SALE+" руб.");
						else
							$(".allSum .certificate").html(data.SERTIFICATE+" сертификатов на сумму "+data.SALE+" руб.");
							
						$(".addCert span span").text("Выбрано "+data.SALE+" руб.");	
						$("#allCert").val(data.SALE);
						}
					else{
						$(".allSum .certificate").html("Сертификаты не выбраны.");
						 $(".certItem_checkbox").each(function(){
							$(this).attr('checked', false); 
							$(".addCert span span").text("Выбрать");
							$("#allCert").val(0);
						 });
					}
					
				}		
		  }
		});
	}
	return false;
  });
  
  $(".repearElement").live('click',function(){
	var id = parseInt($(this).attr("href"),10);
	if(id>0){
		$.ajax({
			type: "POST",
			ajax: false,
			url: '/ajaxBasket.php',
			data: "do=repearElement&id="+id,
			//dataType: "json",
			success: function(data) {
				data = $.trim(data);
				data = $.parseJSON(data);
				if(data.error==0){
					$(".allPrice").text(data.allValue);
					$(".allPriceSale").text(data.allValueSale);
					$(".sale_basket_basket tr:last").after(htmlspecialchars_decode(data.html));
					$(".del"+id).remove();
					$("#allPriceFull").val(data.allValue);
					
				}		
		  }
		});
	}
	return false;
  });
  
  $(".certItem_checkbox").change(function(){
		var allCert = parseInt($("#allCert").val(),10);
		var pr = parseInt($(this).attr("id"),10);
		var allPrice = parseInt($("#allPriceFull").val(),10);
		if(this.checked)
			allCert += pr;
		else
			allCert -= pr;
		if(allPrice<allCert){
			$(this).attr("checked",false);
			return false;
			}
		if(allCert>0)
			$text = "Выбрано "+allCert+" руб." ;
		else
			$text = "Выбрать";
		$(".addCert span span").text($text);
		$("#allCert").val(allCert);
  });
  
 
  
  $(".addCert").click(function(){
	var elem = $(".certItem_checkbox:checked");
	var i=0;
	var arr = new Array();
	for (i=0;i<=elem.length;i++)
	{
		arr[i] = elem.eq(i).val();
	} 
	arr = arr.join(";");
	//alert(arr);
	$.ajax({
			type: "POST",
			url: '/ajaxBasket.php',
			data: "do=certificate&ids="+arr,
			dataType: "json",
			success: function(data) {
				if(data.error==0){
					$(".allPrice").text(data.allValue);
					$(".allPriceSale").text(data.allValueSale);
					if(elem.length>0)
					$(".certificate").text(elem.length+" сертификата на сумму "+ data.sale+ " руб.");
					else
					$(".certificate").text("Сертификаты не выбраны.");
				}		
		  }
		});
	$("#cerfBasket").hide();
	return false;
  });
});