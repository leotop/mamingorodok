<?
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("������������ � ������");
$APPLICATION->SetPageProperty("description", "������������ � ������ �������� �������� ������ �������.");

?> 
<div class="reviews"> 
  <?/*<h2 style="margin-left: 20px;">������</h2>
 
  <div class="top-left"> 
    <p>��������� ������� �&nbsp;����� ������ ������� �&nbsp;���������� ����� ������ ���. ����� ������� ����������� ����, ������&nbsp;��, ����������� ����� �&nbsp;��������� ������... ��&nbsp;����� ������, ��� ���� ����� ���� �������&nbsp;&mdash; ��� ��&nbsp;�������, �&nbsp;��&nbsp;������. </p>
   
    <p> ��&nbsp;����� ���������� ���� ��&nbsp;������ ������, ����� ��&nbsp;����� ������ ���� ������ ������. ��� ����� ���� ����������� �������� ��� ���� ����� ��������� ������� ������ ��&nbsp;���� ���������. ������ ��&nbsp;����� �������� ��������� ������� �&nbsp;������, ����� ������� ������. </p>
   
    <p> �&nbsp;���������� ���� ��� ����� �����������, ��� �&nbsp;����, ������� ������� ��&nbsp;���� ����� ������ �&nbsp;������� ���������� ���� �����. �&nbsp;��� ��� ��� ���� ��-������� �������� �&nbsp;�������� ��� ����� ������, ��&nbsp;������� ��������� ��������� ������� �������, ������� ����� ���� ������������.</p>
   
    <p>������, �������, ���������, ���� ��&nbsp;�������� ��� ����!</p>
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

<div class="title-line reviews-left"><h2>������ � ��������� �������</h2></div>
    <div class="title-line reviews-right"><h2>��������</h2></div>
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