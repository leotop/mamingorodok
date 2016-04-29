<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

    <div class="types-baby-list-reviews">
        <?$arMamas = array('Практичная мама', 'Классическая мама', 'VIP мама', 'Активная мама', 'Стильная мама');?>
        <?foreach($arResult["SECTIONS"] as $key=>$arSection):?>
            <div class="item" id="<?=$arSection["IBLOCK_CODE"]?>">
                 <center><a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=ShowImage($arSection["PICTURE"]["ID"],80,80,"border=0");?></a>
				 <div class="clear"></div>
                 <a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?></a>
				 </center>
            </div>
            <?if (($key+1) % 3 == 0):?>
                <div class="clear"></div>
            <?endif?>
        <?endforeach?>
        <div class="clear"></div>
    </div>