<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    $filter = substr_count($_SERVER["REQUEST_URI"],"/filter/");

    $parent_catalog = substr_count($_SERVER["REQUEST_URI"],"/catalog/filter/");

    $isSearch = $arParams["SEARCH"] == "Y";

    $strH1 = $arResult["NAME"];
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

    if(!$isSearch)
    {
        if(preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()) || preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()))
            $strH1Addon = 'Детские товары ';
        else $strH1Addon = '';
    ?>
    <?
        global $USER;
        //if ($USER->IsAdmin()) arShow($arParams);
    ?>
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
    <div class="noRegister">
        <p class="title">Для того чтобы добавить товар в список "Избранное" требуется</p>
        <a href="/personal/registaration/" class="registation">регистрация</a>
        <span> или </span>
        <a href="/personal/profile/" class="">авторизация</a> 
        <img src="/bitrix/templates/nmg/img/close_bg.png" class="closeAfterBuy">                                    
    </div>            
    <div class="overla"></div> 
    <?   /*
        <script type="text/javascript">
        var i = 0;
        </script> 
        */
    ?>
    <br> 
    <h1 class="secth"><?=$strH1?></h1>
    <br><?

        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]=='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>        
        <div class="catalogFilter">
            <div class="stext"><?
                if(strlen($arResult["~UF_DESCR_PREVIEW"])>0)
                {
                    echo $arResult["~UF_DESCR_PREVIEW"];
                    if(strlen($arResult["~DESCRIPTION"])>0) echo '<span class="more_text">'.$arResult["~DESCRIPTION"].'</span><span class="showMore"><a href="#">Подробнее</a><br clear="all"><br><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                } else {
                    if($arPreview["PREVIEW"] != strip_tags($arResult["~DESCRIPTION"]))
                    {
                        echo '<span class="less_text">'.$arPreview["PREVIEW"].'</span><span class="more_text">'.$arResult["~DESCRIPTION"].'</span> <span class="showMore"><a href="#">Подробнее</a><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                    } else echo $arPreview["PREVIEW"];
                }
            ?></div>
        </div><?
        }

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
    //arshow($arResult["PRICES_ALLOW"]);
    if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
    {
    ?>
    <?//arshow($_GET);?>
    <div class="sorting_block"><?
            if(!$isSearch)
            {?> 
            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                    "0"=>array("NAME"=>"по скидкам", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),   
                    "1"=>array("NAME"=>"новинкам", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                    "2"=>array("NAME"=>"популярности", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                    "3"=>array("NAME"=>"названию", "CODE" => "NAME", "sort"=>"ASC"),
                    "4"=>array("NAME"=>"цене", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"ASC"),    
                )));?><?
        }?>
        <?=$arResult["NAV_STRING"]?>
        <?
        ?>
        <div class="clear"></div>
    </div>
    <?
    }

?>
<form method="POST" action="<?$APPLICATION->GetCurPage()?>" name="orders_filter" style="margin: 20px 0">
    <div class="access_check fl">  
        <input value="" <?=$_COOKIE["namber_order"];?> name="namber_order"  onclick="filter_click();submit();" type="checkbox" id="cat_for_access" class="fl">
        <label for="cat_for_access">Отображать только имеющиеся в наличии</label>
    </div>
</form>   
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
                        $smallImg = null;
                        $offerPrices = array();
                        $torgPred=0;  

                        //---------------------------------------------------получаем картинки----------------------------------------------------------------------
                        $rsOffers = CCatalogSKU::getOffersList($arElement["ID"],0,array(">CATALOG_QUANTITY"=>0),array('XML_ID','CATALOG_QUANTITY'));   //получаем список торговых предложений              
                        foreach($rsOffers[$arElement["ID"]] as $arTovar){
                            //arshow($arTovar,true);
                            $tmp_path=getResizedIMGPath($arTovar['XML_ID']);
                            //$arResult["PRICES_ALLOW"][0]
                            $priceCheck = CPrice::GetList( array(), array("PRODUCT_ID"=>$arTovar["ID"],">PRICE"=>0,"CATALOG_GROUP_ID"=>$arResult["PRICES_ALLOW"][0]),false,false,array("PRICE"))->Fetch();
                            //if ($priceCheck["PRICE"])
                            if ($tmp_path && $priceCheck["PRICE"]){
                                $smallImg[$arTovar["ID"]] = $tmp_path;
                                $offerPrices[$arTovar["ID"]] = $priceCheck["PRICE"];
                                //echo $smallImg[$arTovar["ID"]]."<br>";    

                            }
                            else {continue;};

                            ++$torgPred;    
                        }            
                        //-----------------------------------------------------------------------------------------------------------------------------------------
                        $width=count($smallImg)*60;
                    ?>

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

                                    // arshow($arElement["PROPERTIES"]["CATALOG_AVAILABLE"]);
                                    if($arElement["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] != "Y"/*$price == 0 || $arElement["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] != "" || $arElement["COUNT_SKLAD"] <=0*/) //проверка цены если больше 0 ....//если количество товаров меньше 2
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
                                ?><?/*<i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Купить</button></i>*/?>
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
                                //echo showNoindex();
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

                            <?/*<p class="addToLikeList"><img src="/bitrix/templates/nmg/img/header/ico-baby-listNotEmpty.png" class="heart_rem"> </p>  */?>
                        </div>



                        <div class="comparison"> 
                            <label class="compare"><input type="checkbox" class="input29 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" /><span class="com_span" data-check=''></span><span class="comparsion_title">Сравнить</span></label>

                        </div> 

                        <?
                            //echo showNoindex(false);?>
                        <div class="clear"></div>

                    </div>

                </li>
                <?
            }?>
            <?
        }?>
    </ul>
    <div class="clear"></div>
    <div style="margin-top:60px"></div><?
        if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
        {?>
        <div class="sorting_block"><?
                if(!$isSearch)
                {?>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                        "0"=>array("NAME"=>"по скидкам", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),   
                        "1"=>array("NAME"=>"новинкам", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                        "2"=>array("NAME"=>"популярности", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                        "3"=>array("NAME"=>"названию", "CODE" => "NAME", "sort"=>"ASC"),
                        "4"=>array("NAME"=>"цене", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"ASC"), 
                    )));?><?
            }?>


            <? if(strlen($arResult["NAV_STRING"])>0) echo $arResult["NAV_STRING"].'<br><br><br>'; ?>
            <div class="clear"></div>
        </div>

        <?/******************************/?>    

        <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section", 
                "rand_section_test", 
                array(
                    "TEMPLATE_THEME" => "blue",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "ADD_PICT_PROP" => "MORE_PHOTO",
                    "LABEL_PROP" => "NEW_BOOK",
                    "OFFER_ADD_PICT_PROP" => "FILE",
                    "OFFER_TREE_PROPS" => array(
                        0 => "-",
                    ),
                    "PRODUCT_SUBSCRIPTION" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_CLOSE_POPUP" => "Y",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "AJAX_MODE" => "Y",
                    "SEF_MODE" => "N",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "IBLOCK_ID" => "2",
                    "SECTION_CODE" => "",
                    "SECTION_USER_FIELDS" => array(
                        0 => "",
                        1 => "",
                    ),
                    "ELEMENT_SORT_FIELD" => "PROPERTY_1498",
                    "ELEMENT_SORT_ORDER" => "desc", 
                    "ELEMENT_SORT_FIELD2" => "RAND",
                    "ELEMENT_SORT_ORDER2" => "RAND",
                    "FILTER_NAME" => "arrFilter",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SECTION_URL" => "",
                    "DETAIL_URL" => "",
                    "BASKET_URL" => "/personal/basket.php",
                    "ACTION_VARIABLE" => "action",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "DISPLAY_COMPARE" => "N",
                    "SET_TITLE" => "Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "BROWSER_TITLE" => "-",
                    "SET_META_KEYWORDS" => "Y",
                    "META_KEYWORDS" => "",
                    "SET_META_DESCRIPTION" => "Y",
                    "META_DESCRIPTION" => "",
                    "SET_LAST_MODIFIED" => "Y",
                    "USE_MAIN_ELEMENT_SECTION" => "Y",
                    "SET_STATUS_404" => "Y",
                    "PAGE_ELEMENT_COUNT" => "4",
                    "LINE_ELEMENT_COUNT" => "4",
                    "PROPERTY_CODE" => array(
                        0 => "CATALOG_AVAILABLE",
                        1 => "PROPERTY_1493",
                        2 => "",
                    ),
                    "OFFERS_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_PROPERTY_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "OFFERS_SORT_FIELD" => "PROPERTY_1498",
                    "OFFERS_SORT_ORDER" => "desc",
                    "OFFERS_SORT_FIELD2" => "rand",
                    "OFFERS_SORT_ORDER2" => "rand",
                    "OFFERS_LIMIT" => "4",
                    "PRICE_CODE" => array(
                        0 => "Розничная",
                    ),
                    "USE_PRICE_COUNT" => "Y",
                    "SHOW_PRICE_COUNT" => "1",
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_PROPERTIES" => array(
                    ),
                    "USE_PRODUCT_QUANTITY" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Товары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_DESC_NUMBERING" => "Y",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "HIDE_NOT_AVAILABLE" => "Y",
                    "OFFERS_CART_PROPERTIES" => array(
                    ),
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CONVERT_CURRENCY" => "Y",
                    "CURRENCY_ID" => "RUB",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "PAGER_BASE_LINK_ENABLE" => "Y",
                    "SHOW_404" => "Y",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "COMPONENT_TEMPLATE" => "rand_section_test",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "FILE_404" => "",
                    "SECTION_ID" => $_REQUEST["SECTION_ID"]
                ),
                false
            );?>

        <?/******************************/?>   

        <?
        }
        if ($parent_catalog<1) {
            echo $arResult["SEO_LINKING"];    
        } 
    ?>

    <p class="about_error">Сообщить об ошибке: выделить текст и нажать Ctrl+Enter</p>
    <?
        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]!='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>        
        <div class="catalogFilter">
            <h2 class="underlined"><?=$strH2?></h2>
            <div class="stext"><?
                if(strlen($arResult["~UF_DESCR_PREVIEW"])>0)
                {
                    echo $arResult["~UF_DESCR_PREVIEW"];
                    if(strlen($arResult["~DESCRIPTION"])>0) echo '<span class="more_text">'.$arResult["~DESCRIPTION"].'</span><span class="showMore"><a href="#">Подробнее</a><br clear="all"><br><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                } else {
                    if($arPreview["PREVIEW"] != strip_tags($arResult["~DESCRIPTION"]))
                    {
                        echo '<span class="less_text">'.$arPreview["PREVIEW"].'</span><span class="more_text">'.$arResult["~DESCRIPTION"].'</span> <span class="showMore"><a href="#">Подробнее</a><a href="#" class="hidden float">Скрыть</a></span><br clear="all"><br>';
                    } else echo $arPreview["PREVIEW"];
                }
            ?></div>
        </div><?
        }

?></div>         

<?
    //arshow($_SESSION["additionalNavChain"],true); 
    //доформировываем дополнительные элементы для хлебных крошек. вывод в section.php
    $text = $arResult["SECTION"]["NAME"];
    if (count($_SESSION["additionalNavChain"]) > 0) {
        foreach ($_SESSION["additionalNavChain"] as $n=>$chainItem) {
            $text .= " ".$chainItem["NAME"];
            $_SESSION["additionalNavChain"][$n]["NAME"] = $text;
        }
    }
?>



    
   

