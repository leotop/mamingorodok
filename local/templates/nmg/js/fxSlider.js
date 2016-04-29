/*
слайдер
описание входных параметров
//container_class - класс контейнера со слайдером         !!!!!  обязательный
//btn_prev_class - класс кнопки влево
//btn_next_class - класс кнопки вправо
//delay_time - время между переключением слайдов
//animate_time - скорость анимации переключения слайдов   !!!!!  обязательный
//visible - количество видимых слайдов                    !!!!!  обязательный

!!! если какие-то параметры не используются - выставлять false
*/

function fxSlider(container_class,btn_prev_class,btn_next_class,delay_time,animate_time,visible) {


    //задаем переменные

    var div = $("." + container_class),   //задаем ссылки на нужные нам объекты
    ul = $("ul", div),     //список элементов слайдера
    tLi = $("li", ul),     //элемент слайдера
    tl = tLi.size(); //количество элементов в слайдере
if(tl > 4){
    var animate_now = 0;  //факт анимации. если 0 - то можно запускать действие


    //задаем стили для компонентов слайдера. смещение будет осуществляться за счет перемещения ul внутри контейнера div
    var div_width = (parseInt($(tLi).css("width")))*visible;
    $(ul).css({overflow:"hidden",position:"relative","list-style-type": "none","z-index": "1"});
    $(div).css({"width":div_width + "px",overflow: "hidden", position: "relative", "z-index": "2", left: "0px"})

    $(tLi).each(function(){
            $(this).css({"float":"left", "position":"relative","overflow":"hidden"})
    })

    //дублируем наши начальные элементы 2 раза, чтобы каждый элемент был в 3 экземплярах (пример: 123123123)
    
        $(ul).html($(ul).html() + $(ul).html() + $(ul).html());

    /*
    ul.prepend(tLi.slice(tl-v-1+1).clone())
    .append(tLi.slice(0,v).clone());
    start += v;
    */

    tLi = $("li", ul);

    //после изменения количества элементов, получаем ссылку на объект элемента списка заново
    var li = $("li", ul), itemLength = li.size();   //и получаем новое количество элементов. как правило оно = начальное_количество*3

    //вычисляем новую ширину списка чтобы все его элементы влезли в одну строку
    var ul_width = itemLength*parseInt($(tLi).css("width"));

    //присваиваем списку новую длину и начальное смещение влево, чтобы посредине оказался второй набор элементов
    //пример 123[123]123  [] - область видимости
    $(ul).css({width:ul_width + "px", left: ul_width/3*-1 + "px"});




    //интервал по умолчанию. 0 - автоскролл выключен
    var auto_play_interval = 0;

    //если задано время автоскролла, создаем интервал
    if (delay_time != false) {
        auto_play_interval = setInterval(auto_play, delay_time);   //тут все понятно
    }

    //если заданы классы кнопок влево и вправо
    if (btn_prev_class != false && btn_next_class != false)  {
        //обрабатываем клики по кнопкам вперед и назад
        $("."+btn_prev_class).click(function(){
                //проверяем текущую позицию
                if (animate_now == 0) {   //проверяем не происходит ли в данный момент анимации
                    animate_now = 1;      //ставим 1. пока данная переменная = 1 - другие действия выполняться не будут
                    if (parseInt($(ul).css("left")) == 0) {$(ul).css("left",ul_width/3*-1 + "px")}
                    //если доехали до левого края, смещаемся обратно в центр, применив хитрую формулу расчета положения
                    $(ul).animate({left:"+=" + $(tLi).css("width")},animate_time, function(){animate_now = 0});
                }
                //если задан интервал, обнуляем его и задаем заново
                if (auto_play_interval != 0) {
                    clearInterval(auto_play_interval);
                    auto_play_interval = setInterval(auto_play, delay_time);
                }
        })

        $("."+btn_next_class).click(function(){
                //проверяем текущую позицию
                if (animate_now == 0) {   //проверяем не происходит ли в данный момент анимации
                    animate_now = 1;      //ставим 1. пока данная переменная = 1 - другие действия выполняться не будут
                    //если доехали до правого края, смещаемся обратно в центр
                    if (parseInt($(ul).css("left"))*-1 == (parseInt($(ul).css("width")))-visible*parseInt($(tLi).css("width"))) {$(ul).css("left",(ul_width/3*-1)-(tl - visible)*parseInt($(tLi).css("width")) + "px")}
                    $(ul).animate({left:"-=" + $(tLi).css("width")},animate_time, function(){animate_now = 0});
                }
                //если задан интервал, обнуляем его и задаем заново
                if (auto_play_interval != 0) {
                    clearInterval(auto_play_interval);
                    auto_play_interval = setInterval(auto_play, delay_time);
                }
        })

    }

     //функция автоскролла
     function auto_play() {
        $("."+btn_next_class).click(); //имитируем клик по кнопке "следующий элемент"
    }
    }
}