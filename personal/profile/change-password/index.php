<?
$NO_BROAD = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личные данные");
$APPLICATION->AddChainItem("Профиль", "/community/profile/");
$APPLICATION->AddChainItem("Изменить пароль", "");
?>
<div id="CatalogCenterColumn" class="LExist">

	<?if($NO_BROAD && $USER->IsAuthorized()):?>
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
	"START_FROM" => "0",
	"PATH" => "",
	"SITE_ID" => "s1"
	),
	false
);?>
	<?endif;?>

	<div class="wish-list-light-notop">
	<?$APPLICATION->IncludeComponent("bitrix:main.profile", "shortprofile", Array(
	
	),
	false
	);?>
	</div>
	
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>