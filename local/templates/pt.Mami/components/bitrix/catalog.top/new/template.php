<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="goods">
    <h2>Новинки <a href="?">Показать все</a></h2>
    <div class="item_list">
        <?$first = true;?>
	    <?foreach($arResult["ROWS"] as $arItems):?>
            <?foreach($arItems as $arElement):?>
                <div class="item <?=($first ? 'first' : ($last ? 'last' : ''))?>"><div class="align_center_to_left">
                    <div class="align_center_to_right"><a class="Pic" href="/catalog/2/385/"><img border="0" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arElement["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arElement["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arElement["NAME"]?>" title="<?=$arElement["NAME"]?>" /></a></div>
                    <?if(!$NoRaiting):?>
                        <div class="align_center_to_right"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arItem['RAITING']));?></div>
                    <?endif?>
                    <div class="align_center_to_right"><a class="Name" href="/catalog/2/385/"><?=$arElement['NAME']?></a></div>
                    <?if($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"] > 0):?>
                        <div class="align_center_to_right"><div class="OldPrice"><?=number_format($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
                        <div class="align_center_to_right"><div class="NewPrice"><?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
                    <?else:?>
                        <div class="align_center_to_right"><div class="Price"><?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">руб</span></div></div>
                    <?endif;?>
                    <?if($InBasket):?>
                        <div class="align_center_to_right"><div class="ToBasket"></div></div>
                    <?endif;?>
                </div></div>
                <?$first = false;?>
            <?endforeach?>
            <div class="clear"></div>
	    <?endforeach?>
    </div>
</div>
<?echo "<pre>"; var_dump($arResult); echo "</pre>";?>