<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(method_exists($this, 'setFrameMode')) 
	$this->setFrameMode(true);
	
if(count($arResult['ELEMENTS']) > 1 && $arResult["ITEMS_COUNT_SHOW"]):
$arParams['MESSAGE_ALIGN'] = isset($arParams['MESSAGE_ALIGN']) ? $arParams['MESSAGE_ALIGN'] : 'LEFT';
$arParams['MESSAGE_TIME'] = intval($arParams['MESSAGE_TIME']) >= 0 ? intval($arParams['MESSAGE_TIME']) : 5;

include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");

CJSCore::Init(array("popup"));
$APPLICATION->AddHeadScript("/bitrix/js/kombox/filter/ion.rangeSlider.js");
$APPLICATION->AddHeadScript("/bitrix/js/kombox/filter/jquery.cookie.js");
$APPLICATION->AddHeadScript("/bitrix/js/kombox/filter/jquery.filter.js");
?>

<div class="kombox-filter" id="kombox-filter">
	<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get"<?if($arResult['IS_SEF']):?> data-sef="yes"<?endif;?>>
		<?foreach($arResult["HIDDEN"] as $arItem):?>
			<input
				type="hidden"
				name="<?echo $arItem["CONTROL_NAME"]?>"
				id="<?echo $arItem["CONTROL_ID"]?>"
				value="<?echo $arItem["HTML_VALUE"]?>"
			/>   
		<?endforeach;?>
		<ul>	
		<?
        //$arResult["SET_FILTER"] - если фильтр установлен, то = 1. Иначе - пустой.
        //$arResult["REQUEST"] - массив фильтруемых свойств
       // arshow($arResult["ITEMS"],true); 
        
      $url_brends = explode('/', $APPLICATION->GetCurPageParam());
      if($url_brends[2] == ""){
            foreach($arResult["ITEMS"] as $arItem):
            //arshow($arItem["NAME"],true);
                if($arItem["NAME"] == "Производитель" or $arItem["NAME"] == "Тип товара"){
                    //arshow($arResult["SET_FILTER"],true);
                    //если по свойству нет фильтрации, то сворачиваем его
                    if (!array_key_exists($arItem["CODE_ALT"],$arResult["REQUEST"]) && $arItem["CODE_ALT"] != "price" && $arItem["CODE_ALT"] != "proizvoditel") {
                       $arItem["CLOSED"] = true; 
                    }
                    
                    $showProperty = false;
                    if($arItem["SETTINGS"]["VIEW"] == "SLIDER")
                    {
                        if(isset($arItem["VALUES"]["MIN"]["VALUE"]) && isset($arItem["VALUES"]["MAX"]["VALUE"]) && $arItem["VALUES"]["MAX"]["VALUE"] > $arItem["VALUES"]["MIN"]["VALUE"])
                            $showProperty = true;
                    }
                    elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"]))
                    {
                        $showProperty = true;
                    }
                    ?>
                    <?if($showProperty):?>
                    <li class="lvl1<?if($arItem["CLOSED"]):?> kombox-closed<?endif;?> <?if($arItem["CODE_ALT"]=="roznichnaya"){ echo "priceHolder"; }?>" data-id="<?echo $arItem["CODE_ALT"].'-'.$arItem["ID"]?>">
                        <div class="kombox-filter-property-head">
                            <i class="kombox-filter-property-i"></i>
                            <span class="kombox-filter-property-name"><?echo $arItem["NAME"]?></span>
                            <?if(strlen($arItem['HINT'])):?>
                            <span class="kombox-filter-property-hint"></span>
                            <div class="kombox-filter-property-hint-text"><?echo $arItem['HINT']?></div>
                            <?endif;?>
                        </div>
                        <span class="for_modef"></span>    
                        <?komboxShowField($arItem);?>
                    </li>    
                    <?endif;?>
                <?}?>
            
            <?endforeach;
            }else{
                  foreach($arResult["ITEMS"] as $arItem):
                    //arshow($arResult["SET_FILTER"],true);
                    //если по свойству нет фильтрации, то сворачиваем его
                    if (!array_key_exists($arItem["CODE_ALT"],$arResult["REQUEST"]) && $arItem["CODE_ALT"] != "price" && $arItem["CODE_ALT"] != "proizvoditel") {
                       $arItem["CLOSED"] = true; 
                    }
                    
                    $showProperty = false;
                    if($arItem["SETTINGS"]["VIEW"] == "SLIDER")
                    {
                        if(isset($arItem["VALUES"]["MIN"]["VALUE"]) && isset($arItem["VALUES"]["MAX"]["VALUE"]) && $arItem["VALUES"]["MAX"]["VALUE"] > $arItem["VALUES"]["MIN"]["VALUE"])
                            $showProperty = true;
                    }
                    elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"]))
                    {
                        $showProperty = true;
                    }
                    ?>
                    <?if($showProperty):?>
                    <li class="lvl1<?if($arItem["CLOSED"]):?> kombox-closed<?endif;?> <?if($arItem["CODE_ALT"]=="roznichnaya"){ echo "priceHolder"; }?>" data-id="<?echo $arItem["CODE_ALT"].'-'.$arItem["ID"]?>">
                        <div class="kombox-filter-property-head">
                            <i class="kombox-filter-property-i"></i>
                            <span class="kombox-filter-property-name"><?echo $arItem["NAME"]?></span>
                            <?if(strlen($arItem['HINT'])):?>
                            <span class="kombox-filter-property-hint"></span>
                            <div class="kombox-filter-property-hint-text"><?echo $arItem['HINT']?></div>
                            <?endif;?>
                        </div>
                        <span class="for_modef"></span>    
                        <?komboxShowField($arItem);?>
                    </li>   
                   
                    <? 
                    
                    if($arItem['CODE']!='PROIZVODITEL') {
                    ?>
                    <?foreach($arItem["VALUES"] as $val => $ar) :
                        if ($ar['HTML_VALUE_ALT']) {?>
                    <?$controls[$ar["CONTROL_ID"]]["CODES"]=$arItem["CODE_ALT"].'-'.$ar["HTML_VALUE_ALT"];
                      $controls[$ar["CONTROL_ID"]]["VALUES"]=$ar["VALUE"];
                      $controls[$ar["CONTROL_ID"]]["COUNT"]=$ar["CNT"];
                        } endforeach;}
                    else{
                     foreach($arItem["VALUES"] as $val => $ar) :
                     if ($ar['CHECKED']=='1') {  
                     //arshow($ar);
                     $checked_brand=$ar['VALUE'];
                     }
                     endforeach; 
                    }
                      
                    ?> 
                    <?endif;?>
            
            <?endforeach;
            }?>  
		</ul>
		<input type="submit" id="set_filter" value="<?=GetMessage("KOMBOX_CMP_FILTER_SET_FILTER")?>" />
		<?if($arResult['SET_FILTER']):?>
		<a href="<?=$arResult["DELETE_URL"]?>" class="kombox-del-filter"><?=GetMessage("KOMBOX_CMP_FILTER_DEL_FILTER")?></a>
		<?endif;?>
        <?//arshow(($arResult["ELEMENT_COUNT"]),true)?>
		<div class="modef" id="modef" style="display:none">
			<div class="modef-wrap">
				<?echo GetMessage("KOMBOX_CMP_FILTER_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
				<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("KOMBOX_CMP_FILTER_FILTER_SHOW")?></a>
				<span class="ecke"></span>
			</div>
		</div>
	</form>
	<div class="kombox-loading"></div>
</div>
<script>
	$(function(){
		$('#kombox-filter').komboxSmartFilter({
			ajaxURL: '<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>',
			urlDelete: '<?echo CUtil::JSEscape($arResult["DELETE_URL"])?>',
			align: '<?echo $arParams['MESSAGE_ALIGN']?>',
			modeftimeout: <?echo $arParams['MESSAGE_TIME']?>
		});
	});
</script>
<?endif;?>
<div style="display:none;">
<?//arshow($controls)?>
<?$sect_list=CIBlockSection::GetByID($arParams["SECTION_ID"]);
//arshow($sect_list);
while($sect_list_fetch=$sect_list->Fetch()) { 
$checked_sections=$sect_list_fetch['NAME'].' ';
}?>
<?foreach ($controls as $cont_key) {
    if ($cont_key["COUNT"]!=0) {
  echo '<a href="'.$_SERVER["REDIRECT_URL"].$cont_key["CODES"].'/">'.$checked_sections.$checked_brand.' '.$cont_key["VALUES"].'</a><br>';  
        }
    }    
    ?></div> 
