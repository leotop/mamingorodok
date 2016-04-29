<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?echo '<br />
<form class="jqtransform">';


if(!empty($arResult['ERRORS']['FATAL'])):?>

	<?foreach($arResult['ERRORS']['FATAL'] as $error):?>
		<?=ShowError($error)?>
	<?endforeach?>

<?else:?>

	<?if(!empty($arResult['ERRORS']['NONFATAL'])):?>

		<?foreach($arResult['ERRORS']['NONFATAL'] as $error):?>
			<?=ShowError($error)?>
		<?endforeach?>

	<?endif?>

	<div class="bx_my_order_switch">

		<?$nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);?>

		<?if($nothing || isset($_REQUEST["filter_history"])):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?show_all=Y"><?=GetMessage('SPOL_ORDERS_ALL')?></a>
		<?endif?>

		<?if($_REQUEST["filter_history"] == 'Y' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?=GetMessage('SPOL_CUR_ORDERS')?></a>
		<?endif?>

		<?if($nothing || $_REQUEST["filter_history"] == 'N' || $_REQUEST["show_all"] == 'Y'):?>
			<a class="bx_mo_link" href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y"><?=GetMessage('SPOL_ORDERS_HISTORY')?></a>
		<?endif?>

	</div>

	<?if(!empty($arResult['ORDERS'])):?>
   <? 
        $intItemsCount = count($arOrder["ITEMS"]);
		foreach($arResult["ORDER_BY_STATUS"] as $key => $group):?>

			<?foreach($group as $k => $order):?>

				<?if(!$k):?>

<!--					<div class="bx_my_order_status_desc">

						<h2><?=GetMessage("SPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h2>
						<div class="bx_mos_desc"><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></div>

					</div> -->

				<?endif?>

				<div class="bx_my_order">
                <?  $intOrderCnt = 0;
                         ?>
                    <table class="sale_basket_basket data-table">
                    <thead>
                        <tr class="firstLine">
                            <th class="ph1">Дата заказ</th>
                            <th class="ph2">Номер заказа</th>
                            <th class="ph3">Артикул</th>
                            <th>Название товара</th>
                            <th class="ph5">Кол-во</th>
                            <th class="ph6">Стоимость</th>
                        </tr>
                    </thead>
						<tbody>
                        <?
                    $intCnt = 0;
                        $item = $arResult["ITEMS"][$intItemID];
                        if($arOrder["CANCELED"] == "Y")
                            $strStatus = 'Отменен';
                        else $strStatus = $arResult["STATUS"][$arOrder["STATUS"]]; ?>
                        <?foreach ($order["BASKET_ITEMS"] as $item):?>
                         <?  $arSelect = Array("ID", "IBLOCK_ID","PROPERTY_CML2_ARTICLE", "PROPERTY_SBOR", "PROPERTY_ELEVATOR", "ARTICUL");
                            $arFilter = Array("ID"=>$item["PRODUCT_ID"]);
                            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                            $ob = $res->Fetch();
                             arshow($ob);
                             ?>
                        <tr>
                            <td>
                                <?=$order["ORDER"]["DATE_STATUS_FORMATED"];?>
                            </td>
                            <td rowspan="<?=$intItemsCount?>">
                               <?=$order["ORDER"]["ID"]?>
                            </td>
                            <td>
                               <? if($ob["PROPERTY_ARTICLE_VALUE"] ){
                                 echo $ob["PROPERTY_ARTICLE_VALUE"];
                               }elseif($ob["PROPERTY_CML2_ARTICLE_VALUE"]){
                                 echo $ob["PROPERTY_CML2_ARTICLE_VALUE"];
                               }else{
                                   echo "-";
                               };?>
                               <?//=$item["PROPERTY_ARTICUL_VALUE"]?>
                            </td>                      
                            <td>
                                <?if(strlen($item["DETAIL_PAGE_URL"])):?>
                                    <a href="<?=$item["DETAIL_PAGE_URL"]?>" target="_blank">
                                <?endif?>
                                    <?=$item['NAME']?>
                                <?if(strlen($item["DETAIL_PAGE_URL"])):?>
                                    </a> 
                                <?endif?>
                            </td>
                             <td>
                                   <nobr><?=$item['QUANTITY']?> <?=(isset($item["MEASURE_NAME"]) ? $item["MEASURE_NAME"] : GetMessage('SPOL_SHT'))?></nobr>
                             </td>
                             <td>
                                 <?=CurrencyFormat($item["QUANTITY"] * $item["PRICE"], "RUB")?>
                             </td>
                             <?endforeach?>
                             <?$intCnt++;
                             ?>
                          
                         </tr>
                        <tr>
                            <td class="nopad" colspan="100%"><div class="liner"></div></td>
                        </tr>
                          <tr>
                          <td colspan="4">
                            <strong><?="Статус заказа";?>:</strong>
                            <span class="mag bold <?=$arResult["INFO"]["STATUS"][$key]['COLOR']?><?/*yellow*/ /*red*/ /*green*/ /*gray*/?>"><?=$arResult["INFO"]["STATUS"][$key]["NAME"]?></span><br>
                                
                                <?if($order['HAS_DELIVERY']):?>

                                    <strong><?=GetMessage('SPOL_DELIVERY')?>:</strong>

                                    <?if(intval($order["ORDER"]["DELIVERY_ID"])):?>
                                    
                                        <?=$arResult["INFO"]["DELIVERY"][$order["ORDER"]["DELIVERY_ID"]]["NAME"]?> <br />
                                    
                                    <?elseif(strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false):?>
                                    
                                        <?$arId = explode(":", $order["ORDER"]["DELIVERY_ID"])?>
                                        <?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>) <br />

                                    <?endif?>

                                <?endif?>
                                <? // PAY SYSTEM ?>
                                <?if(intval($order["ORDER"]["PAY_SYSTEM_ID"])):?>
                                    <strong><?=GetMessage('SPOL_PAYSYSTEM')?>:</strong> <?=$arResult["INFO"]["PAY_SYSTEM"][$order["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?> - <?=GetMessage('SPOL_'.($order["ORDER"]["PAYED"] == "Y" ? 'YES' : 'NO'))?> <br />
                                <?endif?>
                                
                                  <?//echo "способ оплаты:"; arshow($order)?>
                                  
                                <? // DELIVERY SYSTEM ?>
                              <!--  <strong>Подъем:</strong> <?=(empty($ob["PROPERTY_SBOR_VALUE"]) ?'нет':'да')?><br />
                                <strong>Сборка:</strong> <?=(empty($order["PROPERTY_ELEVATOR_VALUE"]) ?'нет':'да')?>         -->
                           </td> 
                        
                            <td class="ar">
                                Доставка<br>
                                <span class="mag bold">Итого</span>
                            </td>
                            <td>
                                <?=CurrencyFormat(intval($item["PRICE_DELIVERY"]), "RUB")?><br>
                                <span class="bold"> <?=$order["ORDER"]["FORMATED_PRICE"]?> </span>
                            </td>
                        </tr>
                          <tr>
                            <td colspan="2"><a title="Оставить отзыв на Яндекс.Маркет" href="#"><img src="/img/ym-blue.gif" alt="Оставить отзыв на Яндекс.Маркет" /></a></td>
                            <td colspan="4" class="ar">
                                <a href="#" onclick="showPopupQuestionOrder(<?=$arOrder["ID"]?>); return false;"><input class="orange-button" type="button" value="Задать вопрос по заказу" /></a>&nbsp;&nbsp;&nbsp;<a href="/personal/order/?COPY_ORDER=Y&ID=<?=$arOrder["ID"]?>">
                                <?if($order["ORDER"]["CANCELED"] != "Y"):?>
                                <a href="<?=$order["ORDER"]["URL_TO_CANCEL"]?>" style="min-width:140px"class="jqTransformButton_1"><?=GetMessage('SPOL_CANCEL_ORDER')?></a><br>
                                <?endif?> 
                                <a href="<?=$order["ORDER"]["URL_TO_COPY"]?>" style="min-width:140px"class="jqTransformButton_1"><?=GetMessage('SPOL_REPEAT_ORDER')?></a>  
                              </td>
                          </tr>
						</tbody>
					</table>
                     <?$intOrderCnt++;
                     if($intOrderCnt > 0){ echo '<div class="liner"></div>';} 
                      ?>
				</div>
               
			<?endforeach?>

		<?endforeach?>

		<?if(strlen($arResult['NAV_STRING'])):?>
			<?=$arResult['NAV_STRING']?>
		<?endif?>

	<?else:?>
		<?=GetMessage('SPOL_NO_ORDERS')?>
	<?endif?>

<?endif?>
<?

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
?>