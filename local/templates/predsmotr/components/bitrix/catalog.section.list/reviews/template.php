<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


 <div class="title-line"><h2>Какая ты мама?</h2></div>
    <div class="types">
        <?$arMamas = array('Практичная мама', 'Классическая мама', 'VIP мама', 'Активная мама', 'Стильная мама');?>
        <?foreach($arResult["SECTIONS"] as $key=>$arSection):?>
            <div class="item" id="<?=$arSection["IBLOCK_CODE"]?>">
                 <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=ShowImage($arSection["PICTURE"]["ID"],140,140,"border=0; style='float:left'");?></a>
                <div class="right-right">
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
                    <p><?=$arSection["DESCRIPTION"]?></p>
                </div>
            </div>
            <?if (($key+1) % 2 == 0):?>
                <div class="clear"></div>
            <?endif?>
        <?endforeach?>
        <div class="clear"></div>
    </div>