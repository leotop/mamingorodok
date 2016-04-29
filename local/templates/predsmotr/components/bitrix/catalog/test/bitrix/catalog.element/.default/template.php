
<?
    global $USER; 
    $rsGroup = CGroup::GetByID(1, "Y");
    $arGroup = $rsGroup->Fetch();   
    global $arGroups;
    $arGroups = $USER->GetUserGroupArray();
    //arshow($arGroups[0]);
?>
 <div id="ajaxContain"></div>
<div class="afterBuy">
    <p class="title">Товар успешно добавлен в корзину</p>
    <a href="javascript:void(0)" class="contin">продолжить выбор товаров</a>
    <a href="/basket/" onclick="return close_frame(this);" class="next">перейти к оформлению заказа</a> 
    <img src="/bitrix/templates/nmg/img/close_bg.png" class="closeAfterBuy">                                    
</div>            
<div class="overla"></div>  

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
                    $arColorList = $arResult["CS"]["CHASSI"];
                }
                //                arshow($arColorList, true);
                foreach ($arColorList as $arSizeItem => $arSize) { 
                    //                                        arshow(count($arSize), true);
                    if (count($arSize)>=1) {
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

                            $price=GetOfferMinPrice($arParams["IBLOCK_ID"],$arOffer["ID"]);

                            if ($arOffer["PRICE"] > 0 && $arOffer["CATALOG_QUANTITY"] > 0){             //проверка на количество элементов у которых указана цена ... // проверка на количество элементов на складе
                                global $ar_quantity;  
                                //  arshow($arOffer,true);
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
                                href="<?if(empty($bigImg["src"])){echo "/img/no_foto.jpg";}else{echo $bigImg["src"];}?>" 
                                alt="<?=CFile::GetPath($imgName["MAXI"]["ID"])?>"  
                                rel="useZoom:'zoom2'" 
                                <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                                class="cloud-zoom-gallery sk-product-color--item<?=($intCnt == 0?' sk-product-color--item_active':'' /*or ($arStartOffer["ID"] == $arOffer["ID"]?' sk-product-color--item_active':'')*/)?><?=($intCnt==0?' first':'')?>" 
                                <?//активность класса происходит при наличии 1 элемента $intCnt?> 
                                data-code="<?=$arOffer["PROPERTY_ELEMENT_XML_1C_VALUE"]?>" 
                                data-color="<?=$arOffer["PROPERTY_TSVET_VALUE"]?>" 
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
        font-size: 22px !important;
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
        background: #FF7A00  url(/bitrix/images/mamin_new_icon3.png) no-repeat 25px;
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
        /*        margin-bottom: 20px;*/
        border-bottom: 1px solid #E7E4E8;
    }
    .soc_block {
        padding-left: 25px;
        padding-bottom: 45px;
        padding-top: 30px;
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
        width: 192px;
        cursor: pointer;
    }
    .sk-under-color .sk-bonus {
        background:  url(/bitrix/templates/nmg/img/tick.png) no-repeat 15px !important;
        width: 152px;
    }
    .sk-under-color .sk-supply {
        background:  url(/bitrix/templates/nmg/img/tick.png) no-repeat 15px !important;
        width: 210px;
    }
    .sk-small-description-wrap {
        background: none !important;
        border: 1px solid #E9E5EA;
        border-radius: 3px!important;
        padding: 14px 0;
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
        height: 34.5%;
    }
    .sk-sd-delvery-deliter{
        position:absolute;
        width: 1px;
        background-color: #E5E1E6;
        margin-top: -161px;
        margin-left: 142px;
        height: 179px; 
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
        overflow: hidden;
        line-height: 1.4;
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
        margin-left: 130px;
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
    .product_compare{
        display: inline-block;
    }
    .product_compare label{
        display: inline-block;
        font-size: 14px;
        padding-left: 25px;
        background: url(/bitrix/templates/nmg/img/compare.png) no-repeat 0px 100%;
        cursor: pointer;  
        height: 15px;             
    }
    .product_compare input{
        display: none;   
    }
    .product_compare a {
        color: #808080;
        margin: 0 10px 0 0;
        display: inline-block;
        font-size: 13px;
        font-style: italic;
    }
    .infobar-div {
        position: absolute;
        display: inline-block;
        width: 350px;
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
        float: left;
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
    .addWishBut {
        color:  #D40000;
        text-decoration: none !important;
    }
    .chassi-title {
        position: absolute;
        margin-top: 5px; 
        margin-left: 5px;
    }
    .chassi-select { 
        margin-left: 130px !important;
    }
    #deleteFromWishList {
        cursor: pointer;
    }
    .characteristic_block{
        width: 370px !important;
    }
    #characteristic_block{
        background-color: white;
        left: 555px;
        bottom: -27px;
        position: absolute;
        z-index: 100;  
        padding: 14px!important;
        border: 1px solid black;
        border-radius:15px;   
    }
    .characteristic_info{
        width: 100% !important;
        padding: 0!important;
    }
    .rating{
        float: left;
    }
    #char_close{
        position: absolute;
        right: -10px;
        top: -10px;
        cursor: pointer;
    }
    div.links{
        color: #d40000;
        cursor: pointer;
        text-decoration: underline;
    }
    .afterBuy{
        display: none;
        width: 450px;
        height: 112px;
        position: absolute;
        top:50%;
        left:50%;
        margin: -56px 0 0 -225px;
        background-color: white;
        z-index:5005;
        border-radius:10px;
    }
    .overla{
        position: fixed;
        width: 150%;
        height: 150%;
        left:-200px;
        top:-200px;
        z-index:5004;
        display: none;  
        opacity: 0.5;
        background-color: black;
    }
    div.afterBuy .title{
        color: #80568d;
        font-size: 18px;
        padding-top: 10px;
        text-align: center;
        padding-bottom: 20px;    
    }
    div.afterBuy .contin{
        padding-left: 42px;
        padding-right: 20px;   
    }
    div.afterBuy .next{
        
    }
    .closeAfterBuy{
        cursor: pointer;
        position: absolute;
        right: -5px;
        top: -5px;
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
        //Выбор шасси
        $(".chassiItem").click(function () {
            $(".sk-product-choose--item").slideUp(); 
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
                <script>
                    $(function(){
                        var check = false;
                        $(".product_compare label").click(function(){
                            if($(".product_compare input").prop("checked") == true){
                                check = true;
                                $('.product_compare label').css({"background-position": "0 10%"});     
                            }else if(check = true){
                                check = false;  
                                $('.product_compare label').css({"background-position": "0 100%"}); 
                            }
                        });
                    });
                </script>
                <div class="product_compare">
                    <label><input type="checkbox" class="input2 add-to-compare-list-ajax" value="<?=$arResult["ID"]?>" /></label>
                    <i title="/catalog/compare/">Сравнить</i>
                    <?
                        if(false)
                        {
                        ?><span></span><?
                    }?>
                </div> 
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
            <script>
                function close_iframe() {     
                    window.top.location = document.location.pathname+'#comment';
                    
                return false;
                }function close_iframes() {     
                    window.top.location = document.location.pathname;
                    
                return false;
                }
                function close_frame(){
                    window.top.location = '/basket/'
                }    
            </script>
            
            
            <div class="infobar-div">
            <?
                $page = $APPLICATION->GetCurPageParam("", array("pred")); 
                $strAddon = '<a class="comment grey" href="'.$page.'#comment" onclick="return close_iframe(this);">Написать отзыв</a>';
                $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
             ?>
                <ul class="sk-product-info-bar">
                    <li>
                       
                    </li>
                    <li>

                        <?=showNoindex()?>
                        <div class="links "> 
                        
                        #ADD_TO_WISH_LIST#
                            <!--                        <a href="#" title=""><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="" /><span>К сравнению</span></a>-->
                        </div>
                        <?=showNoindex(false)?>

                        <!--                        <div class="delayed-list">Нет отложенных</div>-->
                    </li>

                </ul>
            </div> 
        </div>   
        <!-- product_block_photo -->

        <div class="product_block_photo">
            <div id="large" class="sk-product-img">
               <!-- <div class="sk-product-img--zoom"><a href="#" class="">Смотреть все фото</a></div>       -->
                <table>
                    <tr>
                        <td>
                            
                                <img src="<?=$bigImg["src"]?>" 
                                    title="<?=$arResult["NAME"]?>" 
                                    alt="<?=$strH1orName?>" 
                                    data-last-img="<?=$bigImg["src"]?>"  
                                    itemprop="image"/>                 
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
                                    
                                    
                                    <div class="sk-product-price-one"><?=($arResult["COLORS_HAS_SAME_PRICE"]?'':'от ')?><?=number_format($arStartOffer["PRICE"], 0, '.', ' ')?>  <span class="rouble">a</span>
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
                        <div class="sk-product-price-buy"><a onclick="_gaq.push(['_trackEvent', 'Button', 'buy', 'card']);after_buy();post_func();" href="#" class="addToCartButton">Купить</a></div>

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
                        //                        arshow($arStartOffer, true);
                        ?>
                    </div><?

                        if(!$singleOffer)
                        {
                            $strTmp = '';
                            $strSelectedSize = '';
                            //                            arshow($arResult["CS"], true);

                            foreach($arResult["CS"] as $strSize => $arFoo)
                            {
                                if($arResult["SIZE_AVAIL"][$strSize] == "Y")
                                    $htmlCross = '';
                                else $htmlCross = '<div class="cross"></div>';

                                if($strSize == $arStartOffer["PROPERTY_SHASSI"]) $strSelectedSize = $strSize;


                                if ($arResult["SIZE_AVAIL"][$strSize] == "Y") {
                                    if ($strSize!="Стандарт") {
                                        $strTmp .= '
                                        <li'.($arResult["SIZE_AVAIL"][$strSize] == "Y"?'':' sizeNotAvailable').($strSize == $arStartOffer["PROPERTY_RAZMER_VALUE"]?' class="sk-product-choose--item_active"':'').' id="lisize_'.md5($strSize).'"><a href="#" title="'.$strSize.'" data-color="'.$strSize.'">'.$strSize.'</a></li>';
                                    } 
                                }  
                        }?>

                        <?if (!$onlyStandardSize && empty($arResult["CS"]["CHASSI"]) ){?>

                            <div class="sk-product-choose">
                                <div class="sk-product-choose--head">
                                    <span class="s_like"><?=(strlen($arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"])>0 ? 'Выберите '.$arResult["PROPERTIES"]["CH_VYBIRAEM"]["VALUE"].':':'Выберите размер:')?></span> <span id="sizeLabel"><?=$strSelectedSize?></span>
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
                                            foreach ($arChassi as $strColor => $arColor) {
                                            ?> 

                                            <li ><a class="chassiItem" id="<?=$arColor["ID"]?>"><?=$strChassi.' ('.$strColor.')'?></a></li>
                                            <?} }

                                    ?>
                                </ul>
                            </div>
                            <?}

                    }?>
                    <div class="sk-under-color">
                        <div class="sk-bonus">Ваш бонус <span>0</span><span class="rouble">i</span></div>
                        <div class="sk-supply">Официальная поставка</div>
                        <?$paged = $APPLICATION->GetCurPageParam("", array("pred","comment"));?>
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
                                <li><a id="show_char" href="javascript:void(0)" title="Все характеристики" class="sk-dotted">Все характеристики</a></li> 
                                <li><a href="<?=$paged?>" onclick="return close_iframes(this);" class="sk-dotted">Подробнее о товаре</a></li>                    
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
    
<!--------------------------------------блок подробных характеристик-------------------------------------------------------------------------------------------------------->       
       <div class="characteristic_block char_popup" id="characteristic_block" style="display: none;">     
        <!-- Tabs -->
        <div class="sk-tab">
            <img src="/bitrix/templates/nmg/img/close_bg.png" id='char_close'>
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
                {
                    if($arProp["MULTIPLE"] != "Y")
                        $arTmp = CIBlockFormatProperties::GetDisplayValue($arResult, $arResult["PROPERTIES"][$key], "news_out");         
                    if (($arTmp["PROPERTY_TYPE"]=='S' || $arTmp["PROPERTY_TYPE"]=='N' || $arTmp["PROPERTY_TYPE"]=='L') && ($arTmp["CODE"]!='UPDATE_HASH' && $arTmp["CODE"]!='PRICE' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='PHASH' && $arTmp["CODE"]!='GARANTIYA_PROIZVODITELYA' && $arTmp["CODE"]!='WISH_RATING' && $arTmp["CODE"]!='CML2_ARTICLE' && $arTmp["CODE"]!='title' && $arTmp["CODE"]!='SALES_RATING' && $arTmp["CODE"]!='CML2_BASE_UNIT' && $arTmp["CODE"]!='SERVICE_QSORT' && $arTmp["CODE"]!='description' && $arTmp["CODE"]!='CATALOG_AVAILABLE' && $arTmp["CODE"]!='QU_ACTIVE' && $arTmp["CODE"]!='NEW' && $arTmp["CODE"]!='SALE_RATING' && $arTmp["CODE"]!='RATING' && !strstr($arTmp["CODE"], "SEO")))
                    {
                        $arTmp["DISPLAY_VALUE"] = prepareMultilineText($arTmp["DISPLAY_VALUE"]);       
                        $strProps .= '<li><div class="oh4">'.$arProp["NAME"].'</div>    <p>'.$arTmp["DISPLAY_VALUE"].'</p></li>';    
                    }
                }
            ?>  
                <div  class="sk-tab--item" style="display: block;">       
                    <div class="characteristic_info">      
                            <div class="characteristic_info-head">Типовые характеристики</div>
                            <ul class="sk-characteristic-list">
                                <?=$strProps?>
                            </ul>     
                    </div>   
                </div>
        </div>
    </div>
<!--------------------------------------КОНЕЦ--------блок подробных характеристик-------------------------------------------------------------------------------------------------------->       
  
    <script>
//------------------------------------появление блока характеристик---------------------------------------------------
        $('#show_char').click(function(){             
           $("#characteristic_block").toggle();   
        });
        $('#char_close').click(function(){             
           $("#characteristic_block").toggle();   
        });  
//----------------------------------------------------------------------------------------------------------------------                                       
    </script>   
       
       
       
       
       
        
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
            //if(!$arResult["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] )
            //if(!$arResult["CATALOG_AVAILABLE"])
           ?><?
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
<?     
/*    $res = CCatalogSKU::getOffersList(array($arResult['ID']),$arResult['IBLOCK_ID']);          
    foreach($res[$arResult['ID']] as $arTorgPred){
        //arshow($arTorgPred);
        $dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC"),array('USER_ID'=>$user_id, 'ORDER_ID'=>'NULL','PRODUCT_ID'=>$arTorgPred['ID']),false,false,array("ID","QUANTITY",'PRODUCT_ID'));
        while ($arItems = $dbBasketItems->Fetch()){
            ?>
             <script>         
                $('.addToCartButton').html('В корзине');
                $('.sk-product-price-buy a').css({'background':'#C0BBC1','padding-left':'38px'});    
                
            </script>
        <?
        }     
     }*/?>
<script>
function after_buy(){
    $('.addToCartButton').html('В корзине');
    $('.sk-product-price-buy a').css({'background':'#C0BBC1','padding-left':'38px'});     
    $('.afterBuy').show();    
    $('.overla').show();
                           
};
$('.contin').click(function(){
    $('.afterBuy').hide();
    $('.overla').hide();
});
$('.closeAfterBuy').click(function(){
    $('.afterBuy').hide();
    $('.overla').hide();
});

</script>

