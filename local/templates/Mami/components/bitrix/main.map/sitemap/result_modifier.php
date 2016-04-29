<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	
	
	$children = array();
	
	function CreateChildren($parent=0,$deap=1){
		$res=array();
		
		$arFilter = Array(
		'IBLOCK_ID'=>CATALOG_IBLOCK_ID, 
		'ACTIVE'=>'Y'
		);
		
		if($parent!=0){
			$arFilter["SECTION_ID"] = $parent;
		}
		elseif($deap>0){
			$arFilter["DEPTH_LEVEL"] = $deap;
		}	
		
		$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false);
		
		while($ar_result = $db_list->GetNext())  {   
			$res[] = array(
				"LEVEL"=>$ar_result["DEPTH_LEVEL"],
				"ID"=>md5($ar_result["NAME"]),
				"IS_DIR" =>"Y",
				"NAME"=> $ar_result["NAME"],
				"PATH"=> $_SERVER["DOCUMENT_ROOT"].$ar_result["LIST_PAGE_URL"],
				"FULL_PATH"=>"/catalog/".$ar_result["ID"]."/",
				"SEARCH_PATH"=>"/catalog/".$ar_result["ID"]."/",
				"DESCRIPTION"=>"",
				"CHILDREN" => CreateChildren($ar_result["ID"])
			);
		}
		
		return $res;
	}
	
	function CreateMap($ch,&$count){
		
		foreach($ch as $v){
			
			$r[] = array(
				"LEVEL"=>$v["LEVEL"],
				"ID"=>$v["ID"],
				"IS_DIR" =>"Y",
				"NAME"=> $v["NAME"],
				"PATH"=> $v["PATH"],
				"FULL_PATH"=>$v["FULL_PATH"],
				"SEARCH_PATH"=>$v["SEARCH_PATH"],
				"DESCRIPTION"=>"",
				"STRUCT_KEY"=> $count
			);
			
			if(count($v["CHILDREN"])>0){
				$r = array_merge($r,CreateMap($v["CHILDREN"],$count));
			}
			
			$count++;
		}
		return $r;
	}
	
	$children = CreateChildren();
	
	$arResult["arMapStruct"][] = array(
		"LEVEL"=>0,
		"ID"=>md5("catalog"),
		"IS_DIR" =>"Y",
		"NAME"=> "Каталог",
		"PATH"=> $_SERVER["DOCUMENT_ROOT"],
		"FULL_PATH"=>"/catalog/",
		"SEARCH_PATH"=>"/catalog/",
		"DESCRIPTION"=>"",
		"CHILDREN" => $children	
	);
	
	$count = count($arResult["arMapStruct"]);
	$childrenMap = CreateMap($children,$count);
	
	//print_R($childrenMap);
	
	$arResult["arMap"][] = Array(
		"LEVEL" => 0,
		"ID" => md5("catalog"),
		"IS_DIR" => "Y",
		"NAME" => "Каталог",
		"PATH" => $_SERVER["DOCUMENT_ROOT"],
		"FULL_PATH" => "/catalog/",
		"SEARCH_PATH" => "/catalog/",
		"DESCRIPTION" => "",
		"STRUCT_KEY" => count($arResult["arMap"])
	);
	
	//print_R($children);
	// $struct = array();
	// $i = count($arResult["arMap"]);
	// foreach($children as $k=>$ch){
		// $child = $ch["CHILDREN"]
		// $children[$k]
		// $struct
	// }
	$arResult["arMap"] = array_merge($arResult["arMap"],$childrenMap);
	
	//	print_R($arResult);
?>
