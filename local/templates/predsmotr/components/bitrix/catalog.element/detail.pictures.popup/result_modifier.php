<?
$arSelect = array(
    "ID", 
    "IBLOCK_ID", 
    "NAME", 
    "DETAIL_PICTURE", 
    "PROPERTY_OLD_PRICE", 
    "PROPERTY_IMG_BIG", 
    "PROPERTY_SIZE", 
    "PROPERTY_COLOR_CODE", 
    "PROPERTY_COLOR_IMAGE",
    "PROPERTY_COLOR",
    "PROPERTY_ARTICUL",
    "PROPERTY_PICTURE_MINI",
    "PROPERTY_PICTURE_MIDI",
    "PROPERTY_PICTURE_MAXI"
);
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arResult["ID"]), false, false, $arSelect);    
while($obEl = $dbEl->GetNext())    
{           
    $arBasePrice = CPrice::GetBasePrice($obEl["ID"], false, false); // обязательно false false!!
    $obEl["PRICE"] = $arBasePrice["PRICE"];
    
    // все привязанные элементы
    $arResult["LINKED_ITEMS"][] = $obEl;
    
    // выбираем различные цвета и различные размеры
    if (!in_array($obEl["PROPERTY_COLOR_CODE_VALUE"], $arResult["LINKED_COLORS"]))
    {
        $arResult["LINKED_COLORS"][] = $obEl["PROPERTY_COLOR_CODE_VALUE"];
        $arResult["LINKED_COLORS_ITEMS"][] = $obEl;
    }
    if (!in_array($obEl["PROPERTY_SIZE_VALUE"], $arResult["LINKED_SIZES"]))
    {
        $arResult["LINKED_SIZES"][] = $obEl["PROPERTY_SIZE_VALUE"];
        $arResult["LINKED_SIZES_ITEMS"][] = $obEl;
    }
    $arResult["COLOR_SIZE"][$obEl["PROPERTY_COLOR_CODE_VALUE"]][$obEl["PROPERTY_SIZE_VALUE"]] = $obEl;
}
?>