<?
$NO_BROAD = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сертификаты");
?>
<?$user = intval($_REQUEST["USER_ID"]); ?>
<?
global $USER;
$user_cur = $USER->GetID();
?>
<?
	$arCrumb=array(
		"0"=>array("URL"=>"/", "NAME"=>"Мамин городок"),
		"1"=>array("URL"=>"/community/user/".$USER->GetID()."/", "NAME"=>"Мой профиль"),
		"2"=>array("URL"=>"/community/user/1/certificates/already-have/", "NAME"=>"Мои сертификаты"),
	);
	?>
	<div class="underline"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/bread_crumb.php', array('arCrumb'=>$arCrumb));?>
	</div>
	<?
	
	if($_REQUEST["DO"]=="presented")
	{
		?><div class="catalogFilter" id="trueLink">
		<div class="choose">
		<span><span><a href="/community/user/<?=$user_cur?>/certificates/already-have/">У меня есть</a></span></span>
		<span class="active"><span><a href="/community/user/<?=$user_cur?>/certificates/presented/">Я подарил</a></span></span>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div><?
	} else {
		?><div class="catalogFilter" id="trueLink">
		<div class="choose">
		<span class="active"><span><a href="/community/user/<?=$user_cur?>/certificates/">У меня есть</a></span></span>
		<span><span><a href="/community/user/<?=$user_cur?>/certificates/presented/">Я подарил</a></span></span>
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
		</div><?
	}
	?>
	
	

<?if($_REQUEST["DO"]=="presented"):?>
	<?if($user == $user_cur):?>
		<?$APPLICATION->IncludeComponent("individ:certificates.present.list","my",array(
			"IBLOCK_TYPE"=>"certificate", 
			"IBLOCK_ID"=>CERTIFICATES_PRESENT_IBLOCK_ID, 
			"USER_ID"=>$user,
			"CACHE_GROUPS"=>"N"
			))?>
	<?else:?>
		<div class="notetext">Доступ запрещен.</div>
	<?endif;?>
<?else:?>
	<?if($user == $user_cur):?>
		<?$APPLICATION->IncludeComponent("individ:certificates.list","my",array(
			"IBLOCK_TYPE"=>"certificate", 
			"IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID, 
			"USER_ID"=>$user,
			"CACHE_GROUPS"=>"N"
			))?>
	<?else:?>		
		<div class="notetext">Доступ запрещен.</div>
	<?endif;?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>