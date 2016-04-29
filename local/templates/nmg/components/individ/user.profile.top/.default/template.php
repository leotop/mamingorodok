<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? // если пользователь смотрит свой вишлист ?>
<?if ($arParams["CURRENT_USER_ID"] == $arParams["USER_ID"]):?>

    <div class="product-type-selector ie7-bug">
        <ul>
            <?if ($_REQUEST["tab"]=="have"):?>
                <li>
                    <span><span><a href="?tab=wish<?if(!empty($_REQUEST["s"])):?>&s=<?=$_REQUEST["s"]?><?endif;?>">Хочу</a></span></span>
                </li>
                <li class="selected">
                    <span><span>Уже есть</span></span>
                </li>            
            <?else:?>
                <li class="selected">
                    <span><span>Хочу</span></span>
                </li>
                <li>
                    <span><span><a href="?tab=have<?if(!empty($_REQUEST["s"])):?>&s=<?=$_REQUEST["s"]?><?endif;?>">Уже есть</a></span></span>
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
            "USER_ID" => $arParams["USER_ID"],
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
            "USER_ID" => $arParams["USER_ID"],
            "STATUS" => '',
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "Y"
        ));?> 

    <?endif?>

<?else: // пользователь смотрит чужой вишлист ?>

<?

?>

    <div class="title-line profile"><h2>Профиль пользователя</h2></div>
    <div class="user-profile">
        <div class="left-left">
            <?if ($arResult["PERSONAL_PHOTO"] > 0):?>
               <?=ShowImage($arResult["PERSONAL_PHOTO"],100,100);?>
            <?else:?>
                <img src="/bitrix/images/socialnetwork/nopic_user_100.gif" width="100" height="100" />
            <?endif?>
        </div>
        <div class="center-center">
            <div class="name-name"><?=ShowFullName($arResult["NAME"], $arResult["SECOND_NAME"], $arResult["LAST_NAME"])?></div>
				
            <?if(!empty($arResult["PERSONAL_BIRTHDAY"])):?><?=GetAge($arResult["PERSONAL_BIRTHDAY"])?><?endif?><?if(strlen($arResult["PERSONAL_CITY"]) > 0):?>, <?=$arResult["PERSONAL_CITY"]?><?endif?><br />
            <b>Рейтинг:</b> <?if(intval($arResult["UF_USER_RATING"])>0):?>+<?=$arResult["UF_USER_RATING"]?><?else:?><?=intval($arResult["UF_USER_RATING"])?><?endif;?><br />
			<?if(is_array($arResult["AWARDS"])):?>
				<b>Награды:</b> <?=implode(", ",$arResult["AWARDS"])?><br />
			<?endif;?>
			<?if(!empty($arResult["STATUS"])):?>
				<b>Статус в сообществах:</b> <?=$arResult["STATUS"]?><br />
			<?endif;?>
            <?if ($arResult["PERSONAL_NOTES"]):?>
                <b>О себе:</b><br />
                <?=$arResult["PERSONAL_NOTES"];?>
            <?endif?>
			
        </div>
		<?if(!$USER->IsAuthorized()):?>
			<script>
				$.cookie("auth", 0);
			</script>
		<?else:?>
			<script>
				$(document).ready(function() {
				if($.cookie("auth")==0 && $.cookie("button_certificates_click")==1){
					$.cookie("auth",1);
					$("#sert").click();
				}
				});
			</script>
		<?endif;?>
        <div class="right-right">
            <input class="orange select-sertificate" id="sert" type="submit" value="Подарить сертификат" />
            <div class="presents">
			<?global $presentCert;?>
			<?$any = array();?>
			<?foreach($presentCert as $ser){
				if(!in_array($ser["PROPERTY_USER_BY_VALUE"],$any)){
					$any[] = $ser["PROPERTY_USER_BY_VALUE"];
				}
			}?>
				<?if(count($any)>0):?>
					Сделали подарок <a class="showpUp" href="#certificate-presented-user"><?=count($any)?> <?=PersonLangN(count($any));?></a>
				<?endif;?>
            </div>
            <div class="read-blog">
                <a href="/community/blog/<?=$arResult["URL_BLOG"]?>/">Читать блог</a>
            </div>                                            
            
            <?if ($USER->IsAuthorized()):?>
                <?if ($arParams["IS_FRIENDS"]):?>
                    <input class="left-filter button-with-link" type="submit" value="Удалить из друзей" />
                    <a href="/community/user/<?=$arResult["ID"]?>/friends/delete/" style="display:none;"></a>
                <?else:?>                                   
                    <input class="left-filter button-with-link" type="submit" value="Добавить в друзья" />
                    <a href="/community/user/<?=$arResult["ID"]?>/friends/add/" style="display:none;"></a>
                <?endif?>
            <?endif?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="title-line baby-list">
        <ul>
            <li>
                <?if($arParams["CURRENT_PAGE"]=="BABY_LIST"):?>
                    Список малыша
                    <?else:?>
                    <a href="/community/user/<?=$arResult["ID"]?>/">Список малыша</a>
                    <?endif?>
            </li>
            <li>
                <?if($arParams["CURRENT_PAGE"]=="FRIENDS"):?>
                    Друзья
                    <?else:?>
                    <a href="/community/user/<?=$arResult["ID"]?>/friends/">Друзья</a>
                    <?endif?>
            </li>
            <?/*            <li>
                <?if($LOOK=="BABY"):?>
                Дети
                <?else:?>
                <a href="#">Дети</a>
            <?endif?>
            </li>
            <li>
                <?if($arParams["CURRENT_PAGE"]=="RATING"):?>
                    Рейтинг
                    <?else:?>
                    <a href="/community/user/<?=$arResult["ID"]?>/rating/">Рейтинг</a>
                <?endif?></li>*/?>
        </ul>
        <div class="clear"></div>
		<div id="order_do_friend" <?if(!isset($_SESSION["buyfriend"][$arParams["USER_ID"]])):?>class="nodisplay"<?endif;?>>
				<a href="/basketFriend/<?=$arParams["USER_ID"]?>/" class="grey" id="canbuyfriend">Оформить заказ в подарок</a>
		</div>
    </div>
<?endif?>
<div id="certificate-presented-user" class="CatPopUp nodisplay">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
		<div class="data">
			<?$i = 0;?>
			<?foreach($arResult["USERS"] as $k=>$user):?>
				<div class="friend<?if($i==1):?> last<?endif?>">
				<?if(intval($user["PERSONAL_PHOTO"])>0):?>
					<?=ShowImage($user["PERSONAL_PHOTO"],41,41);?>
				<?else:?>
					<?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',41,41);?>
				<?endif;?>
				<div class="lnk2">
					<a href="/community/blog/<?=$user["BLOG"]["URL"]?>/"><?=$user["LOOK_NAME"]?></a>
				</div>
				</div>
				<?$i++;?>
				<?if($i==2):?>
					<?$i=0;?>
					<div class="clear"></div>
				<?endif;?>
				
			<?endforeach;?>
			<div class="clear"></div>
		</div>
	 </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 