<?

if (!CModule::IncludeModule("forum")){
	return false;
}


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

$arResult["COUNT_REPORTS"] = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$arResult["ID"]),true);

$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MAIN_PRODUCT"=>$arResult["ID"]), false, false, $arSelect);    
while($obEl = $dbEl->GetNext())    
{
    $arBasePrice = CPrice::GetBasePrice($obEl["ID"], false, false); // ����������� false false!!
	//print_R($arBasePrice);
	$pr = explode(".",$arBasePrice["PRICE"]);
	if(isset($pr[1])){
		$pr2 = intval($pr[1]);
		if($pr2==0)
			$arBasePrice["PRICE"] = $pr[0];
	}
    $obEl["PRICE"] = $arBasePrice["PRICE"];
    
    $ar_res = CCatalogProduct::GetByID($obEl["ID"]);
    $obEl["QUANTITY"] = $ar_res["QUANTITY"];
    // ��� ����������� ��������
    $arResult["LINKED_ITEMS"][] = $obEl;
	
    // �������� ��������� ����� � ��������� �������
    if (!in_array($obEl["PROPERTY_COLOR_CODE_VALUE"], $arResult["LINKED_COLORS"]))
    {
		if(intval($obEl["PRICE"])>0){
        $arResult["LINKED_COLORS"][] = $obEl["PROPERTY_COLOR_CODE_VALUE"];
        $arResult["LINKED_COLORS_ITEMS"][] = $obEl;
		}
    }
	//echo $obEl["PROPERTY_SIZE_VALUE"]."---<br>";
    if (!in_array($obEl["PROPERTY_SIZE_VALUE"], $arResult["LINKED_SIZES"]))
    {
		if(intval($obEl["PRICE"])>0){
        $arResult["LINKED_SIZES"][] = $obEl["PROPERTY_SIZE_VALUE"];
        $arResult["LINKED_SIZES_ITEMS"][] = $obEl;
		}
    }
    $arResult["COLOR_SIZE"][$obEl["PROPERTY_COLOR_CODE_VALUE"]][$obEl["PROPERTY_SIZE_VALUE"]] = $obEl;
}
SortArray( $arResult["LINKED_COLORS_ITEMS"], "PRICE");


// ���������� 
if(!empty($arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]))
{
    $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID" => $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"]), false, false, array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PREVIEW_PICTURE", "PROPERTY_PRICE", "PROPERTY_OLD_PRICE", "PROPERTY_RATING"));    
    while($obEl = $dbEl->GetNext())    
    {           
        $arResult["ACCESSORIES_ITEMS"][] = $obEl;
    }
}
//print_R($arResult);

$arFilter = Array(
				'IBLOCK_ID'=>$arResult["IBLOCK_ID"], 
				"ID"=>$arResult["IBLOCK_SECTION_ID"]
				);  
				//print_R($arFilter);
$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false,array("ID","UF_HARACTERISTICS"));
if($ar_result = $db_list->GetNext())  {    
	$arResult["HARACTERISTICS"] = $ar_result["UF_HARACTERISTICS"];
}  

if(!CModule::IncludeModule("forum")){
	return;
}
//print_R();
//
$countOtz = 0;
$db_res = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>1,"PARAM2"=>$arResult["ID"]));
while ($ar_res = $db_res->Fetch())
{
 $countOtz++;
}
$arResult["PROPERTIES"]["VOTES"]["VALUE"] = $countOtz;
//print_R();

// if(is_object($this->__component))
	// {
		// $this->__component->$arResult["title"] = $arResult["PROPERTIES"]["title"]["VALUE"];
		// $this->__component->$arResult["description"]= $arResult["PROPERTIES"]["description"]["VALUE"];
		// $this->__component->$arResult["keywords"]= $arResult["PROPERTIES"]["keywords"]["VALUE"];
		// $this->__component->SetResultCacheKeys(array("title"));	
	// }
?>
