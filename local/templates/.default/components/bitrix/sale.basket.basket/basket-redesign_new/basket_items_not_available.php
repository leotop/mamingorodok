<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="basket_items_not_available" class="bx_ordercart_order_table_container" style="display:none">
    <table>

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
                            elseif ($arHeader["id"] == "SUM"):
                        ?>                        
                        <?
                            else:
                        ?>
                        <td class="custom" id="col_<?=$arHeader["id"];?>">
                            <?
                                endif;
                            if($arHeader["id"] != "DISCOUNT" && $arHeader["id"]!="SUM") {
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
            <?  $i=0;
                foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

                    if (isset($arItem["NOT_AVAILABLE"]) && $arItem["NOT_AVAILABLE"] == true):
                        $i++;
                        $itemsNoAvailSumm+=$arItem["FULL_PRICE"]*$arItem["QUANTITY"];

                    ?>
                    <tr>
                        <td class="count-prod"><div><?=$i?></div></td>
                        <?
                            foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

                                if (!in_array($arHeader["id"], array("NAME", "PRICE", "QUANTITY", "WEIGHT")))
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
                                        if (is_array($arItem["SKU_DATA"])):
                                            foreach ($arItem["SKU_DATA"] as $propId => $arProp):

                                                // is image property
                                                $isImgProperty = false;
                                                foreach ($arProp["VALUES"] as $id => $arVal)
                                                {
                                                    if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
                                                    {
                                                        $isImgProperty = true;
                                                        break;
                                                    }
                                                }
                                                $countValues = count($arProp["VALUES"]);
                                                $full = ($countValues > 5) ? "full" : "";

                                                if ($isImgProperty):
                                                ?>
                                                <div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

                                                    <span class="bx_item_section_name_gray">
                                                        <?=$arProp["NAME"]?>:
                                                    </span>

                                                    <div class="bx_scu_scroller_container">
                                                        <div class="bx_scu">
                                                            <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
                                                                <?
                                                                    foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                        $selected = "";
                                                                        foreach ($arItem["PROPS"] as $arItemProp):
                                                                            if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                            {
                                                                                if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
                                                                                    $selected = "class=\"bx_active\"";
                                                                            }
                                                                            endforeach;
                                                                    ?>
                                                                    <li style="width:10%;" <?=$selected?>>
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
                                                            <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
                                                                <?
                                                                    foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

                                                                        $selected = "";
                                                                        foreach ($arItem["PROPS"] as $arItemProp):
                                                                            if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
                                                                            {
                                                                                if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
                                                                                    $selected = "class=\"bx_active\"";
                                                                        }
                                                                        endforeach;
                                                                ?>
                                                                <li style="width:10%;" <?=$selected?>>
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
                                    <div style="text-align: center;">
                                        <?echo $arItem["QUANTITY"];
                                            if (isset($arItem["MEASURE_TEXT"]))
                                                echo "&nbsp;".$arItem["MEASURE_TEXT"];
                                        ?>
                                    </div>
                                </td>
                                <?
                                    elseif ($arHeader["id"] == "PRICE"):
                                ?>
                                <td class="price">
                                    <?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
                                        <div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
                                        <div class="old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></div>
                                        <?else:?>
                                        <div class="current_price"><?=$arItem["PRICE_FORMATED"];?></div>
                                        <?endif?>

                                    <?if (strlen($arItem["NOTES"]) > 0):?>
                                        <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                        <div class="type_price_value"><?=$arItem["NOTES"]?></div>
                                        <?endif;?>
                                </td>
                                <?
                                    elseif ($arHeader["id"] == "DISCOUNT"):
                                ?>
                                <td class="custom">
                                    <span><?=$arHeader["name"]; ?>:</span>
                                    <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
                                </td>
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
                                    <?=$arItem[$arHeader["id"]]?>
                                </td>
                                <?
                                    endif;
                                endforeach;

                            if ($bDelayColumn || $bDeleteColumn):
                            ?>
                            <td class="control">
                                <?
                                    /*<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><div><?=GetMessage("SALE_ADD_TO_BASKET")?></div></a><br />*/
                                ?>

                                <?
                                    if ($bDeleteColumn):
                                    ?>
                                    <a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><div><?=GetMessage("SALE_DELETE")?></div></a><br />
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
                        <div>ƒо бесплатной доставки осталось: <span class="summ-free-delivery">500</span> <span class="rouble">a</span></div>
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
                            <td class="fwb" id="allSum_FORMATED"><?=$itemsNoAvailSumm?> <div class="rub_none">руб.</div><span class="rouble">a</span></td>
                        </tr>


                    </table>
                    <div style="clear:both;"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
<?