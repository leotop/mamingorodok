<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!$this->__component->__parent || empty($this->__component->__parent->__name) || $this->__component->__parent->__name != "bitrix:blog"):
    $GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/style.css');
    $GLOBALS['APPLICATION']->SetAdditionalCSS('/bitrix/components/bitrix/blog/templates/.default/themes/blue/style.css');
endif;
?>
<?function WISHLIST_show($arPost){?>
    <?global $USER;
    /*echo "<pre>";
    print_r($arPost);
    echo "</pre>";*/
    
    ?>
    <?if($arPost["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
        <div class="top15"></div>
        <div class="clear"></div>
        <?=ShowImage($arPost["LOOK_FOTO"], 42,42,"class='foto'")?>
        <a href="/personal/profile/">
        <?=$arPost["LOOK_NAME"]?>
        </a> <span class="rating">Рейтинг</span>
        <?if($arPost["RATING"]>0):?>
        +
        <?endif;?>
        <?=$arPost["RATING"]?>
        <div class="clear"></div>
        <div class="status">
            <div>
                <?if($arPost["Post"]["GENDER"]=="M"):?>
                Добавил
                <?else:?>
                Добавила
                <?endif?>
                в свой список</div>
            <div class="tvr">
                <table>
                    <tbody>
                        <tr>
                            <td><?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                                    <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                                <?endif;?></td>
                            <td><a href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
                                <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
                                </a>
                                <?$rating = intval($arPost["Post"]["PROPERTY_RATING_VALUE"]);?>
                                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?else:?>
        <div class=item>
            <div class="st"> <?=$arPost["AuthorName"]?>
                <?if($arPost["Post"]["GENDER"]=="M"):?>
                добавил
                <?else:?>
                добавила
                <?endif?>
                <a href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
                <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
                </a> 
            </div>
            <?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
            <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
            <?endif;?>
            <div class="clear"></div>
        </div>
    <?endif?>    
<?    
}?>
<?function DEFAULT_show($arPost){?>
    <?if($arPost["FIRST"]!="Y")
    {
        ?><div class="blog-line"></div><?
    }
    ?>
    <div class="blog-mainpage-item">
    <div class="blog-author">
    <?if($arParams["SEO_USER"] == "Y"):?>
        <noindex>
        <a class="blog-author-icon" href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>" rel="nofollow"></a>
        </noindex>
    <?else:?>
        <a class="blog-author-icon" href="<?=$arPost["urlToAuthor"]?>" title="<?=GetMessage("BLOG_BLOG_M_TITLE_BLOG")?>"></a>
    <?endif;?>
    <?
    if (COption::GetOptionString("blog", "allow_alias", "Y") == "Y" && (strlen($arPost["urlToBlog"]) > 0 || strlen($arPost["urlToAuthor"]) > 0) && array_key_exists("BLOG_USER_ALIAS", $arPost) && strlen($arPost["BLOG_USER_ALIAS"]) > 0)
        $arTmpUser = array(
            "NAME" => "",
            "LAST_NAME" => "",
            "SECOND_NAME" => "",
            "LOGIN" => "",
            "NAME_LIST_FORMATTED" => $arPost["~BLOG_USER_ALIAS"],
        );
    elseif (strlen($arPost["urlToBlog"]) > 0 || strlen($arPost["urlToAuthor"]) > 0)
        $arTmpUser = array(
            "NAME" => $arPost["~AUTHOR_NAME"],
            "LAST_NAME" => $arPost["~AUTHOR_LAST_NAME"],
            "SECOND_NAME" => $arPost["~AUTHOR_SECOND_NAME"],
            "LOGIN" => $arPost["~AUTHOR_LOGIN"],
            "NAME_LIST_FORMATTED" => "",
        );    
    ?>
    <?
    $GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.user.link",
        '',
        array(
            "ID" => $arPost["AUTHOR_ID"],
            "HTML_ID" => "blog_new_posts_".$arPost["AUTHOR_ID"],
            "NAME" => $arTmpUser["NAME"],
            "LAST_NAME" => $arTmpUser["LAST_NAME"],
            "SECOND_NAME" => $arTmpUser["SECOND_NAME"],
            "LOGIN" => $arTmpUser["LOGIN"],
            "NAME_LIST_FORMATTED" => $arTmpUser["NAME_LIST_FORMATTED"],
            "USE_THUMBNAIL_LIST" => "N",
            "PROFILE_URL" => $arPost["urlToAuthor"],
            "PROFILE_URL_LIST" => $arPost["urlToBlog"],                            
            "PATH_TO_SONET_MESSAGES_CHAT" => $arParams["~PATH_TO_MESSAGES_CHAT"],
            "PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
            "DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
            "SHOW_YEAR" => $arParams["SHOW_YEAR"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "NAME_TEMPLATE" => $arParams["NAME_TEMPLATE"],
            "SHOW_LOGIN" => $arParams["SHOW_LOGIN"],
            "PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
            "PATH_TO_SONET_USER_PROFILE" => ($arParams["USE_SOCNET"] == "Y" ? $arParams["~PATH_TO_USER"] : $arParams["~PATH_TO_SONET_USER_PROFILE"]),
            "INLINE" => "Y",
            "SEO_USER" => $arParams["SEO_USER"],
        ),
        false,
        array("HIDE_ICONS" => "Y")
    );
    ?>    
    </div>
    <div class="blog-clear-float"></div>

    <div class="blog-mainpage-title"><a href="<?=$arPost["urlToPost"]?>"><?echo $arPost["TITLE"]; ?></a></div>
    <div class="blog-mainpage-content">

    <?=$arPost["TEXT_FORMATED"]?>
    </div>
    <div class="blog-mainpage-meta">
        <a href="<?=$arPost["urlToPost"]?>" title="<?=GetMessage("BLOG_BLOG_M_DATE")?>"><?=$arPost["DATE_PUBLISH_FORMATED"]?></a>
        <?if(IntVal($arPost["VIEWS"]) > 0):?>
            <span class="blog-vert-separator"></span> <a href="<?=$arPost["urlToPost"]?>" title="<?=GetMessage("BLOG_BLOG_M_VIEWS")?>"><?=GetMessage("BLOG_BLOG_M_VIEWS")?>:&nbsp;<?=$arPost["VIEWS"]?></a>
        <?endif;?>
        <?if(IntVal($arPost["NUM_COMMENTS"]) > 0):?>
            <span class="blog-vert-separator"></span> <a href="<?=$arPost["urlToPost"]?>#comments" title="<?=GetMessage("BLOG_BLOG_M_NUM_COMMENTS")?>"><?=GetMessage("BLOG_BLOG_M_NUM_COMMENTS")?>:&nbsp;<?=$arPost["NUM_COMMENTS"]?></a>
        <?endif;?>
    </div>
    <div class="blog-clear-float"></div>
    </div>
<?    
}?>
<?function FRIEND_show($arPost){?>
    <?global $USER;?>
    <?if($arPost["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
    <div class="top15"></div>
    <div class="clear"></div>
    <?=ShowImage($arPost["LOOK_FOTO"], 42,42,"class='foto'")?>
    <a href="/personal/profile/">
    <?=$arPost["LOOK_NAME"]?>
    </a> <span class="rating">Рейтинг</span>
    <?if($arPost["RATING"]>0):?>
    +
    <?endif;?>
    <?=$arPost["RATING"]?>
    <div class="clear"></div>
    <div class="status">
        <div class="tvr"> теперь дружит с
            <table>
                <tbody>
                    <tr>
                        <td><?if(intval($arPost["Post"]["FRIEND_PHOTO"])>0):?>
                            <?=ShowImage($arPost["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
                            <?else:?>
                            <?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
                            <?endif;?></td>
                        <td><?if(!empty($arPost["Post"]["FRIEND_BLOG"])):?>
                            <a href="/community/blog/<?=$arPost["Post"]["FRIEND_BLOG"]?>/">
                            <?=$arPost["Post"]["FRIEND_NAME"]?>
                            </a>
                            <?else:?>
                            <?=$arPost["Post"]["FRIEND_NAME"]?>
                            <?endif;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?else:?>
    <div class="st"> <?=$arPost["AuthorName"]?> дружит с
        <?if(!empty($arPost["Post"]["FRIEND_BLOG"])):?>
        <a href="/community/blog/<?=$arPost["Post"]["FRIEND_BLOG"]?>/">
        <?=$arPost["Post"]["FRIEND_NAME"]?>
        </a>
        <?else:?>
        <?=$arPost["Post"]["FRIEND_NAME"]?>
        <?endif;?>
    </div>
    <?if(intval($arPost["Post"]["FRIEND_PHOTO"])>0):?>
    <?=ShowImage($arPost["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
    <?else:?>
    <?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
    <?endif;?>
    <div class="clear"></div>
    <?endif;?>
<?
}?>
<?function ADD_COMMENT_show($arPost){?>
    <?global $USER;?>
    <?if($arPost["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
    <div class="top15"></div>
    <div class="clear"></div>
    <?=ShowImage($arPost["LOOK_FOTO"], 42,42,"class='foto'")?>
    <a href="/personal/profile/">
    <?=$arPost["LOOK_NAME"]?>
    </a> <span class="rating">Рейтинг</span>
    <?if($arPost["RATING"]>0):?>
    +
    <?endif;?>
    <?=$arPost["RATING"]?>
    <div class="clear"></div>
    <div class="status">
        <?//echo $arPost["Post"]["USER_GENDER"];?>
        <div>
            <?if($arPost["Post"]["USER_GENDER"]=="M"):?>
            Добавил
            <?else:?>
            Добавила
            <?endif?>
            отзыв на товар</div>
        <div class="tvr">
            <table>
                <tbody>
                    <tr>
                        <td><?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                            <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                            <?endif;?></td>
                        <td><?//print_R($CurPost["COUNT"]);?>
                            <a href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
                            <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
                            </a>
                            <?$rating = intval($arPost["Post"]["PROPERTY_RATING_VALUE"]);?>
                            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?else:?>
    <?//print_R($CurPost)?>
    <div class="clear"></div>
    <div class="st"><?=$arPost["AuthorName"]?>
        <?if($CurPost["USER_GENDER"]=="M"):?>
        добавил
        <?else:?>
        добавила
        <?endif?>
        отзыв на товар <a href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
        <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
        </a> </div>
    <?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
    <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
    <?endif;?>
    <div class="clear"></div>
    <?endif;?>
<?
}?>
<?function ADD_REPORT_show($arPost){?>
    <?global $USER;?>
    <?if($arPost["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
    <div class="top15"></div>
    <div class="clear"></div>
    <?=ShowImage($arPost["LOOK_FOTO"], 42,42,"class='foto'")?>
    <a href="/personal/profile/">
    <?=$arPost["LOOK_NAME"]?>
    </a> <span class="rating">Рейтинг</span>
    <?if($arPost["RATING"]>0):?>
    +
    <?endif;?>
    <?=$arPost["RATING"]?>
    <div class="clear"></div>
    <div class="status">
        <?//echo $arPost["Post"]["USER_GENDER"];?>
        <div>
            <?if($arPost["Post"]["USER_GENDER"]=="M"):?>
            Запросил
            <?else:?>
            Запросила
            <?endif?>
            отзыв у <a href="/comunity/blog/<?=$arPost["Post"]["REPORT_USER_BLOG"]?>/">
            <?=$arPost["Post"]["REPORT_USER"]?>
            </a> на товар</div>
        <div class="tvr">
            <table>
                <tbody>
                    <tr>
                        <td><?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                            <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                            <?endif;?></td>
                        <td><?//print_R($CurPost["COUNT"]);?>
                            <a href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
                            <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
                            </a>
                            <?$rating = intval($arPost["Post"]["PROPERTY_RATING_VALUE"]);?>
                            <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?else:?>
    <?//print_R($CurPost)?>
    <div class="clear"></div>
    <div class="st"><?=$arPost["AuthorName"]?>
        <?if($CurPost["USER_GENDER"]=="M"):?>
        запросил
        <?else:?>
        запросила
        <?endif?>
        отзыв у <a href="/comunity/blog/<?=$arPost["Post"]["REPORT_USER_BLOG"]?>/">
        <?=$arPost["Post"]["REPORT_USER"]?>
        </a> на товар </div>
    <?if($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
    <?=ShowImage($arPost["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto tovarfoto"');?>
    <?endif;?>
    <div class="tovarName"><a style="margin-top:15px;" href="<?=$arPost["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
        <?=$arPost["Post"]["PRODUCT"]["NAME"]?>
        </a></div>
    <div class="clear"></div>
    <?endif;?>
<?
}?>
<?function CERTIFICATE_show($arPost){?>
    <?global $USER;?>
    <?
    //print_R($CurPost["USER_TO"]);
    $name = "";
    
    if(!empty($arPost["Post"]["USER_TO"]["NAME"])){
        $name = $arPost["Post"]["USER_TO"]["NAME"];
    }
    
    if(!empty($arPost["Post"]["USER_TO"]["LAST_NAME"])){
        if(!empty($name))
            $name .= " ".$arPost["Post"]["USER_TO"]["LAST_NAME"];
        else
            $name = $arPost["Post"]["USER_TO"]["LAST_NAME"];
    }
    
    if(empty($name)){
        $name = $arPost["Post"]["USER_TO"]["LOGIN"];
    }
    ?>
    <?if($arPost["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
    <div class="top15"></div>
    <div class="clear"></div>
    <?=ShowImage($arPost["LOOK_FOTO"], 42,42,"class='foto'")?>
    <a href="/personal/profile/"><?=$arPost["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span>
    <?if($arPost["RATING"]>0):?>
    +
    <?endif;?>
    <?=$arPost["RATING"]?>
    <div class="clear"></div>
    <div class="status">
        <?//echo $arPost["Post"]["USER_GENDER"];?>
        <div>
            <?if($arPost["Post"]["USER_GENDER"]=="M"):?>
            Подарил
            <?elseif($arPost["Post"]["USER_GENDER"]=="F"):?>
            Подарила
            <?else:?>
            Подарил(а)
            <?endif?>
            пользователю <a href="/comunity/user/<?=$arPost["Post"]["USER_TO"]["ID"]?>/">
            <?=$name?>
            </a> сертификат </div>
        <div class="tvr">
            <table>
                <tbody>
                    <tr>
                        <td><?if($arPost["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"]>0):?>
                            <?=ShowImage($arPost["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                            <?endif;?></td>
                        <td><?//print_R($CurPost["COUNT"]);?>
                            <?if($arPost["Post"]["CERTIFICATE"]["PRICE"]>0):?>
                            <br />
                            <?=$arPost["Post"]["CERTIFICATE"]["PRICE"]?>     руб.
                            <?endif;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?else:?>
    <div class="clear"></div>
    <div><?=$arPost["AuthorName"]?>
        <?if($arPost["Post"]["USER_GENDER"]=="M"):?>
        подарил
        <?elseif($arPost["Post"]["USER_GENDER"]=="F"):?>
        Подарила
        <?else:?>
        Подарил(а)
        <?endif?>
        пользователю <a href="/comunity/user/<?=$arPost["Post"]["USER_TO"]["ID"]?>/">
        <?=$name?>
        </a> сертификат </div>
    </div>
    <?if($arPost["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"]>0):?>
    <?=ShowImage($arPost["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"],60,60,'class="stfoto tovarfoto"');?>
    <?endif;?>
    <div class="tovarName">
        <?if($arPost["Post"]["CERTIFICATE"]["PRICE"]>0):?>
        <br />
        <?=$arPost["Post"]["CERTIFICATE"]["PRICE"]?>
        руб.
        <?endif;?>
    </div>
    <div class="clear"></div>
    <?endif;?>
<?
}?>


<?
if(empty($arResult))
    echo GetMessage("SONET_BLOG_EMPTY");
     
foreach($arResult as $arPost)
{
    /*echo "<pre>";
    print_r($arPost);
    echo "</pre>"; */
    ?>
    
    <?
    $type=$arPost["Post"]["TYPE"];
    switch ($type)  {
        case WISHLIST_TYPE:
            WISHLIST_show($arPost);     
        break;
        case FRIEND_TYPE:
            FRIEND_show($arPost);     
        break;
        case ADD_COMMENT_TYPE:
            ADD_COMMENT_show($arPost);     
        break;
        case ADD_REPORT_TYPE:
            ADD_REPORT_show($arPost);     
        break;
        case CERTIFICATE_TYPE:
            CERTIFICATE_show($arPost);     
        break;
        default:
            DEFAULT_show($arPost);
        }

}
?>