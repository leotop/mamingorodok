<?define("NEED_AUTH", true);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->SetTitle("�������");?>
<?
global $USER;
$user_id = $USER->GetID();
if (CModule::IncludeModule("blog")):
	$arBlog = CBlog::GetByOwnerID($user_id);
	//print_R($arBlog);
	if(is_array($arBlog)) 
		
		$user_blog = $arBlog["URL"];
endif;
?> 
<div class="wish-list-light"> 
  <table width="100%"> 
    <tbody> 
      <tr><td width="50%"> 
          <h2 class="grey">������������ ����������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/personal/profile/" >�������� ������ ������</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/?showMe=Y" >���������� ������ ������</a> <a class="otzlnk" href="/personal/profile/change-password/" >�������� ������</a> <a class="otzlnk" href="/personal/profile/forgot-password/" >������������ ������</a> </div>
           </div>
         
          <h2 class="grey">������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/friends/" >���������� ������ ������</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/friends/invite/" >���������� ������ �� ����</a> <a class="otzlnk" href="/community/search/" >����� ������ �� �����</a></div>
           </div>
         
          <h2 class="grey">�����������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/certificates/already-have/" >���������� ��� �����������</a> <a class="otzlnk" href="/community/user/<?=$user_id?>/certificates/presented/" >� �������</a> <a class="otzlnk showpUp" href="#certificateBuy" >������ ����������</a> </div>
           </div>
         </td> <td width="50%"> 
          <h2 class="grey">��������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/personal/subscribe/" >�������� ��������</a> </div>
           </div>
         
          <h2 class="grey">��� ����</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/blog/<?=$user_blog?>/" >���������� ����</a> <a class="otzlnk" href="/community/blog/<?=$user_blog?>/post_edit/new/" >�������� ������</a> </div>
           </div>
         
          <h2 class="grey">�������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/rating/" >���������� ������ ����������</a> </div>
           </div>
         
          <h2 class="grey">������ ������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/" >���������� ������ ������</a> </div>
           </div>
		   
		    <h2 class="grey">�������</h2>
         
          <div class="items-group"> 
            <div class="item-group"> <a class="otzlnk" href="/community/user/<?=$user_id?>/awards/" >���������� ������ ������</a> </div>
           </div>
         </td> </tr>
     </tbody>
   </table>
 </div>
 
 <div id="certificateBuy" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
		<div class="clear"></div>
		<div class="title">�������� �����������</div>
		<div class="sub-title">������ ����������� � ��������</div>
       <div class="data">
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "certificate.buy", Array(
	"IBLOCK_TYPE" => "certificate",	// ��� ��������������� ����� (������������ ������ ��� ��������)
	"IBLOCK_ID" => "4",	// ��� ��������������� �����
	"NEWS_COUNT" => "20",	// ���������� �������� �� ��������
	"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
	"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
	"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
	"FILTER_NAME" => "",	// ������
	"FIELD_CODE" => array(	// ����
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// ��������
		0 => "PRICE",
		1 => "",
	),
	"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
	"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
	"AJAX_MODE" => "Y",	// �������� ����� AJAX
	"AJAX_OPTION_SHADOW" => "Y",	// �������� ���������
	"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
	"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
	"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
	"CACHE_TYPE" => "A",	// ��� �����������
	"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
	"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
	"CACHE_GROUPS" => "Y",	// ��������� ����� �������
	"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
	"SET_TITLE" => "N",	// ������������� ��������� ��������
	"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
	"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
	"PARENT_SECTION" => "",	// ID �������
	"PARENT_SECTION_CODE" => "",	// ��� �������
	"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
	"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
	"PAGER_TITLE" => "�������",	// �������� ���������
	"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
	"PAGER_TEMPLATE" => "",	// �������� �������
	"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
	"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
	"DISPLAY_DATE" => "Y",	// �������� ���� ��������
	"DISPLAY_NAME" => "Y",	// �������� �������� ��������
	"DISPLAY_PICTURE" => "Y",	// �������� ����������� ��� ������
	"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
	"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
	),
	false
);?>
       </div> 
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>