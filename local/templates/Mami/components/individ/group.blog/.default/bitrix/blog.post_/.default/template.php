<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER;?>
<?
    if(strlen($arResult["MESSAGE"])>0)
    {
    ?>
    <div class="blog-textinfo blog-note-box">
        <div class="blog-textinfo-text">
            <?=$arResult["MESSAGE"]?>
        </div>
    </div>
    <?
    }
    if(strlen($arResult["ERROR_MESSAGE"])>0)
    {
    ?>
    <div class="blog-errors blog-note-box blog-note-error">
        <div class="blog-error-text">
            <?=$arResult["ERROR_MESSAGE"]?>
        </div>
    </div>
    <?
    }
    if(strlen($arResult["FATAL_MESSAGE"])>0)
    {
    ?>
    <div class="blog-errors blog-note-box blog-note-error">
        <div class="blog-error-text">
            <?=$arResult["FATAL_MESSAGE"]?>
        </div>
    </div>
    <?
    }
    elseif(strlen($arResult["NOTE_MESSAGE"])>0)
    {
    ?>
    <div class="blog-textinfo blog-note-box">
        <div class="blog-textinfo-text">
            <?=$arResult["NOTE_MESSAGE"]?>
        </div>
    </div>
    <?
    }
    else
    {


        if(!empty($arResult["Post"])>0)
        {
            //print_R($arResult);
        ?>
		
		<div class="BlogInfo">
			<div class="BlogName">Блог <a href="/community/group/<?=$arResult["Blog"]["URL"]?>/"><?=$arResult["Blog"]["NAME"]?></a></div>
			<div><?=$arResult["Blog"]["DESCRIPTION"]?></div>
		</div>
		<div class="top15"></div>
        <?if($arResult["Post"]["TYPE"]==BLOG_TYPE):?>
            <div class="headers">
				<div class="blogLinkAdmin">
			
				<?if(strLen($arResult["urlToDelete"])>0):?>
				<a href="<?=$arResult["urlToDelete"]?>" class="delete">Удалить</a>
				<?endif;?>
				<?if(strLen($arResult["urlToEdit"])>0):?>
				<a href="<?=$arResult["urlToEdit"]?>" class="edit">Редактировать</a>
				<?endif;?>
				</div>
				<h1 class="BlogName"><span><?=$arResult["Post"]["TITLE"]?></span></h1>
                
            </div>
            <div class="top15"></div>
            <div class="clear"></div>
			<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
			
			<a href="/community/user/<?=$arResult["arUser"]["ID"]?>/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span> <?if($arResult["RATING"]>0):?>+<?endif;?><?=$arResult["RATING"]?>

			<div class="clear"></div>
            <div class="text2">
				<?$arResult["Post"]["textFormated"] = preg_replace('/&lt;div.*?id="#(.*?)"&gt;/is',"<div id=\"$1\">",$arResult["Post"]["textFormated"]);?>
				<?$arResult["Post"]["textFormated"] = preg_replace("/&lt;\/div&gt;/is","</div>",$arResult["Post"]["textFormated"]);?>
				<?$arResult["Post"]["textFormated"] = preg_replace('/<a.*?href="http:\/\/#([a-zA-Z0-9]+?)".*?>/is','<a href="#$1">',$arResult["Post"]["textFormated"]);?>
                <?=$arResult["Post"]["textFormated"]?>
				<?$arResult["Post"]["SHOWtext"] = substr($arResult["Post"]["textFormated"],0,100)?>
            </div>
            <div class="mark">
                <?if(!empty($arResult["Category"]))
                    {?>
                    Метка:
                    <noindex>
                        <?
                            $i=0;
                            foreach($arResult["Category"] as $v)
                            {
                                if($i!=0)
                                    echo ",";
                            ?> <a href="/community/group/category/<?=$v["NAME"]?>/" class="grey" rel="nofollow"><?=$v["NAME"]?></a><?
                                $i++;
                            }
                        ?>
                    </noindex>
                    <?}?>
            </div>
            <?elseif($arResult["Post"]["TYPE"]==FRIEND_TYPE):?>

            <?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
                <div class="top15"></div>
                <div class="clear"></div>
                <?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
                <a href="/personal/profile/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span> <?if($arResult["RATING"]>0):?>+<?endif;?><?=$arResult["RATING"]?></td>
                <div class="clear"></div>
                <div class="status">
                    <div class="tvr">
                        теперь дружит с 
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <?if(intval($arResult["Post"]["FRIEND_PHOTO"])>0):?>
                                            <?=ShowImage($arResult["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
                                            <?else:?>
                                            <?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
                                            <?endif;?>
                                    </td>
                                    <td>
                                        <?if(!empty($arResult["Post"]["FRIEND_BLOG"])):?>
                                            <a href="/community/blog/<?=$arResult["Post"]["FRIEND_BLOG"]?>/">
                                            <?=$arResult["Post"]["FRIEND_NAME"]?></a>
                                            <?else:?>
                                            <?=$arResult["Post"]["FRIEND_NAME"]?>
                                            <?endif;?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
					<?$arResult["Post"]["SHOWtext"] = $arResult["LOOK_NAME"]."  теперь дружит с ".$arResult["Post"]["FRIEND_NAME"];?>
                <?else:?>
                <div class="st">
                    Я дружу с
                    <?if(!empty($arResult["Post"]["FRIEND_BLOG"])):?>
                        <a href="/community/blog/<?=$arResult["Post"]["FRIEND_BLOG"]?>/">
                        <?=$arResult["Post"]["FRIEND_NAME"]?></a>
                        <?else:?>
                        <?=$arResult["Post"]["FRIEND_NAME"]?>
                        <?endif;?>
                </div>
                <?if(intval($arResult["Post"]["FRIEND_PHOTO"])>0):?>
                    <?=ShowImage($arResult["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
                    <?else:?>
                    <?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
                    <?endif;?>
                <div class="clear"></div>
				<?$arResult["Post"]["SHOWtext"] = "Я дружу с ".$arResult["Post"]["FRIEND_NAME"];?>
                <?endif;?>
            <?//print_R($arResult);?>

            <?elseif($arResult["Post"]["TYPE"]==WISHLIST_TYPE):?>	
            <?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
                <div class="top15"></div>
                <div class="clear"></div>
                <?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
                <a href="/personal/profile/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span> <?if($arResult["RATING"]>0):?>+<?endif;?><?=$arResult["RATING"]?></td>
                <div class="clear"></div>
                <div class="status">
                    <div><?if($arResult["Post"]["GENDER"]=="M"):?>Добавил<?else:?>Добавила<?endif?> в свой список</div>
                    <div class="tvr">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                                            <?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                                            <?endif;?>
                                    </td>
                                    <td>
                                        <?//print_R($CurPost["COUNT"]);?>
                                        <a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["Post"]["PRODUCT"]["NAME"]?></a>
                                        <?$rating = intval($arResult["Post"]["PROPERTY_RATING_VALUE"]);?>
                                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<?$arResult["Post"]["SHOWtext"] = $arResult["LOOK_NAME"]." добавил(а) в свой список ".$arResult["Post"]["PRODUCT"]["NAME"]?>
                <?else:?>
                <div class="st">
                    Я <?if($arResult["Post"]["GENDER"]=="M"):?>добавил<?else:?>добавила<?endif?>
                    <a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["Post"]["PRODUCT"]["NAME"]?></a>
                </div>
                <?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                    <?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
                    <?endif;?>
            <div class="clear"></div>
			<?$arResult["Post"]["SHOWtext"] ="Я добавил(а) в свой список ".$arResult["Post"]["PRODUCT"]["NAME"]?>
            <?endif?>

            <?elseif($arResult["Post"]["TYPE"]==ADD_COMMENT_TYPE):?>	
            <?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
                <div class="top15"></div>
                <div class="clear"></div>
                <?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
                <a href="/personal/profile/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span> <?if($arResult["RATING"]>0):?>+<?endif;?><?=$arResult["RATING"]?></td>
                <div class="clear"></div>
                <div class="status">
                    <?//echo $arResult["Post"]["USER_GENDER"];?>
                    <div><?if($arResult["Post"]["USER_GENDER"]=="M"):?>Добавил<?else:?>Добавила<?endif?> отзыв на товар</div>
                    <div class="tvr">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                                            <?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
                                            <?endif;?>
                                    </td>
                                    <td>
                                        <?//print_R($CurPost["COUNT"]);?>
                                        <a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["Post"]["PRODUCT"]["NAME"]?></a>
                                        <?$rating = intval($arResult["Post"]["PROPERTY_RATING_VALUE"]);?>
                                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
				<?$arResult["Post"]["SHOWtext"] = $arResult["LOOK_NAME"]." добавил(а) отзыв на товар ".$arResult["Post"]["PRODUCT"]["NAME"]?>
                <?else:?>
                <?//print_R($CurPost)?>
                <div class="clear"></div>
                <div class="st">Я <?if($CurPost["USER_GENDER"]=="M"):?>добавил<?else:?>добавила<?endif?> отзыв на товар
                    <a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arResult["Post"]["PRODUCT"]["NAME"]?></a>
                </div>
                <?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
                    <?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
                    <?endif;?>
            <div class="clear"></div>
			<?$arResult["Post"]["SHOWtext"] = "Я добавил(а) отзыв на товар ".$arResult["Post"]["PRODUCT"]["NAME"]?>
            <?endif;?>
            <?else:?>
            <?=$arResult["Post"]["textFormated"]?>
            <?endif;?>
        <div class="panel">
            <div class="panelLeft"></div>
            <div class="panelCenter">
                <div class="ratnum"><?
                        $APPLICATION->IncludeComponent(
                        "individ:rating.vote", "blog",
                        Array(
                        "ENTITY_TYPE_ID" => "BLOG_POST",
                        "ENTITY_ID" => $arResult["Post"]["ID"],
                        "OWNER_ID" => $arResult["Post"]["AUTHOR_ID"],
                        "USER_HAS_VOTED" => $arResult["RATING"]["USER_HAS_VOTED"],
                        "TOTAL_VOTES" => $arResult["RATING"]["TOTAL_VOTES"],
                        "TOTAL_POSITIVE_VOTES" => $arResult["RATING"]["TOTAL_POSITIVE_VOTES"],
                        "TOTAL_NEGATIVE_VOTES" => $arResult["RATING"]["TOTAL_NEGATIVE_VOTES"],
                        "TOTAL_VALUE" => $arResult["RATING"]["TOTAL_VALUE"]
                        ),
                        null,
                        array("HIDE_ICONS" => "Y")
                        );?>
                </div> 
                <div class="date">
                    <?
                        //echo $arResult["DATE_PUBLISH"];
                        if(!empty($arResult["Post"]["DATE_PUBLISH"])):
                            $mas = explode(" ",$arResult["Post"]["DATE_PUBLISH"]);
                            if(isset($mas[0])):
                            ?>
                            <?=MyFormatDate($mas[0], false);?>
                            <?endif;
                            if(isset($mas[1]) && !empty($mas[1])):
                                $mas = explode(":",$mas[1]);
                                if(isset($mas[0]) && isset($mas[1]) && !empty($mas[1]) && !empty($mas[0])):
                                ?>
                                <?=$mas[0].":".$mas[1]?>
                                <?	endif;
                                endif;?>
                        <?endif;?>
                </div>
                <div class="share">
                    <?
						$arResult["urlToPost"] = "/community/group/".$arResult["Blog"]["URL"]."/".$arResult["Post"]["ID"]."/";
                        $APPLICATION->IncludeComponent("individ:main.share", "", array(
                        "HANDLERS" => $arParams["SHARE_HANDLERS"],
                        "PAGE_URL" => htmlspecialcharsback($arResult["urlToPost"]),
                        "PAGE_TITLE" => $arResult["Post"]["~TITLE"],
                        "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                        "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
						"PAGE_DESCRIPTION"=>substr($arResult["Post"]["SHOWtext"],0,100),
                        "ALIGN" => "right",
                        "HIDE" => $arParams["SHARE_HIDE"],
                        ),
                        $component,
                        array("HIDE_ICONS" => "Y")
                        );
                    ?>
                </div>

                <a href="<?=$arResult["urlToPost"]?>#addcomments" class='addcomment'>Оставить комментарий</a>
                <a href="<?=$arResult["urlToPost"]?>#lookcomments" class="comment grey"><?if($arResult["Post"]["NUM_COMMENTS"]>0):?><?=$arResult["Post"]["NUM_COMMENTS"]?> <?endif;?><?=CommentLang($arResult["Post"]["NUM_COMMENTS"])?></a>
            </div>
            <div class="panelRight"></div>
        </div>
        <h2 class="grey top15"><?if($arResult["Post"]["NUM_COMMENTS"]>0):?><?=$arResult["Post"]["NUM_COMMENTS"]?> <?endif;?><?=CommentLang($arResult["Post"]["NUM_COMMENTS"],true)?> к записи 
            <?if($arResult["Post"]["TYPE"]==BLOG_TYPE):?>
                "<?=$arResult["Post"]["TITLE"]?>"
                <?endif;?>
        </h2>			
		<?//print_R($arResult);?>

        <?
        }
        else
            echo GetMessage("BLOG_BLOG_BLOG_NO_AVAIBLE_MES");
    }
?>
