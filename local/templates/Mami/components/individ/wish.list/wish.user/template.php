<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="wish-list">
    <?foreach($arResult["ITEMS"] as $key => $arItem):?>
        <div class="item<?if($key+1 == count($arResult["ITEMS"])):?> last<?endif?>">  
            <div class="image">
				<?if(intval($arItem["PRODUCT"]["PREVIEW_PICTURE"])>0):?>
					<?=ShowImage($arItem["PRODUCT"]["PREVIEW_PICTURE"],100,100);?>
				<?else:?>
					&nbsp;
				<?endif;?>
            </div>
			<?if(!empty($arItem["PRODUCT"]["NAME"])):?>
            <div class="name-name">
                <a class="product-name" href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arItem["PRODUCT"]["NAME"]?></a>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => $arItem["PRODUCT"]["PROPERTY_RATING_VALUE"]));?>
                <div class="heart"></div>
                <a class="to-baby-list" href="#">В список малыша</a>
            </div>
			<?else:?>
			<div class="name-name">
				<div class="product-name"><?=$arItem["NAME"]?></div>
			</div>
			<?endif;?>
            <div class="comment">
				<?if(!empty($arItem["PROPERTY_STATUS_VALUE"])):?>
					<?=$arItem["PROPERTY_STATUS_VALUE"]?>
				<?else:?>
					Тоже пригодится
				<?endif;?>
            </div>
			<?if(!empty($arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"])):?>
            <div class="right-right">
                <div class="price">
				<?if($arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]>0):?>
				<?=$arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]?> <span>р</span>
				<?else:?>
				&nbsp;
				<?endif?>
				</div>
                <input type="submit" class="purple add-to-basket-button" value="Купить в подарок" />
                <a class="add-to-basket" href="/select-color-and-size-and-count.php?id=<?=$arItem["PRODUCT"]["ID"]?>&quantity=1&user=<?=$arParams["USER_ID"]?>" style="display:none;"></a>
            </div>
			<?else:?>
			<div class="right-right">
                <div class="price">
				<?if($arItem["PROPERTY_PRICE_VALUE"]>0):?>
				<?=$arItem["PROPERTY_PRICE_VALUE"]?> <span>р</span>
				<?else:?>
				&nbsp;
				<?endif;?>
				</div>
            </div>
			<?endif;?>
			
            <div class="clear"></div>
        </div>
    <?endforeach?>
    
    <?=$arResult["NAV_STRING"]?>    
    
</div>