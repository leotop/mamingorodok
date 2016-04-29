<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ROWS"])>0):?>
    <div class="goods">
        <h2>������ <a href="/catalog/title/sale/">�������� ���</a></h2>
        <div class="item_list">
<?$first = true;?>
<?foreach($arResult["ROWS"] as $arItems):?>
    <?foreach($arItems as $arElement):?>
        <?if (!$arElement) continue;?>
        <div class="item <?=($first ? 'first' : ($last ? 'last' : ''))?>"><div class="align_center_to_left">
           <div class="align_center_to_right i100100">
			<?if(file_exists($_SERVER["DOCUMENT_ROOT"].$arElement["PREVIEW_PICTURE"]["SRC"])):?>
			<a class="Pic" href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=ShowImage($arElement["PREVIEW_PICTURE"]["SRC"],100,100,'border="0" title="'.$arElement["NAME"].'"')?></a>
			<?else:?>
				&nbsp;
			<?endif;?>
			</div>
            <?if(!$NoRaiting):?>
                <div class="align_center_to_right"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]));?></div>
            <?endif?>
            <div class="align_center_to_right n100100"><a class="Name" href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=$arElement['NAME']?></a></div>
			<?if($arElement["PROPERTIES"]['PRICE']["VALUE"]>0):?>
            <?if($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"] > 0):?>
                <div class="align_center_to_right"><div class="OldPrice"><?=number_format($arElement["PROPERTIES"]['OLD_PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">�</span></div></div>
			<?endif?>
                <div class="align_center_to_right">
				<?if($arElement["PROPERTIES"]['PRICE']["VALUE"]>0):?>
					<div class="NewPrice"><span class="Currency">��</span> <?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">�</span></div>
				<?endif?>
				</div>
            <?else:?>
                <div class="align_center_to_right">
					<?if($arElement["PROPERTIES"]['PRICE']["VALUE"]>0):?>
					<div class="Price"><span class="Currency">��</span> <?=number_format($arElement["PROPERTIES"]['PRICE']["VALUE"], 0, '.', ' ')?> <span class="Currency">�</span></div>
					<?endif?>
				</div>
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
        <div class="clear"></div>
    </div>
<?endif;?>