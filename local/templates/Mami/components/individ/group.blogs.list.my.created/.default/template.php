<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<h2>Созданные группы</h2>
    <div class="items-group">
    <?foreach($arResult as $arBlog):?>
        <?
        // получаем колличество участников
        $arFriendUsers = array();
        $arUserID = array();
        $dbUsers = CBlogUser::GetList(
            array(),
            array(
                "GROUP_BLOG_ID" => $arBlog["ID"],
            ),
            array("ID", "USER_ID")
        );
        while($arUsers = $dbUsers->Fetch())
        {
            if (!in_array($arUsers["USER_ID"], $arFriendUsers))
                $arFriendUsers[] = $arUsers["USER_ID"];        
        }
        $friend_count = count($arFriendUsers);
        ?>        
        <div class="item-group">
            <a href="<?=$arBlog["urlToBlog"]?>"><?=$arBlog["NAME"]?></a>
            <div>Создан <?=date('d.m.Y', strtotime($arBlog["DATE_CREATE"]));?>, <?=$arBlog["POSTS_COUNT"]?> <?=WordsForNumbers($arBlog["POSTS_COUNT"], "запись", "записи", "записей")?></div>
        </div>    
    <?endforeach?>
    </div>
<div class="clear"></div>
<?endif?>