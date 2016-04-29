<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult["MESSAGES"])):?>

    <h2>Отзывы</h2>

    <?foreach($arResult["MESSAGES"] as $key => $arMessage):?>

        <?if ($i == 1):?>
            <div id="open_review"><a href="?">Все <?=count($arResult["MESSAGES"])?> отзывов</a></div>
            <div id="hide_review" style="display: none;">                    
        <?endif?>
        <a name="message<?=$arMessage["ID"]?>"></a>
        <div class="comment top15">
            <div class="head">
                <img src="/bitrix/templates/Mami/images/blog/famous_people.png" class="foto">
                <a class="boldLink" href="/community/user/2/blog/"><?=$arMessage["FOR_JS"]["AUTHOR_NAME"]?></a>
                <div class="rat">
                    <div class="Raiting"><span class=""></span><span class=""></span><span class=""></span><span class=""></span><span class=""></span><div class="clear"></div></div> <span class="data"><span class="date"><?=$arMessage["POST_DATE"]?></span></span>
                </div>
            </div>
            <div class="text">
                <?=$arMessage["POST_MESSAGE_TEXT"]?>
                <div class="clear"></div>
            </div>
        </div>           
        <?$i++;?>
    <?endforeach?> 

            
<?endif?>

<?if ($i > 1):?>
    </div>
    <div id="close_review"><a href="?">Закрыть отзывы</a></div>
<?endif?>
