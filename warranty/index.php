<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Гарантия");
$APPLICATION->SetPageProperty("description", "Гарантийная информация");
?> 
<div class="formatted"> 
  <h1>Гарантия надежной покупки</h1>

  <div>
    <br />
  </div>

  <div>
    <div>- Покупка в &laquo;Мамином Городке&raquo; всегда с гарантией качества, поскольку мы являемся официальными дилерами по всем брендам, представленным в нашем магазине.</div>
  
    <div>- Вся продукция сертифицирована, имеет соответствующие допуски и одобрена экспертами.</div>
  
    <div>- Мы обменяем товар или оформим возврат покупки при обнаружении брака, недокомплекта либо в других гарантийных случаях.</div>
  
    <div>
      <br />
    </div>
  
    <div>С условиями Возврата и обмена товаров можно ознакомиться <a href="http://www.mamingorodok.ru/how-to-buy/warranty/" title="Условия возврата и обмена" target="_self" >тут</a><span style="font-size: 16px;">.</span></div>
  </div>

  <div>
    <br />
  </div>

  <ol> </ol>
 </div>
 <?//CEvent::Send("NOTIFY_PRODUCT", "s1", "");
 ?>
 <? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>