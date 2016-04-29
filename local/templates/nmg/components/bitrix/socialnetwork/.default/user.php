<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
    $pageId = "user";
    global $USER;
    $current_user_id = $USER->GetID();
    $user_id = $arResult["VARIABLES"]["user_id"];
    

?>

<? // если пользователь смотрит свой вишлист ?>
<?if ($current_user_id == $user_id):?>

    <div class="product-type-selector ie7-bug">
        <ul>
            <?if ($_REQUEST["tab"]=="have"):?>
                <li>
                    <span><span><a href="?tab=wish">Хочу</a></span></span>
                </li>
                <li class="selected">
                    <span><span>Уже есть</span></span>
                </li>            
            <?else:?>
                <li class="selected">
                    <span><span>Хочу</span></span>
                </li>
                <li>
                    <span><span><a href="?tab=have">Уже есть</a></span></span>
                </li>
            <?endif?>
        </ul>
    </div>
    
    <?if ($_REQUEST["tab"] == "have"):?>
    <div class="sort-layer">
        <div class="left-left">
            Сортировать по:
        </div>
        <?if ($_REQUEST["sortby"] == "NAME"):?>
            <div class="product-type-selector ie7-bug">
                <ul>
                    <li>
                        <span><span><a href="?tab=have&sortby=PROPERTY_RATING&sortorder=<?if($_REQUEST["sortorder"] == "ASC"):?>DESC<?else:?>ASC<?endif?>">Новизне</a></span></span>
                    </li>
                    <li class="selected">
                        <span><span><nobr><a href="?tab=have&sortby=NAME&sortorder=<?if($_REQUEST["sortorder"] == "DESC"):?>ASC<?else:?>DESC<?endif?>">Названию <?if($_REQUEST["sortorder"] == "ASC"):?>&#9650;<?else:?>&#9660;<?endif?></a></nobr></span></span>
                    </li>
                </ul>
            </div>         
        <?else:?>
            <div class="product-type-selector ie7-bug">
                <ul>
                    <li class="selected">
                        <span><span><nobr><a href="?tab=have&sortby=PROPERTY_RATING&sortorder=<?if($_REQUEST["sortorder"] == "ASC"):?>DESC<?else:?>ASC<?endif?>">Новизне <?if($_REQUEST["sortorder"] == "ASC"):?>&#9650;<?else:?>&#9660;<?endif?></a></nobr></span></span>
                    </li>
                    <li>
                        <span><span><a href="?tab=have&sortby=NAME&sortorder=<?if($_REQUEST["sortorder"] == "DESC"):?>ASC<?else:?>DESC<?endif?>">Названию</a></span></span>
                    </li>
                </ul>
            </div>   
        <?endif?>     
        <div class="clear"></div>
    </div>
    <?endif?>
    
    <div class="clear"></div>

    <?if ($_REQUEST["tab"] != "have"):?>
        <div class="sub-selector-line">
            <div class="left-left">
                <a class="presents" href="#">Подарили подарков на 4 100 руб.</a>
            </div>
            <div class="right-right">
                <ul>
                    <li class="icon-icon plus add-my"><a href="#">Добавить свое</a></li>                
                    <li class="icon-icon letter send-to-friend"><a href="#">Сообщить друзьям</a></li>                
                    <li class="icon-icon buffer i-choose"><a href="#">Поделиться</a></li>                
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    <?endif?>  
    
    <?if ($_REQUEST["tab"]=="have"):?>
    
        <?$APPLICATION->IncludeComponent("individ:wish.list", "have.my", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID,
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "N",
            "SORT_BY" => $_REQUEST["sortby"],
            "SORT_ORDER" => $_REQUEST["sortorder"]
        ));?> 
  
    
    <?else:?>
    
        <?$APPLICATION->IncludeComponent("individ:wish.list", "wish.my", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => '',
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "Y"
        ));?> 

    <?endif?>

<?else: // пользователь смотрит чужой вишлист ?>

<?$APPLICATION->IncludeComponent("individ:user.profile.top", "", array(
    "USER_ID" => $user_id,
    "CURRENT_USER_ID" => $current_user_id,
    "IS_FRIENDS" => CSocNetUserRelations::IsFriends($user_id, $current_user_id),
    "CURRENT_PAGE" => "BABY_LIST"

));?>

    <div class="product-type-selector ie7-bug">
        <ul>
            <?if ($_REQUEST["tab"]=="have"):?>
                <li>
                    <span><span><a href="?tab=wish">Хочу</a></span></span>
                </li>
                <li class="selected">
                    <span><span>Уже есть</span></span>
                </li>            
            <?else:?>
                <li class="selected">
                    <span><span>Хочу</span></span>
                </li>
                <li>
                    <span><span><a href="?tab=have">Уже есть</a></span></span>
                </li>
            <?endif?>
        </ul>
    </div>

    <?if ($_REQUEST["tab"]=="have"):?>
    
        <?$APPLICATION->IncludeComponent("individ:wish.list", "have.user", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID,
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "N",
            "SORT_BY" => $_REQUEST["sortby"],
            "SORT_ORDER" => $_REQUEST["sortorder"]
        ));?> 
  
    
    <?else:?>
    
        <?$APPLICATION->IncludeComponent("individ:wish.list", "wish.user", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => '',
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "Y"
        ));?> 

    <?endif?>


<?endif?>