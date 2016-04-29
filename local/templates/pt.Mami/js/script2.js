
var show = false;
var showName = "";
var hideName = "";
var timeOut = 1500;
var timeOut2 = 500;
var updateTimeOut = 0;

var ballonHide = false;
var ballonTime = 2000;
var updateTime = 0;
var timeOutST2 = 0;
var nm;
var mayShow;
var timeMay = 500;
	
$(document).ready(function() {

	//показ характеристики
	
	$(".hoHide").mouseover(function(){
		updateTimeOut++;
	});
	$(".hoHide").mouseout(function(){
		setTimeout("hideBlock("+updateTimeOut+")",timeOut);
	});	
	$(".showTime").mouseover(function(){
		if(!show){
		nm = this;
		setTimeout("showBlock("+timeOutST2+")",timeOut2);
		}
		else{
			mayShow = this;
			setTimeout("showMay()",timeMay);
		}
		//showBlock(this,timeOutST2)
		return false;
	});
	$(".showTime").mouseout(function(){
		if(show){
		hideName = showName;
		}
		mayShow = "";
		setTimeout("hideBlock("+updateTimeOut+")",timeOut);
		timeOutST2++;
		return false;
	});	
	
	//показ подсказки
	$(".showClickPosition").click(function(){
		var name = $(this).attr('id');
		var position = $(this).position();
		$("."+name).show().css("left",position.left-28).css("top",position.top+18);	
		return false;
	});
	
	//показ аяксовой инфы о колличестве товара
	$(".filterChange").keypress(function(){
		if($(this).attr("type")=="text"){
			showBallon(this);
		}
	});
	$(".filterChange").change(function(){
		
		if($(this).attr("checked") || $(this).attr("type")=="text"){
			showBallon(this);
		}
		return false;
	});
	
	$(".ballon_float").mouseover(function(){
		//ballonHide = false;
	});
	
	$(".ballon_float").mouseout(function(){
	//	ballonHide = true;
	//	updateTime++;
	//	setTimeout("hideBallon("+updateTime+")",ballonTime);
	});
	
	$(".baloon_close").click(function(){
		$(".ballon_float").hide();
		ballonHide = false;
	});
	
	$(document).click(function(e){
		if ($(e.target).parents().filter('.ballon_float:visible').length != 1) {
			$('.ballon_float').hide();
		}
	});
});


function showBlock(uptimeOut2){
	if(uptimeOut2==timeOutST2){
	var name = $(nm).attr('id');
	if(!show){
				var num = $(".showTime").index(nm);
				var elem = $(".itemAbsl").eq(num);
				elem.css("z-index","99");
				$("."+name).show();
				
				elem.find(".cn").removeClass("deactive");
				elem.find(".content").removeClass("deborder");
				show = true;
				showName = name;
			}
			else
			if(showName!=name){
				var element = $("."+showName);
				element.hide();
				var showNum = $(".showTime").index($("#"+showName));
				var elem = $(".itemAbsl").eq(showNum)
				elem.css("z-index","2");
				elem.find(".cn").addClass("deactive");
				elem.find(".content").addClass("deborder");
				
				var element2 = $("."+name).show();
				var showElNum = $(".showTime").index(nm);
				elem = $(".itemAbsl").eq(showElNum);
				elem.css("z-index","99");
				elem.find(".cn").removeClass("deactive");
				elem.find(".content").removeClass("deborder");
				
				show = true;
				showName = name;
				hideName = "";
			}
	}
}
//Функция скрытия блока характеристики товара
function hideBlock(updateTimeH){
		if(updateTimeH==updateTimeOut){
		if(hideName!=""){
			var elem = $("."+hideName);
			elem.hide();
			var hideEl = $(".showTime").index($("#"+hideName));
				var elem = $(".itemAbsl").eq(hideEl);
				elem.css("z-index","2");
				elem.find(".cn").addClass("deactive");
				elem.find(".content").addClass("deborder");
			showName = "";
			hideName = "";
			show = false;
		}
		}
	}

//Функция отображения аяксовой инфы о колличестве товара
function showBallon(thisElem){
	var cc = Math.floor(Math.random()*1001);
	$(".filter .categoryF-left-filter").find("nobr").text("Показать "+cc+" товаров");
	$(".filter .categoryF-left-filter span span").css("padding","6px 10px 0 20px");
	updateTime++;
			ballonHide = false;
			var position = $(thisElem).parent().position();
			var elemF = $(".filter");
			var posF = elemF.position();
			//$(".ballon_float").css("left",posF.left+elemF.width()-15).css("top",position.top-29).show();
			if($(thisElem).attr("type")=="text")
			$(".ballon_float").css("left", position.left+$(thisElem).parent().width()).css("top",position.top-$(thisElem).parent().height()+17).show();
			else
			$(".ballon_float").css("left", position.left+$(thisElem).parent().width()-5).css("top",position.top-$(thisElem).parent().height()-2).show();
			ballonHide = true;
			//setTimeout("hideBallon("+updateTime+")",ballonTime);
}
//Функция скрытия аяксовой инфы о колличестве товара
function hideBallon(i){
	if(ballonHide && updateTime==i)
		$(".ballon_float").hide();
}

function showMay(){
	if(mayShow!=""){
		if(show){
			setTimeout("showMay()",timeMay);
		}
		else{
			nm = mayShow;
			setTimeout("showBlock("+timeOutST2+")",timeOut2);
			mayShow = "";
		}
	}
	return false;
}