<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
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
	<!--<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />-->
	
	


<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/recomend-lists.css" />
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/cloud-zoom.css" />

<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie6.css" />
<![endif]-->
<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie7.css" />
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie8.css" />
<![endif]-->
<!--[if IE 9]>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/ie9.css" />
<![endif]-->


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
<?/*if($USER->IsAdmin()):*/
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
    $IS_COMUNITY = true;
    
?>


<?if(!$HIDE_LEFT_COLUMN):?>
 <?if(strpos($_SERVER["REQUEST_URI"], "catalog") !== false)
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
		<? $APPLICATION->ShowProperty("leftMenuHtml"); // generates in footer ?>


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
        
        <?if ($IS_PARENT_SECTION || $IS_COMUNITY):?>
          
            <? // фильтр для первого уровня ?>
            <?if ($SHOW_FILTER):?>
                
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
<?endif?>
