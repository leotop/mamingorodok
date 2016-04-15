<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$strLink = '';
if(strpos($_SERVER['HTTP_REFERER'], "mamingorodok.ru") !== false && $_REQUEST["set_filter"] == "Y")
{
	CModule::IncludeModule("iblock");
	if(!is_array($_REQUEST["arrLeftFilter_pf"])) $_REQUEST["arrLeftFilter_pf"] = array();
	if($_REQUEST["currSection"]>0)
	{
		$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$_REQUEST["currSection"], "ACTIVE"=>"Y"), false);
		$arS = $rsS -> GetNext();
	}
	
	if(empty($_REQUEST["arrLeftFilter_pf"]["PRICE"]["LEFT"]) && empty($_REQUEST["arrLeftFilter_pf"]["PRICE"]["RIGHT"]))
	{
		unset($_REQUEST["arrLeftFilter_pf"]["PRICE"]);
		if(count($_REQUEST["arrLeftFilter_pf"]) == 1 && count($_REQUEST["arrLeftFilter_ff"])==0)
		{
			if(is_array($_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"]) && count($_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"]) == 1)
			{
				$rsProd = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "ID"=>$_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"][0]), false, false, array("NAME", "ID", "CODE"));
				if($arProd = $rsProd -> GetNext())
					$strLink = '/catalog/'.$arS["CODE"].'/proizvoditel_'.$arProd["CODE"].'/';
			} else {
				foreach($_REQUEST["arrLeftFilter_pf"] as $strCode => $arVal)
				{
					$rsProp = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "ACTIVE"=>"Y", "DETAIL_TEXT"=>$strCode, "PREVIEW_TEXT"=>implode(",", $arVal)), false, false, array("NAME", "ID", "CODE"));
					if($arProp = $rsProp -> GetNext())
						$strLink = '/catalog/'.$arS["CODE"].'/tip-'.$arProp["CODE"].'/';
				}
			}
		}
	}
}

echo $strLink;
?>