<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):?>
    
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    <div id="PopupParamsChoose">
    <div class="title">Выберите параметры товара</div>
    <?$APPLICATION->IncludeComponent('individ:catalog.element' , 'color-size', array(
         "IBLOCK_TYPE" => 'catalog',
         "IBLOCK_ID" => CATALOG_IBLOCK_ID,
         "ELEMENT_ID" => $_REQUEST['id'],
		 "CACHE_TYPE"=>"N"
    ));?>    
    </div>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>

<script>
    var selected_product_ajax = 0;
    var selected_color_ajax = 0;
    var selected_size_ajax = 0;   
   
    // если выбраны цвет и размер - проверяем есть ли такой товар и если есть, то возвращаем его id
    function CheckProductAJAX(color, size)
    {
        if (color.length && size.length)
        {
            // если товар существует
            if (arColorsSizesAJAX[color][size] > 0)
                return arColorsSizesAJAX[color][size];
        }
        return false;        
    }

    // заменяет элементы детальной страницы свойствами выбранного привязанного товара
    // (свойства лежат на детальной странице в скрытых дивах) 
    function DetailPageRefreshAJAX(product_id)
    {
		
        var properties = $('#linked-item-id-'+product_id);
        if (properties.length)
        {
            var price = properties.find('.price').html();   		
            var old_price = properties.find('.old-price').html();            
            var bonus_scores = properties.find('.bonus-scores').html();            
            var articul = properties.find('.articul').html();            
            var midi_src = properties.find('.midi-src').html();   
			var quantity = properties.find('.quantity').html();   
			var color_code = properties.find('.color-code').html();		
			//console.log($('.color-id-'+color_code).find("input"));			
			$('.color-id-'+color_code).find("input").each(function(){
				$(this).prop("checked",true);
			});
			quantity = parseInt(quantity,10);
           
            $('.white_plash #midi-picture img').attr('src', midi_src);
            $('.price-layer .price').html(price);
            
			//console.log(quantity);
			if(quantity==0){
				if(!$('.white_plash .add-to-basket-me').hasClass("add-to-basket-me-none"))
					$('.white_plash .add-to-basket-me').addClass("add-to-basket-me-none");
			}
			else{
			//console.log($('.white_plash .add-to-basket-me').hasClass("add-to-basket-me-none"));
				//$('.white_plash .add-to-basket-me').removeClass("add-to-basket-me-none");
				if($('.white_plash .add-to-basket-me').hasClass("add-to-basket-me-none")){
					//console.log("del");
					$('.white_plash .add-to-basket-me').removeClass("add-to-basket-me-none");
				}
			}
			
            $('.white_plash .add-to-basket-me').attr('href', '/add-to-basket.php?action=ADD2BASKET&id='+product_id+'&quantity=1');            
        }        
    }
    // подкращиваем отсутвующие размеры и цвета на детальной при выборе цвето-размера
    $('.white_plash .ColorList .item').click(function(){
        var current_color_code = $(this).find('.current-color-code').html();
        var current_color = $(this).find('.current-color').html();

        selected_color_ajax = current_color_code;
        
        // проходим по размерам и смотрим какие существуют
        $('.white_plash .SizeList .item').removeClass('not-available')
        $('.white_plash .SizeList .item').each(function(){
            var current_size = $(this).find('.current-size').html();
            if (!arColorsSizesAJAX[current_color_code][current_size] > 0)
            {
                $(this).addClass('not-available');
            }
        })
        $('.white_plash .Color span').html(current_color);
        
        selected_product_ajax = CheckProductAJAX(selected_color_ajax, selected_size_ajax);
        if (selected_product_ajax > 0)
            DetailPageRefreshAJAX(selected_product_ajax) // обновляем страницу
    })

    // то же самое при клике по размерам
    $('.white_plash .SizeList .item').click(function(){
        var current_size = $(this).find('.current-size').html();

        selected_size_ajax = current_size;
        
        // проходим по размерам и смотрим какие существуют
        $('.white_plash .ColorList .item').removeClass('not-available')
        $('.white_plash .ColorList .item').each(function(){
            var current_color_code = $(this).find('.current-color-code').html();
            if (!arColorsSizesAJAX[current_color_code][current_size] > 0)
            {
                $(this).addClass('not-available');
            }
        })
        $('.white_plash .Size span').html(current_size);

        selected_product_ajax = CheckProductAJAX(selected_color_ajax, selected_size_ajax);
        if (selected_product_ajax > 0)
            // обновляем страницу
            DetailPageRefreshAJAX(selected_product_ajax) 
        
    })
    $('.white_plash .ColorList .item').eq(0).find('input').click();
    $('.white_plash .SizeList .item').eq(0).find('input').click();
    
    $('.white_plash .add-to-basket-me').fancybox({onComplete:function(){
		$("#add-to-basket-popup .exitpUp").click();
	}}); 
</script>



<?else:?>

    <?CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("Страница не найдена");?>

<?endif?>