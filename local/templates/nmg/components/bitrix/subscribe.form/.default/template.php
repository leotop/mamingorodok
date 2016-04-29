<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe-form">
<form class="jqtransform former" action="<?=$arResult["FORM_ACTION"]?>">
<label>Выбирите подписку</label>
<div class="clear"></div>
<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
	
	<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <span class="compare_link"><?=$itemValue["NAME"]?></span>
	<br />
<?endforeach;?>
<div class="clear"></div>
<input type="text" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" />
<div class="clear"></div>
	
<div class="input-f">
<input type="submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" /></td>
</div>

</form>
</div>
