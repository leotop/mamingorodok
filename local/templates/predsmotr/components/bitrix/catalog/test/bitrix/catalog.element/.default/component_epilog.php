<?
$APPLICATION->AddHeadString('
<meta property="og:title" content="'.$arResult["NAME"].'"/>
<meta property="og:type" content="product"/>
<meta property="og:url" content="http://www.mamingorodok.ru'.$APPLICATION->GetCurPage().'"/>
<meta property="og:description" content="'.$arResult["NAME"].'"/>
<meta property="og:image" content="http://www.mamingorodok.ru'.(strlen($arResult["DETAIL_PICTURE"]["SRC"])>0?$arResult["DETAIL_PICTURE"]["SRC"]:'/bitrix/templates/nmg/img/logo.png').'"/>', true);

//$APPLICATION->AddHeadScript('https://kupivkredit-test-fe.tcsbank.ru:8100/widget/vkredit.js');
$APPLICATION->AddHeadScript('https://www.kupivkredit.ru/widget/vkredit.js');
$APPLICATION->AddHeadScript('/bitrix/templates/nmg/components/individ/catalog.element/newCard/script_card.js?'.substr(md5(filemtime($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/nmg/components/individ/catalog.element/newCard/script.js')), 0, 10));

$intShowOffer = intval($_REQUEST["showOffer"]);
if($intShowOffer)
{
	$rsO = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>$intShowOffer), false, false, array("PROPERTY_SIZE"));
	if($arO = $rsO -> GetNext())
	{ ?>
<script type="text/javascript">
	$(document).ready(function() {
		if($("#lisize_<?=md5($arO["PROPERTY_SIZE_VALUE"])?>").size())
			$("#lisize_<?=md5($arO["PROPERTY_SIZE_VALUE"])?> a").click();
		$("#smallOffer<?=$intShowOffer?>").click();
	});
</script>
<?
	}
}

if(isset($arResult["PROPERTIES"]["title"]["VALUE"]) && !empty($arResult["PROPERTIES"]["title"]["VALUE"]))
{
	$APPLICATION->SetPageProperty("headertitle",$arResult["PROPERTIES"]["title"]["VALUE"]);

}


	
?>
