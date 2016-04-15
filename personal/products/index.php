<?
$NO_BROAD = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddChainItem("Профиль", "/community/profile/");
$APPLICATION->AddChainItem("Личные данные", "");
$APPLICATION->SetTitle("Личные данные");
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
	<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile", Array(
	
	),
	false
	);?>
	</div>
	
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>