<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb"=>1), array("MODE"=>"html") );?>
<?
echo ShowError($arResult["ERROR_MESSAGE"]);
//echo GetMessage("STB_ORDER_PROMT"); ?>

<!--<br /><br />
<table width="100%">
	<tr>
		<td width="50%">
			<input type="submit" value="<?= GetMessage("SALE_REFRESH")?>" name="BasketRefresh">
		</td>
		<td align="right" width="50%">
			<input type="submit" value="<?= GetMessage("SALE_ORDER")?>" name="BasketOrder"  id="basketOrderButton1">
		</td>
	</tr>
</table>
<br />-->
<table class="sale_basket_basket data-table">
	<tr class="firstLine">
		<th class="th1" colspan="2">Товар</th>
		<th class="th2">Цена</th>
		<th class="th3"></th>
		<th class="th4">Количество</th>
		<th class="th5"></th>
		<th class="th6">Стоимость</th>
	</tr>
	<?
	if(isset($_SESSION["PRODUCTS"]) && is_array($_SESSION["PRODUCTS"])){
		foreach($_SESSION["PRODUCTS"] as $val){
		?>
			<tr class="del<?=$val["PRODUCT_ID"]?>"><td colspan='8' class='infoline'>Товар <?=$val["NAME"]?> был удален. <a class='grey repearElement' href="<?=$val["PRODUCT_ID"]?>">Отменить удаление</a></td></tr>
		<?
		}
	}
	
	$fullSumm = 0; // DISCOUNT_PRICE
	
	$i=0;
	//print_r($arResult);
	foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
	{
//        arshow($arBasketItems);
        ?>
    
		<tr class="line<?=$arBasketItems["PRODUCT_ID"]?>">
			<td class="td1"><a href="<?=$arBasketItems["PRODUCT_ID"]?>" class="delete"></a></td>
			<td class="td2">
				<?//print_R($arBasketItems["IMAGE"]);?>
				<div class="bskt_img">
				<?
//                arshow($arBasketItems);
				$file=CFile::ResizeImageGet($arBasketItems["PREVIEW_PICTURE"],array("width"=>100,"height"=>100),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,true); 
				//print_R($file);
				?>
				<img src='<?=$file["src"];?>'></div>
				<div class="bskt_info">
				<div class="bskt_lnk"><a href="<?=$arBasketItems["URL"]?>"><?=$arBasketItems["NAME"]?></a></div>
				<div class="bskt_rtg"> <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arBasketItems["RATING"]));?></div>
                <div class="bskt_color"><? if($arBasketItems["PROPERTY_TSVET_VALUE"]!=""){ echo "Цвет: ".$arBasketItems["PROPERTY_TSVET_VALUE"]; }?></div>
                <div class="bskt_size"><? if($arBasketItems["PROPERTY_RAZMER_VALUE"]!=""){ echo "Размер: ".$arBasketItems["PROPERTY_RAZMER_VALUE"]; }?></div>
                <div class="bskt_color"><? if($arBasketItems["PROPERTY_SHASSI_VALUE"]!=""){ echo "Шасси: ".$arBasketItems["PROPERTY_SHASSI_VALUE"]; }?></div>
				</div>
				<div class="clear"></div>
			</td>
			<td class="td3"><?
if($arBasketItems["DISCOUNT_PRICE"]>0 || $arBasketItems["OLD_PRICE"]>0)
	echo '<span class="basket_red"><s>'.intval(($arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"]>$arBasketItems["OLD_PRICE"]?$arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"]:$arBasketItems["OLD_PRICE"])).' руб.</s><br>'.intval($arBasketItems["PRICE"]).' руб.</span>';
else echo intval($arBasketItems["PRICE"]).' руб.'?> </td>
			<td class="td4">х</td>
			<td class="td5"><input maxlength="18" id="<?=$arBasketItems["PRODUCT_ID"]?>" type="text" name="QUANTITY_<?=$arBasketItems["ID"] ?>" value="<?=$arBasketItems["QUANTITY"]?>" class="QUANTITY" ></td>
			<td class="td7">=</td>
			<td class="td8"><span class="priceid<?=$arBasketItems["PRODUCT_ID"]?>"><?=$arBasketItems["PRICE"]*$arBasketItems["QUANTITY"]?></span> руб.</td>
		</tr>
	<?
		$fullSumm += $arBasketItems["QUANTITY"] * intval(($arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"]>$arBasketItems["OLD_PRICE"]?$arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"]:$arBasketItems["OLD_PRICE"]));
		$i++;
	}
	?>
</table>
<div class="allSum">
	<div class="total">Итого: <span class="redPr"><span class="allPrice"><?=$fullSumm?></span> руб.</span></div>
	<!--<div class="points"><input type="checkbox" name="point" id="point"> <label for="point">Использовть 127 баллов для оплаты заказа.</label></div>-->
	<!--<div class="certificate"><?if($arResult["SALE"]>0):?><?=count($_SESSION["certificates"])?> сертификата на сумму <?=$arResult["SALE"]?> руб.<?else:?>Сертификаты не выбраны.<?endif;?></div>-->
	<div class="totalSale">Итого с учетом скидки: <span class="redPr"><span class="allPriceSale"><?=$arResult["allSum"]-$arResult["SALE"]?></span> руб.</span></div>
	<div class="order">
	<input type="hidden" name="BasketOrder" value="<?= GetMessage("SALE_ORDER")?>">
	<input type="submit" value="<?echo GetMessage("SALE_ORDER")?>"  id="basketOrderButton2"></div>
</div><?
if(count($arResult["ACTIONS"])>0 && $USER -> IsAdmin())
{?><br>
<h2>Подарки</h2>
<div class="basketActions"><?
	foreach($arResult["ACTIONS"] as $arA)
	{ ?>
	<div><?
		if(!empty($arA["PREVIEW"]["SRC"]))
			echo '<img src="'.$arA["PREVIEW"]["SRC"].'" alt="'.$arA["NAME"].'">';
		echo $arA["~PROPERTY_BASKET_TEXT_VALUE"]["TEXT"];
		?>
	</div><?
	}?>
</div>
<br clear="all"><?
}?>
<!--<div class="selectCertificate">
	<?if($USER->IsAuthorized()):?>
		<a href="#cerfBasket" class="showpUp greydot">Выбрать сертификаты для оплаты</a>
	<?endif?>
	</div>
    -->
    
    <!--<div class="sale">Скидка: 127 руб.</div>-->
	<div class="clear"></div>
<br />