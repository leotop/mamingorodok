<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
// выбираем всех производителей
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE","PROPERTY_MENU_LINK"));    
while($obEl = $dbEl->GetNext())    
{           
    $arProducers[$obEl["ID"]] = $obEl;
}
$fSL = false;
?>

<?foreach($arResult["SECTIONS"] as $key => $arSection):?>
	<?//print_R($arSection)?>
    <?if ($arSection["DEPTH_LEVEL"] == 1):?>
        <?if ($key == 0):?>
            <div id="CatMenu">
            <a href="/catalog/" id="CatHead"></a>
            <div class="FirstLevel">
            <div class="flt">
                <ul>
                    <li class="first"><div class="sep"></div><a href="/catalog/<?=$arSection["ID"]?>/"><?=$arSection["NAME"]?></a>
                        <div class="SecondLevel "><div class="tp"></div>
                            <ul class="sl_ul">
                            
                            <? // получаем производителей секции 
							$fSL = true;
                            $last_first_level_section_id = $arSection["ID"];
                            unset($arProducersIDs);
                            // $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MENU_LINK" => $arSection["ID"]), false, false, array("ID", "IBLOCK_ID"));    
                            // while($obEl = $dbEl->GetNext())    
                            // {      
                                // $arProducersIDs[] = $obEl["ID"];
                            // }
							foreach($arProducers as $k=>$v){
								if(is_array($v["PROPERTY_MENU_LINK_VALUE"]) && in_array($arSection["ID"],$v["PROPERTY_MENU_LINK_VALUE"])){
									$arProducersIDs[] = $v["ID"];
								}
							}
							//print_R( $arProducersIDs);
                            ?>
                
        <?else:?>
                    </ul>
						<?//echo $key."<br>";?>
						<?//print_R($arProducersIDs)?>
						<?if (!empty($arProducersIDs)):?>
						<ul class="brands">
							<li class="title first">Популярные бренды</li>
							<?foreach($arProducersIDs as $producer_id):?>
								<?/*<li><a href="/catalog/<?=$last_first_level_section_id?>/?arrLeftFilter_pf[CH_PRODUCER][]=<?=$producer_id?>&set_filter=Y"><img src="<?=CFile::GetPath($arProducers[$producer_id]["PREVIEW_PICTURE"]);?>" /></a></li>*/?>
								<li><a href="/catalog/<?=$last_first_level_section_id?>/?arrLeftFilter_pf[CH_PRODUCER][]=<?=$producer_id?>&set_filter=Y"><?=$arProducers[$producer_id]["NAME"]?></a></li>
							<?endforeach?>
						</ul>
					<?endif?>
					<div class="clear"></div>
					<div class="bp"><div></div></div>
					
                </div>
            </li>
            <li><div class="sep"></div><a href="/catalog/<?=$arSection["ID"]?>/"><?=$arSection["NAME"]?></a>
                <div class="SecondLevel "><div class="tp"></div>
                    <ul class="sl_ul">
                    
                    <? // получаем производителей секции 
						$fSL = true;
                        $last_first_level_section_id = $arSection["ID"];
                        unset($arProducersIDs);
                        // $dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>PRODUCERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_MENU_LINK" => $arSection["ID"]), false, false, array("ID", "IBLOCK_ID"));    
                        // while($obEl = $dbEl->GetNext())    
                        // {           
                            // $arProducersIDs[] = $obEl["ID"];
                        // }
						foreach($arProducers as $k=>$v){
								if(is_array($v["PROPERTY_MENU_LINK_VALUE"]) && in_array($arSection["ID"],$v["PROPERTY_MENU_LINK_VALUE"])){
									$arProducersIDs[] = $v["ID"];
								}
							}
						//print_R( $arProducersIDs);
                    ?>
                    
        <?endif?>
    <?else:?>
        <li <?=$fSL?'class="first"':''?> ><a href="/catalog/<?=$arSection["ID"]?>/"><?=$arSection["NAME"]?></a><?/* <span><?=$arSection["ELEMENT_CNT"]?></span>*/?><div class="clear"></div></li>
		<?$fSL = false;?>
    <?endif?>

    <?$last_depth_level = $arSection["DEPTH_LEVEL"];?>
<?endforeach?>
<?if ($last_depth_level == 2):?>
					<?//unset($arProducersIDs);?>
				</ul>
                    <?if (!empty($arProducersIDs)):?>
						<ul class="brands">
							<li class="title first">Популярные бренды</li>
							<?foreach($arProducersIDs as $producer_id):?>
								<?/*<li><a href="/catalog/<?=$last_first_level_section_id?>/?arrLeftFilter_pf[CH_PRODUCER][]=<?=$producer_id?>&set_filter=Y"><img src="<?=CFile::GetPath($arProducers[$producer_id]["PREVIEW_PICTURE"]);?>" /></a></li>*/?>
								<li><a href="/catalog/<?=$last_first_level_section_id?>/?arrLeftFilter_pf[CH_PRODUCER][]=<?=$producer_id?>&set_filter=Y"><?=$arProducers[$producer_id]["NAME"]?></a></li>
							<?endforeach?>
						</ul>
                       <!-- <li class="brands">
                            <?foreach($arProducersIDs as $producer_id):?>
                                <a href="/catalog/<?=$last_first_level_section_id?>/?arrLeftFilter_pf[CH_PRODUCER][]=<?=$producer_id?>&set_filter=Y"><img src="<?=CFile::GetPath($arProducers[$producer_id]["PREVIEW_PICTURE"]);?>" />
								<?//=$arProducers[$producer_id]["NAME"]?>
								</a>
                            <?endforeach?>
                            <div class="clear">
                        </li>-->
                    <?endif?>
                
				
				<div class="clear"></div>
				<div class="bp"><div></div></div>
				
            </div>
        </li>
    </ul>
	</div>
</div>
</div>    

<?endif?>