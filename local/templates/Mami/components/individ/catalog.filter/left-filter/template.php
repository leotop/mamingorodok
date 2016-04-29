<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.8.11.custom.min.js');?>

<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/slider/jquery-ui-1.8.11.custom.css" />
<?/*<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/components/individ/catalog.filter/left-filter/script.js"></script>*/?>
 <?//print_R($GLOBALS["arrLeftFilter"])?>
<?
$zindex =99;
// текуща€ секци€ 
$current_section_id = $arResult["SELECT_SECTION"];
$arNumPropsRange = $arResult["arNumPropsRange"];
$arPropCodesWithoutCH_ = $arResult["arPropCodesWithoutCH_"];
$arPropCodesWithoutCH_Num = $arResult["arPropCodesWithoutCH_Num"];
$arValues = $arResult["arValues"];
$max_price = $arResult["MAX_PRICE"];
$min_price = $arResult["MIN_PRICE"];
$arFilterProps = $arResult["arFilterProps"];
$first_producers_count = $arResult["first_producers_count"];
$arPrices = $arResult["arPrices"];
$arIDs = $arResult["arIDs"];
$arSectionsIDs = $arResult["arSectionsIDs"];
$current_section_name = $arResult["current_section_name"];
$parent_section_id = $arResult["parent_section_id"];
$arPropsValues = $arResult["arPropsValues"];
$arGetHintByPropID = $arResult["arGetHintByPropID"];

?>
<?//echo "<pre>"; var_dump($arPropsValues); echo "</pre>";?>
<?//print_R($arPropCodesWithoutCH_);?>
<?foreach($arPropCodesWithoutCH_ as $prop):?>
	<?//print_R($arPropsValues[$prop]);?>
<?endforeach?>
<script>
    ////////////////////////////////////////////////
    // ƒанные всех товаров секции перегон€ем в js //
    ////////////////////////////////////////////////
    
    arPropsToShow = new Array();
    arPropsToShowNum = new Array();
    arPropsToShow = <?=json_encode($arPropCodesWithoutCH_);?>;  
    arPropsToShowNum = <?=json_encode($arPropCodesWithoutCH_Num);?>;  
    
    var min_price = <?=$min_price?>;
    var max_price = <?=$max_price?>;
    
    var last_price_min = <?if($GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]?><?else:?><?=$min_price?><?endif?>;
    var last_price_max = <?if($GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]?><?else:?><?=$max_price?><?endif?>;
    
    var selected_section;
            
    var arSelectedProps = new Array();
    var arSelectedPropsNum = new Array();

    arAllItemsProps = new Array();
    arAllItemsPropsNum = new Array();
    
    arNumPropsRange = new Array();
    
    arNumPropLastRange = new Array();
    
    // дл€ чекбоксовых свойств
	
    <?foreach($arPropCodesWithoutCH_ as $prop):?>
        // забиваем значени€ свойств элементов в массивы вида arAllItemsProps["TYPE"] = array(12, 3, 5);
        // где пор€док соотвествует пор€дку id элементов в массиве arIDs
        // arSelectedProps - массив в котором будут хранитьс€ выбранные значени€ свойства
        arSelectedProps["<?=$prop?>"] = new Array();
        arAllItemsProps["<?=$prop?>"] = new Array();
        arAllItemsProps["<?=$prop?>"] = <?=json_encode($arPropsValues[$prop]);?>;
    <?endforeach?>

    // тоже самое дл€ числовых свойств
    <?foreach($arPropCodesWithoutCH_Num as $prop):?>
        
        arSelectedPropsNum["<?=$prop?>"] = new Array();
        
        arAllItemsPropsNum["<?=$prop?>"] = new Array();
        arAllItemsPropsNum["<?=$prop?>"] = <?=json_encode($arPropsValues[$prop]);?>;
        
        // минимальные и максимальные значени€ числовых свойств (по всем товарам)
        arNumPropsRange["<?=$prop?>"] = new Array();
        arNumPropsRange["<?=$prop?>"]["MIN"] = <?=$arNumPropsRange[$prop]["MIN"]?>;
        arNumPropsRange["<?=$prop?>"]["MAX"] = <?=floatval($arNumPropsRange[$prop]["MAX"])?>;
        
    <?endforeach?>
    
    // массив id, цен и секций всех товаров  
    var arIDs = <?=json_encode($arIDs);?>;
    var arPrices = <?=json_encode($arPrices);?>;
    var arSectionsIDs = <?=json_encode($arSectionsIDs);?>;
    
    // слайдеры дл€ числовых свойств
    <?foreach($arPropCodesWithoutCH_Num as $prop):?>
        if (arNumPropsRange["<?=$prop?>"]["MIN"] != arNumPropsRange["<?=$prop?>"]["MAX"])  // есть товары с разными значени€ми свойств
        {
            $(function(){
                $('#slider-num-<?=$prop?>').slider({
                    range: true,
                    step: 1,
                    min: arNumPropsRange["<?=$prop?>"]["MIN"],
                    max: arNumPropsRange["<?=$prop?>"]["MAX"],
                    textMark:"txtM<?=$prop?>",
                    values: [ <?if($GLOBALS["arrLeftFilter"]["PROPERTY"][">=CH_".$prop]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=CH_".$prop]?><?else:?>arNumPropsRange["<?=$prop?>"]["MIN"]<?endif?>, <?if($GLOBALS["arrLeftFilter"]["PROPERTY"]["<=CH_".$prop]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=CH_".$prop]?><?else:?>arNumPropsRange["<?=$prop?>"]["MAX"]<?endif?> ],
                    slide: function( event, ui ) {
                        var sV = $( "#start-num-<?=$prop?>" ).val();
                        if(sV!=ui.values[ 0 ]){
                            var products_count = GetProductsInInterval();
                           // showBallon($(".startPrices"), products_count);
                            
                            arSelectedPropsNum["<?=$prop?>"]["LEFT"] = ui.values[0]; 
                            arSelectedPropsNum["<?=$prop?>"]["RIGHT"] = ui.values[1];
                            showBallon($("#start-num-<?=$prop?>"), products_count);
                            
                            $('#check_<?=$prop?>').show();
                            $('#check_<?=$prop?>').find('.num-value-left').html(ui.values[0]);
                            $('#check_<?=$prop?>').find('.num-value-right').html(ui.values[1]);
                        }
                        $( "#start-num-<?=$prop?>" ).val( ui.values[ 0 ]);
                        var eV = $( "#end-num-<?=$prop?>" ).val();
                        if(eV!=ui.values[ 1 ]){
                            var products_count = GetProductsInInterval();
                            
                           // showBallon($(".startPrices"), products_count);
                            
                            arSelectedPropsNum["<?=$prop?>"]["LEFT"] = ui.values[0]; 
                            arSelectedPropsNum["<?=$prop?>"]["RIGHT"] = ui.values[1];
                            showBallon($("#end-num-<?=$prop?>"), products_count);
                            
                            $('#check_<?=$prop?>').show();
                            $('#check_<?=$prop?>').find('.num-value-left').html(ui.values[0]);
                            $('#check_<?=$prop?>').find('.num-value-right').html(ui.values[1]);
                        }
                        $( "#end-num-<?=$prop?>" ).val( ui.values[ 1 ]);
                    }
                });
            });  
        }
    <?endforeach?>
    
    if (<?=$min_price?> != <?=$max_price?>)  // есть разные цены и можно построить диапозон
    {
        $(function(){
            // слайдер дл€ выбора диапозона цен
            $('#sliderPrice').slider({
                step:10,
                range: true,
                min:<?=$min_price?>,
                max:<?=$max_price?>,
                values: [ <?if($GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]?><?else:?><?=$min_price?><?endif?>, <?if($GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]>0):?><?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]?><?else:?><?=$max_price?><?endif?> ],
                textMark:"txtMM",
                slide: function( event, ui ) {
                    var sV = $( ".startPrices" ).val();
                    if(sV!=ui.values[ 0 ]){

                        last_price_min = ui.values[0]
                        last_price_max = ui.values[1]

                        var products_count = GetProductsInInterval();   
                        showBallon($(".startPrices"), products_count);
                        
                        $('#check_PRICE').show();
                        $('#check_PRICE').find('.num-value-left').html(ui.values[0]);
                        $('#check_PRICE').find('.num-value-right').html(ui.values[1]);
                    }
                    $( ".startPrices" ).val( ui.values[ 0 ]);
                    var eV = $( ".endPrices" ).val();
                    if(eV!=ui.values[ 1 ]){

                        last_price_min = ui.values[0]
                        last_price_max = ui.values[1]
                        
                        var products_count = GetProductsInInterval();
                        showBallon($(".endPrices"), products_count);

                        $('#check_PRICE').show();
                        $('#check_PRICE').find('.num-value-left').html(ui.values[0]);
                        $('#check_PRICE').find('.num-value-right').html(ui.values[1]);
                    }
                    $( ".endPrices" ).val( ui.values[ 1 ]);
                }
            });
            
        });  
    }
</script>



<div class="filter">
<div class="ballon_float">
<div class="baloon">
    <div class="baloon_left"></div>
    <div class="baloon_right"></div>
    <div class="ballon_text">Ќайдено <span></span> товаров. <a href="#">ѕоказать</a></div>
    <div class="baloon_close"></div>
</div>
</div>
<form name="arrLeftFilter_form" class="jqtransform" action="?">
<div class="categoryF no-top-margin">¬аш выбор</div>
<div class="myCheck">
    <? // выбранна€ секци€  ?>
    <?//if ($arParams["CURRENT_CATALOG_LEVEL"] == 2):?>
    <?//else: // если второй уровень - секци€ уже выбрана ?>
        <div id="check_section_redirect" class="check-item check-block" style="display:block;">
            <span class="section-name"><?=$current_section_name?></span><span class="parent-section-id" style="display:none;"><?=$parent_section_id?></span>
            <div class="myCheckNone"></div>
        </div>
        <div id="check_section" class="check-item check-block" style="display:none;">
            <span class="section-name"></span><span class="section-id" style="display:none;"></span>
            <div class="myCheckNone"></div>
        </div>
    <?//endif?>
    
    <? // блоки с крестиками "¬аш выбор" ?>
    <div id="check_PRICE" class="check-item" style="display:none;">
        ÷ена <span class="num-value-left"></span> - <span class="num-value-right"></span>
        <div class="myCheckNone"></div>
    </div>
	<?//print_r($arFilterProps);?>
    <?foreach($arFilterProps as $arProp):?>
		<?//echo "<pre>"; var_dump($arProp); echo "</pre>";?>
	
        <?if ($arProp["TYPE"] == "CHECKBOX"):?>
		
            <div id="check_<?=$arProp["CODE"]?>" class="check-item check-block" style="display:none;">
                <ul>
				<?//$arProp["VALUES"] = array_unique($arProp["VALUES"]);?>
                <?foreach($arProp["VALUES"] as $value):?>
                    <li class="<?=$arProp["CODE"]?>_<?=$value["ID"]?>" style="display:none;"><?=$value["TEXT"]?></li>
                <?endforeach?>
                </ul>
                <div class="myCheckNone"></div>
            </div>
        <?else:?>
            <div id="check_<?=$arProp["CODE"]?>" class="check-item num-block" style="display:none;">
                <?=$arProp["NAME"]?> <span class="num-value-left"></span> - <span class="num-value-right"></span>
                <div class="myCheckNone"></div>
            </div>
        <?endif?>
    <?endforeach?>
    <a class="greydot myCheckLinkClear" href="#">ќчистить все</a>
</div>

<?if ($arParams["CURRENT_CATALOG_LEVEL"] == 1):?>
<?
	
   $arSecions = $arResult["arSecions_2"];
?>
    <div id="sections-list">
        <div class="categoryF no-top-margin">–азделы</div>   
        <ul>
            <?foreach($arSections as $arSect):?>
                <li><a href="<?=$arSect["~SECTION_PAGE_URL"]?>"><?=$arSect["NAME"]?></a><span style="display: none;"><?=$arSect["ID"]?></span></li>
            <?endforeach?>
        </ul>    
    </div>
<?endif?>

<?if ($min_price != $max_price):?>
    <div class="categoryF" id="price"><span></span>÷ена</div>
    <div class="price">
    <input type="text" class="startPrice startPrices filterChange" placeholder="от" name="arrLeftFilter_pf[PRICE][LEFT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]?>" /> <div class="line"></div> <input type="text" class="endPrice endPrices filterChange" placeholder="до" name="arrLeftFilter_pf[PRICE][RIGHT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]?>" />
    <div class="clear"></div>
    <div id="sliderPrice" class="slider">
    <div class="slL"><</div>
    <div class="slR">></div>
    <div class="slLP"></div>
    <div class="slRP"></div>
    <div class="slP1 slP"><div class="txtMM1T slPT"></div></div>
    <div class="slPT1"></div>
    <div class="slP2 slP"><div class="txtMM2T slPT"></div></div>
    <div class="slPT2"></div>
    <div class="slP3 slP"><div class="txtMM3T slPT"></div></div>
    <div class="slPT3"></div>
    </div>
    <div class="clear"></div>
    </div>
<?endif?>


<?
$hPr = false;
foreach($arFilterProps as $kk => $arProp){
	
		if($arProp["CODE"]=="PRODUCER"){
			if($hPr)
				unset($arFilterProps[$kk]);
			$hPr = true;
		}
}
?>
<?//print_r($arFilterProps)?>
<?foreach($arFilterProps as $kk => $arProp):?>
	<?//echo "<b>".$arProp["CODE"]."</b>";?>
	<?//print_R($arProp["VALUES"])?>
    <?if(empty($arProp["VALUES"])) continue;?>
    
    <?if ($arProp["FIRST"] != "Y" && !$deactive_layer_is_opened):?>
        <?$deactive_layer_is_opened = true;?>
        <div class="allTub deactive">
    <?endif?>
	<?//echo $arProp["CODE"]." PRODUCER"?>
    <?if($arProp["CODE"] == "PRODUCER"):?>
	
    <? // свойство "ѕроизводители"  ?>
    <?//print_R("ssssssssssssss");?>
    <div class="categoryF" id="proizv"><span></span>ѕроизводители
        <?if (count($arProp["VALUES"]) > $first_producers_count):?>
            <div><a href="" class="greydot showAll" id="allProizv">¬се производители</a></div>
        <?endif?>
    </div>
    
    <?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
        <div class="relClass" style="z-index:<?=$zindex?>">
			<?
				$zindex--;
			?>
            <div class="qw tp-pr showClickPosition" id="info<?=$arProp["ID"]?>"></div>
            <div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>700):?> infoBig<?endif;?>">
                <div class="hint">
                    <div class="exitpUp"></div>
                    <div class="cn tl"></div>
                    <div class="cn tr"></div>
                    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
                                <h2><?=$arProp["NAME"]?></h2>
                                <p>
                                    <?=$arGetHintByPropID[$arProp["ID"]];?>
                                <p>
                            </div></div></div>
                    <div class="cn bl"></div>
                    <div class="cn br"></div>
                </div>
            </div>
        </div>

    <?endif?>

    <div class="proizv check check_<?=$arProp["CODE"]?>">
        <table width="100%">
			<?$i=0;?>
            <?foreach($arProp["VALUES"] as $key=>$value):?>
                    <?if ($key==0):?>
                        <tr>
                            <?/*<td width="50%"><input type="checkbox" id="checkbx" class="filterChange all" name="<?=$arProp["CODE"]?>" /><span style="display:none;"><?=$arProp["CODE"]?></span><div class="name">¬се</div></td>
                            <?$i++;?>*/?>
                    <?endif?>
                    <td <?if($i >= $first_producers_count && count($arProp["VALUES"]) > $first_producers_count):?> class="allProizv deactive"<?endif?>width="50%">
                       
                        <?if (in_array($value["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])) $checked=' checked'; else $checked = '';?>
                        
                        <input type="checkbox" id="checkbx" class="filterChange producer" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
                        <span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><?=$value["TEXT"]?></div></td>
                    <?$i++;?>
                    <?if ($i % 2 == 0):?>
                        </tr>
                        <?if ($i+1 == count($arProp["VALUES"])):?>
                            <tr>
                        <?endif?>
                    <?endif?>
            <?endforeach?>
        </table>
    </div>
    <?elseif ($arProp["TYPE"] == "CHECKBOX"):?> 
		<?if(count($arProp["VALUES"])>0):
		if(count($arProp["VALUES"])!=1 && intval($arProp["VALUES"][1]["ID"])>0):?>
        <?// свойство список ?>

        <div class="categoryF" id="check_<?=$arProp["CODE"]?>"><span></span><?=$arProp["NAME"]?></div>
        
        <?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
            <div class="relClass" style="z-index:<?=$zindex?>">
				<?$zindex--;?>
                <div class="qw tp showClickPosition" id="info<?=$arProp["ID"]?>"></div>
                <div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>700):?> infoBig<?endif;?>">
                    <div class="hint">
                        <div class="exitpUp"></div>
                        <div class="cn tl"></div>
                        <div class="cn tr"></div>
                        <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
                                    <h2><?=$arProp["NAME"]?></h2>
                                    <p>
                                        <?=$arGetHintByPropID[$arProp["ID"]];?>
                                    <p>
                                </div></div></div>
                        <div class="cn bl"></div>
                        <div class="cn br"></div>
                    </div>
                </div>
            </div>
        <?endif?>
        <div class="check check_<?=$arProp["CODE"]?>">
            <?foreach($arProp["VALUES"] as $value):?>
                <div class="checkbx">                    
                    <?if (in_array($value["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['CH_'.$arProp["CODE"]])) $checked=' checked'; else $checked = '';?>                    
                    <?if ($value["ID"] > 0 && $value["COUNT"]>0):?>
                        <input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
                        <span style="display:none;"><?=$arProp["CODE"]?></span>
                        <div class="name"><?=$value["TEXT"]?></div>
                        <!--<div class="num"><?=$value["COUNT"]?></div>-->
                    <?endif?>
                </div>    
                <div class="clear"></div>
            <?endforeach?>
        </div>
		<?$jj = 1;?>
		<?endif?>
		<?endif;?>
    <?else:?>    
        <? // числовое свойство ?>    
        <?if ($arNumPropsRange[$arProp["CODE"]]["MIN"] != $arNumPropsRange[$arProp["CODE"]]["MAX"]): // если значений больше одного ?>
            
            <div class="categoryF"><span></span><?=$arProp["NAME"]?></div>
            
            <?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
                <div class="relClass" style="z-index:<?=$zindex?>">
					<?$zindex--;?>
                    <div class="qw tp showClickPosition" id="info<?=$arProp["ID"]?>"></div>
                    <div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>700):?> infoBig<?endif;?>">
                        <div class="hint">
                            <div class="exitpUp"></div>
                            <div class="cn tl"></div>
                            <div class="cn tr"></div>
                            <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
                                        <h2><?=$arProp["NAME"]?></h2>
                                        <p>
                                        “е кто что то делает трудитс€ а мы тут это отдаем вам в подарок и даже не напр€гаемс€. круто да а вы и незнали.
                                        <p>
                                    </div></div></div>
                            <div class="cn bl"></div>
                            <div class="cn br"></div>
                        </div>
                    </div>
                </div>
            <?endif?>
            <div id="num-<?=$arProp["CODE"]?>" class="ves num-prop" style="display: block;">
                
                <input id="start-num-<?=$arProp["CODE"]?>" type="text" class="startPrice startPriceVes filterChange" placeholder="от" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][LEFT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=CH_".$arProp["CODE"]]?>" /> 
                <div class="line"></div> 
                <input type="text" id="end-num-<?=$arProp["CODE"]?>" class="endPrice endPriceVes filterChange" placeholder="до" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][RIGHT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=CH_".$arProp["CODE"]]?>" /> 
                
                <div class="clear"></div>
                <div id="slider-num-<?=$arProp["CODE"]?>" class="slider">
                    <div class="slL"><</div>
                    <div class="slR">></div>
                    <div class="slLP"></div>
                    <div class="slRP"></div>
                    <div class="slP1 slP"><div class="txtM<?=$arProp["CODE"]?>1T slPT"></div></div>
                    <div class="slPT1"></div>
                    <div class="slP2 slP"><div class="txtM<?=$arProp["CODE"]?>2T slPT"></div></div>
                    <div class="slPT2"></div>
                    <div class="slP3 slP"><div class="txtM<?=$arProp["CODE"]?>3T slPT"></div></div>
                    <div class="slPT3"></div>
                </div>
                <div class="clear"></div>
            </div>
        
        <?endif?>
        
    <?endif?>
<?endforeach?>

<?if ($deactive_layer_is_opened):?>
    </div>

<?endif?>

<?if (!$arResult["NO_HIDDEN_PROPERTIES"] && $jj==1):?>
    <a href="#" class="greydot showAll allParam" id="allTub">¬се параметры</a>
<?endif?>
<input type="hidden" name="set_filter" value="Y" />
</form>
<div class="top15"></div>
<input type="submit" value="ѕоказать" name="set_filter" class="left-filter categoryF-left-filter">  
</div>