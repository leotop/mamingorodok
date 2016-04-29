function ChangeGenerate(val)
{
	if(val)
		document.getElementById("sof_choose_login").style.display='none';
	else
		document.getElementById("sof_choose_login").style.display='block';

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}

var error;
$(document).ready(function(){	
	//$("#loadhide").hide();	
	$(".prof").change(function(){
		if(this.checked)
			$(this).parent().parent().parent().addClass("select");
		else
			$(this).parent().parent().parent().removeClass("select");
	});
			
	$(".filter").keyup(function(){
		var id = $(this).attr("id");
		var idm = id.split("_");
		if(idm[1]){
			id = parseInt(idm[1]);
			if(id==3){
				var str = $(this).val();
				var tstr = "";
				tstr = str;
				//for(var i = 0; i < str.length; i++) {
					if(!/^[0-9]+?$/i.test(str))
						tstr = "";
				//}
				$(this).val(tstr);
			}
		}
	});
			
	$(".filter").focusout(function(){
		var id = $(this).attr("id");
		var idm = id.split("_");
		//console.log(idm);
		if(idm[1]){
			id = parseInt(idm[1]);
			var str = $(this).val();
			//console.log(id);
			var res = findError(id, str);
			if(res){
				if(id!=6){
					$(this).parent().parent().parent().addClass("jqTransformInputError");
				}
					$(".error_"+id).text(res);
				
				}
			else{
				$(".error_"+id).text("");
				$(this).parent().parent().parent().removeClass("jqTransformInputError");
				}
		}
	});
	
	$(".filter").focusin(function(){
		var id = $(this).attr("id");
		var idm = id.split("_");
		if(idm[1]){
				id = parseInt(idm[1]);
				$(".error_"+id).text("");
					if($(this).parent().parent().parent().hasClass("jqTransformInputError"))
						$(this).parent().parent().parent().removeClass("jqTransformInputError");
			}
		});
		
		$(".btnSend").click(function(){
			var ch = $(".prof:checked").attr("id");
			ch = ch.split("_");
			if(ch[3]){
				ch = parseInt(ch[3]);
				if(ch==0){
				var el = $(".filter");
				var error = false; 
				$.each(el,function(){
					var id = $(this).attr("id");
					var idm = id.split("_");
					if(idm[1]){
						id = parseInt(idm[1]);
						var str = $(this).val();
						var res = findError(id, str);
						if(res){
							$(".error_"+id).text(res);
							error = true;
						}
						else
							$(".error_"+id).text("");
					}
				});
				if(!error) return true;
				else return false;
				}
			}
			return true;
		});
		
		$(".reloadpost").change(function(){
		if(this.checked){
			var pr = $(this).parent().parent();
			var st = pr.find("#dost").val();
			var sum = $("#sum").val();
			if(isNaN(st)) st = 0;
			st = parseInt(st);
			sum = parseInt(sum);
			sum = sum+st;
			$(".dostav").text(st);
			$(".itogo").text(sum);
		}
		
	  
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
						$(".certificate").text(elem.length+" сертификата на сумму "+ data.sale+ " руб.");
					}		
			  }
			});
		$("#cerfBasket").hide();
		return false;
	  });
  
	});
	
	$("#BreadCrumb a").click(function(){
	var cur = $(this).attr("href");
	cur = parseInt(cur,10);
	if(cur && cur>0){
	document.order_form.CurrentStep.value=cur;
	document.order_form.BACK.value='Y'; 
	document.order_form.submit();
	return false;
	}
	
  });
  
  $(".backstep").click(function(){
	var cur = $(this).attr("href");
	document.order_form.CurrentStep.value=cur;
	document.order_form.BACK.value='Y'; 
	document.order_form.submit();
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
			var location = $("#location").val();
			var weight = $("#weight").val();
			var delevery = $("#delevery").val();
			var lang = $("#lang").val();
			//alert(arr);
			$.ajax({
					type: "POST",
					url: '/ajaxBasket.php',
					data: "do=certificate2&ids="+arr+"&location="+location+"&weight="+weight+"&delevery="+delevery+"&lang="+lang,
					dataType: "json",
					success: function(data) {
						if(data.error==0){
							$(".allPrice").text(data.allValue);
							if(data.delevery.VALUE){
								$(".dostav").text(data.delevery.VALUE);
								var itogo = data.allValueSale+data.delevery.VALUE;
								}
							else{
								$(".dostav").text(0);
								var itogo = data.allValueSale;
							}
							$(".itogo").text(itogo);
							$(".serf").text(data.sale);
							//$(".allPriceSale").text();
							//$(".certificate").text(elem.length+" сертификата на сумму "+ data.sale+ " руб.");
						}		
				  }
				});
			$("#cerfBasket").hide();
			return false;
		  });
});

function findError(id, str){
	switch(id)
	{
	case 1:
	case 2:
		var regexp = /^[A-Za-zА-Яа-я ]+$/i;
		if(str.length==0)
			return "Поле не должно быть пустым";
		if(str.length<3)
			return "Слишком короткое значение";
		if(!(regexp.test(str)))
			 return "Поле может содержать только буквы";
	  break;
	case 3:
		var regexp = /^[0-9 ]+$/i;
		if(str.length==0)
			return "Поле не должно быть пустым";
		if(str.length<5)
			return "Слишком короткое значение";
	  break;
	case 6:
		if(str.length==0)
			return "Поле не должно быть пустым";
		if(str.length<10)
			return "Слишком короткая строка";
	  break;
	default:
	}
	return false;
	
	
}

