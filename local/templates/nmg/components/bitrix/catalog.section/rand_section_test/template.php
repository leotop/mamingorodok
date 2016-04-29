
<div class="noRegister">
    <p class="title">Для того чтобы добавить товар в список "Избранное" требуется</p>
    <a href="/personal/registaration/" class="registation">регистрация</a>
    <span> или </span>
    <a href="/personal/profile/" class="">авторизация</a> 
    <img src="/bitrix/templates/nmg/img/close_bg.png" class="closeAfterBuy">                                    
</div>            
<div class="overla"></div> 

<div class="compare_comment" style="display: none;">
    <div class="compare_com">
        <p style="margin-top: 13px;">Товар добавлен в сравнение</p>
    </div>
</div>
<div class="like_comment" style="display: none;">
    <div class="like_com">
        <p style="margin-top: 13px;">Вам понравился товар</p>
    </div>
</div>

<style >
    .bx-pager-item{
        display: none !important;
    }
</style>

<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    // arshow($arResult);
    $filter = substr_count($_SERVER["REQUEST_URI"],"/filter/");

    $parent_catalog = substr_count($_SERVER["REQUEST_URI"],"/catalog/filter/");


    $isSearch = $arParams["SEARCH"] == "Y";

    $strH1 = $arResult["META"]["H1"];
    $strH2 = $arResult["META"]["H2"];

    if($GLOBALS["SET_SEO"]["type"] == 'producer')
    {
        $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
        $strProducer = $GLOBALS["SET_SEO"]["DATA"]["NAME"];

        //$strH1 = "Детские ".ToLower($strCategoryName).' '.$strProducer;
        $strH1 = $strCategoryName.' '.$strProducer;
        //$strH2 = $strH1;
    } elseif($GLOBALS["SET_SEO"]["type"] == 'property') {
        $strCategoryName = $arResult["PATH"][count($arResult["PATH"])-1]["NAME"];
        $strH1 = $strCategoryName.' '.ToLower($GLOBALS["SET_SEO"]["DATA"]["ENUM"]["VALUE"]);
        $strH2 = $strH1;
    }

    if(strlen($arResult["SEO"]["H1"])>0) $strH1 = $arResult["SEO"]["H1"];
    if(strlen($arResult["SEO"]["H2"])>0) $strH2 = $arResult["SEO"]["H2"];

    // arshow($arResult); 

    if(!$isSearch)
    {
        if(preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()) || preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()))
            $strH1Addon = 'Детские товары ';
        else $strH1Addon = '';
    ?>

    <br> 
    <h1 class="secth">Лидеры продаж</h1><?

        if($arParams["brendID"]<=0)
        {
            if($_REQUEST["set_filter"] == "Y") $arResult["DESCRIPTION"] = '';
            if(strlen($arResult["SEO"]["SEO_TEXT"])>0)
            {
                $arResult["DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
                $arResult["~DESCRIPTION"] = $arResult["SEO"]["SEO_TEXT"];
            }
        }
    } else echo '<h1>Результаты поиска</h1>';

    if($_REQUEST["set_filter"]=="Y" && (count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
    { ?>
    <div class="search-page">
        <div class="top15"></div>
        <div>Измените запрос или попробуйте поискать в <a href="/catalog/">каталоге</a>.</div>
    </div><?
        return false;
    } elseif($isSearch) {
        if((count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
        {
        ?>
        <div class="search_block"><div class="inputs">
                <form action="/tools/search/">
                    <input type="text" value="<?=(strlen($_REQUEST["q"])>0?htmlspecialcharsEx($_REQUEST["q"]):'Поиск по городку')?>" name="q" class="input1 searchInputField noGray black">
                    <button value="" class="input2" type="submit" name="s" id=""><span class="png"><span class="png"><nobr></nobr></span></span></button>
                </form>
            </div><br clear="all"><br>По Вашему запросу ничего не найдено. Попробуйте изменить запрос или искать товар в каталоге.</div><?
        } else {
            if(strlen($_REQUEST["q"])>0)
            { ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#searchInputField").val("<?=htmlspecialcharsEx($_REQUEST["q"])?>").addClass("black");
                });
            </script><?
            }
        }
    }

?>
<div class="catalog_block">
    <ul class="catalog_list"><?
            $intLastSection = 0;
            foreach($arResult["ROWS"] as $arRow)
            {
                foreach($arRow as $arElement)
                {
                    $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], $strElementEdit);
                    $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                    $strMainID = $this->GetEditAreaId($arElement['ID']);

                    if (intval($arElement["ID"])==0) continue;

                    if($arParams["brendID"]>0)
                    {
                        if($arElement["IBLOCK_SECTION_ID"] != $intLastSection)
                        {
                            if($intLastSection > 0) echo '<div class="clear"></div>';
                            echo '<div class="crumbs"><a href="'.$arResult["BREND_SECTIONS"][$arElement["IBLOCK_SECTION_ID"]]["SECTION_PAGE_URL"].'proizvoditel_'.$arResult["BREND"]["CODE"].'/">'.$arResult["BREND_SECTIONS"][$arElement["IBLOCK_SECTION_ID"]]["NAME"].' '.$arResult["BREND"]["NAME"].'</a></div>';
                            $intLastSection = $arElement["IBLOCK_SECTION_ID"];
                        }
                    }
                ?>
                <li id="<?=$strMainID?>" class="li_hover_mod">
                    <?   
                        $smallImg=null;
                        $offerPrices = array();
                        $torgPred=0;              
                        //---------------------------------------------------получаем картинки----------------------------------------------------------------------
                        /*$rsOffers = CCatalogSKU::getOffersList($arElement["ID"],0,array(),array('XML_ID'));   //получаем список торговых предложений              
                        foreach($rsOffers[$arElement["ID"]] as $arTovar){

                            $tmp_path=getResizedIMGPath($arTovar['XML_ID']);

                            $priceCheck = CPrice::GetList( array(), array("PRODUCT_ID"=>$arTovar["ID"],">PRICE"=>0),false,false,array("PRICE"))->Fetch();
                            if ($tmp_path && $priceCheck["PRICE"]){
                                $smallImg[$arTovar["ID"]] = getResizedIMGPath($arTovar['XML_ID']);
                                $offerPrices[$arTovar["ID"]] = $priceCheck["PRICE"];
                                //echo $smallImg[$arTovar["ID"]]."<br>";    

                            }
                            //  arshow($offerPrices,true);

                        }  */             
                        //-----------------------------------------------------------------------------------------------------------------------------------------
                        $width=count($smallImg)*60;
                    ?>
                    <style>
                        <?echo('.carusel_'.$arElement["ID"])?>{
                        width: 60px;             
                        position: relative;
                        top:0;
                        }
                    </style>      
                    <div class="catalog_bg stock-item card"> 
                        <div class="carusel_body">    
                            <?if($torgPred>4){?><div class="down" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}
                                else{?><div style="height: 26px;"></div><?}?>
                            <div class="tovar_card">
                                <div class="<?echo('carusel_'.$arElement["ID"])?> itemPreviewCarousel">
                                    <?foreach($smallImg as $oID=>$pict){?>
                                        <div class="slider_element"><img src="<?=(empty($pict)?'/img/no_photo_52x52.png':$pict)?>" titile="" alt="<?=$strH1orName?>" data-price="<?=number_format($offerPrices[$oID], 0, ',', ' ');?>"> </div>                                                                                                                     
                                        <?}?> 
                                </div>             
                            </div>
                            <?if($torgPred>4){?><div class="up" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}?>
                        </div>
                        <?   
                            if($arElement["ACTIVE"] == "N")
                                echo '<div class="element_inactive">Деактивирован</div>';
                            if(isset($arResult["ACTIONS_ITEMS"][$arElement["ID"]]))
                            {
                                $arAction = $arResult["ACTIONS"][$arResult["ACTIONS_ITEMS"][$arElement["ID"]]];
                                $isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;

                                if($isSpecOffer)
                                {?>
                                <div class="wrap-specialoffert">
                                    <a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="Спецпредложение!" class="btt-specialoffert">Спецпредложение!</a></div><?
                            }?>
                            <div class="prize"><?
                                    if(!$isSpecOffer)
                                    {?>
                                    <a href="#" target="_blank"><div class="gift_bg"></div></a><?
                                }?>
                                <div class="gift_info ">
                                    <div class="gift_info_text">
                                        <div style="text-align: center;">Акция!</div> <?=$arAction["PREVIEW_TEXT"]?>                                         
                                    </div><div class="gift_info_bg"></div></div></div><?
                            }

                            if(!empty($arElement["DETAIL_PICTURE"]["ID"])){
                                $arFileTmp = CFile::ResizeImageGet(                 
                                    $arElement["DETAIL_PICTURE"]["ID"],
                                    array("width" => 160, 'height' => 160),
                                    BX_RESIZE_IMAGE_PROPORTIONAL,
                                    false
                                );
                            }else{
                                $arFileTmp["src"] = "/img/no_foto.jpg";
                                $arFileTmp["width"] = "160";
                                $arFileTmp["height"] = "160";   
                            }

                            if($arFileTmp["height"] == 0){$arFileTmp["height"] = "auto" ;}else {$arFileTmp["height"] = "160";}
                            if($arFileTmp["width"] == 0){$arFileTmp["width"] = "auto";}else {$arFileTmp["width"] = "160";}

                        ?>
                        <div class="photo">
                            <?$APPLICATION->IncludeFile("/includes/shields.php",array("props" => $arElement["PROPERTIES"]),array("SHOW_BORDER" => false))?>
                            <p><i title="<?=$arElement['DETAIL_PAGE_URL']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=(empty($arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?$arElement["NAME"]:$arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?>"></i><span>&nbsp;</span></p>
                        </div>

                        <?                             
                            $strAddon = "";
                            if(!$isSearch) {
                                //   $strAddon = '#REPORT_COUNT_'.$arElement["ID"].'#';
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'/#comment">Написать отзыв</a>';

                            } 
                            else  {
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'/#comment">Написать отзыв</a>';
                            }
                            if(strlen($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"])>0) {
                                $strAddon .= '<a class="ttp_lnk 3dlink" onclick="window.open(\'/view360.php?idt='.$arElement["ID"].'\', \'wind1\',\'width=900, height=600, resizable=no, scrollbars=yes, menubar=no\')" href="javascript:" title="Подробная 3D - Модель"><i class="img360">3D модель</i></a>';
                            }
                            // echo showNoindex();
                            $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
                            // echo showNoindex(false); ?>

                        <div class="info_block">    
                            <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement["NAME"]?>"><?=smart_trim($arElement['NAME'], 70)?></a></div><?
                                if(false)
                                {?>
                                <div class="textPreview"><?=smart_trim(strip_tags($arElement["DETAIL_TEXT"]), 120)?></div><?
                            }?>
                            <div class="price">
                                <?
                                    $arElement["PROPERTIES"]["PRICE_CODE"]["VALUE"] = substr($price, 0, strlen($price)-3);
                                    //  if($USER->IsAdmin()){arshow($arElement["PROPERTIES"]);};
                                    $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);

                                    // arshow($arElement["PROPERTIES"]["CH_SNYATO"]);
                                    if($price == 0 || $arElement["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] !="" || $arElement["COUNT_SKLAD"] <=0) //проверка цены если больше 0 ....//если количество товаров меньше 2
                                        echo '<span class="currency" style="width: 100%;font-size:12px">Нет в наличии</span>';
                                    else 
                                    {?>


                                    <span class="currency" style="width: auto;" rel="<?=CurrencyFormat($price, "")?>"><?=number_format($price, 0, '.', ' ' );?> <div class='rub_none'>руб.</div><span class='rouble'>a</span></span>
                                    <!-- <span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>--><?
                                        if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
                                        {?>
                                        <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
                                        };
                                }?>
                            </div><?
                                if(strlen($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"]) <= 0 || $arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                {
                                ?><!--<i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Быстрый просмотр</button></i>   -->
                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>?pred=Y" class="fast_view">Быстрый просмотр</a> 
                                <?
                                } elseif($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
                                ?>Новинка! Ожидаем поставку.<?
                                }

                                /*
                                if($arElement["COUNT_SKLAD"] == 0)
                                {?>
                                <a class="notifyMeButton" href="#ng_<?=$arElement["ID"]?>"><input type="button" class="input1_notify" value="" /></a><?
                                } else {?>
                                <a class="addToCartList" href="<?=$arElement["DETAIL_PAGE_URL"]?>#showOffers"><input type="button" class="input1" value="" /></a><?
                                }
                                */
                                echo showNoindex();
                            ?>
                        </div>

                        <div class="<?echo('rememb_'.$arElement['ID'])?> remember">  
                            <?if($USER->GetID() > 0){
                                    $rsI = CIBlockElement::GetList(Array("ID" => "DESC"), array(
                                        "ACTIVE" => "Y",
                                        "IBLOCK_ID" => 8,
                                        "PROPERTY_DELETED" => false,
                                        "PROPERTY_USER_ID" => $USER -> GetID(),
                                        "PROPERTY_PRODUCT_ID" => $arElement['ID']
                                        ), false, false, array(
                                            "ID",
                                            "IBLOCK_ID", "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS",
                                            "PROPERTY_PRODUCT_ID.DETAIL_PAGE_URL",
                                            "PROPERTY_PRODUCT_ID.NAME",
                                            "PROPERTY_PRODUCT_ID.PREVIEW_PICTURE"
                                    ));
                                    if($arI = $rsI->GetNext()){
                                        echo ('<a class="deleteFromWishListaa" data-id="'.$arI["ID"].'" data-remId="'.$arElement["ID"].'"  title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_t.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');

                                    }                 
                                    else{
                                        echo ('<a class="add addToLikeListaa" data-remId="'.$arElement["ID"].'"  title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a> ');   

                                    }    
                                }
                                else{
                                    echo ('<a class="showpUpss" class="userNoAuthaa" data-id="'.$arElement["ID"].'" href="#messageNoUser1" title="В избранное"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">Запомнить</p></a>');
                            }?>

                            <!-- <p class="addToLikeList"><img src="/bitrix/templates/nmg/img/header/ico-baby-listNotEmpty.png" class="heart_rem"> </p>     -->
                        </div>

                        <div class="comparison">
                            <label class="compare"><input type="checkbox" class="input29 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" /><span class="com_span" data-check=''></span><span class="comparsion_title">Сравнить</span></label>

                        </div>

                        <?
                            echo showNoindex(false);?>
                        <?
                            if(false)
                            {?>
                            <div class="info"><?
                                $maxChars = 270;
                                $strMoreText = smart_trim(strip_tags($arElement["DETAIL_TEXT"]), $maxChars);

                                $strMoreText .= '#TITLE_HERE#';
                                foreach($arResult["UF_HARACTERISTICS"] as $arPropertyName)
                                {
                                    $arProperty = $arElement["PROPERTIES"][$arPropertyName["CODE"]];

                                    if($arProperty["VALUE"]["TYPE"]=="html" || $arProperty["VALUE"]["TYPE"]=="HTML")
                                    {
                                        if(strlen($arProperty["VALUE"]["TEXT"])>0)
                                        {
                                            $strMoreText .= $arPropertyName["NAME"].': ';
                                            $strMoreText .=  htmlspecialchars_decode($arProperty["VALUE"]["TEXT"]).(strpos(htmlspecialchars_decode($arProperty["VALUE"]["TEXT"]), "<br")===false?"<br />":'');
                                        }
                                    }
                                    elseif($arProperty["VALUE"]["TYPE"]=="text" || $arProperty["VALUE"]["TYPE"]=="TEXT") {
                                        if(strlen($arProperty["~VALUE"]["TEXT"])>0)
                                        {
                                            $strMoreText .= '- '.$arPropertyName["NAME"].': ';
                                            $strMoreText .= "<pre>".$arProperty["VALUE"]["TEXT"]."</pre>";
                                        }
                                    } else {
                                        if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"])>0)
                                            $arProperty["VALUE"] = implode(", ",$arProperty["VALUE"]);

                                        if(strlen($arProperty["VALUE"])>0) $strMoreText .= '- '.$arPropertyName["NAME"].': '.htmlspecialchars_decode($arProperty["VALUE"]).(strpos($arPropertyName["NAME"].': '.$arProperty["VALUE"], "<br")===false?'<br />':'');
                                    }

                                    if($maxChars < strlen($strMoreText)) break;
                                }
                                echo str_replace(array("#TITLE_HERE#", "<BR><br />"), array('<br><br>', '<br />'), $strMoreText); // <div class="name">Характеристики:</div>?>
                            </div><?
                        }?>
                    </div>    

                </li>
                <?
            }?>
            <div class="clear"></div>
            <?
        }?>
    </ul>
    <div class="clear"></div>

</div>
<script>  
    $('.down').click(function(){
        var id=$(this).attr("data-id");
        var carusel_id='.carusel_'+id;
        var width=$(this).attr("data-width")
        var war=parseInt(width);   
        var top_val=parseInt($(carusel_id).css('top'));
        if(top_val<0){                                            
            $(carusel_id).animate({top:'+=50px'},500);         
        }         
    }); 
    $('.up').click(function(){
        var id=$(this).attr("data-id");
        var carusel_id='.carusel_'+id;
        var width=$(this).attr("data-width");
        var carus=parseInt(width);
        var top_val=parseInt($(carusel_id).css('top'));
        var card=parseInt($('.tovar_card').css('height'));   
        if ((card-top_val)<carus){                                
            $(carusel_id).animate({top:'-=50px'},500);       
        }
    });
    $('.showpUpss').click(function(){
        $(".noRegister").show();
        $(".overla").show();      
    })
    $('.closeAfterBuy').click(function(){
        $(".noRegister").hide();
        $(".overla").hide();     
    })                                     
</script>



<?  
    /*
    if(isset($arResult["META"]["UF_KEYWORDS"]) && !empty($arResult["META"]["UF_KEYWORDS"])) {
        $APPLICATION->SetPageProperty("keywords",$arResult["META"]["UF_KEYWORDS"]);
    }

    if(isset($arResult["META"]["UF_DESCRIPTION"]) && !empty($arResult["META"]["UF_DESCRIPTION"])) {
        $APPLICATION->SetPageProperty("description",$arResult["META"]["UF_DESCRIPTION"]);
    }

    if(isset($arResult["META"]["UF_TITLE"]) && !empty($arResult["META"]["UF_TITLE"])) {
        $APPLICATION->SetTitle($arResult["META"]["UF_TITLE"]);
    }


    //если есть SEO

    if(isset($arResult["SEO"]["KEYWORDS"]) && !empty($arResult["SEO"]["KEYWORDS"])) {
        $APPLICATION->SetPageProperty("keywords",$arResult["SEO"]["KEYWORDS"]);
    }

    if(isset($arResult["SEO"]["DESCRIPTION"]) && !empty($arResult["SEO"]["DESCRIPTION"])) {
        $APPLICATION->SetPageProperty("description",$arResult["SEO"]["DESCRIPTION"]);
    }

    if(isset($arResult["SEO"]["TITLE"]) && !empty($arResult["SEO"]["TITLE"])) {
        $APPLICATION->SetTitle($arResult["SEO"]["TITLE"]);
    }
    */




    $GLOBALS["ALLELEMENT"] = $arResult["ALLELEMENT"];?>