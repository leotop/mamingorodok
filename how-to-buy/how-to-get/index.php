<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������ � ����� ��������, �������, ������");
$APPLICATION->SetPageProperty("description", "���������� � ���, ��� �������� �����.");
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
     
    <h5 style="text-align: center;"><span>��������� ����������! �� �������� ��� ����� �� ���� ���������� �� ���������� � ���� ������ ������� �������. ������ ������� ��� ����� ��� ������������ ������ � ���������� � ���������� ������ ��������.�</span></h5>
          
        <h1 class="spoiler_slide spoiler_slide_1 active"><span >�� ������ � ��:</span></h1>    

        <h1 class="spoiler_slide spoiler_slide_2"><span >�������� �� �������� ��:</span></h1>
<div id="ramka_fon"> 
<div id="frame_fon">   
    <section class="content slide_1">      
     
    <div class="spoiler"><b class="purple"><u>����� �������� �� ������ � ��</u></b></div>

    <section class="content "> 
    <div><b class="purple"><u> 
          
         </u></b></div>
     
    <span>���������� �������� �� ������ � �� �������������� �� ��������� ���� ����� ������</span><span>�</span><span>� 12:00 �� 20:00�</span><span>c ������������ �� �������, ����� ����������� ����, ��� �������, ��� ����� �������� �� 17:00 �������� ���. � ��������� ������� �������� �������� � � ���� ������. ��� ���� ������ ����� �������� ������� ��� ��������� ������.</span>

    </section> 

    <div class="spoiler"><b class="purple"><u>��������� �������� ��� ������ (� �������� ����)</u></b></div> 

    <section class="content ">      
    <br />
     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>����� ������ � � � � � � � � � � � � ��������� �������� (�������� �����)</div>
     </blockquote> 
     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>�� 1500 ���. � � � � � � � � � � � � � � � � � �500 ���.</div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>�� 1500 ���. �� 3000 ���. � � � � � � �350 ���.</div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>�� 3000 ���. �� 5000 ���. � � � � � � �200 ���.�</div>
     </blockquote><blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div>�� 5000 ���. � � � � � � � � � � � � � � � � ���������</div>
     </blockquote> 

    <span>  �������� �������������� ��� �������� �����, ���� ������ �� ���������� �� ���� (� ������� 30 ���. �� ��������) </span>
    <br>
    </section>
     
    <div class="spoiler"><b class="purple"><u>��������� �������� ��� ���������� ������� (����������� �� ����� 50 �� �� ����)</u></b></div>
    <section class="content"> 
     
    <div><span>�������� �������������� ��� �������� �����, ���� ������ �� ���������� �� ���� ������ �� �����������:</span></div>
     

     <blockquote style="margin: 0px 0px 0px 40px; border: none; padding: 0px;"> 
      <div><span>����������� �� ���� � � � � � � � � � � � � � � � � ��������� �� ��������</span></div>
     
      <div><span> 
          <br />
         </span></div>
     
      <div><span>� � � � � � �� 10 �� � � � � � � � � � � � � � � � � � � � � � � � � � � � � �30 ���.</span></div>
     
      <div><span>� � �� 10 �� �� 30 �� � � � � � � � � � � � � � � � � � � � � � � � � � 35 ���.</span></div>
     
      <div><span>� � �� 30 �� �� 50 �� � � � � � � � � � � � � � � � � � � � � � � � � � 40 ���. � � � � � � � � � � � � � � � � � � � � � ��</span></div>
     </blockquote> 

      
    </section>

     <div class="spoiler"><b class="purple"><u>������ ������� � ���������������� ���������</u></b> </div>
     <section class="content"> 
    <div> 
      
     <span>�������� ������� �������������� �� ��������.�</span></div>
     
    <div><span> 
        <br />
       </span></div>
     
    <div><span>����������� ��������:</span></div>
     
    <div><span>- ������ (��������, ������ � �����),</span></div>
     
    <div><span>- ��������� ������ ������� (������������, 2�1, 3�1),</span></div>
     
    <div><span>- ������� ���������������� ����� � ������.�</span></div>
     
    <div><span> 
        <br />
       </span></div>
     
    <div><span>��� ��� �������� �������������� �� ��������, ����� ������ �������.�</span> 
      <br />
     
      <br />
     <u>������ ���������������� ������� �� ����� ����� �������� ������������ �������� �� ������� ��������.�</u> 
      <br />
          
      <br />
          
      <ul>          
        <li>� � � � � � � � � � � � ������� � � � � � � � � � � � � � � � � � � � � � � � � � � � � ������ � � � � � � � � � � ��� �����</li>
       
        <li>��������, ��������-������������, ������ �� 30 �� � � . � 100 �. � � � � � � � � 100�. ������ ����</li>
       
        <li>��������-������������, ������� 2�1 � 3�1 � � � � � � � � � � � 200� � � � � � � � � � 200�. ������ ����</li>
       
        <li>������ ����� 30��. � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � �300 �. � � � � � � � � 300�. ������ ����</li>
       
        <li>�����, ����� ��� ������� � � � � � � � � � � � � � � � � � � � � � � � � 500 �. � � � � � � � � 500�. ������ ����</li>
       
        <li><span>����� � ������ ����� 15��. � � � � � � � � � � � � � � � � � � � � � � � � 200 �. � � � � � � � � 200�. ������ ����</span></li>
       
        <li> 
          <br />
         </li>
       
        <li><span>����������, �������� ��������, ��� ��������� ������ ����� ���� ��������� � 2 �������� &ndash; � ���� ������ ��������� ������� �������������� �� ������ �������.�</span></li>
       </ul>
     
     
      </section>
      <div class="spoiler"><b class="purple"><u>������</u></b></div>
       <section class="content">
     
     
     
      <ul> 
        <li>������ � � � � � � � � � � � � � � � � � � � ���������</li>
       
        <li>�������� ��� �������� � � � � � �1000 �.</li>
       
        <li>�������� ������� � � � � � � � � � �1500 �.</li>
       
        <li>��������-����������� � � � � � �2300 �.</li>
       
        <li>����� � � � � � � � � � � � � � � � � � � � �2000�.</li>
       
        <li>���� � � � � � � � � � � � � � � � � � � �  �2500 �.</li>
       
        <li> 
          <br />
         </li>
       
        <li>��������� ������ �������/������/�������/��������� ��� ��������� 300 �.</li>
           </ul>
          
      <div> 
        <br />
       </div>
       </section>
       </section>
     
      
       <section class="content slide_2">
     
      <div><span style="font-size: 24px;"> 
         
         </span></div>
     
      <div><b class="purple"><span style=" font-weight: normal;">���� � ����� ������ ��� ������������ ��������, �������, ���������� ��� ������� ������, � �� ������ ��������������� �������� ������ ��������, �� �� � �������� ������� ������������ �������� ������ � ����� ������ ������.�</span> 
          <br style="font-weight: normal;" />
         
          <br style="font-weight: normal;" />
         <span style=" font-weight: normal;">��� ���� ��� ������� ����� ��������� �����������: �� ���������� ��� ����� �� ��������� ������������ �������� �� ���� �������� �� ������.�</span></b></div>
     
      <div><span class="purple">�� �������� �� ��������� ������ � ������ �� ������ ������ � ����� ������ ��� �� ����� �������� �� ��������������� ��������������� � ������������ ���������.�</span></div>

      <div><span class="purple">
          <br />
        </span></div>

      <div><span class="purple">��������! �������� ������ � ������� �� ������������ ������ ����� 100% ���������� ������. ������������ ����� �, ��� �������������, �������� �� �� (�� ��������� ������).</span></div>
     
      <div><span class="purple"> 
          <br style="font-weight: normal;" />
         <span>�� �������� �� ���������� ������������� ����������:</span></span></div>
     
      <div><span class="purple"><span>- ��� -�</span></span><noindex><a href="http://pecom.ru/ru/calc/" title="����������� ���" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ���</a></noindex></div>
     
      <div><span class="purple"><span>- ������������ -�</span></span><noindex><a href="http://www.ae5000.ru/" title="����������� ������������" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ������������</a></noindex></div>
     
      <div><span class="purple"><span>- ������� ����� -�</span></span><noindex><a href="http://www.dellin.ru/" title="����������� ������� �����" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ������� �����</a></noindex></div>
     
      <div><span class="purple"><span>- ������ -�</span></span><noindex><a href="http://www.jde.ru/online/calculator.html" title="����������� ������" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ������</a></noindex></div>
     
      <div><span class="purple"><span>- ��� -�</span></span><noindex><a href="http://tk-kit.ru/calculate/" title="����������� ���" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ���</a></noindex></div>
     
      <div><span class="purple"><span>- ���� -�</span></span><noindex><a href="http://www.edostavka.ru/calculator.html" target="_blank" rel="nofollow" >���������� ��������� �������� ����� ����������� ����</a></noindex></div>
     
      <div><b class="purple"><u> 
            
           </u></b></div>
     
      <div class="spoiler"><b class="purple"><u>�������� �� ��������� ������ ������������ �������� � ������ (� �������� ����)</u></b></div> 
        <section class="content">

       <blockquote style="margin-left: 40px; border-style: none;"> 
          <div>����� ������ � � � � � ����������� �������� (�������� �����)</div>
         </blockquote> 
        <div> </div>
       <blockquote style="margin-left: 40px; border-style: none; "> 
          <div>�� 1500 ���. � � � � � � � � � � �500 ���.</div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>�� 1500 ���. �� 3000 ���.� � � � � � � �350 ���.</div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>�� 3000 ���. �� 5000 ���.� � � � � � � �200 ���.�</div>
         </blockquote><blockquote style="margin-left: 40px; border-style: none; "> 
          <div>�� 5000 ���.� � � � � � � � � � ����������</div>
         </blockquote></div>
     

      </section>
      <div class="spoiler"><b class="purple"><u>�������� �� ��������� ������ ������������ �������� � ������ (�� ������� ����, �� �� �����, ��� 10 ��)</u></b></div> 
      <section class="content">  
        
       <span>�������� �������������� ��� �������� ����� �������� �� ��������� ������ � ������, ���� ������ �� ���������� �� ���� (� ������� 30 ���. �� ��������)</span> 
        <br />
       
     
      <div><span> 
          <br />
         </span></div>
       </section>
     
      <div class="spoiler"><b class="purple"><u>����� �������� ������ � ������������ ��������:</u></b></div>
      <section class="content">
     
      <div><span>�������� � ������� �������������� �� ��������� ���� ����� ��������� ����������,� � 12:00 �� 20:00.</span></div>
     
      <div><span>� ��������� ������� �������� �������� �� ��������� ������ �� � � ���� ������ (�� ������������ � ����������)</span></div>
     
      <div> 
        <br />
       </div>
       </section>
     
      <div><b class="purple"><u>��������! ����������� ���������!</u></b></div>
     
      <div><b class="purple"><u> 
            <br />
           </u></b></div>
     
      <div><span>��������� �������, �� ��������� � ���, ����� ��� ����� ��� ��������� � ������� � �����������. ������ ������� �� ����������� ������������� ���������� ��� ��������� ������ ����� ��������� � ��� ����������� ����������� �����, � ������, � 100% ����������������� �� �������.�</span></div>
     
      <div><span> 
          <br />
         </span></div>
     
      <div><span><u><i>���������</i></u> ������������ ����� ��� ������� ��������, ��� ������� �������������� ��������� � ������ �������� ���� ����������� ����������� ���������-��������, ������� ��� ��������� ����������� ������������� ������������ ������.</span></div>
     </div>
     
     </section>
 </div>
</div> 
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>