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

if($USER -> IsAdmin())
{ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"><?
} else {
?>
<!DOCTYPE html>
	<html><?	
}
?>
<head>
	<title><?$APPLICATION->ShowTitle(false)?></title>
	<?$APPLICATION->ShowMeta("keywords")?>
	<?$APPLICATION->ShowMeta("description")?>
	
	<script src="/bitrix/templates/nmg/js/jquery-1.6.1.js" type="text/javascript"></script>
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
	
	<link href="/bitrix/templates/nmg/components/individ/catalog.element/newCard/style_card.css?1336556583" type="text/css" rel="stylesheet" />
	
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/cloud-zoom.css" />
	
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/recommended.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jcarousellite_1.0.1.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/lib/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.jscrollpane.min.js"></script>
	
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script_cache.js?2"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script2.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/consultant.js"></script>
	
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
if($USER -> IsAdmin())
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
?>
<div class="sk-sticky-bar">
	<div class="sk-sticky-bar--cont">
		<div class="sk-search"><div class="sk-search--input"><input type="text" data-placeholder="Поиск по сайту" value="Поиск по сайту"></div></div>
		<ul class="sk-mybar">
			<li><a href="<?=($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')?>" class="sk-mybar--babylist" title="Список малыша">Список малыша</a></li>
			<li><a rel="nofollow" href="/basket/" class="sk-mybar--cart" title="Моя корзина">Моя корзина <span>(<?=$intCartCnt?>)</span></a></li>
		</ul>
	</div>
</div>

<div class="header">
	<div class="sk-toppane-wrap">
		<div class="sk-toppane">
			<ul class="sk-top-menu">
				<li><?=showNoindex()?><a href="/how-to-buy/" rel="nofollow" title="Помощь покуптелю">Помощь покуптелю</a><?=showNoindex(false)?></li>
				<li class="sk-top-menu_sel"><a href="#" title="" class="sk-popup-open" data-popup-name="callback-form">Обратная связь</a></li>
				<li><a href="#" title="">Покупка в кредит</a></li>
			</ul>
			<ul class="sk-welkom-bar">
				<li>Добро пожаловать</li>
				<li><?
			if($USER -> IsAuthorized())
			{
				echo $USER -> GetFullName();
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
				<li><a href="/how-to-buy/how-to-pay/" title="Купи в кредит"><img src="/bitrix/templates/nmg/img/header/pay-credit.png" alt="Купи в кредит" /></a></li>
			</ul>

			<ul class="sk-mybar">
				<li><a href="<?=($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')?>" class="sk-mybar--babylist" title="Список малыша">Список малыша</a></li>
				<li><a rel="nofollow" href="/basket/" class="sk-mybar--cart" title="Моя корзина">Моя корзина <span>(<?=$intCartCnt?>)</span></a></li>
			</ul>

		</div>	
	</div>
	<div class="sk-logopane">
		<div class="sk-logo"><a href="#" title=""><img src="/bitrix/templates/nmg/img/header/logo.png" alt=""></a></div>
		<div class="sk-search"><div class="sk-search--input" ><input type="text" data-placeholder="Поиск по сайту" value="Поиск по сайту"></div></div>

		<div class="sk-action">
			<div class="sk-action--delivery">
				<a href="#" title="Доставка по всей России"><img src="/bitrix/templates/nmg/img/header/delivery-in-russia.png" alt="Доставка по всей России"></a>
				<a href="#" title="Бесплатно по Москве">Бесплатно по Москве</a>
				<a href="#" class="fl-r" title="Условия для регионов">Условия для регионов</a>								
			</div>
			<div class="sk-action--credit">
				<a href="#" title="Кредит на весь ассортимент магазина"><img src="/bitrix/templates/nmg/img/header/buy-in-credit.png" alt="Кредит на весь ассортимент магазина"></a>
				<a href="#" title="Кредит на весь ассортимент магазина">Кредит на весь ассортимент магазина</a>
			</div>
		</div>

		<div class="sk-phone">
			<img src="/bitrix/templates/nmg/img/header/phone-number.png" alt="(495) 988-32-39"><br>
			<a href="#" title="Заказать обратный звонок">Заказать обратный звонок</a>
		</div>
	</div>
	<div class="popup_block" id="callback-form"  data-popup-head="Обратная связь" style="display: none;">
		Обратная связь
	</div>
</div><?
} else {
?>
<div class="header">
	<div class="header_bg">
		<a href="/" title="Мамин городок"><img src="/bitrix/templates/nmg/img/logo.png" class="logo" width="130" height="84" alt="" /></a>
		<div class="phone_block">
			<div class="oh3"><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/phone.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/worktime.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?></div>
			<p><span><i><a title="Бесплатный звонок" class="showpUp getCallForm" href="#call_popup">Бесплатный звонок</a></i></span><span><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/buyer_help.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?></span></p>
		</div>
		<div class="delivery"><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/includes/delivery.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
		</div>
		<div class="we_accept">
			<a title="Комиссия 0%!" class="tooltip_a" href="/how-to-buy/how-to-pay/"></a>
			<div class="oh3"><span>Мы</span> принимаем</div>
			<img src="/img/visa_mastercard_mg.png" alt="Мы принимаем" />
		</div>
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
		<?=showNoindex(false)?>
		<?
$intCartCnt = 0;
if(CModule::IncludeModule("sale"))
{
	$dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"), false, false, array());
    while ($arItems = $dbBasketItems->Fetch())
		$intCartCnt += $arItems["QUANTITY"];
}
?>
		<ul class="action">
			<li><a class="heart" href="<?=($USER->IsAuthorized()?'/community/user/'.$USER->GetID().'/':'/about-baby-list.php')?>" title="Список малыша">Список<br />малыша</a></li>
			<li><?=showNoindex()?><a class="basket" href="/basket/" title="Корзина">Корзина<span id="cartItemsCnt"><?=$intCartCnt?></span></a><?=showNoindex(false)?></li>
		</ul>
	</div>
</div><?
}?>
<div class="main">
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
	<div class="search_block">
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
	</div>
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
}?>
	<table class="contant_table" cellpadding="0" cellspacing="0">
		<tr><?
if(preg_match("/\/catalog\/.+\/.+\//i", $APPLICATION->GetCurDir())) $HIDE_LEFT_COLUMN = true;

if((!$HIDE_LEFT_COLUMN || ($HIDE_LEFT_COLUMN && $ignoreHideLeftColumn)) || ERROR_404 == "Y")
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
	
	
	if($IS_MAIN || strpos($APPLICATION -> GetCurDir(), "/tools/search/") === 0 || preg_match("/\/community\/user\/\d+\//", $APPLICATION -> GetCurDir()))
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "index_left_col", array(
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
	
	if(strpos($_SERVER["REQUEST_URI"], "catalog") !== false && ERROR_404 != "Y")
	{
		$catal = true;
		CModule::IncludeModule('iblock');
		$arURL = explode('/', $_SERVER["REDIRECT_URL"]);
		
		$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arURL[2], "ACTIVE"=>"Y"), false);
		if($arS = $rsS -> GetNext())
			$current_section_id = $arS["ID"];
		else $current_section_id = -1;
		
		if (count($arURL) > 1 && count($arURL) < 5) $SHOW_FILTER = true;
		
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
	
	if($SHOW_SECTIONS_MENU)
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
		?><?$APPLICATION->IncludeComponent("individ:catalog.filter", "left-filter-layer1", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"FILTER_NAME" => "arrLeftFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"CURRENT_CATALOG_LEVEL" => "1",
	"SECTION_ID" => $current_section_id,
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"LIST_HEIGHT" => "5",
	"TEXT_WIDTH" => "20",
	"NUMBER_WIDTH" => "5",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"SAVE_IN_SESSION" => "N",
	"PRICE_CODE" => array(
	)
	),
	false
);?><?
	} else {
		if ($SHOW_FILTER)
		{
			?><?$APPLICATION->IncludeComponent("individ:catalog.filter", "left-filter", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"FILTER_NAME" => "arrLeftFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"CURRENT_CATALOG_LEVEL" => "2",
	"SECTION_ID" => $current_section_id,
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"LIST_HEIGHT" => "5",
	"TEXT_WIDTH" => "20",
	"NUMBER_WIDTH" => "5",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"SAVE_IN_SESSION" => "N",
	"PRICE_CODE" => array(
	)
	),
	false
);?>
<?
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
			);?><?$APPLICATION->IncludeComponent("bitrix:catalog.filter", "reviews_filter", Array(
	"IBLOCK_TYPE" => "catalog",	// Тип инфо-блока
	"IBLOCK_ID" => "7",	// Инфо-блок
	"FILTER_NAME" => "arrFilter",	// Имя выходящего массива для фильтрации
	"FIELD_CODE" => array(	// Поля
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// Свойства
		0 => "AGE",
		1 => "DEVELOPMENTS",
		2 => "FUNCTIONAL_PURPOSE",
		3 => "",
	),
	"LIST_HEIGHT" => "5",	// Высота списков множественного выбора
	"TEXT_WIDTH" => "20",	// Ширина однострочных текстовых полей ввода
	"NUMBER_WIDTH" => "5",	// Ширина полей ввода для числовых интервалов
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
	"PRICE_CODE" => "",	// Тип цены
	),
	false
);?><?
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
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.filter", "left-filter-title1", array(
	            "IBLOCK_TYPE" => "catalog",
	            "IBLOCK_ID" => "2",
	            "FILTER_NAME" => "arrFilter",
	            "FIELD_CODE" => array(
		            0 => "",
		            1 => "",
	            ),
	            "CURRENT_CATALOG_LEVEL" => "2",
	            "SECTION_ID" => "",
	            "PROPERTY_CODE" => array(
		            0 => "PRICE",
		            1 => "CH_PRODUCER",
		            2 => "",
	            ),
	            "LIST_HEIGHT" => "5",
	            "TEXT_WIDTH" => "20",
	            "NUMBER_WIDTH" => "5",
	            "CACHE_TYPE" => "A",
	            "CACHE_TIME" => "36000000",
	            "CACHE_GROUPS" => "Y",
	            "SAVE_IN_SESSION" => "N",
	            "PRICE_CODE" => array(
	            )
	            ),
	            false
            );?><?
	}?>
				</div><?
	if(ERROR_404 != "Y")
		$APPLICATION->ShowProperty("leftColSocial"); // generates in footer
	
	?>
			</td>
			<td>&nbsp;</td><?
}?>
			<td class="right_sitebar"><?
if(strpos($APPLICATION->GetCurPage(), "/catalog/") === 0 || strpos($APPLICATION->GetCurPage(), "/basket/") === 0)
	$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array("START_FROM" => "0", "PATH" => "", "SITE_ID" => "s1"), false);



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
<div class="bskt">
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/slogan2.php"), array(), array("MODE"=>"html") );?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/phone.php"), array(), array("MODE"=>"html") );?>
</div>
<?else:?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/slogan.php"), array(), array("MODE"=>"html") );?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/phone.php"), array(), array("MODE"=>"html") );?>
<?endif;?>
<?if($IS_HIDE!="Y"):?>
<div class="search">
	    		<?$APPLICATION->IncludeComponent("bitrix:search.form", "search", Array(
	"PAGE" => "#SITE_DIR#tools/search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
	),
	false
);?>
</div> 
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
<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/menu.php');?>
<?if(!$IS_BASKET):?>

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
	"SECTION_USER_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"SECTION_URL" => "",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"ADD_SECTIONS_CHAIN" => "N"
	),
	false
);?>
<?endif;?>
<?if(!$IS_BASKET):?>
<?$APPLICATION->IncludeComponent("bitrix:menu", "main", array(
	"ROOT_MENU_TYPE" => "main",
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

    <div id="CatalogLeftColumn" class="<?if($IS_DETAIL && $catal):?>CatalogLeftNONE<?endif?>">



        <?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/left_menu1.php');?>

        

       
        <?if (!$IS_DETAIL):?>
            &nbsp;
        <?endif?>
        
        
        <?if ($SHOW_SECTIONS_MENU):?>
        <??><?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "sections-left", array(
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
            "SECTION_URL" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_GROUPS" => "Y",
            "ADD_SECTIONS_CHAIN" => "N"
            ),
            false
        );?>
        <?endif?>
        
        <?if ($IS_PARENT_SECTION===true || $IS_COMUNITY):?>
          
            <? // фильтр для первого уровня ?>
            <?
			if ($SHOW_FILTER):?>
                
                <?$APPLICATION->IncludeComponent("individ:catalog.filter", "left-filter-layer1", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"FILTER_NAME" => "arrLeftFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"CURRENT_CATALOG_LEVEL" => "1",
	"SECTION_ID" => $current_section_id,
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"LIST_HEIGHT" => "5",
	"TEXT_WIDTH" => "20",
	"NUMBER_WIDTH" => "5",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"SAVE_IN_SESSION" => "N",
	"PRICE_CODE" => array(
	)
	),
	false
);?>
				
				
            <?endif?>
            
			<?/*
            <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
            "TYPE" => "catalog_left",
            "NOINDEX" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0"
            ),
            false
            );?>
            
			
			<?$APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_sections", array("COUNT"=>2, "SECTION_ID"=> $current_section_id,"ELEMENT_ID"=>""));?>
			
            <?$APPLICATION->IncludeFile('/inc/cat_vo.php');?>
            <?$APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $current_section_id));?>
			*/?>
        <?else:?>  
        
            <?if ($SHOW_FILTER):?> 
                <?$APPLICATION->IncludeComponent("individ:catalog.filter", "left-filter", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "2",
	"FILTER_NAME" => "arrLeftFilter",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"CURRENT_CATALOG_LEVEL" => "2",
	"SECTION_ID" => $current_section_id,
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "",
	),
	"LIST_HEIGHT" => "5",
	"TEXT_WIDTH" => "20",
	"NUMBER_WIDTH" => "5",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"SAVE_IN_SESSION" => "N",
	"PRICE_CODE" => array(
	)
	),
	false
);?>
				<br>
			<?/*	<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
            "TYPE" => "catalog_left",
            "NOINDEX" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0"
            ),
            false
            );?>
            
			<?$APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_sections", array("COUNT"=>2, "SECTION_ID"=> $current_section_id,"ELEMENT_ID"=>""));?>
			
            <?$APPLICATION->IncludeFile('/inc/cat_vo.php');?>
            <?$APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $current_section_id));?>*/?>
            <?endif?>
        <?endif?>
        
        <?if($IS_REVIEWS):?>
			<div class="left-column-filter">
			<?$APPLICATION->IncludeComponent("individ:menu.section.list", "reviews_filter", Array(
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
			
			<?$APPLICATION->IncludeComponent("bitrix:catalog.filter", "reviews_filter", Array(
	"IBLOCK_TYPE" => "catalog",	// Тип инфо-блока
	"IBLOCK_ID" => "7",	// Инфо-блок
	"FILTER_NAME" => "arrFilter",	// Имя выходящего массива для фильтрации
	"FIELD_CODE" => array(	// Поля
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// Свойства
		0 => "AGE",
		1 => "DEVELOPMENTS",
		2 => "FUNCTIONAL_PURPOSE",
		3 => "",
	),
	"LIST_HEIGHT" => "5",	// Высота списков множественного выбора
	"TEXT_WIDTH" => "20",	// Ширина однострочных текстовых полей ввода
	"NUMBER_WIDTH" => "5",	// Ширина полей ввода для числовых интервалов
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
	"PRICE_CODE" => "",	// Тип цены
	),
	false
);?>
			<br>
			</div>
		<?endif;?>
		
		<?if($SUBSCRIBE):?>
		<div class="left-column-filter">
			 <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
            "TYPE" => "catalog_left",
            "NOINDEX" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0"
            ),
            false
            );?>
            
			<?$APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_sections", array("COUNT"=>2, "SECTION_ID"=> $current_section_id,"ELEMENT_ID"=>""));?>
			
            <?$APPLICATION->IncludeFile('/inc/cat_vo.php');?>

            <?  $APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $current_section_id)); ?>
		</div>
		<?endif;?>
		
		<?//http://mamingorodok.individ.ru/catalog/title/ххх/ - фильтр?>
		<?if($FILTER_TITLE):?>
		<div class="left-column-filter">
			<?$APPLICATION->IncludeComponent("bitrix:catalog.filter", "left-filter-title1", array(
	            "IBLOCK_TYPE" => "catalog",
	            "IBLOCK_ID" => "2",
	            "FILTER_NAME" => "arrFilter",
	            "FIELD_CODE" => array(
		            0 => "",
		            1 => "",
	            ),
	            "CURRENT_CATALOG_LEVEL" => "2",
	            "SECTION_ID" => "",
	            "PROPERTY_CODE" => array(
		            0 => "PRICE",
		            1 => "CH_PRODUCER",
		            2 => "",
	            ),
	            "LIST_HEIGHT" => "5",
	            "TEXT_WIDTH" => "20",
	            "NUMBER_WIDTH" => "5",
	            "CACHE_TYPE" => "A",
	            "CACHE_TIME" => "36000000",
	            "CACHE_GROUPS" => "Y",
	            "SAVE_IN_SESSION" => "N",
	            "PRICE_CODE" => array(
	            )
	            ),
	            false
            );?>
			
			<br>
		</div>
		<?endif;?>
		
		<?if(!$HIDE_LEFT_COLUMN):?>
		
			 <?$APPLICATION->IncludeComponent("bitrix:advertising.banner", ".default", array(
            "TYPE" => "catalog_left",
            "NOINDEX" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0"
            ),
            false
            );?>
			
			<?$APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_sections", array(
	"COUNT" => "2",
	"SECTION_ID" => $current_section_id,
	"ELEMENT_ID" => ""
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
			
            <?$APPLICATION->IncludeFile('/inc/cat_vo.php');?>
			<?//echo $current_section_id;?>
            <? $APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $current_section_id),false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)); ?>
			
		<?endif;?>
    </div>
<?endif?>
<?if (!$IS_DETAIL):?>
    <div id="CatalogCenterColumn" class="LExist<?if ($HIDE_LEFT_COLUMN):?> wide<?endif?>">   
<?endif?><?
}

?>