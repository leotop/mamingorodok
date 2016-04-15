<?
$IS_BASKET = true;
$IS_HIDE = true;
$HIDE_LEFT_COLUMN = true;
$IS_DETAIL = true;
$NO_BROAD = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<?
//unset($_SESSION["STEP"]);
global $step;
$step = intval($_REQUEST["step"]);
$user_id = intval($_REQUEST["USER_ID"]);
if(isset($_SESSION["STEP"]) && $_SESSION["STEP"]==2){
	$step = $_SESSION["STEP"];
	unset($_SESSION["STEP"]);
}

if($step==2){
	foreach($_REQUEST as $k=>$v){
		if(preg_match("/ORDER_PROP_/is",$k))
			$_SESSION["buyfriend"]["profile"][$user_id][$k] = $v;
	}
	
	if($USER->IsAuthorized()){
		$step = 3;
	}
	else{
		$_SESSION["STEP"] = 2;
	}
}

if($step==4){
	$_SESSION["buyfriend"]["pay_system"][$user_id] = intval($_REQUEST["pay_system"]);
	$_SESSION["buyfriend"]["delivery"][$user_id] = intval($_REQUEST["delivery"]);
	if($_SESSION["buyfriend"]["pay_system"][$user_id]<=0)
		$step = 3;
	if($_SESSION["buyfriend"]["delivery"][$user_id]<=0)
		$step = 3;
}

if($step==0):
	$APPLICATION->IncludeComponent("individ:order.friend.step.0","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID
	));
elseif($step==1):
	$APPLICATION->IncludeComponent("individ:order.friend.step.1","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID,
		"PERSON_TYPE"=>PERSON_TYPE_ID_VALUE
	));
elseif($step==2):
	$APPLICATION->IncludeComponent("individ:order.friend.step.2","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID,
	));
elseif($step==3):
	$APPLICATION->IncludeComponent("individ:order.friend.step.3","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID,
		"PERSON_TYPE"=>PERSON_TYPE_ID_VALUE
	));
endif;
if($step==4):
	$APPLICATION->IncludeComponent("individ:order.friend.step.4","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID,
		"PERSON_TYPE"=>PERSON_TYPE_ID_VALUE
	));
elseif($step==5):
	
	$APPLICATION->IncludeComponent("individ:order.friend.step.5","",array(
		"USER_ID"=>$_REQUEST["USER_ID"],
		"OFFER_ID"=>OFFERS_IBLOCK_ID,
		"CATALOG_ID"=>CATALOG_IBLOCK_ID,
		"ORDER_ID"=>$_REQUEST["ORDER_ID"],
		"CERTIFICATE_ID"=>CERTIFICATES_IBLOCK_ID,
		"PERSON_TYPE"=>PERSON_TYPE_ID_VALUE,
		"PATH_TO_PAYMENT"=>"/basketFriend/payment.php"
	));
	
endif;?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>