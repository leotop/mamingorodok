<?
$SUBSCRIBE = true;
$NO_BROAD = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка");
?>
	<div class="mrg15l">
		<?
		if(false) {
		$arCrumb = array(
			"0" => array("URL" => "/", "NAME" => "Мамин городок"),
			"1" => array("URL" => "/personal/subscribe/", "NAME" => "Подписка"),
		);
		?>
		<div class="underline"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/bread_crumb.php', array('arCrumb' => $arCrumb)); ?>
		</div><?
		}?>

		<div class="wish-list-light-notop">
			<?$APPLICATION->IncludeComponent("bitrix:subscribe.edit", ".default", array(), false);?>
		</div>

	</div>
	<style>
		form.jqtransformdone label {
			margin-top: 10px;
		}

		.jqTransformRadioWrapper {
			margin: 0;
		}
	</style>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>