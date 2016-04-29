<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}
$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");



?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>

<div class="bx_order_make">
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{  
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");

			}
		}
		else
		{
			?>
			<script type="text/javascript">

            new_adress_click = false;  // значение кнопки нового адреса доставки по умолчанию
            
			<?if(CSaleLocation::isLocationProEnabled()):?>

				<?
				// spike: for children of cities we place this prompt
				$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
				?>

				BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
					'source' => $this->__component->getPath().'/get.php',
					'cityTypeId' => intval($city['ID']),
					'messages' => array(
						'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
						'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
						'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
							'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
							'#ANCHOR_END#' => '</a>'
						)).'</div>'
					)
				))?>);

			<?endif?>

			var BXFormPosting = false;
			function submitForm(val)
			{   
				if (BXFormPosting === true)
					return true;

				BXFormPosting = true;
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				BX.showWait();

				<?if(CSaleLocation::isLocationProEnabled()):?>
					BX.saleOrderAjax.cleanUp();
				<?endif?>

				BX.ajax.submit(orderForm, ajaxResult);

				return true;
			}
        
			function ajaxResult(res)
			{
				var orderForm = BX('ORDER_FORM');
				try
				{
					// if json came, it obviously a successfull order submit

					var json = JSON.parse(res);
					BX.closeWait();

					if (json.error)
					{
						BXFormPosting = false;
						return;
					}
					else if (json.redirect)
					{
						window.top.location.href = json.redirect;
					}
				}
				catch (e)
				{
					// json parse failed, so it is a simple chunk of html

					BXFormPosting = false;
					BX('order_form_content').innerHTML = res;

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.initDeferredControl();
					<?endif?>
				}

				BX.closeWait();
				BX.onCustomEvent(orderForm, 'onAjaxSuccess');
                change();
                $('.reviews select').styler();
                var heightLogotipe = $('.bx_section.delivery').height()-166;
                $('.delivery .bx_logotype').css('height', heightLogotipe);
               // $("#ORDER_FORM > .section").css("display", "none");
                if($('#ORDER_PROP_2').val() =="" || $('#ORDER_PROP_3').val() ==""){
                    $('.mandatory_fields').css("display", "block"); 
                }else{
                    $('.mandatory_fields').css("display", "none"); 
                } 
                 $("#ORDER_PROP_2, #ORDER_PROP_3").blur(function(){ 
                    if($('#ORDER_PROP_2').val() =="" || $('#ORDER_PROP_3').val() ==""){
                        $('.mandatory_fields').css("display", "block"); 
                    }else{
                        $('.mandatory_fields').css("display", "none"); 
                    }  
                 })
                     $( "#ORDER_PROP_6" ).blur(function () {  // сохраняет записанный пользователем адрес в сессии                                                
                        value_id = $('#ORDER_PROP_6').val();      // передаёт значение из переменной "адрес"
                        id_delivery = $('.label_dat.active_delivery').attr('for');  // передает id  текущего способа доставки
                        $.ajax({
                            type: "POST",
                            url: "/bitrix/templates/nmg/ajax/order_adress.php",
                            data: {value_id:value_id, id_delivery:id_delivery},
                        })
                    })                                                    
                 
                 $("#ORDER_PROP_3").inputmask("8-999-999-99-99");    // подключаем маску телефона к полю "теелфон" оформления заказа
                
                
                $('.bx_section.adress_pole').hover(function(){       // отключает пеерход по службам доставки при незаполненном поле города
                     if($('.bx-ui-sls-fake').attr('title') == ""){
                         $('.city_null').html('Введите название города');
                         $('.bx-ui-sls-fake').focus(); 
                         $('.label_dat').removeAttr('onclick');    
                         $('.label_dat').removeAttr('for');  
                         $('.bx_ordercart_order_pay_center a').removeAttr('onclick');
                         $('.bx_description label').removeAttr('onclick');
                     }else{
                         $('.bx_ordercart_order_pay_center a').attr("onclick","submitForm('Y'); return false;");     
                     }
                })  
                if(new_adress_click == false){
                    $('.create_new_adress').show();    // открытие кнопки нового заказа при неактивном флаге
                    $('#sale_order_props').hide();    // скрытие формы адреса доставки при неактивном флаге    
                }
                
                $(function(){  
                    $("#wrap_left .prof").click(function(){
                        var new_adress_click = $(this).attr('for');
                        $.ajax({
                            type: "POST",
                            url: "/bitrix/templates/nmg/ajax/new_adress_click.php",
                            data: {new_adress_click:new_adress_click}, 
                        })   
                    })
                })      
			}

			function SetContact(profileId)
			{
               // $('#wrap_left label').addClass('active_location');
				BX("profile_change").value = "Y";
				submitForm();
                
			}
              
            function change(){       
                  $('.more').on("click",function(){
                        $('.wrap_pay, .wrap_fon').show(); 
                        $('.header,.wrap-sk-menu-abc,.sk-menu,#order_form_content > label, #order_form_content > h4,.bx_section delivery,.element_date,.bx_section > h4,.bx_section > p, .bx_block,.delivery').css({'-webkit-filter':'blur(3px)'})   
                  })
                  $('#close_wrap_pay').on("click",function(){
                        $('.wrap_pay, .wrap_fon').hide(); 
                        $('.header,.wrap-sk-menu-abc,.sk-menu,#order_form_content > label, #order_form_content > h4,.bx_section delivery,.element_date,.bx_section > h4,.bx_section > p, .bx_block,.delivery').css({'-webkit-filter':'blur(0px)'}) 
                  })
                  
                  $('.exit_sale a').on("click",function(){
                        $('.wrap_pay_exit_sale, .wrap_fon').show(); 
                        $('.header,.wrap-sk-menu-abc,.sk-menu,#order_form_content > label, #order_form_content > h4,.bx_section delivery,.element_date,.bx_section > h4,.bx_section > p, .bx_block,.delivery').css({'-webkit-filter':'blur(3px)'})   
                  })
                  $('#close_wrap_sale, .bx_description_pay').on("click",function(){
                        $('.wrap_pay_exit_sale, .wrap_fon').hide(); 
                        $('.header,.wrap-sk-menu-abc,.sk-menu,#order_form_content > label, #order_form_content > h4,.bx_section delivery,.element_date,.bx_section > h4,.bx_section > p, .bx_block,.delivery').css({'-webkit-filter':'blur(0px)'}) 
                  })

                    var elWrap = $('.slider_pay'), 
                        el =  elWrap.find('div.wrap_pay_slide'),
                        indexImg = 1,
                        indexMax = el.length;
                        
                    var elWrap_2 = $('.krug ul'),
                        el2 = elWrap_2.find('.li_wrap_pay_1'),
                        indexImg2 = 1,
                        indexMax2 = el2.length;
                        
                 function slider(){
                        el.fadeOut(100);
                        el2.removeClass('li_wrap_pay');
                        el.filter(':nth-child('+indexImg+')').fadeIn(500);
                        el2.filter(':nth-child('+indexImg2+')').addClass('li_wrap_pay');
                 }
                    $('.strelka_right').on("click", function() {
                        indexImg++;
                        if(indexImg > indexMax) {
                            indexImg = 1;
                        } 
                        indexImg2++;
                        if(indexImg2 > indexMax2) {
                            indexImg2 = 1; 
                        }  
                        slider();
                    });
                    $('.strelka_left').on("click", function() {
                        indexImg--;
                        if(indexImg < 1) {
                            indexImg = indexMax; 
                        }
                        indexImg2--;
                        if(indexImg2 < 1) {
                            indexImg2 = indexMax2; 
                        }
                        slider();
                    }); 
              }
               $(function(){
                   $('.reviews .element_date select').styler();
                   change();
                    var heightLogotipe = $('.bx_section.delivery').height()-166;
                    $('.delivery .bx_logotype').css('height', heightLogotipe);
                     
                   
               }) 

			</script>
            
            
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}

			if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
			{
				?>
				<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
				<?
			}

			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);
				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}
            //arshow($arParams["DELIVERY_TO_PAYSYSTEM"]);
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
			if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
			}
			else
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
			}

			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>

			<?if($_POST["is_ajax_post"] != "Y")
			{                      
				?>  
                </div>
                <div class="wrap_pay_exit_sale">
                      <h3>Отказ от заказа</h3>
                      <div id="close_wrap_sale"></div>
                      <div class="refusal_to_order">
                      <p>Отказ от заказа оплачивается в том случае, если товар соответствует позициям в заказе, но вы при этом отказываетесь от заказа полностью. </p>
                      <p>При отказе от заказа (если товар соотвествует заказанным позициям) частично, оплата за доставку приозводится следующим образом: </p>  
                      <strong>1. сумма выкупленных из заказа товаров, меньше 5000 руб., то доставка оплачивается в соответствии с тарифами на доставку.</strong>  
                      <ul>   
                            <li><p>Сумма заказа                         Стоимость доставки (основной тариф. в пределах МКАД)</p></li>
                            <li><p>До 1500 руб..................................................500 руб.</p></li>
                            <li><p>От 1500 руб. до 3000 руб. ..........................350 руб.</p></li>
                            <li><p>От 3000 руб. до 5000 руб.   ..........................200 руб. </p></li> 
                            <li><p>От 5000 руб.  ................................................Бесплатно </p></li> 
                            <li><p>Доставка рассчитывается как основной тариф, плюс оплата за километраж от МКАД (в расчете 30 руб. за километр) </p></li> 
                        </ul>
                        <strong>2. сумма выкупленных из заказа товаров, боолее 5000 руб., то доставка по прежнему остается бесплатной. </strong>   
                     </div>
                 </div> 
                <div class="ordering">
                    <textarea placeholder="Здесь можно указать любые комментарии к заказу ..." name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" ><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
                    <input type="hidden" name="" value="">
                    <div style="clear: both;"></div>
					    <input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					    <input type="hidden" name="profile_change" id="profile_change" value="N">
					    <input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					    <input type="hidden" name="json" value="Y">
					<div class="bx_ordercart_order_pay_center">
                    <a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="checkout"><?=GetMessage("SOA_TEMPL_BUTTON")?></a>
                    <a href="javascript:void();" onclick="window.history.back();" class="back">Вернуться назад в корзину</a>
                    </div>
                     
                </div>
             </div> 
                 
              <?
                global $city_val;
                
              ?>
              <input type="hidden" id="city_val" value="<?=$city_val?>">  
                </form>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
		}
	}
	?>
	</div>
</div>

<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps", 
			".default", 
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.search", 
			".default", 
			array(
			),
			false
		);?>
	</div>

<?endif?>