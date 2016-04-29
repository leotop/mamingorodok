<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
echo '<div class="left_column_bg">';
$prevLevel = 0;
foreach($arResult["SECTIONS"] as $arS)
{
	if($arS["DEPTH_LEVEL"] == 1)
	{
		if($prevLevel == 2) echo '</ul>';
		echo '<a class="href1l" href="'.$arS["SECTION_PAGE_URL"].'"><h3>'.$arS["NAME"].'</h3></a>';
	} else {
		if($prevLevel == 1)
			echo '<ul>';
		echo '<li><a href="'.$arS["SECTION_PAGE_URL"].'">'.$arS["NAME"].'</a></li>';
	}
	$prevLevel = $arS["DEPTH_LEVEL"];
}
if($prevLevel == 2) echo '</ul>';
echo '</div>';
?>