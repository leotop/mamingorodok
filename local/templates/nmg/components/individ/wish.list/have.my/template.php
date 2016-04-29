<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="wish-list already-have">
    <?$i = 0;?>
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <div class="item<?if($i+1 == count($arResult["ITEMS"])):?> last<?endif?>">
            <div class="image">
				<?=ShowImage($arItem["PRODUCT"]["PREVIEW_PICTURE"],100,100);?>
				&nbsp;
            </div>
            
			<div class="name-name">
				<?if(is_array($arItem["PRODUCT"])):?>
					<a class="product-name" href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$arItem["PRODUCT"]["NAME"]?></a>
					<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => $arItem["PRODUCT"]["PROPERTY_RATING_VALUE"]));?>
				<?else:?>
					<b><?=$arItem["NAME"]?></b>
					<p><?=$arItem["PREVIEW_TEXT"]?></p>
				<?endif;?>
            </div>
            
			<div class="comment">
                <?=$arItem["PROPERTY_STATUS_VALUE"]?>
            </div>
			
			<?if(is_array($arItem["PRODUCT"])):?>
				<div class="price-column">
					<?if($arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]>0):?>
					<?=$arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]?> р
					<?else:?>
					 &nbsp;
					<?endif;?>
				</div>
				<div class="read-comment">
					<?if($arItem["REVIEW"]!=""):?>
					<a href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>#review<?=$arItem["REVIEW"]?>">Прочитать отзыв</a>
					<?else:?>
					<a class="addReportProfile showpUp" id="/addReportProfile.php?id=<?=$arItem["PRODUCT"]["ID"]?>" href="#addReport"><input type="submit" class="left-filter write-comment" value="Написать отзыв" /></a>
					<?endif;?>
				</div>
			<?endif;?>
			
            <div class="clear"></div>
        </div>
        <?$i++;?>
    <?endforeach?>
    
    <?=$arResult["NAV_STRING"]?>    
        
</div>   
 
<div id="addReport" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Добавить отзыв</div><br>
        <div class="value"><br/><center><img src="/ajax-loader.gif"></center><br/></div>
        <div class="clear"></div>
        <br>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>