<?

if(count($arResult["ITEMS"])>0 && $arParams["ES_TYPE"] == "advertising")
{
	
	$arTmp = array();
	foreach($arResult["ITEMS"] as $arB)
	{
		$arBannerID[] = $arB["ID"];
		$arTmp[$arB["ID"]] = $arB;
	}
	
	$rsBanners = CAdvBanner::GetList($by, $order, array("ID"=>implode(" | ", array_keys($arTmp))), $is_filtered, "N");
	$arResult["ITEMS"] = array();
	while($arBanner = $rsBanners -> GetNext())
		$arResult["ITEMS"][$arBanner["WEIGHT"]] = $arTmp[$arBanner["ID"]];
	
	unset($arTmp);
	
	ksort($arResult["ITEMS"]);
}


?>