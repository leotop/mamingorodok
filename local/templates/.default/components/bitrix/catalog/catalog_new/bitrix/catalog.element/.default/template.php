<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $intLocationID = $GLOBALS["CGeoIP"] -> getLocationID();
    $strDeliveryDate = date("d.m.Y", getDeliveryDate(true));

    $singleOffer  = count($arResult["CS"]) <= 1;   //торговые предложения имеют одинаковый размер
    $onlyStandardSize=false;                       

    //если для этого размера несколько цветов, то выводим выбор цвета
    if ($singleOffer)
    {
        $arIndx=array_values($arResult["CS"]);  
        $singleOffer = count($arIndx[0]) <= 1;     
        $onlyStandardSize=true;                   //размер один, значит не выводим выбор размера

    }
    //    farshow($arResult["CS"]);
    foreach ($arResult["CS"] as $arItemCheck => $arCheck) { 
        $arCheckCount= count($arCheck)+$arCheckCount;
    } 
    //    arshow($arCheckCount);
    if($singleOffer && $arCheckCount==1){
    ?>
    <style>
        .soc_block {
            position: absolute;
            border: 1px solid #E7E4E8 !important;
            left: 399px;
            top: 375px;
            width: 535px;
            padding-top: 20px !important;
            padding-bottom: 20px !important; 
        }
        .soc_block div:nth-last-child(1) {
            float:left !important;
            margin-left: 10px;
        }
    </style>
    <?    }
    $price=GetOfferMinPrice($arParams["IBLOCK_ID"],$arResult["CS"]["ID"]);


    //arshow($arResult["CS"],true);
    function getColorHtml($strSize, $arResult)
    {   //echo $strSize.'<br>';
        ob_start();   
        $arColor = $arResult["CS"][$strSize];    
        $arStartOffer = $arResult["START_OFFERS_BY_SIZE"][$strSize];
        //  arshow($strSize,true);

    ?><div id="colorData_<?=md5($strSize)?>">  

        <? //Проверяем если у товара только один цвет
            $arCheckColor = $arResult["CS"];

            foreach ($arCheckColor as $arSizeItemCheck => $arSizeCheck) { 
                $arSizeCheckCount= count($arSizeCheck)+$arSizeCheckCount;
            }  

            if (count($arCheckColor)!=$arSizeCheckCount) {
            ?>
            <div class="sk-product-color--head-list"><span class="s_like">Цвет:</span> <a class="sk-link-btt" id="colorList" data-last-value="<?=$arStartOffer["PROPERTY_TSVET_VALUE"]?>"><span class="sk-dotted"><?=$arStartOffer["PROPERTY_TSVET_VALUE"]?></span></a></div>
            <?} else {?>
            <style type="text/css">
                .jcarousel-skin-color_chose_one {
                    margin-top: 70px;
                }
                .sk-product-choose {
                    left: 15px;
                }
            </style>
            <?
            }
        ?>
        <div class="sk-product-color-list"> 
            <?  
                if(empty($arResult["CS"]["CHASSI"])){
                    $arColorList = $arResult["CS"];
                } else {
                    $arColorList = $arResult["ALL_COLOR"];
                }

                foreach ($arResult["ALL_COLOR"] as $arColorKey => $arColorItem) {
                    if ($arColorItem["~CATALOG_QUANTITY"]>0) { ?>    
                    <div class="sk-product-color-item" id="<?=$arColorItem["ID"]?>" ><?=$arColorItem["PROPERTY_TSVET_VALUE"]?></div>
                    <? } 
                } 



            ?>
        </div>

        <?
        ?>

        <div>
            <ul class="sk-product-color--slider jcarousel jcarousel-skin-color_chose<?=(!$singleOffer?'_one':'')?>">
                <li><?

                        $itemsPerLi = (!$singleOffer ? 1:2);
                        $intCnt = 0;

                        arshow($arResult["CS"]["CHASSI"], true);
                        if (empty($arResult["CS"]["CHASSI"])) {
                            $arColorTemp = $arColor;
                        }  else {
                            $arColorTemp = $arResult["ALL_COLOR"]; 
                        }

                        foreach($arColorTemp as $arOffer){


                            $price=GetOfferMinPrice($arParams["IBLOCK_ID"],$arOffer["ID"]);
                            if ($arOffer["PRICE"] > 0 && $arOffer["CATALOG_QUANTITY"] > 0){             //проверка на количество элементов у которых указана цена ... // проверка на количество элементов на складе

                                global $ar_quantity;  
                                $ar_quantity = $arOffer["~CATALOG_QUANTITY"];
                                $strH1orName = $arResult["SEO_H1_FROM_NAME"] == "Y" ? $arResult["NAME"].' '.$arOffer["PROPERTY_TSVET_VALUE"] : $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];
                                // $strH1orName = $arResult['NAME'].' '.$arOffer['PROPERTY_TSVET_VALUE'];
                                $imgName=GetImgNameArray($arOffer["XML_ID"]);  
                                $watermark = Array(array("name" => "watermark", "position" => "bottomleft",  "file"=>$_SERVER['DOCUMENT_ROOT']."/img/mmm.png"));  
                                if (!empty($imgName))
                                {   
                                    //arshow($imgName); 
                                    $smallImg = getResizedIMGPath($arOffer["XML_ID"]);
                                    $bigImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>376, "height"=>343), BX_RESIZE_IMAGE_PROPORTIONAL, false, $watermark); 
                                } 
                                if($intCnt%$itemsPerLi == 0 && $intCnt>0)                        
                                    echo '</li><li>';?>    

                            <a id="smallOffer<?=$arOffer["ID"]?>" 
                                <?/*href="<?if(empty($bigImg["src"])){echo "/img/no_foto.jpg";}else{echo $bigImg["src"];}?>"*/?> 
                                alt="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>"  
                                rel="useZoom:'zoom2'" 
                                <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                                class="cloud-zoom-gallery sk-product-color--item<?=($intCnt == 0?' sk-product-color--item_active':'' /*or ($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')*/)?><?=($intCnt==0?' first':'')?>" 
                                <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                                data-code="<?=$arOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?>" 
                                data-color="<?=$arOffer["PROPERTY_TSVET_VALUE"]?>" 
                                data-size="<?=$arOffer["PROPERTY_RAZMER_VALUE"]?>"
                                data-img="<?if(empty($bigImg["src"])){echo "/img/no_foto.jpg";}else{echo $bigImg["src"];}?>" 
                                data-offerID="<?=$arOffer["ID"]?>" 
                                data-quantity="<?=$arOffer["~CATALOG_QUANTITY"]?>"
                                data-price="<?=number_format($arOffer["PRICE"], 0, '.', ' ')?>"<?=($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0?'data-old-price="'.number_format($arOffer["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ').'"':'')?>>
                                <div class="sk-product-color--img"> <img src="<?=(empty($smallImg)?'/img/no_photo_52x52.png':$smallImg)?>" titile="" alt="<?=$strH1orName?>"> </div>
                                <div class="sk-product-color--price">

                                    <span class="s_like"><span><?=number_format($arOffer["PRICE"], 0, '.', ' ')?></span>a</span><?

                                        /*
                                        if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
                                        echo 'Нет в продаже';
                                        elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
                                        echo 'Новинка! Ожидаем поставку.';
                                        elseif($arOffer["PRICE"]["PRICE"]["PRICE"]>0) {
                                        ?><strong><span><?=($arOffer["CATALOG_QUANTITY"]<=0?'<font title="Цена последней продажи">':'')?><?=number_format($arOffer["PRICE"]["PRICE"]["PRICE"], 0, '.', ' ')?><?=($arOffer["CATALOG_QUANTITY"]<=0?'</font>':'')?></span> р</strong><?
                                        }
                                */?></div>
                            </a><?
                                $smallImg = '';
                                $bigImg = '';
                                $intCnt++; 

                            }
                    }?>
                </li>
            </ul>
        </div> 

    </div><?
        $strHtml = ob_get_contents();
        ob_end_clean();
        return $strHtml;
    }



    $arStartOffer = $arResult["CS"][$arResult["START_SIZE"]][$arResult["START_COLOR"]];

    /*
    echo $arResult["START_SIZE"]."<br>";
    echo $arResult["START_COLOR"];      */


    //$strH1orName = $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];
    $strH1orName=$arResult['NAME'].' '.$arOffer['PROPERTY_TSVET_VALUE'];
    $watermark = Array(array("name" => "watermark", "position" => "bottomleft",  "file"=>$_SERVER['DOCUMENT_ROOT']."/img/mmm.png"));

    if (!empty($arResult["DETAIL_PICTURE"]["ID"]))
    {
        $bigImg = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL, true, $watermark);
    }
    else
    {   
        $imgName=GetImgNameArray($arStartOffer["XML_ID"]);  //с.м. result_modifier
        $bigImg["src"] = "/img/no_foto.jpg";
        $bigImg["width"] = "376";
        $bigImg["height"] = "342";
        /*  if (!empty($imgName)) 
        {    
        $bigImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL, false, $watermark); 
        //            $bigImg = $imgName['MAXI'];   
        }   */
    }

    //arshow($bigImg,true);
    $user_id = $USER->GetID();
    $pr=0;
    foreach($arResult["LINKED_ITEMS"] as $arElem)
        if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0) $pr++;

        $arTmpSizeHtml = array(); 
    if (!$singleOffer) {
        foreach($arResult["CS"] as $strSize => $arColor) {
            // arshow($strSize,true); 
            $arTmpSizeHtml[$strSize] = getColorHtml($strSize, $arResult); 
        }

    }
?>
<!-- product_block -->

<span itemscope itemtype="http://data-vocabulary.org/Product">
    <div class="product_block"> 
        <h1 class="product_name" itemprop="name"><?=$strH1orName?></h1> 
        <div class="infobar_product_name">
            <div class="top-div">
                <script>
                    $(function(){
                        var produkt_id = "<?=print_r($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"][$arResult["ID"]]["ID"])?>";
                        if(produkt_id != '1'){
                            var check = false; 
                            $('.product_compare label').css({"background-position": "0 10%"});
                        }else{ 
                            var check = true;
                        }
                        $(".product_compare label").click(function(){
                            if($(".product_compare input").prop("checked") == true ){    
                                check = true;
                                $('.product_compare label').css({"background-position": "0 10%"}); 
                                var compareCount =parseInt(<?=count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])?>);  
                            }else if(check = true){
                                check = false;  
                                $('.product_compare label').css({"background-position": "0 100%"}); 
                                var compareCount =parseInt(<?=count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])?>); 
                            }
                        });
                    });
                </script>
                <?//arshow($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"][$arResult["ID"]]);?>
                <div class="product_compare">  
                    <label><input type="checkbox" class="input2 add-to-compare-list-ajax" value="<?=$arResult["ID"]?>" /></label>
                    <i title="/catalog/compare/">Сравнить</i>
                </div> 
                <?
                    //arshow($arResult["PROPERTY_1238"]);
                ?> 
                <div class="product_code"><span class="s_like">Код:</span> <? if ($arResult["PROPERTY_1238"]["2"]!="") { ?>
                    <span><?=$arResult["PROPERTY_1238"]["2"]?></span>
                    <? } ?>
                </div>
            </div>
            <?  //Определение количества товара в наличии 
                if ($arStartOffer["~CATALOG_QUANTITY"]<=2){
                    $productQuantity = '<span class="low-quant">заканчивается</span>';
                    $img_name='low-battery';
                } elseif ($arStartOffer["~CATALOG_QUANTITY"]<=5 && $arStartOffer["~CATALOG_QUANTITY"]>=3) {
                    $productQuantity = '<span class="enough-quant">достаточно</span>';
                    $img_name='enough-battery';
                } elseif ($arStartOffer["~CATALOG_QUANTITY"]>=6) {
                    $productQuantity = '<span class="high-quant">достаточно</span>';
                    $img_name='high-battery';
                };
            ?>
            <div id="product-quantity" class="product-quantity"><img class="battery-quantity" src="/bitrix/templates/nmg/img/<?=$img_name?>.png">Наличие: <?=$productQuantity?></div>
            <div class="infobar-div">
                <ul class="sk-product-info-bar">
                    <li>
                        <div class="rating detailPage"> #RATING# #REPORT_COUNT# </div>
                    </li>
                    <li>
                        <?=showNoindex()?>
                        <div class="links "> 
                            #ADD_TO_WISH_LIST#
                        </div>
                        <?=showNoindex(false)?>
                    </li>

                </ul>
            </div> 
        </div>   
        <!-- product_block_photo -->

        <div class="product_block_photo">
            <div id="large" class="sk-product-img">
                <div class="photo" style=" top: 20px; position: relative; left: 20px; ">
                    <?$APPLICATION->IncludeFile("/includes/shields_2.php",array("props" => $arResult["PROPERTIES"]),array("SHOW_BORDER" => false))?>
                </div>
                <div class="sk-product-img--zoom"><a href="#" class="">Смотреть все фото</a></div>
                <table>
                    <tr>
                        <td>
                            <?//arshow($bigImg);?>
                            <a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" 
                                alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?> " 
                                id='zoom2'  
                                class="cloud-zoom sk-product-images" 
                                rel="useZoom: 'zoom2', adjustX:0,adjusty:-50">
                                <img src="<?=$bigImg["src"]?>" 
                                    title="<?=$arResult["NAME"]?>" 
                                    alt="<?=$strH1orName?>" 
                                    width="<?if($bigImg["width"] == 0){echo "auto";}else{echo $bigImg["width"];}?>"                   
                                    height="<?if($bigImg["height"] == 0){echo "342";}else{echo $bigImg["height"];}?>"
                                    data-last-img="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"  
                                    itemprop="image"/>                        
                            </a>
                        </td>
                    </tr>
                </table>
                <?
                    if($arResult["ACTIVE"] == "N")
                        echo '<div class="element_inactive">Деактивирован</div>';
                    if(strlen($arResult["ACTION"]["PREVIEW_TEXT"])>0)
                    {?>
                    <div class="sk-product-gift sk-product-gift_close"><div class="sk-product-gift-ico"></div>
                        <div class="sk-product-gift_o"></div>
                        <div class="sk-product-gift--head"><?=(strlen($arResult["ACTION"]["PROPERTY_TITLE_VALUE"])>0?$arResult["ACTION"]["PROPERTY_TITLE_VALUE"]:$arResult["ACTION"]["NAME"])?></div>
                        <div class="sk-product-gift--cont"> <?=$arResult["ACTION"]["PREVIEW_TEXT"]?> </div>
                    </div><?
                }?>

            </div><?
                $arCommonImg = array();    
                if($arResult["DETAIL_PICTURE"]["ID"]>0) $arCommonImg[] = $arResult["DETAIL_PICTURE"]["ID"];  
                if(!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) $arCommonImg = array_merge($arCommonImg, $arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]);


                $strGallery = '';
                if(!empty($arCommonImg)|| !empty($bigImg["src"]))
                {
                ?>

                <ul id="sk-tumb-slider" class="jcarousel jcarousel-skin-tumb sk-tumb"><?
                        foreach($arCommonImg as $intCnt => $intImgID)
                        {
                            $smallImg = CFile::ResizeImageGet($intImgID, array("width"=>52, "height"=>44), BX_RESIZE_IMAGE_PROPORTIONAL);

                            if(!empty($intImgID)){
                                $bigImg = CFile::ResizeImageGet($intImgID, array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL, false, $watermark);
                                $galleryBigImg = CFile::ResizeImageGet($intImgID, array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL, false, $watermark); 
                            }else{
                                $bigImg["src"] = "/img/no_foto.jpg";
                                $bigImg["width"] = "376";
                                $bigImg["height"] = "342";  
                                $galleryBigImg["src"] = "/img/no_foto.jpg"; 
                            }


                            if($intCnt == 0) $strStartBigImage = $galleryBigImg["src"];

                            $strGallery .= '<li  '.
                            (strlen($strGallery)>0?'':' class="sk-tumb_active"').
                            '><a id="gallery'.
                            $intImgID.
                            '" class="cloud-zoom-gallery"   data-orig='.
                            CFile::GetPath($intImgID).
                            ' alt="'.CFile::GetPath($intImgID).
                            '" href="'.$galleryBigImg["src"].
                            '" title="" rel="useZoom: \'zoom1\', zoomWidth: \'400\'"><img src="'.
                            $smallImg["src"].'"  alt="" /></a></li>';
                        ?>
                        <?if(!empty($intImgID)){?>
                            <li<?=($intCnt==0?' class="sk-tumb_active"':'')?>><a id="small<?=$intImgID?>" class="cloud-zoom-gallery"  href="<?=$bigImg["src"]?>" alt="<?=CFile::GetPath($intImgID)?>"   title="" rel="useZoom: 'zoom2', zoomWidth: '400'"><img src="<?=$smallImg["src"]?>"  alt="<?=$strH1orName?>" /></a></li><?
                            }
                    }?>
                </ul><?
            }?>
            <div class="soc_block"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
                $arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false)); ?></div>

        </div>
        <!-- EDN product_block_photo --> 
        <!-- product_block_info -->
        <div class="product_block_info">

            <input type="hidden" id="offerID" value="<?=$arStartOffer["ID"]?>" />
            <input type="hidden" id="productID" value="<?=$arResult["ID"]?>" />


            <div class="sk-product-price-bar">

                <?
                    if ($arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"]) {
                    ?>

                    <?if (!$singleOffer):?>

                        <div class="sk-product-price-holder">



                            <div class="sk-product-price">
                                <div class="sk-product-price--cont" id="priceHere"><?

                                        if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
                                        {
                                        ?>
                                        <div class="sk-product-price-old"><?=$arStartOffer["PROPERTY_OLD_PRICE_VALUE"] ?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                        <div class="sk-product-price-new<?=($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923?' sk-product-price-new-preorder':'')?>"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span><?

                                            /*
                                            if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
                                            echo '<strong>Новинка! Ожидаем поставку.</strong>';
                                            elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
                                            echo 'Нет в продаже';
                                            else {
                                            ?><?
                                            }
                                        */?></div><?
                                        } else {


                                        ?>

                                        <?//if($USER->IsAdmin()){arshow($arOffer["PROPERTY_OLD_PRICE_VALUE"]);}   
                                            //$price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arResult["ID"]); ?>
                                        <?$arDiscounts = CCatalogDiscount::GetDiscountByProduct(
                                                $arResult["ID"],
                                                $USER->GetUserGroupArray(),
                                                "N",
                                                $arResult["PRICES_ALLOW"][0],
                                                SITE_ID
                                            );
                                            if(empty($arDiscounts)){

                                                foreach($arColor as $arOffer){          
                                                    if ($arOffer["PRICE"] > 0 && $arOffer["CATALOG_QUANTITY"] > 0){    
                                                        $arDiscounts_product = CCatalogDiscount::GetDiscountByProduct(
                                                            $arOffer["ID"],
                                                            $USER->GetUserGroupArray(),
                                                            "N",
                                                            $arResult["PRICES_ALLOW"][0],
                                                            SITE_ID
                                                        );
                                                        if($arDiscounts_product[0]["VALUE_TYPE"] == "P"){
                                                            $bonus_discount_procent = ($arStartOffer["PRICE"] * round($arDiscounts_product[0]["VALUE"]))/100;
                                                            $bonus_discount = $arStartOffer["PRICE"] - $bonus_discount_procent;
                                                        }else{
                                                            $bonus_discount = $arStartOffer["PRICE"] - round($arDiscounts_product[0]["VALUE"]);
                                                        }
                                                        // arshow($bonus_discount,true);
                                                    }
                                                }
                                            }else{
                                                // arshow($arDiscounts,true);
                                                if($arDiscounts[0]["VALUE_TYPE"] == "P"){
                                                    $bonus_discount_procent = ($arStartOffer["PRICE"] * round($arDiscounts[0]["VALUE"]))/100; 
                                                    $bonus_discount = $arStartOffer["PRICE"] - $bonus_discount_procent;
                                                }else{
                                                    $bonus_discount = $arStartOffer["PRICE"] - round($arDiscounts[0]["VALUE"]);
                                                }
                                        } ?>
                                        <?//arshow($arDiscounts)?>
                                        <?if($bonus_discount > 0 and $arStartOffer["PRICE"] != $bonus_discount){ ?>
                                            <div class="sk-product-price-one prise_cena"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span> </div> 

                                            <div class="sk-product-price-one prise_discount"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($bonus_discount, 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span> </div> 
                                            <? }else{?>
                                            <div class="sk-product-price-one"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span>
                                                <?

                                                    /*
                                                    if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920)
                                                    echo '<strong>Новинка! Ожидаем поставку.</strong>';
                                                    elseif($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100916)
                                                    echo 'Нет в продаже';
                                                    else {
                                                    ?><?
                                                    }
                                                    */


                                            ?></div><?
                                            }
                                        }
                                        if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                        { ?>
                                        <span class="sk-item-preorder">под заказ</span><?
                                    }?>
                                </div>
                            </div>



                            <div class="sk-product-price-count">

                                <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" id="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" readonly> 
                                <a class="count_arrow dec" href="javascript:void(0)" onclick="if (BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value &gt; 1) BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value--;">&#9660;</a>
                                <a class="count_arrow inc" href="javascript:void(0)" onclick="BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value++;">&#9650;</a> 
                                <?/*<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="шт. В корзину" class="add_b_item">*/?>
                            </div>
                            <div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);after_buy();post_func();" href="#" class="addToCartButton">Купить</a></div>

                            <?if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
                                {?>
                                <div class="price-deliter"></div>
                                <div class="sk-product-price-order"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy1click', 'card']);" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить <br> в 1 клик</a></div><?
                                }
                            ?>
                            <?/*<div class="sk-product-price-credit"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy_credit', 'card']);" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит - <span id="creditprice"></span> р.</a></div>*/?>

                        </div>

                        <?else:?>

                        <div class="left_col">
                            <div class="sk-product-price-single">
                                <div class="sk-product-price--cont single" id="priceHere"><?
                                    if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
                                    {?>
                                    <div class="sk-product-price-old"><?=$arStartOffer["PROPERTY_OLD_PRICE_VALUE"]?> <div class="rub_none">руб.</div><span class="rouble">a</span></div>
                                    <div class="sk-product-price-new<?=($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923?' sk-product-price-new-preorder':'')?>"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span>

                                    </div><?
                                    } else {

                                    ?>
                                    <div class="sk-product-price-one sk-product-price-one-single"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <div class="rub_none">руб.</div><span class="rouble">a</span><?


                                    ?></div><?
                                    }
                                    if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                    { ?>
                                    <span class="sk-item-preorder">под заказ</span><?
                                }?>
                            </div>
                        </div>
                        <div class="sk-product-price-count">
                            <input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" id="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" readonly> 
                            <a class="count_arrow inc" href="javascript:void(0)" onclick="BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value++;">&#9650;</a> 
                            <a class="count_arrow dec" href="javascript:void(0)" onclick="if (BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value &gt; 1) BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value--;">&#9660;</a>

                            <?/*<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="шт. В корзину" class="add_b_item">*/?>
                        </div>
                    </div>

                    <div class="right_col">
                        <div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);post_func();" href="#" class="addToCartButton">Купить</a></div>


                        <?if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
                            {?>
                            <div class="price-deliter"></div>
                            <div class="sk-product-price-order"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy1click', 'card']);" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить в 1 клик</a></div><?
                            }
                        ?>
                    </div>
                    <div class="single-price-deliter"></div>  
                    <?//Скрываем поле если стандарт 
                        if($arStartOffer["PROPERTY_TSVET_VALUE"]!="Стандарт") {
                        ?>   
                        <div class="single-price-color">Цвет: <span><?=$arStartOffer["PROPERTY_TSVET_VALUE"]?></span></div>
                        <?/*<div class="sk-product-price-credit"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy_credit', 'card']);" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит - <span id="creditprice"></span> р.</a></div>*/?>
                        <? } ?>

                    <?endif;?>
                    <?}?>
                <div class="sk-product-colorchoose-wrap">
                    <?//arshow($arStartOffer);?>
                    <div id="skProductColor" class="sk-product-color">
                        <?=$arTmpSizeHtml[$arStartOffer["PROPERTY_RAZMER_VALUE"]];
                        //                        arshow($arStartOffer, true);
                        ?>
                    </div>

                    <?

                        if(!$singleOffer)
                        {
                            $strTmp = '';
                            $strSelectedSize = '';
                            foreach($arResult["CS"] as $strSize => $arFoo)
                            {
                                if($arResult["SIZE_AVAIL"][$strSize] == "Y")
                                    $htmlCross = '';
                                else $htmlCross = '<div class="cross"></div>';

                                if($strSize == $arStartOffer["PROPERTY_SHASSI"]) {$strSelectedSize = $strSize;}
                                if($strSize == $arStartOffer["PROPERTY_RAZMER_VALUE"]) {$strSelectedSize = $strSize;}


                                if ($arResult["SIZE_AVAIL"][$strSize] == "Y") {
                                    if ($strSize!="Стандарт") {
                                        $strTmp .= '
                                        <li'.($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':' sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_RAZMER_VALUE"]?' class="sk-product-choose--item_active"':'').' id="lisize_'.md5($strSize).'"><a href="javascript:void(0)" title="'.$strSize.'" data-color="'.$strSize.'">'.$strSize.'</a></li>';
                                    } 
                                }  
                        }?>
                        <?//arshow($arResult["CS"],true)?>
                        <?if (!$onlyStandardSize && empty($arResult["CS"]["CHASSI"]) ){?>

                            <div class="sk-product-choose">
                                <div class="sk-product-choose--head">
                                    <span class="s_like size_span"><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0 ? 'Выберите '.$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].':':'Выберите размер:')?></span> <span id="sizeLabel"><?=$strSelectedSize?></span>
                                </div>
                                <ul class="sk-product-choose--item" id="sk-product-choose--item"><?=$strTmp?>
                                </ul>
                            </div><?
                            }

                            if(!empty($arResult["CS"]["CHASSI"])) { ?>

                            <div class="sk-product-choose">
                                <div class="sk-product-choose--head">
                                    <span class="s_like chassi-title"><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0 ? 'Выберите '.$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].':':'Выберите шасси:')?></span> <span class="chassi-select" id="sizeLabel"><?=$arStartOffer["PROPERTY_SHASSI_VALUE"]?></span>
                                </div>
                                <ul class="sk-product-choose--item" id="sk-product-choose--item">
                                    <? foreach ($arResult["CS"]["CHASSI"] as $strChassi => $arChassi){ 
                                            //                                                arshow($arChassi, true);
                                            if ($arChassi["PRICE"] > 0 && $arChassi["CATALOG_QUANTITY"] > 0){
                                            ?> 
                                            <li ><a class="chassiItem chassi<?=$arChassi["ID"]?>" <? if($arStartOffer["PROPERTY_TSVET_VALUE"]!=$arChassi["PROPERTY_TSVET_VALUE"]){ echo 'style="display: none"'; }?> id="<?=$arChassi["ID"]?>"><?=$arChassi["PROPERTY_SHASSI_VALUE"]?></a></li>
                                            <?} 
                                        } 
                                        //arshow($arStartOffer, true) ;  
                                    ?>
                                </ul>
                            </div>
                            <?}
                    }?>
                    <? 
                        $arDiscounts = CCatalogDiscount::GetDiscountByProduct(
                            $arResult["ID"],
                            $USER->GetUserGroupArray(),
                            "N",
                            $arResult["PRICES_ALLOW"][0],
                            SITE_ID
                        );


                        if(empty($arDiscounts)){

                            foreach($arColor as $arOffer){          
                                if ($arOffer["PRICE"] > 0 && $arOffer["CATALOG_QUANTITY"] > 0){    
                                    $arDiscounts_product = CCatalogDiscount::GetDiscountByProduct(
                                        $arOffer["ID"],
                                        $USER->GetUserGroupArray(),
                                        "N",
                                        $arResult["PRICES_ALLOW"][0],
                                        SITE_ID
                                    );
                                    $bonus_discount = round($arDiscounts_product[0]["VALUE"]);
                                    // arshow($bonus_discount);
                                }
                            }
                        }else{
                            $bonus_discount = round($arDiscounts[0]["VALUE"]);
                        }


                    ?>
                    <div class="sk-under-color">
                        <div class="sk-bonus">Ваша скидка <span><?=$bonus_discount?></span> <div class="rub_none">руб.</div><span class="rouble">i</span></div>
                        <div class="sk-supply">Официальная поставка</div>
                        <div class="sk-question">Задать вопрос</div>
                    </div>
                </div>
            </div>


            <div class="sk-small-description-wrap">
                <div class="sk-sd-features-deliter" ></div>
                <table class="sk-small-description">
                    <tr>
                        <td><ul class="sk-sd-features">
                                <li>
                                    <div class="sk-sd-features--head">Характеристики</div>
                                </li>

                                <?/*                               <li<?=(empty($arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"])?' class="hidden"':'')?> id="CODE_1C_CONT"><span class="s_like">Код товара:</span> <span id="CODE_1C"><?=$arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?></span></li>*/?><?//   arshow($arResult["DISPLAY_PROPERTIES"]["PROIZVODITEL"]["DISPLAY_VALUE"] );
                                    if(strlen($arResult["DISPLAY_PROPERTIES"]["PROIZVODITEL"]["DISPLAY_VALUE"])>0)
                                    {?>
                                    <li><span class="s_like">Производитель:</span> <?=$arResult["DISPLAY_PROPERTIES"]["PROIZVODITEL"]["DISPLAY_VALUE"]?></li><?
                                    }
                                    if(strlen($arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITELYA"]["DISPLAY_VALUE"])>0)
                                    {?>
                                    <li><span class="s_like">Страна:</span> <?=$arResult["DISPLAY_PROPERTIES"]["STRANA_PROIZVODITELYA"]["DISPLAY_VALUE"].(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0?' ('.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].')':'')?></li><?
                                    }


                                    if(strlen($arResult["DISPLAY_PROPERTIES"]["GARANTIYA_PROIZVODITELYA"]["DISPLAY_VALUE"])>0)
                                    {?>
                                    <?/*<li><span class="s_like">Гарантия:</span> <?=$arResult["DISPLAY_PROPERTIES"]["GARANTIYA_PROIZVODITELYA"]["DISPLAY_VALUE"]?></li>*/?>
                                    <?
                                }?>
                                <li><a id="allParamLink" href="#characteristic_block" title="Все характеристики" class="sk-dotted">Все характеристики</a></li>
                            </ul>
                        </td>
                        <td>

                            <script src="http://api-maps.yandex.ru/2.0.31/?load=package.full&lang=ru-RU" type="text/javascript"></script>

                            <?$_ses_ar = GetInfoMMByName($_SESSION["ALTASIB_GEOBASE_CODE"]["CITY"]["NAME"]);?>

                            <script type="text/javascript">
                                var mkad_coords = [[[55.897702887224796,37.67240905761718],[55.89664192633831,37.6752414703369],[55.89591852721012,37.67807388305662],[55.8956291637662,37.6829662322998],[55.89538802590739,37.687686920166],[55.89553270880329,37.69146347045898],[55.89529157034246,37.69669914245605],[55.89466460330075,37.69996070861816],[55.89312125646775,37.705282211303704],[55.89215663339145,37.70751380920409],[55.89152961547806,37.70957374572752],[55.89046848506115,37.712148666381815],[55.888635554797155,37.715324401855455],[55.8874296322104,37.71798515319823],[55.88622367199341,37.720216751098604],[55.88545183770592,37.722448348999016],[55.884872951875,37.72493743896484],[55.884872951875,37.73025894165038],[55.88279853978146,37.73025894165038],[55.8811582281455,37.73111724853514],[55.880000319199695,37.7330913543701],[55.87903536858371,37.735065460205064],[55.87816689243558,37.737468719482415],[55.87464453915709,37.743562698364244],[55.86373768471359,37.76553535461424],[55.84804765603748,37.79574775695799],[55.833558904954586,37.8228702545166],[55.83148173964286,37.82776260375975],[55.83090204571783,37.83093833923339],[55.82925953247555,37.831968307495096],[55.824331574788744,37.83746147155761],[55.82186736083274,37.83866310119629],[55.81930634494508,37.83995056152341],[55.81640687737011,37.84115219116209],[55.815923611680155,37.84321212768552],[55.815198701844565,37.84458541870117],[55.814038817900894,37.84381294250486],[55.81244392079273,37.84252548217771],[55.81075229152879,37.84063720703125],[55.80698210925112,37.84106636047361],[55.80209966167469,37.841667175292955],[55.80011750252675,37.84192466735837],[55.780193594328715,37.84381294250486],[55.77913351008552,37.844783264391616],[55.77845628577709,37.84701486229202],[55.77792417267178,37.84813066124222],[55.776618045932416,37.84778733848831],[55.77526349769469,37.84581323265335],[55.773812143546046,37.844697433703146],[55.75997317538473,37.84426828026078],[55.753487486017335,37.84435411094925],[55.75198691106874,37.8441824495723],[55.74898558725352,37.84383912681839],[55.74675864876349,37.845555740587926],[55.7449673229946,37.84950395225785],[55.74482207674487,37.85173555015823],[55.74332116703625,37.85019059776566],[55.741481263136315,37.844869095080114],[55.736784271297495,37.8430666506221],[55.73179612239952,37.84289498924515],[55.731166504711425,37.844697433703146],[55.72898698012023,37.84177919029495],[55.72491820726679,37.841521698229506],[55.72080056319119,37.84092088341019],[55.71818442163351,37.845126587145536],[55.716585581821896,37.84435411094925],[55.71571345967627,37.840405899279325],[55.713823794608125,37.84135003685256],[55.7119340377362,37.84461160301467],[55.710722606838814,37.84461160301467],[55.709414219096786,37.84169335960648],[55.70985035323334,37.83731599449416],[55.70849347541899,37.83851762413284],[55.70645806996491,37.83971925377152],[55.70587650599171,37.83774514793656],[55.705149538801436,37.83551355003615],[55.70350169621928,37.8343119203975],[55.701708376470975,37.833110290758825],[55.69758827484921,37.83216615318557],[55.69356469588598,37.83156533836623],[55.6894922165988,37.832766968004904],[55.686631530014225,37.83499856590531],[55.684207054812255,37.83748765587111],[55.6821703789833,37.83499856590531],[55.680279084622,37.834655243151396],[55.678775682559596,37.83620019554396],[55.675235183954115,37.83723016380569],[55.667182989135455,37.840405899279325],[55.66053624948339,37.84203668236037],[55.65641179002368,37.84263749717971],[55.6535972024768,37.84014840721388],[55.64859838232795,37.83448358177445],[55.64529783914648,37.83027787803908],[55.64243390621512,37.82572885154982],[55.63913284127208,37.824613052599645],[55.637919144215985,37.818604904406286],[55.62854813179519,37.80358453392288],[55.61820341705874,37.78667588829299],[55.617086218110366,37.78899331688187],[55.614948878859664,37.78959413170121],[55.61509461025296,37.7873625338008],[55.614997456051206,37.784444290392614],[55.614997456051206,37.78075357078811],[55.61120825360195,37.773543792956076],[55.60217097907149,37.75852342247268],[55.59726276567736,37.74642129539749],[55.59342323822858,37.736464935534215],[55.59118739019748,37.733718353502965],[55.58875697549044,37.73251672386429],[55.58875697549044,37.72891183494826],[55.5889514142296,37.72530694603226],[55.58584027831145,37.71826882957717],[55.58345814747422,37.7134623110225],[55.58127034840715,37.7057375490596],[55.57845033787414,37.69964357017777],[55.577088880670665,37.695094543688505],[55.575532871526356,37.692691284411154],[55.57358777301203,37.692262130968786],[55.57120489546283,37.69234796165726],[55.57188573243677,37.689773041002965],[55.57266381732086,37.68642564415238],[55.572128885626164,37.68239160179398],[55.57057267908735,37.67071862816117],[55.57042678154921,37.655612426989286],[55.57086447253071,37.645570236437536],[55.571496684188844,37.63930459617874],[55.57208025510925,37.63381143211625],[55.57208025510925,37.62437005638381],[55.57266381732086,37.621108490221694],[55.57353914430943,37.61527200340529],[55.57383091561797,37.61115213035842],[55.573879543957716,37.606860595934606],[55.573101483264445,37.603684860460966],[55.57144805288571,37.60196824669143],[55.56896777623045,37.60308404564163],[55.56648734226576,37.601624923937536],[55.5659036878825,37.59759088157914],[55.56673052902162,37.59467263817092],[55.57008635184344,37.593642669909215],[55.57378228721773,37.59252687095901],[55.57601913103611,37.58969445823929],[55.57699163191336,37.5841154634883],[55.57854758300307,37.577163177721715],[55.579617263456626,37.5727858126094],[55.58039519449406,37.569524246447294],[55.58195101012762,37.56188531517287],[55.58972915951208,37.530900436632834],[55.58919446129312,37.52729554771683],[55.590652711931135,37.52592225670121],[55.592256724782665,37.52223153709671],[55.59313161313196,37.5185408174922],[55.59415229144777,37.51373429893752],[55.59677677040253,37.50738282799025],[55.599012298609146,37.50369210838577],[55.60192801271931,37.49931474327346],[55.604843509200315,37.49776979088089],[55.60722433656079,37.494594055407255],[55.6090220079864,37.491332489245146],[55.60790454629169,37.48910089134476],[55.60596105848462,37.48747010826369],[55.611256835447605,37.488585907213896],[55.61412305735588,37.48686929344436],[55.61834913630358,37.48111863731642],[55.62340040051834,37.47622628807327],[55.62786828167662,37.47099061607619],[55.632044316744654,37.46661325096388],[55.63592859929264,37.46172090172073],[55.63665685921782,37.458373504870146],[55.63626845561624,37.45622773765824],[55.63578294567616,37.45348115562697],[55.63811333828267,37.455111938708036],[55.64068631839994,37.455541092150426],[55.64660838237857,37.44910379051468],[55.6556353723766,37.43837495445512],[55.65903208541546,37.43416925071975],[55.659905478070506,37.431079345934585],[55.66063329033317,37.42884774803421],[55.660875891400586,37.426616150133825],[55.66330181902196,37.429105240099624],[55.66655232529556,37.427817779772475],[55.680279084622,37.4175180971553],[55.688910399066174,37.41305490135452],[55.69293445909798,37.407990890734396],[55.698994005599275,37.40052362083694],[55.70049662715336,37.39691873192091],[55.702726216740054,37.39503045677445],[55.705343398046864,37.393142181627965],[55.70626421627299,37.39176889061234],[55.70960805709442,37.3874773561885],[55.71144946990421,37.38567491173048],[55.71237014362427,37.382413345568374],[55.712757789198164,37.38078256248733],[55.714938223574464,37.3838724672725],[55.718620457447926,37.38224168419143],[55.72307743204297,37.38009591697952],[55.72661358103612,37.378207641833036],[55.72985880462025,37.37657685875199],[55.72981037043872,37.37219949363968],[55.72951976408239,37.36653466820022],[55.73005254074289,37.3611273348262],[55.731892985754094,37.37134118675492],[55.734992485659596,37.373057800524435],[55.74501573829052,37.368680435412145],[55.751212398090566,37.36773629783889],[55.76215096246012,37.36799378990431],[55.76418345353268,37.36550469993851],[55.76655455864643,37.36610551475785],[55.76849004730127,37.368251281969755],[55.77158662843581,37.36567636131546],[55.77361862555876,37.36893792747757],[55.77739205226982,37.36893792747757],[55.7812134822765,37.36885209678909],[55.78493780505847,37.369023758166044],[55.787404367494126,37.37031121849319],[55.78943553645033,37.36885209678909],[55.791369884195,37.36430307029983],[55.792530446538024,37.374259430163114],[55.79562510967724,37.377520996325224],[55.80031498774618,37.381898361437536],[55.80442420841985,37.38533158897659],[55.808484657453775,37.387563186876974],[55.82303110743136,37.39185472130082],[55.83076121703942,37.39417214988967],[55.831727372273825,37.39099641441603],[55.83192060042838,37.388421493761754],[55.831775679402845,37.38558908104201],[55.83414265491183,37.38576074241899],[55.83568835674609,37.38782067894242],[55.834625693362945,37.392369705431676],[55.835640054497695,37.39554544090529],[55.839648936077,37.39468713402053],[55.84394715517475,37.391940551989286],[55.84814832383642,37.39133973716995],[55.85452164003844,37.39460130333206],[55.85959057388015,37.39674707054397],[55.86311429845631,37.399665313952184],[55.866782492613076,37.40378518699905],[55.86924384891148,37.407733398668974],[55.8718980772097,37.41219659446976],[55.873876565242476,37.418204742663114],[55.875565438348396,37.4226679384639],[55.87947369034666,37.43477006553909],[55.88121056442022,37.44077821373244],[55.884442872291174,37.4417223513057],[55.88285087383534,37.4453272402217],[55.88285087383534,37.44970460533402],[55.882995603677216,37.458287674181676],[55.883815729211854,37.46661325096388],[55.885745367711415,37.47339387535355],[55.888784352998634,37.48257775902054],[55.889122003279596,37.48549600242873],[55.889218474246576,37.488500076525426],[55.89119607599798,37.492619949572294],[55.89433109088146,37.49450822471878],[55.894041715548205,37.50043054222366],[55.90055213634929,37.51373429893752],[55.90416856273664,37.52214570640823],[55.9071096731802,37.532445389025426],[55.90826676999187,37.54059930443069],[55.91115936034281,37.54471917747756],[55.90870067235796,37.5464357912471],[55.91038802410236,37.56274362205765],[55.91130398417253,37.57338662742874],[55.91140039975807,37.58248468040726],[55.91072548560348,37.58737702965042],[55.91279839869436,37.59055276512405],[55.90870067235796,37.594071823351584],[55.90720609923871,37.6005949556758],[55.90508467033431,37.60797639488478],[55.90064857878059,37.626687484972685],[55.89789987512875,37.64428277611039],[55.89621197772044,37.65990396141311],[55.89577793503864,37.668057876818395],[55.897702887224796,37.67240905761718]]];

                                ymaps.ready(init);

                                function init()
                                {
                                    //карта с центром на москве
                                    var myMap = new ymaps.Map("map_distance", {
                                        center: [55.73, 37.75],
                                        zoom: 9,
                                        behaviors: ['default', 'scrollZoom']
                                    });

                                    //нарисуем полигон мкада.
                                    var mkad_polygon = new ymaps.Polygon(mkad_coords);
                                    ymaps.geoQuery(mkad_polygon).addToMap(myMap);                        

                                    var route_bef;
                                    //смотрим на координаты щелчка
                                    var coords ='<?=$_ses_ar["latitude"];?>, <?=$_ses_ar["longitude"];?>';

                                    //составляем маршрут между центром полигона и кликом
                                    ymaps.route([
                                        [55.752277349454076,37.62085099815628],    //приблизительный центр полигона
                                        coords
                                    ]).then(function (route) {

                                        if(route_bef)
                                            myMap.geoObjects.remove(route_bef);

                                        //составляем коллекцию сегментов пути
                                        var pathsObjects = ymaps.geoQuery(route.getPaths()),
                                        edges = [];

                                        //переберём сегменты и разобьём их на отрезки-линии
                                        pathsObjects.each(function (path) {
                                            var coordinates = path.geometry.getCoordinates();
                                            for (var i = 1, l = coordinates.length; i < l; i++) {
                                                edges.push({
                                                    type: 'LineString',
                                                    coordinates: [coordinates[i], coordinates[i - 1]]
                                                });
                                            }
                                        });

                                        //добавим эту выборку на карту, но показывать не будем
                                        // она нужна только для расчётов
                                        var routeObjects = ymaps.geoQuery(edges).setOptions('visible', false).addToMap(myMap);

                                        //находим сегменты, попадающие внутрь мкад
                                        var objectsInMoscow = routeObjects.searchInside(mkad_polygon),
                                        //объекты за пределами МКАД получим исключением полученных выборок из исходной (так проще!).
                                        objectsOutMoscow = routeObjects.remove(objectsInMoscow),
                                        //находим начальную точку полученной выборки
                                        start_coords = objectsOutMoscow.get(0).geometry.getCoordinates()[1];
                                        //удаляем расчётный маршрут с карты
                                        routeObjects.removeFromMap(myMap);

                                        //строим маршрут от стартовой точки до клика
                                        ymaps.route([
                                            start_coords,
                                            coords
                                        ]).then(function (needed_route) {
                                            //длина маршрута
                                            // window.distance;
                                            distance = Math.round(needed_route.getLength()/1000);

                                            //подписываем начало и конец маршрута
                                            needed_route.getWayPoints().each(function(point){
                                                if (point.properties.get('iconContent') == '1')
                                                {
                                                    point.properties.set('iconContent', 'МКАД');
                                                    point.options.set('preset', 'twirl#blueStretchyIcon');
                                                }
                                                if (point.properties.get('iconContent') == '2')
                                                {
                                                    point.options.set('preset', 'twirl#blueStretchyIcon');
                                                    point.properties.set('iconContent', distance+' км.');
                                                }
                                                //point.properties.set('visible', false);
                                            }); 

                                            if(distance < 10){
                                                var z=document.getElementById("map_distance");
                                                z.innerHTML = ' 30р. за километр';  
                                            }else if(distance > 10 && distance < 30){
                                                var z=document.getElementById("map_distance");
                                                z.innerHTML = ' 35р. за километр';
                                            }else if(distance > 30 && distance < 50){
                                                var z=document.getElementById("map_distance");
                                                z.innerHTML = ' 40р. за километр';
                                            }else if(distance > 50){
                                                var z=document.getElementById("s_like"),
                                                x=document.getElementById("off_title");
                                                z.innerHTML = ' Дотавка в ваш город не осуществляется';
                                                x.innerHTML = ' ';

                                            }

                                            /*myMap.geoObjects.add(needed_route);
                                            needed_route.options.set({ strokeWidth: 5, strokeColor: '0000ffff', opacity: 0.5 });

                                            route_bef = needed_route;     */
                                            //  document.getElementById('map_distance').innerHTML(distance);

                                        });// needed route*/
                                    }); // start route
                                }        

                            </script>

                            <ul class="sk-sd-delvery"> 
                                <li>
                                    <div class="sk-sd-delvery--head">Доставка<?=($arResult["PROPERTIES"]["SBOR"]["VALUE"]>0 && in_array($intLocationID, array(1732, 2399))?' и сборка':'')?></div>
                                </li><?
                                    //arshow($_SESSION);

                                    $arBasketItems = array();
                                    $dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC", "ID" => "ASC"), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "CAN_BUY"=>"Y"), false,  false,  array());
                                    while ($arItems = $dbBasketItems->Fetch()) {        
                                        $arBasketItems[] = $arItems;
                                        $priceDelivery = $priceDelivery + $arItems["PRICE"]*$arItems["QUANTITY"];

                                    }




                                    if($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                    {
                                        $strMos = '<span class="s_like">Срок:</span> до 2-х месяцев';
                                        $strOther = '<span class="s_like">Срок:</span> около 2-х месяцев';
                                    } else {
                                        $strConstruct = '';
                                        if($arResult["PROPERTIES"]["SBOR"]["VALUE"] > 0)
                                            $strConstruct .= '<li><span class="s_like">Сборка:</span> '.CurrencyFormat($arResult["PROPERTIES"]["SBOR"]["VALUE"], "RUB").'</li>';

                                        $strDeliveryData = '';
                                        if($intLocationID == 1732) {
                                            $summBasket = 1;
                                            $strDeliveryData = '<li><span class="s_like">Дата доставки:</span> '.$strDeliveryDate.'</li>';  
                                            if($arStartOffer["PRICE"] < 1500){
                                                $StartOffer_price = '500р. внутри МКАД';
                                            }elseif($arStartOffer["PRICE"] > 1500 and $arStartOffer["PRICE"] < 3000){
                                                $StartOffer_price = '350р. внутри МКАД';
                                            }elseif($arStartOffer["PRICE"] > 3000 and $arStartOffer["PRICE"] < 5000){
                                                $StartOffer_price = '200р. внутри МКАД';
                                            }else{
                                                $StartOffer_price = 'бесплатно внутри МКАД';
                                            }
                                            $strDeliveryData .= '<li><span class="s_like">Стоимость:</span> '.$StartOffer_price.'</li>';
                                            if(false)
                                                $strDeliveryData .= '<li><span class="s_like">Сборка:</span> стоимость сборки (только если указано)';
                                        } elseif($intLocationID ==   2399) {?>
                                        <li id="s_like"><span class="s_like">Дата доставки:</span> <?=$strDeliveryDate?></li>

                                        <li><span class="s_like" id="off_title">Стоимость:</span><span id="map_distance"></span> </li>
                                        <? if(false){
                                                $strDeliveryData .= '<li><span class="s_like">Сборка:</span> стоимость сборки (только если указано)';
                                            }
                                        } else {
                                            $strDeliveryData = '<li><span class="s_like">Срок доставки:</span> от 2-х дней.</li>
                                            <li>Стоимость доставки зависит от веса, объема и расстояния.</li>';
                                        }
                                    }                                     

                                    //echo $intLocationID; arshow($arResult["PROPERTIES"]["SBOR"]);
                                ?>
                                <?=$strDeliveryData.$strConstruct?>
                                <li> 
                                    <a id="deliveryShowLink" 
                                        data-id="<?=$arResult["ID"]?>" 
                                        href="#" 
                                        title="Доставка по Москве и Подмосковью" 
                                        class="sk-popup-open sk-dotted" 
                                        data-popup-name="<?=(in_array($intLocationID, array(1732, 2399))?
                                            'delivery-moskow':'delivery-region')?>" >О доставке<?=($arResult["PROPERTIES"]["SBOR"]["VALUE"]>0 && 
                                            in_array($intLocationID, array(1732, 2399))?' и сборке':'')?>
                                    </a> 
                                </li>
                            </ul>
                            <div class="sk-sd-delvery-deliter"></div>
                        </td>
                        <td>
                            <div class="sk-sd-options--head">Преимущества</div>
                            <ul class="sk-sd-options">
                                <li class="sk-sd-options--back"><a href="#" title="14 дней на возврат товара!" class="sk-dotted sk-popup-open" data-popup-name="cash_back" >14 дней на возврат товара</a></li>
                                <li class="sk-sd-options--delveri"><a href="#" title="Доставка по всей России" class="sk-dotted sk-popup-open" data-popup-name="delivery_russia">Доставка по всей России</a></li>
                                <li class="sk-sd-options--pay"><a href="#" title="Способы оплаты" class="sk-dotted sk-popup-open" data-popup-name="pay_method">Более 10 способов оплаты</a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        <!-- END product_block_info -->
        <div class="clear"></div>
        <?           
            global $ar_quantity;
            foreach($arResult["OFFERS"] as $arPrices){
                global $prises;
                if($arPrices["CATALOG_PRICE_3"] > 0){
                    $prises = $arPrices["CATALOG_PRICE_3"];   
                }
            }
            //arshow($arResult["PROPERTIES"]);
            //if(!$arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] )
            //if(!$arResult["CATALOG_AVAILABLE"])               
            if(!$arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] )
            {?>
            <?/* Если товара нет */?>                
            <div class="sk-noproduct">
                <div class="sk-noproduct--cont">Нет в продаже 
                    <?$track_list=CIBlockElement::GetList(array(),array("IBLOCK_ID"=>16, "PROPERTY_DELETED" => false, "CREATED_BY" => $USER -> GetID(), "ACTIVE" => "Y", "PROPERTY_PRODUCT"=>$arResult["ID"]), false, false, array("ID", "PROPERTY_PRODUCT"));
                        $trlist=$track_list->GetNext();?><?if ($track_list->SelectedRowsCount()) {?>
                        <br> <span class="already_added"><a href="http://www.mamingorodok.ru/personal/">Товар добавлен в список ожидания.</a></span><br><a href="#" onclick="animateTo('#similarItems'); return false;" title="Смотреть аналоги">Смотреть аналоги</a><span class="sk-noproduct--arrow"></span><br> 
                        <?} else {?>
                    <br> <a rel="nofollow" class="notifyMeButton" href="#ng_<?=$arResult["ID"]?>" title="Уведомить о поставке">Уведомить о поставке</a><br><a href="#" onclick="animateTo('#similarItems'); return false;" title="Смотреть аналоги">Смотреть аналоги</a><span class="sk-noproduct--arrow"></span>  <? } ?>  </div>
                <div class="sk-noproduct--overlap"></div>   
            </div>
            <?/* END Если товара нет */?><?  
        }?>

        <?/* END Попап */?>
        <?/* Галерея */?>
        <div class="sk-gallery-holder" style="display: none;">
            <div class="sk-gallery" >
                <div class="sk-gallery--close"><a href="#" title="Закрыть"></a></div>
                <div class="sk-gallery--img--holder">
                    <div class="sk-gallery-slider">
                        <ul id="sk-tumb-gallery-slider" class="jcarousel jcarousel-skin-tumb sk-tumb-gall ">
                            <?=$strGallery?>
                        </ul>
                    </div>
                    <div class="sk-gallery--img">
                        <?if(empty($strStartBigImage)){
                                $strStartBigImage = "/img/no_foto.jpg";
                            }else{
                                $strStartBigImage;
                        }?>
                        <a href="<?=$strStartBigImage?>" id='zoom1' alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="cloud-zoom" rel="useZoom: 'zoom1', adjustX:0,adjusty:-50, zoomWidth:500, zoomHeight:408" ><img id="galleryCurrentImage" src="<?=$strStartBigImage?>"  data-last="<?=$strStartBigImage?>" alt=""></a>
                    </div>

                </div>
                <div class="sk-gallery--color--holder">
                    <div class="sk-gallery--avl-price">
                        Доступные цвета для этой модели
                    </div>
                    <div class="sk-gallery-color" id="galleryListPreview"><div class="sk-gallery-color-scroll">
                            <?/* Color Items*/?>
                            <?
                                $intGallryCnt = 0; //arshow($arResult["CS"]);
                                foreach($arResult["CS"] as $strSize => $arColor)
                                {

                                    if(count($arResult["CS"])>0)
                                        $strSizeHash = 'data-sizehash="'.md5($strSize).'"';
                                    else $strSizeHash = '';

                                    foreach($arColor as $arItem)
                                    {
                                        if ($arItem["PRICE"] != 0 and  $arItem["~CATALOG_QUANTITY"] > 0){
                                            $strH1orName = $arResult["SEO_H1_FROM_NAME"] == "Y" ? $arResult["NAME"].' '.$arItem["PROPERTY_TSVET_VALUE"] : $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];
                                            if(!$onlyStandardSize)
                                                $strGalleryItemName = ToLower($arItem["PROPERTY_RAZMER_VALUE"]).' цвет '.ToLower($arItem["PROPERTY_TSVET_VALUE"]);
                                            else $strGalleryItemName = $arItem["PROPERTY_TSVET_VALUE"];

                                            $imgName=GetImgNameArray($arItem["XML_ID"]);
                                            //arshow($imgName);
                                            if (!empty($imgName))
                                            {
                                                $smallImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL); 
                                                $galleryBigImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL);
                                            }else{
                                                $galleryBigImg["src"] = "/img/no_foto.jpg";
                                                $smallImg["src"] = "/img/no_photo_52x52.png"; 
                                                $smallImg["width"] = "52"; 
                                                $smallImg["height"] = "55";   
                                            }

                                            //arshow($galleryBigImg);?>
                                        <a<?=($intGallryCnt>13?' style="display:none;"':'')?> 
                                            title="<?=$strGalleryItemName?>" 
                                            class="sk-gallery-color-item cloud-zoom-gallery" 
                                            id="galleryOffer<?=$arItem["ID"]?>" <?=$strSizeHash?> 
                                            data-orig="<?if(!empty($imgName["MAXI"]["ID"])){echo CFile::GetPath($imgName["MAXI"]["ID"]);}else{ echo $galleryBigImg["src"];}?>" 
                                            data-img="<?=$galleryBigImg["src"]?>" 
                                            href="<?if(!empty($imgName["MAXI"]["ID"])){echo CFile::GetPath($imgName["MAXI"]["ID"]);}else{ echo $galleryBigImg["src"];}?>" 
                                            alt="<?if(!empty($imgName["MAXI"]["ID"])){echo CFile::GetPath($imgName["MAXI"]["ID"]);}else{ echo $galleryBigImg["src"];}?>" 
                                            rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=$galleryBigImg["src"]?>' ">
                                            <div class="sk-gallery-color--img">
                                                <img src="<?=$smallImg["src"]?>" 
                                                    width="<?if($smallImg["width"] == 0){echo "auto";}else{ echo $smallImg["width"];}?>" 
                                                    height="<?if($smallImg["height"] == 0){echo "auto";}else{ echo $smallImg["height"];}?>"
                                                    alt="<?//=$strH1orName?>">
                                                <span>Выбрать</span>
                                            </div>
                                            <div class="sk-gallery-color--body">
                                                <div class="sk-gallery-color--head"><?=smart_trim($strGalleryItemName, 19)?></div>
                                                <div class="sk-gallery-color--price"><?
                                                    if($arItem["PRICE"]>0)
                                                    echo number_format($arItem["PRICE"], 0, '', ' ').' <div class="rub_none">руб.</div><span class="rouble">a</span>'; ?></div>
                                            </div>
                                        </a><?
                                            $intGallryCnt++;
                                        }
                                    }
                                }
                            ?>
                            <?/* END Color Items */?>   
                        </div>                                                        
                    </div><?
                        if($intGallryCnt>14)
                        {?>
                        <?/* <div class="sk-gallery--all-price"><a href="#" onclick="$('#galleryListPreview a:hidden').show(); $(this).parent().hide(); return false;" title="Показать все цвета">Показать все цвета</a></div> */?>

                        <div class="sk-gallery--all-price"><a href="#" title="Показать все цвета">Показать все цвета</a></div><?
                    }?>
                </div>
            </div>

            <div class="sk-gallery-overlap"></div>
        </div>  
        <?/* END Галерея */?>
    </div>
    <!--noindex-->
    <input type="hidden" id="lastClickedImage" value="" />
    <div id="current-url" style="display:none;"><?=$_SERVER["REDIRECT_URL"]?></div>
    <div id="product-id" style="display:none;"><?=$arResult["ID"]?></div>
    <div id="productPrice" style="display:none;"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></div>
    <div id="user-id" style="display:none;"><?=$user_id;?></div>
    <div id="qu_count" style="display:none;"><?=$pr?></div>
    <div id="sel_colorsize" style="display:none;"><?=$arResult["LINKED_ITEMS"][0]["ID"]?></div>
    <span id="element-id" style="display:none;"><?=intval($arResult["ID"])?></span>
    <!--/noindex-->
    <? /* END product_block */?>
</span>

<?      
    /*  if((($arStartOffer["PRICE"] == 0  || $ar_quantity  == 0 || $prises == 0)                                                                                   //проверка на отображение заглушки
    and $arResult["OFFERS"][0]["CATALOG_QUANTITY"] == 0)  or $arResult["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] != "" )      */
    if(!$arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"])
    {       
        $APPLICATION->IncludeComponent("sk:catalog.like.items", "newCardNotAvailable1", Array(
            "AJAX_MODE" => "N",    // Включить режим AJAX
            "ELEMENT_ID" => $arResult["ID"],    // Родительский элемент
            "SECTION_ID" => $arResult["SECTION"]["ID"],    // Родительский раздел
            "strFilter" => "arrLikeFilter",    // Внешний фильтр
            "IBLOCK_TYPE" => "catalog",    // Тип информационного блока (используется только для проверки)
            "IBLOCK_ID" => "2",    // Код информационного блока
            "NEWS_COUNT" => "20",    // Количество новостей на странице
            "CACHE_TYPE" => "A",    // Тип кеширования
            "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
            "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
            "AJAX_OPTION_STYLE" => "N",    // Включить подгрузку стилей
            "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
            ),
            false
        );  
    } else {  ?>

    <div class="characteristic_block" id="characteristic_block">     
        <?/* Tabs */?>
        <div class="sk-tab">
            <ul class="sk-tab--tabs">
                <li <?if($_GET["comment"]!="Y"){?> class="sk-tabs--item_active" <?}?>>
                    <div class="oh3"><a id="paramTabTitle" href="#features" title="Характеристики">Характеристики</a></div>
                </li><?
                    if(!empty($arResult["DETAIL_TEXT"]))
                    {?>
                    <li>
                        <div class="oh3"><a href="#descr" title="Описание товара">Описание товара</a></div>
                    </li><?
                }?>
                <?
                    if(is_array($arResult["PROPERTIES"]["VIDEO"]["VALUE"]) && count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])) { ?>
                    <li class="sk-tabs--item_video">
                        <div class="oh3"><a href="#video" title="Видео">Видео (<?=count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])?>)</a></div>
                    </li><?
                }?>
            </ul>
            <div <?if($_GET["comment"]=="Y"){?> class="sk-tabs--item_active active" <?}else{?>  <?}?> id="coment_style">
                <form action="<?=$APPLICATION->GetCurPage()?>" method="GET" id="com_form">
                    <div class="oh3"><a id="commentTabTitle" href="#comment" onclick="$('#com_form').submit()" title="Отзывы">Отзывы</a></div>
                    <input type="hidden" name="comment" value="Y">
                </form>
            </div>
            <div class="clear"></div>
            <?      
                $strProps = '';
                if(!empty($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]))
                {
                    $strProps .= '<li><div class="oh4">'.$arResult["PROPERTIES"]["CML2_ARTICLE"]["NAME"].'</div>    <p>'.$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"].'</p></li>';
                    unset($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]);
                }
                if(strlen($arResult["PRODUCER"]["NAME"])>0) $strProps .= '<li><div class="oh4">Производитель</div><p>'.$arResult["PRODUCER"]["NAME"].'</p></li>';
                if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"])>0)
                    $strProps .= '<li><div class="oh4">Страна производителя</div><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_PRODUCER_NAME"].'</p></li>';
                unset($arResult["PROPERTIES"]["CH_STRANA_1"]);
                if(strlen($arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"])>0) $strProps .= '<li><div class="oh4">Страна производства</div><p>'.$arResult["PRODUCER"]["PROPERTY_COUNTRY_ITEM_NAME"].'</p></li>';
                unset($arResult["PROPERTIES"]["CH_STRANA"]);    
                if(strlen($arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"])>0) $strProps .= '<li><div class="oh4">Гарантия</div><p>'.$arResult["PRODUCER"]["PROPERTY_WARRANTY_VALUE"].'</p></li>';

                $strOtherPropsHidden = '';

                foreach($arResult["DISPLAY_PROPERTIES"] as $key => $arProp)
                {   // arshow($arProp["MULTIPLE"],true);

                    if($arProp["MULTIPLE"] != "Y")
                        $arTmp = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult["PROPERTIES"][$key], "news_out");

                    if($arProp["MULTIPLE"] == "Y"){?>
                    <?
                        $arTmp["DISPLAY_VALUE"] = '';
                        foreach($arProp["VALUE"] as $k=>$value):?>  
                        <?$arTmp["DISPLAY_VALUE"] .= $value.' ';?>
                        <?endforeach;   

                    ?>        
                    <?}
                    if (($arProp["MULTIPLE"] != "Y" || $arTmp["PROPERTY_TYPE"]=='S' || $arTmp["PROPERTY_TYPE"]=='N' || $arTmp["PROPERTY_TYPE"]=='L') && ($arTmp["CODE"]!='UPDATE_HASH' && $arTmp["CODE"]!='PRICE' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='PHASH' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='WISH_RATING' && $arTmp["CODE"]!='CML2_ARTICLE' && $arTmp["CODE"]!='title' && $arTmp["CODE"]!='SALES_RATING' && $arTmp["CODE"]!='CML2_BASE_UNIT' && $arTmp["CODE"]!='SERVICE_QSORT' && $arTmp["CODE"]!='description' && $arTmp["CODE"]!='CATALOG_AVAILABLE' && $arTmp["CODE"]!='QU_ACTIVE' && $arTmp["CODE"]!='NEW' && $arTmp["CODE"]!='SALE_RATING' && $arTmp["CODE"]!='RATING' && !strstr($arTmp["CODE"], "SEO")))
                    {
                        $arTmp["DISPLAY_VALUE"] = prepareMultilineText($arTmp["DISPLAY_VALUE"]);            

                        $strProps .= '<li><div class="oh4">'.$arProp["NAME"].'</div>    <p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';

                    }
                }


            ?>
            <div class="sk-tab--content"> 
                <!-- features tab -->
                <div id="features" class="sk-tab--item" <?if($_GET["comment"]!="Y"){?> style="display: block;" <?}?>> 
                    <!-- characteristic_info -->
                    <div class="characteristic_info">
                        <div class="sk-column sk-colum_44">
                            <div class="characteristic_info-head">Типовые характеристики</div>
                            <ul class="sk-characteristic-list">
                                <?=$strProps?>
                            </ul><?
                                if( !empty($arResult["UF_KOLKOMPLEKTTEXT"]) )
                                {
                                    $strSet = str_ireplace(array("<br>", "\n", "[html]"), array("", "</li><li>", ""), $arResult["UF_KOLKOMPLEKTTEXT"]);?>
                                <div class="sk-equip">
                                    <div class="characteristic_info-head">Комплектация</div>
                                    <ul class="sk-characteristic--list">
                                        <li><?=$strSet?></li>
                                    </ul>
                                </div><?
                            }?>
                        </div><?
                            if(!empty($arResult["OTHER_PROPERTIES"])) 
                            {?>
                            <div class="sk-column sk-colum_56 "> 
                                <!-- characteristic_text -->
                                <div class="characteristic_text" id="characteristicDiv">
                                    <div id="characteristicDivInner">
                                        <?foreach ($arResult["OTHER_PROPERTIES"] as $value):?>
                                            <?='<div class="characteristic_info-head">'.$value["key"].'</div>'.str_ireplace(array("&mdash;&nbsp;", "\n", "[html]"), array("", "\n\n", ""), $value["value"]).'<br><br>'?>
                                            <?endforeach;?>
                                    </div>
                                </div><?
                                    if(false)
                                    {?>
                                    <div class="sk-characteristic-more-btt"><a href="#" class="sk-dotted" title="Показать все">Показать все</a></div><?
                                }?>
                                <!-- END characteristic_text --> 
                            </div><?
                        }?>
                    </div>
                    <!-- END characteristic_info --><?
                        //arshow($arResult["ACCESSORIES"],true);

                        if (!empty($arResult["ACCESSORIES"]))
                        {

                            $GLOBALS["arrAccFilter"]["ID"] = $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"];?>


                        <div class="sk-accessory-block" id="detailAccessories"> 
                            <!-- similar_block -->
                            <div class="similar_block similar_block_right">
                                <div class="crumbs_black">Рекомендуем</div>
                                <ul class="sk-accessory-slider jcarousel jcarousel-skin-accessory"><?


                                        foreach($arResult["ACCESSORIES"] as $akey => $arAccItem)
                                        {
                                            if (GetOfferMinPrice($arParams["IBLOCK_ID"],$arAccItem["ID"]) > 0 ){
                                                $smallImg = CFile::ResizeImageGet($arAccItem["PREVIEW_PICTURE"], array("width"=>100, "height"=>100), BX_RESIZE_IMAGE_PROPORTIONAL);?>
                                            <li<?=($akey==count($arResult["rows"])-1?' class="last-child"':'')?>>
                                                <div class="photo">
                                                    <p><a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><img src="<?=$smallImg["src"]?>" alt="<?=$arAccItem["NAME"]?>" /><span>&nbsp;</span></a></p>
                                                </div>
                                                <div class="link"><a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" title="<?=$arAccItem["NAME"]?>"><?=smart_trim($arAccItem["NAME"], 35)?></a></div>
                                                <span class="acess_price"><?
                                                        $price=GetOfferMinPrice($arParams["IBLOCK_ID"],$arAccItem["ID"]);  //init.php
                                                        if (is_null($price))
                                                        {
                                                            echo "Нет в наличии";
                                                        }
                                                        else
                                                        {

                                                            echo CurrencyFormat($price, "RUB"); 
                                                        }
                                                    }
                                            ?></span>
                                        </li><?
                                    }?>
                                </ul>  
                            </div>
                            <!-- END similar_block --> 
                        </div>

                        <?                      

                            /*$APPLICATION->IncludeComponent("bitrix:news.list", "accessories-items-newCard", array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                            "NEWS_COUNT" => "99",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_ORDER1" => "DESC",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "arrAccFilter",
                            "FIELD_CODE" => array(
                            0 => "",
                            1 => "NAME",
                            2 => "PREVIEW_PICTURE",
                            3 => "",
                            ),
                            "PROPERTY_CODE" => array(
                            0 => "RATING",
                            1 => "OLD_PRICE",
                            2 => "PRICE",
                            3 => "",
                            ),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_SHADOW" => "Y",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "CACHE_TYPE" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "Y",
                            "CACHE_GROUPS" => "Y",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "SET_TITLE" => "N",
                            "SET_STATUS_404" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "PAGER_TITLE" => "Новости",
                            "PAGER_SHOW_ALWAYS" => "Y",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "Y",
                            "AJAX_OPTION_ADDITIONAL" => ""
                            ),
                            false
                            );*/

                            /*$APPLICATION->IncludeComponent(
                            "bitrix:highloadblock.list", 
                            "accessories-items-newCard", 
                            array(
                            "IBLOCK_ID" => "2",
                            "DETAIL_URL" => "detail.php?BLOCK_ID=#BLOCK_ID#&ROW_ID=#ID#",
                            "BLOCK_ID" => "2",
                            "XML_ID" => $arResult["XML_ID"]
                            ),
                            false
                            );*/

                    }?>
                </div>
                <!--END  features tab--><?
                    if(!empty($arResult["DETAIL_TEXT"]))
                    {
                        $strAddon = '';
                        if(!empty($arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"]) && !empty($arResult["PRODUCER"]["~PROPERTY_NAME_RUS_VALUE"]))
                            $strAddon = ' ('.$arResult["PRODUCER"]["~PROPERTY_NAME_RUS_VALUE"].' '.$arResult["PROPERTIES"]["SEO_MODEL_RUS"]["VALUE"].')';
                    ?>
                    <!-- descr tab-->
                    <div id="descr" class="sk-tab--item" style="display: none;"> 
                        <div class="characteristic_info" style="clear:both;">
                            <p><b class="characteristic_info-head"><?=$strH1orName.$strAddon?></b></p><br>
                            <span itemprop="description"><?=str_replace(array("&mdash;&nbsp;", "<br>"), array("", "<br><br>"), normalizeBR($arResult["DETAIL_TEXT"]))?></span>
                        </div>
                        <!-- END characteristic_info -->
                    </div>
                    <!--END descr tab --> <?
                }?>
                <!--comment -->  
                <?//arshow($_GET)?>
                <?if($_GET["comment"] == "Y"){?>
                    <div id="" class="sk-tab--item" name="comment" <?if($_GET["comment"]=="Y"){?> style="display: block;" <?}?>> 
                        <!-- characteristic_info -->
                        <div class="characteristic_info" style="height:auto;">
                            <a name="review"></a>
                            <div class="oh2"><?=$strH1orName?> - отзывы</div>
                            <?$APPLICATION->IncludeComponent("individ:forum.topic.reviews2", "all-comments-newCard", array(
                                    "FORUM_ID" => "1",
                                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                    "ELEMENT_ID" => $arResult["ID"],
                                    "POST_FIRST_MESSAGE" => "N",
                                    "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                                    [url=#LINK#]#TITLE#[/url]
                                    #BODY#",
                                    "URL_TEMPLATES_READ" => "",
                                    "URL_TEMPLATES_DETAIL" => "",
                                    "URL_TEMPLATES_PROFILE_VIEW" => "",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "36000000",
                                    "MESSAGES_PER_PAGE" => "10",
                                    "PAGE_NAVIGATION_TEMPLATE" => "",
                                    "DATE_TIME_FORMAT" => "d.m.Y",
                                    "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                                    "USE_CAPTCHA" => "Y",
                                    "PREORDER" => "N",
                                    "SHOW_LINK_TO_FORUM" => "N",
                                    "FILES_COUNT" => "2"
                                    ),
                                    false
                                );?><?$APPLICATION->IncludeComponent("individ:forum.topic.reviews", "add-comment", array(
                                    "FORUM_ID" => "1",
                                    "IBLOCK_TYPE" => $arResult["IBLOCK_TYPE"],
                                    "IBLOCK_ID" => $arResult["IBLOCK_ID"],
                                    "ELEMENT_ID" => $arResult["ID"],
                                    "POST_FIRST_MESSAGE" => "N",
                                    "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                                    [url=#LINK#]#TITLE#[/url]
                                    #BODY#",
                                    "URL_TEMPLATES_READ" => "",
                                    "URL_TEMPLATES_DETAIL" => "",
                                    "URL_TEMPLATES_PROFILE_VIEW" => "",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => "36000000",
                                    "MESSAGES_PER_PAGE" => "0",
                                    "PAGE_NAVIGATION_TEMPLATE" => "",
                                    "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
                                    "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                                    "USE_CAPTCHA" => "N",
                                    "PREORDER" => "Y",
                                    "SHOW_LINK_TO_FORUM" => "N",
                                    "FILES_COUNT" => "2"
                                    ),
                                    false
                                );?>
                        </div>
                        <?}?>
                    <!-- END characteristic_info -->
                </div>    
                <!--END comment -->

                <div id="video" class="sk-tab--item" style="display: none;">
                    <div class="characteristic_info" style="clear:both;"><?
                            foreach($arResult["PROPERTIES"]["VIDEO"]["~VALUE"] as $intCnt => $strVideo) {
                                if(empty($arResult["PROPERTIES"]["VIDEO"]["DESCRIPTION"][$intCnt]))
                                    $strTitle = $arResult["NAME"].' - видеообзор';
                                else $strTitle = $arResult["PROPERTIES"]["VIDEO"]["DESCRIPTION"][$intCnt]; ?>
                            <div class="sk-videotab-item">
                                <div class="characteristic_info-head"><?=$strTitle?></div>
                                <?=$strVideo?>
                            </div> <?
                        } ?>
                    </div>
                </div>
            </div>
            <p style="color: #999;font-size: 13px;">Сообщить об ошибке: выделить текст и нажать Ctrl+Enter</p>
        </div>
        <!-- END Tabs-->
    </div>

    <?// if($USER->IsAdmin()){   //arshow($arResult["SECTION"]["ID"]); 
        // if(is_array($arResult["PROPERTIES"]["LIKE"]["VALUE"]))
        // $GLOBALS["arrLikeFilter"]["ID"] = $arResult["PROPERTIES"]["LIKE"]["VALUE"];
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.bigdata.products", 
            "personal_Information", 
            array(
                "RCM_TYPE" => "similar_view",
                "ID" => $arResult["ID"],
                "IBLOCK_TYPE" => "1c_catalog",
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "HIDE_NOT_AVAILABLE" => "Y",
                "SHOW_DISCOUNT_PERCENT" => "Y",
                "PRODUCT_SUBSCRIPTION" => "N",
                "SHOW_NAME" => "Y",
                "SHOW_IMAGE" => "Y",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "PAGE_ELEMENT_COUNT" => "5",
                "LINE_ELEMENT_COUNT" => "5",
                "TEMPLATE_THEME" => "blue",
                "DETAIL_URL" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_GROUPS" => "N",
                "SHOW_OLD_PRICE" => "N",
                "PRICE_CODE" => array(
                    0 => "Цена для выгрузки на сайт",
                ),
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "Y",
                "CONVERT_CURRENCY" => "Y",
                "BASKET_URL" => "/personal/cart/",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "SHOW_PRODUCTS_2" => "Y",
                "CURRENCY_ID" => "RUB",
                "PROPERTY_CODE_2" => array(
                    0 => "",
                    1 => "NEWPRODUCT",
                    2 => "MANUFACTURER",
                    3 => "MATERIAL",
                    4 => "COLOR",
                    5 => "OLD_PRICE_VALUE",
                    5 => "PROPERTY_OLD_PRICE_VALUE"
                ),
                "CART_PROPERTIES_2" => array(
                    0 => "",
                    1 => "NEWPRODUCT",
                    2 => "",
                ),
                "ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
                "LABEL_PROP_2" => "-",
                "PROPERTY_CODE_3" => array(
                    0 => "",
                    1 => "COLOR_REF",
                    2 => "SIZES_SHOES",
                    3 => "SIZES_CLOTHES",
                    4 => "OLD_PRICE_VALUE",
                    4 => "PROPERTY_OLD_PRICE_VALUE",
                ),
                "CART_PROPERTIES_3" => array(
                    0 => "",
                    1 => "COLOR_REF",
                    2 => "SIZES_SHOES",
                    3 => "SIZES_CLOTHES",
                    4 => "",
                ),
                "ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
                "OFFER_TREE_PROPS_3" => array(
                ),
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "COMPONENT_TEMPLATE" => "personal_Information",
                "SHOW_FROM_SECTION" => "Y",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "SECTION_ELEMENT_ID" => "",
                "SECTION_ELEMENT_CODE" => "",
                "DEPTH" => ""
            ),
            false
        );
        //  }
    ?><?$APPLICATION->IncludeComponent("sk:catalog.like.items", "newCard1", Array(
            "AJAX_MODE" => "N",    // Включить режим AJAX
            "ELEMENT_ID" => $arResult["ID"],    // Родительский элемент
            "SECTION_ID" => $arResult["SECTION"]["ID"],    // Родительский раздел
            "IBLOCK_TYPE" => "catalog",    // Тип информационного блока (используется только для проверки)
            "IBLOCK_ID" => "2",    // Код информационного блока
            "NEWS_COUNT" => "5",    // Количество новостей на странице
            "CACHE_TYPE" => "A",    // Тип кеширования
            "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
            "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
            "AJAX_OPTION_STYLE" => "N",    // Включить подгрузку стилей
            "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
            ),
            false
        );?><?
    }
?>

<div class="clear"></div>
<?
    //if( $USER->IsAdmin()) {   
?>
<div style="position:absolute; top:-10000px; right:100000px;" id="colorsStorageHere"><?
        foreach($arTmpSizeHtml as $strSize => $strSizeHtml)
        {
            if($strSize != $arResult["START_SIZE"])
                echo ($strSizeHtml);
    } ?>
</div>
<?
    //}
?>
<input type="hidden" id="cartPrice" value="<?=$arResult["CART_PRICE"]?>">

<script type="text/javascript">
    var arDelivery = new Array;<?
        foreach($arResult["DELIVERY"] as $intCnt => $arDelivery)
        {?>
        arDelivery[<?=$intCnt?>] = new Array;
        arDelivery[<?=$intCnt?>][0] = <?=$arDelivery["ORDER_PRICE_FROM"]?>;
        arDelivery[<?=$intCnt?>][1] = <?=$arDelivery["ORDER_PRICE_TO"]?>;
        arDelivery[<?=$intCnt?>][2] = <?=$arDelivery["PRICE"]?>;
        <?
    }?>
</script>  



<?     
    $res = CCatalogSKU::getOffersList(
        array($arResult['ID']),
        $arResult['IBLOCK_ID']
    );               

    foreach($res[$arResult['ID']] as $arTorgPred){
        $dbBasketItems = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array('USER_ID'=>$user_id, 'ORDER_ID'=>'NULL','PRODUCT_ID'=>$arTorgPred['ID']),
            false,
            false,
            array("ID","QUANTITY",'PRODUCT_ID')
        );
    }
    //  while ($arItems = $dbBasketItems->Fetch()){

    CModule::IncludeModule('sale');
    $dbItems = CSaleBasket::GetList(
        array("ID" => "ASC"),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array(
            "ID", "NAME", "PRODUCT_ID", "CATALOG_XML_ID", "PRODUCT_PRICE_ID"
        )
    );

    while($arItem = $dbItems->Fetch())
    {
        if($arItem["PRODUCT_ID"] == $arResult["OFFERS"][0]["ID"]){
            global $name_atem; 
            $name_atem = "Y";
        } 
    } 
    if($name_atem == "Y"){?>
    <script>        
        $('.addToCartButton').html('В корзине');
        $('.sk-product-price-buy a').css({'background':'#C0BBC1','padding-left':'38px'});      
    </script>
    <?
} ?>

