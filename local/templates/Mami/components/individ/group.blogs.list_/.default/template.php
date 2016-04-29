<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="title">���������� �������</div>
    <?foreach($arResult as $arBlog):?>
    <div class="block">
        <a href="<?=$arBlog["urlToBlog"]?>" class="groupName"><?=$arBlog["NAME"]?></a>
        <?
        // �������� ��������� �� ���������������� �������� �����
        $owner_id = GetUserField("BLOG_BLOG", $arBlog["ID"], "UF_OWNER_ID");
        if ($owner_id > 0)
        {
            $obOwner = CUser::GetByID($owner_id);
            $arOwner = $obOwner->Fetch();   
        }
        // �������� ����������� ����������
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
        <?if ($owner_id > 0):?>
            <div class="autor">���������: <a class="grey" href="/community/user/<?=$arOwner["ID"]?>/"><?=ShowFullName($arOwner["NAME"], '', $arOwner["LAST_NAME"])?></a></div>
        <?endif?>
        <div class="popul"><?=$friend_count?> <?=WordsForNumbers($friend_count, '��������', '���������', '����������')?>, <?=$arBlog["POSTS_COUNT"]?> <?=WordsForNumbers($arBlog["POSTS_COUNT"], "������", "������", "�������")?></div>
        <div class="text">
            <?=$arBlog["DESCRIPTION"]?>
        </div>
        <div class="wr"><a <?if(!$USER->IsAuthorized()):?>href="#usernoWrite" class="showpUp"<?else:?>href="<?=$arBlog["urlToBlog"]?>post_edit/new/"<?endif;?>>��������</a></div>
    </div>
    <?endforeach?>
<div class="clear"></div