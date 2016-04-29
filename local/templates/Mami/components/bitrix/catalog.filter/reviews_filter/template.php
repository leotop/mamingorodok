<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_R($arResult);?>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" class="jqtransform FormReviews" id="filterForm" action="<?echo $arResult["FORM_ACTION"]?>" method="post">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
		<?foreach($arResult["arrProp"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				<div class="block-block">
				<div class="label-label"><?=$arItem["NAME"]?></div>
				<?if($arItem["PROPERTY_TYPE"]=="L"):?>
					<?if(count($arItem["VALUE_LIST"])>0):?>
					<ul><?$i=0;?>
						<?foreach($arItem["VALUE_LIST"] as $k=>$v):?>
							<li>
							<?//print_R()?>
							<div class="checkbox"><input id="<?=$arItem["CODE"]?><?=i?>" name="arrFilter_pf[PROPERTY_<?=$arItem["CODE"]?>][]" value="<?=$k?>" type="checkbox"  <?if(in_array($k,$_REQUEST["arrFilter_pf"]["PROPERTY_".$arItem["CODE"]])):?>checked<?endif;?>/></div> <label class="name-name" for="<?=$arItem["CODE"]?><?=i?>"><?=$v?></label><div class="clear"></div></li>
						<?endforeach;?>
					</ul>
					<?endif;?>
				<?endif;?>
				</div>
				<div class="clear"></div>
			<?endif?>
		<?endforeach;?>
	<?/*
	<?if(isset($_POST["arrFilter_pf"])):?>
	<input type="submit" name="set_filter" id="resetFilter" class="whiteBtn" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сбросить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /><input type="hidden" name="set_filter" value="Y" />
	<?else:?>
	<input type="submit" name="set_filter" class="whiteBtn" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Показать&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /><input type="hidden" name="set_filter" value="Y" />
	<?endif;?>
	
	*/?>
</form>
