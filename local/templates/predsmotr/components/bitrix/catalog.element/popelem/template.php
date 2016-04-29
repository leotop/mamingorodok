<!--<link href="/js/cloud-zoom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/cloud-zoom.1.0.3.min.js"></script>  -->

<!--<script>
//загрузка первого товара в торговом каталоге 
window.onload = function () {
$('.sk-product-color--item_active').trigger('click');
};
//загрузка первого товара в торговом каталоге 
</script>  -->

<?
?>



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

    //arshow($arResult["START_OFFERS_BY_SIZE"]);

    function getColorHtml($strSize, $arResult)
    {
        ob_start();   

        $arColor = $arResult["CS"][$strSize];    
        $arStartOffer = $arResult["START_OFFERS_BY_SIZE"][$strSize];


    ?><div id="colorData_<?=md5($strSize)?>">  

        <? //Проверяем если у товара только один цвет
            $arCheckColor = $arResult["CS"];

            foreach ($arCheckColor as $arSizeItemCheck => $arSizeCheck) { 
                //                    arshow(count($arSize), true);
                $arSizeCheckCount= count($arSizeCheck)+$arSizeCheckCount;
            }  
            // arshow(count($arCheckColor), true);
            //                                arshow($arSizeCheckCount, true);

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
                $arColorList = $arResult["CS"];
                //                arshow($arColorList, true);
                foreach ($arColorList as $arSizeItem => $arSize) { 
                    //                    arshow(count($arSize), true);
                    if (count($arSize)>1) {
                        foreach ($arSize as $arColorKey => $arColorItem) {
                            if ($arColorItem["~CATALOG_QUANTITY"]>0) { ?>    
                            <div class="sk-product-color-item" id="<?=$arColorItem["ID"]?>" ><?=$arColorKey.' ('.$arSizeItem.')'?></div>
                            <? } } } }
            ?>
        </div>
        <?

        ?>

        <div>
            <ul class="sk-product-color--slider jcarousel jcarousel-skin-color_chose<?=(!$singleOffer?'_one':'')?>">
                <li><?

                    $itemsPerLi = (!$singleOffer ? 1:2);
                    $intCnt = 0;
                    foreach($arColor as $arOffer){
                        if ($arOffer["PRICE"] != 0 and $arOffer["~CATALOG_QUANTITY"] > 0){             //проверка на количество элементов у которых указана цена ... // проверка на количество элементов на складе
                            global $ar_quantity;     
                            $ar_quantity = $arOffer["~CATALOG_QUANTITY"];
                            $strH1orName = $arResult["SEO_H1_FROM_NAME"] == "Y" ? $arResult["NAME"].' '.$arOffer["PROPERTY_TSVET_VALUE"] : $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];

                            $imgName=GetImgNameArray($arOffer["XML_ID"]);

                            if (!empty($imgName))
                            {
                                $smallImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>52, "height"=>55), BX_RESIZE_IMAGE_PROPORTIONAL);
                                $bigImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>376, "height"=>343), BX_RESIZE_IMAGE_PROPORTIONAL); 
                            }
                            //                        arshow($arOffer); 
                            //Количество товара в торговой предложении
                            //$intElementID = 100; // ID предложения
                            //$mxResult = CCatalogSku::GetProductInfo($arOffer["ID"]);
                            //if (is_array($mxResult))
                            //{
                            //arshow($mxResult);
                            //}
                            //else
                            //{
                            //ShowError('Это не торговое предложение');
                            //};
                            if($intCnt%$itemsPerLi == 0 && $intCnt>0)
                                echo '</li><li>';?>    

                        <a id="smallOffer<?=$arOffer["ID"]?>" 
                            href="<?=$bigImg["src"]?>" 
                            alt="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>"  
                            rel="useZoom:'zoom2'" 
                            <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                            class="cloud-zoom-gallery sk-product-color--item<?=($intCnt == 0?' sk-product-color--item_active':'' /*or ($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')*/)?><?=($intCnt==0?' first':'')?>" 
                            <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                            data-code="<?=$arOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?>" 
                            data-color="<?=$arOffer["PROPERTY_TSVET_VALUE"]?>" 
                            data-img="<?=$bigImg["src"]?>" 
                            data-offerID="<?=$arOffer["ID"]?>" 
                            data-quantity="<?=$arOffer["~CATALOG_QUANTITY"]?>"
                            data-price="<?=number_format($arOffer["PRICE"], 0, '.', ' ')?>"<?=($arOffer["PROPERTY_OLD_PRICE_VALUE"]>0?'data-old-price="'.number_format($arOffer["PROPERTY_OLD_PRICE_VALUE"], 0, '.', ' ').'"':'')?>>
                            <div class="sk-product-color--img"> <img src="<?=(empty($smallImg["src"])?'/img/no_photo_52x52.png':$smallImg["src"])?>" titile="" alt="<?=$strH1orName?>"> </div>
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

                            $intCnt++; 
                        }
                }?>
                <li>
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
    //arshow($arResult["CS"]);


    $strH1orName = $arResult["PROPERTIES"]["SEO_H1"]["VALUE"];

    if (!empty($arResult["DETAIL_PICTURE"]["ID"]))
    {
        $bigImg = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
    }
    else
    {
        $imgName=GetImgNameArray($arStartOffer["XML_ID"]);  //с.м. result_modifier

        if (!empty($imgName)) 
        {
            $bigImg = CFile::ResizeImageGet($imgName["MAXI"], array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL); 
            //            $bigImg = $imgName['MAXI'];   
        } 
    }

    $user_id = $USER->GetID();
    $pr=0;
    foreach($arResult["LINKED_ITEMS"] as $arElem)
        if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0) $pr++;

        $arTmpSizeHtml = array(); 
    if (!$singleOffer) {
        foreach($arResult["CS"] as $strSize => $arColor) { 
            $arTmpSizeHtml[$strSize] = getColorHtml($strSize, $arResult); 
        }

    }
?>
<? //Cтили для новой карточки каталога ?>
<style type="text/css">
    /*Шрифты*/
    @font-face {
        font-family: 'rouble';
        src: url('/bitrix/templates/nmg/font/rouble.eot');
        src: url('/bitrix/templates/nmg/font/rouble.eot') format('embedded-opentype'),
        url('/bitrix/templates/nmg/font/rouble.woff2') format('woff2'),
        url('/bitrix/templates/nmg/font/rouble.woff') format('woff'),
        url('/bitrix/templates/nmg/font/rouble.ttf') format('truetype'),
        url('/bitrix/templates/nmg/font/rouble.svg#ALSRublRegular') format('svg');
    }

    @font-face {
        font-family: 'RotondaC';
        font-style: normal;
        font-weight: normal;
        src: local('RotondaC'), url('/bitrix/templates/nmg/font/rotondac.woff') format('woff');
    }
    /*Стили для хлебных крошек*/
    .crumbs {
        padding-left: 0px;
        font-size: 12px;
        font-family:Arial;
        color: #A273C5;
        max-width: 960px;
        border-bottom: none;
    }
    .crumbs span a {
        text-decoration: none;
        color:#178AEF;
    }
    /*Карточка товара*/
    .sk-product-color--head-list .sk-link-btt {
        margin: 0 0 0 10px;
        padding: 0 36px 0 10px;
        position: relative;
        cursor: pointer;
        z-index:2;
    }

    .sk-product-color--head-list .sk-link-btt:after {
        content: "";
        width: 26px;
        height: 24px;
        position: absolute;
        top: 0;
        right:0;

        background-image: url(/bitrix/templates/nmg/img/drop-btn-ico.png);
        background-repeat: no-repeat;
        background-position: 0 100%;    
    }

    .product_block {
        padding-top: 5px;
    }
    .product_block .product_name {
        font-family: Arial !important;
        font-weight: bold !important;
        font-size: 28px !important;
        color:#7C4C95 !important;
        padding-bottom: 15px;
        border-bottom: 1px solid #D1C9D2;
        margin-bottom: 15px !important;
    }
    /*Инфобар под названием товара*/
    .product_block .infobar_product_name {
        margin-bottom: 20px;
    }
    /*Изображение товара*/
    .product_block_photo .sk-product-img {  
        border: none !important;
        border-bottom: 1px solid #E7E4E8 !important;
        border-radius: 3px !important;
    } 

    .product_block_photo{
        border: 1px solid #E7E4E8 !important;
        border-radius: 3px !important;
        width: 376px;
    }

    .product_block_photo .sk-product-img .sk-product-img--zoom {
        top: 4px;
        right: 4px;
        bottom: auto;
        background: none;
        background: #EFEDEF;
        padding-right: 20px;
    }
    .product_block_photo .sk-product-img .sk-product-img--zoom a{
        color: #4C4C4C;
        font-size: 13px;
        font-family: Arial;
        text-decoration: none;
        /*        position: absolute;*/
        padding-left: 13px;
        background:  url(/bitrix/templates/nmg/img/img-zoom.png) no-repeat 0;
    }
    /*Цена товара*/
    .sk-product-price-bar {
        background: none !important;
        border: 1px solid #E7E4E8 !important;
        border-radius: 3px !important;
        padding:0px 0px;
        width: 560px !important;
        overflow: visible;
    }


    .sk-product-price-holder {
        float: none;
        width: 97.5%;
        border-bottom: 1px solid #E7E4E8 !important;
        padding-left: 15px;
        height: 73px !important;
    }
    .sk-product-price-holder div{
        display: inline-block;
    }
    .sk-product-colorchoose-wrap{
        float:none;
    }
    .sk-product-price-holder .sk-product-price {
        background: none !important;
        border: none !important;
        font-size: 30px !important;
        color: #7C4C95 !important;
    }
    .sk-product-price-holder .sk-product-price .sk-product-price--cont {
        border: none !important;

    }
    .sk-product-price-holder .sk-product-price .sk-product-price-one {
        border: none !important;
        background: none !important;
        color: #7C4C95 !important;
        font-size: 30px !important;
        padding-bottom: 17px;
        margin-right: 15px;

    }
    .sk-product-price-holder .sk-product-price .sk-product-price-one .rouble {
        font-family: "rouble";
    }
    .rouble {
        font-family: "rouble";
    }
    .sk-product-price-count input {
        border: none;
        width: 38px;
        height: 30px;
        text-align: center;
    }
    .sk-product-price-count {
        margin-top: 20px;
        width: 60px;
        height: 34px;
        border: 1px solid #CCC3CD !important;
        border-radius: 3px !important;
        margin-bottom: 1px;
        position: absolute;
    }
    .sk-product-price-count .count_arrow {
        position: absolute;
        width: 22px;
        height: 17px;
        background-color: #CCC3CD;
        font-size: 8px;
        color: white;
        text-decoration: none;
        text-align: center;
        line-height: 20px;
    }
    .sk-product-price-count .dec{
        top: 17px ;
    }
    .sk-product-price-count .inc{
        top: 0px;
    }
    .sk-product-price-buy {
        position: absolute;
        /*        margin-left: 80px;*/
        margin-top: 13px;
        background: none;
        border:none;
        width: 150px;
        height: 40px;
        right: 136px;
    }
    .sk-product-price-buy a{
        padding-left: 60px;
        padding-top: 6px;
        background: none;
        border-radius: 3px !important;
        background: #FF7A00  url(/bitrix/templates/nmg/img/cart.png) no-repeat 25px;
        font-size: 15px;
        text-transform: uppercase;
        font-family: 'RotondaC';
        text-shadow:none;
    }
    .sk-product-price-buy:hover a{
        border-radius: 3px !important;
    }
    .sk-product-price-buy:hover {
        border-radius: 3px !important;
    }
    .sk-product-price-order {
        position: absolute;
        /*        margin-left: 256px;*/
        width: 100px;
        height: 35px;
        background: none;
        border: none;
        background-color: #714E75;
        border-radius: 3px !important;
        margin-top: 17px;
        right: 12px;
    }
    .sk-product-price-order:hover {
        background: none;
        border: none;
    }
    .sk-product-price-order a{ 
        width: 65px;
        height: 33px;
        background: #714E75  url(/bitrix/templates/nmg/img/arrow.png) no-repeat 10px;
        padding-left: 35px !important;
        padding-top: 5px;
        font-family: 'RotondaC';
        text-transform: uppercase;
        font-weight: bold;
        font-size: 10px;
        padding-left: 0px;
        line-height: 1.4;
        display:block;
        border-radius: 3px !important;
    }
    .sk-product-price-holder .price-deliter {
        position: absolute !important;
        width: 1px !important;
        height: 73px !important;
        background-color: #E7E3E8 !important;
        right: 123px;
    }

    .sk-product-colorchoose-wrap {
        margin-top: 25px;
    }
    .sk-product-color--head-list span {
        font-family: Arial !important;
        color: #322C33 !important;
        font-weight: normal !important; 
        font-size: 14px;
    }
    .sk-link-btt {
        width: 28%;
        height: 23px;
        padding-top: 7px !important;
        background: none;
        border: 1px solid #FF8000;
        border-radius: 3px !important;

    }
    .sk-link-btt:after {
        background-image: none !important; 
        height: 30px !important;
        background: #FF8000  url(/bitrix/templates/nmg/img/arrow-select.png) no-repeat 10px !important;
    }
    .sk-link-btt span {
        background: none !important;
        font-size: 14px !important;
        color: #FF8000 !important;
        display: block;
        white-space: pre;
        overflow: hidden;
    }

    .sk-link-btt span:after {
        background-color: #FF8000;
        width: 100px;
        height: 50px;
    }
    .sk-product-color {
        margin-left: 15px;
    }
    .sk-product-color--slider .jcarousel-item {
        height: 98px !important;
    }
    .jcarousel-item .sk-product-color--item_active .sk-product-color--img {
        border-color: #FF8000 !important;      
    }
    .jcarousel-item .sk-product-color--item_active .sk-product-color--price {
        background-color: #FF8000 !important;      
    }
    .sk-product-color--slider .jcarousel-item .sk-product-color--img {
        height: 70px !important; 
        border-radius: 3px 3px 0px 0px!important;
        border-color: #C0BBC1;
    }
    .sk-product-color--slider .jcarousel-item:hover .sk-product-color--img {
        border-color: #FF8000;
    }
    .sk-product-color--slider .jcarousel-item:hover .sk-product-color--price {
        background-color: #FF8000;
    }
    .sk-product-color--slider .jcarousel-item .sk-product-color--price {
        height: 17px !important; 
        border-radius: 0px 0px 3px 3px!important;
        background-color: #C0BBC1;
        padding-top: 3px;
    }
    .sk-product-color--slider .jcarousel-item .sk-product-color--price .s_like span{
        color: white;
        font-family: Arial;
    }
    .sk-product-color--slider .jcarousel-item .sk-product-color--price .s_like {
        color: white;
        font-family: 'rouble';
    }
    .sk-product-color--item:hover:before, .sk-product-color--item_active:before {
        margin: 68px 0 0 -4px !important;
        background:  url(/bitrix/templates/nmg/img/select-item-arrow.png) no-repeat !important;;
    }
    .sk-product-color .jcarousel-prev {
        margin-top: 12px;
    }
    .sk-product-color .jcarousel-next {
        margin-top: 12px;
    }
    .jcarousel-skin-tumb {
        margin-bottom: 20px;
        border-bottom: 1px solid #E7E4E8;
    }
    .soc_block {
        margin-left: 25px;
        padding-bottom: 20px;
    }
    .sk-under-color {
        width: 100%;
        background-color: #F2F2F0;
    }
    .sk-under-color div {
        display: inline-block;
        height: 50px;
        text-align: center;
        line-height: 4.0;
        font-family: Arial;
        font-size: 12px;
        color: #606060;
    }
    .sk-under-color .sk-question {
        color: #FF7A00;
        background:  url(/bitrix/templates/nmg/img/tick.png) no-repeat 15px !important;
        width: 160px;
    }
    .sk-under-color .sk-bonus {
        background:  url(/bitrix/templates/nmg/img/tick.png) no-repeat 15px !important;
        width: 180px;
    }
    .sk-under-color .sk-supply {
        background:  url(/bitrix/templates/nmg/img/tick.png) no-repeat 15px !important;
        width: 210px;
    }
    .sk-small-description-wrap {
        background: none !important;
        border: 1px solid #E9E5EA;
        border-radius: 3px!important;
        padding-left: 15px;

    }
    .sk-small-description-wrap tr td {
        background: none !important;
    }
    .sk-small-description {
        background: none;
        padding-bottom: 0px;
    }
    .sk-sd-features--head {
        background: none;
        padding-left: 0px;
    }
    .jcarousel-skin-color_chose_one {
        margin-top: 18px;
    }
    .sk-sd-features .s_like {
        font-weight: normal;
    }
    .sk-sd-delvery--head {
        background: none;
        padding-left: 0px; 
    }
    .sk-sd-delvery {
        padding-left: 0px;
        padding-right: 30px;
    }
    .sk-sd-options{
        padding-left: 0px;
    }
    .sk-sd-options--head {
        color: #050505;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .sk-small-description tr td:nth-child(3) {
        width: 185px;
    }
    .sk-small-description tr td:nth-child(2) {
        width: 145px;
    }
    .sk-sd-features-deliter {
        position: absolute;
        width: 1px;
        background-color: #E5E1E6;
        margin-top: -18px;
        margin-left: 160px;
        height: 33%;
    }
    .sk-sd-delvery-deliter{
        position:absolute;
        width: 1px;
        background-color: #E5E1E6;
        margin-top: -150px;
        margin-left: 142px;
        height: 168px; 
    }
    .sk-small-description tr .sk-sd-options--back {
        padding: 5px 0 5px 30px;
    }  
    .sk-small-description tr .sk-sd-options--delveri {
        padding: 5px 0 5px 30px;
    }
    .sk-small-description tr .sk-sd-options--pay {
        padding: 5px 0 5px 30px;
    }
    .sk-product-choose {
        position: absolute;
        top: 99px;
        left: 275px;
    }
    .sk-product-choose .s_like {
        font-family: Arial;
        font-size: 14px;
        color: #3F3940;
        font-weight: normal;
    }
    .sk-product-choose #sizeLabel {
        width: 140px;
        height: 23px;
        padding-top: 7px !important;
        border: 1px solid #CCC3CD;
        border-radius: 3px !important;
        background: none !important;
        font-size: 14px !important;
        font-weight: normal;
        font-family: Arial;
        padding-left: 10px;
        margin-left: 7px;
        cursor: pointer;
    }
    #sizeLabel:after{
        content: "";
        width: 26px;
        height: 20px;
        position: absolute;
        top: 1px;
        right: 0px;
        background-image: none !important;
        height: 30px !important;
        background: #CCC3CD url(/bitrix/templates/nmg/img/arrow-select.png) no-repeat 10px !important; 
    }
    .sk-product-choose--item {
        width: 140px;
        margin-left: 125px;
        display: none;
    }
    .sk-product-choose--item li a{
        width: 120px;
        height: 25px;
        font-weight: normal;
    }
    .sk-product-choose--item li:first-child a {
        border-radius: 3px 3px 0px 0px!important;  
    }
    .sk-product-choose--item li:nth-last-child(1) a{
        border-radius: 0px 0px 3px 3px!important;
    }
    .product_compare {
        display: inline-block;
        font-size: 14px;
        padding-left: 25px;
        background: url(/bitrix/templates/nmg/img/compare.png) no-repeat 0px !important; 
        cursor: pointer;               
    }
    .infobar-div {
        position: absolute;
        display: inline-block;
        width: 420px;
        right:0px;
    }
    .product_code {
        position: relative;
        display: inline-block;
        font-size: 14px;
        float:right;
    }
    .product_code .s_like {
        font-weight: normal;
    }
    .top-div {
        width:378px;
        display: inline-block;
    }
    .product-quantity {
        display: inline-block;
        margin-left: 20px;
        padding-left: 35px;
        font-size: 13px;
        background: url(/bitrix/templates/nmg/img/battery-quant.png) no-repeat 0px !important; 
    }
    .battery-quantity {
        position: absolute;
        margin-left: -30px;
        margin-top: 2px;
    }
    .low-quant {
        color: #D30000;
    }
    .enough-quant {
        color: #FF8000;
    }
    .high-quant {
        color: #81BE16;
    }
    .sk-product-info-bar {
        float: right;
        font-size: 13px !important; 
        margin-right: 12px;
    }
    .sk-product-info-bar li:nth-child(2) {
        margin-left: 10px;
    }
    .sk-product-info-bar li:nth-child(1) a {
        color: #3C363D !important;
    }
    .sk-product-info-bar a {
        text-decoration: none !important;
        margin-left: 10px;
    }
    .sk-product-info-bar .links a{
        color:#D40000;
    }
    .sk-product-info-bar .links a span {
        margin-left: 7px;
    }
    .addToBabyList span {
        color: #3C363D !important;
        background: none !important; 
    }
    .sk-product-price-bar .left_col{
        float: none; 
        margin-left: 20px !important;
        margin-top: 10px;    
    }
    .sk-product-price-bar .left_col .sk-product-price-single {
        display: inline-block;    
    }

    .sk-product-price-bar .left_col .sk-product-price-single .sk-product-price--cont{
        border: none !important;
        background: none !important;
        color: #7C4C95 !important;
        font-size: 30px !important;
        padding-bottom: 17px;
        margin-right: 15px;
    }
    .sk-product-price-bar .left_col .sk-product-price-single .sk-product-price--cont .sk-product-price-one {
        color: #7C4C95 !important;
        font-size: 30px !important;
    }
    .sk-product-price-bar .left_col .sk-product-price-count {
        display: inline-block;
        margin-top: 12px !important;
    }
    .sk-product-price-bar .right_col {
        float: right;
        position: absolute;
        margin-right: 60px;
        width: 190px;
        top: 0px;
        right: -58px;
    }
    .sk-product-price-bar .right_col .price-deliter{
        position: absolute !important;
        width: 1px !important;
        height: 73px !important;
        background-color: #E7E3E8 !important;
        right: 123px;
    }
    .single-price-deliter {
        position: absolute;
        height: 1px;
        width: 100%;
        background-color: #ECE9ED;
        margin-top: -14px;
        margin-bottom: 15px;
    }
    .single-price-color {
        font-family: Arial;
        font-size: 16px;
        margin-top: 15px;
        margin-left: 20px;
    }
    .single-price-color span {
        color: #FF8812;
    }
    .rating span {
        display: block;
        float: left;
        width: 12px;
        height: 12px;
        background: url(/bitrix/templates/nmg/img/stars.png) 0 -12px no-repeat;
        margin: 0 1px 0 0;
    }
    .rating .on {
        background: url(/bitrix/templates/nmg/img/stars.png) 0 0px no-repeat;
    }
    .delayed-list {
        color: #888888;
        padding-left: 20px;
        background: url(/bitrix/templates/nmg/img/grey-heart.png) 0 2px no-repeat;
    }
    #vk_like {
        width: 170px !important;
        /*        margin-left: 10px;*/
    }
    .sk-product-price-bar .jcarousel-prev-disabled {
        display: none !important;
    }
    .sk-product-price-bar .jcarousel-next-disabled {
        display: none !important;
    }
    .sk-product-color-list {
        position: absolute;
        width: auto;
        z-index: 1;
        margin-left: 48px;
        margin-top: -32px; 
        display: none;
        padding-top: 42px;
    }
    .sk-product-color-list div {
        background-color: white;
        padding-left: 10px;
        height: 20px;
        padding-top: 7px;
        border: 1px solid #FF8000; 
        cursor: pointer;
    }
    .sk-product-color-list div:hover {
        border-color: #C0BBC1;
    }
    .sk-product-color-list div:first-child{
        border-radius: 3px 3px 0px 0px!important;  
    }
    .sk-product-color-list div:nth-last-child(1) {
        border-radius: 0px 0px 3px 3px!important;
    }
    .sk-product-color {
        margin: 0px 0 15px 20px;
    }
    .sk-small-description-wrap {
        margin: 15px 0 0 0;
    }
    .sk-product-color-item {
        width: 100% !important;
    }
    .sk-gallery-holder {
        position: absolute;
    }   
    .sk-gallery {
        /*        top: 0px !important;*/
        left: 0px !important;
    } 
</style>

<script type="text/javascript">
    $(function(){        
        //Раскрывающийся список дополнительного свойства товара
        $("#sizeLabel").click(function () {
            $(".sk-product-color-list").slideUp();
            if($(".sk-product-choose--item").css("display")=="none"){
                $(".sk-product-choose--item").slideDown();
            } else {
                $(".sk-product-choose--item").slideUp(); 
            }
        });

        //Раскрывающийся список цвета товара
        $("#colorList").click(function () {
            $(".sk-product-choose--item").slideUp(); 
            if($(".sk-product-color-list").css("display")=="none"){
                $(".sk-product-color-list").slideDown();
            } else {
                $(".sk-product-color-list").slideUp(); 
            }
        });
        //Выбор цвета 
        $(".sk-product-color-item").click(function () {
            $(".sk-product-color-list").slideUp(); 
            var id = $(this).attr('id');
            var galId = "#galleryOffer"+id;
            //            alert (galId);
            $(galId).click();
            $(galId).click();
        });
    });

</script>

<!-- product_block -->
<span itemscope itemtype="http://data-vocabulary.org/Product">
    <div class="product_block">
        <h1 class="product_name" itemprop="name"><?=$strH1orName?></h1>  
        <div class="infobar_product_name">
            <div class="top-div">
                <div class="product_compare">Сравнить</div> 
                <?
                    //                      arshow($arResult["PROPERTY_1238"]);
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
                        <?
                            /* <?=showNoindex()?>
                            <div class="links "> #ADD_TO_WISH_LIST#
                            <!-- <a href="#" title=""><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="" /><span>К сравнению</span></a>--> 
                            </div>
                            <?=showNoindex(false)?>*/
                        ?>
                        <div class="delayed-list">Нет отложенных</div>
                    </li>

                </ul>
            </div> 
        </div>   
        <!-- product_block_photo -->

        <div class="product_block_photo">
            <div id="large" class="sk-product-img">
                <div class="sk-product-img--zoom"><a href="#" class="">Смотреть все фото</a></div>
                <table>
                    <tr>
                        <td>
                            <a href="<?=$bigImg["src"]?> " 
                                alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?> " 
                                id='zoom2'  
                                class="cloud-zoom sk-product-images" 
                                rel="useZoom: 'zoom2', adjustX:0,adjusty:-50, zoomWidth: '300'">
                                <img src="<?=$bigImg["src"]?>" 
                                    title="<?=$arResult["NAME"]?>" 
                                    alt="<?=$strH1orName?>" 
                                    data-last-img="<?=$bigImg["src"]?>"  
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
                if(!empty($arCommonImg))
                {
                ?>
                <ul id="sk-tumb-slider" class="jcarousel jcarousel-skin-tumb sk-tumb"><?
                        foreach($arCommonImg as $intCnt => $intImgID)
                        {
                            $smallImg = CFile::ResizeImageGet($intImgID, array("width"=>52, "height"=>44), BX_RESIZE_IMAGE_PROPORTIONAL);
                            $bigImg = CFile::ResizeImageGet($intImgID, array("width"=>376, "height"=>342), BX_RESIZE_IMAGE_PROPORTIONAL);
                            $galleryBigImg = CFile::ResizeImageGet($intImgID, array("width"=>575, "height"=>505), BX_RESIZE_IMAGE_PROPORTIONAL);

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
                        <li<?=($intCnt==0?' class="sk-tumb_active"':'')?>><a id="small<?=$intImgID?>" class="cloud-zoom-gallery"  href="<?=$bigImg["src"]?>" alt="<?=CFile::GetPath($intImgID)?>"   title="" rel="useZoom: 'zoom2', zoomWidth: '400'"><img src="<?=$smallImg["src"]?>"  alt="<?=$strH1orName?>" /></a></li><?
                    }?>
                </ul><?
            }?>
            <div class="soc_block"><? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
                $arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false)); ?></div>
            <br><br>
        </div>
        <!-- EDN product_block_photo --> 
        <!-- product_block_info -->
        <div class="product_block_info">

            <!--         <h1 itemprop="name"><?=$strH1orName?></h1>     -->
            <input type="hidden" id="offerID" value="<?=$arStartOffer["ID"]?>" />
            <input type="hidden" id="productID" value="<?=$arResult["ID"]?>" />
            <div class="sk-product-price-bar">

                <?if (!$singleOffer):?>

                    <div class="sk-product-price-holder">
                        <div class="sk-product-price">
                            <div class="sk-product-price--cont" id="priceHere"><?

                                    if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
                                    {
                                    ?>
                                    <div class="sk-product-price-old"><?=$arStartOffer["PROPERTY_OLD_PRICE_VALUE"] ?> <span class="rouble">a</span></div>
                                    <div class="sk-product-price-new<?=($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923?' sk-product-price-new-preorder':'')?>"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <span class="rouble">a</span><?

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
                                    <div class="sk-product-price-one"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <span class="rouble">a</span><?

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
                            <!--<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="шт. В корзину" class="add_b_item">-->
                        </div>
                        <div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);" href="#" class="addToCartButton">Купить</a></div>

                        <?if(strlen($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"])<=0)
                            {?>
                            <div class="price-deliter"></div>
                            <div class="sk-product-price-order"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy1click', 'card']);" class="design_links quickOrder" href="#qo_<?=$arResult["ID"]?>" title="Быстрый заказ">Купить <br> в 1 клик</a></div><?
                            }
                        ?>
                        <!--<div class="sk-product-price-credit"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy_credit', 'card']);" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит - <span id="creditprice"></span> р.</a></div>-->

                    </div>

                    <?else:?>

                    <div class="left_col">
                        <div class="sk-product-price-single">
                            <div class="sk-product-price--cont single" id="priceHere"><?
                                if($arStartOffer["PROPERTY_OLD_PRICE_VALUE"]>0)
                                {?>
                                <div class="sk-product-price-old"><?=$arStartOffer["PROPERTY_OLD_PRICE_VALUE"]?> <span class="rouble">a</span></div>
                                <div class="sk-product-price-new<?=($arResult["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923?' sk-product-price-new-preorder':'')?>"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <span class="rouble">a</span>

                                </div><?
                                } else {

                                ?>
                                <div class="sk-product-price-one sk-product-price-one-single"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <span class="rouble">a</span><?




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

                        <!--<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="шт. В корзину" class="add_b_item">-->
                    </div>
                </div>

                <div class="right_col">
                    <div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);" href="#" class="addToCartButton">Купить</a></div>


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
                <!--<div class="sk-product-price-credit"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy_credit', 'card']);" href="#" title="Купить в кредит" class="sk-dotted addToCartButton" >В кредит - <span id="creditprice"></span> р.</a></div>-->
                <? } ?>

                <?endif;?>

                <div class="sk-product-colorchoose-wrap">
                    <?//arshow($arStartOffer);?>
                    <div id="skProductColor" class="sk-product-color">
                        <?=$arTmpSizeHtml[$arStartOffer["PROPERTY_RAZMER_VALUE"]];
                        //arshow($arResult);
                        ?>
                    </div><?

                        if(!$singleOffer)
                        {
                            $strTmp = '';
                            $strSelectedSize = '';
                            foreach($arResult["CS"] as $strSize => $arFoo)
                            {
                                if($arResult["SIZE_AVAIL"][$strSize] == "Y")
                                    $htmlCross = '';
                                else $htmlCross = '<div class="cross"></div>';

                                if($strSize == $arStartOffer["PROPERTY_RAZMER_VALUE"]) $strSelectedSize = $strSize;

                                $strTmp .= '
                                <li'.($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':' sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_RAZMER_VALUE"]?' class="sk-product-choose--item_active"':'').' id="lisize_'.md5($strSize).'"><a href="#" title="'.$strSize.'" data-color="'.$strSize.'">'.$strSize.'</a></li>';
                        }?>
                        <?if (!$onlyStandardSize){?>
                            <div class="sk-product-choose">
                                <div class="sk-product-choose--head"><span class="s_like"><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0 ? 'Выберите '.$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].':':'Выберите размер:')?></span> <span id="sizeLabel"><?=$strSelectedSize?></span>
                                </div>
                                <ul class="sk-product-choose--item" id="sk-product-choose--item"><?=$strTmp?>
                                </ul>
                            </div><?
                            }
                    }?>
                    <div class="sk-under-color">
                        <div class="sk-bonus">Ваш бонус <span>0</span><span class="rouble">i</span></div>
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

                                <!--                               <li<?=(empty($arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"])?' class="hidden"':'')?> id="CODE_1C_CONT"><span class="s_like">Код товара:</span> <span id="CODE_1C"><?=$arStartOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?></span></li>--><?//   arshow($arResult["DISPLAY_PROPERTIES"]["PROIZVODITEL"]["DISPLAY_VALUE"] );
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
                                    <!--<li><span class="s_like">Гарантия:</span> <?=$arResult["DISPLAY_PROPERTIES"]["GARANTIYA_PROIZVODITELYA"]["DISPLAY_VALUE"]?></li>        -->
                                    <?
                                }?>
                                <li><a id="allParamLink" href="#" title="Все характеристики" class="sk-dotted">Все характеристики</a></li>
                            </ul>
                            <!--                            <div class="sk-sd-features-deliter" ></div>-->
                        </td>
                        <td>
                            <ul class="sk-sd-delvery">
                                <li>
                                    <div class="sk-sd-delvery--head">Доставка<?=($arResult["PROPERTIES"]["SBOR"]["VALUE"]>0 && in_array($intLocationID, array(1732, 2399))?' и сборка':'')?></div>
                                </li><?
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
                                            $strDeliveryData = '<li><span class="s_like">Дата доставки:</span> '.$strDeliveryDate.'</li>
                                            <li><span class="s_like">Стоимость:</span> '.($arStartOffer["PRICE"] < 3000?'300р. внутри МКАД':'бесплатно внутри МКАД').'</li>';
                                            if(false)
                                                $strDeliveryData .= '<li><span class="s_like">Сборка:</span> стоимость сборки (только если указано)';
                                        } elseif($intLocationID == 2399) {
                                            $strDeliveryData = '<li><span class="s_like">Дата доставки:</span> '.$strDeliveryDate.'</li>
                                            <li><span class="s_like">Стоимость:</span> '.($arStartOffer["PRICE"] < 3000?'300р. + 30 р./км':'30 р./км').'</li>';
                                        } else {
                                            $strDeliveryData = '<li><span class="s_like">Срок доставки:</span> от 2-х дней.</li>
                                            <li>Стоимость доставки зависит от веса, объема и расстояния.</li>';
                                        }

                                        //$strMos = '<span class="s_like">Дата доставки:</span> с '.$strDeliveryDate;
                                        //$strOther = '<span class="s_like">Сроки:</span> от 2-х дней';
                                    }

                                    if(false) { ?>
                                    <li class="sk-drop">
                                        <span class="s_like">Регион:</span>
                                        <a href="#" class="sk-link-btt"><span class="sk-dotted" id="deliveryRegion">Москва и МО</span></a>
                                        <ul class="sk-dropdown-menu" id="deliveryDropDown">
                                            <li><a data-name="Доставка по Москве и Подмосковью" id="moscowDeliveryData" data-str1='<?=$strMos?>' data-str2='' data-popup="delivery-moskow" href="#">Москва и МО</a></li>
                                            <li><a data-str1='<?=$strOther?>' data-str2="<span class='s_like'>Стоимость</span> от 350 р" data-popup="delivery-region" data-name="Доставка по регионам" href="#">Регионы</a></li>
                                        </ul>
                                    </li>
                                    <li id="deliveryStr1"></li>
                                    <li id="deliveryStr2"></li><?
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
                if($arPrices["CATALOG_PRICE_2"] > 0){
                    $prises = $arPrices["CATALOG_PRICE_2"];   
                }
            }
            // arshow($prises);
            if(!$arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] )
            {?>
            <!-- Если товара нет -->                
            <div class="sk-noproduct">
                <div class="sk-noproduct--cont">Нет в продаже
                    <br> <a rel="nofollow" class="notifyMeButton" href="#ng_<?=$arResult["ID"]?>" title="Уведомить о поставке">Уведомить о поставке</a><br> <a href="#" onclick="animateTo('#similarItems'); return false;" title="Смотреть аналоги">Смотреть аналоги</a><span class="sk-noproduct--arrow"></span></div>
                <div class="sk-noproduct--overlap"></div>   
            </div>
            <!-- END Если товара нет --><?
        }?><?
            if(false)
            {?>
            <?=showNI()?>
            <div class="popup_block" id="credit"  data-popup-head="Купить в кредит" style="display: none;">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/includes/card/credit.php",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );?>
            </div>
            <?=showNI(false)?>
            <?=showNI()?>
            <div class="popup_block" id="pickup"  data-popup-head="Самовывоз возможен по 100% предоплате" style="display: none;">
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/includes/card/pickup.php",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );?>
            </div>
            <?=showNI(false)?><?
        }?>
        <!-- END Попап -->
        <!-- Галерея -->
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
                        <a href="<?=$strStartBigImage?>" id='zoom1' alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="cloud-zoom" rel="useZoom: 'zoom1', adjustX:0,adjusty:-50, zoomWidth:500, zoomHeight:408" ><img id="galleryCurrentImage" src="<?=$strStartBigImage?>"  data-last="<?=$strStartBigImage?>" alt=""></a>
                    </div>

                </div>
                <div class="sk-gallery--color--holder">
                    <div class="sk-gallery--avl-price">
                        Доступные цвета для этой модели
                    </div>
                    <div class="sk-gallery-color" id="galleryListPreview"><div class="sk-gallery-color-scroll">
                            <!-- Color Items-->
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
                                            }


                                            //arshow($galleryBigImg);?>
                                        <a<?=($intGallryCnt>13?' style="display:none;"':'')?> 
                                            title="<?=$strGalleryItemName?>" 
                                            class="sk-gallery-color-item cloud-zoom-gallery" 
                                            id="galleryOffer<?=$arItem["ID"]?>" <?=$strSizeHash?> 
                                            data-orig="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>" 
                                            data-img="<?=$galleryBigImg["src"]?>" 
                                            href="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>" 
                                            alt="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>" 
                                            rel="useZoom: 'zoom1', zoomWidth: '400', smallImage: '<?=$galleryBigImg["src"]?>' ">
                                            <div class="sk-gallery-color--img">
                                                <img src="<?=$smallImg["src"]?>" alt="<?//=$strH1orName?>">
                                                <span>Выбрать</span>
                                            </div>
                                            <div class="sk-gallery-color--body">
                                                <div class="sk-gallery-color--head"><?=smart_trim($strGalleryItemName, 19)?></div>
                                                <div class="sk-gallery-color--price"><?
                                                    if($arItem["PRICE"]>0)
                                                    echo number_format($arItem["PRICE"], 0, '', ' ').'<span class="rouble">a</span>'; ?></div>
                                            </div>
                                        </a><?
                                            $intGallryCnt++;
                                        }
                                    }
                                }
                            ?>
                            <!-- END Color Items-->    
                        </div>                                                        
                    </div><?
                        if($intGallryCnt>14)
                        {?>
                        <!-- <div class="sk-gallery--all-price"><a href="#" onclick="$('#galleryListPreview a:hidden').show(); $(this).parent().hide(); return false;" title="Показать все цвета">Показать все цвета</a></div> -->

                        <div class="sk-gallery--all-price"><a href="#" title="Показать все цвета">Показать все цвета</a></div><?
                    }?>
                </div>
            </div>

            <div class="sk-gallery-overlap"></div>
        </div>
        <!-- END Галерея -->
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
    <!-- END product_block -->
</span>

<?      
    if(((/*$arStartOffer["PRICE"] == 0  || */$ar_quantity  == 0 || $prises == 0)                                                                                   //проверка на отображение заглушки
        and $arResult["OFFERS"][0]["CATALOG_QUANTITY"] == 0)  or $arResult["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] != "" )
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
    } else { ?>
    <div class="characteristic_block">     
        <!-- Tabs -->
        <div class="sk-tab">
            <ul class="sk-tab--tabs">
                <li class="sk-tabs--item_active">
                    <div class="oh3"><a id="paramTabTitle" href="#features" title="Характеристики">Характеристики</a></div>
                </li><?
                    if(!empty($arResult["DETAIL_TEXT"]))
                    {?>
                    <li>
                        <div class="oh3"><a href="#descr" title="Описание товара">Описание товара</a></div>
                    </li><?
                }?>
                <li>
                    <div class="oh3"><a id="commentTabTitle" href="#comment" title="Отзывы">Отзывы</a></div>
                </li><?
                    if(is_array($arResult["PROPERTIES"]["VIDEO"]["VALUE"]) && count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])) { ?>
                    <li class="sk-tabs--item_video">
                        <div class="oh3"><a href="#video" title="Видео">Видео (<?=count($arResult["PROPERTIES"]["VIDEO"]["VALUE"])?>)</a></div>
                    </li><?
                }?>
            </ul><?      
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
                {
                    if($arProp["MULTIPLE"] != "Y")
                        $arTmp = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult["PROPERTIES"][$key], "news_out");

                    //                      arshow($arTmp["CODE"]);
                    if (($arTmp["PROPERTY_TYPE"]=='S' || $arTmp["PROPERTY_TYPE"]=='N' || $arTmp["PROPERTY_TYPE"]=='L') && ($arTmp["CODE"]!='UPDATE_HASH' && $arTmp["CODE"]!='PRICE' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='PHASH' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='WISH_RATING' && $arTmp["CODE"]!='CML2_ARTICLE' && $arTmp["CODE"]!='title' && $arTmp["CODE"]!='SALES_RATING' && $arTmp["CODE"]!='CML2_BASE_UNIT' && $arTmp["CODE"]!='SERVICE_QSORT' && $arTmp["CODE"]!='description' && $arTmp["CODE"]!='CATALOG_AVAILABLE' && $arTmp["CODE"]!='QU_ACTIVE' && $arTmp["CODE"]!='NEW' && $arTmp["CODE"]!='SALE_RATING' && $arTmp["CODE"]!='RATING' && !strstr($arTmp["CODE"], "SEO")))
                    {
                        $arTmp["DISPLAY_VALUE"] = prepareMultilineText($arTmp["DISPLAY_VALUE"]);            

                        $strProps .= '<li><div class="oh4">'.$arProp["NAME"].'</div>    <p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';

                    }
                    //}
                }
            ?>
            <div class="sk-tab--content"> 
                <!-- features tab -->
                <div id="features" class="sk-tab--item" style="display: block;"> 
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
                <div id="comment" class="sk-tab--item" style="display: none;"> 
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
                                "CACHE_TIME" => "0",
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
                                "CACHE_TIME" => "0",
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
        </div>
        <!-- END Tabs--><?
            if(false)
            {?>

            <!--
            <div class="characteristic_left">
            <div class="headline">Характеристики</div>



            <div class="clear"></div><br /><br />

            <div class="headline">Описание</div>
            <div class="characteristic_text">
            <h5>роватка-маятник Лаванда АБ 21.3 из натурального бука - идеальный выбор перв</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p><br />
            </div>
            <div class="clear"></div><br /><br />

            <div class="headline">Отзывы</div>
            <div class="characteristic_text">
            <ul class="comment_list">
            <li>
            <div class="headline_info">
            <img src="/bitrix/templates/nmg/img/pic1.png" width="40" class="photo" height="40" alt="" />
            <h6><a href="#" title="">Анастасия Иванова</a></h6>
            <p><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span></p>
            <div class="rating">
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <b>12 марта 2012</b>
            </div>
            </div>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p>
            </li>
            <li>
            <div class="headline_info">
            <img src="/bitrix/templates/nmg/img/pic1.png" width="40" class="photo" height="40" alt="" />
            <h6><a href="#" title="">Анастасия Иванова</a></h6>
            <p><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span><img src="/bitrix/templates/nmg/img/pic1.png" width="16" height="16" alt="" /><span><a href="#" title="">Вера</a>, 1 год</span></p>
            <div class="rating">
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <b>12 марта 2012</b>
            </div>
            </div>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem</p>
            </li>
            </ul>
            </div>
            <div class="clear"></div>

            <div class="headline">Ваш отзыв</div>
            <div class="your_comment">
            <div class="your_comment_headline">
            <b>Ваша оценка:</b>
            <span>ужасно</span>
            <span>плохо</span>
            <span class="active">удовлетворительно</span>
            <span>хорошо</span>
            <span>отлично</span>
            </div>
            <div class="input_1"><textarea cols="" rows="" name=""></textarea></div>
            <input type="submit" class="input_2" value="Добавить отзыв" />
            <div class="input_info">За отзыв вы получите 1 балл.</div>
            </div>
            <div class="clear"></div>

            </div>
            <div class="characteristic_right">

            <div class="crumbs indent2">Также рекомендуем</div>

            <div class="similar_block similar_block_right">
            <ul>
            <li>
            <div class="photo"><p><img src="/bitrix/templates/nmg/img/photo.jpg" width="105" height="120" alt="" /><span>&nbsp;</span></p></div>
            <div class="rating">
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            </div>
            <div class="link"><a href="#" title="">Платья Sue Wong<br />Ombre Beaded Lo ...</a></div>
            <strong>15 000 р</strong>
            </li>
            <li>
            <div class="photo"><p><img src="/bitrix/templates/nmg/img/photo.jpg" width="105" height="120" alt="" /><span>&nbsp;</span></p></div>
            <div class="rating">
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            <span class="on"></span>
            </div>
            <div class="link"><a href="#" title="">Платья Sue Wong<br />Ombre Beaded Lo ...</a></div>
            <strong>15 000 р</strong>
            </li>
            </ul>    
            </div>

            <div class="crumbs indent1">Хотят</div>
            <div class="right_text"><a href="#" title="">23 пользователя</a></div>

            <div class="crumbs indent1">Уже имеют</div>
            <div class="right_text"><a href="#" title="">7 друзей</a></div>

            </div>
            --> <?
        }?>
    </div>
    <?    //arshow($arResult["SECTION"]["ID"]); 
        // if(is_array($arResult["PROPERTIES"]["LIKE"]["VALUE"]))
        // $GLOBALS["arrLikeFilter"]["ID"] = $arResult["PROPERTIES"]["LIKE"]["VALUE"];
    ?><?$APPLICATION->IncludeComponent("sk:catalog.like.items", "newCard1", Array(
            "AJAX_MODE" => "N",    // Включить режим AJAX
            "ELEMENT_ID" => $arResult["ID"],    // Родительский элемент
            "SECTION_ID" => $arResult["SECTION"]["ID"],    // Родительский раздел
            //"strFilter" => "arrLikeFilter",    // Внешний фильтр
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
<div style="position:absolute; top:-10000px; right:100000px;" id="colorsStorageHere"><?
        foreach($arTmpSizeHtml as $strSize => $strSizeHtml)
        {
            if($strSize != $arResult["START_SIZE"])
                echo $strSizeHtml;
    } ?>
</div>
<input type="hidden" id="cartPrice" value="<?=$arResult["CART_PRICE"]?>">
<script type="text/javascript">
    $(document).ready(function() {
        var obTR = $("#colorsHere").next().find(".select_block_bg1").find("tr");
        if(obTR.length == 1)
        {
            obTR.click();
            $("#colorsHere").next().find(".select_block_bg").unbind("click");
        }
    });

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
