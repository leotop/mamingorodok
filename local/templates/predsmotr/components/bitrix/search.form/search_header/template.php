<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="sk-search">
	<div class="sk-search--input">
		<form action="<?=$arResult["FORM_ACTION"]?>">
			<input name="q" type="text" data-placeholder="����� �� �����" value="<?=(empty($_REQUEST["q"])?'����� �� �����':$_REQUEST["q"])?>" />
			<input type="submit" class="search_header_submit" name="s" value="" />
		</form>
	</div>
</div>