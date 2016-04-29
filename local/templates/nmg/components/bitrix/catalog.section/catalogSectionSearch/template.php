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

        //$strH1 = "������� ".ToLower($strCategoryName).' '.$strProducer;
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
            $strH1Addon = '������� ������ ';
        else $strH1Addon = '';
    ?>
    <?
        global $USER;
        //if ($USER->IsAdmin()) arShow($arParams);
    ?>
    <div class="compare_comment" style="display: none;">
        <div class="compare_com">
            <p style="margin-top: 13px;">����� �������� � ���������</p>
        </div>
    </div>
    <div class="like_comment" style="display: none;">
        <div class="like_com">
            <p style="margin-top: 13px;">��� ���������� �����</p>
        </div>
    </div>
    <div class="noRegister">
        <p class="title">��� ���� ����� �������� ����� � ������ "���������" ���������</p>
        <a href="/personal/registaration/" class="registation">�����������</a>
        <span> ��� </span>
        <a href="/personal/profile/" class="">�����������</a> 
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
    <?$h1 = "���������� ������";?>
    <?switch($_REQUEST["prop"]) {
        case "NOVINKA": $h1 = "�������"; break;
        case "KHIT_PRODAZH": $h1 = "���� ������"; break;
        case "DISCOUNT": $h1 = "����������"; break;          
    }?>
    <br>
    <h1 class="secth"><?=$h1?></h1>
    <br><?

        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]=='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>        
       <?
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
    } else echo '<h1>���������� ������</h1>';

    if($_REQUEST["set_filter"]=="Y" && (count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
    { ?>
    <div class="search-page">
        <div class="top15"></div>
        <div>�������� ������ ��� ���������� �������� � <a href="/catalog/">��������</a>.</div>
    </div><?
        return false;
    } elseif($isSearch) {
        if((count($arResult["ROWS"])<=0) || !is_array($arResult["ROWS"]))
        {
        ?>
        <div class="search_block"><div class="inputs">
                <form action="/tools/search/">
                    <input type="text" value="<?=(strlen($_REQUEST["q"])>0?htmlspecialcharsEx($_REQUEST["q"]):'����� �� �������')?>" name="q" class="input1 searchInputField noGray black">
                    <button value="" class="input2" type="submit" name="s" id=""><span class="png"><span class="png"><nobr></nobr></span></span></button>
                </form>
            </div><br clear="all"><br>�� ������ ������� ������ �� �������. ���������� �������� ������ ��� ������ ����� � ��������.</div><?
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
    ?>
    <?//arshow($_GET);?>
    <div class="sorting_block"><?
            if(!$isSearch)
            {?> 
            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose_nmg.php',array("arChoose"=>array(
                    "0"=>array("NAME"=>"�� �������", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),   
                    "1"=>array("NAME"=>"��������", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                    "2"=>array("NAME"=>"������������", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                    "3"=>array("NAME"=>"��������", "CODE" => "NAME", "sort"=>"ASC"),
                    "4"=>array("NAME"=>"����", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"ASC"),    
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
        <label for="cat_for_access">���������� ������ ��������� � �������</label>
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
                
                <?//arshow($arResult)?>
                <li id="<?=$strMainID?>" class="li_hover_mod">
                    <?   
                        $smallImg = null;
                        $offerPrices = array();
                        $torgPred=0;  

                        //---------------------------------------------------�������� ��������----------------------------------------------------------------------
                        $rsOffers = CCatalogSKU::getOffersList($arElement["ID"],0,array(">=CATALOG_QUANTITY"=>3),array('XML_ID','CATALOG_QUANTITY'));   //�������� ������ �������� �����������              
                        foreach($rsOffers[$arElement["ID"]] as $arTovar){
                            
                            $tmp_path=getResizedIMGPath($arTovar['XML_ID']);
                           // arshow($tmp_path,true);
                            /*$tmp_path = CFile::ResizeImageGet(
                                $arTovar["XML_ID"],
                                array("width" => 250, "height" => 127),
                                BX_RESIZE_IMAGE_EXACT
                            );  */
                            //arshow($tmp_path);
                            //$arResult["PRICES_ALLOW"][0]
                            //$priceCheck = CPrice::GetList( array(), array("PRODUCT_ID"=>$arTovar["ID"],">PRICE"=>0,"CATALOG_GROUP_ID"=>$arResult["PRICES_ALLOW"][0]),false,false,array("PRICE"))->Fetch();
                          //  arshow($tmp_path);
                            //if ($priceCheck["PRICE"])
                            if ($tmp_path){
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
                                        <?//arshow($smallImg,true)?>
                                        <div class="slider_element"><img src="<?=(empty($pict)?'/img/no_photo_52x52.png':$pict)?>" titile="" alt="<?=$strH1orName?>" data-price="<?=number_format($offerPrices[$oID], 0, ',', ' ');?>"> </div>                                                                                                                     
                                        <?}?> 
                                </div>             
                            </div>
                            <?if($torgPred>4){?><div class="up" data-id="<?echo($arElement["ID"])?>" data-width="<?echo $width?>"></div><?}?>
                        </div>      
                        <?        
                         
                            if($arElement["ACTIVE"] == "N")
                                echo '<div class="element_inactive">�������������</div>';
                            if(isset($arResult["ACTIONS_ITEMS"][$arElement["ID"]]))
                            {
                                $arAction = $arResult["ACTIONS"][$arResult["ACTIONS_ITEMS"][$arElement["ID"]]];
                                $isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;

                                if($isSpecOffer)
                                {?>
                                <div class="wrap-specialoffert">
                                    <a href="<?=$arElement['DETAIL_PAGE_URL']?>" title="���������������!" class="btt-specialoffert">���������������!</a></div><?
                            }?>
                            <div class="prize"><?
                                    if(!$isSpecOffer)
                                    {?>
                                    <a href="#" target="_blank"><div class="gift_bg"></div></a><?
                                }?>
                                <div class="gift_info ">
                                    <div class="gift_info_text">
                                        <div style="text-align: center;">�����!</div> <?=$arAction["PREVIEW_TEXT"]?>                                         
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
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">�������� �����</a>';
                            } 
                            else  {
                                $strAddon = '<a class="comment grey" href="'.$arElement['DETAIL_PAGE_URL'].'#comment">�������� �����</a>';
                            }
                            if(strlen($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"])>0) {
                                $strAddon .= '<a class="ttp_lnk 3dlink" onclick="window.open(\'/view360.php?idt='.$arElement["ID"].'\', \'wind1\',\'width=900, height=600, resizable=no, scrollbars=yes, menubar=no\')" href="javascript:" title="��������� 3D - ������"><i class="img360">3D ������</i></a>';
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
                                
                                    $price = GetOfferMinPrice($arParams["IBLOCK_ID"],$arElement["ID"]);

                                   //  arshow($arElement["PROPERTIES"]["CATALOG_AVAILABLE"], false);
                                    if($arElement["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"] != "Y"/*$price == 0 || $arElement["PROPERTIES"]["STATUS_TOVARA"]["VALUE"] !="" || $arElement["COUNT_SKLAD"] <=0 || $arElement["PROPERTIES"]["CATALOG_AVAILABLE"]["VALUE"]!='Y'*/) //�������� ���� ���� ������ 0 ....//���� ���������� ������� ������ 2
                                        echo '<span class="currency" style="width: 100%;font-size:12px">��� � �������</span>';
                                    else 
                                    {?>


                                    <span class="currency" style="width: auto;" rel="<?=CurrencyFormat($price, "RUB")?>"><?=number_format($price, 0, ' ', ' ' );?><div class="rub_none">���.</div><span class="rouble"> a</span> </span>
                                    <!-- <span class="currency" style="width: auto;"><?=CurrencyFormat($arElement["PROPERTIES"]["PRICE"]["VALUE"], "RUB")?></span>--><?
                                        if($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]>0)
                                        {?>
                                        <i><?=CurrencyFormat($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], "RUB")?></i><?
                                        };
                                    }?>
                            </div><?
                                if(strlen($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"]) <= 0 || $arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100923)
                                {
                                ?><!--<i class="addToCartList" title="<?=$arElement["DETAIL_PAGE_URL"]?>"><button type="button" class="input21">������</button></i>-->
                                <a href="<?=$arElement["DETAIL_PAGE_URL"]?>?pred=Y" class="fast_view">������� ��������</a>   
                                <?
                                } elseif($arElement["PROPERTIES"]["CH_SNYATO"]["VALUE_ENUM_ID"] == 2100920) {
                                ?>�������! ������� ��������.<?
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
                                        echo ('<a class="deleteFromWishListaa" data-id="'.$arI["ID"].'" data-remId="'.$arElement["ID"].'"  title="� ���������"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_t.png" width="20" height="17" alt="" /><p class="remembering">���������</p></a>');

                                    }                 
                                    else{
                                        echo ('<a class="add addToLikeListaa" data-remId="'.$arElement["ID"].'"  title="� ���������"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">���������</p></a> ');   

                                    }    
                                }
                                else{
                                    echo ('<a class="showpUpss" class="userNoAuthaa" data-id="'.$arElement["ID"].'" href="#messageNoUser1" title="� ���������"><img class="heart_like" src="/bitrix/templates/nmg/img/heart_f.png" width="20" height="17" alt="" /><p class="remembering">���������</p></a>');
                            }?>

                            <!-- <p class="addToLikeList"><img src="/bitrix/templates/nmg/img/header/ico-baby-listNotEmpty.png" class="heart_rem"> </p>     -->
                        </div>



                        <div class="comparison"> 
                            <label class="compare"><input type="checkbox" class="input29 add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" /><span class="com_span" data-check=''></span><span class="comparsion_title">��������</span></label>

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
                        "0"=>array("NAME"=>"�� �������", "CODE" => "PROPERTY_DISCOUNT", "sort"=>"DESC"),   
                        "1"=>array("NAME"=>"��������", "CODE" => "PROPERTY_NOVINKA", "sort"=>"DESC"),
                        "2"=>array("NAME"=>"������������", "CODE" => "PROPERTY_KHIT_PRODAZH", "sort"=>"DESC"),
                        "3"=>array("NAME"=>"��������", "CODE" => "NAME", "sort"=>"ASC"),
                        "4"=>array("NAME"=>"����", "CODE"=> "CATALOG_PRICE_".$arResult["PRICES_ALLOW"][0], "sort"=>"ASC"), 
                    )));?><?
            }?>
            <? if(strlen($arResult["NAV_STRING"])>0) echo $arResult["NAV_STRING"].'<br><br><br>'; ?>
            <div class="clear"></div>
        </div><?
        }
        if ($parent_catalog<1) {
            echo $arResult["SEO_LINKING"];

    } ?>
    <p class="about_error">�������� �� ������: �������� ����� � ������ Ctrl+Enter</p>
    <?//arshow($arResult["~DESCRIPTION"]);
        if(strlen($arResult["DESCRIPTION"])>0 && $_REQUEST["PAGEN_1"]<=1 && $arResult["IBLOCK_SECTION_ID"]!='688')
        {
            $arPreview = smart_trim(strip_tags($arResult["~DESCRIPTION"]), 460, false, '<span class="full_hide">...</span>', true);
        ?>        
        <?
        }

?></div>

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
    </script>
   


  