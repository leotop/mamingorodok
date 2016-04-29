<?if (!$IS_DETAIL):?>
    </div>
<?endif?>

<?if(!$IS_MAIN):?>
    <div class="clear"></div>
    </div>
<?endif;?>

<div class="footer">
	<div class="toplink">
	<a href="#">Наверх<div></div></a>
	</div>
	<div class="hr"></div>
</div>
<div class="footer2">
<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
	"ROOT_MENU_TYPE" => "bottom",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "1",
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/bottomphone.php"), array(), array("MODE"=>"html") );?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/bottomcopyrigth.php"), array(), array("MODE"=>"html") );?>
</div>
<div class="clear"></div>
<div class="top25"></div>
</div>
</div>

<div id="add-to-basket-popup" class="CatPopUp">
    <?/*<div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Выберите параметры товара</div>
        <div id="PopupParamsChoose">
            <div class="PictureBlock">
                <div class="DPicture"><a class="no-fancybox" href="/i/big.jpg"><img width="256" height="258" title="" alt="" src="/i/big.jpg"></a></div>
            </div>
            <div class="ChooseBlock">
                <h1>Inglesina Domino Trio</h1>
                <div class="clear"></div>
                <div class="round_plash">
                    <div class="rp_head"></div>
                    <div class="rp_content">
                        <div class="rp_content">
                            <div class="clear"> </div>
                            <form action="?"><div class="clear"> </div>
                                <div class="Color">Цвет: <span>Appletree</span></div>
                                <div class="ColorList">
                                    <div class="i"><label for="color_0"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_0"></div>
                                    <div class="i"><label for="color_1"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_1"></div>
                                    <div class="i"><label for="color_2"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_2"></div>
                                    <div class="i"><label for="color_3"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_3"></div>
                                    <div class="i"><label for="color_4"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_4"></div>
                                    <div class="i"><label for="color_5"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_5"></div>
                                    <div class="i"><label for="color_6"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_6"></div>
                                    <div class="i"><label for="color_7"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_7"></div>
                                    <div class="i"><label for="color_8"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_8"></div>
                                    <div class="i"><label for="color_9"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_9"></div>
                                    <div class="i"><label for="color_10"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_10"></div>
                                    <div class="i"><label for="color_11"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_11"></div>
                                    <div class="i"><label for="color_12"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_12"></div>
                                    <div class="i"><label for="color_13"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_13"></div>
                                    <div class="i"><label for="color_14"><img width="31" height="32" title="" alt="" src="/i/small.gif"></label><input type="radio" name="color" id="color_14"></div>
                                    <div class="clear"></div>
                                </div>
                                <div class="Size">Размер: <span>50</span></div>
                                <div class="SizeList">
                                    <div class="i"><input type="radio" id="size_47" name="size"><label for="size_47">47</label></div>
                                    <div class="i"><input type="radio" id="size_48" name="size"><label for="size_48">48</label></div>
                                    <div class="i"><input type="radio" id="size_49" name="size"><label for="size_49">49</label></div>
                                    <div class="i"><input type="radio" id="size_50" name="size"><label for="size_50">50</label></div>
                                    <div class="i"><input type="radio" id="size_51" name="size"><label for="size_51">51</label></div>
                                    <div class="i"><input type="radio" id="size_52" name="size"><label for="size_52">52</label></div>
                                    <div class="clear"></div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                            <a href="?" class="dotted_a how">Как выбрать размер?</a>
                        </div>
                    </div>
                    <div class="rp_footer"></div>
                </div>
                <div class="price-layer">
                    <div class="price">15 000 <span>руб.</span></div>
                    <a class="add-to-basket" href="#"></a>
                    <div class="clear"></div>
                </div>                
            </div>
            <div class="clear"></div>
        </div>

    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>  



<div id="made-a-gift" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Сделали подарок</div>
        <?for($i=1; $i<=5; $i++):?>
            <div class="person<?if($i % 3 == 0):?> last<?endif?>">
                <div class="image"></div>
                <div class="right-right">
                    <a href="#">Иванов Игорь</a><br />
                    Хабаровск, 28 лет
                </div>
            </div>
            <?if ($i % 3 == 0):?>
                <div class="clear"></div>
            <?endif?>
        <?endfor?>
        <div class="clear"></div>
        
        <div class="paging">
            <ul>
                <li><a href="#">Следующие 10</a></li>
                <li>|</li>
                <li><a href="#">Показать всех</a></li>
            </ul>
        </div>
        
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 

<div id="send-to-friend" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Сообщить друзьям</div>
        <div class="el-address-label">Электронные адреcа</div>
        <div class="descr">(введите адреса друзей через запятую)</div>
        <form class="jqtransform">
            <div class="el-address"><input type="text" /></div>
            <div><input type="submit" class="purple" value="Отправить" /></div>
        </form><br />
        
        
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 

<div id="i-choose" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Вставить в блог</div>
        <div class="left-left">
            <div class="label-label">Я выбрала для малыша</div>
            <div class="product-product">
                <div class="image">
                    <img src="/i/g1.jpg" />
                </div>
                <div class="name-name">
                    <a class="product-name" href="/catalog/2/385/">Inglesina Domino Trio</a>
                    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => 4));?>
                </div>
                <div class="clear"></div>
            </div>
            <a class="all-list" href="#">Весь список Ольги</a>
        </div>
        <div class="right-right">
            <form class="jqtransform">
                <textarea>HTML код виджета</textarea><br />
                <input type="submit" class="purple" value="Скопировать код" />
            </form>
        </div>
        <div class="clear"></div>
        
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 


*/?>
</div>  

<div id="call_popup" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
       <div class="data">
	   <br/><center><img src="/ajax-loader.gif"></center><br/>
       </div> 
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 


<?
if($USER->GetID() != 495)
{ ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {/*Здесь параметры визита*/};
</script>

<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter8129698 = new Ya.Metrika({id:8129698, enableAll: true,params:window.yaParams||{ }});
        }
        catch(e) { }
    });
})(window, "yandex_metrika_callbacks");
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/8129698" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --><?
	if(true)
	{ ?>
<script type="text/javascript">
	UisConsultant.init(290, 'W5eGZZL7Tmfg64iu83oMlfBSNgSyIYsE3Hm1G88ztmPyq72x0qgvGVmtae1Tctwe', 'consultant.up.uiscom.ru', 80, 289, 'http://up.uiscom.ru/', '');
</script><?
	} else { ?>
<script type="text/javascript" src="http://up.uiscom.ru/static/client/js/UisConsultant.js" charset="utf-8"></script>
<script type="text/javascript">
UisConsultant.init(290, 'W5eGZZL7Tmfg64iu83oMlfBSNgSyIYsE3Hm1G88ztmPyq72x0qgvGVmtae1Tctwe', 'consultant.up.uiscom.ru', 80, 289, 'http://up.uiscom.ru/', '');
</script><?
	}
}
?>
</body>
</html>
<?
if(strlen($APPLICATION->GetProperty('seo_title'))>0)
	$APPLICATION->SetTitle($APPLICATION->GetProperty('seo_title'));
else {
	$hh = $APPLICATION->GetProperty('headertitle');
	if(strlen($hh) > 0) $APPLICATION->SetTitle($hh);
}

if($APPLICATION->GetDirProperty("showLeftMenu") == "Y")
{
	ob_start();
	?><?$APPLICATION->IncludeComponent(
"bitrix:menu",
"left_col_ml",
Array(
	"ROOT_MENU_TYPE" => "left",
	"MAX_LEVEL" => "2",
	"CHILD_MENU_TYPE" => "subleft",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array()
),
false
);?><?
	$APPLICATION->SetPageProperty("leftMenuHtml", ob_get_contents());
	ob_end_clean();
}
?>
