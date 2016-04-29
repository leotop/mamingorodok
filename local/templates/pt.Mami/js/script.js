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
	$('#FPictureBlock .DPictureList').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 5});
	$("#FPictureBlock .DPictureList a").fancybox({'type': 'ajax','autoScale':true, 'showNavArrows': false, 'onComplete':CaruselPictureFancy});
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
	});

	
$(document).ready(function() {
	
	//Вызов файла по кнопке
	$("#file").click(function(){
		var id = $(this).next().val();
		$("#file"+id).click();
		return false;
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
	$(".showpUp").click(function(){
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
	
	$(".exitpUp").click(function(){
		$(this).parent().parent().hide();
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
			$(this).text("Основные параметры");
			}
		else{
			depBlock.addClass("deactive");
			$(this).text("Все параметры");
			}
			
		return false;
	});
	
    // кнопочки
    $('input:submit', this).each(ButtonAdd);
    $('input:reset', this).each(ButtonAdd);
    $('input:button', this).each(ButtonAdd);	
	
	$(".enter").click(function(){
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
				info.css({
					top: tp.top-ih,
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
	
	
	$("a.fancybox").fancybox();
	$(".DPicture a").fancybox({'type': 'ajax','autoScale':true, 'showNavArrows': false, 'onComplete':CaruselPictureFancy});
	
	// во всплывающем леере никаких фэнсибоксов!  
    $('.no-fancybox').unbind().click(function(){return false;});
    
	$('.choose  a').click(function() {return false;});
	
	/*карусель на карточке*/
	$('#PictureBlock .DPictureList').jCarouselLite({btnPrev: '.prev', btnNext: '.next', mouseWheel: true, visible: 5});
	$('.DPictureList a').click(function(){return false;});
	
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
	
	
	/* раскрываем - прячем рекомендуемые товары*/
    $('.open-list').click(function(){
        if ($(this).hasClass('opened'))
            $(this).removeClass('opened');
        else
            $(this).addClass('opened');
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
	$('.CompareCatalog tr, .CompareCatalog .remove').hover(function(){$(this).addClass('hover');}, function(){$(this).removeClass('hover');});

    // всплывашка при нажатии на "в корзину"
    $('.add-to-basket').click(function(){
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
    })        
    
    // всплывашка "выбор сертификата"
    $('.select-sertificate').click(function(){
        $('#certificates-selector').show();
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
        $(name).show();        
        return false;
    })  
    // всплывашка "Сообщить другу"
    $('.send-to-friend').click(function(){
        $('#send-to-friend').show();
        var name = $('#send-to-friend');
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
    
});
