<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER;?>
<div class="psycho-filter-result-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?if($arResult["INFO"]):?>
	<?//print_r($arResult["INFO"])?>
	<div class="psycho-head">
		<div class="img">
			<?=ShowImage($arResult["INFO"]["PICTURE"],80,80,"class='foto'");?>
		</div>
		<div class="text">
			<?=$arResult["INFO"]["DESCRIPTION"]?>
		</div>
		<div class="clear"></div>
		<div class="socshare">
			<?//print_r($arResult["INFO"])?>
			<?//echo $arResult["INFO"]["SECTION_PAGE_URL"]?>
			
			<?//echo $arResult["INFO"]["NAME"]?>
			<?$APPLICATION->IncludeComponent("bitrix:main.share", "share", array(
				"HIDE" => "N",
				"HANDLERS" => array(
					0 => "vk",
					1 => "twitter",
					2 => "facebook",
					3 => "lj",
				),
				"PAGE_URL" => htmlspecialcharsback($arResult["INFO"]["SECTION_PAGE_URL"]),
				"PAGE_TITLE" => htmlspecialcharsback("Рекомендованные списки для: ".$arResult["INFO"]["NAME"]." (МаминГородок)"),
				"SHORTEN_URL_LOGIN" => "",
				"SHORTEN_URL_KEY" => ""
				),
				false
			);?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="top15"></div>
<?endif?>
<?//print_r($arResult);?>
<?if(count($arResult["ITEMS"])>0):?>
    <?$j=0;?>
	<?foreach($arResult["ITEMS"] as $key=>$arItem):?>
		<?$k=0;?>
		<?if(count($arItem["TOVAR"])>0):?>
        <div class="item-item" id="block_<?=$j?>">
			<input type="hidden" id="recomendList_<?=$arItem["ID"]?>" class="recomendList_<?=$j?>">
            <div class="header-header">
				<div class="nodisplay name"><?=$arItem["NAME"]?></div>
                <div class="label-label open-list"><span></span><?=$arItem["NAME"]?> (раскрыть)</div>
				<?if(!empty($arResult["ITEMS"][$key]["POST_URL"])):?>
				<div class="blog-link">
				читайте подробное
				<a target="_blank" href="<?=$arResult["ITEMS"][$key]["POST_URL"]?>">сравнение</a>
				товара
				</div>
				<?endif;?>
            </div>
			<?$i=0;?>
			<?foreach($arItem["TOVAR"] as $tovar):?>
			<?//print_R($tovar);?>
			<?if($i==0):?>
				<div class="preview-preview" id='tovar_<?=$tovar["ID"]?>_<?=$j?>'>
					<div class="left-left">
						<div class="name-name-layer">
							<a  target="_blank" href="<?=$tovar["DETAIL_PAGE_URL"]?>" class="name-name"><?=$tovar["NAME"]?></a>
						</div>
						<div class="img">
							<a  target="_blank" href="<?=$tovar["DETAIL_PAGE_URL"]?>">
							<?=CFile::ShowImage($tovar["PREVIEW_PICTURE"], 95, 95, "border=0", "", false);?></a>
							<?if($tovar["THUMB"]=="Y"):?><div class="is-great"></div><?endif;?>
						</div>
						<div class="right-text">
							<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => intval($tovar["PROPERTY"]["RATING"]["VALUE"])));?>
							<a href="<?=$tovar["DETAIL_PAGE_URL"]?><?if($arItem["COUNT_REPORTS"]==0):?>#comment<?else:?>#reports<?endif;?>" class="reports-reports"><?if($arItem["COUNT_REPORTS"]>0):?><?=$arItem["COUNT_REPORTS"]?> <?endif;?><?=RevirewsLang(intval($arItem["COUNT_REPORTS"]))?></a>
							<div class="clear"></div>
							<div class="text-text"><?=$tovar["PREVIEW_TEXT"]?></div>
						</div>
					</div>
					<div class="right-right">
						<div style="display:none" class="product-id<?=$tovar["ID"]?>"><?=$tovar["ID"]?></div>
						<div style="display:none" class="user-id<?=$tovar["ID"]?>"><?=$USER->GetId()?></div>
						<div class="price">
						<?if($tovar["PROPERTY"]["PRICE"]["VALUE"]>0):?>
						<span>от</span>
						<?=$tovar["PROPERTY"]["PRICE"]["VALUE"]?> <span>р</span>
						<?else:?>
						&nbsp;
						<?endif?>
						</div>
						<?if($tovar["HAVEBUY"]=="Y"):?>
							<a href="<?=$tovar["DETAIL_PAGE_URL"]?>#showOffers" class="add-to-basket_new"></a>
						<?else:?>
							<a href="<?=$tovar["DETAIL_PAGE_URL"]?>#showOffers" class="add-to-basket-none_new"></a>
						<?endif;?>
						<div class="heart"></div>
						
						<?if(!$USER->IsAuthorized()):?>
							<a class="showpUp greydot" href="#messageNoUser1">В список малыша</a>
						<?else:?>
							<?if($tovar["IN_WISH"]):?>
							<a class="greydot" href="/community/user/<?=$USER->GetId()?>/">Уже в списке малыша</a>
							<?else:?>
							<div class="action BabyList BabyList<?=$tovar["ID"]?>" ><a class="add greydot " id="<?=$tovar["ID"]?>" href="#">В список малыша</a><div class="clear"></div></div>
							<?endif?>
						<?endif;?>
						
						<div class="compare-checkbox-layer">
							<label><input type="checkbox" <?if(isset($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"][$tovar["ID"]])):?>checked<?endif;?> class="add-to-compare-list-ajax" value="<?=$tovar["ID"]?>"> <a class="grey compare_link" href="/catalog/compare/"><a class="grey compare_link" href="/catalog/compare/">Сравнить</a></label>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				 <div class="hidden-hidden">
				 <div class="recommend-plus-minus">
				<?if(!empty($tovar["PROPERTY"]["PLUS"]["VALUE"])):?>
                <div class="plus">
                    <div class="label-label">Плюсы</div>
                    <span><?=$tovar["PROPERTY"]["PLUS"]["VALUE"]["TEXT"]?></span>
                </div>
				<?endif;?>
				<?if(!empty($tovar["PROPERTY"]["MINUS"]["VALUE"])):?>
                <div class="minus">
                    <div class="label-label">Минусы</div>
                    <span><?=$tovar["PROPERTY"]["MINUS"]["VALUE"]["TEXT"]?></span>
                </div>
				<?endif;?>
				</div>
                <div class="clear"></div>
				<div class="recommended">
                    <div class="rec-label">Рекомендуемые товары</div>
			<?else:?>
				 <div class="item-item item_item_<?=$tovar["ID"]?>_<?=$j?><?if ($i==count($arItem["TOVAR"])-1):?> last<?endif?>">
					<div class="name-rec-head"> 
					<a class="name-name recommend-update" id="tovar_<?=$tovar["ID"]?>_<?=$j?>" href="<?=$tovar["DETAIL_PAGE_URL"]?>"><?=$tovar["NAME"]?></a>
					</div>
					<div class="clear"></div>
					<div class="left-left">
						<div class="img">
							<a href="<?=$tovar["DETAIL_PAGE_URL"]?>" target="blank"><?=CFile::ShowImage($tovar["PREVIEW_PICTURE"], 95, 95, "border=0", "", false);?></a>
							<?if($tovar["THUMB"]=="Y"):?>
								<div class="is-great"></div>
							<?endif;?>
						</div>                            
					</div>
					<div class="right-right">
						<div class="price">
						<?if($tovar["PROPERTY"]["PRICE"]["VALUE"]>0):?>
							<span>от</span>
							<?=$tovar["PROPERTY"]["PRICE"]["VALUE"]?> <span>р</span>
						<?else:?>
						&nbsp;
						<?endif;?>
						</div>
						<?if($tovar["HAVEBUY"]=="Y"):?>
							<a class="add-to-basket_new" href="<?=$tovar["DETAIL_PAGE_URL"]?>#showOffers"></a> 
						<?else:?>
							<a class="add-to-basket-none_new" href="<?=$tovar["DETAIL_PAGE_URL"]?>#showOffers"></a> 
						<?endif;?>
							<label class="tpf"><input type="checkbox" <?if(isset($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"][$tovar["ID"]])):?>checked<?endif;?> class="add-to-compare-list-ajax" value="<?=$tovar["ID"]?>"> <a class="grey compare_link" href="/catalog/compare/">Сравнить</a></label>
					</div>
					  
					<div class="clear"></div>
					
				  
				</div>
				 <?$k++;?>
				 <?if($k==3): $k=0;?>
				
					<div class="clear"></div>
				 <?endif;?>
			<?endif;?>
			<?$i++;?>
			<?endforeach?> 
					<div class="clear"></div>
                </div>
            </div>                
        </div>
	<?$j++;?>
	<?endif;?>
    <?endforeach;?>
    
  <?else:?> 
	Ничего не найдено.
<?endif?>  
    
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
</div>

<?if(!$USER->IsAuthorized()):?>
<div id="messageNoUser1" class="CatPopUp">
<div class="white_plash">
<div class="exitpUp"></div>
<div class="cn tl"></div>
<div class="cn tr"></div>
<div class="content">
<div class="content">
<div class="content">
<div class="clear"></div>
	Для того чтобы добавить товар в "Список малыша" требуется <a href="/personal/registaration/">регистрация</a>.
</div>
</div>
</div>
<div class="cn bl"></div>
<div class="cn br"></div>
</div>
</div>
<?endif;?>