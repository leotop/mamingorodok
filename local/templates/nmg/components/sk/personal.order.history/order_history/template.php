<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

echo '<br />
<form class="jqtransform">';

if(!empty($arResult["ORDER"])) {
	$intOrderCnt = 0;
	foreach($arResult["ORDER"] as $arOrder) {
		$intItemsCount = count($arOrder["ITEMS"]);
		if($intOrderCnt > 0) echo '<div class="liner"></div>';?>
<table class="sale_basket_basket data-table">
	<tr class="firstLine">
		<th class="ph1">Дата заказ</th>
		<th class="ph2">Номер заказа</th>
		<th class="ph3">Артикул</th>
		<th>Название товара</th>
		<th class="ph5">Кол-во</th>
		<th class="ph6">Стоимость</th>
	</tr>
	<?
	$intCnt = 0;
	foreach($arOrder["ITEMS"] as $intItemID) {
		$arItem = $arResult["ITEMS"][$intItemID];

		if($arOrder["CANCELED"] == "Y")
			$strStatus = 'Отменен';
		else $strStatus = $arResult["STATUS"][$arOrder["STATUS"]]; ?>
	<tr><?
		if($intCnt == 0) {?>
		<td rowspan="<?=$intItemsCount?>"><?=substr($arOrder["DATE_INSERT"], 0, 10)?></td>
		<td rowspan="<?=$intItemsCount?>"><?=(empty($arItem["PROPERTY_ARTICUL_VALUE"])?'-':$arItem["PROPERTY_ARTICUL_VALUE"])?></td><?
		} ?>
		<td><?=$arItem["PROPERTY_ARTICUL_VALUE"]?></td>
		<td><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></td>
		<td><?=$arItem["QUANTITY"]?></td>
		<td><?=CurrencyFormat($arItem["QUANTITY"] * $arItem["PRICE"], "RUB")?></td>
	</tr><?
		$intCnt++;
	}?>
	<tr>
		<td class="nopad" colspan="100%"><div class="liner"></div></td>
	</tr>
	<tr>
		<td colspan="4">
			<strong>Статус заказа:</strong> <span class="mag bold"><?=$strStatus?></span><br />
			<strong>Способ оплаты:</strong> <?=$arResult["PAYMENT"][$arOrder["PAY_SYSTEM_ID"]]["NAME"]?> - <?=($arOrder["PAYED"]=="Y"?'оплачен':'не оплачен')?><br />
			<strong>Подъем:</strong> <?=(empty($arOrder["PROP"][17]) || $arOrder["PROP"][17]=="N"?'нет':'да')?><br />
			<strong>Сборка:</strong> <?=(empty($arOrder["PROP"][19]) || $arOrder["PROP"][19]=="N"?'нет':'да')?>
		</td>
		<td class="ar">
			Доставка<br>
			<span class="mag bold">Итого</span>
		</td>
		<td>
			<?=CurrencyFormat(intval($arOrder["DELIVERY_PRICE"]), "RUB")?><br>
			<span class="bold"><?=CurrencyFormat(intval($arOrder["PRICE"]), "RUB")?></span>
		</td>
	</tr>
	<tr>
		<td colspan="3"><a title="Оставить отзыв на Яндекс.Маркет" href="#"><img src="/img/ym-blue.gif" alt="Оставить отзыв на Яндекс.Маркет" /></a></td>
		<td colspan="3" class="ar">
			<a href="#" onclick="showPopupQuestionOrder(<?=$arOrder["ID"]?>); return false;"><input class="orange-button" type="button" value="Задать вопрос по заказу" /></a>&nbsp;&nbsp;&nbsp;<a href="/personal/order/?COPY_ORDER=Y&ID=<?=$arOrder["ID"]?>"><input type="button" value="Повторить заказ" /></a>
		</td>
	</tr>
</table><?
		$intOrderCnt++;
	}
} else echo 'У Ваc нет ни одного заказа в истории.';

echo '</form>


<div id="askOrderQuestionContainer" class="hidden" data-popup-head="Задать вопрос">
	<form id="frmOrderQuestion" class="jqtransform">
		<input type="hidden" id="orderIDQuestion" name="orderID" />
		<div id="popupOrderQuestionOuter" class="popupOrderQuestionOuter">
			<p>Здесь Вы можете написать свой вопрос. Мы ответим Вам в течение 2-4 рабочих дней на почту или по телефону.</p>
			<div id="popupOrderQuestionError" class="error"></div>
			<form id="frmQuestionOrder" class="">
				<textarea name="orderQuestion" id="textOrderQuestion"></textarea>
				<a id="btnOrderQuestion" href="#" onclick="sendPopupQuestionOrder(); return false;"><input type="button" value="Отправить сообщение" /></a>
			</form>
		</div>
	</form>
</div>
';