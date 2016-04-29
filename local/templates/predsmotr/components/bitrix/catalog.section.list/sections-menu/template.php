<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// выбираем всех производителей
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "CODE", "NAME", "PREVIEW_PICTURE","PROPERTY_MENU_LINK"));    
while($obEl = $dbEl->GetNext())   
    $arProducers[$obEl["ID"]] = $obEl;
?>
<div class="menu">
	<table cellpadding="0" cellspacing="0">
		<tr><?
$isFirst = true;
$intRootSectionID = 0;
$strRootSectionCode = "";
$intRootCnt = 0;
foreach($arResult["SECTIONS"] as $key => $arSection)
{
	if(strlen($arSection["~UF_MENU_TITLE"])<=0) $arSection["~UF_MENU_TITLE"] = $arSection["~NAME"];
	
	if ($arSection["DEPTH_LEVEL"] == 1)
	{
		$intRootCnt++;
		
		if($key > 0)
		{
			$strClass = '';
			if($isFirst)
			{
				$strClass = ' class="first"';
				$isFirst = false;
			}
			
			$strTmp .= '</ul>';
			
			// get producers
			$arProducersIDs = array();
			foreach($arProducers as $k=>$v)
			{
				if(is_array($v["PROPERTY_MENU_LINK_VALUE"]) && in_array($intRootSectionID, $v["PROPERTY_MENU_LINK_VALUE"]))
					$arProducersIDs[] = $v["ID"];
			}
						
			if(count($arProducersIDs)>0)
			{
				$strTmp .= '<ul class="submenu_list submenu_list_popular"><li><span class="oh4">Популярные бренды</span></li>';
				foreach($arProducersIDs as $producerID)
				{
					$strTmp .= '<li><a href="/catalog/'.$strRootSectionCode.'/proizvoditel_'.$arProducers[$producerID]["CODE"].'/">'.$arProducers[$producerID]["NAME"].'</a></li>';
				}
				$strTmp .= '</ul>';
			} else $strTmp = str_replace('class="submenu_list"', 'class="submenu_list alone"', $strTmp);
			$strTmp .= '<div class="clear"></div></div></div>';
			?>
			<td<?=$strClass?>>
				<?=$strTmp?>
			</td><?
		}
		
		$intRootSectionID = $arSection["ID"];
		$strRootSectionCode = $arSection["CODE"];
		
		$strTmp = '';
		
		$strTmp .= '<div class="submenu'.($intRootCnt>5?' submenu_right':'').'"> <a'.(strpos($arSection["~UF_MENU_TITLE"], " ")!=false?' class="two_line"':'').' href="'.$arSection["SECTION_PAGE_URL"].'" title="'.$arSection["NAME"].'">'.$arSection["~UF_MENU_TITLE"].'</a><div class="submenu_popap"><ul class="submenu_list">';
		
	} else {
		$strTmp .= '<li><a href="'.$arSection["SECTION_PAGE_URL"].'" title="'.$arSection["NAME"].'">'.$arSection["~UF_MENU_TITLE"].'</a></li>';
	}
}

if(strlen($strTmp)>0)
{
	$strTmp .= '</ul>';
			
	// get producers
	$arProducersIDs = array();
	foreach($arProducers as $k=>$v)
	{
		if(is_array($v["PROPERTY_MENU_LINK_VALUE"]) && in_array($intRootSectionID, $v["PROPERTY_MENU_LINK_VALUE"]))
			$arProducersIDs[] = $v["ID"];
	}
				
	if(count($arProducersIDs)>0)
	{
		$strTmp .= '<ul class="submenu_list submenu_list_popular"><li><span class="oh4">Популярные бренды</span></li>';
		foreach($arProducersIDs as $producerID)
		{
			$strTmp .= '<li><a href="/catalog/'.$strRootSectionCode.'/proizvoditel_'.$arProducers[$producerID]["CODE"].'/">'.$arProducers[$producerID]["NAME"].'</a></li>';
		}
		$strTmp .= '</ul>';
	} else $strTmp = str_replace('class="submenu_list"', 'class="submenu_list alone"', $strTmp);
	$strTmp .= '<div class="clear"></div></div></div>';
			?>
			<td class="last">
				<?=$strTmp?>
			</td><?
}
?>
		</tr>
	</table>
</div>