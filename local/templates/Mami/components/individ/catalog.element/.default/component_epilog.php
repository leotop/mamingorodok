<?

  if(isset($arResult["PROPERTIES"]["title"]["VALUE"]) && !empty($arResult["PROPERTIES"]["title"]["VALUE"])){
	 $APPLICATION->SetPageProperty("headertitle",$arResult["PROPERTIES"]["title"]["VALUE"]);
	// echo $arResult["META"]["UF_TITLE"];
	 }
// if(isset($arResult["keywords"]) && !empty($arResult["keywords"]))
	// $APPLICATION->SetPageProperty("keywords",$arResult["keywords"]);
	// if(isset($arResult["description"]) && !empty($arResult["description"])){
	// $APPLICATION->SetPageProperty("description",$arResult["description"]);
		
	// }
// else{
	// $APPLICATION->SetPageProperty("keywords","");
	// $APPLICATION->SetPageProperty("description","");
// }
	
?>