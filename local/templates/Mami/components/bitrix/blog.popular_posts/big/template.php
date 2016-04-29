<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="blog-posts-content">
<?
if(!empty($arResult["OK_MESSAGE"]))
{
    ?>
    <div class="blog-notes blog-note-box">
        <div class="blog-note-text">
            <ul>
                <?
                foreach($arResult["OK_MESSAGE"] as $v)
                {
                    ?>
                    <li><?=$v?></li>
                    <?
                }
                ?>
            </ul>
        </div>
    </div>
    <?
}
if(!empty($arResult["MESSAGE"]))
{
    ?>
    <div class="blog-textinfo blog-note-box">
        <div class="blog-textinfo-text">
            <ul>
                <?
                foreach($arResult["MESSAGE"] as $v)
                {
                    ?>
                    <li><?=$v?></li>
                    <?
                }
                ?>
            </ul>
        </div>
    </div>
    <?
}
if(!empty($arResult["ERROR_MESSAGE"]))
{
    ?>
    <div class="blog-errors blog-note-box blog-note-error">
        <div class="blog-error-text">
            <ul>
                <?
                foreach($arResult["ERROR_MESSAGE"] as $v)
                {
                    ?>
                    <li><?=$v?></li>
                    <?
                }
                ?>
            </ul>
        </div>
    </div>
    <?
}
    global $MyBlog;
    if($MyBlog!="BLOG"){
        ?>
            <?//print_R($arResult)?>
            <div class="BlogInfo">
            <h1>Популярные записи</h1>
            <?
            global $USER;
            if($USER->IsAuthorized() && !empty($arResult["POST"])):?>
            <input type="submit" id="blog_<?=$arResult["BLOG"]["ID"]?>" class="purple frending" value="<?if($arResult["USER_ADD"]=="Y"):?>Отписаться от блога<?else:?>Подписаться на блог<?endif;?>">
            <?endif;?>
            <div class="clear"></div>
            <div class="text">
            <?=$arResult["PERSONAL_NOTES"]?>
            </div>
            <div class="clear"></div>
            </div>
        <?
    }

if(count($arResult)>0)
{

    foreach($arResult as $ind => $CurPost) 
    {
    ?>           
    <div class="items">
    <?
    ?>
        <?//print_R($CurPost)?>
        <div class="headers">
            <a class="top10" href="<?=$CurPost["urlToPost"]?>"><?=$CurPost["TITLE"]?></a>
            <?if(strLen($CurPost["urlToEdit"])>0):?>
            <a href="<?=$CurPost["urlToEdit"]?>" class="edit">Редактировать</a>
            <?endif;?>
            <?if(strLen($CurPost["urlToDelete"])>0):?>
            <a href="<?=$CurPost["urlToDelete"]?>" class="delete">Удалить</a>
            <?endif;?>
        </div>
        <div class="top15"></div>
        <?
            $rsUser = CUser::GetList($by, $order, array("ID" => $CurPost["AUTHOR_ID"]), array("SELECT" => array("UF_USER_RATING")));    
            $arUser = $rsUser->Fetch();      
        ?>
        <?if ($arUser["PERSONAL_PHOTO"] > 0):?>
            <img class="foto" src="<?=MegaResizeImage($arUser["PERSONAL_PHOTO"], 41, 41)?>" />
        <?endif?>
        <a href="/community/blog/<?=$CurPost["AUTHOR_BLOG_URL"]?>/"><?=ShowFullName($arUser["NAME"], $arUser["LAST_NAME"])?></a>

        <span class="rating">Рейтинг</span> +<?=$arUser["UF_USER_RATING"]?>
        <div class="clear"></div>
        <?=$CurPost["TEXT_FORMATED"]?>
        <?if(preg_match('/\[CUT\]/i',$CurPost)):?>
            <a href="<?=$CurPost["urlToPost"]?>">Читать полностью</a>
        <?endif;?>
        <?if(!empty($CurPost["CATEGORY"]))
            {?>
            <div class="mark">Метка: 
                <noindex>
                    <?
                        $i=0;
                        foreach($CurPost["CATEGORY"] as $v)
                        {
                            if($i!=0)
                                echo ",";
                            ?> <a href="<?=$v["urlToCategory"]?>" class="grey" rel="nofollow"><?=$v["NAME"]?></a><?
                            $i++;
                        }
                    ?>
                </noindex>
            </div>
            <?}    ?>

    <div class="panel">
            <div class="panelLeft"></div>
            <div class="panelCenter">
                <div class="ratnum"><?
                    $APPLICATION->IncludeComponent(
                        "individ:rating.vote", "blog",
                        Array(
                            "ENTITY_TYPE_ID" => "BLOG_POST",
                            "ENTITY_ID" => $CurPost["ID"],
                            "OWNER_ID" => $CurPost["arUser"]["ID"],
                            "USER_HAS_VOTED" => $arResult["RATING"][$CurPost["ID"]]["USER_HAS_VOTED"],
                            "TOTAL_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_VOTES"],
                            "TOTAL_POSITIVE_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_POSITIVE_VOTES"],
                            "TOTAL_NEGATIVE_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_NEGATIVE_VOTES"],
                            "TOTAL_VALUE" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_VALUE"]
                        ),
                        null,
                        array("HIDE_ICONS" => "Y")
                    );?>
                </div> 
                <div class="date">
                <?
                //echo $CurPost["DATE_PUBLISH"];
                if(!empty($CurPost["DATE_PUBLISH"])):
                $mas = explode(" ",$CurPost["DATE_PUBLISH"]);
                if(isset($mas[0])):
                ?>
                <?=MyFormatDate($mas[0], false);?>
                <?endif;
                if(isset($mas[1]) && !empty($mas[1])):
                    $mas = explode(":",$mas[1]);
                    if(isset($mas[0]) && isset($mas[1]) && !empty($mas[1]) && !empty($mas[0])):
                ?>
                        <?=$mas[0].":".$mas[1]?>
                <?    endif;
                endif;?>
                <?endif;?>
                </div>
                <div class="share">
                        <?
                            $APPLICATION->IncludeComponent("bitrix:main.share", "", array(
                                    "HANDLERS" => $arParams["SHARE_HANDLERS"],
                                    "PAGE_URL" => htmlspecialcharsback($CurPost["urlToPost"]),
                                    "PAGE_TITLE" => htmlspecialcharsback($CurPost["TITLE"]),
                                    "SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
                                    "SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
                                    "ALIGN" => "right",
                                    "HIDE" => $arParams["SHARE_HIDE"],
                                ),
                                $component,
                                array("HIDE_ICONS" => "Y")
                            );
                            ?>
                </div>
                
                <a href="<?=$CurPost["urlToPost"]?>#addcomments" class='addcomment'>Оставить комментарий</a>
                <a href="<?=$CurPost["urlToPost"]?>#lookcomments" class="comment grey"><?if($CurPost["NUM_COMMENTS"]>0):?><?=$CurPost["NUM_COMMENTS"]?> <?endif;?><?=CommentLang($CurPost["NUM_COMMENTS"])?></a>
            </div>
            <div class="panelRight"></div>    
        </div>
    </div><?
    }
        ?>
            
                <?
    if(strlen($arResult["NAV_STRING"])>0)
        echo $arResult["NAV_STRING"];
}
elseif(!empty($arResult["BLOG"]))
    echo GetMessage("BLOG_BLOG_BLOG_NO_AVAIBLE_MES");
?>    
</div>