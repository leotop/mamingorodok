<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$APPLICATION->AddHeadScript("/bitrix/templates/nmg_order/js/jquery-1.8.2.min.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg_order/js/select2.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg_order/js/jquery.icheck.min.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg_order/js/main.js");

$APPLICATION->AddHeadScript("/bitrix/templates/nmg/js/jquery.easing-1.3.pack.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg/js/jquery.mousewheel-3.0.4.pack.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg/js/fancybox/jquery.fancybox-1.3.4.js");

$APPLICATION->AddHeadScript("/bitrix/templates/nmg/js/scripts.js");
$APPLICATION->AddHeadScript("/bitrix/templates/nmg/js/script_cache.js");
$APPLICATION->AddHeadScript('/bitrix/templates/nmg/js/jquery.jqtransform.js');
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?$APPLICATION->ShowTitle(false)?></title>
		<link href="/bitrix/templates/nmg/template_styles.css" type="text/css" rel="stylesheet" />
		<? $APPLICATION->ShowHead(); ?>

		<link href="/bitrix/templates/nmg_order/css/style.css" rel="stylesheet" type="text/css" />
		<link href="/bitrix/templates/nmg_order/css/select2.css" rel="stylesheet" type="text/css" />
		<link href="/bitrix/templates/nmg_order/css/ichek/ichek.css" rel="stylesheet" type="text/css" />

		<link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/jqtransform.css" />
		<link rel="stylesheet" type="text/css" href="/bitrix/templates/nmg/style_blog.css" />
	</head>
<body>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="wrap">
	<div class="mg-header-wrap">
		<div class="sk-toppane-wrap">
			<div class="sk-toppane">
				<ul class="sk-top-menu">
					<li><?=showNoindex()?><a href="/how-to-buy/" title="Помощь покупателю">Помощь покупателю</a><?=showNoindex(false)?></li>
					<li class="sk-top-menu_sel"><a href="#" title="Обратная связь" id="feedbackFormHref">Обратная связь</a></li>
					<li class="sk-top-menu_last"><a href="/credit/" title="">Покупка в кредит</a></li>
				</ul>
				<ul class="sk-welkom-bar">
					<li>Добро пожаловать <?=$USER -> GetFullName()?></li>
					<li><?
						if($USER -> IsAuthorized())
						{
							echo '<a href="'.$APPLICATION->GetCurPage().'?logout=yes">Выход</a>';
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
				</ul>
			</div>
		</div>

		<div class="mg-header newHewader">
			<div class="mg-checkout-logo"><a href="#"><img src="/bitrix/templates/nmg_order/images/checkout-logo.png"></a></div>

			<div class="sk-hotLine">
				Бесплатный телефон для регионов<br>
				<strong>8-800-323-3934</strong>
			</div>

			<div class="sk-phone sk-phone_newHed">
				<a class="showpUp getCallForm" href="#call_popup" title="Заказать обратный звонок">Заказать обратный звонок</a><br>
				<span>(495)</span> 988-32-39
			</div>

		</div>
	</div>
<?
if(false) {


IncludeTemplateLangFile(__FILE__);
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?$APPLICATION->ShowHead();?>
<?if (!isset($_GET["print_course"])):?>
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH."/print_style.css"?>" type="text/css" media="print" />
<?else:?>
	<meta name="robots" content="noindex, follow" />
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH."/print_style.css"?>" type="text/css" />
<?endif?>
<script type="text/javascript">
function ShowSwf(sSwfPath, width1, height1)
{
	var scroll = 'no';
	var top=0, left=0;
	if(width1 > screen.width-10 || height1 > screen.height-28)
		scroll = 'yes';
	if(height1 < screen.height-28)
		top = Math.floor((screen.height - height1)/2-14);
	if(width1 < screen.width-10)
		left = Math.floor((screen.width - width1)/2);
	width = Math.min(width1, screen.width-10);
	height = Math.min(height1, screen.height-28);
	window.open('<?=SITE_TEMPLATE_PATH."/js/swfpg.php"?>?width='+width1+'&height='+height1+'&img='+sSwfPath,'','scrollbars='+scroll+',resizable=yes, width='+width+',height='+height+',left='+left+',top='+top);
}
</script>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH."/js/imgshw.js"?>"></script>
<title><?$APPLICATION->ShowTitle()?></title>
</head>

<body>



<div id="learning-page-wrapper">

<div id="panel">
	<?$APPLICATION->ShowPanel();?>
</div>

<table id="outer" cellspacing="0" cellpadding="0">
	<tr height="91">
		<td>
			<table id="header">
				<tr>
					<td id="logo"><?=GetMessage("LEARNING_LOGO_TEXT")?></td>
					<td id="logotext"><?$APPLICATION->ShowProperty("learning_course_name")?>&nbsp;</td>
				</tr>
			</table>

			<table id="toolbar">
				<tr>
					<td id="toolbar_icons">
						<a href="<?$APPLICATION->ShowProperty("learning_test_list_url")?>"><img src="<?=SITE_TEMPLATE_PATH."/icons/tests.gif"?>" width="25" height="25" border="0" title="<?=GetMessage("LEARNING_PASS_TEST")?>"></a><img src="<?=SITE_TEMPLATE_PATH."/icons/line.gif"?>" width="11" height="25" border="0"><a href="<?$APPLICATION->ShowProperty("learning_gradebook_url")?>" title="<?=GetMessage("LEARNING_GRADEBOOK")?>"><img src="<?=SITE_TEMPLATE_PATH."/icons/gradebook.gif"?>" width="25" height="25" border="0"></a><img src="<?=SITE_TEMPLATE_PATH."/icons/line.gif"?>" width="11" height="25" border="0"><a href="<?$APPLICATION->ShowProperty("learning_course_contents_url")?>" title="<?=GetMessage("LEARNING_ALL_COURSE_CONTENTS")?>"><img src="<?=SITE_TEMPLATE_PATH."/icons/materials.gif"?>" width="25" height="25" border="0"></a><img src="<?=SITE_TEMPLATE_PATH."/icons/line.gif"?>" width="11" height="25" border="0"><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("print_course=Y", array("print_course")), false)?>" rel="nofollow" title="<?=GetMessage("LEARNING_PRINT_PAGE")?>"><img src="<?=SITE_TEMPLATE_PATH."/icons/printer_b_b.gif"?>" width="25" height="25" border="0"></a>
					</td>
					<td id="toolbar_title">
						<div id="container">
							<div id="title"><?$APPLICATION->ShowTitle()?></div>
							<div id="complete">
								<span title="<?=GetMessage("LEARNING_CURRENT_LESSON")?>"><?$APPLICATION->ShowProperty("learning_lesson_current")?></span>&nbsp;/&nbsp;<span title="<?=GetMessage("LEARNING_ALL_LESSONS")?>"><?$APPLICATION->ShowProperty("learning_lesson_count")?></span>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<div id="workarea" style="height: 100%"><?
}
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
);
?>