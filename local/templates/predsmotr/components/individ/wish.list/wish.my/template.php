<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_R($arResult["ITEMS"])?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="wish-list">
    <?$i=0; foreach($arResult["ITEMS"] as $key => $arItem):?>
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
                <a class="to-baby-list delete-from-wish-list" href="#">Удалить из списка</a><span style="display: none;"><?=$arItem["ID"]?></span>
            </div>
            <div class="comment">
                <form class="jqtransform">
                    <select class="status-change">
                        <option value="want"<?if($arItem["PROPERTY_STATUS_ENUM_ID"] == WISHLIST_PROPERTY_STATUS_WANT_ENUM_ID):?> selected="selected"<?endif?>>Тоже пригодится</option>
                        <option value="necessary"<?if($arItem["PROPERTY_STATUS_ENUM_ID"] == WISHLIST_PROPERTY_STATUS_NECESSARY_ENUM_ID):?> selected="selected"<?endif?>>Будет очень кстати</option>
                        <option value="going_to_die"<?if($arItem["PROPERTY_STATUS_ENUM_ID"] == WISHLIST_PROPERTY_STATUS_GOING_TO_DIE_ENUM_ID):?> selected="selected"<?endif?>>Первая необходимость</option>
                        <option value="already_have"<?if($arItem["PROPERTY_STATUS_ENUM_ID"] == WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID):?> selected="selected"<?endif?>>Уже есть</option>
                    </select>
                    <span class="wish-item-id" style="display:none;"><?=$arItem["ID"]?></span>
                </form>
            </div>
			
			<?if(is_array($arItem["PRODUCT"])):?>
				<div class="right-right">
					<div class="price">
					<?if($arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]>0):?>
					<?=$arItem["PRODUCT"]["PROPERTY_PRICE_VALUE"]?> р
					<?else:?>
					&nbsp;
					<?endif;?>
					</div>
					<?if($arItem["HAVEBUY"]>0 || true):?>
					<a class="addToCartList" href="<?=$arItem["PRODUCT"]["DETAIL_PAGE_URL"]?>#showOffers"><input type="button" class="input1" value="" /></a>
					<?else:?>
						<a class="ToBasket-none-none" href="#" onclick="return false;"/></a>
					<?endif?>
				</div>
			<?elseif(!empty($arItem["PROPERTY_PRICE_VALUE"])):?>
				<div class="right-right">
					<div class="price">
					<?if($arItem["PROPERTY_PRICE_VALUE"]>0):?>
					<?=$arItem["PROPERTY_PRICE_VALUE"]?> р
					<?else:?>
					&nbsp;
					<?endif;?>
					</div>
				</div>
			<?endif;?>
			
            <div class="clear"></div>
        </div>
    <?$i++; endforeach?>

    <div class="wish-list-access-text">
        Ваш список доступен только друзьям. Если Вы хотите показать список кому-то еще, то для этого можно сгенерировать специальную ссылку и отправить ее. Чтобы сделать это перейдите по ссылке "Сообщить друзьям"
    </div>
    
    <?=$arResult["NAV_STRING"]?>
    
</div>

<script>
    let_wish_status_change = false;
    
    setTimeout(function(){
        let_wish_status_change = true;
        
    }, 400)



    
</script>
<?else:?>
<div class="wish-list">
	<p>Ваш список малыша сейчас пуст.</p><br />
	<p>Для того чтобы начать составлять его перейдите в <a href="/catalog/">каталог</a> и выберите любой товар.</p><br />
	<p>Также вы можете добавить свое желание по ссылке выше.</p><br />
	<p>Или начините формировать список из товаров, которые рекомендуют наши эксперты для разных типов мам:</p><br />
	 <div class="clear"></div>
 	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"reviews_baby_list",
	Array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "7",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "1",
		"SECTION_FIELDS" => array(0=>"DESCRIPTION",1=>"PICTURE",2=>"",),
		"SECTION_USER_FIELDS" => array(0=>"",1=>"",),
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y"
	)
);?> 	 

</div>
<?endif;?>