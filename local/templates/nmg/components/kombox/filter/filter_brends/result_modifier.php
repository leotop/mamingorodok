<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
function cmp($a, $b)
{
    if(!$a["CHECKED"] && !$b["CHECKED"]){
        if ($a["VALUE"] == $b["VALUE"]) {
            return 0;
        }
        return ($a["VALUE"] < $b["VALUE"]) ? -1 : 1; 
    }else{
        if ($a["CHECKED"] == $b["CHECKED"]) {
            return 0;
        }
        return ($a["CHECKED"] > $b["CHECKED"]) ? -1 : 1; 
    } 
}

foreach ($a as $key => $value) {
    echo "$key: $value\n";
}
?>
<?

foreach ($arResult["ITEMS"] as $key=>$arItem) {
      usort($arItem["VALUES"], "cmp"); 
       
      $select = 0;
     foreach ($arItem["VALUES"] as $val=>$ar){
        if($ar["CHECKED"]){
            $select++;
        }
     } 
     $arItem["SELECTED_ITEMS"] = $select;
     $arResult["ITEMS"][$key] = $arItem;
}
?>