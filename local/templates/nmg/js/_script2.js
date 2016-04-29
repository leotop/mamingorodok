var show = false;
var showName = "";
var hideName = "";
var timeOut = 500;
var timeOut2 = 300;
var updateTimeOut = 0;

var ballonHide = false;
var ballonTime = 2000;
var updateTime = 0;
var timeOutST2 = 0;
var nm;
var mayShow;
var timeMay = 500;
var hoHideAny = false;
	
$(document).ready(function() {    
    
$(function() {
    if (window.PIE) {
        $('.btt-specialoffert, .catalog_list li, .stock-block, .header_bg .action li a.basket span, .pink_d, .select_block_popap, .select_block, .size_select li.first, .your_comment, .sorting_block .show_block b, .sorting_block ul.sorting_list li.active, .banners_block, .left_column1, .contant_table tr td.left_sitebar .left_column, .header_bg .action li a.basket span ').each(function() {
            PIE.attach(this);
        });
    }
}); 
    l_tooltip(".ttp_lnk","tooltip");

	//показ характеристики
	
	$(".hoHide").mouseover(function(){
		updateTimeOut++;
	});
	$(".hoHide").mouseout(function(){
		setTimeout("hideBlock("+updateTimeOut+")",timeOut);
	});	
	
	$(".showTime").mouseover(function(){
		if(!show)
		{
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
	
	$(".podlogka").mouseleave(function(){
		if(show){
			hideName = showName;
		}
		mayShow = "";
		setTimeout("hideBlock("+updateTimeOut+")", timeOut);
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
    $('html').click(function(){
        $('.filter .info').hide();
    })
	
	//показ аяксовой инфы о колличестве товара
	/*$(".filterChange").keypress(function(){
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
	*/
	
	$(".baloon_close").click(function(){
		$(".ballon_float").hide();
		ballonHide = false;
	});
	
	$(document).click(function(e){
		if ($(e.target).parents().filter('.ballon_float:visible').length != 1 && !$(e.target).hasClass("filterChange") && !hoHideAny) {
			$('.ballon_float').hide();
		}
		setTimeout("nnHohideAny()",50);
	});
	
	
	$(".recommend-update").live("click",function(){
		var id = $(this).attr("id");
		if(id.match(/[a-zA-Z]+?_[0-9]+?_[0-9]+?/i)){
			var mas = id.split("_");
			var blockId = mas[2];
			var tovarGetFullId = mas[1];
			var block = $("#block_"+blockId).find(".preview-preview");
			if(block){
				var id = block.attr("id");
				if(id.match(/[a-zA-Z]+?_[0-9]+?_[0-9]+?/i)){
					var mas = id.split("_");
					var tovarGetShortId = mas[1];
					var recListId = $(".recomendList_"+blockId).attr("id");
					recListId = recListId.split("_");
					recListId = recListId[1];
					if(tovarGetFullId>0 && recListId>0 && tovarGetShortId>0){
						$.ajax({
						   type: "POST",
						   url: "/recomendList.php",
						   //dataType: "json",
						   data: "do=getChangeElement&tovarGetFullId="+tovarGetFullId+"&tovarGetShortId="+tovarGetShortId+"&recListId="+recListId,
						   success: function(date){
								date = JSON.parse(date);
								if(date.error=="0"){
									var plusMinus = htmlspecialchars_decode(date.plusMinus);
									$(".recommend-plus-minus").html(plusMinus);
									var fullBlock = htmlspecialchars_decode(date.fullBlock);
									block.html(fullBlock);
									block.attr("id","tovar_"+tovarGetFullId+"_"+blockId);
									var elem = $("#block_"+blockId).find(".item_item_"+tovarGetFullId+"_"+blockId);
									var shortBlock = htmlspecialchars_decode(date.shortBlock);
									elem.html(shortBlock);
									elem.removeClass("item_item_"+tovarGetFullId+"_"+blockId);
									elem.addClass("item_item_"+tovarGetShortId+"_"+blockId);
									elem.find(".recommend-update").attr("id","tovar_"+tovarGetShortId+"_"+blockId)
								}
						   },
						   error: function(xhr,status){
								alert(status);
						   }
						 });
					}
				}
			}
		}
		return false;
	});
});


function showBlock(uptimeOut2){
	if(uptimeOut2==timeOutST2){
	var name = $(nm).attr('id');
	if(!show)
	{
			$(nm).hide();
				var num = $(".showTime").index(nm);
				var elem = $(".itemAbsl").eq(num);
				elem.css("z-index","99");
				$("."+name).show();
				
				elem.find(".cn").removeClass("deactive");
				elem.find(".content").removeClass("deborder");
				show = true;
				showName = name;
				elem.find(".name_upd_to_to").css("height","100%");
				elem.find(".headname").css("height","100%");
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
				elem.find(".name_upd_to_to").css("height","29px");
				elem.find(".headname").css("height","35px");
				
				var element2 = $("."+name).show();
				var showElNum = $(".showTime").index(nm);
				elem = $(".itemAbsl").eq(showElNum);
				elem.css("z-index","99");
				elem.find(".cn").removeClass("deactive");
				elem.find(".content").removeClass("deborder");
				elem.find(".name_upd_to_to").css("height","100%");
				elem.find(".headname").css("height","100%");
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
			$("#"+hideName).show();
			elem.hide();
			var hideEl = $(".showTime").index($("#"+hideName));
				var elem = $(".itemAbsl").eq(hideEl);
				elem.css("z-index","2");
				elem.find(".cn").addClass("deactive");
				elem.find(".content").addClass("deborder");
				elem.find(".name_upd_to_to").css("height","29px");
				elem.find(".headname").css("height","35px");
				
			showName = "";
			hideName = "";
			show = false;
		}
		}
	}

	
function showBallonFast(thisElem, cc){
	 if (!cc > 0) cc=0;
    
    $(".filter .categoryF-left-filter").find("nobr").text("Показать "+cc+" товаров");
	$(".filter .categoryF-left-filter span span").css("padding","6px 10px 0 20px");
	updateTime++;
	ballonHide = false;
	var position = $(thisElem).parent().position();   
	var elemF = $(".filter");      
	var posF = elemF.position();
	$(".ballon_float").css("left",posF.left+elemF.width()-15).css("top",position.top-29).show();
	 $(".ballon_float .ballon_text span").html(cc);
}
//Функция отображения аяксовой инфы о колличестве товара
function showBallon(thisElem, cc){
	//var cc = Math.floor(Math.random()*1001);
    if (!cc > 0) cc=0;

    $(".filter .categoryF-left-filter").find("nobr").text("Показать "+cc+" товаров");
	$(".filter .categoryF-left-filter span span").css("padding","6px 10px 0 20px");
	updateTime++;
			ballonHide = false;
			var position = $(thisElem).parent().position();   
			var elemF = $(".filter");      
			var posF = elemF.position();
			$(".ballon_float").css("left",posF.left+elemF.width()-15).css("top",position.top-29).show();
			
			if($(thisElem).attr("type")=="text")
			{
                $(".ballon_float .ballon_text span").html(cc);
                $(".ballon_float").css("left", position.left+$(thisElem).parent().width()).css("top",position.top-$(thisElem).parent().height()+17).show();

            }
			else
            {

					var w = $(thisElem).parent().width()-5;
					var h = $(thisElem).parent().height()-2;
					if($(thisElem).hasClass("producer")){
						position = $(thisElem).parent().parent().position();
						w = $(thisElem).parent().parent().width()-10;
						h = $(thisElem).parent().parent().height()+2;
					}
			      $(".ballon_float .ballon_text span").html(cc);
               $(".ballon_float").css("left", position.left+w).css("top",position.top-h).show();
            }
            ballonHide = true;
			//setTimeout("hideBallon("+updateTime+")",ballonTime);
}
//Функция скрытия аяксовой инфы о колличестве товара
function hideBallon(i){
	if(ballonHide && updateTime==i)
		$(".ballon_float").hide();
}

function nnHohideAny(){
	hoHideAny = false;
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

    function htmlspecialchars_decode(str) {  
        
          
        str = str.toString();  
          
        // Always encode  
        str = str.replace(/&lt;/gi, '<');  
        str = str.replace(/&gt;/gi, '>');  
		str = str.replace(/&amp;/gi, '&');
		str = str.replace(/&quot;/gi, '"');
          
        return str;  
    }