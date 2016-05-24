<div class="bx_ordercart_order_table_container">
<?
   $dbBasket = CSaleBasket::GetList(Array(), Array("ORDER_ID"=> $arResult["ORDER"]["ACCOUNT_NUMBER"]),false,false,array("*"));
   while($product_order = $dbBasket->Fetch()){
        $arSelect = Array("PROPERTY_MAIN_PRODUCT", "PROPERTY_TSVET","PROPERTY_RAZMER","PROPERTY_SHASSI");
        $arFilter = Array("ID" => $product_order["PRODUCT_ID"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect)->Fetch();

        $produkt_block_2 = CIBlockElement::GetList(Array(), Array("ID" => $res["PROPERTY_MAIN_PRODUCT_VALUE"]), false, Array(), Array("PREVIEW_PICTURE","DETAIL_PICTURE","PROPERTY_TSVET","PROPERTY_RAZMER","PROPERTY_SHASSI"))->Fetch();
        $rsFile = CFile::GetPath($produkt_block_2["PREVIEW_PICTURE"]);
        $rsFile_2 = CFile::GetPath($produkt_block_2["DETAIL_PICTURE"]);
        $product_order["PROPERTY"] = $res;
        $product_order["PREVIEW_PICTURE"] =  $rsFile;
        $product_order["DETAIL_PICTURE"] =  $rsFile_2;
        $arResult["GRID"]["ROWS"][] = $product_order;

   }
   ?>
<?
 // arshow($arResult["GRID"]["ROWS"]);
?>
        <table>
            <thead>
                <tr>
                    <td class="sale_number">№</td>
                    <td class="photo">фото</td>
                    <td class="item" width="50%">Наименование товара</td>
                    <td class="price">Цена</td>
                    <td class="quabtity">Кол-во</td>
                    <td class="sum">Стоимость</td>
                    <?
                    $bPreviewPicture = false;
                    $bDetailPicture = false;
                    $imgCount = 0;
                    // arshow($produkt_block_2);
                    // prelimenary column handling
                    foreach ($arResult["GRID"]["ROWS"] as $id => $arColumn)
                    {   //
                        if ($arColumn["id"] == "PROPS")
                            $bPropsColumn = true;

                        if ($arColumn["id"] == "NOTES")
                            $bPriceType = true;

                        if ($arColumn["id"] == "PREVIEW_PICTURE")
                            $bPreviewPicture = true;

                        if ($arColumn["id"] == "DETAIL_PICTURE")
                            $bDetailPicture = true;
                    }

                    if ($bPreviewPicture || $bDetailPicture)
                        $bShowNameWithPicture = true;


                    foreach ($arResult["GRID"]["ROWS"] as $id => $arColumn):

                        if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
                            continue;

                        if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                            continue;

                        if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
                        ?>
                            <td class="item">
                        <?
                            echo GetMessage("SALE_PRODUCTS");
                        elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
                        ?>
                            <td class="item">
                        <?
                            echo $arColumn["name"];
                        elseif ($arColumn["id"] == "PRICE"):
                        ?>
                            <td class="price">
                        <?
                            echo $arColumn["name"];
                        elseif ($arColumn["id"] == "SUM"):
                        ?>
                            <td class="sum">
                        <?
                            echo 'Стоимость';
                        elseif ($arColumn["id"] == "QUANTITY"):
                        ?>
                            <td class="quabtity">
                        <?
                            echo $arColumn["name"];
                        elseif ($arColumn["id"] == "PRICE_FORMATED"):
                        ?>
                            <td class="custom">
                        <?
                            echo $arColumn["name"];
                        endif;
                        ?>
                            </td>
                    <?endforeach;?>

                </tr>
            </thead>

            <tbody>
                  <?$num = 1?>
                <?foreach ($arResult["GRID"]["ROWS"] as $arData):?>
                <?//arshow($arData)?>
                <tr>
                    <td class="count-prod"><?=$num++?></td>
                    <td class="itemphoto">
                        <div class="bx_ordercart_photo_container">
                            <?
                                if (strlen($arData["PREVIEW_PICTURE"]) > 0):
                                    $url = $arData["PREVIEW_PICTURE"];
                                    elseif (strlen($arData["DETAIL_PICTURE"]) > 0):
                                    $url = $arData["DETAIL_PICTURE"];
                                    else:
                                    $url = $templateFolder."/images/no_photo.png";
                                    endif;
                            ?>

                            <?if (strlen($arData["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                            <?if (strlen($arData["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                        </div>
                        <?
                            if (!empty($arItem["BRAND"])):
                            ?>
                            <div class="bx_ordercart_brand">
                                <img alt="" src="<?=$arData["BRAND"]?>" />
                            </div>
                            <?
                                endif;
                        ?>
                    </td>
                    <td class="itemphoto">
                        <h2 class="bx_ordercart_itemtitle">
                            <?=$arData["NAME"]?>
                        </h2>
                    </td>
                    <td class="price ">
                        <div class="current_price"><?=$arData["PRICE_FORMATED"]?></div>
                        <div class="old_price ">
                            <?
                            if (doubleval($arData["DISCOUNT_PRICE"]) > 0){
                                echo SaleFormatCurrency($arData["PRICE"] + $arData["DISCOUNT_PRICE"], $arData["CURRENCY"]);
                                $bUseDiscount = true;
                            }else{
                                echo SaleFormatCurrency($arData["PRICE"] + $arData["DISCOUNT_PRICE"], $arData["CURRENCY"]);
                                $bUseDiscount = true;
                            };
                            ?>
                        </div>

                        <?if ($bPriceType && strlen($arData["NOTES"]) > 0):?>
                            <div style="text-align: left">
                                <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                <div class="type_price_value"><?=$arData["NOTES"]?></div>
                            </div>
                        <?endif;?>
                    </td>
                    <td class="custom" style="text-align: center;">
                         <span><?=getColumnName($arColumn)?>:</span>
                        <?=$arData["QUANTITY"]*1?>
                    </td>

                    <td class="custom" style="text-align: center;">
                    <?if($arData["DISCOUNT_PRICE"]!=0) { ?>
                            <div class="summ_without_discount"><?=SaleFormatCurrency(($arData["PRICE"] + $arData["DISCOUNT_PRICE"])*$arData["QUANTITY"], $arData["CURRENCY"]);?> <div class="rub_none">руб.</div><span class="rouble">a</span> </div>
                            <div class="summ_discount"><?=GetMessage("SALE_DISCOUNT")?> <?=round(($arData["DISCOUNT_PRICE"] * 100)/$arData["PRICE"]).'%'; ?></div>
                            <div class="summ_with_discount"><?=SaleFormatCurrency($arData["PRICE"], $arData["CURRENCY"])?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                            <?
                        } else {
                            ?>
                            <div id="sum_<?=$arData["ID"]?>">
                                <?
                                    echo SaleFormatCurrency(($arData["PRICE"] + $arData["DISCOUNT_PRICE"])*$arData["QUANTITY"], $arData["CURRENCY"]);?>
                                    <div class="rub_none">руб.</div>
                                    <span class="rouble">a</span>
                            </div>
                            <?
                        } ?>
                        </td>
                    <?
                    // prelimenary check for images to count column width
                    foreach ($arResult["GRID"]["ROWS"] as $id => $arColumn)
                    {
                        $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData;
                        if (is_array($arItem[$arColumn["id"]]))
                        {
                            foreach ($arItem[$arColumn["id"]] as $arValues)
                            {
                                if ($arValues["type"] == "image")
                                    $imgCount++;
                            }
                        }
                    }

                    foreach ($arResult["GRID"]["ROWS"] as $id => $arColumn):

                        $class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

                        if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
                            continue;

                        if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
                            continue;

                        $arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData;

                        if ($arColumn["id"] == "NAME"):
                            $width = 50 - ($imgCount * 20);
                        ?>
                            <td class="item" style="width:<?=$width?>%">

                                <h2 class="bx_ordercart_itemtitle">
                                <?//arshow($arItem);
                                $db_vals = CCatalogSku::GetProductInfo($arItem["PRODUCT_ID"]);    // определяет является ли товар торговым предложением
                                if(!empty($db_vals)){
                                    $ar_item = CIBlockElement::GetList(
                                         Array("SORT"=>"ASC"),
                                         Array("IBLOCK_ID" => $db_vals["IBLOCK_ID"], "ID" => $db_vals["ID"]),
                                         false,
                                         false,
                                         Array()
                                        )->GetNext();
                                }else{
                                    $ar_item = CIBlockElement::GetList(
                                         Array("SORT"=>"ASC"),
                                         Array("IBLOCK_ID" => $arItem["IBLOCK_ID"], "ID" => $arItem["ID"]),
                                         false,
                                         false,
                                         Array()
                                        )->GetNext();
                                }                // $ar_item - Выводит массив с url страницы товара
                                ?>

                                    <?if (strlen($ar_item["DETAIL_PAGE_URL"]) > 0):?>
                                        <a href="<?=$ar_item["DETAIL_PAGE_URL"] ?>">
                                    <?endif;?>
                                        <?=$arItem["NAME"]?>
                                    <?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                </h2>
                                <div class="bx_ordercart_itemart">
                                    <div class="propProduct">
                                        <?
                                            $i=0;
                                            foreach ($arItem["PROPERTY"] as $key => $item) {
                                                if ($key=="PROPERTY_TSVET_VALUE") {
                                                    if($item != '') echo 'цвет'.': '.$item.' / ';
                                                }elseif($key=="PROPERTY_RAZMER_VALUE" ){
                                                    if($item != '') echo 'Размер'.': '.$item;
                                                }elseif($key=="PROPERTY_SHASSI_VALUE" ){
                                                    if($item != '') echo ' / Шасси'.': '.$item;
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="bx_ordercart_itemart">
                                    <?
                                    if ($bPropsColumn):
                                        foreach ($arItem["PROPS"] as $val):
                                            echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
                                        endforeach;
                                    endif;
                                    ?>
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

                                        $full = (count($arProp["VALUES"]) > 5) ? "full" : "";

                                        if ($isImgProperty): // iblock element relation property
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
                                                                    if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
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

                                                    <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                    <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
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
                                                    <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                    <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
                                                </div>

                                            </div>
                                        <?
                                        endif;
                                    endforeach;
                                endif;
                                ?>
                            </td>
                        <?
                        elseif ($arColumn["id"] == "PRICE_FORMATED"):
                        ?>
                            <td class="price <?//if (doubleval($arItem["DISCOUNT_PRICE"]) > 0){echo "right";}?>">
                                <div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
                                <div class="old_price ">
                                    <?
                                    if (doubleval($arItem["DISCOUNT_PRICE"]) > 0){
                                        echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
                                        $bUseDiscount = true;
                                    }else{
                                        echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
                                        $bUseDiscount = true;
                                    };
                                    ?>
                                </div>

                                <?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
                                    <div style="text-align: left">
                                        <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                        <div class="type_price_value"><?=$arItem["NOTES"]?></div>
                                    </div>
                                <?endif;?>
                            </td>
                        <?
                        elseif ($arColumn["id"] == "DISCOUNT"):
                        ?>
                            <!--<td class="custom right">
                                <span><?=getColumnName($arColumn)?>:</span>
                                <?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
                            </td>    -->
                        <?
                        elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
                        ?>
                            <td class="itemphoto">
                                <div class="bx_ordercart_photo_container">
                                    <?
                                    $url = "";
                                    if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["DETAIL_PICTURE_SRC"]) > 0)
                                        $url = $arData["DETAIL_PICTURE_SRC"];

                                    if ($url == "")
                                        $url = $templateFolder."/images/no_photo.png";

                                    if (strlen($arData["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                        <div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
                                    <?if (strlen($arData["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                </div>
                            </td>
                        <?
                        elseif (in_array($arColumn["id"], array("QUANTITY"))):
                        ?>
                            <td class="custom" style="text-align: center;">
                                <span><?=getColumnName($arColumn)?>:</span>
                                <?=$arItem[$arColumn["id"]]*1?>
                            </td>
                         <?

                        elseif (in_array($arColumn["id"], array("SUM"))):?>
                            <td class="custom" style="text-align: center;">
                            <?if($arData["DISCOUNT_PRICE"]!=0) { ?>
                                    <div class="summ_without_discount"><?=SaleFormatCurrency(($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"])*$arItem["QUANTITY"], $arItem["CURRENCY"]);?> <div class="rub_none">руб.</div><span class="rouble">a</span> </div>
                                    <div class="summ_discount"><?=GetMessage("SALE_DISCOUNT")?> <?=round(($arItem["DISCOUNT_PRICE"] * 100)/$arItem["PRICE"]).'%'; ?></div>
                                    <div class="summ_with_discount"><?=SaleFormatCurrency($arItem["PRICE"], $arItem["CURRENCY"])?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                    <?
                                } else {
                                    ?>
                                    <div id="sum_<?=$arData["ID"]?>">
                                        <?
                                            echo SaleFormatCurrency(($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"])*$arItem["QUANTITY"], $arItem["CURRENCY"]);?>
                                            <div class="rub_none">руб.</div>
                                            <span class="rouble">a</span>
                                    </div>
                                    <?
                                } ?>
                                </td>
                                <?
                             else: // some property value

                            if (is_array($arItem[$arColumn["id"]])):

                                foreach ($arItem[$arColumn["id"]] as $arValues)
                                    if ($arValues["type"] == "image")
                                        $columnStyle = "width:20%";
                            ?>
                            <!--<td class="custom" style="<?=$columnStyle?>">
                                <span><?=getColumnName($arColumn)?>:</span>
                                <?
                                foreach ($arItem[$arColumn["id"]] as $arValues):
                                    if ($arValues["type"] == "image"):
                                    ?>
                                        <div class="bx_ordercart_photo_container">
                                            <div class="bx_ordercart_photo" style="background-image:url('<?=$arValues["value"]?>')"></div>
                                        </div>
                                    <?
                                    else: // not image
                                        echo $arValues["value"]."<br/>";
                                    endif;
                                endforeach;
                                ?>
                            </td>  -->
                            <?
                            else: // not array, but simple value
                            ?>
                            <!--<td class="custom" style="<?=$columnStyle?>">
                                <span><?=getColumnName($arColumn)?>:</span>
                                <?
                                    echo $arItem[$arColumn["id"]];
                                ?>
                            </td>  -->
                            <?
                            endif;
                        endif;

                    endforeach;
                    ?>
                </tr>
                <?$arorder = $arData["PRICE"] * $arData["QUANTITY"]?>
                <?$arPrice += $arorder;?>
                <?//arshow($arData)?>
                <?endforeach;?>
            </tbody>
        </table>
    </div>