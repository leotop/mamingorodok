<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<div class="crumb-layer"><div id="BreadCrumb">';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	if($index > 0)
		$strReturn .= '<span class="delim"></span>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "" && $index+1 < count($arResult))
		$strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>';
	else
		{
		if($index == $itemSize-1)
			$class = " class='nourl'";
		else
			$class = "";
		$strReturn .= '<span'.$class.'>'.$title.'</span>';
		}
}

$strReturn .= '<div class="clear"></div></div></div>';
return $strReturn;
?>
