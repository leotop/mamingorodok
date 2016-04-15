<?

$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Форум редактор");
global $USER;
if($USER->IsAdmin()){
?> 
<?
	$APPLICATION->IncludeComponent("bitrix:forum","",array());
?>
 <?}?>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
