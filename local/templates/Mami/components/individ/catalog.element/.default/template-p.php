<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="elementCatalog">
<? // список свойств привязанных товаров для js ?>
<?
global $USER; 
$user_id = $USER->GetID();
?>
<?//xvar_dump($arResult["LINKED_ITEMS"]);
$pr=0;
foreach($arResult["LINKED_ITEMS"] as $arElem) {
    if(intval($arElem["QUANTITY"])>0 && intval($arElem["PRICE"])>0)
        $pr++;
}
?>
<div id="current-url" style="display:none;"><?=$_SERVER["REDIRECT_URL"]?></div>
<div id="product-id" style="display:none;"><?=$arResult["ID"]?></div>
<div id="user-id" style="display:none;"><?=$user_id;?></div>
<div id="qu_count" style="display:none;"><?=$pr?></div>
<div id="sel_colorsize" style="display:none;"><?=$arResult["LINKED_ITEMS"][0]["ID"]?></div>
<div id="linked-items" style="display:none;">
<?foreach($arResult["LINKED_ITEMS"] as $arLinkedItem):?>
    <div class="item" id="linked-item-id-<?=$arLinkedItem["ID"]?>">
        <div class="element-id"><?=$arLinkedItem["ID"]?></div>
        <div class="name"><?=$arLinkedItem["NAME"]?></div>
        <div class="color"><?=$arLinkedItem["PROPERTY_COLOR_VALUE"]?></div>
        <div class="color-code"><?=$arLinkedItem["PROPERTY_COLOR_CODE_VALUE"]?></div>
        <div class="size"><?=$arLinkedItem["PROPERTY_SIZE_VALUE"]?></div>
        <div class="price"><?=$arLinkedItem["PRICE"]?></div>
		<div class="quantity"><?=$arLinkedItem["QUANTITY"]?></div>
        <div class="old-price"><?=$arLinkedItem["PROPERTY_OLD_PRICE_VALUE"]?></div>
        <div class="bonus-scores"><?=$arLinkedItem["PROPERTY_BONUS_SCORES_VALUE"]?></div>
        <div class="articul"><?=$arLinkedItem["PROPERTY_ARTICUL_VALUE"]?></div>
        <div class="mini-src"><?=MegaResizeImage($arLinkedItem["PROPERTY_PICTURE_MINI_VALUE"], 32, 32)?></div>
		<?$file = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"],array("width"=>256,"height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL)?>
        <div class="midi-src"><?=$file["src"]?></div>
			<?$file2 = CFile::GetPath($arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"]);?>
			<?//$file = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"],array("width"=>1000,"height"=>1000),BX_RESIZE_IMAGE_PROPORTIONAL_ALT)?>
		<div class="midi-src-max"><?=$file2?></div>
		<div class="midi-id"><?=$arLinkedItem["PROPERTY_PICTURE_MIDI_VALUE"]?></div>
		<div class="maxi-id"><?=$arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"]?></div>
		<?//$file = CFile::ResizeImageGet($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"],array("width"=>640,"height"=>480),BX_RESIZE_IMAGE_PROPORTIONAL)?>
        <div class="maxi-src"><?=CFile::GetPath($arLinkedItem["PROPERTY_PICTURE_MAXI_VALUE"])?></div>
    </div>
<?endforeach?>
</div>
<script>
	$(document).ready(function(){

		////////////////////////////////////////////////////////
		// Отмечаем самый минимальный по цене доступный товар //
		////////////////////////////////////////////////////////
		 var min_price = parseInt($('#linked-items .price').html());
		 var min_price_active = 0;
		// var min_price_product_id = 0;
		// var min_price_product_id_active = 0;
		
		$('#linked-items .item').each(function(){
			var current_price = parseInt($(this).find('.price').html());
			var current_product_id = $(this).find('.element-id').html();
			
			//наименьшая цена
			if (current_price < min_price)
			{
				min_price = current_price;
				min_price_product_id = current_product_id;
			}
			
			//наименьшая цена среди активных
			if (parseInt($(this).find('.quantity').html()) > 0)
			{
				//current_price = parseInt($(this).find('.price').html())
				if ((current_price < min_price_active && min_price_active > 0) || min_price_active == 0)
				{
					min_price_active = current_price;
					min_price_product_id_active = current_product_id;
				}
			}
			
		});
		
		//console.log(min_price_active);
		if(min_price_active>0)
			$("#Basketplash .Price").html("<span>от</span> "+CurrencyFormat(min_price_active)+" <span>р</span>");
            
		var colors_count = $('.ColorList .item').size();
		var sizes_count = $('.SizeList .item').size();
		
		//console.log(colors_count);
		//console.log(sizes_count);
		if(colors_count>0)
			$("#Basketplash #colorVal").val("");
		
		if(sizes_count>2)
			$("#Basketplash #sizeVal").val("");
		// отмечем радибаттоны цвета и размера
		// $('#linked-items .item').each(function(){
			// if ($(this).find('.element-id').html() == min_price_product_id_active)
			// {
				// var color_code = $(this).find('.color-code').html();
				// var size = $(this).find('.size').html();
				// $('#color_'+color_code).click();
				// $('#size_'+size).click();
			// }
		// });
	});
</script>

<? // получаем производителя ?>
<?foreach($arResult["PROPERTIES"] as $key => $arProp):?>
    <?if (strpos($arProp["CODE"], "CH_") !== false):?>
        <?if($arProp["CODE"] == "CH_PRODUCER"):?>
            <?
			if(is_array($arProp["VALUE"]))
				$arProp["VALUE"] = $arProp["VALUE"][0];
				
			//print_R($arProp["VALUE"]);
            $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arProp["VALUE"]), false, false, array("ID", "IBLOCK_ID", "NAME"));
            if($obEl = $dbEl->GetNext())
            {
                $producer_value = $obEl["NAME"];
            }
            break;
            ?>
        <?else:?>
            <?continue;?>
        <?endif?>
    <?endif?>
<?endforeach?>

<?if ($_REQUEST["IS_AJAX"]):?>
<script type="text/javascript">
    // массив id цветоразмеров вида arColorsSizes['white'][10] => id элемента 
    var arColorsSizesAJAX = new Array();
    <?foreach($arResult["LINKED_COLORS"] as $color):?>
        arColorsSizesAJAX['<?=$color?>'] = new Array();
        <?foreach($arResult["LINKED_SIZES"] as $size):?>
            <?if ($arResult["COLOR_SIZE"][$color][$size]["ID"] > 0):?>
                arColorsSizesAJAX['<?=$color?>']['<?=$size?>'] = <?=$arResult["COLOR_SIZE"][$color][$size]["ID"]?>;
            <?endif?>
        <?endforeach?>
    <?endforeach?>

</script>
<?else:?>
<script type="text/javascript">
    // массив id цветоразмеров вида arColorsSizes['white'][10] => id элемента 
    var arColorsSizes = new Array();
    <?foreach($arResult["LINKED_COLORS"] as $color):?>
        arColorsSizes['<?=$color?>'] = new Array();
        <?foreach($arResult["LINKED_SIZES"] as $size):?>
            <?if ($arResult["COLOR_SIZE"][$color][$size]["ID"] > 0):?>
                arColorsSizes['<?=$color?>']['<?=$size?>'] = <?=$arResult["COLOR_SIZE"][$color][$size]["ID"]?>;
            <?endif?>
        <?endforeach?>
    <?endforeach?>

</script>
<?endif?>



<?if (empty($arResult["PROPERTIES"]["VOTES"]["VALUE"])) $arResult["PROPERTIES"]["VOTES"]["VALUE"]=0;?>
<span id="element-id" style="display:none;"><?=$arResult["ID"]?></span>
<div class="CatalogCenterColumn RExist">

<div id="DetailPhotoChoose">    
    <?//xvar_dump($arResult)?>
	<?if($arResult["PROPERTIES"]["MODEL_3D"]["VALUE"]!=''):?>
	<div class="rel">
	 
            <a class="ttp_lnk" onclick="window.open('/view360.php?idt=<?=$arResult["ID"]?>', 'wind1','width=900, height=600, resizable=no, scrollbars=yes, menubar=no')" href="javascript:" title="Подробная 3D - Модель"><i class="img360"></i></a>
        
	</div>
	<?endif;?>
    <div id="PictureBlock" class="zoom-section" clearfix>
		<?$file = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"]["ID"],array("width"=>256,"height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT)?>
		<?$file =  $file["src"];?>
		
        <div id="midi-picture" class="DPicture clearfix">

		<?if (isset($_REQUEST["IS_AJAX"])):?>
		<img alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" src="<?=$file?>">
		<?else:?>
		<?if(file_exists($_SERVER["DOCUMENT_ROOT"].$arResult["DETAIL_PICTURE"]["SRC"])){?>
		<a href="/inc/picture_view.php?ELEMENT_ID=<?=$arResult["ID"]?>&img_id=<?=$arResult["DETAIL_PICTURE"]["ID"]?>" class="fancybox cloud-zoom"  id='zoom1' rel="adjustX: 30, adjustY:-4" alt="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img src="<?=$file?>"></a>
		<?}else{?>
		<a href="#" class="fancybox"><img src=""></a>
		<?}?>
		<?endif?>
		</div>
       
        <?//print_R($arResult["LINKED_COLORS_ITEMS"]);?>
        <?if(!$_REQUEST["IS_AJAX"]):?>
        <div class="DPictureListArea">
        <?$i=0;
        foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem) {
            if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0)
                $i++;
        }?>
        
        <?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) > 5):?>
            <div class="prev"></div>
        <?endif?>
        <?//xvar_dump(count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 + $i)?>
        <?//$file = CFile::MakeFileArray($arResult["DETAIL_PICTURE"]["ID"]);
		///print_R($file);
		?>
        <div class="zoom-desc DPictureList<?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) < 6):?>  DPictureListMargin<?endif;?><?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1 ) > 5):?> DPictureListCarousel<?endif;?>">
            <ul>
				<?if(intval($arResult["DETAIL_PICTURE"]["ID"])>0):?>
				<?$picID = $arResult["DETAIL_PICTURE"]["ID"];?>
				<?$file = CFile::ResizeImageGet($picID, array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
				<?if($file!=false && file_exists($_SERVER["DOCUMENT_ROOT"].$file["src"])):?>
				<?$file2=CFile::ResizeImageGet($picID, array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT,true);?>
                <li>
                    <a href="#" alt="<?=CFile::GetPath($arResult["DETAIL_PICTURE"]["ID"])?>" class='cloud-zoom-gallery' rel="adjustX: 30, adjustY:-4, useZoom: 'zoom1', smallImage: '<?=$file2["src"]?>'"><?=ShowImage($file["src"],32,32);?></a>
						<?//echo $picID."--";?>
						
                    <span class="midi-picture-src" style="display:none;"><?=$file2["src"]?></span>
                    <span class="maxi-picture-src" style="display:none;"><?=CFile::GetPath($arResult["DETAIL_PICTURE"]["ID"])?></span>
                    <span class="picture-id" style="display:none;"><?=$arResult["DETAIL_PICTURE"]["ID"]?></span>
                </li>
				<?endif;?>
				<?endif?>
            <?foreach($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"] as $img_id):?>
				<?$file = CFile::ResizeImageGet($img_id, array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL);?>
				<?if($file!=false && file_exists($_SERVER["DOCUMENT_ROOT"].$file["src"])):?>
                <li>
					
					<?//print_R($file);?>
					<?$file2 = CFile::ResizeImageGet($img_id,  array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL)?>
                    <a href="#" alt="<?=CFile::GetPath($img_id)?>" class='cloud-zoom-gallery' rel="adjustX: 30, adjustY:-4, useZoom: 'zoom1', smallImage: '<?=$file2["src"]?>' "><img src="<?=$file["src"]?>" /></a>
					
                    <span class="midi-picture-src" style="display:none;"><?=$file2["src"]?></span>
                    <span class="maxi-picture-src" style="display:none;"><?=CFile::GetPath($img_id)?></span>
                    <span class="picture-id" style="display:none;"><?=$img_id?></span>
                </li>
				<?endif;?>
            <?endforeach?>
			<?/*
            <?foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem): // изображения цветоразмеров (только разные цвета)?>
				
				<?if(intval($arColorItem["PROPERTY_PICTURE_MINI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])>0 && intval($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])>0):?>
                <li>	
				
				<?//echo "sdfffffffffffffffffff";?>
				
					<?//print_R($arColorItem)?>
					<?$file = CFile::ResizeImageGet($arColorItem["PROPERTY_PICTURE_MINI_VALUE"],array("width"=>32, "height"=>32),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
                    <a href="#"><img src="<?=$file["src"]?>" /></a>
					<?$file = CFile::ResizeImageGet($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"],array("width"=>256, "height"=>256),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
                    <span class="midi-picture-src" style="display:none;"><?=$file["src"]?></span>
                    <span class="maxi-picture-src" style="display:none;"><?=CFile::GetPath($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])?></span>
                    <span class="picture-id" style="display:none;"><?=$arColorItem["PROPERTY_PICTURE_MAXI_VALUE"]?></span>
                </li>
				<?endif;?>
            <?endforeach?>
			*/?>
            </ul>
            <div class="clear"></div>
        </div>
        <?if ((count($arResult["PROPERTIES"]["IMG_BIG"]["VALUE"]) + 1) > 5):?>
            <div class="next"></div>
        <?endif?>        
        
        <div class="clear"></div>
        </div>
        
        <div class="DPictureLnk"><a class="fancybox-detail bluedot" href="/inc/picture_view.php?ELEMENT_ID=<?=$arResult["ID"]?>">Смотреть все фотографии</a></div>
        
        <?endif?>
    </div>
    
    <div id="ChooseBlock">
        <?if($_REQUEST["IS_AJAX"]):?>
            <h1 style="margin-bottom:15px;"><?=$arResult["NAME"]?></h1>
        <?else:?>
            <h1><?=$arResult["NAME"]?></h1>
			<?if(!empty($arResult["PROPERTIES"]["ARTICUL"]["VALUE"])):?>
            <div class="article">Артикул: <?=$arResult["PROPERTIES"]["ARTICUL"]["VALUE"];?></div>
			<?endif;?>
			
            <div class="manufacturer"><span>Производитель:</span>&nbsp;<?=$producer_value?><div class="clear"></div></div>
            <?if(isset($arResult["PROPERTIES"]['STRANA']['VALUE'])):?>
            <div class="manufacturer">
            <div class="top5"></div>
            <span>Страна производителя:</span>&nbsp;&nbsp;&nbsp;
				<?=$arResult["PROPERTIES"]['STRANA']['VALUE']?>
			<?//print_R($arResult["PROPERTIES"]);?>
			<div class="clear"></div></div>
            <?endif;?>
            <div class="actions">
				<?//print_R($arResult)?>
                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arResult["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html") );?>
				#REPORT_COUNT#
                <div class="clear"></div>
            </div>
        <?endif?>

		<?if (count($arResult["LINKED_SIZES_ITEMS"]) > 0):?>
		<div class="round_plash">
            <div class="rp_head"></div>
            <div class="rp_content">
            <div class="rp_content">
            <div class="clear"> </div>
			
            <form action="?"><div class="clear"> </div>
				 <?if(count($arResult["LINKED_COLORS_ITEMS"])>1):?><div class="ColorError">Выберите цвет</div><?endif;?>
                <div class="Color">Цвет: <span>
				-
				</span></div>
                <div class="ColorList zoom-desc" <?if(intval($arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"])<=0):?>style="margin:0"<?endif;?>>
                    <?foreach($arResult["LINKED_COLORS_ITEMS"] as $arColorItem):?>
						<?if(file_exists($_SERVER["DOCUMENT_ROOT"].CFile::GetPath($arColorItem["PROPERTY_PICTURE_MINI_VALUE"]))):?>
                        <div class="item color-id-<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>">
                            <a href="#" alt="<?=CFile::GetPath($arColorItem["PROPERTY_PICTURE_MAXI_VALUE"])?>" class='cloud-zoom-gallery' rel="adjustX: 30, adjustY:-4, useZoom: 'zoom1', smallImage: '<?=CFile::GetPath($arColorItem["PROPERTY_PICTURE_MIDI_VALUE"])?>'"><label for="color_<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>">
								<?//echo " ".$arColorItem["PROPERTY_PICTURE_MINI_VALUE"]?>
                                <img src="<?=MegaResizeImage($arColorItem["PROPERTY_PICTURE_MINI_VALUE"], 32, 32)?>" />
								
                            </label>
                            <input type="radio" id="color_<?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?>" name="color" />
							</a>
                            <span class="current-color-code" style="display:none;"><?=$arColorItem["PROPERTY_COLOR_CODE_VALUE"]?></span>
                            <span class="current-color" style="display:none;"><?=$arColorItem["PROPERTY_COLOR_VALUE"]?></span>
                        </div>
						<?endif;?>
                    <?endforeach?>
                    <div class="clear"></div>
                </div>
                <?if(count($arResult["LINKED_SIZES_ITEMS"])>1):?>
				 <div class="SizeError">Выберите размер</div>
                <div class="Size">Размер: <span>-</span></div>
                <div class="SizeList">
                    <?foreach($arResult["LINKED_SIZES_ITEMS"] as $arSizeItem):?>
                        <div class="item size-id-<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>">
                            <input type="radio" name="size" id="size_<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>" />
                            <label for="size_<?=$arSizeItem["PROPERTY_SIZE_VALUE"]?>"><?=$arSizeItem["PROPERTY_SIZE_VALUE"]?></label>
                            <span class="current-size" style="display:none;"><?=$arSizeItem["PROPERTY_SIZE_VALUE"]?></span>
                        </div>
                    <?endforeach?>
                    <div class="clear"></div>
                    <div class="clear"></div>
                </div>
				<?else:?>
					<?//print_r($arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]);?>
				<div class="SizeList hide">
					  <div class="item size-id-<?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?>">
						<input type="hidden" name="size" id="size_<?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?>" />
					  <span class="current-size" style="display:none;"><?=$arResult["LINKED_SIZES_ITEMS"][0]["PROPERTY_SIZE_VALUE"]?></span>
					</div>
				</div>
                <?endif;?>
				
            </form>
            <?if(strlen($arResult["PROPERTIES"]['URL_SIZE']['VALUE'])>0):?>
                <a class="dotted_a how" href="<?=$arResult["PROPERTIES"]['URL_SIZE']['VALUE']?>">Как выбрать размер?</a>
            <?endif;?>
            </div>
            </div>
            <div class="rp_footer"></div>
        </div>
		<?endif?>
        
    </div>
    <div class="clear"></div>
</div>
        
    
</div>

<?if ($_REQUEST["IS_AJAX"]):?>
<div class="clear"></div>
<div class="price-layer">
    <div class="price"><span>от</span> 15 000 <span>р</span></div>
    <a href="#" class="add-to-basket-me"></a>
    <div class="clear"></div>
</div>
<?endif?>

<?if ($_REQUEST["IS_AJAX"]):?>

    <div class="clear"></div>

<?else:?>
<?//print_R();?>
<div class="CatalogRightColumn">
    <div class="yellow_plash" id="Basketplash">
        <div class="ytp"></div>
        <div class="yc">
        <?//xvar_dump($arResult["PROPERTIES"]["QU_ACTIVE"])?>
            <?if($arResult["PROPERTIES"]["QU_ACTIVE"]["VALUE"] == "Y"):?>
                <div class="Quantity" style="text-align: center;">Количество<br /><input id="Quantity_val" value="1" type="text" style="width: 45px;" /></div>
            <?endif?>
			<?if(isset($arResult["DISPLAY_PROPERTIES"]["OLD_PRICE"]["VALUE"])):?>
                <div class="OldPrice"><?=$arResult["DISPLAY_PROPERTIES"]["OLD_PRICE"]["VALUE"]?> <span>р</span></div>
			<?endif?>
            <div class="Price"><span>от</span> <?=$arResult["DISPLAY_PROPERTIES"]["PRICE"]["VALUE"]?> <span>р</span></div>
			<input type="hidden" id="colorVal" value="<?=$arResult["LINKED_COLORS"][0]?>">
			<input type="hidden" id="sizeVal" value="<?=$arResult["LINKED_SIZES"][0]?>">
            <a class="ToBasket" href="#"></a>
            <?/*<div class="ball">3.5 балла за покупку</div>*/?>
        </div>
        <div class="ybt"></div>
    </div>
    
    <div class="Delivery">
		<a href="/how-to-buy/#delivery">Способы доставки</a><br><br>
		
	</div>
    
    <div class="Share">
        #ADD_TO_WISH_LIST#
        #ADD_TO_COMPARE_LIST#
        <div class="action" id="Recomend"><div class="DIcon" ></div> <a href="#FriendsRecomend" class="showpUp">Рекомендовать другу</a><div class="clear"></div></div>
        <div class="soci">
        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/social.php', array("IMG"=>CFile::GetPath(
$arResult["DETAIL_PICTURE"]["ID"])), array('NAME'=>'Социальные кнопочки', 'ACTIVE'=>false));?>
        </div>
    </div>
</div>
<div class="clear"></div>


<div class="CatalogCenterColumn RExist">
    <div class="goods">
        <h2><?=substr($arResult["NAME"],0,75)?><?if(strlen($arResult["NAME"])>75):?>...<?endif?> описание</h2>
        <div class="description">
            <?=$arResult["DETAIL_TEXT"]?>
        </div>
		
		<?if(!empty($arResult["PROPERTIES"]["CH_INSTR1"]["VALUE"])):?>
		<div class="description">
		<p class="bold">Инструкция:</p>
		
		<?$arFile = CFile::GetFileArray($arResult["PROPERTIES"]["CH_INSTR1"]["VALUE"]);?>
		<p><a target="_blank" href="<?=$arFile["SRC"]?>"><?=$arFile["ORIGINAL_NAME"]?></a></p>
		</div>
		<?endif;?>
    </div>

</div>

<div class="CatalogRightColumn">
    <div class="short_block want">
        <h3>Хотят</h3>
        <?
        global $USER;
        $user_id = $USER->GetID();
        
        // получаем список друзей
        if ($user_id > 0)
        {
            CModule::IncludeModule('socialnetwork');
            $arFriends = array();
            $dbFriends = CSocNetUserRelations::GetRelatedUsers($user_id, SONET_RELATIONS_FRIEND, false);
            while ($arFriend = $dbFriends->GetNext())
            {
                $arFriends[] = $arFriend;
                $arFriendsIDs[] = $arFriend["FIRST_USER_ID"];
            }            
        }

        // получаем список пользователей которые хотят этот товар
        $users_want = 0;
        $users_friends_want = 0;
        $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_PRODUCT_ID" => $arResult["ID"], "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID, "!PROPERTY_USER_ID" => $user_id), false, false, array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));    
        while($obEl = $dbEl->GetNext())    
        {           
            $arUsersWantIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
            $users_want++;
            
            // является ли он другом
            if (in_array($obEl["PROPERTY_USER_ID_VALUE"], $arFriendsIDs)) 
            {
                $users_friends_want++;     
                $arUsersWantFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
				//die(print_R($obEl["PROPERTY_USER_ID_VALUE"]));
            }
            
        }
		
        // получаем список пользователей которые уже имеют этот товар
        $users_have = 0;
        $users_friends_have = 0;
        $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_PRODUCT_ID" => $arResult["ID"], "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID, "!PROPERTY_USER_ID" => $user_id), false, false, array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));    
        while($obEl = $dbEl->GetNext())    
        {           
			if(!in_array($obEl["PROPERTY_USER_ID_VALUE"],$arUsersHaveIDs)){
				$arUsersHaveIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
				$users_have++;
            }
			
            // является ли он другом
            if (in_array($obEl["PROPERTY_USER_ID_VALUE"], $arFriendsIDs)) 
            {
				if(!in_array($obEl["PROPERTY_USER_ID_VALUE"],$arUsersHaveFriendsIDs)){
					$users_friends_have++;     
					$arUsersHaveFriendsIDs[] = $obEl["PROPERTY_USER_ID_VALUE"];
					//die(print_R($obEl["PROPERTY_USER_ID_VALUE"]));
					//print_R($obEl["PROPERTY_USER_ID_VALUE"]);
				}
            }
            
        }
		// echo "znnnn";
		//die(print_R($arUsersHaveFriendsIDs));
        ?>
        <?//echo "<pre>"; var_dump($arUsersWantIDs);?>
        <div class="sub"><a href="#FriendsWant" class="showpUp"><?=$users_friends_want?> <?=WordsForNumbers($users_friends_want, 'друг', 'друга', 'друзей');?></a><br><a href="#UsersWant" class="showpUp"><?=$users_want?> <?=WordsForNumbers($users_want, 'пользователь', 'пользователя', 'пользователей');?></a></div>
    </div>
    <div class="short_block have">
        <h3>Уже имеют</h3>
        <div class="sub"><a href="#FriendsHave" class="showpUp"><?=$users_friends_have?> <?=WordsForNumbers($users_friends_have, 'друг', 'друга', 'друзей');?></a><br><a href="#UsersHave" class="showpUp"><?=$users_have?> <?=WordsForNumbers($users_have, 'пользователь', 'пользователя', 'пользователей');?></a></div>
    </div>
</div>
<div class="clear"></div>

<div class="DetailSmallCenterColumn" id="haract">
    <div class="goods">
        <h2>Характеристики</h2>
       <div class="choose">
		<span class="active">
			<span>
				<a href="#">Основные</a>
			</span>
		</span>
		<span>
			<span>
				<a href="#">Все</a>
			</span>
		</span>
		</div>
		<div class="clear"></div>
        <div class="TabProp">
            <h3>Общие характеристики</h3>
            <table class="DProp">
                <?foreach($arResult["PROPERTIES"] as $key => $arProp):?>
					<?if($key!="CH_INSTR1"):?>
					<?//print_R($arProp);?>
                    <?if($arProp["VALUE"]!=''):?>
                    <?if (strpos($arProp["CODE"], "CH_") !== false):?>
                        <?if($arProp["CODE"] == "CH_PRODUCER"):?>
                            <?
								
                                $arProp["VALUE"] = $producer_value;
								continue;
                            ?>                        
                        <?endif?>
                            <tr<?if (!in_array($arProp["ID"],$arResult["HARACTERISTICS"])):?> class="DHidePropTr"<?endif?>>
                                <td class="DNameTD"><div class="DName"><?=$arProp["NAME"]?></div><div class="Dsep"></div></td>
                                <td class="DValueTD">
								<?if(is_array($arProp["VALUE"])):?>
									<?if(isset($arProp["VALUE"]["TYPE"]) && ($arProp["VALUE"]["TYPE"]=="TEXT" || $arProp["VALUE"]["TYPE"]=="HTML" || $arProp["VALUE"]["TYPE"]=="text" || $arProp["VALUE"]["TYPE"]=="html")):?>
										<?if($arProp["VALUE"]["TYPE"]=="HTML" || $arProp["VALUE"]["TYPE"]=="html"):?>
										<?=$arProp["~VALUE"]["TEXT"]?>
										<?else:?>
										<pre><?=$arProp["VALUE"]["TEXT"]?></pre>
										<?endif;?>
									<?else:?>
										<?=implode(", ",$arProp["VALUE"])?>
									<?endif;?>
								<?else:?>
								<?=$arProp["VALUE"]?>
								<?endif?>
								</td>
                            </tr>
                    <?endif?>
                    <?endif;?>
					<?endif;?>
                <?endforeach?>
            </table>
        </div>        
    </div>
</div>
<?endif?>
</div>
<?
///////////////////////////////////////
// Всплывающие окна для всякой хрени //
///////////////////////////////////////    
?>

<?
// список всех пользователей, которые хотят или имеют    
$arAllUsers = array_unique(array_merge($arUsersWantIDs, $arUsersHaveIDs));
$arFilter = array(
    "ID" => implode('|', $arAllUsers)
);
$obUsers = CUser::GetList(($by="personal_country"), ($order="desc"),  $arFilter);
while($rs_user = $obUsers->Fetch())
{
    $arGetUsersByID[$rs_user["ID"]] = $rs_user;
}
?>

<div id="UsersWant" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Пользователи хотят</div>
        <?
		$i=0;
		//print_R($arUsersWantIDs);
		//echo "<br><br>";
		//print_R($arGetUsersByID);
		foreach($arUsersWantIDs as $user):?>
            <div class="friend">
				<?//print_R($arGetUsersByID[$user]["PERSONAL_PHOTO"]); echo "----";?>
                <?if($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
            </div>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
        <br>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="FriendsWant" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Друзья хотят</div>
        <?
		$i=0;
		foreach($arUsersWantFriendsIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif;?>
        <?endforeach;?>
        <div class="clear"></div>
        <br>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="UsersHave" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Пользователи имеют</div>
        <?
		$i=0;
		foreach($arUsersHaveIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$arResult["ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
        <br>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<div id="FriendsHave" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Друзья имеют</div>
        <?
		$i=0;
		foreach($arUsersHaveFriendsIDs as $user):?>
            <div class="friend">
                <?if ($arGetUsersByID[$user]["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arGetUsersByID[$user]["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arGetUsersByID[$user]["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arGetUsersByID[$user]["NAME"], $arGetUsersByID[$user]["SECOND_NAME"], $arGetUsersByID[$user]["LAST_NAME"]);
				if(empty($name)) $name = $arGetUsersByID[$user]["EMAIL"];
				?>
				<div class="lnk2"><a href="/community/user/<?=$user?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a  id="this_<?=$arResult["ID"]?>" class="getReport" href="<?=$user?>">Запросить отзыв</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif?>
        <?endforeach;?>
        <div class="clear"></div>
        <br>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<?global $USER;?>
<div id="FriendsRecomend" class="CatPopUp<?if (!$USER->IsAuthorized()):?> FriendsRecomendSmallVar<?endif?>">
    <div class="white_plash"><div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    
        <div class="title">Рекомендовать другу</div>
        <form class="jqtransform" action="?">
        <div class="data">
        <div class="left_part">
            <label for="femail">Электронный адрес</label>
			<div class="clear"></div>
            <input type="text" id="femail" style="width:216px;"/>
			<div class="clear"></div>
            <input type="submit" class="sbm" value="Рекомендовать">
        </div>
		<?
		global $USER;
		$APPLICATION->IncludeComponent("individ:socialnetwork.user_friends","sendmail",array(
			"SET_NAV_CHAIN"=>"N",
			"ITEMS_COUNT"=>10,
			"ID"=>$USER->GetID()
		));?>
		</div>
        <div class="clear"></div>
        </form><div class="clear"></div>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>

<div id="msgBasket" class="CatPopUp">
    <div class="white_plash"><div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
  </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
<script>
	$(document).ready(function(){
    // скрываем списоки размеров или цветов, если они пустые
    var colors_count = $('.ColorList .item').size();
    var sizes_count = $('.SizeList .item').size();
    
    if (colors_count == 1){
        $('.ColorList input').click();
	}
    if (sizes_count < 2){
        $('.SizeList').hide();
		$('.SizeList input').eq(0).click();
		}
	});
</script>                    
