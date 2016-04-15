<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");

?>

<?
    global $USER; 
    $rsGroup = CGroup::GetByID(1, "Y");
    $arGroup = $rsGroup->Fetch();   
    global $arGroups;
    global $arResult;
    $arGroups = $USER->GetUserGroupArray();
?>


<? // arshow($arResult);

       $arFilters = Array(array("name" => "watermark", "position" => "bottomleft",  "file"=>$_SERVER['DOCUMENT_ROOT']."/img/mmm.png"));
      $smallImg = CFile::ResizeImageGet($arResult["ITEMS"][38398]["PROPERTY_PRODUCT_ID_PREVIEW_PICTURE"], array("width"=>300, "height"=>400), BX_RESIZE_IMAGE_PROPORTIONAL, false, $arFilters);
    
     
?>
       
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>