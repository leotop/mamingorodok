<?

$arProductID = array();
$arResult["PRODUCT_ACTION"] = array();

if(count($arResult["ITEMS"]["AnDelCanBuy"]) <= 0) {
	unset($_SESSION["PRODUCTS"]);
	unset($_SESSION["certificates"]);
}

foreach($arResult["ITEMS"]["AnDelCanBuy"] as $k => $arBasketItems) {
	$arFilter = Array(
		"ID" => $arBasketItems["PRODUCT_ID"],
		"ACTIVE" => "Y",
	);

	// if($USER->IsAdmin()){
	// print_R($arFilter);
	// echo "<br><br>";
	// }
	$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array(
		"NAME",
		"PROPERTY_COLOR",
		"PROPERTY_SIZE",
		"PROPERTY_CML2_LINK",
		"PROPERTY_PICTURE_MIDI",
		"PROPERTY_CML2_LINK.DETAIL_PAGE_URL",
		"ID",
		"PROPERTY_CML2_LINK.PROPERTY_OLD_PRICE",
		"IBLOCK_ID",
		"PROPERTY_CML2_LINK.PROPERTY_CH_VYBIRAEM"
	));

	if($ar_fields = $res->GetNext()) {
		$arProductID[] = $ar_fields["PROPERTY_CML2_LINK_VALUE"];

		global $USER;
		// if($USER->IsAdmin()){
		// print_R($ar_fields);
		// }
		//print_R($ar_fields);
		//echo CFile::GetPath($ar_fields["PROPERTY_PICTURE_MIDI_VALUE"]);

		$arResult["ITEMS"]["AnDelCanBuy"][$k]["OLD_PRICE"] = $ar_fields["PROPERTY_CML2_LINK_PROPERTY_OLD_PRICE_VALUE"];
		$arResult["ITEMS"]["AnDelCanBuy"][$k]["IMAGE"] = $ar_fields["PROPERTY_PICTURE_MIDI_VALUE"];
		$arResult["ITEMS"]["AnDelCanBuy"][$k]["COLOR"] = $ar_fields["PROPERTY_COLOR_VALUE"];
		$arResult["ITEMS"]["AnDelCanBuy"][$k]["SIZE"] = $ar_fields["PROPERTY_SIZE_VALUE"];
		$arResult["ITEMS"]["AnDelCanBuy"][$k]["NAME"] = $ar_fields["NAME"];
		$arResult["ITEMS"]["AnDelCanBuy"][$k]["CHOOSE_WHAT"] = (empty($ar_fields["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"])?'Размер':$ar_fields["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"]);
		$arFilter2 = Array(
			"ID" => $ar_fields["PROPERTY_CML2_LINK_VALUE"],
			"ACTIVE" => "Y",
		);
		$res2 = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter2, false, false, array(
			"NAME",
			"IBLOCK_SECTION_ID",
			"PROPERTY_RATING"
		));
		if($ar_fields2 = $res2->GetNext()) {
			$arResult["ITEMS"]["AnDelCanBuy"][$k]["NAME"] = $ar_fields2["NAME"];
			$arResult["ITEMS"]["AnDelCanBuy"][$k]["RATING"] = $ar_fields2["PROPERTY_RATING_VALUE"];
			$arResult["ITEMS"]["AnDelCanBuy"][$k]["URL"] = $ar_fields["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"];
			//"/catalog/".$ar_fields2["IBLOCK_SECTION_ID"]."/".$ar_fields["PROPERTY_CML2_LINK_VALUE"]."/";
		}
	}

}

// actions here
if(count($arProductID) > 0) {
	$strSearch = '';
	foreach($arProductID as $intID) $strSearch .= (strlen($strSearch) > 0?' || ':'').'#'.$intID.'#';

	$rsAction = CIBlockElement::GetList(Array(), array(
		"IBLOCK_ID" => 18,
		"ACTIVE" => "Y",
		"DATE_ACTIVE" => "Y",
		"?PROPERTY_ITEMS" => $strSearch
	), false, false, array(
		"ID",
		"NAME",
		"DETAIL_PICTURE",
		"DETAIL_PAGE_URL",
		"PROPERTY_BASKET_TEXT",
		"PROPERTY_ITEMS",
		"PREVIEW_PICTURE"
	));
	while($arAction = $rsAction->GetNext()) {
		if($arAction["PREVIEW_PICTURE"] > 0) $arAction["PREVIEW"] = CFile::GetFileArray($arAction["PREVIEW_PICTURE"]);
		elseif($arAction["DETAIL_PICTURE"] > 0) $arAction["PREVIEW"] = CFile::GetFileArray($arAction["DETAIL_PICTURE"]);

		$arResult["ACTIONS"][] = $arAction;
	}
}

global $USER;
if($USER->IsAuthorized()) {
	$arFilter = Array(
		"IBLOCK_ID" => CERTIFICATES_IBLOCK_ID,
		"ACTIVE" => "Y",
		"PROPERTY_HAVE" => $USER->GetID()
	);

	$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, array("*"));

	while($ar_fields = $res->GetNextElement()) {
		$db_props = $ar_fields->GetProperties();
		$db_field = $ar_fields->GetFields();
		//$ar_props;
		//print_R($db_props);
		$CERT = "";
		foreach($db_props["HAVE"]["VALUE"] as $k => $have) {
			if($have == $USER->GetID()) {
				if(intval($db_props["HAVE"]["DESCRIPTION"][$k]) > 0) $CERT = array(
					"ID" => $db_field["ID"],
					"NAME" => $db_field["NAME"],
					"PICTURE" => $db_field["PREVIEW_PICTURE"],
					"PRICE" => $db_props["PRICE"]["VALUE"],
					"COUNT" => $db_props["HAVE"]["DESCRIPTION"][$k]
				);
			}

		}

		if(is_array($CERT)) $arResult["CERT"][] = $CERT;
	}

}

$sale = 0;
if(isset($_SESSION["certificates"]) && !empty($_SESSION["certificates"]) && is_array($_SESSION["certificates"]) && count($_SESSION["certificates"]) > 0) {

	foreach($_SESSION["certificates"] as $k => $val) {
		$price = 0;
		$db_props = CIBlockElement::GetProperty(CERTIFICATES_IBLOCK_ID, $k, array("sort" => "asc"), Array("CODE" => "PRICE"));
		if($ar_props = $db_props->Fetch()) $price = IntVal($ar_props["VALUE"]);
		$sale += $price * $val;
	}
}

$arResult["SALE"] = $sale;
?>