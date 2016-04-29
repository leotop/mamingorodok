<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    $bDelayColumn  = false;
    $bDeleteColumn = false;
    $bWeightColumn = false;
    $bPropsColumn  = false;
?>
<div id="basket_items_delayed" class="bx_ordercart_order_table_container" style="display:none">
    <table id="delayed_items">
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
                $i=0;
                foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
                    if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y"):
                        $i++;
                    ?>
                    <tr id="<?=$arItem["ID"]?>">
                        <td class="count-prod"><div><?=$i?></div></td>
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
                                                    if ($key=="TSVET" || $key=="RAZMER" || $key=="SHASSI" ) {
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
                                                            <a href="javascript:void(0);" class="plus" onclick="delay_upd(<?=$arItem["ID"]?>, 'up', <?=$arItem["QUANTITY"]?>, <?=$arItem["PRICE"]?>);">&#9650</a>
                                                            <a href="javascript:void(0);" class="minus" onclick="delay_upd(<?=$arItem["ID"]?>, 'down', <?=$arItem["QUANTITY"]?>, <?=$arItem["PRICE"]?>);">&#9660</a>
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
                                        <?=$arItem["PRICE"]?> <div class="rub_none">руб.</div><span class="rouble">a</span>
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
                                <td class="custom">
                                    <span><?=$arHeader["name"]; ?>:</span>
                                    <?
                                        if ($arHeader["id"] == "SUM"){
                                            if($arItem["DISCOUNT_PRICE"]!=0) { ?>
                                            <div class="summ_without_discount"><?=$arItem["FULL_PRICE"]*$arItem["QUANTITY"]?> <div class="rub_none">руб.</div><span class="rouble">a</span> </div>  
                                            <div class="summ_discount"><?=GetMessage("SALE_DISCOUNT")?> <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]; ?></div>
                                            <div class="summ_with_discount"><?=str_replace('руб.', '', $arItem[$arHeader["id"]])?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                            <?
                                            } else {
                                            ?>
                                            <div id="sum_<?=$arItem["ID"]?>"><?=$arItem["FULL_PRICE"]*$arItem["QUANTITY"]?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                            <?            
                                                $itemsDelaySumm+=$arItem["FULL_PRICE"]*$arItem["QUANTITY"];
                                            }
                                        } 
                                ?>
                            </td>
                            <?
                                endif;
                                endforeach;
                                $ElementID = $arItem["PRODUCT_ID"]; // ID предложения
                                $mxResult = CCatalogSku::GetProductInfo($ElementID);  //получаем id товара по id торгового предложения
                               
                                
                                ?>
                                <?
     
                                $arSelect = Array("ID", "NAME","PROPERTY_PRODUCT_ID", "PROPERTY_USER_ID");
                                $arFilter = Array("IBLOCK_ID"=>8, "NAME" => $mxResult, "PROPERTY_USER_ID_VALUE" => $USER->GetID());
                                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                                while($ob = $res->Fetch())
                                {
                                    if($mxResult["ID"] == $ob["PROPERTY_PRODUCT_ID_VALUE"] and  $ob["PROPERTY_USER_ID_VALUE"] == $USER->GetID()){
                                         $arElement_ID = $ob;          // выводим товары из инфоблока WishList
                                    }  
 
                                }
                                
    
                             // arshow($USER->GetID());     

                                    
                            if ($bDelayColumn || $bDeleteColumn):
                            ?>
                            <input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y">
                            <td align="center" class="control">
                                <?
                                    if ($bDelayColumn):
                                    ?>
                                    <a class=" js-wish-delete" data-id="<?=$arElement_ID["ID"]?>"  href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><div><?=GetMessage("SALE_ADD_TO_BASKET")?></div></a><br />
                                    <?
                                        endif;

                                    if ($bDeleteColumn):
                                    ?>
                                    <?//arshow($arItem);?>
                                    <a class=" js-wish-delete" data-id="<?=$arElement_ID["ID"]?>" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><div><?=GetMessage("SALE_DELETE")?></div></a>
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

                    <?
                        /*
                        ?>
                        <div class="free-delivery">
                        <div>До бесплатной доставки осталось: <span class="summ-free-delivery">500</span> <span class="rouble">a</span></div>
                        <div class="car-delivery">
                        <div id="car" class="car"></div>
                        <div id="top-road" class="top-road"></div>
                        <div class="bottom-road"></div>
                        </div>
                        </div>
                        <?
                        */  
                    ?>
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
                        <?   /*
                            ?> <tr>
                            <td class="custom_t1"><?=GetMessage("SALE_SUMM")?></td>
                            <td class="custom_t2" style="color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
                            <?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
                            <?=$itemsDelaySumm?> <span class="rouble">a</span>
                            <?endif;?>
                            </td>
                            </tr>
                            <?  if($arResult["DISCOUNT_PRICE_ALL"]!=0) {                                      
                            ?>
                            <tr>
                            <td class="fwb"><?=GetMessage("SALE_ECONOMY")?></td>
                            <td class="fwb" id="allSumDiscount"><?=$arResult["DISCOUNT_PRICE_ALL"]?> <span class="rouble">a</span></td>
                            </tr>
                            <?
                            }*/
                        ?>
                        <tr>  
                            <td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
                            <td class="fwb" id="allSum_FORMATED"><?=$itemsDelaySumm?> <div class="rub_none">руб.</div><span class="rouble">a</span></td>
                        </tr>


                    </table>
                    <div style="clear:both;"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
<?   