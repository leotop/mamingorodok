<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
</td>
</tr>
</table>
</div>
<div class="bottom_block">
    <div class="bottom_block_bg">
        <?$APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "sect",
                    "AREA_FILE_SUFFIX" => "bottominc",
                    "AREA_FILE_RECURSIVE" => "Y",
                    "EDIT_TEMPLATE" => ""
                ),
                false
            );?>
        <div class="footer">
            <div class="footer_left">
                <span class="fphone">
                    <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/includes/phone.php",
                                "EDIT_TEMPLATE" => ""
                            ),
                            false
                        );
                    ?>
                </span>
                <p>
                    с 9:00 до 18:00 по московскому времени
                </p>
                <p>
                    суббота и воскресенье ВЫХОДНОЙ
                </p>
            </div>
            <div class="footer_copy">
                <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/includes/copy.php",
                            "EDIT_TEMPLATE" => ""
                        ),
                        false
                    );
                ?>
            </div>
            <div class="footer_right">
                <p>
                    <br/>
                    <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/includes/counters.php",
                                "EDIT_TEMPLATE" => ""
                            ),
                            false
                        );
                    ?>
                </p>
            </div>
            <div class="counters">     
                <!--noindex-->
                <a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://market.yandex.ru/grade-shop.xml?shop_id=79781">
                    <img src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1248/*http://img.yandex.ru/market/informer12.png" border="0" 
                        alt="Оцените качество магазина на Яндекс.Маркете." />
                </a>
                <!--/noindex-->
                <!--noindex-->
                <!--LiveInternet counter-->
                <script type="text/javascript">
                    document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t57.9;r" + escape(document.referrer) +
                        ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" +
                        escape(document.URL) + ";" + Math.random() + "' border=0 width=88 height=31 alt='' title='LiveInternet'><\/a>")
                </script>
                <!--/LiveInternet-->
                <!--/noindex-->
            </div>
        </div>
    </div>
</div>
<?
    // service area
    $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/tipitop.php");
?>
<div id="ajaxContainer"></div>
<div id="add-to-basket-popup" class="CatPopUp"></div>
<div id="call_popup" class="CatPopUp">
    <div class="white_plash">
        <div class="exitpUp"></div>
        <div class="cn tl"></div>
        <div class="cn tr"></div>
        <div class="content">
            <div class="content">
                <div class="content"> 
                    <div class="clear">
                    </div>
                    <div class="data">
                        <br/>
                        <center>
                            <img src="/ajax-loader.gif" alt=""/>
                        </center>
                        <br/>
                    </div> 
                </div>
            </div>
        </div>
        <div class="cn bl"></div>
        <div class="cn br"></div>
    </div>
</div> 

<?
    if($USER->GetID() != 495) {
    ?>
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type="text/javascript">
        (function() { 
            var widget_id = '20476';
            var s = document.createElement('script'); 
            s.type = 'text/javascript'; 
            s.async = true; 
            s.src = '//code.jivosite.com/script/widget/'+widget_id; 
            var ss = document.getElementsByTagName('script')[0]; 
            ss.parentNode.insertBefore(s, ss); 
        })(); 
    </script>
    <!-- {/literal} END JIVOSITE CODE --> 
    <?
    } 
?>
<br/>
<br/> 
<!-- Cifra1 Callback-widget start -->
<script>
    (function(){
        var widget_id = 'coolback_2175'; 
        var s = document.createElement('script'); 
        s.type = 'text/javascript'; 
        s.async = true; 
        s.src = 'https://lkvats.cifra1.ru/vatstest/widget/'+widget_id+'/index'; 
        var ss = document.getElementsByTagName('script')[1]; 
        ss.parentNode.insertBefore(s, ss);  
})();</script>
<!-- Cifra1 Callback-widget end -->
</body>
</html>
<?
    if($APPLICATION->GetDirProperty("showLeftMenu") == "Y") {
        ob_start();
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "left_col_ml",
            Array(
                "ROOT_MENU_TYPE" => "left",
                "MAX_LEVEL" => "2",
                "CHILD_MENU_TYPE" => "subleft",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600000",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array()
            ),
            false
        );
        $APPLICATION->SetPageProperty("leftMenuHtml", ob_get_contents());
        ob_end_clean();
    }

    if($APPLICATION->GetDirProperty("showH1") == "Y") {
        $APPLICATION->SetPageProperty("h1Html", '<h1>'.$APPLICATION->GetTitle().'</h1>');
    }

    if($IS_MAIN || $APPLICATION->GetDirProperty("showLeftMenu") == "Y" || preg_match("/\/catalog\/.+\//", $APPLICATION->GetCurDir()) 
        || preg_match("/\/community\/user\/\d+\//", $APPLICATION -> GetCurDir())) {
        ob_start();
        echo '<div class="leftColSocial" id="leftColSocial"><!--noindex-->';
        include($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/includes/vkontakte.php');
        echo '<!--/noindex--></div>';
        $APPLICATION->IncludeComponent(
            "bitrix:advertising.banner", 
            ".default", 
            array(
                "TYPE" => "catalog_center_left",
                "NOINDEX" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000",
                "CACHE_NOTES" => ""
            ),
            false
        );
        $APPLICATION->IncludeComponent(
            "bitrix:advertising.banner", 
            ".default", 
            array(
                "TYPE" => "catalog_center_left2",
                "NOINDEX" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000",
                "CACHE_NOTES" => ""
            ),
            false
        );
        $APPLICATION->IncludeComponent(
            "bitrix:advertising.banner",
            "",
            Array(
                "TYPE" => "catalog_center_left3",
                "NOINDEX" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000",
                "CACHE_NOTES" => ""
            )
        );
        $APPLICATION->SetPageProperty("leftColSocial", ob_get_contents());
        ob_end_clean();
    }

    if(strlen($APPLICATION->GetProperty('seo_title')) > 0) {
        $APPLICATION->SetTitle($APPLICATION->GetProperty('seo_title'));
    } else {
        $hh = $APPLICATION->GetProperty('headertitle');
        if(strlen($hh) > 0) {
            $APPLICATION->SetTitle($hh);
        }
    }

    //Added by Optimism.ru
    if (isset($_GET['PAGEN_1']) && is_numeric($_GET['PAGEN_1'])) {
        $curr_title = $APPLICATION->GetTitle();
        $APPLICATION->SetTitle($curr_title.' - страница '.$_GET['PAGEN_1']);
    }

    if ($_SERVER['REQUEST_URI'] == '/catalog/postelnye-prinadlezhnosti/proizvoditel_/') {
        $APPLICATION->SetPageProperty("description", "Постельные принадлежности - производитель в интернет-магазине «Мамин городок»");
    }
?>