// выравниваем картинку по центру
function SetPreviewPictureToCenter()
{
    $('#midi-picture .zoomPad').css('position', 'absolute');
    $('#midi-picture .zoomPad').css('left', '-5000px');
    setTimeout(function(){
        var layer_width = $('#midi-picture').width();
        var img_width = $('#midi-picture img').width();
        if (layer_width - img_width > 0)
            $('#midi-picture .zoomPad').css('margin-left', parseInt((layer_width - img_width) / 2)+'px');
        else
            $('#midi-picture .zoomPad').css('margin-left', '0px');                            
            
        $('#midi-picture .zoomPad').css('position', 'relative');
        $('#midi-picture .zoomPad').css('left', '0');
    },300)
}

// вствляем пробелы между разрядами
function CurrencyFormat(str)
{
    str = str+'';
    var result = str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');                    
    return result;
}

function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}

function explode( delimiter, string ) {
    var emptyArray = { 0: '' };
    if ( arguments.length != 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
    if ( delimiter === '' || delimiter === false || delimiter === null ){
        return false;
    }
    if ( typeof delimiter == 'function' || typeof delimiter == 'object' || typeof string == 'function' || typeof string == 'object' ){
        return emptyArray;
    }
    if ( delimiter === true ) {
        delimiter = '1';
    }
 
    return string.toString().split ( delimiter.toString() );
}

ButtonAdd = function(){

    var value = $(this).attr('value');
    var onclick='';

    for (var i = 0; i < this.attributes.length; i++) {
        if (this.attributes[i].nodeName=='onclick'){
            onclick = ' onclick="'+this.attributes[i].nodeValue+'"';
            //console.log(onclick )         
        }
    }     
    //console.log('<button id="'+ this.id +'" name="'+ this.name +'" onclick="'+ onclick +'" type="'+ this.type +'" class="'+ this.className +'" value="'+ value +'"><span class="png"><span class="png">'+ value +'</span></span>')
	var diz = "";
	if($(this).attr("disabled"))	{
		 diz = ' disabled="disabled"';
		 }
		 
    $(this).replaceWith('<button id="'+ this.id +'" name="'+ this.name +'"'+ onclick +' type="'+ this.type +'" class="'+ this.className +'" value="'+ value +'"'+diz+'><span class="png"><span class="png"><nobr>'+ value +'</nobr></span></span></button>');
}; 

CaruselPictureFancy = function () {
	if($('#FPictureBlock .DPictureListCarousel').length>0)
		$('#FPictureBlock .DPictureListCarousel').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 5});
	if($('#FPictureBlock .DPictureListCarousel2').length>0)
	$('#FPictureBlock .DPictureListCarousel2').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 10});
	$("#FPictureBlock .DPictureList a, .DPictureLnk .fancybox-detail").fancybox({'type': 'ajax','autoScale':true, 'showNavArrows': false, 'onComplete':function(){CaruselPictureFancy();$.fancybox.resize();$.fancybox.resize();} });
    
}

function keyy(){
	if($(".textcom").val().length>0){
			$(".disable").removeAttr("disabled");
		}
		else{
			$(".disable").attr("disabled","disabled");
		}
}

$(function() {
    $("form.jqtransform").jqTransform();
    $('.jqtransform-cover form:not(.no-transform)').jqTransform();
});

var clkBtn = "";	
var loadRefreashImage = true;
var showSubmenu = false;
var noSubmenuHide = false;
var nohideshowInfo = false;
var shownowshowInfo = false;
$(document).ready(function() {
    
	$(".showInfo").mouseover(function(){
		var id = "#"+$(this).attr("id")+"_block";
		if( shownowshowInfo == false )
			$(id).show();		
	});
	
	$(".showMoreElement").click(function(){
		var whatDo = $(this).attr("href");
		var page_max = parseInt($(this).attr("page_max"));
		var page_now = parseInt($(this).attr("page_now"));
		var count_page = $(this).attr("count_page");
		var element_id = $(this).attr("element_id");
		var addInfo  = $(this).parent().parent().find(".addInfo");
		var hide = $(this).parent();
		$.post("/moreUserElement.php",{"whatDo": whatDo, "page_max": page_max, "page_now": page_now, "count_page": count_page, "element_id": element_id},function(data){
			if(whatDo.indexOf("All")!=-1){
				$(addInfo).html(data);
				hide.hide();
			}
			else{
				$(addInfo).append(data);
				page_now++;
				if(page_now==page_max){
					hide.hide();
				}
			}
		});
		return false;
	});
	
	$(".blogMenu .newWrite").click(function(){
		var href = $(this).attr("href");
		if(href=="#showMsg"){
			$(".sliddd").show();
			setTimeout("no_sliddd()",1500);
			return false;
			}
	});
	
	$("#BlogLeft .text2 table").each(function(){
		var border =$(this).prop("border");
		border = parseInt(border,10);
		if(border>0)
			if(!$(this).hasClass("showBorder"))
				$(this).addClass("showBorder");
	});
	
	$(".showInfo").mouseout(function(){
		var id = "#"+$(this).attr("id")+"_block";
		if( nohideshowInfo == false )
			$(id).hide();		
	});
	
	
	$(".FormReviews input").click(function(){
		$(".FormReviews").submit();
	});
	
	$("#haract .choose a").click(function() {
		
		setTimeout("doeeeeSizeMlya()",500);
		
	});
	
	var nohide = $('#nohide').val();
    var qu_count = $('#qu_count').html();
	//console.log(qu_count);
    if(qu_count <= 0 && nohide!=1) {
        //$(".ToBasket").addClass("ToBasket-none");
        $(".ToBasket").removeClass("ToBasket");
        $(".ToBasket-none").attr("OnCLick","return false;")
        $(".OldPrice").addClass("hide");
        $(".Price").addClass("hide");
		$(".Quantity").addClass("hide");
    }
    $("#Quantity_val").keyup(function() {
        var prod_id = $("#sel_colorsize").html();
        var qu_val = $(this).val();
        if(qu_val == '')
            return false;
            
        $('.ToBasket').attr('href', '/add-to-basket.php?action=ADD2BASKET&id='+prod_id+'&quantity='+qu_val);
    });
	
	$(".nothanks").click(function(){
		var id = $(this).attr("href");
		var el = $(this).parent();
		$.post("/certificate.php","do=noCerf&id="+id,function(data){
			$(el).html("<span class='nofanksspan'>Вы отказались<span>");
		})
		return false;
	});
	
	
	$(".sliderMenu .slide").click(function(){
		
		var now = $("#LeftMenu").find(".showSubMenu");
		var el = $(this).parent().find("#submenu");
		if(!el.hasClass("showSubMenu"))
			if(now){
				now.removeClass("showSubMenu").hide('fast');
			}
		
		
		//console.log(now);
		//console.log(el);
		if(el.hasClass("showSubMenu")){
			el.removeClass("showSubMenu").hide('fast');
		}
		else{
			el.addClass("showSubMenu").show('fast');
		}
		
		
		return false;
	});
	
	$(".map-level-1 a").click(function(){
		
		var now = $(".map-columns").find(".showSubMenu");
		var el = $(this).parent().find(".map-level-2");
		if(!el.hasClass("showSubMenu"))
			if(now){
				now.removeClass("showSubMenu").hide('fast');
			}
		
		
		//console.log(now);
		//console.log(el);
		if(el.hasClass("showSubMenu")){
			el.removeClass("showSubMenu").hide('fast');
		}
		else{
			el.addClass("showSubMenu").show('fast');
		}
		
		
		return false;
	});
	
	
	
	$(".addReportProfile").click(function(){
		if(clkBtn==""){
		ShowWindows("#addReport");
		var url = $(this).attr("id");
		clkBtn = $(this);
		$.get(url, function(data) {
				$("#addReport .value").html(data);
				//.each(ButtonAdd);
				var value = $("#send").attr('value');
				var diz = "";
				if($("#send").attr("disabled"))	{
					 diz = ' disabled="disabled"';
					 }
				var onclick='';
				var el = $("#send");
				$("#send").replaceWith('<button id="'+ $("#send").attr("id") +'" name="'+  $("#send").attr("name") +'"'+ onclick +' type="'+  $("#send").attr("type") +'" class="'+  $("#send").attr("class") +'" value="'+  $("#send").attr("value") +'"'+diz+'><span class="png"><span class="png"><nobr>'+  $("#send").attr("value") +'</nobr></span></span></button>');
			});
		}
		return false;
	});
	
	$("#addReport .exitpUp").live("click",function(){
		$("#addReport .value").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
		clkBtn ="";
		
	});
	
	
		// перезагружаем страницу при закрытии окна "рекомендовать другу"
		/*if($(this).parent().parent().attr('id') == 'FriendsRecomend')
		{
			var url = $('#current-url').html();
			
			location.href = url;
		
		}*/
	
	
	$("#addReport #send").live("click",function(){
		var url = $("#addReport #REPLIER").attr("action");
		var post = "";
		$("#addReport #REPLIER input").each(function(){
			if($(this).attr("type")=="hidden"){
				post = post +'&'+$(this).attr("name")+'='+$(this).val();
			}
		});
		post = "REVIEW_TEXT="+$("#addReport #REVIEW_TEXT").val() + post+"&AJAX=y";
		$("#addReport .value").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
		$.post(url,post,function(){
			$("#addReport .value").html("Отзыв успешно добавлен.");
			if(clkBtn!=""){
				var el = clkBtn.parent();
				clkBtn.remove;
				clkBtn ="";
				el.html("<span class='grey'>Вы уже добавили отзыв</span>");
			}
		});
		
		return false;
	});
	
	$(".preview").click(function(){
		$(this).append("<input type='hidden' value='Y' name='preview'>");
	});

	$(".getCallForm").click(function(){
		$.get("/callfree.php",function(data){
			$("#call_popup .data").html(data);
			$("#callfreeform").jqTransform();
		});
	});
	
	$(".certificate-val .check").change(function(){
		reCheck();
	});
	
	$(".certificate-val .number").keypress(function(){
		setTimeout("reCheck();",200);
	});
	
	$(".certificate-my .chesks").change(function(){
		reCheck2();
	});
	
	$(".certificate-my .number").keypress(function(){
		setTimeout("reCheck2();",200);
	});
	
	$("#call_popup .exitpUp").click(function(){
		$("#call_popup .data").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
	});
	
	$("#callfree").live("click",function(){
		
		var post = "";
		$("#callfreeform input").each(function(){
			if(post==""){
				post = post+$(this).attr("name")+"="+$(this).val();
			}
			else{
				post = post+"&"+$(this).attr("name")+"="+$(this).val();
			}
		});
		$("#call_popup .data").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
		$.post("/callfree.php",post,function(data){
			$("#call_popup .data").html(data);
			$("#callfreeform").jqTransform();
		});
		return false;
	});
	
	$("#FriendsRecomend .sbm").click(function(){
		var mail = $("#femail").val();
		var user = "";
		$("#FriendsRecomend input:checked").each(function(){
			if($(this).attr("type")=="checkbox"){
					if(user=="")
						user = $(this).val();
					else
						user = user+"||"+$(this).val();
			}
		});
		var prod_id = $("#product-id").html();
		var post="do=addEvents&mail="+mail+"&users="+user+"&product_id="+prod_id;
		$.post("/sendMail.php",post,function(){
			$("#FriendsRecomend .data").html("<br/><h2>Спасибо, Ваши рекомендации отправлены.</h2><br/>");
		});
		return false;
	});
	
	$("#FriendsRecomend .nbm").click(function(){
		var mail = $("#femail").val();
		var user = "";
		$("#FriendsRecomend input:checked").each(function(){
			if($(this).attr("type")=="checkbox"){
					if(user=="")
						user = $(this).val();
					else
						user = user+"||"+$(this).val();
			}
		});
		var prod_id = $("#product-id").html();
		var post="do=addListEvent&mail="+mail+"&users="+user+"&product_id="+prod_id;
		$.post("/sendMail.php",post,function(){
			$("#FriendsRecomend .data").html("<br/><h2>Спасибо, Ваш список отправлен вашим друзьям.</h2><br/>");
		});
		return false;
	});
	
	$(".show_all_all").click(function(){
		var id = $(this).attr("id");
		var id = id.split("_");
		if(id[1]){
			id = id[1];
			if($("#ul"+id).hasClass("showLi")){
				if($.browser.msie)
					$(".noli","#ul"+id).hide();
				else
					$(".noli","#ul"+id).hide("slow");
				$("#ul"+id).removeClass("showLi");
				$(this).text("Все");
			}
			else{
				if($.browser.msie)
					$(".noli","#ul"+id).hide();
				else
					$(".noli","#ul"+id).show("slow");
				$("#ul"+id).addClass("showLi");
				$(this).text("Скрыть");
			}
		}
		
		return false;
	});
	
	//Вызов файла по кнопке
	$("#file").click(function(){
		var id = $(this).next().val();
		$("#file"+id).click();
		return false;
	});
	
	$(".comment_tree").click(function(){
        $(this).parents(".comments_head").next(".comments").removeClass("show_line");
        return false;
    });
	
	$(".BlogInfo").delegate(".frending","click",function(){
		var id = $(this).attr("id");
		var  p = /^blog_[0-9]+$/i;
		if(p.test(id)){
			id = id.split("_");
			id = id[1];
			var nobr = $('span span nobr', this);
			$.get('/ajaxBlog.php', {"do": "frending", "blog_id": id}, function(data) {
				if(data!="" && data!="error"){
					if(data=="add"){
						$(nobr).text("Отписаться от блога");
					}
					else if(data=="remove"){
						$(nobr).text("Подписаться на блог");
					}
				}
			});
		}
		return false;
	});
	
	$(".BlogInfo").delegate(".frendingWrite","click",function(){
		var id = $(this).attr("id");
		var  p = /^blog_[0-9]+$/i;
		if(p.test(id)){
			id = id.split("_");
			id = id[1];
			var nobr = $('span span nobr', this);
			$.get('/ajaxBlog.php', {"do": "frendingWrite", "blog_id": id}, function(data) {
				if(data!="" && data!="error"){
					if(data=="add"){
						$(nobr).text("Отписаться от блога");
					}
					else if(data=="remove"){
						$(nobr).text("Подписаться на блог");
					}
				}
			});
		}
		return false;
	});
	
	$(".frending2").click(function(){
		var id = $(this).attr("id");
		var  p = /^blog_[0-9]+$/i;
		if(p.test(id)){
			id = id.split("_");
			id = id[1];
			var nobr = $(this);
			$.get('/ajaxBlog.php', {"do": "frendingOf", "blog_id": id}, function(data) {
				if(data!="" && data!="error"){
					if(data=="add"){
						$(nobr).text("Удалить");
					}
					else if(data=="remove"){
						$(nobr).text("Восстановить");
					}
				}
			});
		}
		return false;
	});
	
	$(".frending3").click(function(){
		var id = $(this).attr("id");
		var  p = /^blog_[0-9]+$/i;
		if(p.test(id)){
			id = id.split("_");
			id = id[1];
			var nobr = $(this);
			$.get('/ajaxBlog.php', {"do": "frending", "blog_id": id}, function(data) {
				if(data!="" && data!="error"){
					if(data=="add"){
						$(nobr).text("Удалить");
					}
					else if(data=="remove"){
						$(nobr).text("Восстановить");
					}
				}
			});
		}
		return false;
	});
    
    $(".comment_list").click(function(){
        $(this).parents(".comments_head").next(".comments").addClass("show_line");
        return false;
    });
	
	$("#mails").change(function(){
		var val = $("#logins").val();
		var  p = /^.*?@.*?$/i;
		if(p.test(val)){
			$("#logins").val($(this).val());
		}
	});
	

	if($(".moreRegInfo").length>0)
		setTimeout('$(".moreRegInfo").hide();',500);
	
	$(".showMoreRegInfoLink").click(function(){
		if(!$(this).hasClass("showProf")){
			$(this).html("Скрыть все поля");
			$(this).addClass("showProf");
			$(".moreRegInfo").show();
		}
		else{
			$(this).html("Показать все поля");
			$(this).removeClass("showProf");
			$(".moreRegInfo").hide();
		}
		return false;
	});
	
	$('input[name$="REGISTER[EMAIL]"]').change(function(){
		$("#login").val($(this).val());
	});
	
	$("#regBtnClick").click(function(){
		var login = $("#login").val();
		if(login.length<7){
			$("#login").val($('input[name$="REGISTER[EMAIL]"]').val());
		}
		return true;
	});
	
	$("#certificatePresent").live("click",function(){
		reCheck2();
		var ids = "";
		var counts = "";
		var sum = 0;
		
		$(".certificate-my .chesks:checked").each(function(){
		var id = $(this).val();	
		var price = $("#cerfh_"+id).html();
		price = parseInt(price,10);
		var count = $("#numberh_"+id).val();
		sum = sum+(price*count);

		if(sum){
			if(ids=="")
				ids = id+"||"+count;
			else
				ids = ids+"##"+id+"||"+count;
		}
		
		});
		
		var user = $("#cur_user").val();
		var this_user = $("#this_user").val();
		if(ids.length>0){
		$("#certificates-selector .dt").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
			post = "do=addForPresent&ids="+ids+"&forUser="+user;
			$.post("/certificate.php",post,function(datad){
				$("#certificates-selector .dt").html('<br/><center><div class="notetext">Сертификаты подарены</div></center><br/>');
				document.location.href="/community/user/"+this_user+"/certificates/presented/";
				//return true;
			});
		}
		else{
			if($("#certificates-selector .datamy").find(".er").length == 0)
				$(this).after("<span class='er'>Выберите сертификаты</span>");
		}
	});
	
	$("#certificateBuyBtnForUser").live("click",function(){
		var ids = "";
		var counts = "";
		var sum = 0;
		$(".certificate-val .check:checked").each(function(){
		var id = $(this).val();	
		var price = $("#cerf_"+id).html();
		price = parseInt(price,10);
		var count = $("#number_"+id).val();
		sum = sum+(price*count);

		if(sum){
			if(ids=="")
				ids = id+"||"+count;
			else
				ids = ids+"##"+id+"||"+count;
		}
		
		});
		var user = $("#cur_user").val();
		if(ids.length>0){
			$("#certificates-selector .dt").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
			post = "do=addFor&ids="+ids+"&forUser="+user;
			$.post("/certificate.php",post,function(datad){
				$("#certificates-selector .dt").html(datad);
				//setTimeout('$("#certificates-selector form").submit();',100);
				//return true;
			});
		}
		else{
			if($("#certificates-selector .data").find(".er").length == 0)
				$(this).after("<span class='er'>Выберите сертификаты</span>");
		}
		
		return false;
	});
	
	$("#certificates-selector .exitpUp").click(function(){
		var el = $("#certificates-selector .datamy");
		if(el.length==0){
			document.location.reload();
		}
	});
	
	$("#certificateBuyBtn").live("click",function(){
		var ids = "";
		var counts = "";
		var sum = 0;
		$(".certificate-val .check:checked").each(function(){
		var id = $(this).val();	
		var price = $("#cerf_"+id).html();
		price = parseInt(price,10);
		var count = $("#number_"+id).val();
		sum = sum+(price*count);
		
		if(sum){
			if(ids=="")
				ids = id+"||"+count;
			else
				ids = ids+"##"+id+"||"+count;
		}
		});
		if(ids.length>0){
		$("#certificateBuy .data").html('<br/><center><img src="/ajax-loader.gif"></center><br/>');
		
			post = "do=addMe&ids="+ids
			$.post("/certificate.php",post,function(datad){
				$("#certificateBuy .data").html(datad);
				//setTimeout('$("#certificateBuy form").submit();',100);
				//return true;
				//$("#certificateBuy .data .inputbutton").bind("click");
			});
		}
		else{
			if($("#certificateBuy").find(".er").length == 0)
				$(this).after("<span class='er'>Выберите сертификаты</span>");
		}
		return false;
	});
		
	$("#certificateBuy .data .inputbutton").live("click",function(){
		$("#certificateBuy").hide();
	});
		
	$(".textcom").keydown(function(){
		//alert($(this).val().length);
		setTimeout("keyy()",10);
	});
	
	//Вызов файла в профиле
	$('input[name="PERSONAL_PHOTO"]').change(function(){
		$("#file_input").val($(this).val());
	});

	//Вызов файла в регистрации
	$('#PERSONAL_PHOTO').bind('change',function(){
		$("#file_input2").val($(this).val());
	});	
	
	//всплывающие окна
	$(".showpUp").live("click",function(){
		var name = $(this).attr("href");
		var win = $(window);
		var winWC = win.width()/2;
		var winHC = win.height()/2+$(document).scrollTop();
		var fSW = $(name).width()/2;
		var FSH = $(name).height()/2;
		winWC = winWC - fSW;
		winHC = winHC - FSH;
		$(name).css("left",winWC);
		$(name).css("top",winHC);
		$(name).show();
		return false;
	});
	
	//показ характеристики
	
	// var show = false;
	// var focus = false;
	// var showid = 0;
	// $(".showTime").focusin(function(){
		// if(!focus){
			// focus=true;
			// if(!show){
			// show = true;
			// var name = $(this).attr('id');
			// $(this).parent().find("."+name).show();
			// }
		// }
		// return false;
	// });
	
	$(".exitpUp").live('click', function(){
		$(this).parent().parent().hide();
		
		// перезагружаем страницу при закрытии окна "рекомендовать другу" если уведомление уже отправилено
		if($(this).parent().parent().attr('id') == 'FriendsRecomend' && !$('#femail').length)
		{
			var url = $('#current-url').html();
			
			location.href = url;
		
		}

	});
	
	//сворачивание фильтра
	$(".categoryF").click(function(){
		
		var depBlock = $('.'+$(this).attr('id'));
		if($(this).hasClass('unselect'))
		{
			depBlock.show();
			$(this).removeClass('unselect');
		}
		else
		{
			depBlock.hide();
			$(this).addClass('unselect');
		}
		return false;
	});
	
	$(".showAll").click(function(){
		var depBlock = $('.'+$(this).attr('id'));
		
		if(depBlock.hasClass("deactive")){
			depBlock.removeClass("deactive");
			if ($(this).attr('id') == 'allProizv')
                $(this).text("Основные производители");
            else
                $(this).text("Основные параметры");
			}
		else{
			depBlock.addClass("deactive");
			if ($(this).attr('id') == 'allProizv')
                $(this).text("Все производители");
            else
                $(this).text("Все параметры");
			}
			
		return false;
	});
	
    // кнопочки
    $('input:submit', this).each(ButtonAdd);
    $('input:reset', this).each(ButtonAdd);
    $('input:button', this).each(ButtonAdd);	
	
	
	$(".enter").live('click.auth', function(){
		$(".auth").show();
		return false;
	});
	
	$(".close").click(function(){
		$(".auth").hide();
	});
	$('#CatMenu').hover(function (){$(this).addClass('hover'); },function (){$(this).removeClass('hover'); });  
	$('#CatMenu li').hover(function (){$(this).addClass('hover'); 
		$(this).find('.sep').height(parseInt($(this).height())+parseInt($(this).css('paddingTop'))+parseInt($(this).css('paddingBottom')));
	} , function () {$(this).removeClass('hover'); });
	
	$(".friendsTabs div").click(function(){
		var elem = $(".friendsTabs").find(".select");
		elem.removeClass("select");
		$("."+elem.attr("id")).hide();
		$(this).addClass("select");
		$("."+$(this).attr("id")).show();
	});
	
	/*сиреневые подсказки*/
	$('.ITipitop').each(function () {
        var trigger = $(this);
        var info = $('.popup');
		var oldtitle = '';
		
		trigger.mouseover(function () {
			tp = $(this).position();
			tp = $(this).offset();
			to = $(this).offset();
			tw = $(this).width();
			ttitle = $(this).attr('title');
			if(ttitle.length > 0) 
			{
				oldtitle = ttitle;
				$(this).attr('title', '');
				info.find('.tipitop_content').html(ttitle);
				ih = info.height();
				iw = info.width();
				//if(ih==0) ih = 84;
				//if(iw==0) iw = 162;					
				info.css({
					top: tp.top+ih-55,
					left: parseInt(tp.left+tw/2-iw/2),
					opacity: 1,
					display: 'block'
				});
			}
		}).mouseout( function(){
			info.css({
				top: -100,
				left: -100,
				opacity: 0,
				display: 'none'
			});
			$(this).attr('title', oldtitle);
			oldtitle = '';
		});

        
    });
	
	if( $("a.fancybox").length>0)
		$("a.fancybox").fancybox();
	
	if( $(".DPictureLnk .fancybox-detail").length>0)	
		$(".DPictureLnk .fancybox-detail").fancybox({'type': 'ajax','autoScale':true, 'showNavArrows': false, 'onComplete':function(){CaruselPictureFancy();$.fancybox.resize();$.fancybox.resize();} });
	
	
	// во всплывающем леере никаких фэнсибоксов!  
	if( $('.no-fancybox').length>0)
		$('.no-fancybox').unbind().click(function(){return false;});
    
//	$('.choose  a').click(function() {return false;});
	
	
	
	$(".DPicture a").fancybox({'type': 'ajax','autoScale':true, 'showNavArrows': false, 'onComplete':CaruselPictureFancy});
	
    // среднее изображение при клике на маленькое (детальная)
    $('#DetailPhotoChoose .DPictureList a').live("click",function(){
        var maxi_img_src = $(this).parent().find('.maxi-picture-src').html();
        var midi_img_src = $(this).parent().find('.midi-picture-src').html();
        var img_id = $(this).parent().find('.picture-id').html();
        var element_id = $('#element-id').html();
        $('#midi-picture img').attr('src', midi_img_src);
		var zoom_now = $('#midi-picture img').attr('alt');
		 largeimageloading = false;
		 largeimageloaded = false;
        $('#midi-picture img').attr('alt', maxi_img_src);  // для зума
        $('#midi-picture a').attr('href', '/inc/picture_view.php?ELEMENT_ID='+element_id+'&IMG_ID='+img_id);
        
		SetPreviewPictureToCenter();
		
		return false;
    });
	
	/*открываем характеристики товара на карточке*/
	$('.DetailSmallCenterColumn .choose span span a').click(function() {
		
		sp = $(this).parent('span').parent('span');
		bl = $(this).parents('.choose');
		if(sp.hasClass('active'))
		{
		}
		else
		{
			bl.children('span').removeClass('active');
			sp.addClass('active');
			if(bl.find('a').index($(this)) > 0)
				$('.DProp tr.DHidePropTr').show();
			else
				$('.DProp tr.DHidePropTr').hide();
		}
		return false;
	});
	
	/*Открываем все отзывы на карточке*/
    if(window.location.hash=='#review') {
        $('#open_review').hide();
        $('#hide_review').show();
        $('#close_review').show();        
    }   
	
	if(window.location.hash!=""){
		var regex = new RegExp('^#review','i');
		if(regex.test(window.location.hash)){
			 $('#open_review').hide();
			$('#hide_review').show();
			$('#close_review').show();
		}
	}
	
	$('#open_review a').click(function(){
		$('#open_review').hide();
		$('#hide_review').show();
		$('#close_review').show();
		return false;
	});
	$('#close_review a').click(function(){
		$('#close_review').hide();
		$('#hide_review').hide();
		$('#open_review').show();
		return false;
	});
	
	$("#sravn").delegate("#clearCompear","click",function(){
		$.get("/clear-compare-list.php");
		sravn = $("#haveSravn").text();
		if(sravn=="1"){
			$("#sravn").html('');
		}
		$(".add-to-compare-list-ajax:checked").each(function(){
			$(this).attr("checked","");
		});
		return false;
	});
	/* раскрываем - прячем рекомендуемые товары*/
    $('.open-list').click(function(){
		var text = "";
        if ($(this).hasClass('opened')){
				$(this).removeClass('opened');
				text = "раскрыть";
			}
        else{
				$(this).addClass('opened');
				text = "скрыть";
			}
		var name = $(this).parent().find(".name").text();
		$(this).html("<span></span>"+name+" ("+text+")");
        $(this).parent().parent().find('.hidden-hidden').toggle();
        return false;
    })
	
	
	/*таблица сравнения*/
	$('.CompareCatalog .choose span span a').click(function() {
		
		sp = $(this).parent('span').parent('span');
		bl = $(this).parents('.choose');
		if(sp.hasClass('active'))
		{
		}
		else
		{
			bl.children('span').removeClass('active');
			sp.addClass('active');
			if(bl.find('a').index($(this)) > 0)
				$('.CompareCatalog tr.HideTr').show();
			else
				$('.CompareCatalog tr.HideTr').hide();
		}
		return false;
	});
	if($('.CompareCatalog tr, .CompareCatalog .remove').length>0)
		$('.CompareCatalog tr, .CompareCatalog .remove').hover(function(){$(this).addClass('hover');}, function(){$(this).removeClass('hover');});

	
	/*карусель на карточке*/
	if($('#PictureBlock .DPictureListCarousel').length>0)
	$('#PictureBlock .DPictureListCarousel').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 5});
	
	if($('#PictureBlock .DPictureListCarousel2').length>0)
	$('#PictureBlock .DPictureListCarousel2').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 8});
	
    // всплывашка при нажатии на "в корзину"
    $(".add-to-basket").live("click", function(){
        var d;
		$("#add-to-basket-popup").html('<div class="white_plash"><div class="exitpUp"></div><div class="cn tl"></div><div class="cn tr"></div><div class="content"><div class="content"><div class="content"> <div class="clear"></div><br/><center><img src="/ajax-loader.gif"></center><br/><div class="clear"></div></div></div></div><div class="cn bl"></div><div class="cn br"></div></div></div></div></div></div></div><div class="cn bl"></div><div class="cn br"></div></div>');
        // подгружаем аяксом нужный товар
        $.get($(this).attr('href'), {'IS_AJAX':true}, function(change_data){
            $('#add-to-basket-popup').empty().html(change_data);
			if(change_data.indexOf("Товар успешно добавлен в корзи")>0){
				$.get("/count.php","",function(rez){
					d = parseInt(rez,10);
					$(".basket span").html('').html('<img width="44" height="31" alt="" src="/basket_number.php?qua='+d+'">');
				});				
			}
        })
        
        $('#add-to-basket-popup').show();
        var name = $('#add-to-basket-popup');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
		$(name).show();
		
        return false;
    });
    
    // всплывашка "выбор сертификата"
    $('.select-sertificate').click(function(){
        $('#certificates-selector').show();
		$.cookie("button_certificates_click", 1);
        var name = $('#certificates-selector');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
        $(name).show();        
        return false;
    })     
    
    // всплывашка "Сделали подарок"
    $('.presents').click(function(){
        $('#made-a-gift').show();
        var name = $('#made-a-gift');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
        $(name).show();        
        return false;
    })  

	
	// всплывашка "Добавить свое"
    $('.add-my').click(function(){
        $('#add-my').show();
        var name = $('#add-my');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
		if($("#jqTransformTextarea-mm").hasClass("jqTransformSafariTextarea")){
			$("#jqTransformTextarea-mm").find("div").eq(0).css("height",50)
		}
        $(name).show();        
        return false;
    })  
    // всплывашка "Сообщить другу"
    $('.send-to-friend', ".adviseToFriendLink").click(function(){
        $('#FriendsRecomend').show();
        var name = $('#FriendsRecomend');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
        $(name).show();        
        return false;
    })  

    // всплывашка "Я выбрала для малыша"
    $('.i-choose').click(function(){
        $('#i-choose').show();
        var name = $('#i-choose');
        var win = $(window);
        var winWC = win.width()/2;
        var winHC = win.height()/2+$(document).scrollTop();
        var fSW = $(name).width()/2;
        var FSH = $(name).height()/2;
        winWC = winWC - fSW;
        winHC = winHC - FSH;
        $(name).css("left",winWC);
        $(name).css("top",winHC);
        $(name).show();        
        return false;
    })  

	//Вкл ссылки переключалки
	$("#trueLink a").click(function(){
		//if(!$(this).hasClass("jqTransformRadio")){
		var url = $(this).attr("href");
		document.location = url;
		//}
	});
    
    var selected_product = 0;
    var selected_color = '';
    var selected_size = '';
    
    
    // подкращиваем отсутвующие размеры и цвета на детальной при выборе цвето-размера
    $("#elementCatalog").delegate('.ColorList .item',"click",function(){
        var current_color_code = $(this).find('.current-color-code').html();
        var current_color = $(this).find('.current-color').html();
		$('#color_'+current_color_code).attr('checked', true);
		$(".ColorError").hide();
		$("#priceNote").hide();
        selected_color = current_color_code;
        $("#Basketplash #colorVal").val(selected_color);
        // проходим по размерам и смотрим какие существуют
        $('.SizeList .item').removeClass('not-available')
        $('.SizeList .item').each(function(){
            var current_size = $(this).find('.current-size').html();
            if (!arColorsSizes[current_color_code][current_size] > 0)
            {
                $(this).addClass('not-available');
            }
        })
        $('.Color span').html(current_color);
          largeimageloading = false;
		 largeimageloaded = false;
		
		var sz = $("#Basketplash #sizeVal").val();
		if(selected_size!=sz)
			selected_size = sz;
        selected_product = CheckProduct(selected_color, selected_size);
        if (selected_product > 0)
            DetailPageRefresh(selected_product); // обновляем страницу
		
    })

    // то же самое при клике по размерам
    $('.SizeList .item').click(function(){
        var current_size = $(this).find('.current-size').html();

        selected_size = current_size;
		$("#Basketplash #sizeVal").val(selected_size);
        // проходим по размерам и смотрим какие существуют
		$(".SizeError").hide();
        $('.ColorList .item').removeClass('not-available')
        $('.ColorList .item').each(function(){
            var current_color_code = $(this).find('.current-color-code').html();
            if (!arColorsSizes[current_color_code][current_size] > 0)
            {
                $(this).addClass('not-available');
            }
        })
        $('.Size span').html(current_size);
		largeimageloading = false;
		 largeimageloaded = false;
		var selected_color = $("#Basketplash #colorVal").val();
		$("#color_"+selected_color).click();
        selected_product = CheckProduct(selected_color, selected_size);
		//console.log(selected_product);
        if (selected_product > 0)
            // обновляем страницу
            DetailPageRefresh(selected_product);
		
    })
    
    
    $('.ToBasket').fancybox({
		'onStart':function(){
			if($("#Basketplash #colorVal").val()=="" || $("#Basketplash #sizeVal").val()==""){
				 var name = $('#add-to-basket-popup');
				var win = $(window);
				var winWC = win.width()/2;
				var winHC = win.height()/2+$(document).scrollTop();
				var fSW = $(name).width()/2;
				var FSH = $(name).height()/2;
				winWC = winWC - fSW;
				winHC = winHC - FSH;
				$(name).css("left",winWC);
				$(name).css("top",winHC);
				$(name).html('<div class="white_plash"><div class="exitpUp"></div><div class="cn tl"></div><div class="cn tr"></div><div class="content"><div class="content"><div class="content"> <div class="clear"></div><br/><center><img src="/ajax-loader.gif"></center><br/><div class="clear"></div></div></div></div><div class="cn bl"></div><div class="cn br"></div></div></div></div></div></div></div><div class="cn bl"></div><div class="cn br"></div></div>');
				$(name).show(); 
				var elm = $("#element-id").text();
				 $.get("/select-color-and-size.php?id="+elm, {'IS_AJAX':true}, function(change_data){
							$('#add-to-basket-popup').empty().html(change_data);
							if(change_data.indexOf("Товар успешно добавлен в корзи")>0){
								$.get("/count.php","",function(rez){
									d = parseInt(rez,10);
									$(".basket span").html('').html('<img width="44" height="31" alt="" src="/basket_number.php?qua='+d+'">');
								});				
							}
						});				
				return false;
			}
		},
		'onComplete': function(){
				$.get("/count.php","",function(rez){
							
							d = parseInt(rez,10);
							if(d >0){
								$(".basket span").html('').html('<img width="44" height="31" alt="" src="/basket_number.php?qua='+d+'">');
							}
						});
			}
    });
	
    // переключалка ретингов в комментарии к товару
		
    $('.score a').live("click",function(){
        var mark = $('.score a').index(this);
        $('#rating-mark').val(mark)
        $('.score a').removeClass('selected');
        $(this).addClass('selected');
        return false;
    })


	$('#btnSearchBottom, #showHref, .categoryF-left-filter, .ballon_text').live('click',function() {
		//if(typeof(isAdmin) != "undefined") alert($("#frmFilter").serialize()+"&currSection="+currSection);
		// CH_PRODUCER

		$.ajax({
			type: "POST",
			url: "/ajax/getUrl.php",
			async: false,
			data: $("#frmFilter").serialize()+"&currSection="+currSection
		}).done(function( msg ) {
			if(msg.length>0)
				document.location.href = msg;
			else $("#frmFilter").submit();
		});
		
		return false;
	});
	
    /*$('.categoryF-left-filter').click(function(){
        $('.filter form').submit();
    })*/
    
    // zoom
    // $("img.jqzoom").jqueryzoom({
	
        // xzoom: 430, //zooming div default width(default width value is 200)
        // yzoom: 300, //zooming div default width(default height value is 200)
        // offset: 10//, //zooming div default offset(default offset value is 10)
       // position: "left" //zooming div position(default position value is "right")
    // });
	
	// var elZm = $('.jqzoomix').jqzoom({
            // zoomType: 'standard',
			// zoomWidth:430,
			// zoomHeight:300,
			// preloadText:"Загрузка",
            // preloadImages: false
    // });
    
    // добавить и удалить из списока сравнения
    $(".right_sitebar").delegate('.add-to-compare-list-ajax',"click",function(){
        var product_id = parseInt($(this).val());
        if ($(this).is(':checked')) // галка не стоит
        {
            if (product_id > 0)
            {
                $.get('/add-to-compare-list.php', { 'id': product_id, 'action': 'ADD_TO_COMPARE_LIST' }, function(change_data){
					if($("#haveSravn").text()=="1"){
						var val = parseInt(change_data,10);
						if(val!=0){
							$("#sravn").html('<div class="add-to-compare-list"><a href="/catalog/compare/">сравнение товаров:</a><span>'+change_data+'</span><a id="clearCompear" href="#">очистить</a></div>');
						}
						else
							$("#sravn").html('');
					}
                });
				
            }
        }
        else  // галка стоит
        {
            if (product_id > 0)
            {
                $.get('/add-to-compare-list.php', { 'id': product_id, 'action': 'DELETE_FROM_COMPARE_LIST' }, function(change_data){
					if($("#haveSravn").text()=="1"){
						var val = parseInt(change_data,10);
						if(val!=0){
							$("#sravn").html('<div class="add-to-compare-list"><a href="/catalog/compare/">сравнение товаров:</a><span>'+change_data+'</span><a id="clearCompear" href="#">очистить</a></div>');
						}
						else
							$("#sravn").html('');
					}
                })
            }
        }
    });
	
	
    // тоже самое в детальной
    $("#CompareList .add, .addToCompareList").click(function() {
		obControl = $(this);
        var product_id = parseInt($('#product-id').html());
        if (product_id > 0)
        {
            $.get('/add-to-compare-list.php', { 'id': product_id, 'action': 'ADD_TO_COMPARE_LIST' }, function(change_data){
				if($(obControl).hasClass("addToCompareList"))
					$(".addToCompareList").replaceWith('<a href="/catalog/compare/" title="Уже в списке сравнения"><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="" /><span>Уже в списке сравнения</span></a>');
				else $('#CompareList').html('<div class="DIcon" ></div> <a href="/catalog/compare/">В список сравнения</a><div class="clear"></div>');
            })
        }
        
        
        return false;
    })
    

    // все/отличающиеся характеристики в списке сравнения
    if($('.CompareCatalog').length)
    {
        // проходим по всем свойствам и отмечаем классом HideTr такие, у которых неодинаковые зачения
        $('.do-compare').each(function(){
            var arCurrentPropValues = Array();
            
            $(this).addClass('HideTr'); 
            
            $(this).find('td').not('.first').each(function(){
                arCurrentPropValues.push($(this).html());                    
            })
            for(i = 0; i < arCurrentPropValues.length; i++)
            {
                if (arCurrentPropValues[i] != arCurrentPropValues[0])
                    $(this).removeClass('HideTr');
            }
        })
    }
    
    $('.add-to-basket-button').click(function(){
        $(this).next().click();
    })
   
   // кнопки с переходом по следующей ссылке
   $('.button-with-link').click(function(){
       var href = $(this).next().attr('href');
       if (href.length)
            location.href = href;
       return false;
       
   })
   
   // добавить в список малыша
   $('#BabyList .add, .addToBabyList').click(function(){
        var product_id = parseInt($('#product-id').html());
        var user_id = parseInt($('#user-id').html());
        if(!product_id)
		{
            product_id = parseInt($(this).parent().prev().html());
            if(product_id>0)
			{
                $.get('/add-to-wish-list.php', { 'product_id': product_id, 'user_id':user_id, status:'want' }, function(change_data){
					$(".addToBabyList").replaceWith('<a href="/community/user/'+user_id+'/" title="Уже в списке малыша"><img src="/bitrix/templates/nmg/img/icon2.png" width="13" height="11" alt="Уже в списке малыша" /><span>Уже в списке малыша</span></a>');
                   // $('.prod_id'+product_id).html('<div class="DIcon" ></div> <a target="_blank" href="/community/user/'+user_id+'/">Уже в списке малыша</a><div class="clear"></div>');
                })                
            }
        }
        else if (product_id > 0 && user_id > 0)
        {
            $.get('/add-to-wish-list.php', { 'product_id': product_id, 'user_id':user_id, status:'want' }, function(change_data){
              //  $('#BabyList').html('<div class="DIcon" ></div> <a href="/community/user/'+user_id+'/">Уже в списке малыша</a><div class="clear"></div>');
				$(".addToBabyList").replaceWith('<a href="/community/user/'+user_id+'/" title="Уже в списке малыша"><img src="/bitrix/templates/nmg/img/icon2.png" width="13" height="11" alt="Уже в списке малыша" /><span>Уже в списке малыша</span></a>');
            })
        }
        return false;
   })
   
    // добавить в список малыша
   $('.BabyList .add').live("click",function(){
       // consle.log($(this));
		var id = $(this).attr("id");
        var product_id = parseInt($('.product-id'+id).html());
        var user_id = parseInt($('.user-id'+id).html());
        
		if (product_id > 0 && user_id > 0)
        {
            $.get('/add-to-wish-list.php', { 'product_id': product_id, 'user_id':user_id, status:'want' }, function(change_data){
                $('.BabyList'+id).html('<div class="DIcon" ></div> <a href="/community/user/'+user_id+'/" class="greydot">Уже в списке малыша</a><div class="clear"></div>');
            })
        }
        return false;
   })
   
   // удалить из списка малыша
   $('.delete-from-wish-list').click(function(){
        var wish_list_item_id = parseInt($(this).next().html());
        var item_block = $(this).parent().parent();
        if (wish_list_item_id > 0)
        {
            $.get('/delete-from-wish-list.php', { 'wish_list_item_id': wish_list_item_id }, function(change_data){
                item_block.slideUp();
            })
        }       
        return false;
   })
   
   $("#closeAllReview").click(function() {
	  $("#reviewListContainer").find(".hidden").hide(); 
	  $("#showAllReview").show();
   });
   
   $("#showAllReview").click(function() {
	   $("#reviewListContainer").find(".hidden").show();
	   $("#showAllReview").hide();
   });
   
   $("#resetFilter").click(function(){
		$("#filterForm input").each(function(){
			if($(this).attr("type")=="checkbox"){
				$(this).attr("checked","");
			}
		});
	});
   
   
   loadRefreashImage = false;
   loadRefreashImage = true;
   if($('.ColorList .item').length>0){
		var colors_count = $('.ColorList .item').size();
		if(colors_count==1){
			 $('.ColorList input').click();
			 var value = $('.ColorList .current-color-code').text();
			 $("#colorVal").val(value);
		}
	 //console.log( value);
	 }
    // $('.SizeList .item').eq(0).find('input').click();
	
	
	$('.getReport').live("click",function(){
		var userid = $(this).attr("href");
		var tovarid = $(this).attr("id");
		var el = $(this).parent();
		 $.get('/addReport.php', { 'userid': userid, 'tovarid': tovarid }, function(change_data){
				$(el).html("<span>Отзыв запрошен</span>");
            });
		return false;
	});
	
	// с шестого пункта меню - второй уровень всплывает вверх
	$('#CatMenu .FirstLevel').addClass('show');
	$('.SecondLevel').addClass('show');
	var sec_level_counter = 0;
	$('.SecondLevel').each(function(){
		sec_level_counter++;
		if(sec_level_counter >= 6)
		{
			var current_height = $(this).height() - 28;
			$(this).css('top', '-'+current_height+'px');
		}
		$(this).removeClass('show');
	});
	$('#CatMenu .FirstLevel').removeClass('show');

	
	
	
	
});


// если выбраны цвет и размер - провверяем есть ли такой товар и если есть, то возвращаем его id
function CheckProduct(color, size)
{
	//console.log(arColorsSizes);
    if (color.length && size.length)
    {
        // если товар существует
        if (arColorsSizes[color][size] > 0)
            return arColorsSizes[color][size];
    }
    return false;        
}

var objClick = "";
function clicker(){

	if(objClick!=""){
		$(objClick).find("input").prop("checked",true);
		$(objClick).click();
		}
}
// заменяет элементы детальной страницы свойствами выбранного привязанного товара
// (свойства лежат на детальной странице в скрытых дивах) 
function DetailPageRefresh(product_id)
{
    var properties = $('#linked-item-id-'+product_id);
    if (properties.length)
    {
        var price = properties.find('.price').html();
        var old_price = properties.find('.old-price').html();            
        var bonus_scores = properties.find('.bonus-scores').html();            
        var articul = properties.find('.articul').html();            
        var midi_src = properties.find('.midi-src').html();  
		var midi_src_max = properties.find('.midi-src-max').html(); 
		var maxi_src = properties.find('.maxi-src').html();
		var midi_id = properties.find('.midi-id').html();
		var quantity = properties.find('.quantity').html();
		var maxi_id= properties.find('.maxi-id').html();
        quantity = parseInt(quantity,10);
		   
		if(loadRefreashImage == true){
		var element_id = $('#element-id').html();
		$('#midi-picture img').attr('src', midi_src_max);
        $('#midi-picture a').attr('href', '/inc/picture_view.php?ELEMENT_ID='+element_id+'&IMG_ID='+maxi_id);
				//console.log($('#midi-picture a').attr('alt'));
		$('#midi-picture a').attr('alt',maxi_src);
		//console.log($('#midi-picture a').attr('alt'));
		if(midi_src.length>0){
			$('#midi-picture img').attr('src', midi_src);
			$('#midi-picture img').attr('alt', maxi_src);
		}
		}
       
        $('#Basketplash .Price').html(CurrencyFormat(price)+' <span>р</span>');
        if (old_price > 0)
            $('#Basketplash .OldPrice').html(CurrencyFormat(old_price)+' <span>р</span>').show();
        else
            $('#Basketplash .OldPrice').hide(); 
        $('#Basketplash .ball').html(bonus_scores+' балла за покупку');
        //$('#ChooseBlock .article').html('Артикул: '+articul); /bug заменяет артикул на подробной стронице при первой загрузке
        
        var qu_val = $("#Quantity_val").val();
        if(qu_val > 0)
            qu = qu_val;
        else
            qu = 1;
        
		//console.log(quantity);
		
		if(quantity==0){
			if(!$('.ToBasket').hasClass("ToBasket-none"))
				$('.ToBasket').addClass("ToBasket-none");
		}
		else{
			if($('.ToBasket').hasClass("ToBasket-none"))
				$('.ToBasket').removeClass("ToBasket-none");
		}
		
        $('.ToBasket').attr('href', '/add-to-basket.php?action=ADD2BASKET&id='+product_id+'&quantity='+qu);
        
        $("#sel_colorsize").html(product_id);
		
		SetPreviewPictureToCenter();
    }
}

// подстветка title у ссылок (tooltip)
function l_tooltip(target_items, name){
$(target_items).each(function(i){
        $("body").append("<div class='"+name+"' id='"+name+i+"'><p>"+$(this).attr('title')+"</p></div>");
        var tooltip = $("#"+name+i);
        if($(this).attr("title") != "" && $(this).attr("title") != "undefined" ){
        $(this).removeAttr("title").mouseover(function(){
                tooltip.css({opacity:0.9, display:"none"}).fadeIn(30);
        }).mousemove(function(kmouse){
                tooltip.css({left:kmouse.pageX+15, top:kmouse.pageY+15});
        }).mouseout(function(){
                tooltip.fadeOut(10);
        });
        }
    });
}

function reCheck(){
	var sum = 0;
	$(".certificate-val .check:checked").each(function(){
		var id = $(this).val();
		var price = $("#cerf_"+id).html();
		price = parseInt(price,10);
		var count = $("#number_"+id).val();
		sum = sum+(price*count);
	});
		if(sum>0){
			$(".showsum").text(sum);
			$(".sum").show();
		}
		else
			{
			$(".sum").hide();
			}
}

var hideRat = false;
var elh = "null";
function showMassageErrorRating(el){
	$(".NoRatingMsg"+el).show();
	hideRat = true;
	ele = $(".NoRatingMsg"+el).find(".exitpUp");
	elh = $(".NoRatingMsg"+el);
	setTimeout('hideRat = false',100);
	setTimeout('ele.click()',3000);
}

$(document).click(function(e){
		if (!hideRat && elh!= "null") {
			elh.hide();
			elh = "null";
		}
	});


function reCheck2(){
	var sum = 0;
	$(".certificate-my .chesks:checked").each(function(){
		var id = $(this).val();
		var price = $("#cerfh_"+id).html();
		price = parseInt(price,10);
		var max = $("#max_"+id).val();
		var count = $("#numberh_"+id).val();
		if(count>max) {
			$("#numberh_"+id).val(max);
			count = max;
		}
		sum = sum+(price*count);
		//alert(id);
	});
		if(sum>0){
			$(".showsums").text(sum);
			$(".sums").show();
		}
		else
			{
			$(".sums").hide();
			}
}

function doeeeeSizeMlya(){
	// var heighthar = $("#haract").height();
		// var heightaks = $("#aks").height();
		// if(heighthar>heightaks){
			// var s = heighthar/200;
			// $("#aks .recommended").height(s*200);
			// $("#aks .recommended").jCarouselLite();
		// }
		// else{
			// $("#aks .recommended").height(400);
			// $("#aks .recommended").jCarouselLite();
		// }
}

function ShowWindows(element){
		var win = $(window);
		var winWC = win.width()/2;
		var winHC = win.height()/2+$(document).scrollTop();
		var fSW = $(element).width()/2;
		var FSH = $(element).height()/2;
		winWC = winWC - fSW;
		winHC = winHC - FSH;
		$(element).css("left",winWC);
		$(element).css("top",winHC);
		$(element).show();
		return false;
}

function no_sliddd(){
	$(".sliddd").hide();
}