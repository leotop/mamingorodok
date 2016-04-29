<?
$APPLICATION->AddHeadString('
<meta property="og:title" content="'.$arResult["NAME"].'"/>
<meta property="og:type" content="product"/>
<meta property="og:url" content="http://www.mamingorodok.ru'.$APPLICATION->GetCurPage().'"/>
<meta property="og:description" content="'.$arResult["NAME"].'"/>
<meta property="og:image" content="http://www.mamingorodok.ru'.(strlen($arResult["DETAIL_PICTURE"]["SRC"])>0?$arResult["DETAIL_PICTURE"]["SRC"]:'/bitrix/templates/nmg/img/logo.png').'"/>', true);


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