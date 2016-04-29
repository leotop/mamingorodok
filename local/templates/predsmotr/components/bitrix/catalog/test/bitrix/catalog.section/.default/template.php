<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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



    if(!$isSearch)
    {
        if(preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()) || preg_match("#/catalog/filter/#", $APPLICATION->GetCurDir()))
            $strH1Addon = 'Детские товары ';
        else $strH1Addon = '';
    ?>
    <?
    ?>
    <script type="text/javascript">
        $(function(){
           $(".fast_view").fancybox({
            'type'    :    'iframe',
            'width'   :    1050,
            'height'  :    700,
    }); 
        });
    </script>
    <br> 
    <h1 class="secth"><?=$strH1Addon.$strH1?></h1><?

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

    if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
    {
        echo showNoindex();
    ?>
    
    <div class="sorting_block"><?
            if(!$isSearch)
            {?> 
            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                    "0"=>array("NAME"=>"по цене", "CODE"=> "CATALOG_PRICE_2"),
                    // "1"=>array("NAME"=>"новизна", "CODE" => "PROPERTY_NEW"),
                    // "2"=>array("NAME"=>"наличие", "CODE" => "SORT"),
                    // "3"=>array("NAME"=>"рейтинг", "CODE" => "PROPERTY_RATING"),
                    //  "4"=>array("NAME"=>"популярность", "CODE" => "PROPERTY_SALES_RATING"),
                )));?><?
        }?>
        <?=$arResult["NAV_STRING"]?>
        <?
         ?>
        <div class="clear"></div>
    </div>
    <?=showNoindex(false)?><?
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
                <li id="<?=$strMainID?>">
                    <?
                        //echo "!".$arElement["COUNT_SKLAD"]."@";
                    ?>
                    <div class="catalog_bg stock-item"><?   
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

                            $arFileTmp = CFile::ResizeImageGet(
                                $arElement["DETAIL_PICTURE"]["ID"],
                                array("width" => 160, 'height' => 160),
                                BX_RESIZE_IMAGE_PROPORTIONAL,
                                false
                            );

                            //arshow($arFileTmp);
                        ?>
                        <div class="photo">
                        <?$APPLICATION->IncludeFile("/includes/shields.php",array("props" => $arElement["PROPERTIES"]),array("SHOW_BORDER" => false))?>
                        <p><i title="<?=$arElement['DETAIL_PAGE_URL']?>"><img src="<?=$arFileTmp["src"]?>" alt="<?=(empty($arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?$arElement["NAME"]:$arElement["PROPERTIES"]["SEO_H1"]["~VALUE"])?>"></i><span>&nbsp;</span></p></div>
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
                            echo showNoindex();
                            $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("strAddon" => $strAddon, 'Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html"));
                            echo showNoindex(false); ?>
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
                                
                                 
                                <span class="currency" style="width: auto;"><?=CurrencyFormat($price, "RUB")?></span>
                                <!-- <span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>--><?
                                    if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
                                    {?>
                                    <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
                                    };
                                }?>
                        </div><?
                            if(strlen($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"]) <= 0 || $arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                            {
                            ?><i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">Купить</button></i>
                            
                             
                                  <?
                              ?>
                            
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
                        <div class="clear"></div><?
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
                    <?           
             //-----------------ТЕСТОВЫЙ БЫСТРЫЙ ПРЕДСМОТР-----------------------------------------------------------------------------------------------------------------------------------       
                                    global $USER;
                                  if ($USER->IsAdmin()){ ?>
                                    <a href="<?=$arElement["DETAIL_PAGE_URL"]?>?pred=Y" class="fast_view">Быстрый просмотр</a>  
                                  <?}?>
                    
                </li>
                <?
            }?>
            <div class="clear"></div>
            <?
        }?>
    </ul>
    <div class="clear"></div>
    <div style="margin-top:60px"></div><?
        if($filter == 1 || (!($filter == 1) && $parent_catalog<1))
        {?>
        <div class="sorting_block"><?
                showNoindex();
                if(!$isSearch)
                {?>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                        "0"=>array("NAME"=>"цена", "CODE"=> "CATALOG_PRICE_2"),
                        // "1"=>array("NAME"=>"новизна", "CODE" => "PROPERTY_NEW"),
                        //"2"=>array("NAME"=>"наличие", "CODE" => "SORT"),
                        //"3"=>array("NAME"=>"рейтинг", "CODE" => "PROPERTY_RATING"),
                        //"4"=>array("NAME"=>"популярность", "CODE" => "PROPERTY_SALES_RATING"),
                    )));?><?
            }?>
            <? if(strlen($arResult["NAV_STRING"])>0) echo $arResult["NAV_STRING"].'<br><br><br>'; 
                echo showNoindex(false);?>
            <div class="clear"></div>
        </div><?

            
        }
        
        if ($parent_catalog<1) {
        echo $arResult["SEO_LINKING"];
        
        } ?>
        <p class="about_error">Сообщить об ошибке: выделить текст и нажать Ctrl+Enter</p>
        <?//arshow($arResult["~DESCRIPTION"]);
        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1)
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
    //print_R($arResult);
    // global $APPLICATION;

    //arshow($arResult["META"]);

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





    $GLOBALS["ALLELEMENT"] = $arResult["ALLELEMENT"];?>