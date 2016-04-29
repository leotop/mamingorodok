<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb" => 4), array("MODE" => "html")); ?>   
<? //print_R($arResult);?>
<div class="pcihotypes pcihotypes2">
	<div class="lmt"></div>
	<div class="rmt"></div>
	<div class="lmb"></div>
	<div class="rmb"></div>
	<p class="pnk hl"><b>Товар:</b> <?= $arResult["BASKET"]["COUNT"] ?></p>
	<p class="pnk hl"><b>Стоимость:</b> <?= $arResult["ORDER_PRICE"] ?> руб.</p>

	<div class="top10"></div>
	<?
	   if(in_array($arResult['DELIVERY_ID'],array(9,10,11))){
	      $deliveryCostFix = CSaleDelivery::GetByID($arResult['DELIVERY_ID']); 
	   } else {
	      $deliveryCostFix = $arResult["DELIVERY_PRICE"];
	   }
	   
	?>
	<p class="pnk hl3"><b>Сертификаты:</b> <span class="serf"><?= $arResult["SALE"] ?></span> руб.</p>
	<p class="pnk hl3"><b>Доставка:</b> <span class="dostav"><?= intval($deliveryCostFix['PRICE']) ?></span> руб.</p>
	<p class="pnk hl2"><b>Итого:</b>
		<span class="itogo"><?= $arResult["ORDER_PRICE"] - $arResult["SALE"] + $deliveryCostFix['PRICE'] ?></span> руб.
	</p>

	<div class="pnk phoneSp">8(495) 988-32-39</div>
	<input type="hidden" id="sum" value="<?= $arResult["BASKET"]["PRICE"] ?>">
	<input type="hidden" id="sert" value="<?= $arResult["BASKET"]["CERT"] ?>">
	<input type="hidden" id="location" value="<?= $arResult["POST"]["DELIVERY_LOCATION"] ?>">
	<input type="hidden" id="weight" value="<?= $arResult["POST"]["ORDER_WEIGHT"] ?>">
	<input type="hidden" id="delevery" value="<?= $arResult["POST"]["DELIVERY_ID"] ?>">
	<input type="hidden" id="lang" value="<?= $arResult["BASE_LANG_CURRENCY"] ?>">

	<div class="consinfo">
		Наши консультанты готовы<br> ответить на Ваши вопросы
	</div>
</div>
<div class="sposob">
	<? echo ShowError($arResult["ERROR_MESSAGE"]); ?>
	<h2 class="h2headnopad"><? echo GetMessage("STOF_PAYMENT_WAY") ?></h2>


	<?
	if($arResult["PAY_FROM_ACCOUNT"] == "Y") {
		?>
		<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
		<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<? if($arResult["PAY_CURRENT_ACCOUNT"] != "N") echo " checked"; ?>>
		<label for="PAY_CURRENT_ACCOUNT"><b><? echo GetMessage("STOF_PAY_FROM_ACCOUNT") ?></b></label><br />
	<?
	}
	?>
	<?

	if(count($arResult["PAY_SYSTEM"]) > 0) {
		foreach($arResult["PAY_SYSTEM"] as $arPaySystem) {
			?>
			<div class="spP">
				<input type="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"<? if($arPaySystem["CHECKED"] == "Y") echo " checked"; ?>>


				<label for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>">
					<?= $arPaySystem["PSA_NAME"] ?>
				</label>

				<div class="clear"></div>
				<div class="txt_spos">
					<?
					if(strlen($arPaySystem["DESCRIPTION"]) > 0) {
						?>
						<p><?= $arPaySystem["DESCRIPTION"] ?></p>

					<?
					}
					?>
				</div>

			</div>
		<?
		}
		?>

	<?
	}
	if($arResult["HaveTaxExempts"] == "Y") {
		?>
		<br />
		<input type="checkbox" name="TAX_EXEMPT" value="Y" checked> <b><? echo GetMessage("STOF_TAX_EX") ?></b><br />
		<? echo GetMessage("STOF_TAX_EX_PROMT") ?>
		<br /><br />
	<?
	}
	?>

	<div class="selectCertificate"><a href="#cerfBasket" class="showpUp greydot">Выбрать сертификаты для оплаты</a></div>

	<input type="submit" class="nextStep" name="contButton" value="Далее">

</div>