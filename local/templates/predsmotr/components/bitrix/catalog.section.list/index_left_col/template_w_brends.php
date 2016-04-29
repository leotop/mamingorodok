<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// выбираем всех производителей
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_INDEX_LEFT_COL"=>false), false, false, array("ID", "IBLOCK_ID", "CODE", "NAME","PROPERTY_INDEX_LEFT_COL"));    
while($obEl = $dbEl->GetNext())   
    $arProducers[$obEl["ID"]] = $obEl;
?>
<div class="left_column_bg">
	<h3 class="title">ѕопул€рные бренды</h3><?

$strTmp = '';
foreach($arResult["SECTIONS"] as $key => $arSection)
{
	// get producers for current section
	$arProducersIDs = array();
	foreach($arProducers as $k=>$v)
	{
		if(is_array($v["PROPERTY_INDEX_LEFT_COL_VALUE"]) && in_array($arSection["ID"], $v["PROPERTY_INDEX_LEFT_COL_VALUE"]))
			$arProducersIDs[] = $v["ID"];
	}
	
	if(count($arProducersIDs)>0)
	{
		$strTmp .= '<h3>'.$arSection["NAME"].'</h3><ul>';
		foreach($arProducersIDs as $producerID)
		{
			$strTmp .= '<li><a href="/catalog/'.$arSection["CODE"].'/proizvoditel_'.$arProducers[$producerID]["CODE"].'/">'.$arProducers[$producerID]["NAME"].'</a></li>';
		}
		$strTmp .= '</ul>';
	}
}
echo $strTmp;
?>
</div>