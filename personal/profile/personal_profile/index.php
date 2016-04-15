<?
$NO_BROAD = true;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Анкета");
?>
	<div id="CatalogCenterColumn" class="LExist">
		<div class="wish-list-light-notop">
			<?$APPLICATION->IncludeComponent("bitrix:main.profile", "profile", Array(), false);?>
		</div>
	</div>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>