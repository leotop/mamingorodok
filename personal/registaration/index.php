<?
$NO_BROAD = true;
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
?>


<?
	if($NO_BROAD):
	$arCrumb=array(
		"0"=>array("URL"=>"/", "NAME"=>"Мамин городок"),
		"1"=>array("URL"=>"/personal/profile/", "NAME"=>"Мой профиль"),
		"2"=>array("URL"=>"/personal/registaration/", "NAME"=>"Регистрация"),
	);
	?>
	<div class="underline"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/bread_crumb.php', array('arCrumb'=>$arCrumb));?>
	</div>
<?endif;?>

	<div class="wish-list-light-notop">
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	".default", 
	array(
		"SHOW_FIELDS" => array(
			0 => "NAME",
			1 => "SECOND_NAME",
			2 => "LAST_NAME",
			3 => "PERSONAL_GENDER",
			4 => "PERSONAL_BIRTHDAY",
			5 => "PERSONAL_PHOTO",
			6 => "PERSONAL_PHONE",
			7 => "PERSONAL_STREET",
			8 => "PERSONAL_CITY",
			9 => "PERSONAL_ZIP",
			10 => "PERSONAL_COUNTRY",
			11 => "PERSONAL_NOTES",
		),
		"REQUIRED_FIELDS" => array(
		),
		"AUTH" => "Y",
		"USE_BACKURL" => "Y",
		"SUCCESS_PAGE" => "",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => "",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?>
	</div>
	


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>