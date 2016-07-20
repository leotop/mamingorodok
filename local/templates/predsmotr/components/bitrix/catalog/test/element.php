<?

    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

    CModule::IncludeModule("iblock");

    if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
    {
        $rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arResult["VARIABLES"]["SECTION_CODE"], "ACTIVE"=>"Y"), false);
        if($arS = $rsS -> GetNext())
            $arResult["VARIABLES"]["SECTION_ID"] = $arS["ID"];
    }

    if(strlen($arResult["VARIABLES"]["ELEMENT_CODE"])>0)
    {
        $rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arResult["VARIABLES"]["ELEMENT_CODE"], "ACTIVE"=>"Y"), false, false, array("ID"));
        if($arI = $rsI -> GetNext())
            $arResult["VARIABLES"]["ELEMENT_ID"] = $arI["ID"];
    }


    ob_start();
    $arRess=$APPLICATION->IncludeComponent(
        "bitrix:catalog.element",
        '',
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
    );

    $content = ob_get_contents();
    ob_end_clean();

    $ElementID = $arResult["VARIABLES"]["ELEMENT_ID"];

    $arRess=array();
    $obProperty=CIBlockElement::GetProperty($arParams["IBLOCK_ID"],$ElementID,array(),array("CODE" => "ACCESSORIES"))->Fetch();
    $arRess["PROPERTIES"]["ACCESSORIES"]["VALUE"]=$obProperty["VALUE"];

    $obProperty=CIBlockElement::GetProperty($arParams["IBLOCK_ID"],$ElementID,array(),array("CODE" => "LIKE"))->Fetch();
    $arRess["PROPERTIES"]["LIKE"]["VALUE"]=$obProperty["VALUE"];

    $obProperty=CIBlockElement::GetProperty($arParams["IBLOCK_ID"],$ElementID,array(),array("CODE" => "SEO_TEXT"))->Fetch();
    $arRess["PROPERTIES"]["SEO_TEXT"]["VALUE"]=$obProperty["VALUE"];

    $obProperty=CIBlockElement::GetProperty($arParams["IBLOCK_ID"],$ElementID,array(),array("CODE" => "CH_PRODUCER"))->Fetch();
    $arRess["PROPERTIES"]["CH_PRODUCER"]["VALUE"]=$obProperty["VALUE"];

    if($arRess["PROPERTIES"]["CH_PRODUCER"]["VALUE"]>0)
    {
        $temp=GetProducerByID($arRess["PROPERTIES"]["CH_PRODUCER"]["VALUE"]);
        if ($temp) $producer= $temp;
    }

    $obFields=CIBlockElement::GetList(array(),array("ID" => $ElementID),false,false,array("NAME"))->Fetch();




    if(!empty($producer) && !empty($arS)) {
        $APPLICATION->AddChainItem($arS["NAME"].' '.$producer["NAME"], $arS["~SECTION_PAGE_URL"].'proizvoditel_'.$producer["CODE"].'/');
    }

    $APPLICATION->AddChainItem($obFields["NAME"]);



    //////////////////////////////////////////////////////////
    // выводим ссылку уже есть или добавить в список малыша //
    // и список сравнения                                   //
    //////////////////////////////////////////////////////////
    if ($USER->IsAuthorized()){
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
                $arTmpOffers[$arI["PROPERTY_CML2_LINK_VALUE"]][] = $arI["CATALOG_PRICE_3"];

            foreach($arTmpOffers as $intProductID => $arPrices)
                $arResult["ITEMS"][$intProductID]["MIN_PRICE"] = min($arPrices);
        }
    }
?>
<input type="hidden" id="elementDataId" value="<?=$arResult["ITEMS"][$ElementID]["ID"]?>"/>
<input type="hidden" id="elementDataIdAdd" value="<?=$ElementID?>"/>
<?
    if($ElementID > 0)
    {
        $arSearchReplace = array();
        if($USER->GetID() > 0)
        {
            $isInBabyList = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $USER->GetID(), "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array());
            if(!empty($arResult["ITEMS"][$ElementID]))
                $add_to_wish_list_link = '<a id="deleteFromWishList" data-id="'.$arResult["ITEMS"][$ElementID]["ID"].'"  title="В избранное"><img src="/bitrix/templates/nmg/img/icon2.png" width="13" height="11" alt="В избранное" /><span>В избранное</span></a>';
            else $add_to_wish_list_link = '<a class="add addToLikeList" data-id="'.$ElementID.'"  title="В избранное"><img src="/bitrix/templates/nmg/img/grey-heart.png" width="13" height="11" alt="" /><span>В избранное</span></a>';
        } else $add_to_wish_list_link = '<a class="showpUp" id="userNoAuth" data-id="'.$ElementID.'" href="#messageNoUser1" title="В избранное"><img src="/bitrix/templates/nmg/img/grey-heart.png" width="13" height="11" alt="" /><span>В избранное</span></a>';

        $arSearchReplace['#ADD_TO_WISH_LIST#'] = $add_to_wish_list_link;

        // получаем список друзей
        if ($USER->GetID() > 0)
        {
            CModule::IncludeModule('socialnetwork');
            $arFriends = array();
            $dbFriends = CSocNetUserRelations::GetRelatedUsers($USER->GetID(), SONET_RELATIONS_FRIEND, false);
            while ($arFriend = $dbFriends->GetNext())
            {
                $arFriends[] = $arFriend;
                if($arFriend["FIRST_USER_ID"] != $USER->GetID()) $arFriendsIDs[] = $arFriend["FIRST_USER_ID"];
            }
        }

        // получаем список пользователей которые хотят этот товар

        $arFriendsIDsI = $arFriendsIDs;
        $arFriendsIDsI[] = $USER->GetID();
        $arUsersWantIDs = array();
        $users_want = 0;
        $users_friends_want = 0;
        $users_have = 0;
        $users_friends_have = 0;
        $SHOWCOUNTPAGE = 10;
        $COUNTPAGEHAVEFRIENDS = 0;
        $COUNTPAGEHAVE = 0;
        $COUNTPAGEWANTFRIENDS  = 0;
        $COUNTPAGEWANT = 0;


        $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
        while($obEl = $dbEl->GetNext())
            $arUsersWantIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];

        $arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
        $COUNTPAGEWANT = $dbEl->nEndPage;
        $users_want = $dbEl->nSelectedCount;

        if(count($arFriendsIDs)>0 && false)
        {
            $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
            while($obEl = $dbEl->GetNext())
            {
                $users_friends_want++;
                $arUsersWantFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
            }
            $arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
            $COUNTPAGEWANTFRIENDS = $dbEl->nEndPage;
            $users_friends_want = $dbEl->nSelectedCount;
        }

        // получаем список пользователей которые уже имеют этот товар
        $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>15), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
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

        // получаем список пользователей которые уже имеют этот товар
        $users_friends_have = 0;
        if(count($arFriendsIDs)>0 && false) // не разделяем на друзей и пользователей
        {
            $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID), array("PROPERTY_USER_ID"), array("nPageSize"=>$SHOWCOUNTPAGE), array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
            while($obEl = $dbEl->GetNext())
            {
                if(!in_array($obEl["PROPERTY_USER_ID_VALUE"],$arUsersHaveFriendsIDs))
                    $arUsersHaveFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
            }
            $arResult["NAV_STRING"] = $dbEl->GetPageNavStringEx($navComponentObject, $arParams["PAGER_TITLE"], $arParams["PAGER_TEMPLATE"], "Y");
            $COUNTPAGEHAVEFRIENDS = $dbEl->nEndPage;
            $users_friends_have = $dbEl->nSelectedCount;
        }

        /*
        $arSearchReplace['<!--#UWANT#-->'] = '<a href="#FriendsWant" class="showpUp">'.$users_friends_want.' '.WordsForNumbers($users_friends_want, 'друг', 'друга', 'друзей').'</a><br><a href="#UsersWant" class="showpUp">'.$users_want.' '.WordsForNumbers($users_want, 'пользователь', 'пользователя', 'пользователей').'</a>';
        $arSearchReplace['<!--#UHAVE#-->'] = '<a href="#FriendsHave" class="showpUp">'.$users_friends_have.' '.WordsForNumbers($users_friends_have, 'друг', 'друга', 'друзей').'</a><br><a href="#UsersHave" class="showpUp">'.$users_have.' '.WordsForNumbers($users_have, 'пользователь', 'пользователя', 'пользователей').'</a>';
        */
        $arSearchReplace['<!--#UWANT#-->'] = '<a href="#UsersWant" class="showpUp">'.$users_want.' '.WordsForNumbers($users_want, 'пользователь', 'пользователя', 'пользователей').'</a>';
        $arSearchReplace['<!--#UHAVE#-->'] = '<a href="#UsersHave" class="showpUp">'.$users_have.' '.WordsForNumbers($users_have, 'пользователь', 'пользователя', 'пользователей').'</a>';


        $arSearchReplace["#RATING#"] = '';
        $db_props = CacheRatingReviews::GetByID($arResult["VARIABLES"]["ELEMENT_ID"]);
        if(is_array($db_props))
        {
            $count = $db_props["FORUM_MESSAGE_CNT"];
            $arSearchReplace["#RATING#"] = showRating($db_props["RATING"], false);
        }
        $arSearchReplace['#REPORT_COUNT#'] = '<a class="reportLink" href="#'.($count>0?'reports':'comment').'" title="">'.($count>0?$count.' ':'').RevirewsLang($count).'</a>';

        foreach($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"] as $compare_list_item)
            $arCompareList[] = $compare_list_item["ID"];

        if (in_array($arResult["VARIABLES"]["ELEMENT_ID"], $arCompareList))
            $arSearchReplace['#ADD_TO_COMPARE_LIST#'] = '<a href="/catalog/compare/" title="Уже в списке сравнения"><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="" /><span>Уже в списке сравнения</span></a>';
        else
            $arSearchReplace['#ADD_TO_COMPARE_LIST#'] = '<a class="add addToCompareList" href="#" title="К сравнению"><img src="/bitrix/templates/nmg/img/icon3.png" width="12" height="12" alt="К сравнению" /><span>К сравнению</span></a><span style="display:none;">'.$arResult["VARIABLES"]["ELEMENT_ID"].'</span>';
    };

    // вывод карточки товара
    echo str_replace(array_keys($arSearchReplace), array_values($arSearchReplace), $content);

    ///////////////////////////////////////////////////////////////////

    if(!$_REQUEST["IS_AJAX"])
    {
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
    <div id="FriendsRecomend" class="CatPopUp<?if (!$USER->IsAuthorized()):?> FriendsRecomendSmallVar<?endif?>">
        <div class="white_plash">
            <div class="exitpUp"></div>
            <div class="cn tl"></div>
            <div class="cn tr"></div>
            <div class="content">
                <div class="content">
                    <div class="content">
                        <div class="clear"></div>
                        <div class="title">Рекомендовать другу</div>
                        <form class="jqtransform" action="?">
                            <div class="data">
                                <div class="left_part">
                                    <label for="femail">Электронный адрес</label>
                                    <div class="clear"></div>
                                    <input type="text" id="femail" style="width:216px;"/>
                                    <div class="clear"></div>
                                    <input type="submit" class="sbm" value="Рекомендовать">
                                </div><?
                                    $APPLICATION->IncludeComponent("individ:socialnetwork.user_friends", "sendmail", array(
                                        "SET_NAV_CHAIN" => "N",
                                        "ITEMS_COUNT" => "10",
                                        "ID" => $USER->GetID()
                                        ),
                                        false,
                                        array(
                                            "ACTIVE_COMPONENT" => "N"
                                        )
                                    );?>
                            </div>
                            <div class="clear"></div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
    </div>
    <div id="msgBasket" class="CatPopUp">
        <div class="white_plash">
            <div class="exitpUp"></div>
            <div class="cn tl"></div>
            <div class="cn tr"></div>
            <div class="content">
                <div class="content">
                    <div class="content">
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
    </div><?
    }
    ?>
<?
    if(false)
    {
        // список всех пользователей, которые хотят или имеют
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
                        <div class="title">Пользователи хотят</div>
                        <div class="addInfo">
                            <?
                                $i=0;
                              foreach($arUsersWantIDs as $user):?>
                                <div class="friend">
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
                                    <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
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
                                <a href="#userWant" class="grey showMoreElement" page_max="<?=$COUNTPAGEWANT?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Следующие</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userWantAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Показать всех</a>
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
                        <div class="title">Друзья хотят</div>
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
                                    <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
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
                                <a href="#userWantFriends" class="grey showMoreElement" page_max="<?=$COUNTPAGEWANTFRIENDS?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Следующие</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userWantFriendsAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Показать всех</a>
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
                        <div class="title">Пользователи имеют</div>
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
                                            <img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height:42px;"/>
                                            <?endif;?>
                                        <?else:?>
                                        <img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height:42px;"/>
                                        <?endif?>
                                    <?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
                                        if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
                                    ?>
                                    <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                                    <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
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
                                <a href="#userHave" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVEFRIENDS?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Следующие</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userHaveAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Показать всех</a>
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
                        <div class="title">Друзья имеют</div>
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
                                    <div class="lnk_gray"><a id="this_<?=$arResult["VARIABLES"]["ELEMENT_ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
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
                                <a href="#userHaveFriends" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>" element_id="<?=$ElementID?>" >Следующие</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#userHaveFriendsAll" class="grey showMoreElement" page_max="<?=$COUNTPAGEHAVE?>" page_now="1" count_page="<?=$SHOWCOUNTPAGE?>"  element_id="<?=$ElementID?>" >Показать всех</a>
                            </div>
                            <?endif;?>
                    </div></div></div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
    </div>
    <?
    }

    if(!$USER->IsAuthorized())
    { ?>
    <div id="messageNoUser1" class="CatPopUp">
        <div class="white_plash">
            <div class="exitpUp"></div>
            <div class="cn tl"></div>
            <div class="cn tr"></div>
            <div class="content">
                <div class="content">
                    <div class="content">
                        <div class="clear"></div>
                        Для того чтобы добавить товар в список "Избранное" требуется <a href="/personal/registaration/">регистрация</a> или <a href="/personal/profile/">авторизация</a>.
                    </div>
                </div>
            </div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
    </div><?
    }
?>

