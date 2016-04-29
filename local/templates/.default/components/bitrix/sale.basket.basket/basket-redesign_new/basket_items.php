<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    use Bitrix\Sale\DiscountCouponsManager;

    if (!empty($arResult["ERROR_MESSAGE"]))
        ShowError($arResult["ERROR_MESSAGE"]);

    $bDelayColumn  = false;
    $bDeleteColumn = false;
    $bWeightColumn = false;
    $bPropsColumn  = false;
    $bPriceType    = false;

    if ($normalCount > 0):
    ?>   
    <div id="basket_items_list">
    <div class="bx_ordercart_order_table_container" id="bx_ordercart_order_table_container">
        <table id="basket_items">
            <thead>
                <tr>
                    <td class="sale_number"><?=GetMessage("SALE_NUMBER")?></td>

                    <?
                        foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):
                            $arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
                            if ($arHeader["name"] == '')
                                $arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
                            $arHeaders[] = $arHeader["id"];

                            // remember which values should be shown not in the separate columns, but inside other columns
                            if (in_array($arHeader["id"], array("TYPE")))
                            {
                                $bPriceType = true;
                                continue;
                            }
                            elseif ($arHeader["id"] == "PROPS")
                            {
                                $bPropsColumn = true;
                                continue;
                            }
                            elseif ($arHeader["id"] == "DELAY")
                            {
                                $bDelayColumn = true;
                                continue;
                            }
                            elseif ($arHeader["id"] == "DELETE")
                            {
                                $bDeleteColumn = true;
                                continue;
                            }
                            elseif ($arHeader["id"] == "WEIGHT")
                            {
                                $bWeightColumn = true;
                            }

                            if ($arHeader["id"] == "NAME"):
                            ?>
                            <td class="item photo"><div><?=GetMessage("SALE_PHOTO")?></div></td>
                            <td class="item"  id="col_<?=$arHeader["id"];?>">
                            <?
                                elseif ($arHeader["id"] == "PRICE"):
                            ?>
                            <td class="price" id="col_<?=$arHeader["id"];?>">
                            <?
                                elseif ($arHeader["id"] == "DISCOUNT"):
                            ?>
                            <?
                                else:
                            ?>
                            <td class="custom" id="col_<?=$arHeader["id"];?>">
                                <?
                                    endif;
                                if($arHeader["id"] != "DISCOUNT") {
                                    echo $arHeader["name"]; 
                                }

                            ?>
                        </td>
                        <?
                            endforeach;

                        if ($bDeleteColumn || $bDelayColumn): 
                        ?> 
                        <td class="custom"><?=GetMessage("SALE_ACTION")?></td>
                        <?
                            endif;
                    ?>
                </tr>
            </thead>

            <tbody>
                <?       
                    $num=0;
                    foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
                     
                     $ommon_price += $arItem["PRICE"];
                     
                     $num++;     
                        if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
                        ?>   
                        <tr id="<?=$arItem["ID"]?>">
                            <td class="count-prod"><div><?=$num?></div></td>
                            <?
                                foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

                                    if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
                                        continue;

                                    if ($arHeader["id"] == "NAME"):
                                    ?>
                                    <td class="itemphoto">
                                        <div class="bx_ordercart_photo_container">
                                            <?
                                                if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
                                                    $url = $arItem["PREVIEW_PICTURE_SRC"];
                                                    elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
                                                    $url = $arItem["DETAIL_PICTURE_SRC"];
                                                    else:
                                                    $url = $templateFolder."/images/no_photo.png";
                                                    endif;
                                            ?>

                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                        </div>
                                        <?
                                            if (!empty($arItem["BRAND"])):
                                            ?>
                                            <div class="bx_ordercart_brand">
                                                <img alt="" src="<?=$arItem["BRAND"]?>" />
                                            </div>
                                            <?
                                                endif;
                                        ?>
                                    </td>
                                    <td class="item">
                                        <h2 class="bx_ordercart_itemtitle">
                                            <?
                                            ?>
                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                <?=$arItem["NAME"]?>
                                            <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                        </h2>
                                        <div class="bx_ordercart_itemart">
                                            <div class="propProduct">
                                                <?   
                                                    $i=0;
                                                    foreach ($arItem["CATALOG"]["PROPERTIES"] as $key => $item) {
                                                        if ($key=="TSVET" || $key=="RAZMER" || $key=="SHASSI") {
                                                            if   ($item["VALUE"]!=''){
                                                                if($i>=1) {
                                                                    echo " / ";
                                                                }
                                                                echo $item["NAME"].': '.$item["VALUE"];
                                                                $i++;
                                                            }       
                                                        }
                                                    }

                                                ?>
                                            </div>
                                        </div>
                                        <?
                                            if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
                                                foreach ($arItem["SKU_DATA"] as $propId => $arProp):

                                                    // if property contains images or values
                                                    $isImgProperty = false;
                                                    if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"]))
                                                    {
                                                        foreach ($arProp["VALUES"] as $id => $arVal)
                                                        {
                                                            if (!empty($arVal["PICT"]) && is_array($arVal["PICT"])
                                                                && !empty($arVal["PICT"]['SRC']))
                                                            {
                                                                $isImgProperty = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    $countValues = count($arProp["VALUES"]);
                                                    $full = ($countValues > 5) ? "full" : "";

                                                    if ($isImgProperty): // iblock element relation property
                                                    ?>
                                                    <div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

                                                        <span class="bx_item_section_name_gray">
                                                            <?=$arProp["NAME"]?>:
                                                        </span>

                                                        <div class="bx_scu_scroller_container">

                                                            <div class="bx_scu">
                                                                <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
                                                                    style="width: 200%; margin-left:0%;"
                                                                    class="sku_prop_list"
                                                                    >
                                                                    <?
                                                                        foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                            $selected = "";
                                                                            foreach ($arItem["PROPS"] as $arItemProp):
                                                                                if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                                {
                                                                                    if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
                                                                                        $selected = "bx_active";
                                                                                }
                                                                                endforeach;
                                                                        ?>
                                                                        <li style="width:10%;"
                                                                            class="sku_prop <?=$selected?>"
                                                                            data-value-id="<?=$arSkuValue["XML_ID"]?>"
                                                                            data-element="<?=$arItem["ID"]?>"
                                                                            data-property="<?=$arProp["CODE"]?>"
                                                                            >
                                                                            <a href="javascript:void(0);">
                                                                                <span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
                                                                            </a>
                                                                        </li>
                                                                        <?
                                                                            endforeach;
                                                                    ?>
                                                                </ul>
                                                            </div>

                                                            <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                            <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                        </div>

                                                    </div>
                                                    <?
                                                        else:
                                                    ?>
                                                    <div class="bx_item_detail_size_small_noadaptive <?=$full?>">

                                                        <span class="bx_item_section_name_gray">
                                                            <?=$arProp["NAME"]?>:
                                                        </span>

                                                        <div class="bx_size_scroller_container">
                                                            <div class="bx_size">
                                                                <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
                                                                    style="width: 200%; margin-left:0%;"
                                                                    class="sku_prop_list"
                                                                    >
                                                                    <?
                                                                        foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                            $selected = "";
                                                                            foreach ($arItem["PROPS"] as $arItemProp):
                                                                                if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                                {
                                                                                    if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                                        $selected = "bx_active";
                                                                            }
                                                                            endforeach;
                                                                    ?>
                                                                    <li style="width:10%;"
                                                                        class="sku_prop <?=$selected?>"
                                                                        data-value-id="<?=($arProp['TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory' ? $arSkuValue['XML_ID'] : $arSkuValue['NAME']); ?>"
                                                                        data-element="<?=$arItem["ID"]?>"
                                                                        data-property="<?=$arProp["CODE"]?>"
                                                                        >
                                                                        <a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
                                                                    </li>
                                                                    <?
                                                                        endforeach;
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                        <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                    </div>

                                                </div>
                                                <?
                                                    endif;
                                                    endforeach;
                                                endif;
                                        ?>
                                    </td>
                                    <?
                                        elseif ($arHeader["id"] == "QUANTITY"):
                                    ?>
                                    <td class="custom">
                                        <span><?=$arHeader["name"]; ?>:</span>
                                        <div class="centered">
                                            <table cellspacing="0" cellpadding="0" class="counter">
                                                <tr>
                                                    <td>
                                                        <?
                                                            $ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
                                                            $max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
                                                            $useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
                                                            $useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
                                                        ?>
                                                        <input
                                                            type="text"
                                                            size="3"
                                                            class="quantity_input"
                                                            id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                                            name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
                                                            size="2"
                                                            maxlength="18"
                                                            min="0"
                                                            <?=$max?>
                                                            step="<?=$ratio?>"
                                                            style="max-width: 50px"
                                                            value="<?=$arItem["QUANTITY"]?>"
                                                            onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
                                                            >
                                                    </td>
                                                    <?
                                                        if (!isset($arItem["MEASURE_RATIO"]))
                                                        {
                                                            $arItem["MEASURE_RATIO"] = 1;
                                                        }

                                                        if (
                                                            floatval($arItem["MEASURE_RATIO"]) != 0
                                                        ):
                                                        ?>
                                                        <td id="basket_quantity_control">
                                                            <div class="basket_quantity_control">
                                                                <a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);">&#9650</a>
                                                                <a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);">&#9660</a>
                                                            </div>
                                                        </td>
                                                        <?
                                                            endif;

                                                    ?>
                                                </tr>
                                            </table>
                                        </div>
                                        <input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
                                    </td>
                                    <?
                                        elseif ($arHeader["id"] == "PRICE"):
                                    ?>
                                    <td class="price">
                                        <div class="current_price" id="current_price_<?=$arItem["ID"]?>">
                                        <?//arshow($arItem)?>
                                            <?=$arItem["FULL_PRICE"]?><div class="rub_none">руб.</div> <span class="rouble">a</span>
                                        </div>
                                    </td>
                                    <?
                                        elseif ($arHeader["id"] == "DISCOUNT"):
                                    ?>
                                    <?
                                        elseif ($arHeader["id"] == "WEIGHT"):
                                    ?>
                                    <td class="custom">
                                        <span><?=$arHeader["name"]; ?>:</span>
                                        <?=$arItem["WEIGHT_FORMATED"]?>
                                    </td>
                                    <?
                                        else:
                                    ?>
                                    <td class="custom" id="allPrice">
                                        <span><?=$arHeader["name"]; ?></span>
                                        <?
                                            if ($arHeader["id"] == "SUM"){
                                                if($arItem["DISCOUNT_PRICE"]!=0) { ?>
                                                <div class="summ_without_discount"><?=$arItem["FULL_PRICE"]*$arItem["QUANTITY"]?> <div class="rub_none">руб.</div><span class="rouble">a</span> </div>  
                                                <div class="summ_discount"><?=GetMessage("SALE_DISCOUNT")?> <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]; ?></div>
                                                <div class="summ_with_discount"><?=str_replace('руб.', '', $arItem[$arHeader["id"]])?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                                <?
                                                } else {
                                                ?>
                                                <div id="sum_<?=$arItem["ID"]?>"> 
                                                    <?
                                                        echo str_replace('руб.', '', $arItem[$arHeader["id"]]);?> <div class="rub_none">руб.</div> <span class="rouble">a</span></div>
                                                <?            
                                                }
                                            } 
                                    ?>
                                </td>
                                <?
                                    endif;
                                    endforeach;
                                    
                                $ElementID = $arItem["PRODUCT_ID"]; // ID предложения
                                $mxResult = CCatalogSku::GetProductInfo($ElementID);   //получаем id товара по id торгового предложения
                               
                                
                                if ($bDelayColumn || $bDeleteColumn):
                               // arshow($arItem);
                                ?>      
                                <td align="center" class="control">
                                    <?
                                        if ($bDelayColumn):
                                        ?>
                                        <a  data-id="<?=$mxResult["ID"]?>" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><div><?=GetMessage("SALE_DELAY")?></div></a><br />  <?//class="add addToLikeList" класс для добавления товара в избранное?>
                                        <?
                                            endif;

                                        if ($bDeleteColumn):
                                        ?>
                                        <a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><div><?=GetMessage("SALE_DELETE")?></div></a>
                                        <?
                                            endif;
                                    ?>
                                </td>
                                <?
                                    endif;
                            ?>
                        </tr>
                        <?
                            endif;
                        endforeach;
                           ?>
            </tbody>
        </table>
        <table class="itemsFooter" id="itemsFooter">
            <tr>
                <td colspan="3" class="coupon-tr">
                    <div class="bx_ordercart_order_pay_left" id="coupons_block">
                        <div class="free-delivery">
                            <div><p>До бесплатной доставки осталось:</p> <span class="summ-free-delivery">500</span> <div class="rub_none">руб.</div><span class="rouble">a</span> <div class="discover">!?</div></div>
                            <div class="discover_hover">
                            Стоимость доставки для Москвы (в пределах МКАД)<br>
                            Сумма заказа..................Стоимость доставки (основной тариф) <br>
                            До 1500 руб............................................500 руб.     <br>
                            От 1500 руб. до 3000 руб...................350 руб.  <br>
                            От 3000 руб. до 5000 руб...................200 руб.   <br>
                            От 5000 руб............................................Бесплатно
                            
                            </div>
                            <div class="car-delivery">
                                <div id="car" class="car"></div>
                                <div id="top-road" class="top-road"></div>
                                <div class="bottom-road"></div>
                            </div>
                        </div>
                        <?
                            if ($arParams["HIDE_COUPON"] != "Y")
                            {
                            ?>
                            <div class="bx_ordercart_coupon">
                                <input type="text" id="coupon" placeholder="<?=GetMessage("STB_COUPON_PROMT")?>" name="COUPON" value="" onchange="enterCoupon();"><a href="<?=$APPLICATION->GetCurPage();?>"  class="button-coupon" onclick="enterCoupon();"><?=GetMessage("BTN_COUPON_PROMT")?></a>
                            </div><?
                                if (!empty($arResult['COUPON_LIST']))
                                {
                                    foreach ($arResult['COUPON_LIST'] as $oneCoupon)
                                    {
                                        $couponClass = 'disabled';
                                        switch ($oneCoupon['STATUS'])
                                        {
                                            case DiscountCouponsManager::STATUS_NOT_FOUND:
                                            case DiscountCouponsManager::STATUS_FREEZE:
                                                $couponClass = 'bad';
                                                break;
                                            case DiscountCouponsManager::STATUS_APPLYED:
                                                $couponClass = 'good';
                                                break;
                                        }
                                    ?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
                                            if (isset($oneCoupon['CHECK_CODE_TEXT']))
                                            {
                                                echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
                                            }
                                        ?></div></div><?
                                    }
                                    unset($couponClass, $oneCoupon);
                                }
                            }
                            else
                            {
                            ?>&nbsp;<?
                            }
                        ?>
                    </div>
                </td>
                <td colspan="4" class="sum">
                    <div id="sum_order" class="bx_ordercart_order_pay_right">
                        <table class="bx_ordercart_order_sum">
                            <?if ($bWeightColumn):?>
                                <tr>
                                    <td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
                                    <td class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></td>
                                </tr>
                                <?endif;?>
                            <?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
                                <tr>
                                    <td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
                                    <td id="allSum_wVAT_FORMATED"><?=$arResult["allSum_wVAT_FORMATED"]?></td>
                                </tr>
                                <tr>
                                    <td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
                                    <td id="allVATSum_FORMATED"><?=$arResult["allVATSum_FORMATED"]?></td>
                                </tr>
                                <?endif;?>
                            <tr>
                                <td class="custom_t1"><?=GetMessage("SALE_SUMM")?></td>
                                <td class="custom_t2" style="color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
                                    <?/*if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
                                        <?=str_replace('руб.', '', $arResult["PRICE_WITHOUT_DISCOUNT"])?> <span class="rouble">a</span>
                                        <?endif;?>
                                        <?
                                        if (empty($arResult["PRICE_WITHOUT_DISCOUNT"])) {
                                        $str=str_replace('руб.', '', $arResult["PRICE_WITHOUT_DISCOUNT"]);
                                        echo $str;
                                        }
                                    */?> <?=str_replace('руб.', '', $arResult["PRICE_WITHOUT_DISCOUNT"])?> <div class="rub_none">руб.</div><span class="rouble">a</span>
                                </td>
                            </tr>
                            <?  if($arResult["DISCOUNT_PRICE_ALL"]!=0) {                                      
                                ?>
                                <tr>
                                    <td class="fwb"><?=GetMessage("SALE_ECONOMY")?></td>
                                    <td class="fwb" id="allSumDiscount"><?=$arResult["DISCOUNT_PRICE_ALL"]?><div class="rub_none">руб.</div> <span class="rouble">a</span></td>
                                </tr>
                                <?
                                }
                            ?>
                            <tr>  
                                <td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
                                <td class="fwb" id="allSum_FORMATED"><?=str_replace(" ", "&nbsp;", $arResult["allSum"])?> <div class="rub_none">руб.</div><span class="rouble">a</span></td>
                            </tr>


                        </table>
                        <div style="clear:both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
    <input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
    <input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
    <input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
    <input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
    <input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

     
    <?  global $USER;
        if ($USER->IsAuthorized()) {   
        ?>
        <div class="bx_ordercart_order_pay">
            <div style="clear:both;"></div>
            <div class="bx_ordercart_order_pay_center">

                <?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
                    <?=$arResult["PREPAY_BUTTON"]?>
                    <span><?=GetMessage("SALE_OR")?></span>
                    <?endif;?>

                <a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
            </div>
        </div> 
        <?
        } else {
        ?>
        <br><br>
        <div class="authRegBasketForm">
            <div id="auth-bttn" class="auth-btn bttn <?if(!empty($_POST["register_submit_button"])){ echo '';}else{echo 'current';}?>">Авторизация</div>
            <div id="reg-bttn" class="reg-btn bttn <?if(!empty($_POST["register_submit_button"])){ echo 'current';}else{echo '';}?>">Регистрация</div>
            <div id="fastorder-bttn" class="fast-order-btn bttn">Быстрый заказ</div>
              <?//arshow(!empty($_POST["register_submit_button"]))?>
            <div class="auth-form bForm" <?if(!empty($_POST["register_submit_button"])){ echo 'style="display: none;"';}else{echo '';}?>>
                <?$APPLICATION->IncludeComponent(
                        "bitrix:system.auth.form",
                        "basket-auth",
                        Array(
                            "SHOW_ERRORS" => "Y",
                        )
                    );?>
            </div>
            <div class="reg-form bForm" <?if(!empty($_POST["register_submit_button"])){ echo 'style="display: block;"';}else{echo '';}?>>
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.register", 
                        "basket-reg", 
                        array(
                            "COMPONENT_TEMPLATE" => "basket-reg",
                            "SHOW_FIELDS" => array(
                                0 => "EMAIL",
                                1 => "NAME",
                                2 => "PERSONAL_PHONE", 
                                //3 => "PERSONAL_CITY",
                                //4 => "PERSONAL_NOTES",
                            ),
                            "REQUIRED_FIELDS" => array(
                                0 => "EMAIL",
                                1 => "NAME",
                                2 => "PERSONAL_PHONE",
                            ),
                            "AUTH" => "Y",
                            "USE_BACKURL" => "Y",
                            "SUCCESS_PAGE" => "/basket/order/",
                            "USER_PROPERTY" => array(
                            ),
                            "USER_PROPERTY_NAME" => ""
                        ),
                        false
                    );?>
            </div>
            <?//arshow($arItem)?>
            <div class="fastorder-form bForm">
                <a title="Быстрый заказ" class="checkout"><div class="fastOrderBtn">Оформить быстрый заказ</div></a>      
            </div>

            <form method="post" id="OrderForm">
                <input type="hidden" name="frmQuickOrderSent" value="Y">
                <input type="hidden" name="price" id="price" value="<?=$ommon_price?>">
                <div class="notify"></div>
                <ul>
                    <li>Имя*</li>
                    <li>
                        <input type="text" name="qoName" id="qoName" value="" class="i">
                    </li>
                    <li>Телефон*</li>
                    <li>
                        <input type="text" name="qoPhone" id="qoPhone" value="" class="i">
                    </li>
                    <li>Email*</li>
                    <li>
                        <input type="email" name="qoEmail" id="qoEmail" value="" class="i">
                    </li>
                    <li>Комментарий</li>
                    <li>
                        <textarea style="width:268px;" name="qoComment" id="comments" ></textarea>
                    </li>
                    <li class="last">
                        <input type="button" value="Оформить заказ" onclick="sendData()" id="qoSend" class="input2">
                        <div id="page-preloader"></div>
                    </li>
                </ul>
                <div class="form_alert"></div>
                <div class="form_alert_error"></div>    
                <a title="" href="#" onclick="$('#OrderForm').hide(); $('#fancybox-tmp').hide(); return false;" class="closePopupContainer close1"></a>
            </form>
          </div>
            <? }
        ?>
    </div>
                                          

    <?
        else:
    ?>
    <div id="basket_items_list">
        <table>
            <tbody>
                <tr>
                    <td colspan="<?=$numCells?>" style="text-align:center">
                        <div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?
        endif;
?>
<script>
$(function(){
    $("body").on( 'click','#regBtnClick', function(){
     var check = $( '#reg-check:checkbox:checked' ).length;
         if(check < 1){
             $(".reg_input").show();                          
         }
    });
    $('#close_reg').click(function(){
        $(".reg_input").hide();
    });
    $("body").on( 'click','.fastorder-form .checkout', function(){
       $('#OrderForm').show(); 
       $('#fancybox-tmp').show();
    });    
    
})
function sendData(){
        $("#qoSend").css('display','none');
        $("#page-preloader").css('display','block');
        
        var name = $("#qoName").val();
        var email = $("#qoEmail").val();
        var phone = $("#qoPhone").val();
        var price = $("#price").val();
        var comments = $("#comments").val();
        if (name && email && phone && price) {
            $.post("/ajax/quick_order_ajax.php",{
                name: name,
                email: email,
                phone: phone,
                price: price,
                comments: comments,
                },
                function(data){
               //     console.log(data);
                    $("#OrderForm ul").html("");
                    $(".form_alert_error").css("display","none");
                    $(".form_alert").html("<span>Ваш заказ принят -  ожидайте звонка менеджера!</span>");
                    setTimeout(function(){ $(".closePopupContainer").click(); }, 2000);
                    
            })
        }
        else if(!name && !phone && !email) {
            $(".form_alert_error").html("Заполните все поля!");
            $(".form_alert_error").css("display","block");
            $("#qoSend").css('display','block');
            $("#page-preloader").css('display','none');
        }
        else if(!phone){ 
            $(".form_alert_error").html("Неправильно заполнено поле 'Телефон'!");
            $("#qoSend").css('display','block');
            $("#page-preloader").css('display','none');
        }
        else if(!email){
            $(".form_alert_error").html("Неправильно заполнено поле 'E-mail'!");
            $("#qoSend").css('display','block');
            $("#page-preloader").css('display','none');
        }

    }
</script>