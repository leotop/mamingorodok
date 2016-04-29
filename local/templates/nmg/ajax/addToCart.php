<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	if(!(CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))) echo 'Модуль не установлен';
	
	$productID = intval($_REQUEST['id']);
	$strAction = $_REQUEST['action'];
	$intAddCnt = intval($_REQUEST['quantity']);

	$strOk = '';
	$strError = '';
	
	if(($strAction == "ADD2BASKET") && $productID > 0 && $intAddCnt > 0)
	{
		$arProp = array();
		$rsO = CIBlockElement::GetList(Array(), array("ID"=>$productID), false, false, array("IBLOCK_ID", "PROPERTY_SIZE", "PROPERTY_COLOR", "ID", "PROPERTY_CML2_LINK.PROPERTY_CH_VYBIRAEM"));
		if($arO = $rsO -> GetNext())
		{
			$arProp[] = array("NAME" => empty($arO["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"])?'Размер':$arO["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"], "CODE" => "SIZE", "VALUE" => $arO["PROPERTY_SIZE_VALUE"]);
			$arProp[] = array("NAME" => "Цвет", "CODE" => "COLOR", "VALUE" => $arO["PROPERTY_COLOR_VALUE"]);
		}

		$arQuantity = CCatalogProduct::GetByID($productID);
		/*if ($arQuantity["QUANTITY"] < $intAddCnt)
			$strError = 'На складе недостаточно товара.';
		else {*/


			if(Add2BasketByProductID($productID, $intAddCnt, array(), $arProp))
				$strOk = 'Товар был успешно добавлен в корзину';
			else $strError = 'Ошибка добавления товара в корзину.';
		//}
	}?>   
<div id="message-body"><?
	if (strlen($strError) <= 0)
	{
		$intCartPrice = 0;
		$intBasketCnt = 0;
		$dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array());
    while ($arItems = $dbBasketItems->Fetch()) {
		$intCartPrice += $arItems["QUANTITY"] * $arItems["PRICE"];
	    $intBasketCnt += $arItems["QUANTITY"];
    }

		?><h1>Товар успешно добавлен в корзину</h1></li><li style="text-align:center;">
	<a class="gray" onclick="_gaq.push(['_trackEvent', 'Button', 'ContinueBuy', 'Continue']); $('.popupContainer').hide(); $('.overlay').remove(); return false;" href="#">продолжить выбор товаров</a>&nbsp;&nbsp;&nbsp;<a onclick="_gaq.push(['_trackEvent', 'Button', 'OrderCart', 'Order']);" href="/basket/">перейти к оформлению заказа</a>

	<script type="text/javascript">
		$("#cartItemsCnt").html(parseInt($("#cartItemsCnt").html())+1);
		$(".js-cartCnt").html('(<?=$intBasketCnt?>)');
        $(".basketQuant").fadeOut();
        $(".basketQuant").html('<?=$intBasketCnt?>');
        $(".basketQuant").fadeIn();

		<? if(empty($_REQUEST["simple"])) { ?>
		$("#cartPrice").val(<?=$intCartPrice?>);
		
		currentDeliveryPrice = getDeliveryPrice($("#cartPrice").val(), parseFloat(toNum($("h5.cost").html())));
		if(parseInt(currentDeliveryPrice)>0)
			strDeliveryPrice = 'Доставка '+currentDeliveryPrice;
		else strDeliveryPrice = currentDeliveryPrice;
	
		$("#deliveryPrice").html(strDeliveryPrice);<?
		}?>
	</script><?
	} else ShowError($strError);?>
</div><?
} else {
	CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
    $APPLICATION->SetTitle("Страница не найдена");

}?>