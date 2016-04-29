<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="BlogLeft">
    <h1>Популярные авторы</h1>
    <div>
        <?foreach($arResult["USER"] as $arUser):?>
            <div class="friend">
                <?if ($arUser["PERSONAL_PHOTO"] > 0):?>
                    <img src="<?=MegaResizeImage($arUser["PERSONAL_PHOTO"], 100, 100)?>" />
                <?else:?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/blog/foto2.png">
                <?endif?>

                <a href="/community/blog/<?=$arUser["BLOG_URL"]?>/"><?=ShowFullName($arUser["NAME"], '', $arUser["LAST_NAME"])?></a>
                <?$rating = GetUserField("USER", $arUser["ID"], "UF_USER_RATING");?>
                <?if ($rating > 0):?>
                    <center>Рейтинг: +<?=$rating?></center>
                <?endif?>
            </div>
        <?endforeach?>
    </div>
</div>