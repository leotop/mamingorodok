<?
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("��� ���� ����� ������ ������");
$APPLICATION->SetPageProperty('description', '����������');

global $USER;
$user_id = intval($USER->GetID());
if($user_id>0){
	 // $arFilter = array(
		// "IBLOCK_ID"=>WISHLIST_IBLOCK_ID,
		// "ACTIVE"=>"Y",
		// "PROPERTY_USER_ID" => $user_id,
		// "PROPERTY_STATUS" => '',
		// "ALL_EXCEPT_ALREADY_HAVE" => "Y",
		// "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID
	// );
	// $dbWish = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "IBLOCK_ID", 'NAME', 'PREVIEW_TEXT', "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS"));    
	// if($obEl = $dbWish->GetNext())    
	// {           
		LocalRedirect("/community/user/{$user_id}/");
	// }

		
}
?>
<table> 
  <tbody>
    <tr> <td> 
        <br />
       
        <br />
       
        <br />
       
        <p><b class="purple"> <span style="font-size: 14px; ">&laquo;������ ������&raquo; �������� ���:</span></b></p>
       
        <br />
       
        <p><b class="purple"><span style="font-size: 14px; ">���������</span></b> - ��������� ������ �� ���� ������ ����, ��� ������� ������������� � ������� � ������� ���, 
          <br />
         ����� �������, �������.</p>
       
        <br />
       
        <p><b class="purple"><span style="font-size: 14px; ">��������</span></b> - ���������� � ���������� ������ ����� ������! �����������, ������� ��� �������, ������ ��������� ����������� ��� �������� ������� � ������ ���� ��� ����� ������.</p>
       </td> <td> 							<a href="/personal/registaration/?backurl=/catalog/" > 						<img style="margin-right: 20px" src="/upload/medialibrary/7f0/7f0a59a8179690d9c7689dd921586d43.png" width="270" height="200"  /></a> </td> </tr>
   </tbody>
</table>
 
<br />
 
<table> 
  <tbody>
    <tr> <td width="30%"> <center> 							<a href="/personal/registaration/?backurl=/catalog/" > 						<img src="/upload/medialibrary/4b9/4b9b7440c30a9ed19f5b32f197aab7e5.png"  /></a></center> 
        <br />
       
        <p align="center"><b class="purple"><span style="font-size: 14px; ">��������� ���� ������� ������</span></b></p>
       
        <br />
       
        <p>����� ������� ������ �� ������� ��� ������ ���, ������� ��������� ���� ��������!</p>
       
        <br />
       
        <p>��� ������ �� �� �������� � ��������</p>
       
        <br />
       
        <p>��� ������ ������� ���� ������� �� �������� ������� ������.</p>
       
        <br />
       
        <p><a href="/personal/registaration/?backurl=/about-baby-list.php" >�����������������</a> � ��������� ���� ������ ������.</p>
       </td> <td valign="middle"> <img class="strelo4ka" src="/upload/medialibrary/next_icon.jpg"  /> </td> <td width="30%"> <center> 							<a href="/personal/registaration/?backurl=/catalog/" > 						<img src="/upload/medialibrary/6f7/6f717083c42e03d1ba2da5ed4d08dbdc.png"  /></a></center> 
        <br />
       
        <p align="center"><b class="purple"><span style="font-size: 14px; ">�������� ��� �������</span></b></p>
       
        <br />
       
        <p>��� ������ ����� ������ ����� ������� ��� ���, ���� �� ����������� ����������� ������.</p>
       
        <br />
       
        <p>��������� ������ �� ������ �� �������� ������ ������.</p>
       
        <br />
       
        <br />
       
        <br />
       
        <p><a href="/personal/registaration/?backurl=/about-baby-list.php" >�����������������</a> � ��������� ���� ������ ������.</p>
       </td> <td valign="middle"> <img class="strelo4ka" src="/upload/medialibrary/next_icon.jpg"  /> </td> <td width="30%"> <center> 							<a href="/personal/registaration/?backurl=/catalog/" > 						<img src="/upload/medialibrary/dac/dacb1368b7f6bd5a0139b82964ba9867.png"  /></a></center> 
        <br />
       
        <p align="center"><b class="purple"><span style="font-size: 14px; ">��������� � ��������� �������!</span></b></p>
       
        <br />
       
        <p>�� �������, ��� ������ � ������������ ����� ���� ������ ���. </p>
       
        <br />
       
        <p>���-�� ��������� �� ������������ �������, � 
          <br />
         ���-�� ���� ������� �������!</p>
       
        <br />
       
        <br />
       
        <br />
       
        <p><a href="/personal/registaration/?backurl=/about-baby-list.php" >�����������������</a> � ��������� ���� ������ ������.</p>
       </td> </tr>
   </tbody>
</table>
 
<br />
 
<br />
 
<br />
 
<p><b class="purple"><span style="font-size: 14px; ">������� ���������� ���� ������ � �������� ��� ������ ����� ���:</span></b> </p>
 
<br />
 
<ul class="wtf"> 
  <li><a href="/reviews/aktivnaya_mama/" ><b><span style="font-size: 14px; ">��������</span></b></a><a></a></li>
<a> </a>
  <li><a></a><a href="/reviews/stilnaya_mama/"><b><span style="font-size: 14px; ">��������</span></b></a></li>
 
  <li><a href="/reviews/rich_mama/" ><b><span style="font-size: 14px; ">�������������</span></b></a></li>
 
  <li><a href="/reviews/klassicheskaya_mama/" ><b><span style="font-size: 14px; ">������������</span></b></a></li>
 
  <li><a href="/reviews/practical_mom/" ><b><span style="font-size: 14px; ">����������</span></b></a></li>
 
  <li><a href="/reviews/ya_papa/" ><b><span style="font-size: 14px; ">� ����</span></b></a></li>
 </ul>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>