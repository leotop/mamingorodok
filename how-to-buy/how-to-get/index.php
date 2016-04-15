<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тарифы и сроки доставки, подъема, сборки");
$APPLICATION->SetPageProperty("description", "Информация о том, как получить заказ.");
?>
    <?//CEvent::Send("AVAIL_NOTIFY","s1",array(),"N",77);?>
    <script type="text/javascript">
        (function($){
            $(function(){
                console.log("ready");
                $(".spoiler").click(function(e)
                {
                    var $content = $(this).next();
                    
                    $content.slideToggle("normal");   
                    $(this).toggleClass("active");
                                    
                    return false;
                });  
        $(function(){
            $(".spoiler_slide_1").click(function(){ 
                $('.slide_1').fadeIn("show"); 
                $('.slide_2').fadeOut("show");
                $(this).addClass("active"); 
                $(this).next().removeClass("active"); 
            }); 
            $(".spoiler_slide_2").click(function(){
             $('.slide_2').fadeIn("show"); 
             $('.slide_1').fadeOut("show"); 
             $(this).addClass("active"); 
             $(this).prev().removeClass("active"); 
            }); 
        }) 
            })
        })(jQuery);    
    </script>

    <style type="text/css">
         .content.slide_1{
             display: block;
         }   
        .spoiler
        {
        cursor: pointer;
          font-size: 16px;
          background: url(/bitrix/templates/nmg/img/delivery_text-shadow.png) no-repeat 50% 0%;
          padding-bottom: 15px;
          padding-top: 10px;
          background-repeat: no-repeat;
          padding-right: 30px;
          position: relative;
        }
        .spoiler b u
        {
          text-decoration: none;  
        }  
    /*    .spoiler.active
        {
            background-image: url(/bitrix/templates/nmg/img/up-btn-ico.png);   
        }   */
        
        section.content
        {
            margin-left: 20px;
            display: none;
            font-size: 16px;
            padding-right: 30px;
              padding-bottom: 10px;
            
        }
    </style>
     
    <h5><span> 
        <br />
       </span></h5>
     
    <h5 style="text-align: center;"><span>Уважаемые покупатели! Мы доставим ваш заказ по всей территории РФ оперативно и безо всяких скрытых наценок. Просто укажите ваш адрес при формировании заказа и обговорите с оператором детали доставки. </span></h5>
          
        <h1 class="spoiler_slide spoiler_slide_1 active"><span >По Москве и МО:</span></h1>    

        <h1 class="spoiler_slide spoiler_slide_2"><span >Доставка по регионам РФ:</span></h1>
<div id="ramka_fon"> 
<div id="frame_fon">   
    <section class="content slide_1">      
     
    <div class="spoiler"><b class="purple"><u>Сроки доставки по Москве и МО</u></b></div>

    <section class="content "> 
    <div><b class="purple"><u> 
          
         </u></b></div>
     
    <span>Курьерская доставка по Москве и МО осуществляется на следующий день после заказа </span><span> </span><span>с 12:00 до 20:00 </span><span>c понедельника по субботу, кроме праздничных дней, при условии, что заказ оформлен до 17:00 текущего дня. В отдельных случаях возможна доставка и в день заказа. При этом оплату можно передать курьеру при получения товара.</span>

    </section> 

    <div class="spoiler"><b class="purple"><u>Стоимость доставки для Москвы (в пределах МКАД)</u></b></div> 

    <section class="content ">      
    <br />
     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>Сумма заказа                         Стоимость доставки (основной тариф)</div>
     </blockquote> 
     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>До 1500 руб.                                    500 руб.</div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>От 1500 руб. до 3000 руб.              350 руб.</div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>От 3000 руб. до 5000 руб.              200 руб. </div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>От 5000 руб.                                 Бесплатно</div>
     </blockquote> 

    <span>  Доставка рассчитывается как основной тариф, плюс оплата за километраж от МКАД (в расчете 30 руб. за километр) </span>
    <br>
    </section>
     
    <div class="spoiler"><b class="purple"><u>Стоимость доставки для Московской области (удаленность не более 50 км от МКАД)</u></b></div>
    <section class="content"> 
     
    <div><span>Доставка рассчитывается как основной тариф, плюс оплата за километраж от МКАД исходя из удаленности:</span></div>
     

     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div><span>Удаленность от МКАД                                 Стоимость за километр</span></div>
     
      <div><span> 
          <br />
         </span></div>
     
      <div><span>            До 10 км                                                          30 руб.</span></div>
     
      <div><span>    От 10 км до 30 км                                                   35 руб.</span></div>
     
      <div><span>    От 30 км до 50 км                                                   40 руб.                                             </span></div>
     </blockquote> 

      
    </section>

     <div class="spoiler"><b class="purple"><u>Подъем тяжелых и крупногабаритных предметов</u></b> </div>
     <section class="content"> 
    <div> 
      
     <span>Доставка товаров осуществляется до квартиры. </span></div>
     
    <div><span> 
        <br />
       </span></div>
     
    <div><span>Исключением является:</span></div>
     
    <div><span>- мебель (кроватки, комоды и шкафы),</span></div>
     
    <div><span>- некоторые модели колясок (трансформеры, 2в1, 3в1),</span></div>
     
    <div><span>- уличные крупногабаритные горки и домики. </span></div>
     
    <div><span> 
        <br />
       </span></div>
     
    <div><span>Для них доставка осуществляется до подъезда, далее подъем платный. </span> 
      <br />
     
      <br />
     <u>Подъем крупногабаритных товаров до двери вашей квартиры оплачивается отдельно от тарифов доставки. </u> 
      <br />
          
      <br />
          
      <ul>          
        <li>                         Подъем                                                       С лифтом                     Без лифта</li>
       
        <li>Кроватки,  коляски-трансформеры, комоды до 30 кг     .   100 р.                 100р. каждый этаж</li>
       
        <li>Кроватки-трансформеры, коляски 2в1 и 3в1                       200р                   200р. каждый этаж</li>
       
        <li>Комоды свыше 30кг.                                                              300 р.                 300р. каждый этаж</li>
       
        <li>Шкафы, ящики для игрушек                                                 500 р.                 500р. каждый этаж</li>
       
        <li><span>Горки и домики свыше 15кг.                                                 200 р.                 200р. каждый этаж</span></li>
       
        <li> 
          <br />
         </li>
       
        <li><span>Пожалуйста, обратите внимание, что некоторые товары могут быть упакованы в 2 коробках &ndash; в этом случае стоимость подъема рассчитывается за каждую коробку. </span></li>
       </ul>
     
     
      </section>
      <div class="spoiler"><b class="purple"><u>Сборка</u></b></div>
       <section class="content">
     
     
     
      <ul> 
        <li>Сборка                                       Стоимость</li>
       
        <li>Кроватка без маятника            1000 р.</li>
       
        <li>Кроватка маятник                    1500 р.</li>
       
        <li>Кроватка-трансформер            2300 р.</li>
       
        <li>Комод                                        2000р.</li>
       
        <li>Шкаф                                         2500 р.</li>
       
        <li> 
          <br />
         </li>
       
        <li>Стоимость сборки коляски/манежа/качелей/стульчика для кормления 300 р.</li>
           </ul>
          
      <div> 
        <br />
       </div>
       </section>
       </section>
     
      
       <section class="content slide_2">
     
      <div><span style="font-size: 24px;"> 
         
         </span></div>
     
      <div><b class="purple"><span style=" font-weight: normal;">Если в вашем городе нет определенной кроватки, коляски, автокресла или другого товара, и вы решили воспользоваться услугами нашего магазина, то мы с радостью поможем организовать доставку заказа в любой регион России. </span> 
          <br style="font-weight: normal;" />
         
          <br style="font-weight: normal;" />
         <span style=" font-weight: normal;">При этом все расходы будут абсолютно прозрачными: мы доставляем ваш товар до выбранной транспортной компании по цене доставки по Москве. </span></b></div>
     
      <div><span class="purple">За доставку от приемного пункта в Москве до пункта выдачи в вашем городе или до вашей квартиры вы рассчитываетесь непосредственно с транспортной компанией. </span></div>

      <div><span class="purple">
          <br />
        </span></div>

      <div><span class="purple">Внимание! Доставка товара в регоины РФ производится только после 100% предоплаты заказа. Оплачивается заказ и, при необходимости, доставка до ТК (по основному тарифу).</span></div>
     
      <div><span class="purple"> 
          <br style="font-weight: normal;" />
         <span>Мы работаем со следующими транспортными компаниями:</span></span></div>
     
      <div><span class="purple"><span>- ПЭК - </span></span><noindex><a href="http://pecom.ru/ru/calc/" title="Калькулятор ПЭК" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор ПЭК</a></noindex></div>
     
      <div><span class="purple"><span>- Автотрейдинг - </span></span><noindex><a href="http://www.ae5000.ru/" title="Калькулятор Автотрейдинг" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор Автотрейдинг</a></noindex></div>
     
      <div><span class="purple"><span>- Деловые линии - </span></span><noindex><a href="http://www.dellin.ru/" title="Калькулятор Деловые линии" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор Деловых линий</a></noindex></div>
     
      <div><span class="purple"><span>- Желдор - </span></span><noindex><a href="http://www.jde.ru/online/calculator.html" title="Калькулятор Желдор" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор Желдор</a></noindex></div>
     
      <div><span class="purple"><span>- КИТ - </span></span><noindex><a href="http://tk-kit.ru/calculate/" title="Калькулятор КИТ" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор КИТ</a></noindex></div>
     
      <div><span class="purple"><span>- СДЭК - </span></span><noindex><a href="http://www.edostavka.ru/calculator.html" target="_blank" rel="nofollow" >рассчитать стоимость доставки через калькулятор СДЭК</a></noindex></div>
     
      <div><b class="purple"><u> 
            
           </u></b></div>
     
      <div class="spoiler"><b class="purple"><u>Доставка до приемного пункта транспортной компании в Москве (в пределах МКАД)</u></b></div> 
        <section class="content">

       <blockquote style="margin-left: 40px; border-style: none;"> 
          <div>Сумма заказа             Стоимость доставки (основной тариф)</div>
         </blockquote> 
        <div> </div>
       <blockquote style="margin-left: 40px; border-style: none; "> 
          <div>До 1500 руб.                      500 руб.</div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>От 1500 руб. до 3000 руб.               350 руб.</div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>От 3000 руб. до 5000 руб.               200 руб. </div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>От 5000 руб.                     Бесплатно</div>
         </blockquote></div>
     

      </section>
      <div class="spoiler"><b class="purple"><u>Доставка до приемного пункта транспортной компании в Москве (за пределы МКАД, но не более, чем 10 км)</u></b></div> 
      <section class="content">  
        
       <span>Доставка рассчитывается как основной тариф доставки до приемного пункта в Москве, плюс оплата за километраж от МКАД (в расчете 30 руб. за километр)</span> 
        <br />
       
     
      <div><span> 
          <br />
         </span></div>
       </section>
     
      <div class="spoiler"><b class="purple"><u>Сроки отправки заказа в транспортную компанию:</u></b></div>
      <section class="content">
     
      <div><span>Отправка в регионы осуществляется на следующий день после получения предоплаты,  с 12:00 до 20:00.</span></div>
     
      <div><span>В отдельных случаях возможна доставка до приемного пункта ТК и в день заказа (по согласованию с менеджером)</span></div>
     
      <div> 
        <br />
       </div>
       </section>
     
      <div><b class="purple"><u>Внимание! Рекомендуем обрешетку!</u></b></div>
     
      <div><b class="purple"><u> 
            <br />
           </u></b></div>
     
      <div><span>Уважаемые клиенты, мы заботимся о том, чтобы ваш заказ был доставлен в целости и сохранности. Именно поэтому мы рекомендуем дополнительно заказывать для перевозки вашего груза обрешетку – это гарантирует сохранность груза, а значит, и 100% удовлетворенность от покупки. </span></div>
     
      <div><span> 
          <br />
         </span></div>
     
      <div><span><u><i>Обрешетка</i></u> представляет собой вид жесткой упаковки, при которой предварительно обернутый в мягкую упаковку груз закрывается деревянными решетками-каркасом, которые для прочности укрепляются металлической окантовочной лентой.</span></div>
     </div>
     
     </section>
 </div>
</div> 
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>