<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="search-page">
<form action="" class="jqtransform" method="get">
<table cellspacing="2" cellpadding="0" border="0" class="blog-search">
	<tr>
		<td><?
		if($USER->IsAdmin()) echo '<input type="hidden" name="ss" value="ss">';?>
			<input type="text" name="q" value="<?=$_REQUEST["q"]?>" size="40" />
		</td>
		<td class="btnSB">
			<input type="submit" value="Поиск" />
		</td>
	</tr>
</table>
</form>
<br /><?
if(count($arResult["ITEMS"])>0)
{
	foreach($arResult["ITEMS"] as $arItem)
	{
		$strName = $arItem["NAME"].(strlen($arItem["PROPERTY_ARTICUL_VALUE"])>0?' ['.$arItem["PROPERTY_ARTICUL_VALUE"].']':'');
		preg_match_all("/".addslashes($_REQUEST["q"])."/is", $strName, $arM);
		if(count($arM[0])>0)
		{
			foreach($arM[0] as $strTmp)
				$strName = str_replace($strTmp, "<strong>".$strTmp."</strong>", $strName);
		}
		?>
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$strName?></a>
		<p><?=smart_trim(strip_tags($arItem["DETAIL_TEXT"]), 300)?></p>
		<hr /><?
	}
	
	if($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		echo '<br>'.showBreadcrumb($arResult["NAV_STRING"]);
	}
} else {
	ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
	<div class="top15"></div>
	<div>Измените запрос или попробуйте поискать в <a href="/catalog/">каталоге</a>.</div><?
}?>
</div>