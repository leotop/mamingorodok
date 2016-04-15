<?
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рекомендации и обзоры");
$APPLICATION->SetPageProperty("description", "Рекомендации и обзоры интернет магазина «Мамин городок».");

?> 
<div class="reviews"> 
  <?/*<h2 style="margin-left: 20px;">Друзья</h2>
 
  <div class="top-left"> 
    <p>Появление ребенка в&nbsp;семье всегда связано с&nbsp;множеством очень важных дел. Нужно выбрать необходимые вещи, купить&nbsp;их, подготовить жилье к&nbsp;появлению малыша... Но&nbsp;самое важное, что мама может дать ребенку&nbsp;&mdash; это не&nbsp;покупки, а&nbsp;ее&nbsp;забота. </p>
   
    <p> Мы&nbsp;хотим освободить тебя от&nbsp;лишних хлопот, чтобы ты&nbsp;могла больше дать своему малышу. Для этого наши специалисты отобрали для тебя самые достойные детские товары из&nbsp;всех возможных. Теперь не&nbsp;нужно посещать множество форумов и&nbsp;сайтов, чтобы выбрать нужное. </p>
   
    <p> В&nbsp;отобранном есть как самое необходимое, так и&nbsp;вещи, которые возьмут на&nbsp;себя часть хлопот и&nbsp;помогут освободить твое время. А&nbsp;так как все мамы по-разному подходят к&nbsp;покупкам для своих крошек, мы&nbsp;сделали несколько различных списков покупок, которые могут тебе понадобиться.</p>
   
    <p>Смотри, выбирай, спрашивай, ведь мы&nbsp;работаем для тебя!</p>
   </div>
 
  <div class="top-right"> 
    <div class="image"><img src="/upload/medialibrary/7f0/7f0a59a8179690d9c7689dd921586d43.png" border="0" width="330" height="240"  /></div>
   </div>
 */?>
  <div class="clear"></div>
 	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"reviews",
	Array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "7",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "1",
		"SECTION_FIELDS" => array(0=>"DESCRIPTION",1=>"PICTURE",2=>"",),
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y"
	)
);?> 	 

<div class="title-line reviews-left"><h2>Обзоры и сравнения товаров</h2></div>
    <div class="title-line reviews-right"><h2>Полезное</h2></div>
    <div class="clear"></div>
	<div class="reviews-left-block">
	<?$APPLICATION->IncludeComponent("individ:blog.reviews", ".default", array(
	"COUNT" => "10",
	"IBLOCK_ID" => "7",
	"CODE" => "ALL_IMAGES",
	"IGNORE_ID_PROP" => array(
		0 => "useful",
		1 => "",
	),
	"SELECT_ID_PROP" => array(
	),
	"SEO_USER" => "N"
	),
	false
);?> 
	</div>
	 <div class="column-column last">
	 <?$APPLICATION->IncludeComponent("individ:blog.reviews", ".default", array(
	"COUNT" => "10",
	"IBLOCK_ID" => "7",
	"CODE" => "ALL_IMAGES",
	"IGNORE_ID_PROP" => array(
		
	),
	"SELECT_ID_PROP" => array(
		0 => "useful",
	),
	"SEO_USER" => "N"
	),
	false
);?> 
	 </div> 
</div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>