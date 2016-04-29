function getCreditPrice(strPrice)
{
    intPrice = parseInt(strPrice.split(" ").join(""));
    return number_format(Math.ceil(intPrice / 10), 0, '.', ' ');
}

function addProductToCart(intProductID) {
	if(intProductID > 0) {
		$.ajax({
			type: "POST",
			url: "/bitrix/templates/nmg/ajax/addToCart.php",
			data: "action=ADD2BASKET&id="+intProductID+"&quantity=1&simple=Y"
		}).done(function( strResult ) {
			showNotify(strResult, "")
		});

		return false
	}

	return true;
}     

function simple_tooltip(target_items, name)
{
	$(target_items).each(function(i) {
		$("body").append("<div class='"+name+"' id='"+name+i+"'><p>"+$(this).attr('title')+"</p></div>");
		var my_tooltip = $("#"+name+i);
		
		$(this).removeAttr("title").mouseover(function(){
			my_tooltip.css({opacity:1, display:"none"}).fadeIn(400);
		}).mousemove(function(kmouse){
			my_tooltip.css({left:kmouse.pageX+15, top:kmouse.pageY+15});
		}).mouseout(function(){
			my_tooltip.fadeOut(0);
		});
	});
}

function animateTo(strSelector)
{
	jQuery("html:not(:animated),body:not(:animated)").animate({scrollTop: $(strSelector).offset().top}, 1000);
}

function initLocationSelect() {
	$("#sk-city-choose-sk-cityList a").click(function() {
		var strLocationPost = '<form id="locationSelectForm" method="post"><input type="hidden" name="setLocation" value="Y" /><input type="hidden" name="locationSelect" value="'+$(this).attr("data-id")+'" /></form>';

		$("body").append(strLocationPost);
		$("#locationSelectForm").submit();

		return false;
	});
}

function changeLocationLetter(strLetter) {
	$.ajax({
		type: "POST",
		url: "/system/getLocationSelect.php",
		data: "strLetter="+strLetter
	})
		.done(function( strHtml ) {
			$(".sk-city-choose-sk-cityList").html(strHtml);
			initLocationSelect();
		});
}

	/*City choose Popup*/
	var cityJSP = null;
	var cityJSP_api = null;

jQuery(document).ready(function($) {


	/* SocialServices */
	$('button.button[type=submit]').live('click',function(){
		$(this).parents('form').submit();
	});
	

	/* popup Inint */
	var pops = new PopUps(); 


	$('.sk-popup-open').click(function() {
		var obT = $(this);
		if ($('.sk-city-choose-scrollHolder').size() > 0 && $(this).data('scroll') == 'scroll') {
			pops.open($(this).attr('data-popup-name'), $(this).attr('title'), function() { cityJSP_api.destroy(); });
			cityJSP = $('.sk-city-choose-scrollHolder').jScrollPane();
			cityJSP_api = cityJSP.data('jsp');
			return false;
		}

		if(obT.attr("data-popup-name") == "city-sel") {
			$.ajax({
				type: "POST",
				url: "/system/getLocationSelect.php"
			})
				.done(function( strHtml ) {
					$("#"+obT.attr('data-popup-name')).html(strHtml);
					pops.open(obT.attr('data-popup-name'), obT.attr('title'));

					$("#selectLocationLetter a").click(function() {
						$("#selectLocationLetter .sk-city-choose-ABC_act").removeClass("sk-city-choose-ABC_act");
						$(this).parent().addClass("sk-city-choose-ABC_act");
						changeLocationLetter($(this).attr("data-letter"));

						return false;
					});

					initLocationSelect();
				});
		} else {
			if(obT.attr("id") == "deliveryShowLink")
				var obData = {ID: obT.attr("data-id"), MODE: "delivery-data"};
			else obData = {};

			pops.open(obT.attr('data-popup-name'), obT.attr('title'), false, obData);
		}

		return false;
	})


	/*if($("#catalogFilter").size() > 0) {
		var divF = $("#catalogFilter");
		var strQ = divF.attr("data-query")+"&strTemplate="+divF.attr("data-template")+"+&section_id="+divF.attr("data-section");

		$.ajax({
			type: "POST",
			url: "/ajax/getFilter.php",
			data: strQ
		})
			.done(function( msg ) {
				$("#catalogFilter").replaceWith(msg);
			});
	}*/


	$(".detailPage .reportLink").click(function() {
		$("#commentTabTitle").click();
		animateTo("#commentTabTitle");
		return false;
	});
	
	if ($('.sk-product-color--slider').size())
		$('.sk-product-color--slider').jcarousel();
	
	if ($('#sk-tumb-slider').size()) {	
    	$('#sk-tumb-slider').jcarousel();

	}
	
	if ($('.sk-accessory-slider:visible').size()) {
		if ($('.sk-accessory-slider li').size() > 5)
			$('.sk-accessory-slider:visible').jcarousel({vertical: true});
		
	}

    

    $('.fancybox').fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});



	function characteristicTextShow(){
		var el = $('.characteristic_text');
		if (el.height() > 1020) {
			el.css({'height': 1020,'overflow' : 'hidden'});
			$('.sk-characteristic-more-btt').show();
			$('.sk-characteristic-more-btt').live('click', function() {
				el.css({'height': 'auto'});
				$(this).hide();
				return false;
			})
		}
	
	};
	characteristicTextShow();
	
	/* TABS */
	(function(){
		var tabs = $('.sk-tab--tabs');
		var tabCont = $('.sk-tab--content');
		$('li a', tabs).live('click', function() {
			characteristicTextShow();
			$('li', tabs).removeClass('sk-tabs--item_active');
			$(this).closest('li').addClass('sk-tabs--item_active');
			$('.sk-tab--item:visible', tabCont).hide();
			$(''+$(this).attr('href'), tabCont).show();
			$(''+$(this).attr('href'), tabCont).find(".characteristic_info").after($("#detailAccessories").detach());
	
			return false;
		})
	
	})();
	/* END TABS */
	
	/* size Chose */
	(function() {		
		if ($('.sk-product-choose--item').size()) {
			var items = $('.sk-product-choose--item');
			//var label = $('.sk-product-choose--head span');
			var input = $('#sk-product-choose-input');
			$('a', items).live('click', function() {
				$('li', items).removeClass('sk-product-choose--item_active');
				$("#sizeLabel").empty();
				$("#sizeLabel").text($(this).text());
				$(this).parent().addClass('sk-product-choose--item_active');
				input.val($(this).attr('data-color'));
				
				strID = ($(this).parent().attr("id")).split("lisize_").join('colorData_');
				
				$("#colorsStorageHere").append($("#skProductColor > div").detach());
				$("#skProductColor").append($("#"+strID).detach());
				$("#skProductColor").find(".first").click();
				
				return false;
			})		
		}
	
	})();
	
	/* END size Chose */

	function showCode1C(strCode1C) {
		if(typeof(strCode1C) == "undefined")
			$("#CODE_1C_CONT").hide();
		else {
			$("#CODE_1C").html(strCode1C);
			$("#CODE_1C_CONT").show();
		}
	}

	/* product Color Chose */
	(function() {
		if ($('.sk-product-color').size()) {
			var el = $('.sk-product-color');
			var items = $('.sk-product-color--item', el);
			var input = $('#sk-product-color-input');
			var label = $('.sk-product-color--head-list a', el);
			var zoom = $('.sk-product-img--zoom a');
			
			$('.sk-product-color--item').bind('click', function(e) {
				//items.removeClass('sk-product-color--item_active');
				$(".sk-product-color--item").removeClass('sk-product-color--item_active');
				
				$(this).addClass('sk-product-color--item_active')
				label.find('span').empty();
				label.find('span').text($(this).attr('data-color'));
				label.attr('data-last-value', $(this).attr('data-color'))
				input.val($(this).attr('name')) 
				$("#offerID").val($(this).attr("data-offerID"));
				
				// set price
				var itemPrice = $(this).attr("data-price");
				var itemOldPrice = $(this).attr("data-old-price");
				var strCode1C = $(this).attr("data-code");
				
				var strAddon = '';
				if($("#priceHere .sk-item-preorder").size())
					strAddon = '<span class="sk-item-preorder">'+$("#priceHere .sk-item-preorder").html()+'</span>';

				// xml code here
				showCode1C(strCode1C);

				if(typeof(itemOldPrice) != "undefined")
					strPrice = '<div class="sk-product-price-old">'+itemOldPrice+' <span class="rub">&#101;</span></div> \
						<div class="sk-product-price-new'+(strAddon.length?' sk-product-price-new-preorder':'')+'">'+itemPrice+'<span class="rub">&#101;</span></div>';
				else strPrice = '<div class="sk-product-price-one">'+itemPrice+'  <span class="rub">&#101;</span></div>';
				
				
				
				$("#priceHere").html(strPrice+strAddon);
				
				$('.sk-product-img img')
					.attr('src', $(this).attr('data-img'))
					.attr('data-last-img', $(this).attr('data-img'));

                $("#creditprice").html(getCreditPrice($("#skProductColor a.sk-product-color--item_active").attr("data-price")));

                
			//	zoom.attr('href',  $(this).attr('data-img'));
				return false;
			})
		
			items.live('mouseenter', function(){
				$('.sk-product-img img')
					.attr('src', $(this).attr('data-img'))
				label.find('span').empty();
				$('.sk-product-color--head-list a span').text($(this).attr('data-color'));
			});
	
			items.live('mouseleave', function(){
	
				var img = $('.sk-product-img img');
				img.attr('src', img.attr('data-last-img'))
				label.find('span').text(label.attr('data-last-value'));
					
			});	
		}
	
	
	})();
	
	/* END  product Color Chose */
	/* Product IMG*/
	(function(){
		if ($('.sk-tumb').size()) {
			var el = $('.sk-tumb');
			//var zoom = $('.sk-product-img--zoom a');

			
			$('#sk-tumb-slider li a').click(function() {
				if ($('.sk-gallery-holder').is(':visible'))
					{return false}
				$('li', el).removeClass('sk-tumb_active');
				$(this).parent().addClass('sk-tumb_active');
				$('.sk-product-img img')
					.attr('src', $(this).attr('href'))
					.attr('data-last-img', $(this).attr('href'));
				//zoom.attr('href',  $(this).attr('href'));
				
				intFileID = ($(this).attr("id")).split("small").join("");
				$("#lastClickedImage").val(intFileID)
				
				return false;
			}); 
			
			$('li a', el).live('mouseenter', function(){
				$('#large img').attr('src', $(this).attr('href'));
			});
			$('li a', el).live('mouseleave', function(){
				var img = $('#large img');
				img.attr('src', img.attr('data-last-img'))
					
			});		
		}
	
	})();
	/* END Product IMG*/
/* gift Anim*/	
(function(){

	if ($('.sk-product-gift').size()) {
		$(window).load(function() {
			var stageOpen = 500;
			var stageClose = 3000;

				productGift.isAnim = true;
				productGift.small(1000, function() {
					setTimeout(function() {
						productGift.open(1000, function() {setTimeout(function() {
							productGift.close(1000, function() {productGift.isAnim = false;});
							//stage 2
						}, stageClose)});
					//stage 1
					}, stageOpen)
				});

		});
		$('.sk-product-gift_close').live('click', function() {
			if (!productGift.isAnim)
				productGift.open(1000, function() {});
		});
		$('.sk-product-gift_small').live('click', function() {	
			if (!productGift.isAnim)
				productGift.open(1000, function() {});

		});
		$('.sk-product-gift_open').live('click', function() { 
			if (!productGift.isAnim)
				productGift.close(1000, function() {});

		});
		var productGift = {
			el : $('.sk-product-gift'),
			t : 0,
			animSpeed : 1000,
			toSmallAnim : 500,
			toCloseAnim : 3000,
			isAnim : false,
			head: $('.sk-product-gift--head'), 
			content:  $('.sk-product-gift--cont'),
			headWidth: function() {
				return this.head.outerWidth();
			},
			headHeight: function() {
				return this.head.outerHeight();
			},
			contentHeight: function() {
				return this.content.outerHeight();
			},
			
			close: function(animSpeed, callback) {
				var self = this;
				self.head.css('display', 'none');
				self.content.css('display', 'none');
				self.el.animate({
					'width' : 0,
					'height': 31}, animSpeed, function () {
						self.el.removeClass('sk-product-gift_open').removeClass('sk-product-gift_small').addClass('sk-product-gift_close');
						callback();
					})
			},
			small: function(animSpeed, callback) {
				var self = this;
				var w = self.headWidth();

				self.el.animate({
					'width' : w,
					'height': 31
				}, animSpeed, function() {
					self.el.removeClass('sk-product-gift_close').removeClass('sk-product-gift_open').addClass('sk-product-gift_small');
					callback();
				})			
			},
			open: function(animSpeed, callback) {

				var self = this;
				self.content.width(self.headWidth());
				var h = this.headHeight()+this.contentHeight();
				var w = self.headWidth();
				self.el.animate({
					'width' : w,
					'height': h}, animSpeed, function () {
						self.content.css('display', 'block');
						self.head.css('display', 'block');
						self.el.removeClass('sk-product-gift_small').removeClass('sk-product-gift_close').addClass('sk-product-gift_open');
						callback();
					}) 
			}
		}		
	}
 /*
	if ($('.sk-product-gift').size()) {
		var el = $('.sk-product-gift');
		var t = 0;
		var animSpeed = 400;
		var toSmallAnim = 500;
		var toCloseAnim = 3000;
		var isAnim = true;
		$(window).load(function() {
			t = setTimeout(function(){
			var w = $('.sk-product-gift--head').outerWidth();
				el.animate({
					'width' : w
				}, 500, function() {
					$(this).removeClass('sk-product-gift_close').addClass('sk-product-gift_small');
					isAnim = false;
				})
			}, toSmallAnim);

			t = setTimeout(function(){
				el.animate({
					'width' : 0
				}, animSpeed,  function(){$(this).removeClass('sk-product-gift_small').addClass('sk-product-gift_close');})
			}, toCloseAnim);
		});


		$('.sk-product-gift_small').live('click', function() {		
			//$(this).removeClass('sk-product-gift_small').addClass('sk-product-gift_open');
			$(this).find('.sk-product-gift--head').css('display', 'block');
			$('.sk-product-gift--cont').width($('.sk-product-gift--head').outerWidth());
			var h = $('.sk-product-gift--head').outerHeight()+$('.sk-product-gift--cont').outerHeight();
			$(this).removeClass('sk-product-gift_small').addClass('sk-product-gift_open');
			el.animate({
				'height': h}, animSpeed, function () {
					$(this).find('.sk-product-gift--cont').css('display', 'block');
					$(this).removeClass('sk-product-gift_small').addClass('sk-product-gift_open');
				})
			clearTimeout(t);
		})
		$('.sk-product-gift_close').live('click', function() {
			if (isAnim) {
				return;
			}
			clearTimeout(t);
			var w = $('.sk-product-gift--head').outerWidth();
			$('.sk-product-gift--cont').width(w);
			var h =  $('.sk-product-gift--head').outerHeight()+$('.sk-product-gift--cont').outerHeight();
			el.animate({
				'width' : w,
				'height': h}, animSpeed, function () {
					$(this).find('.sk-product-gift--head').css('display', 'block');
					$(this).find('.sk-product-gift--cont').css('display', 'block');
					$(this).removeClass('sk-product-gift_close').addClass('sk-product-gift_open');
				})
		})
		$('.sk-product-gift_open').live('click', function() {
			$(this).find('.sk-product-gift--head').css('display', 'none');
			$(this).find('.sk-product-gift--cont').css('display', 'none');
			el.animate({
				'width' : 0,
				'height': 31}, animSpeed, function () {

					$(this).removeClass('sk-product-gift_open').addClass('sk-product-gift_close');
				})
		})
	}*/
})();
/* gift Anim*/

	
	$(".stext .showMore a").click(function() {
		$(".stext .showMore a").toggle();
		$(this).parent().parent().find(".less_text").toggle();
		$(this).parent().parent().find(".more_text").toggle();
		$(this).parent().parent().find(".dots").toggle();
		
		return false;
	});
	
	simple_tooltip($(".tooltip_a"),"tooltip");

if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
$(".catalog_list li").addClass('no-touch');
$(".catalog_list li").bind('touchstart', function(){
$(".catalog_list li .info").hide();	
$(this).find('.info').show();
    });
    //$(".catalog_list li").bind('touchend', function(){	}); 
	$(document).bind('touchstart', function(event){
	  if( $(event.target).closest(".catalog_list").length ) 
		return;
	  $(".catalog_list li .info").hide();
	  event.stopPropagation();
	});

}

	//$(".contant_table tr td.left_sitebar div.left_column").height ($(".contant_table tr td.left_sitebar").height() - ($("#leftColSocial").length>0?300:0));
	
	$(window).resize(function() {
							  
	});
	
	$(".toggleProducers").find("a").click(function() {
		$(".toggleProducers").toggle();
		$(".hiddenProducer").toggle();
		return false;
	});
	

	 /*
	 $("div.gift").hover(
	  function () {
		 $(this).find('div.gift_info').fadeIn("normal");
	  },
	  function () {
		 $(this).find('div.gift_info').fadeOut("normal");
	  }
	);
	*/
 
     $('.stock-item_card').mouseenter(function () {

		 $(this).find('div.gift_info').stop(true, true).fadeIn("normal");
		        if ($(this).closest('li').position().left > 250) {
		            $(this).find('div.gift_info').addClass('gift_info_right');
		        }
	  });
	$('.stock-item').mouseleave (
	  function () {
		 $(this).find('div.gift_info').stop(true, true).fadeOut("normal");
	  }
	);
 
	$('.stock-item .prize > a, .sk-menu-offer-item .prize > a').click(function() {
		var popup = $(this).next('div.gift_info');
		if (popup.is(':visible')) {
			popup.stop(true, true).fadeOut("normal");
			return false;
		}
		popup.stop(true, true).fadeIn("normal");
		/*if ($(this).closest('li').position().left > 250) {
		    popup.addClass('gift_info_right');
		}*/
		return false;
	});
	$('.gift_info').bind('mouseleave', function() {
		$(this).stop(true, true).fadeOut("normal");
	}); 
	 
	 $('a.close').click(function() {
		$(this).parents('div.gift_info').fadeOut("normal");		
		return false;
	});

	$(document).click( function(event){
	  if( $(event.target).closest("div.gift_info").length ) 
		return;
	  $("div.gift_info").fadeOut("normal");	
	  event.stopPropagation();
	});
	
	
//	 $('a.link_4').click(function() {
//		$(this).parent().find('div.gift_info').fadeIn("normal");	
//		return false;
//	});
	 
	 $("div.submenu").stop().hover(
	  function () {
		$(this).addClass('hover');
	  },
	  function () {
		$(this).removeClass('hover');
	  }
	); 
	
	
	
	
	$("div.gift_block_1").hover(
	  function () {
		$(this).find('div.gift_info').fadeIn("normal");
	  },
	  function () {
		
	  }
	);
	
	
	 $('div.enter a.aEnter').live("click.authPopup",function() {
		$(this).parent().parent().find('div.enter_popap').fadeIn("normal");	
		return false;
	});
	 
	 $('a.close1').click(function() {
		$(this).parents('div.enter_popap').fadeOut("normal");		
		if(window.lastSelectedGalleryItem) window.lastSelectedGalleryItem.click();
		return false;
	});

	$(document).click( function(event){
	  if( $(event.target).closest("div.enter_popap").length || $(event.target).closest('.sk-welkom-bar').length) 
		return;
	  $("div.enter_popap").not('.popupContainer').fadeOut("normal");
	/*	if ($('.overlay').length) {
			$(".overlay").remove();
		} */
	
	  if(window.lastSelectedGalleryItem) window.lastSelectedGalleryItem.click();
	  event.stopPropagation();
	});
	
	 $('#commentAddRating span').click(function() {
		$(this).parent().find('span').removeClass('active');
		$(this).addClass('active');
		var mark = 4-$('#commentAddRating span').index(this);
		$('#rating-mark').val(mark);
		 
		return false;
	});
	 
	 

	 
	 $('ul.size_select li').click(function() {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		
		strSizeCode = ($(this).attr("id")).split("lisize_").join("");
		strHtmlNew = $("#colorData_"+strSizeCode).detach();
		strHtmlOld = $("#colorsHere").next().detach();
		$(strHtmlNew).insertAfter($("#colorsHere"));
		$(strHtmlOld).appendTo($("#colorsStorageHere"));
		
		$("#select_block_popap").find("tr.selected").click();
		$("#select_block_popap").find("tr.selected").find(".cloud-zoom-gallery").click();
		
		var obTR = $("#colorsHere").next().find(".select_block_bg1").find("tr");
		if(obTR.length == 1)
			$("#colorsHere").next().find(".select_block_bg").unbind("click");
		
		return false;
	});
	 
	 
	 
	 
	 
	 
	/*$(".jcarousel li a").click(function(){
		$("#large table tr td img").hide().attr({"src": $(this).attr("href"), "title": $("table tr td> img", this).attr("title")});
		return false;
	
	});*/
	
	//$("#large table tr td>img").load(function(){$("#large table tr td>img:hidden").fadeIn("slow")});
	
	var ulHeight = $("div.select_block_popap").height()/2;
	$("div.select_block_popap").css("top","-"+ulHeight+"px");
	 
	 
	 /**/
	 
	 $('div.select_block_bg').click(function() {
		$(this).parent().find('div.select_block_bg1').css("top","50%");
		$(this).parent().find('div.select_block_popap').css("display","none");
		$(this).parent().find('div.select_block_popap').fadeIn("normal");
		return false;
	});

	$('div.select_block_popap').click(function() { // select offer
		$(this).fadeOut("normal");	
		return false;
	});
	
	$('div.select_block_popap tr').click(function() {
		obColorData = $(".color_data");
		
		$(obColorData).find(".selectedOfferMiniPic img").attr("src", $(this).find(".miniPic a img").attr("src")); // pic
		$(obColorData).find(".selectedOfferColor").html($(this).find(".miniPic a img").attr("alt")); // color name
		//$(obColorData).find(".selectedOfferAvail").html($(this).find(".td_3").html()); // avail
		$(".total_block").find(".old_cost").html($(this).find(".td_4 b").html()); // old price
		
		floatPrice = parseFloat($(this).find(".price strong span").html());
		if(floatPrice>0)
			$(".total_block").find(".cost").html($(this).find(".price strong span").html()+' <span>P</span>');
		else $(".total_block").find(".cost").html("");
		
		$("#offerID").val($(this).attr("rel"));
		
		if(($(this).find(".td_3").html()).indexOf("navail") == -1)
		{
			$("#deliveryDate").show();
			$("#addToCartButton").removeClass("hidden");
			$("#notifyMeButton").addClass("hidden");
		} else {
			$("#deliveryDate").hide();
			$("#addToCartButton").addClass("hidden");
			$("#notifyMeButton").removeClass("hidden");
		}
		
		currentDeliveryPrice = getDeliveryPrice($("#cartPrice").val(), parseFloat(toNum($("h5.cost").html())));
		if(parseInt(currentDeliveryPrice)>0)
			strDeliveryPrice = 'Доставка '+currentDeliveryPrice;
		else strDeliveryPrice = currentDeliveryPrice;
		
		$("#deliveryPrice").html(strDeliveryPrice); // update delivery price
		window.lastSelectedGalleryItem = $(this).find(".cloud-zoom-gallery");
	});

	$(".addToCartButton").click(function() {
		quantity=$(".sk-product-price-count input").val();
        if (quantity<1) quantity=1;
        
        strData = '';
		if(($(this).attr("href")).length>2)
			strData = $(this).attr("href");
		else if(parseInt($("#offerID").val())>0)
			strData =  "action=ADD2BASKET&id="+$("#offerID").val()+"&quantity="+quantity;
		
		if(strData.length>2)	
		{
			$.ajax({
				type: "POST",
				url: "/bitrix/templates/nmg/ajax/addToCart.php",
				data: strData
			}).done(function( strResult ) {
				showNotify(strResult, "")
			});
		} else $(".select_block_bg:visible").click();
		
		return false;
	});
	
	$(".miniPic").find("img").click(function() {
		$(this).parent().parent().parent().click();
	});
	
	$(".notifyMeButton").click(function() {
		if(($(this).attr("href")).length>2)
		{
			if(($(this).attr("href")).indexOf("#na") === 0)
				intOfferID = ($(this).attr("href")).split("#na_").join("");
			else if(($(this).attr("href")).indexOf("#ng") === 0)
				intProductID = ($(this).attr("href")).split("#ng_").join("");
		} else intOfferID = $("#offerID").val();
		
		if((typeof(intOfferID) !== "undefined" && intOfferID>0) || typeof(intProductID) !== "undefined")
		{	
			if(($("#naForm")).length<=0)
			{
				$.ajax({
					type: "POST",
					url: "/bitrix/templates/nmg/ajax_tmpl/notifyForm.php"
				}).done(function( strResult ) {
					$(strResult).insertAfter('#ajaxContainer');
					showPopupContainer($("#naDiv"));
					
					if(typeof(intOfferID) !== "undefined")
						$("#naOffer").val(intOfferID);
					else if(typeof(intProductID) !== "undefined")
						$("#naProduct").val(intProductID);
				});
			} else {
				showPopupContainer($("#naDiv"));
				if(typeof(intOfferID) !== "undefined")
					$("#naOffer").val(intOfferID);
				else if(typeof(intProductID) !== "undefined")
					$("#naProduct").val(intProductID);
			}
		} else $(".select_block_bg:visible").click();
		
		return false;
	});

	$(".fullTextLink").click(function() {
		$(".fullText").removeClass("hidden");
		$(this).parent().hide();
		return false;
	});
	
	$(".fullTextHideLink").click(function() {
		$(".fullText").addClass("hidden");
		$(".fullTextLink").parent().show();
		return false
	});

	$(document).click( function(event){
	  if( $(event.target).closest("div.select_block_popap").length ) 
		return;
	  $("div.select_block_popap").fadeOut("normal");	
	  event.stopPropagation();
	});
	 
	 
	$("div.select_block_popap table tr").hover(
		function () {
			$(this).find(".cloud-zoom-gallery").click();
		},
		function () {
			
		}
	); 
	 
	 /*
	$(".div.select_block_popap table tr").click(function(){
		$("#large table tr td img").hide().attr({"src": $(this).attr("rel")});
		return false;
	
	});*/

	 
	 
	/**/
	
	
	
	$("ul.filter_producent_list li span").bind('click', function() {
		$(this).parent().find('b').css("display","block");
		$(this).parent().find('input').attr('checked', 'checked');
		showBaloon($(this).parent().find('input'));
		return false;
	});
	
	$("ul.filter_producent_list li b").bind('click', function() {
		$(this).css("display","none");
		$(this).parent().find('input').removeAttr("checked");
		showBaloon($(this).parent().find('input'));
		return false;
	});
	
	
	
	
	$("a.popap_link").hover(
	  function () {
		 $(this).find('span.popap_link_popap').css("display","block");
	  },
	  function () {
		$(this).find('span.popap_link_popap').css("display","none");
	  }
	);
	
	
	
	$("a.popap_link1").bind('click', function() {
		$(this).find('span.popap_link_popap').toggleClass("popap_link_popap_active");
		return false;
	});
	
	$(document).click( function(event){
	  if( $(event.target).closest("span.popap_link_popap").length ) 
		return;
	  $("span.popap_link_popap").removeClass('popap_link_popap_active');
	  event.stopPropagation();
	});
	
	
	/*$('.left_column1 input:checkbox').change(function() {
		showBaloon($(this));
	});
	$('.left_column1 input:text').keypress(function() {
		showBaloon($(this));
	});
	$('.baloon_close').click(function() {
		$('.baloon').fadeOut(100);
	});*/
	
	$(".closePopupContainer").click(function() {
		$(".popupContainer").hide();

		if ($('.overlay').length) {
			$(".overlay").remove();
		}
		return false;
	});
	
	$(".quickOrder").click(function() {
        alert(1);
		intProductID = $("#offerID").val();
		if(($("#quickOrderForm")).length<=0)
		{
			$.ajax({
				type: "POST",
				url: "/bitrix/templates/nmg/ajax_tmpl/quckOrder.php"
			}).done(function( strResult ) {
				$(strResult).insertAfter('#ajaxContainer');
				$("#quickOrderForm").find("ul").show();
				showPopupContainer($("#quickOrderDiv"));
				$("#qoProduct").val(intProductID);
			});
		} else {
			$("#quickOrderForm").find("ul").show();
			$("#quickOrderForm").find(".errorp").remove();
			$("#quickOrderForm").find(".notep").remove();
			showPopupContainer($("#quickOrderDiv"));
			$("#qoProduct").val(intProductID);
		}
		
		return false;
	});
	
	$("#feedbackFormHref").click(function() {
		if($("#feedbackFormDiv").size() <= 0)
		{
			$.ajax({
				type: "POST",
				url: "/bitrix/templates/nmg/ajax_tmpl/feedbackForm.php"
			}).done(function( strResult ) {
				$(strResult).insertAfter('#ajaxContainer');
				$("#feedbackForm").find("ul").show();
				showPopupContainer($("#feedbackFormDiv"));
			});
		} else {
			$("#feedbackForm").find("ul").show();
			$("#feedbackForm").find(".errorp").remove();
			$("#feedbackForm").find(".notep").remove();
			showPopupContainer($("#feedbackFormDiv"));
		}
		
		return false;
	});

/*new menu*/
	$('.sk-menu').bind('mouseenter', function() {
		$('.sk-menu-dropdown').show();
	})
	$('.sk-menu').bind('mouseleave', function() {
		$('.sk-menu-dropdown').hide();
		$('.sk-menu_main li').removeClass('sk-menu_main_act');
	})
	$('.sk-menu_main a').bind('mouseenter', function() {
		$('.sk-menu_main li').removeClass('sk-menu_main_act');
		$(this).parent().addClass('sk-menu_main_act');

		$('.sk-menu-dropdown--item').hide();
		$('.sk-menu-dropdown--item[data-name='+$(this).parent().data('for')+']').show();
	})
	
/*new menu*/

	
});

function centerObject(obContainer)
{
	$("#invisibleTmp").html($("#showNotifyDiv").html());
	$("#showNotifyDiv").width(($("#invisibleTmp").width()<300?300:$("#invisibleTmp").width()));
	$("#invisibleTmp").html('');
	
	var win = $(window);
	var winWC = win.width()/2;
	var winHC = win.height()/2+$(document).scrollTop();
	var fSW = $(obContainer).width()/2;
	var FSH = $(obContainer).height()/2;
	
	$(obContainer).css("left", (winWC - fSW));
	$(obContainer).css("top", (winHC - FSH));
}

function showPopupContainer(obContainer)
{
	if(($(obContainer).filter(":visible")).length>0) {
		centerObject(obContainer);
		if (!$('.overlay').length) {
			$('<div class="overlay" />').insertAfter(obContainer);
		}
     		
     }	else {
		centerObject(obContainer);
		$('.popupContainer').hide();
		$(obContainer).show();
if (!$('.overlay').length) {
$('<div class="overlay" />').insertAfter(obContainer);
}

	}
}

function showNotify(strText, strTitle)
{
	if(($("#showNotifyDiv")).length<=0)
		$('<div class="enter_popap hidden popupContainer" id="showNotifyDiv"><div></div><a title="" href="#" class="closePopupContainer close1"></a></div><div id="invisibleTmp"></div>').insertAfter('#ajaxContainer');
	
	$("#showNotifyDiv").find(".closePopupContainer").click(function() {
		$('.popupContainer').hide(); 

		if ($('.overlay').length) {
			$(".overlay").remove();
		}
		return false;
	});
	
	if(typeof(strTitle) == "undefined") strTitle = '';
		
	$("#showNotifyDiv div").html('<ul>'+(strTitle.length>0?'<li><h1>'+strTitle+'</h1></li>':'')+'<li>'+strText+'</li></ul>');
	$('.popupContainer').hide();
	showPopupContainer("#showNotifyDiv");
}

function getDeliveryPrice(floatCartPrice, floatProductPrice, intMode)
{
	if(typeof(intMode) == "undefined") intMode = 0;
	if(typeof(floatProductPrice) == "undefined") floatProductPrice = 0;

	floatCartPrice = parseFloat(floatCartPrice);
	floatProductPrice = parseFloat(floatProductPrice);

	floatCartPrice += floatProductPrice;	
	
	intDeliveryPrice = 0;
	for(var i in arDelivery)
	{
		if(floatCartPrice>=arDelivery[i][0] && floatCartPrice<=arDelivery[i][1])
			intDeliveryPrice = arDelivery[i][2];
	}

	if(intDeliveryPrice>0)
		return intDeliveryPrice + " р";
	else return (intMode==0?'Бесплатная доставка':'бесплатно');
}

function toNum(strVal)
{
	strVal = String(strVal);
	arReplace = {" ":"", ".":","};
	
	for(var i in arReplace) strVal = strVal.split(i).join(arReplace[i]);
	return parseFloat(strVal);
}

function orderItem()
{
	if(($("#addToCartButton:visible")).length>0)
		$("#addToCartButton").click();
	else if(($("#notifyMeButton:visible")).length>0)
		$("#notifyMeButton").click();
}

function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +	 bugfix by: Michael White (http://crestidg.com)

    var i, j, kw, kd, km;

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return km + kw + kd;
}


	function PopUps () {
		var that = this;
		var holder =$('<div class="sk-popup-holder"><div id="sk-popup" class="sk-popup"><div class="sk-popup--close"><a href="#" title="Закрыть"></a></div><div class="sk-popup--head"><span></span></div><div class="sk-popup--body"></div></div><div class="sk-popup-overlap"></div></div>');
		var popup = holder.find('.sk-popup');
		var popupBody = holder.find('.sk-popup--body');
		var popupHead = holder.find('.sk-popup--head span');
		var onCloseCallback = function() {};


		this.open = function(bodyID, strName, closeCallback, obData) {

			onCloseCallback = closeCallback ||  function() {};

			var windowH = $(window).height();
			var windowW = $(window).width();

			if($('#'+bodyID).size()>0) {
				$('#'+bodyID).clone().show().appendTo(popupBody);
				popupHead.text($('#'+bodyID).data('popup-head'));

				holder.css(
					{
						'width': windowW,
						'height': $(document).height()
					}
				)
				holder.appendTo('body');
				holder.css({'position': 'absolute'})

				if (windowH-100 < popup.height()) {

					popup.css( {
						top: 	($(document).scrollTop()+100),
						left: windowW/2 - popup.width()/2
					})
				} else {
					popup.css( {
						top: $(document).scrollTop()+windowH/2 - popup.height()/2,
						left: windowW/2 - popup.width()/2
					})
				}
			} else {
				var obRequestData = { TYPE: "card", LOCATION: bodyID};

				if(typeof(obData) == "object") {
					if(obData.ID > 0 && obData.MODE == "delivery-data") {
						obRequestData.ID = obData.ID;
						obRequestData.MODE = obData.MODE;
					}
				}

				popupHead.text(strName);
				$.ajax({
					type: "POST",
					url: "/ajax/getText.php",
					data: obRequestData
				})
					.done(function( str ) {
						popupBody.html(str);
						holder.css(
							{
								'width': windowW,
								'height': $(document).height()
							}
						)
						holder.appendTo('body');
						holder.css({'position': 'absolute'})

						if (windowH-100 < popup.height()) {
							popup.css( {
								top: 	($(document).scrollTop()+100),
								left: windowW/2 - popup.width()/2
							})
						} else {
							popup.css( {
								top: $(document).scrollTop()+windowH/2 - popup.height()/2,
								left: windowW/2 - popup.width()/2
							})

						}
					});
			}
		}
		this.close = function() {
			onCloseCallback();
			popupHead.empty();
			popupBody.empty();
			holder.remove();
		}
		$('.sk-popup .sk-popup--close a').live('click', function() {
			that.close();
			return false;
		});

		$('.sk-popup-overlap').live('click', function() {
			that.close();
		})
	}

$(function() {
  $("i[title]").each(function(){
      var linkIdString = '';
      var linkClassString = '';

    if ($(this).attr("id")) {
      linkIdString = " id = '" + $(this).attr("id") + "'";
    }

    if ($(this).attr('class')) {
      linkClassString = " class = '" + $(this).attr('class') + "'";
    }
    $(this).replaceWith("<a href='" + $(this).attr("title") + "'" + linkClassString +  linkIdString + ">" +$(this).html() + "</a>");
  });

});