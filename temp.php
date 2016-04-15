<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Аналитика");
?>
<?
$arFilter =array("IBLOCK_ID"=>CATALOG_IBLOCK_ID);
	$sectionHas = array();
	$db_list =  CIBlockSection::GetList(Array($by=>$order), $arFilter, true, array("XML_ID","ID","IBLOCK_SECTION_ID","NAME","SECTION_ID"));
	while($ar_result = $db_list->GetNext())  {
		//echo "<br><br>";
		if(!empty($ar_result["XML_ID"]) && intval($ar_result["IBLOCK_SECTION_ID"])>0){
		$section["ID"] = $ar_result["ID"];
		$section["PARENT_ID"] = $ar_result["IBLOCK_SECTION_ID"];
		$section["NAME"] = $ar_result["NAME"];
		$section["ELEMENT_CNT"] = $ar_result["ELEMENT_CNT"];
		$section["XML_ID"] =  $ar_result["XML_ID"];
		$sectionHas[] = $section;
		}
	}
	$doe = array();
	for($i=0;$i<count($sectionHas);$i++)
		for($j=0;$j<count($sectionHas);$j++)
			if($sectionHas[$i]["XML_ID"]==$sectionHas[$j]["XML_ID"] && $sectionHas[$i]["ID"]!=$sectionHas[$j]["ID"]){
				if($sectionHas[$i]["ELEMENT_CNT"]>0 && $sectionHas[$i]["ID"]>$sectionHas[$j]["ID"]){
					$param["IN"] = $sectionHas[$i]["ID"];
					$param["OUT"]  = $sectionHas[$j]["ID"];
					$param["ELEMENT_CNT"] = $sectionHas[$i]["ELEMENT_CNT"];
				}
				// else{
					// $param["IN"] = $sectionHas[$j]["ID"];
					// $param["OUT"]  = $sectionHas[$i]["ID"];
					// $param["ELEMENT_CNT"] = $sectionHas[$j]["ELEMENT_CNT"];
				// }	
				$param["NAME"] = $sectionHas[$i]["NAME"];
				$doe[] = $param;
			}
	//die(print_R($doe));
	global $DB;
	foreach($doe as $v){
		if($v["ELEMENT_CNT"]>0){
			$arFilter =array("IBLOCK_ID"=>CATALOG_IBLOCK_ID,"SECTION_ID"=>$v["IN"]);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID","IBLOCK_SECTION_ID"));
			while($ar_fields = $res->GetNext()){
				//echo $v["IN"]." ".$v["OUT"];
				//die(print_R($ar_fields));
				//if($ar_fields["IBLOCK_SECTION_ID"]==$v["IN"]){
					
					 $arLoadProductArray = array("IBLOCK_SECTION"=>$v["OUT"]);
					$el = new CIBlockElement;
					 $res2 = $el->Update($ar_fields["ID"], $arLoadProductArray);
					//$DB->Query("Update b_iblock_element SET IBLOCK_SECTION_ID='".$v["OUT"]."' where ID='".$ar_fields["ID"]."'");
					//die(print_R($ar_fields));
				//}
				
				//IBLOCK_SECTION_ID
			}
		}
	}
	
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
