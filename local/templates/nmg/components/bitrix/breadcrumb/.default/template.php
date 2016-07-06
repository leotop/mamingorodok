<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
    return "";

global $APPLICATION;

$arTmp = array();
foreach($arResult as $intKey => $arItem)
    if($arItem["LINK"] != "/catalog/") $arTmp[] = $arItem;

$arResult = $arTmp;

$strReturn = '<div class="crumbs">';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
    if($index > 0) {
        $strReturn .= ' &rarr; ';
    }
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    if($arResult[$index]["LINK"] <> "" && $index + 1 < count($arResult)) {
        $class_string = (strpos($APPLICATION->GetCurDir(), "/basket/order/") == 0 && (strpos($arResult[$index]["LINK"], "/basket/order/")) == 0) || $title == "Способ оплаты"?' class="backstep"' : '';
        $strReturn .= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a' . $class_string . ' href="' . $arResult[$index]["LINK"] . '" title="' . $title . '">
                <span itemprop="title">' . $title . '</span>
            </a>
        </span>';
    } else {
        $strReturn .= $title;

    }
}
$strReturn .= '</div>';

return $strReturn;
?>
