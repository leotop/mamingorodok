/*
�������
�������� ������� ����������
//container_class - ����� ���������� �� ���������         !!!!!  ������������
//btn_prev_class - ����� ������ �����
//btn_next_class - ����� ������ ������
//delay_time - ����� ����� ������������� �������
//animate_time - �������� �������� ������������ �������   !!!!!  ������������
//visible - ���������� ������� �������                    !!!!!  ������������

!!! ���� �����-�� ��������� �� ������������ - ���������� false
*/

function fxSlider(container_class,btn_prev_class,btn_next_class,delay_time,animate_time,visible) {


    //������ ����������

    var div = $("." + container_class),   //������ ������ �� ������ ��� �������
    ul = $("ul", div),     //������ ��������� ��������
    tLi = $("li", ul),     //������� ��������
    tl = tLi.size(); //���������� ��������� � ��������
if(tl > 4){
    var animate_now = 0;  //���� ��������. ���� 0 - �� ����� ��������� ��������


    //������ ����� ��� ����������� ��������. �������� ����� �������������� �� ���� ����������� ul ������ ���������� div
    var div_width = (parseInt($(tLi).css("width")))*visible;
    $(ul).css({overflow:"hidden",position:"relative","list-style-type": "none","z-index": "1"});
    $(div).css({"width":div_width + "px",overflow: "hidden", position: "relative", "z-index": "2", left: "0px"})

    $(tLi).each(function(){
            $(this).css({"float":"left", "position":"relative","overflow":"hidden"})
    })

    //��������� ���� ��������� �������� 2 ����, ����� ������ ������� ��� � 3 ����������� (������: 123123123)
    
        $(ul).html($(ul).html() + $(ul).html() + $(ul).html());

    /*
    ul.prepend(tLi.slice(tl-v-1+1).clone())
    .append(tLi.slice(0,v).clone());
    start += v;
    */

    tLi = $("li", ul);

    //����� ��������� ���������� ���������, �������� ������ �� ������ �������� ������ ������
    var li = $("li", ul), itemLength = li.size();   //� �������� ����� ���������� ���������. ��� ������� ��� = ���������_����������*3

    //��������� ����� ������ ������ ����� ��� ��� �������� ������ � ���� ������
    var ul_width = itemLength*parseInt($(tLi).css("width"));

    //����������� ������ ����� ����� � ��������� �������� �����, ����� ��������� �������� ������ ����� ���������
    //������ 123[123]123  [] - ������� ���������
    $(ul).css({width:ul_width + "px", left: ul_width/3*-1 + "px"});




    //�������� �� ���������. 0 - ���������� ��������
    var auto_play_interval = 0;

    //���� ������ ����� �����������, ������� ��������
    if (delay_time != false) {
        auto_play_interval = setInterval(auto_play, delay_time);   //��� ��� �������
    }

    //���� ������ ������ ������ ����� � ������
    if (btn_prev_class != false && btn_next_class != false)  {
        //������������ ����� �� ������� ������ � �����
        $("."+btn_prev_class).click(function(){
                //��������� ������� �������
                if (animate_now == 0) {   //��������� �� ���������� �� � ������ ������ ��������
                    animate_now = 1;      //������ 1. ���� ������ ���������� = 1 - ������ �������� ����������� �� �����
                    if (parseInt($(ul).css("left")) == 0) {$(ul).css("left",ul_width/3*-1 + "px")}
                    //���� ������� �� ������ ����, ��������� ������� � �����, �������� ������ ������� ������� ���������
                    $(ul).animate({left:"+=" + $(tLi).css("width")},animate_time, function(){animate_now = 0});
                }
                //���� ����� ��������, �������� ��� � ������ ������
                if (auto_play_interval != 0) {
                    clearInterval(auto_play_interval);
                    auto_play_interval = setInterval(auto_play, delay_time);
                }
        })

        $("."+btn_next_class).click(function(){
                //��������� ������� �������
                if (animate_now == 0) {   //��������� �� ���������� �� � ������ ������ ��������
                    animate_now = 1;      //������ 1. ���� ������ ���������� = 1 - ������ �������� ����������� �� �����
                    //���� ������� �� ������� ����, ��������� ������� � �����
                    if (parseInt($(ul).css("left"))*-1 == (parseInt($(ul).css("width")))-visible*parseInt($(tLi).css("width"))) {$(ul).css("left",(ul_width/3*-1)-(tl - visible)*parseInt($(tLi).css("width")) + "px")}
                    $(ul).animate({left:"-=" + $(tLi).css("width")},animate_time, function(){animate_now = 0});
                }
                //���� ����� ��������, �������� ��� � ������ ������
                if (auto_play_interval != 0) {
                    clearInterval(auto_play_interval);
                    auto_play_interval = setInterval(auto_play, delay_time);
                }
        })

    }

     //������� �����������
     function auto_play() {
        $("."+btn_next_class).click(); //��������� ���� �� ������ "��������� �������"
    }
    }
}