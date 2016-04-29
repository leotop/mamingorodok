<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


if(count($arResult["ITEMS"])>0)
{
?>
<div class="goods">
    <h2>Рекомендованные товары</h2>
    <div class="item_list">
<?$first = true;?>
<?foreach($arResult["ROWS"] as $arItems):?>
    <?foreach($arItems as $arElement):?>
        <?if (!$arElement) continue;?>
        <div class="item <?=($first ? 'first' : ($last ? 'last' : ''))?>"><div class="align_center_to_left">
            <div class="align_center_to_right">
			<?if(file_exists($_SERVER["DOCUMENT_ROOT"].$arElement["PREVIEW_PICTURE"]["SRC"])):?>
			<a class="Pic" href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=ShowImage($arElement["PREVIEW_PICTURE"]["SRC"],100,100,'border="0" title="'.$arElement["NAME"].'"')?></a>
			<?else:?>
				&nbsp;
			<?endif;?>
			</div>
            <?if(!$NoRaiting):?>
                <div class="align_center_to_right"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?></div>
            <?endif?>
            <div class="align_center_to_right"><a class="Name" href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=$arElement['NAME']?></a></div>
            <?if($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"] > 0):?>
                <div class="align_center_to_right"><div class="OldPrice"><?=number_format($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">р</span></div></div>
                <div class="align_center_to_right"><div class="NewPrice"><span class="Currency">от</span> <?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">р</span></div></div>
            <?else:?>
                <div class="align_center_to_right"><div class="Price priceBasket"> <span class="Currency">от</span> <?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">р</span></div></div>
            <?endif;?>
                <div class="align_center_to_right">
				<a class="add-to-basket" href="/select-color-and-size.php?id=<?=$arElement["ID"]?>"></a>
			</div>
        </div></div>
        <?$first = false;?>
    <?endforeach?>
    <div class="clear"></div>
<?endforeach?>
    </div>
    <div class="clear"></div>
</div><?
}?>