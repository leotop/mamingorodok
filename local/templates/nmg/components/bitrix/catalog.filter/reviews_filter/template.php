<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form name="<?=$arResult["FILTER_NAME"]."_form"?>" class="jqtransform FormReviews" id="filterForm" action="<?=$arResult["FORM_ACTION"]?>" method="post"><?
foreach($arResult["ITEMS"] as $arItem)
{
	if(array_key_exists("HIDDEN", $arItem))
		echo $arItem["INPUT"];
};
?>
<ul class="filter_list"><?
foreach($arResult["arrProp"] as $arItem)
{
	if(!array_key_exists("HIDDEN", $arItem))
	{?>
	<li>
		<div class="categoryF">
			<h4><?=$arItem["NAME"]?></h4>
		</div><?
		if($arItem["PROPERTY_TYPE"]=="L")
		{
			?>
		<div class="check"><?
			if(count($arItem["VALUE_LIST"])>0)
			{
				$i = 0;
				foreach($arItem["VALUE_LIST"] as $k=>$v)
				{?>
			<div class="checkbx">
				<input class="checkbox" id="<?=$arItem["CODE"]?><?=i?>" name="arrFilter_pf[PROPERTY_<?=$arItem["CODE"]?>][]" value="<?=$k?>" type="checkbox"<?=(in_array($k,$_REQUEST["arrFilter_pf"]["PROPERTY_".$arItem["CODE"]])?' checked':'')?> />
				<div class="name"><?=$v?></div>
			</div>
			<div class="clear"></div><?
				};
			};?>
		</div><?
		};?>
	</li><?
	};
};
	/*
	<?if(isset($_POST["arrFilter_pf"])):?>
	<input type="submit" name="set_filter" id="resetFilter" class="whiteBtn" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Сбросить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /><input type="hidden" name="set_filter" value="Y" />
	<?else:?>
	<input type="submit" name="set_filter" class="whiteBtn" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Показать&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /><input type="hidden" name="set_filter" value="Y" />
	<?endif;?>
	
	*/?>
	</ul>
</form>
