<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["BANNER"] = str_replace('rel="nofollow"', '', $arResult["BANNER"]);
echo $arResult["BANNER"];
?>