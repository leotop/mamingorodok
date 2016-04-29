<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.8.11.custom.min.js');?>
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/slider/jquery-ui-1.8.11.custom.css" />
<?
if(isset($_POST["arrFilter_pf"]["PRICE"])):
	$Pleft = intval($_POST["arrFilter_pf"]["PRICE"]["LEFT"]);
	$Pright = intval($_POST["arrFilter_pf"]["PRICE"]["RIGHT"]);
	if($Pleft>0 && $Pright>0 && $Pright>$Pleft){}
	else{
		unset($Pleft);
		unset($Pright);
	}
	//echo $Pleft." - ".$Pright;
endif;
?>

<?if(intval($arResult["MIN_PRICE"])==0){
	$arResult["MIN_PRICE"] = 0;
}?>

<?if(intval($arResult["MAX_PRICE"])==0){
	$arResult["MAX_PRICE"] = $arResult["MIN_PRICE"]+1000;
}?>

<script>
	var last_price_min = <?=$arResult["MIN_PRICE"]-1?>;
    var last_price_max = <?=$arResult["MAX_PRICE"]+1?>;
	var selected_section;
	
	var arSelectedProps = new Array();
	var arPrices = [<?=$arResult["PRICES"]?>];
	var arPropsToShow = new Array();
	arPropsToShow = ["PRODUCER"];
	var arAllItemsProps2 = new Array();
	var arAllItemsProps = new Array();
	arAllItemsProps2["PRODUCER"] = new Array();
	arSelectedProps["PRODUCER"] = new Array();
	<?foreach($arResult["PRODUCERS"] as $k=>$v):?>
		
		arAllItemsProps2["PRODUCER"][<?=$k?>] = new Array();
		<?foreach($v as $k1=>$c):?>
			<?if(!empty($k1)):?>
				arAllItemsProps2["PRODUCER"][<?=$k?>][<?=$k1?>] = <?=$c;?>;
			<?endif;?>
		<?endforeach?>
	<?endforeach?>
	
	arPropsToShowNum = null;  
</script>
<script type="text/javascript">
            $(function(){
                
                // Slider
                $('.slider').slider({
                    range: true,
                    min:<?=$arResult["MIN_PRICE"]?>,
                    max:<?=$arResult["MAX_PRICE"]?>,
                    textMark:"txtM",
                    values: [<?if(!empty($Pleft)): echo $Pleft; else: echo $arResult["MIN_PRICE"]; endif?>, <?if(!empty($Pright)): echo $Pright; else: echo $arResult["MAX_PRICE"]; endif?>],
                    slide: function( event, ui ) {
                        var sV = $( ".startPriceVes" ).val();
						var eV = $( ".endPriceVes" ).val();
						
						var uor = 0;
						if(sV!=ui.values[ 0 ]){
							uor = 1;
							
							sV = ui.values[ 0 ];
							eV = ui.values[ 1 ];
							$( ".startPriceVes" ).val( ui.values[ 0 ]);
						}
                        
						if(eV!=ui.values[ 1 ]){
							uor = 1;
							
							sV = ui.values[ 0 ];
							eV = ui.values[ 1 ];
							$( ".endPriceVes" ).val( ui.values[ 1 ]);
						}
						if(uor){
							last_price_min = sV;
							last_price_max = eV;
							var products_count = GetProductsInInterval();   
							showBallon($(".endPriceVes"), products_count);
						}
                    }
                });
                });
</script>
<?//print_R($arResult["HINTS"])?>
<div class="filter">
<div class="ballon_float">
<div class="baloon">
    <div class="baloon_left"></div>
    <div class="baloon_right"></div>
    <div class="ballon_text">Найдено <span></span> товаров. <a href="#">Показать</a></div>
    <div class="baloon_close"></div>
</div>
</div>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" class="jqtransform" action="<?echo $arResult["FORM_ACTION"]?>" method="post">

<div class="categoryF" id="ves"><span></span>Цена</div>
<div class="ves">
<input type="text" name="arrFilter_pf[PRICE][LEFT]" class="startPrice startPriceVes filterChange" placeholder="от" value="<?=$Pleft?>"> <div class="line"></div> <input type="text" name="arrFilter_pf[PRICE][RIGHT]" class="endPrice endPriceVes filterChange" placeholder="до" value="<?=$Pright?>"> 
<div class="clear"></div>
<div id="slider" class="slider">
<div class="slL"><</div>
<div class="slR">></div>
<div class="slLP"></div>
<div class="slRP"></div>
<div class="slP1 slP"><div class="txtM1T slPT"></div></div>
<div class="slPT1"></div>
<div class="slP2 slP"><div class="txtM2T slPT"></div></div>
<div class="slPT2"></div>
<div class="slP3 slP"><div class="txtM3T slPT"></div></div>
<div class="slPT3"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
<div class="top15"></div>
<div class="ppprz">
<div class="categoryF" id="proizv"><span></span>Производители
</div>
<?if(isset($arResult["HINTS"]["CH_PRODUCER"])):?>
  <div class="relClass">
            <div class="qw tp-pr showClickPosition" id="info<?=$arResult["HINTS"]["CH_PRODUCER"]["KEY"]?>"></div>
            <div class="info<?=$arResult["HINTS"]["CH_PRODUCER"]["KEY"]?> info">
                <div class="hint">
                    <div class="exitpUp"></div>
                    <div class="cn tl"></div>
                    <div class="cn tr"></div>
                    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
                                <h2><?=$arResult["HINTS"]["CH_PRODUCER"]["NAME"]?></h2>
                                <p>
                                    <?=$arResult["HINTS"]["CH_PRODUCER"]["PREVIEW_TEXT"]?>
                                <p>
                            </div></div></div>
                    <div class="cn bl"></div>
                    <div class="cn br"></div>
                </div>
            </div>
        </div>
<?endif;?>
</div>
<div style="display: block;" class="proizv check check_PRODUCER">
<table width="100%">
<tbody><tr>
<?/*
<td width="50%"><input id="checkbx" class="filterChange all" name="PRODUCER" <?if(count($_POST["arrFilter_pf"]["CH_PRODUCER"])==count($arResult["PRODUCER"])):?> checked <?endif;?>type="checkbox"><span style="display: none;">PRODUCER</span><div class="name">Все</div></td>
*/?>
<?$j = 1;?>
<?foreach($arResult["PRODUCER"] as $k =>$v):?>
	<?if($k%2!=0):?>
		<tr>
	<?endif?>
	<td width="50%">
	<input id="checkbx" class="filterChange" name="arrFilter_pf[CH_PRODUCER][]" value="<?=$v["ID"]?>" <?if(in_array($v["ID"],$_POST["arrFilter_pf"]["CH_PRODUCER"])):?>checked<?endif?> type="checkbox">
	<span style="display: none;">PRODUCER</span><div class="name"><?=$v["NAME"]?></div>
	</td>
	<?if($k%2==0):?>
		</tr>
	<?endif?>
<?$j++;?>
<?endforeach?>
<?if($j%2!=0):?>
<td width="50%">
	&nbsp;
</td>
</tr>
<?endif;?>
</tbody></table>
</div>
<div class="clear"></div>
<div class="top15"></div>
<?//arrFilter_pf[CH_PRODUCER]?>
	<input name="clear_cache" value="Y" type="hidden">
	<input type="submit" name="set_filter" class="whiteBtn categoryF-left-filter" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Показать&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" /><input type="hidden" name="set_filter" value="Y" />

</form>
</div>