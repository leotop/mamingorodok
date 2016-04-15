<?
$NO_BROAD = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Смена пароля");
?>
<div id="CatalogCenterColumn" class="LExist">

	<?if($NO_BROAD):?>
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
	"START_FROM" => "0",
	"PATH" => "",
	"SITE_ID" => "s1"
	),
	false
);?>
	<?endif;?>
	
	<div class="wish-list-light-notop">
	<?$APPLICATION->IncludeComponent("bitrix:system.auth.changepasswd", "pass", Array(
	
	),
	false
	);?>
	</div>
	
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>