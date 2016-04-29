<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?ob_start();?>

<?$ElementID=$APPLICATION->IncludeComponent(
	"individ:catalog.element",
	"",
	Array(
 		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
 		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
 		"PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
 		"DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
 		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
 		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
		"LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
		"LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
		"LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
		"LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],

 		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
 		"ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
 		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
 		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
	),
	$component
);?>

<?
//////////////////////////////////////////////////////////
// выводим ссылку уже есть или добавить в список малыша //
// и список сравнения                                   //
//////////////////////////////////////////////////////////
global $USER;
$user_id = $USER->GetID();
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"], "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), false, false, array("ID", "IBLOCK_ID"));    
if($obEl = $dbEl->GetNext())
    $add_to_wish_list_link = '<div class="action" id="BabyList"><div class="DIcon" ></div> <a target="_blank" href="/community/user/'.$user_id.'/">Уже в списке малыша</a><div class="clear"></div></div>';
else
    $add_to_wish_list_link = '<div class="action" id="BabyList"><div class="DIcon" ></div> <a class="add" href="#">В список малыша</a><div class="clear"></div></div>';

$content = ob_get_contents();    
if ($user_id > 0)
    $content = str_replace('#ADD_TO_WISH_LIST#', $add_to_wish_list_link, $content);
else
    $content = str_replace('#ADD_TO_WISH_LIST#', '<div class="action" id="BabyList"><div class="DIcon" ></div> <a class="showpUp" href="#messageNoUser1">В список малыша</a><div class="clear"></div></div>', $content);    

foreach($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"] as $compare_list_item):
    $arCompareList[] = $compare_list_item["ID"];
endforeach;

if (in_array($arResult["VARIABLES"]["ELEMENT_ID"], $arCompareList))
    $add_to_compare_list_link = '<div class="action" id="CompareList"><div class="DIcon" ></div> <a href="/catalog/compare/">Уже в списке сравнения</a><div class="clear"></div></div>';
else
    $add_to_compare_list_link = '<div class="action" id="CompareList"><div class="DIcon" ></div> <a class="add" href="#">В список сравнения</a><span style="display:none;">'.$arResult["VARIABLES"]["ELEMENT_ID"].'</span><div class="clear"></div></div>';

$content = str_replace('#ADD_TO_COMPARE_LIST#', $add_to_compare_list_link, $content);    
    
ob_end_clean(); 

echo $content;    

///////////////////////////////////////////////////////////////////
?>

<?if (!$_REQUEST["IS_AJAX"]):?>

    <? // аксессуары 
    $db_props = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $arResult["VARIABLES"]["ELEMENT_ID"], array("sort" => "asc"), Array("CODE"=>"ACCESSORIES"));
    while($ar_props = $db_props->Fetch())
    {
        $arAccIDs[] = $ar_props["VALUE"];
    }
    ?>
    <?if (!empty($arAccIDs[0])):?>
    <?$GLOBALS["arrAccFilter"]["ID"] = $arAccIDs;?>
    <?$APPLICATION->IncludeComponent("bitrix:news.list", "accessories-items", array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => CATALOG_IBLOCK_ID,
        "NEWS_COUNT" => "99",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "arrAccFilter",
        "FIELD_CODE" => array(
            0 => "",
            1 => "NAME",
            2 => "PREVIEW_PICTURE",
            3 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "RATING",
            1 => "OLD_PRICE",
            2 => "PRICE",
            3 => "",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );
        ?>  
    <?endif?>

<div class="CatalogCenterColumn RExist">
<a name="review"></a>
    <div class="goods GoodReview">       
        <?
        /////////////////////////////////////////////
        // Обновляем рейтинг после отправки отзыва //
        /////////////////////////////////////////////
		$rating_add = -1;
		$rating_add = intval($_POST["rating"]);
		
        if ($rating_add > 0)
        {
			

	
            // получаем текущий общий рейтинг и количество голосов
            $dbEl = CIBlockElement::GetList(Array(), Array("ID"=>$arResult["VARIABLES"]["ELEMENT_ID"], "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_RATING_SUM", "PROPERTY_VOTES"));    
            if($obEl = $dbEl->GetNext())    
            {           
                $rating_sum = $obEl["PROPERTY_RATING_SUM_VALUE"] + $rating_add;
                $votes = $obEl["PROPERTY_VOTES_VALUE"] + 1;
                
                // забиваем новые значения суммы оценок и голосов (рейтинг считается автоматически при апдейте)
                $arSetProperties = array(
                    "RATING_SUM" => $rating_sum,
                    "VOTES" => $votes
                );
                CIBlockElement::SetPropertyValuesEx($arResult["VARIABLES"]["ELEMENT_ID"], false, $arSetProperties);
            }            
        }
        ?>
        
        <?$APPLICATION->IncludeComponent("individ:forum.topic.reviews2", "all-comments", array(
            "FORUM_ID" => "1",
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
            "POST_FIRST_MESSAGE" => "N",
            "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                        [url=#LINK#]#TITLE#[/url]
                        #BODY#",
            "URL_TEMPLATES_READ" => "",
            "URL_TEMPLATES_DETAIL" => "",
            "URL_TEMPLATES_PROFILE_VIEW" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "0",
            "MESSAGES_PER_PAGE" => "10",
            "PAGE_NAVIGATION_TEMPLATE" => "",
            "DATE_TIME_FORMAT" => "d.m.Y",
            "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
            "USE_CAPTCHA" => "Y",
            "PREORDER" => "N",
            "SHOW_LINK_TO_FORUM" => "N",
            "FILES_COUNT" => "2"
            ),
            false
        );?>  
		
		
		<h2>Ваш отзыв</h2>
		
		<div class="preformcomment" id="postform"><b>У вас есть этот товар?</b> Ваше мнение будет интересно многим. Поставьте оценку этому товару и напишите свой отзыв о нем. Будьте вежливы, все сообщения проверяются перед публикацией (<a href="?">правила публикации</a>).</div>
		
        <?//if ($user_id > 0) {?>
            
            <?$APPLICATION->IncludeComponent("individ:forum.topic.reviews", "add-comment", array(
                "FORUM_ID" => "1",
                "IBLOCK_TYPE" => $arResult["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arResult["IBLOCK_ID"],
                "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
                "POST_FIRST_MESSAGE" => "N",
                "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                            [url=#LINK#]#TITLE#[/url]
                            #BODY#",
                "URL_TEMPLATES_READ" => "",
                "URL_TEMPLATES_DETAIL" => "",
                "URL_TEMPLATES_PROFILE_VIEW" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "MESSAGES_PER_PAGE" => "0",
                "PAGE_NAVIGATION_TEMPLATE" => "",
                "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
                "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                "USE_CAPTCHA" => "Y",
                "PREORDER" => "Y",
                "SHOW_LINK_TO_FORUM" => "N",
                "FILES_COUNT" => "2"
                ),
                false
            );
        /*} else {
            ?><div class="preformcomment">
				<a href="/personal/registaration/" title="зарегистрируйтесь">Зарегистрируйтесь</a> или <a href="/personal/profile/" title="авторизуйтесь">авторизуйтесь</a>, чтобы написать отзыв.
			</div>
			<?
        }*/?>
    
    </div>
    

        
    <? // похожие товары
    $db_props = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $arResult["VARIABLES"]["ELEMENT_ID"], array("sort" => "asc"), Array("CODE"=>"LIKE"));
    while($ar_props = $db_props->Fetch())
    {
        $arLikeIDs[] = $ar_props["VALUE"];
    }
    ?>

    <?if (!empty($arLikeIDs[0])):?>
    <?$GLOBALS["arrLikeFilter"]["ID"] = $arLikeIDs;?>
    <?$APPLICATION->IncludeComponent("bitrix:news.list", "like-items", array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => CATALOG_IBLOCK_ID,
        "NEWS_COUNT" => "99",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "arrLikeFilter",
        "FIELD_CODE" => array(
            0 => "",
            1 => "NAME",
            2 => "PREVIEW_PICTURE",
            3 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "RATING",
            1 => "OLD_PRICE",
            2 => "PRICE",
            3 => "",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );
        ?>
    <?endif?>
    
	<?
		//echo $arResult["VARIABLES"]["ELEMENT_ID"];
		$arFilter = Array(   
			"IBLOCK_ID"=>CATALOG_IBLOCK_ID,    
			"ACTIVE"=>"Y", 
			"ID"=>$arResult["VARIABLES"]["ELEMENT_ID"]
			);
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false);
		if($ar_fields = $res->GetNextElement()){  
			$arPr = $ar_fields->GetProperties();
			?><div class="top15"><?
			echo  $arPr["SEO_TEXT"]["VALUE"]["TEXT"];
			?></div><?
		}
	?>

</div>
<div class="CatalogRightColumn">

	<?$APPLICATION->IncludeComponent("individ:rewiews.show", "catalog_element", array("COUNT"=>1, "SECTION_ID"=> $arResult["VARIABLES"]["SECTION_ID"],"ELEMENT_ID"=>$arResult["VARIABLES"]["ELEMENT_ID"]));?>
    <?$APPLICATION->IncludeFile('/inc/cat_vo.php');?>
	<?$APPLICATION->IncludeComponent("individ:blog.discuss", "", array("COUNT"=>3, "SECTION_ID"=> $arResult["VARIABLES"]["SECTION_ID"]));?>
</div>
<div class="clear"></div>




<?endif?>
<?if(intval($user_id)==0):?>
	<div id="messageNoUser1" class="CatPopUp">
<div class="white_plash">
<div class="exitpUp"></div>
<div class="cn tl"></div>
<div class="cn tr"></div>
<div class="content">
<div class="content">
<div class="content">
<div class="clear"></div>
	Для того чтобы добавить товар в "Список малыша" требуется <a href="/personal/registaration/">регистрация</a>.
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>
<?endif;?>