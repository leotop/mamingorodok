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

$current_section_name = $arResult["current_section_name"];
$parent_section_id = $arResult["parent_section_id"];

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
    'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);
$this->SetViewTarget("right_area");?>
<div class="bx_filter_vertical">
    <div class="bx_filter_section m4">
        <!--<div class="bx_filter_title"><?echo GetMessage("CT_BCSF_FILTER_TITLE")?></div>-->
        <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
            <?foreach($arResult["HIDDEN"] as $arItem):?>
            <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
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
                     // блоки с крестиками "Ваш выбор" ?>
                    <div id="check_PRICE" class="check-item" style="display:none;">
                        Цена <span class="num-value-left"></span> - <span class="num-value-right"></span>
                        <div class="myCheckNone"></div>
                    </div><?
                    foreach($arFilterProps as $arProp):
                        if ($arProp["TYPE"] == "CHECKBOX"):?>
                            <div id="check_<?=$arProp["CODE"]?>" class="check-item check-block" style="display:none;">
                                <ul><?
                            foreach($arProp["VALUES"] as $value):?>
                                    <li class="<?=$arProp["CODE"]?>_<?=$value["ID"]?>" style="display:none;"><?=$value["TEXT"]?></li><?
                            endforeach?>
                                </ul>
                                <div class="myCheckNone"></div>
                            </div><?
                        else:?>
                            <div id="check_<?=$arProp["CODE"]?>" class="check-item num-block" style="display:none;">
                                <?=$arProp["NAME"]?> <span class="num-value-left"></span> - <span class="num-value-right"></span>
                                <div class="myCheckNone"></div>
                            </div><?
                        endif;
                    endforeach; // myCheckLinkClear?>
                    <a class="greydot" href="<?=$APPLICATION->GetCurDir()?>">Очистить все</a>
                </div>
            <br/>
            <?foreach($arResult["ITEMS"] as $key=>$arItem):
                $key = md5($key);
                if(isset($arItem["PRICE"])):
                    if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                        continue;
                    ?>
                    <div class="bx_filter_container price">
                        <span class="bx_filter_container_title"><span class="bx_filter_container_modef"></span><?=$arItem["NAME"]?></span>
                        <div class="bx_filter_param_area">
                            <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                    <input
                                        class="min-price"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                        id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                        size="5"
                                        onkeyup="smartFilter.keyup(this)"
                                    />
                            </div></div>
                            <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                    <input
                                        class="max-price"
                                        type="text"
                                        name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                        id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                        value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                        size="5"
                                        onkeyup="smartFilter.keyup(this)"
                                    />
                            </div></div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                            <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                            <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                            <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                        </div>
                        <div class="bx_filter_param_area">
                            <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?
                                if (isset($arItem["VALUES"]["MIN"]["CURRENCY"]))
                                    echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"], $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                                else
                                    echo $arItem["VALUES"]["MIN"]["VALUE"];
                            ?></div>
                            <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?
                                if (isset($arItem["VALUES"]["MAX"]["CURRENCY"]))
                                    echo CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                                else
                                    echo $arItem["VALUES"]["MAX"]["VALUE"];
                            ?></div>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <?
                    $arJsParams = array(
                        "leftSlider" => 'left_slider_'.$key,
                        "rightSlider" => 'right_slider_'.$key,
                        "tracker" => "drag_tracker_".$key,
                        "trackerWrap" => "drag_track_".$key,
                        "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                        "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                        "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                        "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                        "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                        "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                        "precision" => 2
                    );
                    ?>
                    <script type="text/javascript">
                        BX.ready(function(){
                            var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
                        });
                    </script>
                <?endif;
            endforeach;
            
            $count=0;
            foreach($arResult["ITEMS"] as $key=>$arItem):
                if ($count > 7 && $count < 9)
                {?>
                    
                    <div class="link_1">
                        <?=showNoindex()?><a class="link_1_a showAll" id="allTub" href="#" title="Все параметры">Все параметры</a><?=showNoindex(false)?>
                    </div>
                    
                    <section class="spoiler">
                
                <?    
                }
                
            
            
                if($arItem["PROPERTY_TYPE"] == "N" ):
                    if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
                        continue;
                    ?>
                    <div class="bx_filter_container price">
                        <span class="bx_filter_container_title"><span class="bx_filter_container_modef"></span><?=$arItem["NAME"]?></span>
                        <div class="bx_filter_param_area">
                            <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                <input
                                    class="min-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                />
                                </div></div>
                            <div class="bx_filter_param_area_block"><div class="bx_input_container">
                                <input
                                    class="max-price"
                                    type="text"
                                    name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                                    id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                                    value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
                                    size="5"
                                    onkeyup="smartFilter.keyup(this)"
                                />
                            </div></div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
                            <div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
                            <a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
                            <a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
                        </div>
                        <div class="bx_filter_param_area">
                            <div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
                            <div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <?
                    $arJsParams = array(
                        "leftSlider" => 'left_slider_'.$key,
                        "rightSlider" => 'right_slider_'.$key,
                        "tracker" => "drag_tracker_".$key,
                        "trackerWrap" => "drag_track_".$key,
                        "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                        "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                        "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                        "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                        "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                        "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                        "precision" => 0
                    );
                    ?>
                    <script type="text/javascript">
                        BX.ready(function(){
                            var trackBar<?=$key?> = new BX.Iblock.SmartFilter.Vertical(<?=CUtil::PhpToJSObject($arJsParams)?>);
                        });
                    </script>
                <?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):
                    $count++;
                    if ($arItem["CODE"]=="CH_PRODUCER")
                    {?>
                        <div class="bx_filter_container">
                            <span class="bx_filter_container_title" onclick="//smartFilter.hideFilterProps(this)"><span class="bx_filter_container_modef"></span><?=$arItem["NAME"]?></span>
                            <div class="bx_filter_block">
                                <table width="100%">
                                    <?                                    
                                    $i=0;
                                    define("MAX_LENGTH",12); //строки какой длины переносить
                                    foreach ($arItem["VALUES"] as $val => $ar)
                                    {
                                        if (empty($ar["VALUE"])) continue;
                                        
                                        $oneColumn=false;    //строка должна иметь один столбец 
                                        $needWidth=false;    //у столбца задана ширина 50%
                                        if (strlen($ar["VALUE"]) > MAX_LENGTH)
                                        {
                                            $oneColumn=true;
                                        }

                                        if ($i % 2 == 0 && !$oneColumn)  //первый столбец и не единственный
                                        {
                                            $needWidth=true;
                                            echo "<tr>";
                                        }
                                        
                                        if ($oneColumn)
                                        {
                                            echo "<tr>";
                                        }
                                       
                                        ?>
                                            <td class="<?echo $ar["DISABLED"] ? 'disabled': ''?>" 
                                                <?= $needWidth ? "width='50%'" : ""?> 
                                                <?= $oneColumn ? "colspan=2" : ""?>>
                                                <input
                                                    type="checkbox"
                                                    value="<?echo $ar["HTML_VALUE"]?>"
                                                    name="<?echo $ar["CONTROL_NAME"]?>"
                                                    id="<?echo $ar["CONTROL_ID"]?>"
                                                    <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                                    onclick="smartFilter.click(this)"
                                                />
                                                <label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];
                                               
                                                ?></label>    
                                            </td>

                                        <?
                                        if ($i % 2 == 1 || $oneColumn) //второй столбец или единственный
                                        {
                                            echo "</tr>";
                                        }
                                        
                                        if (!$oneColumn) 
                                        {
                                            $i++;
                                        }
                                        else
                                        {
                                            $i=0;
                                        }
                                    }
                                 ?>   

                                </table>
                       
                            </div>
                       </div>
                            
                <?    
                    }
                    else 
                    {
                ?>
                <div class="bx_filter_container">
                    <span class="bx_filter_container_title" onclick="//smartFilter.hideFilterProps(this)"><span class="bx_filter_container_modef"></span><?=$arItem["NAME"]?></span>
                    <div class="bx_filter_block">
                        <?foreach($arItem["VALUES"] as $val => $ar):?>
                        <span class="<?echo $ar["DISABLED"] ? 'disabled': ''?>">
                            <input
                                type="checkbox"
                                value="<?echo $ar["HTML_VALUE"]?>"
                                name="<?echo $ar["CONTROL_NAME"]?>"
                                id="<?echo $ar["CONTROL_ID"]?>"
                                <?echo $ar["CHECKED"]? 'checked="checked"': ''?>
                                onclick="smartFilter.click(this)"
                            />
                            <label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>
                        </span>
                        <?endforeach;?>
                    </div>
                </div>
                <?}
                endif;
            endforeach;
            if ($count>7)
            {?>
                </section>
            <?
            }
            
            ?>
            <div style="clear: both;"></div>
            <div class="bx_filter_control_section">
                <span class="icon"></span><input class="bx_filter_search_button button1" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
                <input class="bx_filter_search_button button1" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

                <div class="bx_filter_popup_result left" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
                    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
                    <span class="arrow"></span>
                    <a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
                </div>
            </div>
        </form>
        <div style="clear: both;"></div>
    </div>
</div>
<?$this->EndViewTarget("right_area");?>
<script>
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>