<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
<meta name="robots" content="all" />
<?$APPLICATION->ShowMeta("keywords")?>
<?$APPLICATION->ShowMeta("description")?>
<?$APPLICATION->ShowCSS();?>
<?$APPLICATION->ShowHeadStrings();?>
<?$APPLICATION->ShowHeadScripts();?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.min.js');?>
<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.jqtransform.js');?>
	<!--<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />-->
	
<title><?$APPLICATION->ShowTitle()?></title>	


<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />

<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie6.css" />
<![endif]-->
<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie7.css" />
<![endif]-->
<!--[if IE 9]>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie9.css" />
<![endif]-->


<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/recommended.js"></script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jcarousellite_1.0.1.pack.js"></script>

<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script.js"></script>

<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/fancybox/jquery.fancybox-1.3.4.css" />
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/jqtransform.css" />
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/style_blog.css" />

<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/chrome.css" />



</head>

<body>
<?if($USER->IsAdmin()):
$APPLICATION->ShowPanel();
endif;?>
<div class="container">
<div class="base">
<div class="header">
<?if($IS_MAIN):?>
<div class="logo"></div>
<?else:?>
<a class="logo" href="/"></a>
<?endif?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/slogan.php"), array(), array("MODE"=>"html") );?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/phone.php"), array(), array("MODE"=>"html") );?>
<?if($IS_HIDE!="Y"):?>
<div class="search">
	    		<?$APPLICATION->IncludeComponent("bitrix:search.form", "search", Array(
	"PAGE" => "#SITE_DIR#tools/search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
	),
	false
);?>
</div> 
<?endif;?>

<div class="header_right">
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
	"REGISTER_URL" => "/personal/auth.php",	// Страница регистрации
	"PROFILE_URL" => "/personal/",	// Страница профиля
	"SHOW_ERRORS" => "N",	// Показывать ошибки
	),
	false
);?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket.php"), array(), array("MODE"=>"html") );?>
</div>
</div>
<div class="clear"></div>
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/menu.php');?>
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

<? if(!$IS_MAIN):?>
<div id="WorkArea">
<?endif;?> 
