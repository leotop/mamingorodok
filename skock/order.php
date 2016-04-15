<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("iblock") && CModule::IncludeModule("sale"))
{
	$arResult["ORDER"] = CSaleOrder::GetByID(2617);
	
	if($arResult["ORDER"]["PAY_SYSTEM_ID"]>0)
		$arResult["ORDER"]["PAY_SYSTEM"] = CSalePaySystem::GetByID($arResult["ORDER"]["PAY_SYSTEM_ID"], $arResult["ORDER"]["PERSON_TYPE_ID"]);
	
	if($arResult["ORDER"]["DELIVERY_ID"]>0)
		$arResult["ORDER"]["DELIVERY"] = CSaleDelivery::GetByID($arResult["ORDER"]["DELIVERY_ID"]);
	
	$rsProp = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER"]["ID"]);
	while($arProp = $rsProp -> GetNext())
	{
		if($arProp["ORDER_PROPS_ID"] == 4)
			$arProp["VALUE"] = CSaleLocation::GetByID($arProp["VALUE"]);
		
		$arResult["ORDER"]["PROP"][$arProp["ORDER_PROPS_ID"]] = $arProp;
	}
	
	echo '<pre>'.print_r($arResult, true).'</pre>';
}
?>