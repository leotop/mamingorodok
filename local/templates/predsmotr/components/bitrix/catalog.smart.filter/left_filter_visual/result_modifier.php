<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$theme = COption::GetOptionString("main", "wizard_eshop_adapt_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$current_section_id=$arParams["SECTION_ID"];
$current_iblock_id=$arParams["IBLOCK_ID"];
// название текущей секции (для вывода в блоке "Ваш выбор")
if($current_section_id > 0) {
    $res = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $current_iblock_id, "ID" => $current_section_id), false);
    if($arSect = $res->GetNext()) {
        $current_section_name = $arSect["NAME"];
        $parent_section_id = $arSect["IBLOCK_SECTION_ID"];
    }
    //echo $parent_section_id;
    $arResult["current_section_name"] = $current_section_name;
    $arResult["parent_section_id"] = $parent_section_id;
}

// получаем инфу о родительском разделе
if($arParams["CURRENT_CATALOG_LEVEL"] == 2)
{
    $rsSec = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>$current_iblock_id, "ID"=>$arResult["parent_section_id"], "ACTIVE"=>"Y"), false);
    if($arSec = $rsSec -> GetNext())
        $arResult["PARENT_SECTION_URL"] = $arSec["SECTION_PAGE_URL"];
} else $arResult["PARENT_SECTION_URL"] = '/catalog/';

/*global $arPath;

function search($array,$parent_key="")
{
    global $arPath;
    static $finded=false;
     
    if (is_array($array))
    {
        foreach($array as $key=>$val)
        {
            if ($finded)
            {
                break;
            }
            else
            {
                search($val,$key);    
            }
        }
        
        if ($finded && $parent_key!=="")
        {
            $arPath[]=$parent_key;  
        }
    }
    else
    {
        if ($array === "CH_PRODUCER")
        {
            $arPath[]=$parent_key;
            $finded=true;
            return true;
        }
    }
}

search($arResult["ITEMS"]);

function GetFilteredArray($matchid, $array)
{
    $result = array();
    foreach ($array as $id => $childarray)
    {
        
        $filteredparents = GetFilteredArray($matchid, $childarray["parents"]);
        if ($id === $matchid || !empty($filteredparents))
        {
            $childarray["parents"] = $filteredparents;
            $result[$id] = $childarray;
        }
    }
    return $result;
}

arshow(GetFilteredArray(27167,$arResult["ITEMS"]));

/*$arPath=array_reverse($arPath);

$firstKey=$arPath[0];

$arKeys=array_keys($arResult["ITEMS"]);
$secondKey=$arKeys[0];

echo $firstKey;
echo $secondKey;

$arTemp=$arResult["ITEMS"][$firstKey];
$arResult["ITEMS"][$firstKey]=$arResult["ITEMS"][$secondKey];
$arResult["ITEMS"][$secondKey]=$arTemp;

arshow($arResult["ITEMS"]); */
//echo "key45=".$arr;


//CH_PRODUCER
