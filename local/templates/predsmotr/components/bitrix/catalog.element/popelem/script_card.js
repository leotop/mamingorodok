

$(document).ready(function() {
	//if($("#sk-product-choose--item").size())
		//$("#sk-product-choose--item li:first a").click();
	$("#creditprice").html(getCreditPrice($("#skProductColor a.sk-product-color--item_active").attr("data-price")));

	$(".popup_block div.oh4").each(function() {
		$(this).parents(".popup_block").attr("data-popup-head", $(this).html());
		$(this).remove();
	});
	
	if(document.location.hash == "#postform" || (document.location.hash).indexOf("#message")>-1 || document.location.hash == "#comment")
	{
		$("#commentTabTitle").click();
		animateTo("#commentTabTitle");
	}
	
	if($("#characteristicDivInner").height() > $("#characteristicDiv").height())
	{
		$("#characteristicDiv").after("<div id='showAllCharacteristicDiv'><a href='#'>показать все</a></div>");
		$("#characteristicDivInner").append("<br><div id='hideAllCharacteristicDiv'><a href='#'>скрыть</a></div>");
		
		$("#showAllCharacteristicDiv").click(function() {
			$("#hideAllCharacteristicDiv").show();
			$("#showAllCharacteristicDiv").hide();
			$("#characteristicDiv").css("overflow", "visible");
			
			return false;
		});
		
		$("#hideAllCharacteristicDiv").click(function() {
			$("#showAllCharacteristicDiv").show();
			$("#hideAllCharacteristicDiv").hide();
			$("#characteristicDiv").css("overflow", "hidden");
			animateTo("#paramTabTitle");
			
			return false;
		});
	}
	
	var currentDeliveryPrice = getDeliveryPrice($("#cartPrice").val(), parseFloat(toNum($("#productPrice").html())), 1);
	$("#moscowDeliveryData").attr("data-str2", "<strong>Внутри МКАД:</strong> "+currentDeliveryPrice);
	
	$("#deliveryDropDown a").click(function() {
		$("#deliveryRegion").html($(this).html());
		
		$("#deliveryStr1").html($(this).attr("data-str1"));
		$("#deliveryStr2").html($(this).attr("data-str2"));

		$("#deliveryShowLink").attr("title", $(this).attr("data-name"));
		
		$("#deliveryShowLink").attr("data-popup-name", $(this).data("popup"));
		
		$("#deliveryDropDown").hide();
		
		return false;
	});
	$("#deliveryDropDown a:first").click();
	
	$("#allParamLink").click(function() {
		$("#paramTabTitle").click();
		animateTo("#paramTabTitle");
		return false;
	});
	
	if(window.location.hash == "#reports" || window.location.hash == 'review')
	{
		$("#commentTabTitle").click();
		animateTo("#commentTabTitle");
	}	

	$('.sk-sd-delvery .sk-link-btt').live('click', function() {
		if ($(this).next('.sk-dropdown-menu').is(':visible'))
		{
			$(this).next('.sk-dropdown-menu').hide();
		} else {
			$(this).next('.sk-dropdown-menu').show();

		}
		return false;
	});

	$(document).click(function(e) {
		if (!$(e.target).closest('.sk-sd-delvery').length) {
			$('.sk-dropdown-menu').hide();
		}

		e.stopPropagation();
	})


	var gal = new Gallery();
	

	
	$('.sk-product-img--zoom a, .sk-product-img a, .sk-product-color--head a').live('click', function() {
		gal.open();
		if ($('#sk-tumb-gallery-slider').size()) {	
			$('#sk-tumb-gallery-slider').jcarousel();
		}
		return false;
	})	

		$('.sk-gallery-color-item').hover(function(){
			setImg($('.sk-gallery--img img'), $(this).data('img'));
		}, function(){
			restoreImg($('.sk-gallery--img img'));
		});
			
		$('.sk-gallery-color-item').click(function() {
			if ($(this).hasClass('sk-gallery-color-item_act'))	{
				
				strSizeHash = $(this).data("sizehash");
				if(typeof(strSizeHash) != "undefined")
				{
					$("#lisize_"+strSizeHash+" a").click(); // select offer size

				}
				
				intID = ($(this).attr("id")).split("galleryOffer").join();
				$("#smallOffer"+intID).click(); // select offer
				
				gal.close();
				
				intID = ($(this).attr("id")).split("galleryOffer").join("");
				$("#smallOffer"+intID).click();
			} else {
				$('.sk-gallery-color-item').removeClass('sk-gallery-color-item_act');
				$(this).addClass('sk-gallery-color-item_act');
			//	setImg($('#galleryCurrentImage'), $(this).data('img'));
				saveImg($('#galleryCurrentImage'));
			}
			return false;
		});

		$('#sk-tumb-gallery-slider li a').click(function() {


			$('#sk-tumb-gallery-slider li').removeClass('sk-tumb_active')
			$(this).closest('li').addClass('sk-tumb_active');
			saveImg($('.sk-gallery--img img'));
			return false;
		});

		$('#sk-tumb-gallery-slider li a').hover(function() {
			setImg($('#galleryCurrentImage'), $(this).attr('href'));
		}, function(){
			restoreImg($('#galleryCurrentImage'));
		})
			
		function setImg(el, src) {
			el.attr('src', src)			
		}
		function restoreImg(el) {
			el.attr('src', el.data('last'));
		}
		function saveImg(el, bigImg) {
			el.data('last', el.attr('src')); 
		}
		function reinitCloudZoom (el) {
			el.addClass('cloud-zoom');
			$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();			
		}
		function selectProductTumb () {
			
			intFileID = ($('#sk-tumb-gallery-slider .sk-tumb_active a').attr("id")).split("gallery").join("");
			$("#small"+intFileID).click();
		} 
/*
	function PopUps () {
		var that = this;
		var holder =$('<div class="sk-popup-holder"><div class="sk-popup"><div class="sk-popup--close"><a href="#" title="Закрыть"></a></div><div class="sk-popup--head"></div><div class="sk-popup--body"></div></div><div class="sk-popup-overlap"></div></div>');
		var popup = holder.find('.sk-popup');
		var popupBody = holder.find('.sk-popup--body');
		var popupHead = holder.find('.sk-popup--head');

		this.open = function(bodyID, strName) {
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
				popupHead.text(strName);
				$.ajax({
					type: "POST",
					url: "/ajax/getText.php",
					data: { TYPE: "card", LOCATION: bodyID}
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


*/

	function Gallery() {
		var that = this;
		var holder = $('.sk-gallery-holder');
		var popup = $('.sk-gallery');
		var galListPrev, api;
		this.open = function() {
			$('.sk-gallery-color-item').removeClass('sk-gallery-color-item_act');
				
			holder.css(
				{
					'width': '100%',
					'height': $(document).height()
				}
			)
			holder.show();	
				/*popup.css( {
					top: 100,
					left: $(window).width()/2 - popup.outerWidth()/2
				})		
*/
			$('body').css('overflow', 'hidden');
			popup.css( {
				top: $(window).height()/2 - popup.outerHeight()/2,
				left: $(window).width()/2 - popup.outerWidth()/2
			})		
			reinitCloudZoom($('.sk-gallery--img a'));


		// set image
			$("#gallery"+$("#lastClickedImage").val()).click();	
			$("#galleryCurrentImage").attr("src", $("#gallery"+$("#lastClickedImage").val()).attr("href"));		
			galListPrev  = $('.sk-gallery-color-scroll').jScrollPane();
			api = galListPrev.data('jsp');
		}
		this.close = function() {
			holder.hide();
			selectProductTumb();
			$('body').css('overflow', 'auto');
		}
		this.reDraw = function () {
			popup.css( {
				top: $(window).height()/2 - popup.outerHeight()/2,
				left: $(window).width()/2 - popup.outerWidth()/2
			})		
		}	

		$(window).resize(function() {
			that.reDraw();
		}) 
		$('.sk-gallery .sk-gallery--close a').live('click', function() {
			that.close();
			return false;
		});
		$('.sk-gallery-overlap').live('click', function() {
			that.close();
		})
		$('.sk-gallery--all-price a').live('click', function() {
			$('#galleryListPreview a:hidden').show(); 
			$(this).parent().hide(); 
			api.reinitialise();
			return false;
		})

	}

});

/*$(document).ready(function() {
	setTimeout(function() {
		var margin_top;
		margin_top = $(document).scrollTop();
		alert(margin_top);
	}, 1000);
});*/