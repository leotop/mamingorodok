<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb" => 3), array("MODE" => "html")); ?>


<div class="pcihotypes">
	<div class="lmt"></div>
	<div class="rmt"></div>
	<div class="lmb"></div>
	<div class="rmb"></div>
	<p class="pnk hl"><b>Товар:</b> <?= $arResult["BASKET"]["COUNT"] ?></p>
	<p class="pnk hl"><b>Стоимость:</b> <?= $arResult["ORDER_PRICE"] ?> руб.</p>
	<p class="pnk hl"><b>Сертификаты:</b> <?= $arResult["SALE"] ?> руб.</p>
	<p class="pnk hl"><b>Доставка:</b> <span class="dostav"><?= intval($arResult["DELIVERY_NOW"]) ?></span> руб.</p>
	<p class="pnk hl2"><b>Итого:</b>
		<span class="itogo"><?= $arResult["BASKET"]["PRICE"] + $arResult["DELIVERY_NOW"] ?></span> руб.</p>

	<div class="pnk phoneSp">8(495) 988-32-39</div>
	<input type="hidden" id="sum" value="<?= $arResult["BASKET"]["PRICE"] ?>">
	<input type="hidden" id="sert" value="<?= $arResult["SALE"] ?>">

	<div class="consinfo">
		Наши консультанты готовы<br> ответить на Ваши вопросы
	</div>
</div>
<div class="sposob">
	<? echo ShowError($arResult["ERROR_MESSAGE"]); ?>
	<h2 class="h2headnopad"><? echo GetMessage("STOF_DELIVERY_PROMT") ?></h2>
	<? //print_r($arResult);?>
	<input type="hidden" value="<?= $arResult["DELIVERY_LOCATION"] ?>" id="location">
	<?foreach($arResult["DELIVERY"] as $delivery_id => $arDelivery) {
		if($delivery_id !== 0 && intval($delivery_id) <= 0):?>
			<!--<div>
					<label><?= $arDelivery["TITLE"] ?></label>
					<div class="clear"></div>
					<div class="txt_spos">
					<? if(strlen($arDelivery["DESCRIPTION"]) > 0): ?>
						<p><?= nl2br($arDelivery["DESCRIPTION"]) ?></p>
					</div>
					<div class="clear"></div>
					</div>
					
					<? endif; ?>-->
			<?foreach($arDelivery["PROFILES"] as $profile_id => $arProfile) {
				?>
				<div class="spP">
					<input type="radio" class="reloadpost" id="ID_DELIVERY_<?= $delivery_id ?>_<?= $profile_id ?>" name="<?= $arProfile["FIELD_NAME"] ?>" value="<?= $delivery_id.":".$profile_id; ?>" <?= $arProfile["CHECKED"] == "Y"?"checked=\"checked\"":""; ?> />
					<label for="ID_DELIVERY_<?= $delivery_id ?>_<?= $profile_id ?>">
						<?= $arProfile["TITLE"] ?>
					</label>

					<div class="clear"></div>
					<div class="txt_spos">
						<? if(strlen($arProfile["DESCRIPTION"]) > 0): ?>
							<p><?= nl2br($arProfile["DESCRIPTION"]) ?></p>
						<? endif; ?>
						<p><?
							$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
								"NO_AJAX" => $arParams["SHOW_AJAX_DELIVERY_LINK"] == 'S'?'Y':'N',
								"DELIVERY" => $delivery_id,
								"PROFILE" => $profile_id,
								"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
								"ORDER_PRICE" => $arResult["BASKET"]["PRICE"],
								"LOCATION_TO" => $arResult["DELIVERY_LOCATION"],
								"LOCATION_ZIP" => $arResult['DELIVERY_LOCATION_ZIP'],
								"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
							));

							?></p>
					</div>

					<div class="clear"></div>
				</div>




			<? if ($arParams["SHOW_AJAX_DELIVERY_LINK"] == 'N'): ?>
				<script type="text/javascript">deliveryCalcProceed({STEP: 1, DELIVERY: '<?=CUtil::JSEscape($delivery_id)?>', PROFILE: '<?=CUtil::JSEscape($profile_id)?>', WEIGHT: '<?=CUtil::JSEscape($arResult["ORDER_WEIGHT"])?>', PRICE: '<?=CUtil::JSEscape($arResult["ORDER_PRICE"])?>', LOCATION: '<?=intval($arResult["DELIVERY_LOCATION"])?>', CURRENCY: '<?=CUtil::JSEscape($arResult["BASE_LANG_CURRENCY"])?>'})</script>
			<? endif; ?>
			<?
			} // endforeach
			?>
		<?
		else:
			?>
			<div class="spP">
				<input type="radio" class="reloadpost" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?= $arDelivery["FIELD_NAME"] ?>" value="<?= $arDelivery["ID"] ?>"<? if($arDelivery["CHECKED"] == "Y") echo " checked"; ?>>

				<label for="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>">
					<?= $arDelivery["NAME"] ?>
				</label>

				<div class="clear"></div>
				<div class="txt_spos">
					<?
					if (strlen($arDelivery["PERIOD_TEXT"]) > 0)
					{
					?><p><?echo $arDelivery["PERIOD_TEXT"];
					?></p><?
					}
					?>
					<!--<p><?= GetMessage("SALE_DELIV_PRICE"); ?> <?= $arDelivery["PRICE_FORMATED"] ?></p>-->
					<?
					if(strlen($arDelivery["DESCRIPTION"]) > 0) {
						?>
						<p><?= $arDelivery["DESCRIPTION"] ?></p>
					<?
					}
					?>
					<input type="hidden" id="dost" value="<?= $arDelivery["PRICE"] ?>">
				</div>
				<div class="clear"></div>
			</div>
		<?
		endif;

	} // endforeach
	?>
	<?
	//endif;
	?>
	<div class="clear"></div>
	<input type="submit" class="nextStep" name="contButton" value="Перейти&nbsp;к&nbsp;оплате">
</div>

						
							
					
							
						
	
		
	