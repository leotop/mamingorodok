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

        $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.9.11.custom.min.js');
    ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing-1.3.pack.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mousewheel-3.0.4.pack.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.elevatezoom.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/inputmask.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.session.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/recommended.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/lib/jquery.jcarousel.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.jscrollpane.min.js"></script>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script_cache.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script2.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/consultant.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fxSlider.js"></script>

    <script src="/local/templates/nmg/js/scripts.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/datepicker/jquery-ui.min.js"></script>

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

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/jquery.formstyler.js"> </script>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jquery.formstyler.css" />

    <link rel="stylesheet" type="text/css" href="/local/templates/nmg/skins/accessory/skin.css" />
    <link rel="stylesheet" type="text/css" href="/local/templates/nmg/skins/tumb/skin.css" />
    <link rel="stylesheet" type="text/css" href="/local/templates/nmg/skins/color_chose/skin.css" />
    <link rel="stylesheet" type="text/css" href="/local/templates/nmg/skins/color_chose_one/skin.css" />
    <link rel="stylesheet" type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/slider/jquery-ui-1.8.11.custom.css"/>

    <link href="/local/templates/nmg/components/individ/catalog.element/newCard/style_card.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/cloud-zoom.css" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/datepicker/jquery-ui.min.css" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqtransform.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/style_blog.css" />

    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqzoom.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jquery.jqzoom.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/chrome.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/skins/tango/skin.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

    <script type="text/javascript">
        $(function(){
            $("#phone").inputmask("8-999-999-99-99");

            $("#qoPhone").inputmask("8-999-999-99-99");
        })

    </script>
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

</head>
<?php// flush(); ?>
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
<?$APPLICATION->IncludeComponent("bitrix:socialnetwork.events_dyn", ".default", array(
        "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
        "PATH_TO_USER" => "/comunity/user/#iser_id#/",
        "PATH_TO_GROUP" => "",
        "PATH_TO_MESSAGE_FORM" => "",
        "PATH_TO_MESSAGE_FORM_MESS" => "",
        "PATH_TO_MESSAGES_CHAT" => "",
        "PATH_TO_SMILE" => "/bitrix/images/socialnetwork/smile/",
        "AJAX_LONG_TIMEOUT" => "60",
        "NAME_TEMPLATE" => "#NOBR##LAST_NAME# #NAME##/NOBR#",
        "SHOW_LOGIN" => "Y",
        "POPUP" => "N",
        "SHOW_YEAR" => "Y",
        "MESSAGE_VAR" => "",
        "PAGE_VAR" => "",
        "USER_VAR" => ""
        ),
        false
    );?>

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
<? //if(true) { // if($USER -> IsAdmin() || in_array(10, $USER->GetUserGroupArray()))?>

<div class="popup_block" id="city-sel" data-popup-head="Укажите ваш город" style="display: none;"></div>
<div class="header">
    <div class="sk-toppane-wrap">
        <div class="sk-toppane">

            <ul class="sk-top-menu">
                <?
                    if(file_exists($_SERVER["DOCUMENT_ROOT"].'/how-to-buy/.subleft.menu.php')) {
                        include($_SERVER["DOCUMENT_ROOT"].'/how-to-buy/.subleft.menu.php');
                        $strTmp = '';
                        foreach($aMenuLinks as $arItem)
                            $strTmp .= '<li class="sk-top-menu_sel"><a href="'.$arItem[1].'" title="'.$arItem[0].'">'.$arItem[0].'</a></li>';

                        if(!empty($strTmp))
                            echo $strTmp;
                    }
                ?>


                <li class="sk-top-menu_last"><a href="#" title="Обратная связь" id="feedbackFormHref">Обратная связь</a></li>
            </ul>
            <ul class="sk-welkom-bar">
                <li class="sk-top-menu_city-sel">
                    <?$APPLICATION->IncludeComponent(
                            "altasib:geobase.select.city",
                            "",
                            Array(
                            )
                        );?>
                <? /*     <a href="#" class="sk-popup-open" data-popup-name="city-sel" data-scroll="scroll">г. <?=$GLOBALS["CGeoIP"] -> getLocationName()?></a> */  ?> </li>
            </ul>
            <ul class="sk-welkom-bar_top">
                <?if($USER -> IsAuthorized()){?>
                    <li class="hover_menu"><a  href="javascript:void(0);">Здравствуйте, <?=$USER->GetFirstName()?></a>
                        <ul class="slide_effect">
                            <?if ($USER->IsAuthorized()){?>
                                <li><a onclick="_gaq.push(['_trackEvent', 'Button', 'Cabinet', 'Header']);" href="/personal/" title="Мой кабинет">Личный кабинет</a></li>
                                <?}?>
                            <li><?
                                    if($USER -> IsAuthorized())
                                    {
                                        echo '<a href="'.$APPLICATION->GetCurPage().'?logout=yes">Выход</a>';
                                }?>
                            </li>
                        </ul>
                    </li>
                    <?}else{?>
                    <li>
                        <?=showNoindex()?>
                        <div class="enter">
                            <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", array(
                                    "REGISTER_URL" => "/personal/registaration/",
                                    "PROFILE_URL" => "/personal/profile/auth/",
                                    "SHOW_ERRORS" => "N"
                                    ),
                                    false
                                );?>
                        </div>
                        <?=showNoindex(false)?>
                        <?}?>
                </li>
            </ul>
        </div>
    </div>

    <div class="sk-paypane-wrap">
        <div class="sk-paypane">
            <?=showNoindex()?>
            <?
                $APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "search_header",
                    array(
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "sk-search--input",
                        "PRICE_CODE" => "RETAIL",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "150",
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y",
                        "CURRENCY_ID" => "RUB",
                        "PAGE" => "#SITE_DIR#tools/search/",
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "10",
                        "ORDER" => "date",
                        "USE_LANGUAGE_GUESS" => "Y",
                        "CHECK_DATES" => "Y",
                        "SHOW_OTHERS" => "N",
                        "CATEGORY_0_TITLE" => "",
                        "CATEGORY_0" => array(
                            0 => "iblock_catalog",
                        ),
                        "CATEGORY_0_iblock_news" => "all",
                        "CATEGORY_1_TITLE" => "Форумы",
                        "CATEGORY_1" => "forum",
                        "CATEGORY_1_forum" => "all",
                        "CATEGORY_2_TITLE" => "Каталоги",
                        "CATEGORY_2" => "iblock_books",
                        "CATEGORY_2_iblock_books" => "all",
                        "CATEGORY_OTHERS_TITLE" => "",
                        "COMPONENT_TEMPLATE" => "search_header",
                        "CATEGORY_0_iblock_catalog" => array(
                            0 => "2",
                        )
                    ),
                    false
                );
                /*$APPLICATION->IncludeComponent("bitrix:search.form", "search_header", Array(
                "USE_SUGGEST" => "Y",
                "PAGE" => "#SITE_DIR#tools/search/",
                ),
                false
                );*/
            ?>
            <?=showNoindex(false)?>

            <div style="display: none;">
                <?
                    if ($USER->IsAuthorized()){
                        //Получаем список отложенных товаров
                        $arResult["ITEMS"] = array();

                        $rsI = CIBlockElement::GetList(Array("ID" => "DESC"), array(
                            "ACTIVE" => "Y",
                            "IBLOCK_ID" => 8,
                            "PROPERTY_DELETED" => false,
                            "PROPERTY_USER_ID" => $USER -> GetID()
                            ), false, false, array(
                                "ID",
                                "IBLOCK_ID", "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS",
                                "PROPERTY_PRODUCT_ID.DETAIL_PAGE_URL",
                                "PROPERTY_PRODUCT_ID.NAME",
                                "PROPERTY_PRODUCT_ID.PREVIEW_PICTURE"
                        ));
                        while($arI = $rsI->GetNext())
                            $arResult["ITEMS"][$arI["PROPERTY_PRODUCT_ID_VALUE"]] = $arI;

                        if(!empty($arResult["ITEMS"])) {
                            $arTmpOffers = array();
                            $rsI = CIBlockElement::GetList(array(), array("ACTIVE" => "Y",    "IBLOCK_ID" => 3, "PROPERTY_CML2_LINK" => array_keys($arResult["ITEMS"])), false, false, array("ID", "IBLOCK_ID", "CATALOG_GROUP_1", "PROPERTY_CML2_LINK"));
                            while($arI = $rsI->GetNext())
                                $arTmpOffers[$arI["PROPERTY_CML2_LINK_VALUE"]][] = $arI["CATALOG_PRICE_1"];

                            foreach($arTmpOffers as $intProductID => $arPrices)
                                $arResult["ITEMS"][$intProductID]["MIN_PRICE"] = min($arPrices);
                        }
                        //                            arshow(count($arResult["ITEMS"]));
                    }
                ?>
            </div>
            <ul class="sk-mybar">
                <li><a href="<? echo '/personal/products/wishlist/';  /*($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')*/?>" class="sk-mybar--babylist <?if (count($arResult["ITEMS"])>0) { echo 'babyListNotEmpty';}?>" title="Избранное">Избранное <?if (count($arResult["ITEMS"])>0) { echo '(<span id="likeCount" count="'.count($arResult["ITEMS"]).'">'.count($arResult["ITEMS"]).'</span>)';}?></a></li>
                <li class="info_basket_peace">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.small",
                        "template1",
                        array(
                            "PATH_TO_BASKET" => "/basket/",
                            "PATH_TO_ORDER" => "/basket/order/",
                            "SHOW_DELAY" => "N",
                            "SHOW_NOTAVAIL" => "N",
                            "SHOW_SUBSCRIBE" => "Y",
                            "COMPONENT_TEMPLATE" => "template1"
                        ),
                        false
                    );?></li>
            </ul>
        </div>
    </div>
    <div class="sk-logopane">
        <div class="sk-logo"><a href="/" title="mamingorodok.ru"><img src="/local/templates/nmg/img/header/logo.png" alt="" /></a></div>
        <?$APPLICATION->IncludeComponent(
                "sk:banner.slider",
                "",
                Array(
                    "TYPE" => "HEADER_SLIDER",
                    "NOINDEX" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000"
                ),
                false
            );?>
        <?
            /*
            <div class="sk-action sk-action_newHed">
            <div class="sk-action--delivery">
            <i title="#" class="sk-action--delivery--head">Доставка по всей России</i>
            <i title="/how-to-buy/how-to-get/">Бесплатно по Москве</i>
            <i title="/how-to-buy/how-to-get/" class="fl-r" >Условия для регионов</i>
            </div>
            <div class="sk-action--credit">
            <i title="/credit/" class="sk-action--credi--head">Покупка товаров в кредит</i>
            <i title="/credit/">Кредит на весь ассортимент магазина</i>
            </div>
            </div>
            */
        ?>
        <div class="sk-hotLine">
            Бесплатный телефон для регионов<br>
            <strong>
                <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/includes/region-phone.php",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );?>
            </strong>
        </div>


        <div class="sk-phone sk-phone_newHed">
            <a class="showpUp getCallForm" href="#call_popup" title="Заказать обратный звонок">Заказать обратный звонок</a><br>
            <p><span>8 (495)</span> 661-03-21</p>
            <span class="after_phone">Call-центр работает: пн-пт с 9:00 до 18:00<br>суббота и воскресенье ВЫХОДНОЙ</span>
        </div>
    </div>
    <div class="popup_block" id="callback-form"  data-popup-head="Обратная связь" style="display: none;">
        Обратная связь
    </div>
</div>
<!-- new header -->
<? //}
    /*else {
    <!-- Old header -->

    <div class="header">
    <div class="sk-toppane-wrap">
    <div class="sk-toppane">


    <ul class="sk-top-menu">
    <? if(in_array(10, $USER->GetUserGroupArray())) { ?>
    <li class="sk-top-menu_city-sel"><a href="#" class="sk-popup-open" data-popup-name="city-sel">г. Санкт-Петербург</a></li>
    <? } ?>

    <li><?=showNoindex()?><a href="/how-to-buy/" title="Помощь покупателю">Помощь покупателю</a><?=showNoindex(false)?></li>
    <li class="sk-top-menu_sel"><i title="#"  id="feedbackFormHref">Обратная связь</i></li>
    <li class="sk-top-menu_last"><i href="/credit/" >Покупка в кредит</i></li>
    </ul>
    <ul class="sk-welkom-bar">
    <li>Добро пожаловать <?=$USER -> GetFullName()?></li>
    <li><?
    if($USER -> IsAuthorized())
    {
    echo '<a onclick="_gaq.push([\'_trackEvent\', \'Button\', \'ExitClick\', \'Header\']);" href="'.$APPLICATION->GetCurPage().'?logout=yes">Выход</a>';
    } else {?>
    <?=showNoindex()?>
    <div class="enter">
    <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", array(
    "REGISTER_URL" => "/personal/registaration/",
    //"FORGOT_PASSWORD_URL" => "/personal/profile/forgot-password/",
    "PROFILE_URL" => "/personal/profile/auth/",
    "SHOW_ERRORS" => "N"
    ),
    false
    );?>
    </div>
    <?=showNoindex(false)?><?
    }?></li>
    </ul><?
    if(false)
    {?>
    <div class="sk-cabinet"><a href="#" title="Мой кабинет">Мой кабинет</a></div><?
    }?>
    </div>
    </div>

    <div class="sk-paypane-wrap">
    <div class="sk-paypane">
    <ul class="sk-pay-bar">
    <li><a href="/how-to-buy/how-to-pay/" title="Наличные"><img src="/bitrix/templates/nmg/img/header/pay-rub.png" alt="" /></a></li>
    <li><a href="/how-to-buy/how-to-pay/" title="Visa"><img src="/bitrix/templates/nmg/img/header/pay-visa.png" alt="" /></a></li>
    <li><a href="/how-to-buy/how-to-pay/" title="MasterCard"><img src="/bitrix/templates/nmg/img/header/pay-master.png" alt="" /></a></li>
    <li><a href="/how-to-buy/how-to-pay/" title="Maestro"><img src="/bitrix/templates/nmg/img/header/pay-maestro.png" alt="" /></a></li>
    <li><a href="/how-to-buy/how-to-pay/" title="WebMoney"><img src="/bitrix/templates/nmg/img/header/pay-webmoney.png" alt="" /></a></li>
    <li><a href="/how-to-buy/how-to-pay/" title="Яндекс Деньги"><img src="/bitrix/templates/nmg/img/header/pay-yamoney.png" alt="" /></a></li>
    <li><a href="/credit/" title="Купи в кредит"><img src="/bitrix/templates/nmg/img/header/pay-credit.png" alt="Купи в кредит" /></a></li>
    </ul>

    <ul class="sk-mybar">
    <li><a href="<?=($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')?>" class="sk-mybar--babylist" title="Список малыша">Список малыша</a></li>
    <li><a href="/basket/" class="sk-mybar--cart" title="Моя корзина">Моя корзина <span>(<?=$intCartCnt?>)</span></a></li>
    </ul>

    </div>
    </div>
    <div class="sk-logopane">
    <div class="sk-logo"><a href="/" title="mamingorodok.ru"><img src="/bitrix/templates/nmg/img/header/logo.png" alt="" /></a></div>
    <?=showNoindex()?>
    <?$APPLICATION->IncludeComponent("bitrix:search.form", "search_header", Array(
    "PAGE" => "#SITE_DIR#tools/search/",
    ),
    false
    );?>
    <?=showNoindex(false)?>
    <div class="sk-action">
    <div class="sk-action--delivery">
    <a href="#" class="sk-action--delivery--head" title="Доставка по всей России">Доставка по всей России</a>

    <a href="/how-to-buy/how-to-get/" title="Бесплатно по Москве">Бесплатно по Москве</a>
    <a href="/how-to-buy/how-to-get/" class="fl-r" title="Условия для регионов">Условия для регионов</a>
    </div>
    </div>
    <div class="sk-phone">
    <span>(495)</span> 988-32-39<br />
    <a class="showpUp getCallForm" href="#call_popup" title="Заказать обратный звонок">Заказать обратный звонок</a>
    </div>
    </div>
    <div class="popup_block" id="callback-form"  data-popup-head="Обратная связь" style="display: none;">
    Обратная связь
    </div>
    </div>

} */?>

<div class="main">
<?
    echo showNoindex();
?>
<?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "top_menu",
        array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "COUNT_ELEMENTS" => "N",
            "TOP_DEPTH" => "2",
            "SECTION_FIELDS" => array(
                0 => "ID",
                1 => "NAME",
                2 => "SORT",
                3 => "",
            ),
            "SECTION_USER_FIELDS" => array(
                0 => "UF_MENU_TITLE",
                1 => "",
            ),
            "SECTION_URL" => "/catalog/#CODE#/",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "VIEW_MODE" => "LINE",
            "SHOW_PARENT_NAME" => "Y",
            "COMPONENT_TEMPLATE" => "top_menu"
        ),
        false
    );?><?
    echo showNoindex(false);
    if($USER -> GetID() != 495 && false)
    {?>
    <?=showNoindex()?>
    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "sections-menu", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "2",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "COUNT_ELEMENTS" => "N",
            "TOP_DEPTH" => "2",
            "SECTION_FIELDS" => array(
                0 => "ID",
                1 => "NAME",
                2 => "SORT",
                3 => "",
            ),
            "SECTION_USER_FIELDS" => array("UF_MENU_TITLE"),
            "SECTION_URL" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "ADD_SECTIONS_CHAIN" => "N"
            ),
            false
        );?>
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
<?//arshow($showSravn);?>
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
                $APPLICATION->ShowProperty("leftMenuHtml"); // generates in footer
                if(ERROR_404 == "Y")
                {
                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "leftmenu",
                        Array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => "2",
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "N",
                            "TOP_DEPTH" => "2",
                            "SECTION_FIELDS" => array(),
                            "SECTION_USER_FIELDS" => array(),
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "Y"
                        ),
                        false
                    );
                }

                ///////////фильтр поиска///////////////////////////
                if(strpos($APPLICATION -> GetCurDir(), "/tools/search/") === 0 ){


                    global $arrSearchFilter;
                    if(strlen($_REQUEST["q"])>0) $GLOBALS["arrSearchFilter"][] = array(
                        "LOGIC"=>"OR",
                        array("NAME"=>'%'.htmlspecialchars($_REQUEST["q"]).'%'),
                        array("?PROPERTY_ARTICUL" => htmlspecialchars($_REQUEST["q"]))
                        );
                    //  $arrFilterSpecial["!PROPERTY_1498"] = false;
                    //arshow($arrFilterSpecial);

                    $APPLICATION->IncludeComponent(
                        "kombox:filter",
                        "catalog_filter",
                        array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => "2",
                            "FILTER_NAME" => "arrSearchFilter",
                            "HIDE_NOT_AVAILABLE" => "Y",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "N",
                            "SAVE_IN_SESSION" => "N",
                            "INCLUDE_JQUERY" => "N",
                            "MESSAGE_ALIGN" => "LEFT",
                            "MESSAGE_TIME" => "5",
                            "CLOSED_PROPERTY_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "CLOSED_OFFERS_PROPERTY_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "SORT" => "N",
                            "SORT_ORDER" => "ASC",
                            "FIELDS" => array(
                            ),
                            "PRICE_CODE" => array(
                            ),
                            "CONVERT_CURRENCY" => "N",
                            "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                            "XML_EXPORT" => "Y",
                            "SECTION_TITLE" => "NAME",
                            "SECTION_DESCRIPTION" => "DESCRIPTION",
                            "IS_SEF" => "Y",
                            "SEF_BASE_URL" => "/catalog/",
                            "SECTION_PAGE_URL" => "#SECTION_CODE#/",
                            "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
                            "PAGE_URL" => "",
                            "STORES_ID" => array(
                            )
                        ),
                        false
                    );
                }
                ///////////фильтр поиска///////////////////////////

                if($IS_MAIN ||  preg_match("/\/community\/user\/\d+\//", $APPLICATION -> GetCurDir()))
                {

                ?><?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "index_left_col",
                        array(
                            "IBLOCK_TYPE" => "catalog",
                            "IBLOCK_ID" => "2",
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "COUNT_ELEMENTS" => "N",
                            "TOP_DEPTH" => "1",
                            "SECTION_FIELDS" => array(
                                0 => "ID",
                                1 => "NAME",
                                2 => "SORT",
                                3 => "",
                            ),
                            "SECTION_USER_FIELDS" => array(
                                0 => "UF_MENU_TITLE",
                                1 => "UF_INDEX",
                                2 => "",
                            ),
                            "SECTION_URL" => "/catalog/#CODE#/",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_GROUPS" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "COMPONENT_TEMPLATE" => "index_left_col"
                        ),
                        false
                    );?><?
                }
                /*                if(strpos($_SERVER["REQUEST_URI"]) !== false && ERROR_404 != "Y")
                {
                $APPLICATION->IncludeComponent("kombox:filter", "catalog_filter", Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => 2,
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SAVE_IN_SESSION" => "N",
                "INCLUDE_JQUERY" => "N",
                "MESSAGE_ALIGN" => "LEFT",
                "MESSAGE_TIME" => "5",
                "IS_SEF" => "N",
                'SEF_BASE_URL' => $arParams["SEF_FOLDER"],
                "CLOSED_PROPERTY_CODE" => array(),
                "CLOSED_OFFERS_PROPERTY_CODE" => array(),
                "SORT" => "N",
                "SORT_ORDER" => "ASC",
                "FIELDS" => array(),
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                "XML_EXPORT" => "Y",
                "SECTION_TITLE" => "NAME",
                "SECTION_DESCRIPTION" => "DESCRIPTION",
                "SECTION_PAGE_URL" => $arParams["SEF_URL_TEMPLATES"]["section"],
                "SECTION_PAGE_URL" => $arParams["SEF_URL_TEMPLATES"]["element"],
                "TOP_DEPTH_LEVEL" => 1
                ),
                false
                );
                } */
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
                ?><?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "sections-left", array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "2",
                        "SECTION_ID" => $current_section_id,
                        "SECTION_CODE" => "",
                        "COUNT_ELEMENTS" => "Y",
                        "TOP_DEPTH" => "1",
                        "SECTION_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_URL" => "/catalog/#CODE#/",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "ADD_SECTIONS_CHAIN" => "N"
                        ),
                        false
                    );?><?
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
                ?><?$APPLICATION->IncludeComponent("individ:menu.section.list", "reviews_filter", Array(
                        "IBLOCK_TYPE" => "catalog",	// Тип инфо-блока
                        "IBLOCK_ID" => "7",	// Инфо-блок
                        "SECTION_CODE" => $_REQUEST["SECTION_ID"],	// ID раздела
                        "SECTION_CODE" => $_REQUEST["SECTION_CODE"],	// Код раздела
                        "COUNT_ELEMENTS" => "N",	// Показывать количество элементов в разделе
                        "TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
                        "SECTION_FIELDS" => array(	// Поля разделов
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_USER_FIELDS" => array(	// Свойства разделов
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
                        "CACHE_TYPE" => "A",	// Тип кеширования
                        "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                        "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                        "ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
                        ),
                        false
                    );?>
                <? $APPLICATION->ShowViewContent("right_area");?>
                <?
                }

                if($SUBSCRIBE)
                {
                ?><? $APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
                        "TYPE" => "catalog_left",
                        "NOINDEX" => "Y",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "0"
                        ),
                        false
                    ); ?>
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
    <td> </td><?
}?>
<td class="right_sitebar"><?
    if(strpos($APPLICATION->GetCurPage(), "/catalog/") === 0 || strpos($APPLICATION->GetCurPage(), "/basket/") === 0)
        $APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array("START_FROM" => "0", "PATH" => "", "SITE_ID" => "s1"), false);

    $APPLICATION->ShowProperty('h1Html');



    $APPLICATION->IncludeComponent(
        "inseco:9may",
        ".default",
        array(
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_NOTES" => "",
            "INSECO_URL" => "9may.ru",
            "INSECO_URL_TITLE" => "Георгиевская ленточка",
            "INSECO_PTOP" => "0",
            "INSECO_PLEFT" => "0"
        ),
        false
    );?>


<?//Летающая корзина?>
<?$APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket.line",
        "flying-cart",
        array(
            "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
            "SHOW_PERSONAL_LINK" => "N",
            "SHOW_NUM_PRODUCTS" => "Y",
            "SHOW_TOTAL_PRICE" => "N",
            "SHOW_EMPTY_VALUES" => "Y",
            "SHOW_AUTHOR" => "N",
            "PATH_TO_REGISTER" => SITE_DIR."login/",
            "PATH_TO_PROFILE" => SITE_DIR."personal/",
            "SHOW_PRODUCTS" => "Y",
            "POSITION_FIXED" => "Y",
            "SHOW_DELAY" => "Y",
            "SHOW_NOTAVAIL" => "N",
            "SHOW_SUBSCRIBE" => "N",
            "SHOW_IMAGE" => "Y",
            "SHOW_PRICE" => "Y",
            "SHOW_SUMMARY" => "Y",
            "PATH_TO_ORDER" => SITE_DIR."basket",
            "POSITION_HORIZONTAL" => "hcenter",
            "POSITION_VERTICAL" => "vcenter",
            "COMPONENT_TEMPLATE" => "flying-cart"
        ),
        false,
        array(
            "0" => "",
            "ACTIVE_COMPONENT" => "Y"
        )
    );?>


<?/*$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "template1", Array(
    "PATH_TO_BASKET" => "/personal/basket.php",	// Страница корзины
    "PATH_TO_ORDER" => "/personal/order.php",	// Страница оформления заказа
    "SHOW_DELAY" => "Y",	// Показывать отложенные товары
    "SHOW_NOTAVAIL" => "Y",	// Показывать товары, недоступные для покупки
    "SHOW_SUBSCRIBE" => "Y",	// Показывать товары, на которые подписан покупатель
    ),
    false
);*/?>