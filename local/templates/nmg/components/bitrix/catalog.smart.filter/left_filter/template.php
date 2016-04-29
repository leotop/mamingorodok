<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?
//arshow($arResult);
$current_section_name = $arResult["current_section_name"];
$parent_section_id = $arResult["parent_section_id"];


$this->SetViewTarget("right_area");?>
<div class="filter">
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
	<?foreach($arResult["HIDDEN"] as $arItem):
    
    ?>
		<input
			type="hidden"
			name="<?echo $arItem["CONTROL_NAME"]?>"
			id="<?echo $arItem["CONTROL_ID"]?>"
			value="<?echo $arItem["HTML_VALUE"]?>"
		/>
	<?endforeach;?>
    <div class="oh3">Ваш выбор</div>
    <div class="myCheck">        <? // выбранная секция
        if(!empty($current_section_name))
        {?>
        <div id="check_section_redirect" class="check-item check-block" style="display:block;">
            <span class="section-name"><?=$current_section_name?></span><span class="parent-section-id" style="display:none;"><?=$arResult["PARENT_SECTION_URL"]?></span>
            <div class="myCheckNone"></div>
        </div>
        <div id="check_section" class="check-item check-block" style="display:none;">
            <span class="section-name"></span><span class="section-id" style="display:none;"></span>
            <div class="myCheckNone"></div>
        </div><?
        }
        ?>
        <a class="greydot" href="<?=$APPLICATION->GetCurDir()?>">Очистить все</a>
    </div>
    
	<div class="filtren">
		<h5><?echo GetMessage("CT_BCSF_FILTER_TITLE")?></h5>
		<ul class="filter_list">
		<?$count=0;
        foreach($arResult["ITEMS"] as $arItem):
            
            if ($count > 7 && $count < 9)
            {?>
                <li class="lvl1">
                    <div class="link_1">
                        <?=showNoindex()?><a class="link_1_a showAll" id="allTub" href="#" title="Все параметры">Все параметры</a><?=showNoindex(false)?>
                    </div>
                </li>
                <section class="spoiler">
            
            <?    
            }
        ?>
            
			<?if($arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"])):?>
			<li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild oh4"><?=$arItem["NAME"]?></a>
				<ul id="ul_<?echo $arItem["ID"]?>">
					<?
						//$arItem["VALUES"]["MIN"]["VALUE"];
						//$arItem["VALUES"]["MAX"]["VALUE"];
					?>
					<li class="lvl2">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<span class="min-price"><?echo GetMessage("CT_BCSF_FILTER_FROM")?></span>
								</td>
								<td>
									<span class="max-price"><?echo GetMessage("CT_BCSF_FILTER_TO")?></span>
								</td>
							</tr>
							<tr>
								<td><input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
								<td><input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
							</tr>
						</table>
					</li>
				</ul>
			</li>
			<?elseif(!empty($arItem["VALUES"])):;
            $count++;
            if ($arItem["CODE"]=="CH_PRODUCER")
            {?>

        
            <li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild oh4"><?=$arItem["NAME"]?></a>
            <ul id="ul_<?echo $arItem["ID"]?>">
            
            <table>
                <?
                
                $i=0;
                foreach ($arItem["VALUES"] as $val)
                {
                    if (empty($val["VALUE"])) continue;
                    
                    if ($i % 2 == 0)
                    {
                        echo "<tr>";
                    }
                    
                    ?>
                        <td class="lvl2<?echo $val['DISABLED']? ' lvl2_disabled': ''?>" width="50%">
                            <input
                                type="checkbox"
                                value="<?echo $val["HTML_VALUE"]?>"
                                name="<?echo $val["CONTROL_NAME"]?>"
                                id="<?echo $val["CONTROL_ID"]?>"
                                <?echo $val["CHECKED"]? 'checked="checked"': ''?>
                                onclick="smar1tFilter.click(this)"
                            /><label for="<?echo $val["CONTROL_ID"]?>"><?echo $val["VALUE"];?></label>    
                        </td>

                    <?
                    if ($i % 2 == 1)
                    {
                        echo "</tr>";
                    }
                    $i++;
                }
             ?>   

            </table>
           
            </ul>
                
            <?    
            }
            else
            {
            
            ?>
			<li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild oh4"><?=$arItem["NAME"]?></a>
				<ul id="ul_<?echo $arItem["ID"]?>">
					<?foreach($arItem["VALUES"] as $val => $ar):
                        if (empty($ar["VALUE"])) continue;
                    ?>
					<li class="lvl2<?echo $ar["DISABLED"]? ' lvl2_disabled': ''?>"><input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
						onclick="smartFilter.click(this)"
					/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label></li>
					<?endforeach;?>
				</ul>
			</li>
			<?
            
            }
            
            endif;?>
		<?
        endforeach;
        if ($count>7)
        {?>
            </section>
        <?
        }
        
        ?>
        
		</ul>
		<input type="submit" id="set_filter" name="set_filter" class="button1" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
		<input type="submit" id="del_filter" name="del_filter" class="button1" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

		<div class="modef" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
			<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
			<a href="<?echo $arResult["FILTER_URL"]?>" class="showchild"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
			<!--<span class="ecke"></span>-->
		</div>
	</div>
</form>
</div>
<?$this->EndViewTarget("right_area");?>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>