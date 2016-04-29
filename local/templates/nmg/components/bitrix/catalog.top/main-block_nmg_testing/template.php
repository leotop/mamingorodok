<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
   // arshow($arParams["TYPE_OF_FILTER"]);
?>
<style>
    .main_product_list{
        padding: 0 0 20px 0 !important;
    }
    .bx-wrapper .bx-viewport{
        box-shadow:none !important;
    }
    .bx-viewport{
        height: 276px!important;
    }
    
</style>
<script src="/js/jquery.bxslider.min.js"></script>      
<link href="/js/jquery.bxslider.css" rel="stylesheet" />
<script>
    $(document).ready(function(){
        $('.bxsliderx').bxSlider({
            minSlides : 3,
            maxSlides : 4,
            slideWidth: 166,
            controls: true,
            pager: false,
            slideMargin:5,              
        });
    });
</script>
<?
    //arshow($arResult["ShowSecName"]);
    if(is_array($arResult["ROWS"]) && count($arResult["ROWS"])>0)
    { ?>
    <div class="main_product_headline">
        <?
            if(false)
            {?>
            <a href="/catalog/title/desired/" title="Показать все">Показать все</a><?
        }?>
        <div class="clear"></div>
    </div>                                                                    
    <script>
        $(function(){
            $('.title_tab').click(function(){
                var dataid,ulname;
                dataid=$(this).data('id');
                ulname = '.tab_ul'+dataid;     
                $('.ul_slider').hide();
                $(ulname).show();
                $(ulname).children("ul").bxSlider({
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
    <div class="but_list">
    <?
        foreach ($arResult['ShowSecName'] as $keyy => $name) ?>    
        <p class="title_tab" data-id='<?=$keyy?>'><?=$name?></p>    
    </div>
        <?
        foreach ($arResult['ShowElements'] as $key => $arSameEle){                
        ?>                                                  
        <div <?if ($flagFirst != 'true') echo ('style = "display:none"')?> class="ul_slider tab_ul<?echo $key?>">                                                          
            <ul  class="main_product_list <?if ($flagFirst =='true') echo ('bxsliderx')?>"><?
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
                    <li<?=(($intCnt+1)%4==0?' class="last"':'')?>><?
                            if(strlen($arFileTmp["src"])>0)
                            {?>
                            <div class="photo">
                                <?$APPLICATION->IncludeFile("/includes/shields_2.php",array("props" => $arElement["PROPERTIES"], "size" => 25, /*"align" => array("left" => "auto","right" => "0px")*/),array("SHOW_BORDER" => false))?>

                                <p><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=$arElement['NAME']?>" /></a><span>&nbsp;</span></p>
                            </div><?
                        }?>
                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?>
                        <div class="link"><a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="<?=$arElement['NAME']?>" ><?=smart_trim($arElement['NAME'], 48)?></a></div>

                        <?    
                            if($price <= 0 or $price == ""){
                                echo '<span class="fat top_price" style="font-size:16px">Нет в наличии</span>';
                            }else 
                            {?>
                            <span class="fat top_price"><?=CurrencyFormat($price, "RUB")?></span><?
                        }?>

                        <?echo showNoindex();?>
                        <div class="comparison">
                            <input type="checkbox" class="input2 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" />
                            <i title="/catalog/compare/">Сравнить</i>
                            <?
                                if(false)
                                {
                                ?><span></span><?
                            }?>
                        </div><?
                            echo showNoindex(false);?>

                        <?if(strlen($arElement["PROPERTY_CH_SNYATO_ENUM_ID"]) <= 0 || $arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100923)
                            {
                            ?><i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Купить</button></i><?
                            } elseif($arElement["PROPERTY_CH_SNYATO_ENUM_ID"] == 2100920) {
                            ?>Новинка! Ожидаем поставку.<?
                        }?>

                    </li><?

                }?>

            </ul>
        </div><?}
    }
?>     
<div class="clear"></div>
<script>
$(document).ready(function(){
    $('.title_tab:first').css({'color':'white','background-color':'#7a4795','border':'1px solid #7a4795'});
});

$('.title_tab').click(function(){
    $('.title_tab').css({'color':'#4f4f4f','background-color':'white','border':'1px solid #cdcdcd'});
    $(this).css({'color':'white','background-color':'#7a4795','border':'1px solid #7a4795'}); 
});
</script>