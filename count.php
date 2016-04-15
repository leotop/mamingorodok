<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");    

global $USER;
$user_id = $USER->GetID();

if(CModule::IncludeModule("sale")) {
	$dbBasketItems = CSaleBasket::GetList(
	array(
			"NAME" => "ASC",
			"ID" => "ASC"
			),
	array(
			"FUSER_ID" => CSaleBasket::GetBasketUserID(),
			"LID" => SITE_ID,
			"ORDER_ID" => "NULL"
			),
	false,
	false,
	array()
	);
	while ($arItems = $dbBasketItems->Fetch())
	{
		$arBasketItems[] = $arItems;
	}
	if(count($arBasketItems)>0) {
		$qua='';
		foreach($arBasketItems as $v) {
			$qua += $v["QUANTITY"];
		}
	}
}
        
echo $qua;
?>