<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?ob_start();?>

<?$arRess=$APPLICATION->IncludeComponent(
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
		"SET_STATUS_404" => "Y",
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
$content = ob_get_contents();
ob_end_clean(); 
?>
<?$ElementID=intval($arRess["ID"]);?>
<?
//////////////////////////////////////////////////////////
// ������� ������ ��� ���� ��� �������� � ������ ������ //
// � ������ ���������                                   //
//////////////////////////////////////////////////////////

if($ElementID > 0)
{

	global $USER;
	$user_id = intval($USER->GetID());
	$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), false, false, array("ID", "IBLOCK_ID"));    
	if($obEl = $dbEl->GetNext())
	$add_to_wish_list_link = '<div class="action" id="BabyList"><div class="DIcon" ></div> <a target="_blank" href="/community/user/'.$user_id.'/">��� � ������ ������</a><div class="clear"></div></div>';
	else
	$add_to_wish_list_link = '<div class="action" id="BabyList"><div class="DIcon" ></div> <a class="add" href="#">� ������ ������</a><div class="clear"></div></div>';



		
	// �������� ������ ������
	if ($user_id > 0)
	{
		CModule::IncludeModule('socialnetwork');
		$arFriends = array();
		$dbFriends = CSocNetUserRelations::GetRelatedUsers($user_id, SONET_RELATIONS_FRIEND, false);
		while ($arFriend = $dbFriends->GetNext())
		{
			$arFriends[] = $arFriend;
			if($arFriend["FIRST_USER_ID"]!=$user_id)
			$arFriendsIDs[] = $arFriend["FIRST_USER_ID"];
		}            
	}
	// �������� ������ ������������� ������� ����� ���� �����
	
	$arFriendsIDsI = $arFriendsIDs;
	$arFriendsIDsI[] = $user_id;
	
	$arUsersWantIDs = array();
	$users_want = 0;
	$users_friends_want = 0;
	$SHOWCOUNTPAGE = 10;
	$COUNTPAGEHAVEFRIENDS = 0;
	$COUNTPAGEHAVE = 0;
	$COUNTPAGEWANTFRIENDS  = 0;
	$COUNTPAGEWANT = 0;
	$dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
		
	while($obEl = $dbEl->GetNext())    
	{         
		//print_R($obEl);
		$arUsersWantIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
		$users_want++;
		// �������� �� �� ������
	}
	$arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
	$COUNTPAGEWANT = $dbEl->nEndPage;
	$users_want = $dbEl->nSelectedCount;

	$users_friends_want = 0;
	if(count($arFriendsIDs)>0){
		$dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));    
		while($obEl = $dbEl->GetNext())    
		{         
				$users_friends_want++;   
				
				$arUsersWantFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
				//die(print_R($obEl["PROPERTY_USER_ID_VALUE"]));
		}
		$arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
		$COUNTPAGEWANTFRIENDS = $dbEl->nEndPage;
		$users_friends_want = $dbEl->nSelectedCount;
	}
	
	// �������� ������ ������������� ������� ��� ����� ���� �����
	$users_have = 0;
	$users_friends_have = 0;
	
	$dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));    
	while($obEl = $dbEl->GetNext())    
	{           
		if(!in_array($obEl["PROPERTY_USER_ID_VALUE"],$arUsersHaveIDs))
		{
			$arUsersHaveIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
			$users_have++;
		}
	}
	
	$arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
	$COUNTPAGEHAVE = $dbEl->nEndPage;
	$users_have = $dbEl->nSelectedCount;
		
	// �������� ������ ������������� ������� ��� ����� ���� �����
	$users_friends_have = 0;
	if(count($arFriendsIDs)>0):
	$dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));    
	while($obEl = $dbEl->GetNext())    
	{           
			if(!in_array($obEl["PROPERTY_USER_ID_VALUE"],$arUsersHaveFriendsIDs)){
				$users_friends_have++;     
				$arUsersHaveFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
			}
	}
	$arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
	$COUNTPAGEHAVEFRIENDS = $dbEl->nEndPage;
	$users_friends_have = $dbEl->nSelectedCount;
	endif;
	
	$uwant = '<a href="#FriendsWant" class="showpUp">'.$users_friends_want.' '.WordsForNumbers($users_friends_want, '����', '�����', '������').'</a><br><a href="#UsersWant" class="showpUp">'.$users_want.' '.WordsForNumbers($users_want, '������������', '������������', '�������������').'</a>';

	$uhave = '<a href="#FriendsHave" class="showpUp">'.$users_friends_have.' '.WordsForNumbers($users_friends_have, '����', '�����', '������').'</a><br><a href="#UsersHave" class="showpUp">'.$users_have.' '.WordsForNumbers($users_have, '������������', '������������', '�������������').'</a>';
	
	$content = str_replace(array('<!--#UWANT#-->', '<!--#UHAVE#-->'), array($uwant, $uhave), $content);
	
	
	$count = 0;
	$db_props = CacheRatingReviews::GetByID($arResult["VARIABLES"]["ELEMENT_ID"]);
	if(is_array($db_props))
	{
		$count = $db_props["FORUM_MESSAGE_CNT"];
		$rating = showRating($db_props["RATING"]);
	}
	if($count>0)
		$textR = '<a href="#reports" class="dotted_a">'.$count.' '.RevirewsLang($count).'</a>';
	else
		$textR = '<a href="#comment" class="dotted_a">'.RevirewsLang($count).'</a>';

				
			   



	 $content = str_replace('#REPORT_COUNT#', $textR, $content);

	if ($user_id > 0)
		$content = str_replace('#ADD_TO_WISH_LIST#', $add_to_wish_list_link, $content);
	else
		$content = str_replace('#ADD_TO_WISH_LIST#', '<div class="action" id="BabyList"><div class="DIcon" ></div> <a class="showpUp" href="#messageNoUser1">� ������ ������</a><div class="clear"></div></div>', $content);    

	foreach($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"] as $compare_list_item):
		$arCompareList[] = $compare_list_item["ID"];
	endforeach;

	if (in_array($arResult["VARIABLES"]["ELEMENT_ID"], $arCompareList))
		$add_to_compare_list_link = '<div class="action" id="CompareList"><div class="DIcon" ></div> <a href="/catalog/compare/">��� � ������ ���������</a><div class="clear"></div></div>';
	else
		$add_to_compare_list_link = '<div class="action" id="CompareList"><div class="DIcon" ></div> <a class="add" href="#">� ������ ���������</a><span style="display:none;">'.$arResult["VARIABLES"]["ELEMENT_ID"].'</span><div class="clear"></div></div>';

	$content = str_replace('#ADD_TO_COMPARE_LIST#', $add_to_compare_list_link, $content);    

	$content = str_replace('#RATING#', $rating, $content);  
}  
	


echo $content;    

///////////////////////////////////////////////////////////////////
?>

<?if (!$_REQUEST["IS_AJAX"]):?>

    <? // ���������� 
    
    ?>
    <?if (count($arRess["PROPERTIES"]["ACCESSORIES"]["VALUE"])>0):?>
    <?$GLOBALS["arrAccFilter"]["ID"] = $arRess["PROPERTIES"]["ACCESSORIES"]["VALUE"];?>
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
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
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
        "PAGER_TITLE" => "�������",
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
        // ��������� ������� ����� �������� ������ //
        /////////////////////////////////////////////
		$rating_add = -1;
		$rating_add = intval($_POST["rating"]);
		
        if ($rating_add > 0)
        {
			

	
            // �������� ������� ����� ������� � ���������� �������
            $dbEl = CIBlockElement::GetList(Array(), Array("ID"=>$arResult["VARIABLES"]["ELEMENT_ID"], "IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "PROPERTY_RATING_SUM", "PROPERTY_VOTES"));    
            if($obEl = $dbEl->GetNext())    
            {           
                $rating_sum = $obEl["PROPERTY_RATING_SUM_VALUE"] + $rating_add;
                $votes = $obEl["PROPERTY_VOTES_VALUE"] + 1;
                
                // �������� ����� �������� ����� ������ � ������� (������� ��������� ������������� ��� �������)
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
            "CACHE_TIME" => "3600",
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
		
		
		<h2>��� �����</h2>
		
		<div class="preformcomment" id="postform"><b>� ��� ���� ���� �����?</b> ���� ������ ����� ��������� ������. ��������� ������ ����� ������ � �������� ���� ����� � ���. ������ �������, ��� ��������� ����������� ����� ����������� (<a href="?">������� ����������</a>).</div>
		
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
				<a href="/personal/registaration/" title="�����������������">�����������������</a> ��� <a href="/personal/profile/" title="�������������">�������������</a>, ����� �������� �����.
			</div>
			<?
        }*/?>
    
    </div>
    

        
   
    <?if (is_array($arRess["PROPERTIES"]["LIKE"]["VALUE"])):?>
    <?$GLOBALS["arrLikeFilter"]["ID"] = $arRess["PROPERTIES"]["LIKE"]["VALUE"];?>
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
        "CACHE_TYPE" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "Y",
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
        "PAGER_TITLE" => "�������",
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
	if(!empty($arRess["PROPERTIES"]["SEO_TEXT"]["VALUE"]["TEXT"])){
			?><div class="top15"><?
			echo  $arRess["PROPERTIES"]["SEO_TEXT"]["VALUE"]["TEXT"];
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

<?
// ������ ���� �������������, ������� ����� ��� �����    
$Want = array_unique(array_merge($arUsersWantIDs,$arUsersWantFriendsIDs));
$Have = array_unique(array_merge($arUsersHaveIDs,$arUsersHaveFriendsIDs));
$arAllUsers = array_unique(array_merge($Want, $Have));
$arFilter = array(
    "ID" => implode('|', $arAllUsers)
);
$obUsers = CUser::GetList(($by="personal_country"), ($order="desc"),  $arFilter);
while($rs_user = $obUsers->Fetch())
{
    $arGetUsersByID[$rs_user["ID"]] = $rs_user;
}
?>
<?
// $SHOWCOUNTPAGE = 3;
	// $COUNTPAGEHAVEFRIENDS = 0;
	// $COUNTPAGEHAVE = 0;
	// $COUNTPAGEWANTFRIENDS  = 0;
	// $COUNTPAGEWANT = 0;
?>
<div id="UsersWant" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">������������ �����</div>
		<div class="addInfo">
        <?
		$i=0;
		//print_R($arUsersWantIDs);
		//echo "<br><br>";
		foreach($arUsersWantIDs as $user):?>
            <div class="friend">
				<?//print_R($arGetUsersByID[$user]["PERSONAL_PHOTO"]); echo "----";?>
                <?if($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">��������� �����</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
		</div>
        <br>
		<?if($COUNTPAGEWANT>1):?>
		<div class="user_more_block">
			<a href="#userWant" class="grey showMoreElement" page_max="<?=$COUNTPAGEWANT?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >���������</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userWantAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >�������� ����</a>
		</div>
		<?endif;?>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="FriendsWant" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">������ �����</div>
		<div class="addInfo">
        <?
		foreach($arUsersWantFriendsIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">��������� �����</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif;?>
        <?endforeach;?>
        <div class="clear"></div>
		</div>
        <br>
		<?if($COUNTPAGEWANTFRIENDS>1):?>
		<div class="user_more_block">
			<a href="#userWantFriends" class="grey showMoreElement" page_max="<?=$COUNTPAGEWANTFRIENDS?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >���������</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userWantFriendsAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >�������� ����</a>
		</div>
		<?endif;?>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="UsersHave" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">������������ �����</div>
		<div class="addInfo">
        <?
		$i=0;
		foreach($arUsersHaveIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">��������� �����</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
		</div>
        <br>
		<?if($COUNTPAGEHAVEFRIENDS>1):?>
		<div class="user_more_block">
			<a href="#userHave" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVEFRIENDS?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >���������</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userHaveAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >�������� ����</a>
		</div>
		<?endif;?>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="FriendsHave" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">������ �����</div>
		<div class="addInfo">
        <?
		$i=0;
		foreach($arUsersHaveFriendsIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
				<div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">��������� �����</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
		</div>
        <br>
		<?if($COUNTPAGEHAVE>1):?>
		<div class="user_more_block">
			<a href="#userHaveFriends" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >���������</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userHaveFriendsAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>"  element_id="<?=$ElementID?>" >�������� ����</a>
		</div>
		<?endif;?>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>


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
	��� ���� ����� �������� ����� � "������ ������" ��������� <a href="/personal/registaration/">�����������</a>.
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>
<?endif;?>
