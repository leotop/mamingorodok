<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
CModule::IncludeModule("catalog");

foreach($arResult["ITEMS"] as $k=>$v){
	$arFilter = Array(   
			"IBLOCK_ID"=>OFFERS_IBLOCK_ID,    
			"ACTIVE"=>"Y", 
			"PROPERTY_CML2_LINK"=>$v["ID"]
			);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false);
	$buy = false;
	while($ar_fields = $res->GetNext()){  
		$id_tovars[] = $ar_fields["ID"];		
	}
	$db_res = CCatalogProduct::GetList(
        array(),
        array("ID" => $id_tovars),
        false,
        false,
		array("ID","QUANTITY")
    );
	while ($ar_res = $db_res->Fetch())
	{
		if($ar_res["QUANTITY"]>0)
			$buy = true;
	}


	$arResult["ITEMS"][$k]["BUY"] = $buy;
}

?>

