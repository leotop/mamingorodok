<?
//print_R($arResult);
    // global $APPLICATION;


if(isset($arResult["META"]["UF_KEYWORDS"]) && !empty($arResult["META"]["UF_KEYWORDS"]))
    $APPLICATION->SetPageProperty("keywords",$arResult["META"]["UF_KEYWORDS"]);

if(isset($arResult["META"]["UF_DESCRIPTION"]) && !empty($arResult["META"]["UF_DESCRIPTION"]))
    $APPLICATION->SetPageProperty("description",$arResult["META"]["UF_DESCRIPTION"]);

$GLOBALS["ALLELEMENT"] = $arResult["ALLELEMENT"];?>


