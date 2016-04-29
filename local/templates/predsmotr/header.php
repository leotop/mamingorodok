<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

    CModule::IncludeModule("iblock");

    $user_id = $USER->GetID();
    $obCache = new CPHPCache;
    $CACHE_ID = 'user_blog_'.$user_id;
    $CACHE_TIME = 360;
    $CACHE_DIR = 'user_blog';

    if($obCache->StartDataCache($CACHE_TIME, $CACHE_ID, $CACHE_DIR))
    {
        if (CModule::IncludeModule("blog"))
        {
            $arBlog = CBlog::GetByOwnerID($user_id); 
            if(is_array($arBlog)) 

                $user_blog = $arBlog["URL"];
        }

        $obCache->EndDataCache($user_blog);
    } else $user_blog = $obCache->GetVars();

    global $user_blog;

    if(strpos($_SERVER["REQUEST_URI"], "community") !== false) $IS_COMUNITY = true;

    if($USER -> IsAdmin() || true)
    { ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"><?
    } else {
    ?>
    <!DOCTYPE html>
    <html><?	
    }
?>
<head>
    <title><?$APPLICATION->ShowTitle(false)?></title>
    <?

        //Modified by Optimism.ru
        if (!isset($_GET['PAGEN_1'])) {
            $APPLICATION->ShowMeta("keywords");
            $APPLICATION->ShowMeta("description");
        }

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.8.11.custom.min.js');
    ?>


    <!-- <script src="/bitrix/templates/nmg/js/jquery-1.6.1.js" type="text/javascript"></script> -->
    <!--    <script src="/bitrix/templates/nmg/js/jquery-1.8.2.min.js" type="text/javascript"></script>-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mousewheel-3.0.4.pack.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/recommended.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/lib/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.maskedinput.min.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script_cache.js?2"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script2.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/consultant.js"></script>
    <script src="/bitrix/templates/nmg/js/scripts.js" type="text/javascript"></script>
    <?$APPLICATION->ShowCSS();?>

    <?$APPLICATION->ShowHeadStrings();?>
    <?$APPLICATION->ShowHeadScripts();?>
    <?

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.jqtransform.js');
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.cookie.js');
        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/cloud-zoom.1.0.2.js');


        /*if($USER -> IsAdmin())
        { ?>
        <script type="text/javascript"> $(document).ready(function() { var isAdmin = true; }); var isAdmin = true;</script>
        <link href="/bitrix/templates/nmg/template_styles_new.css?1360397630" type="text/css" rel="stylesheet" /><?
        if($USER->IsAdmin())
        {?>
        <link href="/bitrix/templates/nmg/components/individ/catalog.element/newCard/style_card.css?1336556583" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/accessory/skin.css" />
        <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/tumb/skin.css" />
        <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/color_chose/skin.css" />
        <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/color_chose_one/skin.css" /><?
        }
        } else { ?>
        <link href="/bitrix/templates/nmg/template_styles_old.css?1360397630" type="text/css" rel="stylesheet" /><?
    }*/?>
    <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/accessory/skin.css" />
    <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/tumb/skin.css" />
    <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/color_chose/skin.css" />
    <link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/skins/color_chose_one/skin.css" />
    <link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/slider/jquery-ui-1.8.11.custom.css"/>

    <link href="/bitrix/templates/nmg/components/individ/catalog.element/newCard/style_card.css?1336556583" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/cloud-zoom.css" />



    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqtransform.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/style_blog.css" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqzoom.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jquery.jqzoom.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/chrome.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/skins/tango/skin.css" />

    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?32"></script>
    <script type="text/javascript">
        VK.init({apiId: 2400096, onlyWidgets: true});
    </script>  
                         
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount','UA-24296852-2']);
        _gaq.push(['_addOrganic','images.yandex.ru','text',true]);
        _gaq.push(['_addOrganic','blogsearch.google.ru', 'q', true]);
        _gaq.push(['_addOrganic','blogs.yandex.ru', 'text', true]);
        _gaq.push(['_addOrganic','go.mail.ru', 'q']);
        _gaq.push(['_addOrganic','nova.rambler.ru', 'query']);
        _gaq.push(['_addOrganic','nigma.ru', 's']); 
        _gaq.push(['_addOrganic','webalta.ru', 'q']);
        _gaq.push(['_addOrganic','aport.ru', 'r']);
        _gaq.push(['_addOrganic','poisk.ru', 'text']);
        _gaq.push(['_addOrganic','km.ru', 'sq']);
        _gaq.push(['_addOrganic','liveinternet.ru', 'q']);
        _gaq.push(['_addOrganic','quintura.ru', 'request']);
        _gaq.push(['_addOrganic','search.qip.ru', 'query']);
        _gaq.push(['_addOrganic','gde.ru', 'keywords']);
        _gaq.push(['_addOrganic','ru.yahoo.com', 'p']); 
        _gaq.push(['_trackPageview']);
        setTimeout('_gaq.push([\'_trackEvent\', \'NoBounce\', \'Over 10 seconds\'])',10000);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>

    <!--[if lt IE 7]>
    <script src="/bitrix/templates/nmg/js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">DD_belatedPNG.fix('img, div, input, span, td, a, ul, li, h3, h2, p');</script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/PIE.js"></script>
    <![endif]-->
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    var yaParams = {/*Здесь параметры визита*/};
</script>  

<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter8129698 = new Ya.Metrika({id:8129698, enableAll: true, webvisor:true,params:window.yaParams||{ }});
            } catch(e) {}
        });

        var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/8129698" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --> 
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<?
    if(true)
    {
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            (function() {
                if ($('.sk-action').size()) {
                    setInterval(function() {
                        if($('.sk-action--delivery').is(':visible')) {
                            $('.sk-action--delivery').fadeOut();
                            $('.sk-action--credit').fadeIn();
                        } else {
                            $('.sk-action--credit').fadeOut();
                            $('.sk-action--delivery').fadeIn();
                        }
                        }, 3000)		
                }
            })();
            (function() {

                $('.sk-sticky-bar--minimiz a').bind('click', function() {
                    if ($('.sk-sticky-bar').hasClass('sk-sticky-bar_min')) {
                        $('.sk-sticky-bar').removeClass('sk-sticky-bar_min');
                        $(this).parent().removeClass('sk-sticky-bar--minimiz_off');		
                    } else {
                        $('.sk-sticky-bar').addClass('sk-sticky-bar_min');		
                        $(this).parent().addClass('sk-sticky-bar--minimiz_off');	
                    }

                    return false;
                })

            })();
            (function() {
                $('[data-placeholder]').focus(function() {
                    if ($(this).val() == $(this).data('placeholder')) {
                        $(this).val('');
                    }
                }).blur(function() {
                    if ($(this).val() == "") {
                        $(this).val($(this).data('placeholder'));
                    }
                })
            })()
        });
    </script>
    <?
        $intCartCnt = 0;
        if(CModule::IncludeModule("sale"))
        {
            $dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array());
            while ($arItems = $dbBasketItems->Fetch())
                $intCartCnt += $arItems["QUANTITY"];
        }

        /*if($USER->GetID() != 495)
        {
        ?>
        <div class="sk-sticky-bar">

        <div class="sk-sticky-bar--cont">
        <div class="sk-sticky-bar--minimiz"><a href="#"  title="Свернуть"><span class="sk-dotted_grey">Свернуть</span></a></div>
        <?=showNoindex()?>
        <?$APPLICATION->IncludeComponent("bitrix:search.form", "search_header", Array(
        "PAGE" => "#SITE_DIR#tools/search/",
        ),
        false
        );?>
        <?=showNoindex(false)?>
        <ul class="sk-mybar">
        <li><i title="<?=($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')?>" class="sk-mybar--babylist">Список малыша</i></li>
        <li><i title="/basket/" class="sk-mybar--cart">Моя корзина <span class="js-cartCnt">(<?=$intCartCnt?>)</span></i></li>
        </ul>
        </div>
        </div><?
    } */?>

    <!-- new header -->
    <? if(true) { // if($USER -> IsAdmin() || in_array(10, $USER->GetUserGroupArray()))?>

        <?
            if($GLOBALS["skGeoInit"] == "Y") { ?>
            <div class="sk-city-select" id="skLocationConfirm">
                <div class="sk-city-select-body">
                    Ваш город — <strong><?=$GLOBALS["CGeoIP"] -> getLocationName()?></strong><br>
                    Верно?
                </div>
                <div class="sk-city-select-btn">
                    <a href="#" onclick="$('#skLocationConfirm').hide(); return false;">Да</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="sk-popup-open" onclick="$('#skLocationConfirm').hide();" data-popup-name="city-sel" href="#">Выбрать другой</a>
                </div>	
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    if($("#skLocationConfirm").size() > 0) {
                        centerObject("#skLocationConfirm");
                    }
                });
            </script><?
        } ?>
        <div class="popup_block" id="city-sel" data-popup-head="Укажите ваш город" style="display: none;"></div>
        
        <!-- new header -->
        <? } else {?>
        <!-- Old header -->

       

        <?}?>
    <!-- Old header --><?
}?>
<div class="main">
<?
    echo showNoindex();
?>   <?
    echo showNoindex(false);


    if($USER -> GetID() != 495 && false)
    {?>



    <?=showNoindex()?>
   
    <?=showNoindex(false)?>
    <?
    }
    if(false)
    {?>
    <div class="search_block" <?if($USER -> IsAdmin()) {?> style="display: none;"<?}?> >
        <?=showNoindex()?>
        <?$APPLICATION->IncludeComponent("bitrix:search.form", "search", Array(
                "PAGE" => "#SITE_DIR#tools/search/",
                ),
                false
            );?>
        <?=showNoindex(false)?>
        <p><?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/includes/hbanner1.php",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?></p>
        <p class="p2"><?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/includes/hbanner2.php",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?></p>
        <div class="clear"></div>
    </div><?
}?>

<div class="nodisplay" id="haveSravn"><?if($showSravn):?>1<?else:?>0<?endif;?></div><?
    if(!$NO_BROAD)
    {
        if($showSravn)
        {?>                                                                                                
        <div class="rel" style="width:100%; height:1px; z-index:100;">
            <div class="sravn" id="sravn">
                <?if(count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])>2):?>
                    <div class="add-to-compare-list">
                        <a href="/catalog/compare/">сравнение товаров:</a> 
                        <span><?=count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])?></span> 
                        <a id="clearCompear" href="#">очистить</a>
                    </div>
                    <?endif;?>
            </div>
        </div><?
        }
    }


?>

<table class="contant_table" cellpadding="0" cellspacing="0">

<tr><?
    if(preg_match("/\/catalog\/.+\/.+\//i", $APPLICATION->GetCurDir())) $HIDE_LEFT_COLUMN = true;

    if((!$HIDE_LEFT_COLUMN || ($HIDE_LEFT_COLUMN && $ignoreHideLeftColumn)) || ERROR_404 == "Y" )
    {?>                      
    <td class="left_sitebar">                  
        <div class="left_column<?=($IS_MAIN?'':'1')?>"><?
               

                


                if($IS_MAIN || strpos($APPLICATION -> GetCurDir(), "/tools/search/") === 0 || preg_match("/\/community\/user\/\d+\//", $APPLICATION -> GetCurDir()))
                {

                ?><?
                }
       
                if(strpos($_SERVER["REQUEST_URI"], "catalog") !== false && ERROR_404 != "Y")
                {
                    $catal = true;
                    CModule::IncludeModule('iblock');
                    $arURL = explode('/', $_SERVER["REQUEST_URI"]);

                    $rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arURL[2], "ACTIVE"=>"Y"), false);
                    if($arS = $rsS -> GetNext())
                        $current_section_id = $arS["ID"]; 
                    else $current_section_id = -1;  

                    if (count($arURL) > 1 /*&& count($arURL) < 5*/) $SHOW_FILTER = true;

                    if(!$arURL[1] > 0)  $SHOW_SECTIONS_MENU = true;

                    if($arURL > 0 && $current_section_id>0)
                    {
                        $res = CIBlockSection::GetList(array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "SECTION_ID" => $current_section_id), false, array());
                        if($arSect = $res->GetNext())
                            $IS_PARENT_SECTION = true;
                    }

                    if(count($arURL) > 4)
                    {
                        $IS_DETAIL = true;             
                        $IS_PARENT_SECTION = false;
                    }

                    if($FILTER_TITLE)
                    {
                        $IS_DETAIL = false;
                        $IS_PARENT_SECTION = false;
                    }
                }

                if($SHOW_SECTIONS_MENU && false)
                {
                ?><?
                }


                if($IS_PARENT_SECTION)
                {
                    if(true) {
                        echo '<div id="catalogFilter" data-template="left-filter-layer1" data-section="'.intval($current_section_id).'" data-query="ajax=Y'.(empty($_SERVER["QUERY_STRING"])?'':'&'.$_SERVER["QUERY_STRING"]).'"></div>';
                        // call without template show

                        $APPLICATION->ShowViewContent("right_area");


                    } else {
                    ?><?

                        $APPLICATION->ShowViewContent("right_area");

                    ?><?
                    }
                } else {
                    if ($SHOW_FILTER)
                    {
                        if(true) {  

                            echo '<div id="catalogFilter" data-template="left-filter" data-section="'.
                            intval($current_section_id).'" data-query="ajax=Y'.
                            (empty($_SERVER["QUERY_STRING"])?'':'&'.$_SERVER["QUERY_STRING"]).'"></div>';


                            $APPLICATION->ShowViewContent("right_area");


                        } else {
                        ?><?
                            $APPLICATION->ShowViewContent("right_area");
                        ?>
                        <?
                        }
                    }
                }

                if($IS_REVIEWS)
                {
                ?>
                <? $APPLICATION->ShowViewContent("right_area");?>
                <?
                }

                if($SUBSCRIBE)
                {
                ?>
                <? $APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_sections", array("COUNT"=>2, "SECTION_ID"=> $current_section_id,"ELEMENT_ID"=>"")); ?>
                <? $APPLICATION->IncludeFile('/inc/cat_vo.php'); ?>
                <?  $APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $current_section_id)); ?><?
                }

                if($FILTER_TITLE)
                {
                ?><?
                    $APPLICATION->ShowViewContent("right_area");
                ?><?
            }?>
        </div><?
            if(ERROR_404 != "Y")
                $APPLICATION->ShowProperty("leftColSocial"); // generates in footer

        ?>

        <? $result = mysql_query(" SELECT acceptor, anchor FROM `relinking` WHERE donor = '".$_SERVER['REQUEST_URI']."'");?>
        <? while ($r = mysql_fetch_array($result)) :
            $string .= '<li><a href="'.$r['acceptor'].'">'.$r['anchor'].'</a></li>';
            endwhile; ?>
        <? if ($string) :?>
            Смотрите также:
            <ul>
                <?=$string ?>
            </ul>
            <? endif; ?>

    </td>
    <td>&nbsp;</td><?
}?>
<td class="right_sitebar"><?
    

    $APPLICATION->ShowProperty('h1Html');




    if(false)
    {
    ?>   
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
        <meta name="robots" content="all" />
        <?
            global $USER;
            $user_id = $USER->GetID();
            $obCache = new CPHPCache;
            $CACHE_ID = 'user_blog_'.$user_id;
            $CACHE_TIME = 360;
            $CACHE_DIR = 'user_blog';

            if($obCache->StartDataCache($CACHE_TIME, $CACHE_ID, $CACHE_DIR))
            {
                if (!CModule::IncludeModule("blog"))return false;
                $arBlog = CBlog::GetByOwnerID($user_id); 
                //print_R($arBlog);
                if(is_array($arBlog)) 

                    $user_blog = $arBlog["URL"];

                $obCache->EndDataCache($user_blog);
            }
            else
            {
                $user_blog = $obCache->GetVars();
            }
            global $user_blog;
        ?>
        <title><?$APPLICATION->ShowTitle(false)?></title>
        <?$APPLICATION->ShowMeta("keywords")?>
        <?$APPLICATION->ShowMeta("description")?>
        <?
            //$description = $APPLICATION->GetMeta("description");
            //$description = $APPLICATION->GetPageProperty("description");
        ?>
        <?
            // if (strlen($description)>0){
            // echo $description;
            // echo '<!--<meta property="og:description" content="'.$description.'"/> -->';
            // }else{
            // echo '<meta name="description" value="Магазин детских игрушек, товаров для мам и пап." />';
            // echo '<!--<meta property="og:description" content="Магазин детских игрушек, товаров для мам и пап."/> -->';
            // }?>

        <?$APPLICATION->ShowCSS();?>
        <?$APPLICATION->ShowHeadStrings();?>
        <?$APPLICATION->ShowHeadScripts();?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.min.js');?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.jqtransform.js');?>

        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.cookie.js');?>
        <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/cloud-zoom.1.0.2.js');?>



        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/cloud-zoom.css" />


        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing-1.3.pack.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/recommended.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jcarousellite_1.0.1.js"></script>

        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script_cache.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script2.js"></script>
        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/consultant.js"></script>

        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.css" />
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqtransform.css" />
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/style_blog.css" />

        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqzoom.css" />
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jquery.jqzoom.css" />
        <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/chrome.css" />

        <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?32"></script>
        <script type="text/javascript">
            VK.init({apiId: 2400096, onlyWidgets: true});
        </script>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-24296852-2']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>

    <body>
    <?
        /*if($USER->IsAdmin()):*/
        $APPLICATION->ShowPanel();
        /*endif;*/?>

    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/tipitop.php");?>
    <div class="container">
    <div class="base">
    <div class="header">
        <?if($IS_MAIN):?>
            <div class="logo"></div>
            <?else:?>
            <a class="logo" href="/"></a>
            <?endif?>
        <?if($IS_BASKET):?>
           
            <?else:?>
            
            <?endif;?>
        

        <?if(!$IS_BASKET):?>
            <div class="header_right">
                <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", array(
                        "REGISTER_URL" => "/personal/registaration/",
                        //"FORGOT_PASSWORD_URL" => "/personal/profile/forgot-password/",
                        "PROFILE_URL" => "/personal/profile/auth/",
                        "SHOW_ERRORS" => "N"
                        ),
                        false
                    );?>
                <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket.php"), array(), array("MODE"=>"html") );?>
            </div>
            <?endif;?>
    </div>
    <div class="clear"></div>
    
    <?if(!$IS_BASKET):?>

       
        <?endif;?>
    <?if(!$IS_BASKET):?>
       
        <?endif;?>
    <? if(!$IS_MAIN):?>
        <div id="WorkArea">
        <?endif;?>
    <?if($IS_BASKET):?>
        <?if($_REQUEST["CurrentStep"]=="3"|| $_REQUEST["CurrentStep"]=="4"):?>
            <div class="basket2col">
                <?endif;?>
            <h1 class="basketh1"><?$APPLICATION->ShowTitle(false);?></h1>
            <?endif?>
        <div class="nodisplay" id="haveSravn"><?if($showSravn):?>1<?else:?>0<?endif;?></div>
        <?if(!$NO_BROAD):?>

            <?if($showSravn):?>
                <div class="rel" style="width:100%; height:1px; z-index:100;">
                    <div class="sravn" id="sravn">
                        <?if(count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])>2):?>
                            <div class="add-to-compare-list">
                                <a href="/catalog/compare/">сравнение товаров:</a> 
                                <span><?=count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])?></span> 
                                <a id="clearCompear" href="#">очистить</a>
                            </div>
                            <?endif;?>
                    </div>
                </div>
                <?endif;?>
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "s1"
                    ),
                    false
                );?>
            <?endif?>
        <?if($IS_BASKET):?>
            <?if($_REQUEST["CurrentStep"]=="3" || $_REQUEST["CurrentStep"]=="4"):?>
            </div>
            <?endif;?>
        <?endif?>
    <?
        if(strpos($_SERVER["REQUEST_URI"], "community") !== false)
        {
            $IS_COMUNITY = true;
            $HIDE_LEFT_COLUMN = true;
        }

    ?>


    <?if(!$HIDE_LEFT_COLUMN):?>
        <?
            if(strpos($_SERVER["REQUEST_URI"], "catalog") !== false)
            {
                $catal = true;
                CModule::IncludeModule('iblock');
                $arURL = explode('/', $_SERVER["REDIRECT_URL"]);
                $current_section_id = $arURL[2];      


                if (count($arURL) > 1 && count($arURL) < 5)
                    $SHOW_FILTER = true;



                if (!$arURL[1] > 0)
                    $SHOW_SECTIONS_MENU = true;

                if ($arURL > 0)
                {
                    $res = CIBlockSection::GetList(array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "SECTION_ID" => $current_section_id), false, array());
                    if($arSect = $res->GetNext())
                    {
                        $IS_PARENT_SECTION = true;    
                    }
                }

                if(count($arURL) > 4){
                    $IS_DETAIL = true;
                    $IS_PARENT_SECTION = false;
                }

                if($FILTER_TITLE){
                    $IS_DETAIL = false;
                    $IS_PARENT_SECTION = false;
                }
            }
        ?>

     
        <?endif?>
    <?if (!$IS_DETAIL):?>
        <div id="CatalogCenterColumn" class="LExist<?if ($HIDE_LEFT_COLUMN):?> wide<?endif?>">   
        <?endif?><?
    }

?>