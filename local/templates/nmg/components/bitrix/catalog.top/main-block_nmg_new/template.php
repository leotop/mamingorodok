<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    // arshow($arParams["TYPE_OF_FILTER"]);
?>      

<?
    //arshow($arResult["ShowSecName"]);
    if(is_array($arResult["ROWS"]) && count($arResult["ROWS"])>0)
    { ?>

    <script>
        $(function(){
            $('.title_tab').click(function(){
                var dataid,ulname;
                dataid=$(this).data('id');
                ulname = '.tab_ul'+dataid;     
                //$('.ul_slider').hide();
                $(this).closest(".but_list").siblings(".ul_slider").hide();
                //$(ulname).show();
                $(this).closest(".but_list").siblings(ulname).show();
                // $(ulname).children("ul").bxSlider({
                $(this).closest(".but_list").siblings(ulname).children("ul").bxSlider({
                    minSlides : 3,
                    maxSlides : 4,
                    slideWidth: 166,
                    controls: true,
                    pager: false,
                    slideMargin:5    
                });    
            }); 
        });
    </script>
    <?  $flagFirst = 'true';?>
    <?//arshow($arResult['ShowSecName'],true)?>
    <div class="but_list">
        <?foreach (array_reverse($arResult['ShowSecName'], true) as $keyy => $name) {?>    
            <p class="title_tab" data-id='<?=$keyy?>'><?=$name?></p>
            <?}?>    
    </div>
    <?
        foreach ($arResult['ShowElements'] as $key => $arSameEle){                
        ?>                                                  
        <div <?if ($flagFirst != 'true') echo ('style = "display:none"')?> class="ul_slider tab_ul<?echo $key?>">                                                          
            <ul  class=" catalog_list <?if ($flagFirst =='true') echo ('bxsliderx')?>"><?
                    $flagFirst = 'false'; 
                    foreach ($arSameEle as $intCnt => $arElement){    
                        $arFileTmp = CFile::ResizeImageGet(
                            $arElement["DETAIL_PICTURE"],
                            array("width" => 160, 'height' => 160),
                            BX_RESIZE_IMAGE_PROPORTIONAL,
                            false
                        );   
                        $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);
                    ?>

                    <li<?=(($intCnt+1)%4==0?' class="last"':'')?> class="li_hover_mod">  

                        <?   
                            // arshow($arElement,true);

                            $smallImg=null;
                            $torgPred=0;              
                            //---------------------------------------------------получаем картинки----------------------------------------------------------------------
                            $rsOffers = CCatalogSKU::getOffersList($arElement["ID"],0,array(),array('XML_ID'));   //получаем список торговых предложений  
                            foreach($rsOffers[$arElement["ID"]] as $arTovar){
                                if ($arTovar['XML_ID']) {
                                    $tmp_path=getResizedIMGPath($arTovar['XML_ID']);
                                    if ($tmp_path){
                                        $smallImg[$arTovar["ID"]] = $tmp_path;   
                                        ++$torgPred;    
                                    }
                                    else {continue;};  
                                }   
                            }   
                            //   echo $torgPred."!!!!!!!!";     
                            //-----------------------------------------------------------------------------------------------------------------------------------------
                            $width=count($smallImg)*60;
                        ?>   

                        <div class="catalog_bg stock-item card">  

                            <div class="carusel_body">   
                                <?if($torgPred>4){?><div class="down" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}
                                    else{?><div style="height: 26px;"></div><?}?>
                                <div class="tovar_card">
                                    <div class="<?echo('carusel_'.$arElement["ID"])?> itemPreviewCarousel">
                                        <?foreach($smallImg as $pict){?>
                                            <div class="slider_element"><img src="<?=(empty($pict)?'/img/no_photo_52x52.png':$pict)?>" titile="" alt="<?=$strH1orName?>"> </div>                                                                                                                     
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
                                        array("width" => 144, 'height' => 144),
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
                                <?$APPLICATION->IncludeFile("/includes/shields_2.php",array("props" => $arElement["PROPERTIES"]),array("SHOW_BORDER" => false))?>
                                <p><i title="<?=$arElement['DETAIL_PAGE_URL']?>"><img width="<?=$arFileTmp["width"]?>" height="<?=$arFileTmp["height"]?>" src="<?=$arFileTmp["src"]?>" alt="<?=(empty($arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?$arElement["NAME"]:$arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?>"></i><span>&nbsp;</span></p>
                            </div>

                            <?
                                $strAddon = "";
                                if(!$isSearch) {
                                    //   $strAddon = '#REPORT_COUNT_'.$arElement["ID"].'#';
                                    $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">Написать отзыв</a>';
                                } 
                                else  {
                                    $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">Написать отзыв</a>';
                                }
                                if(strlen($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"])>0) {
                                    $strAddon .= '<a class="ttp_lnk 3dlink" onclick="window.open(\'/view360.php?idt='.$arElement["ID"].'\', \'wind1\',\'width=900, height=600, resizable=no, scrollbars=yes, menubar=no\')" href="javascript:" title="Подробная 3D - Модель"><i class="img360">3D модель</i></a>';
                                }
                                //echo showNoindex();
                                $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
                                //echo showNoindex(false); ?>
                            <?//arshow($arElement, true);?>
                            <div class="info_block">
                                <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement["NAME"]?>"><?=smart_trim($arElement['NAME'], 70)?></a></div>
                                <div class="price">
                                    <?
                                        $arElement["PROPERTIES"]["PRICE_CODE"]["VALUE"] = substr($price, 0, strlen($price)-3);
                                        //  if($USER->IsAdmin()){arshow($arElement["PROPERTIES"]);};
                                        $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);

                                        // arshow($arElement["PROPERTIES"]["CH_SNYATO"]);
                                        /*  if($price == 0 || $arElement["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] !="" || $arElement["COUNT_SKLAD"] <=0) //проверка цены если больше 0 ....//если количество товаров меньше 2
                                        echo '<span class="currency" style="width: 100%;font-size:12px">Нет в наличии</span>';
                                        else 
                                        {?>    
                                        <span class="currency" style="width: auto;"><?=CurrencyFormat($price, "RUB")?></span>
                                        <!-- <span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>--><?
                                        if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
                                        {?>
                                        <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
                                        };
                                        }*/
                                        /*  if ($arElement['CATALOG_QUANTITY']==0)
                                        {
                                        echo '<span class="currency" style="width: 100%;font-size:12px;">Нет в наличии</span>';   
                                        }
                                        else
                                        { */
                                        if (intval($arElement['CATALOG_PRICE_3'])>0)
                                        {?>
                                        <span class="currency" style="width: auto;"><?=ceil($arElement['CATALOG_PRICE_3']).' '?> </span>
                                        <span class="rouble">a</span>    
                                        <?
                                        }else
                                        {
                                            echo '<span class="currency" style="width: 100%;font-size:12px;">Нет в наличии</span>';   
                                    }?>

                                    <?//}?>
                                </div><?//arshow($arElement, true);
                                    if(strlen($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"]) <= 0 || $arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                    {
                                    ?><!--<i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Купить</button></i>-->
                                    <a href="<?=$arElement["DETAIL_PAGE_URL"]?>?pred=Y" class="fast_view">Быстрый просмотр</a>   
                                    <?
                                    } elseif($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
                                    ?>Новинка! Ожидаем поставку.
                                    <?} ?>
                            </div>


                            <??>
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
                            <??>
                            <div class="clear"></div>   
                        </div>
                    </li><?

                }?>

            </ul>
        </div><?}
    }
?>     
<div class="clear"></div>
<!-- <a href="/catalog/show-special/?prop=NOVINKA" class="all_new_items">Все новинки</a> -->
<script>
    $(document).ready(function(){
        // $('.title_tab:first').css({'color':'white','background-color':'#7a4795','border':'1px solid #7a4795'});
        $('.but_list').find('.title_tab:last').css({'color':'white','background-color':'#c2bdbd','border':'1px solid #c2bdbd'});
    });

    $('.title_tab').click(function(){
        //$('.title_tab').css({'color':'#4f4f4f','background-color':'white','border':'1px solid #cdcdcd'});
        $(this).closest(".but_list").find('.title_tab').css({'color':'#4f4f4f','background-color':'white','border':'1px solid #cdcdcd'});
        // $(this).css({'color':'white','background-color':'#7a4795','border':'1px solid #7a4795'});
        $(this).css({'color':'white','background-color':'#c2bdbd','border':'1px solid #c2bdbd'}); 
    });
</script>


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
    });
    $(document).ready(function(){
        $(".catalog_list").each(function(){
            if ($(this).children().length==2)
            {
                $(this).css("margin-left", "28%");
            }
            else if ($(this).children().length==3)
            {
                $(this).css("margin-left", "18%");    
            }
            else if ($(this).children().length==1)
            {
                $(this).css("margin-left", "38%");    
            }  
        });
    });
    $(".catalog_list li").hover(function(){
        // alert($(this).closest(".catalog_list").children().length);
    });

    /*$(".catalog_list li").hover(function(){
    if (($(this).closest(".bx-wrapper").find(".bx-prev").hasClass("disabled") && !$(this).hasClass('bx-clone') && $(this).hasClass('last')) || (($(this).closest(".bx-wrapper").find(".bx-prev").hasClass("disabled") && !$(this).hasClass('bx-clone') && $(this).next().hasClass('bx-clone')))) {
    $(this).closest(".bx-viewport").css("padding-right", "14px");
    }
    },
    function(){
    $(this).closest(".bx-viewport").css("padding-right", "0px"); 
    }); */ 

    </script>