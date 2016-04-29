<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="wish-list already-have">
    <?$i == 0;?>
		<?foreach($arResult["ITEMS"] as $key => $arItem){?>
		<?if(!empty($arItem["PRODUCT"]["NAME"])):?>
        <div class="item<?if($i+1 == count($arResult["ITEMS"])):?> last<?endif?>">
            <div class="image">
				<?if(intval($arItem["PRODUCT"]["PREVIEW_PICTURE"])>0):?>
					<?=ShowImage($arItem["PRODUCT"]["PREVIEW_PICTURE"],100,100);?>
				<?else:?>
					&nbsp;
				<?endif;?>
            </div>
            <div class="name-name">
                <a class="product-name" href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arItem["PRODUCT"]["NAME"]?></a>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => $arItem["PRODUCT"]["PROPERTY_RATING_VALUE"]));?>
            </div>
            <div class="comment">
                <?=$arItem["PROPERTY_STATUS_VALUE"]?>
            </div>
            <div class="price-column">
				<?if($arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]>0):?>
                <?=$arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]?> р
				<?else:?>
				 &nbsp;
				<?endif?>
            </div>
            <div class="read-comment">
               
					<?if($arItem["REVIEW"]!=""):?>
						<a href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>#review<?=$arItem["REVIEW"]?>">Прочитать отзыв</a>
					<?else:?>
						<?if($arItem["ZAPROS"]):?>
						<span>Отзыв запрошен</span>
						<?else:?>
						 <a class="getReport" href="<?=$arParams["USER_ID"]?>" id="<?=$arItem["ID"]?>">Запросить отзыв</a>
						 <?endif?>
					<?endif;?>
            </div>
            <div class="clear"></div>
        </div>
        <?$i++;?>
		<?endif;?>
    <?}?>

    <?=$arResult["NAV_STRING"]?>    
    
</div>