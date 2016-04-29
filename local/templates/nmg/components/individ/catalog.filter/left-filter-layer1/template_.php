<?
if($USER -> IsAdmin())
{
	include("new.php");
} else {
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.8.11.custom.min.js');?>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/slider/jquery-ui-1.8.11.custom.css" /><?
	// текущая секция

	$current_section_id = $arParams["SECTION_ID"];

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
	<script><?
if(preg_match("/\/catalog\/(.*?)\//", $APPLICATION->GetCurPage(), $arM))
{
	$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "CODE"=>$arM[1], "ACTIVE"=>"Y"), false);
	if($arS = $rsS -> GetNext())
		$current_section_id = $arS["ID"];
	else $current_section_id = -1;?>
		currSection = "<?=$current_section_id?>";<?
}?>
		////////////////////////////////////////////////
		// Данные всех товаров секции перегоняем в js //
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

		// для чекбоксовых свойств
		<?
		foreach($arPropCodesWithoutCH_ as $prop)
		{?>
		// забиваем значения свойств элементов в массивы вида arAllItemsProps["TYPE"] = array(12, 3, 5);
		// где порядок соотвествует порядку id элементов в массиве arIDs
		// arSelectedProps - массив в котором будут храниться выбранные значения свойства
		arSelectedProps["<?=$prop?>"] = new Array();
		arAllItemsProps["<?=$prop?>"] = new Array();
		arAllItemsProps["<?=$prop?>"] = <?=json_encode($arPropsValues[$prop]);?>;
		<?
		}?>

		// тоже самое для числовых свойств
		<?
		foreach($arPropCodesWithoutCH_Num as $prop)
		{?>

		arSelectedPropsNum["<?=$prop?>"] = new Array();

		arAllItemsPropsNum["<?=$prop?>"] = new Array();
		arAllItemsPropsNum["<?=$prop?>"] = <?=json_encode($arPropsValues[$prop]);?>;

		// минимальные и максимальные значения числовых свойств (по всем товарам)
		arNumPropsRange["<?=$prop?>"] = new Array();
		arNumPropsRange["<?=$prop?>"]["MIN"] = <?=$arNumPropsRange[$prop]["MIN"]?>;
		arNumPropsRange["<?=$prop?>"]["MAX"] = <?=floatval($arNumPropsRange[$prop]["MAX"])?>;
		<?
		}?>

		// массив id, цен и секций всех товаров
		var arIDs = <?=json_encode($arIDs);?>;
		var arPrices = <?=json_encode($arPrices);?>;
		var arSectionsIDs = <?=json_encode($arSectionsIDs);?>;

		// слайдеры для числовых свойств<?
	foreach($arPropCodesWithoutCH_Num as $prop)
	{?>
		if (arNumPropsRange["<?=$prop?>"]["MIN"] != arNumPropsRange["<?=$prop?>"]["MAX"])  // есть товары с разными значениями свойств
		{
			$(function(){
				$('#slider-num-<?=$prop?>').slider({
					range: true,
					step: 10,
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
		<?
		}?>

		if(<?=$min_price?> != <?=$max_price?>)  // есть разные цены и можно построить диапозон
		{
			$(function(){
				// слайдер для выбора диапозона цен
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
	<form name="arrLeftFilter_form" class="jqtransform" action="/<?=implode("/", array_slice(explode("/", $APPLICATION->GetCurDir()), 1, 2))?>/" id="frmFilter">
	<?=showNoindex()?>
	<h3>Ваш выбор</h3><?
	if(!$USER->IsAdmin() && false)
	{?>
		<div class="myCheck">
		<div id="check_section_redirect" class="check-item check-block" style="display:block;">
			<span class="section-name"><?=$current_section_name?></span><span class="parent-section-id" style="display:none;"><?=$parent_section_id?></span>
			<div class="myCheckNone"></div>
		</div>
		<div id="check_section" class="check-item check-block" style="display:none;">
			<span class="section-name"></span><span class="section-id" style="display:none;"></span>
			<div class="myCheckNone"></div>
		</div>
		<? // блоки с крестиками "Ваш выбор" ?>
		<div id="check_PRICE" class="check-item" style="display:none;">
			Цена <span class="num-value-left"></span> - <span class="num-value-right"></span>
			<div class="myCheckNone"></div>
		</div><?
		foreach($arFilterProps as $arProp)
		{
			if ($arProp["TYPE"] == "CHECKBOX")
			{?>
			<div id="check_<?=$arProp["CODE"]?>" class="check-item check-block" style="display:none;">
				<ul>
					<?foreach($arProp["VALUES"] as $value):?>
						<li class="<?=$arProp["CODE"]?>_<?=$value["ID"]?>" style="display:none;"><?=$value["TEXT"]?></li>
					<?endforeach?>
				</ul>
				<div class="myCheckNone"></div>
				</div><?
			} else {?>
			<div id="check_<?=$arProp["CODE"]?>" class="check-item num-block" style="display:none;">
				<?=$arProp["NAME"]?> <span class="num-value-left"></span> - <span class="num-value-right"></span>
				<div class="myCheckNone"></div>
				</div><?
			}
		} // myCheckLinkClear?>
		<a class="greydot" href="<?=$APPLICATION->GetCurDir()?>">Очистить все</a>
		</div><?
	}?>
	<?=showNoindex(false)?>
	<ul class="filter_list"><?
	if($arParams["CURRENT_CATALOG_LEVEL"] == 1)
	{
		$arSections = $arResult["arSecions_2"];?>
		<li>
		<div id="sections-list">
			<div class="categoryF nomargin nopadding"><h4>Разделы</h4></div>
			<ul><?
				foreach($arSections as $arSect)
				{?>
					<li><a href="<?=$arSect["~SECTION_PAGE_URL"]?>"><?=$arSect["NAME"]?></a><span style="display: none;"><?=$arSect["ID"]?></span></li>
				<?
				}?>
			</ul>
		</div>
		</li><?
	}

	if ($min_price != $max_price && !$USER -> IsAdmin() && false)
	{?>
		<li>
		<div class="categoryF nopadding nomargin" id="price"><h4>Цена</h4></div>
		<div class="price">
			<input type="text" class="startPrice startPrices filterChange" placeholder="от" name="arrLeftFilter_pf[PRICE][LEFT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"][">=PRICE"]?>" />
			<div class="line"></div>
			<input type="text" class="endPrice endPrices filterChange" placeholder="до" name="arrLeftFilter_pf[PRICE][RIGHT]" value="<?=$GLOBALS["arrLeftFilter"]["PROPERTY"]["<=PRICE"]?>" />
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
		</li><?
	}

	foreach($arFilterProps as $arProp)
	{
	if(empty($arProp["VALUES"]) || ($arProp["ID"] == 9 && (true || $USER->IsAdmin()))) continue;

	if(in_array("CH_".$arProp["CODE"], $arResult["OTHER_PROP_CODE"]))
		ob_start();

	echo '<li>';

	if ($arProp["FIRST"] != "Y" && !$deactive_layer_is_opened)
	{
	$deactive_layer_is_opened = true;?>
	<div class="allTub deactive"><?
		}
		if($arProp["CODE"] == "PRODUCER" && !$USER->IsAdmin())
		{ // свойство "Производители"?>

			<div class="categoryF" id="proizv"><h4>Производители</h4><?
			if (count($arProp["VALUES"]) > $first_producers_count)
			{?>
				<div><a href="" class="greydot showAll" id="allProizv">Все производители</a></div><?
			}?>
			</div><?
			if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0)
			{?>
				<div class="relClass">
				<div class="qw tp-pr showClickPosition" id="info<?=$arProp["ID"]?>"></div>
				<div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>100):?> infoBig<?endif;?>">
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
				</div><?
			}?>

			<div class="proizv check check_<?=$arProp["CODE"]?>">
				<table width="100%"><?
					$i=0;
					foreach($arProp["VALUES"] as $key=>$value)
					{
					if ($key==0)
				{?>
					<tr><?
						}?>
						<td <? if($i >= $first_producers_count && count($arProp["VALUES"]) > $first_producers_count) {?> class="allProizv deactive"<? }; ?>width="50%">
							<? if (in_array($value["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])) $checked=' checked'; else $checked = '';?>
							<input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
							<span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><?=$value["TEXT"]?></div></td><?
						$i++;
						if ($i % 2 == 0)
						{?>
					</tr><?
					if ($i+1 == count($arProp["VALUES"]))
					{?>
					<tr><?
						}
						}
						}?>
				</table>
			</div>
		<?
		} elseif ($arProp["TYPE"] == "CHECKBOX") {?>
			<?// свойство список ?>
			<div class="categoryF" id="check"><h4><?=$arProp["NAME"]?></h4></div>

			<?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
				<div class="relClass">
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
						<?if ($value["ID"] > 0):?>
							<input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
							<span style="display:none;"><?=$arProp["CODE"]?></span>
							<div class="name"><?=$value["TEXT"]?></div>
							<div class="num"><?=$value["COUNT"]?></div>
						<?endif?>
					</div>
					<div class="clear"></div>
				<?endforeach?>
			</div>
		<?} else {?>
			<? // числовое свойство ?>
			<?if ($arNumPropsRange[$arProp["CODE"]]["MIN"] != $arNumPropsRange[$arProp["CODE"]]["MAX"]): // если значений больше одного ?>

				<div class="categoryF"><h4><?=$arProp["NAME"]?></h4></div>

				<?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
					<div class="relClass">
						<div class="qw tp showClickPosition" id="info<?=$arProp["ID"]?>"></div>
						<div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>700):?> infoBig<?endif;?>">
							<div class="hint">
								<div class="exitpUp"></div>
								<div class="cn tl"></div>
								<div class="cn tr"></div>
								<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
											<h2><?=$arProp["NAME"]?></h2>
											<p>
												Те кто что то делает трудится а мы тут это отдаем вам в подарок и даже не напрягаемся. круто да а вы и незнали.
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

		<?
		}?>
		<?
		echo '</li>';

		if(in_array("CH_".$arProp["CODE"], $arResult["OTHER_PROP_CODE"]))
		{
			$strOtherProps .= ob_get_contents();
			ob_end_clean();
		}
		}?>

	</ul>
	<input type="hidden" name="set_filter" value="Y" />
	</form><?
	if(strlen($strOtherProps)>0)
	{ ?>
		<div class="link_1">
			<a class="link_1_a showAll allParam"  id="allTub" href="#" title="Все параметры">Все параметры</a>
		</div>
		<div class="all_parametrs">
			<br>
			<ul class="filter_list">
				<?=$strOtherProps?>
			</ul>
		</div>
		<br><?
	}

	if(false)
	{?>
		<input type="submit" name="set_filter" class="categoryF-left-filter button_1 notransform" value="Показать" />
		<div class="ballon_float">
			<div class="baloon">
				<div class="baloon_left"></div>
				<div class="baloon_right"></div>
				<div class="ballon_text">Найдено <span></span> товаров. <a id="showHref" href="#">Показать</a></div>
				<div class="baloon_close"></div>
			</div>
		</div><?
	}?>
	</div>
<br><?
if(false)
{
	?>
<div class="filter">

	<form name="arrLeftFilter_form" class="jqtransform" action="?">
	<div class="categoryF no-top-margin">Ваш выбор</div>
	<div class="myCheck">
		<div id="check_section_redirect" class="check-item check-block" style="display:block;">
			<span class="section-name"><?=$current_section_name?></span><span class="parent-section-id" style="display:none;"><?=$parent_section_id?></span>
			<div class="myCheckNone"></div>
		</div>
		<div id="check_section" class="check-item check-block" style="display:none;">
			<span class="section-name"></span><span class="section-id" style="display:none;"></span>
			<div class="myCheckNone"></div>
		</div>
		<? // блоки с крестиками "Ваш выбор" ?>
		<div id="check_PRICE" class="check-item" style="display:none;">
			Цена <span class="num-value-left"></span> - <span class="num-value-right"></span>
			<div class="myCheckNone"></div>
		</div><?
		foreach($arFilterProps as $arProp)
		{
			if ($arProp["TYPE"] == "CHECKBOX")
			{?>
			<div id="check_<?=$arProp["CODE"]?>" class="check-item check-block" style="display:none;">
				<ul>
					<?foreach($arProp["VALUES"] as $value):?>
						<li class="<?=$arProp["CODE"]?>_<?=$value["ID"]?>" style="display:none;"><?=$value["TEXT"]?></li>
					<?endforeach?>
				</ul>
				<div class="myCheckNone"></div>
				</div><?
			} else {?>
			<div id="check_<?=$arProp["CODE"]?>" class="check-item num-block" style="display:none;">
				<?=$arProp["NAME"]?> <span class="num-value-left"></span> - <span class="num-value-right"></span>
				<div class="myCheckNone"></div>
				</div><?
			}
		}?>
		<a class="greydot myCheckLinkClear" href="#">Очистить все</a>
	</div>
	<ul class="filter_list">
	<?
	if($arParams["CURRENT_CATALOG_LEVEL"] == 1)
	{
		$arSections = $arResult["arSecions_2"];?>
		<li>
		<div id="sections-list">
			<div class="categoryF no-top-margin">Разделы</div>
			<ul><?
				foreach($arSections as $arSect)
				{?>
					<li><a href="<?=$arSect["~SECTION_PAGE_URL"]?>"><?=$arSect["NAME"]?></a><span style="display: none;"><?=$arSect["ID"]?></span></li>
				<?
				}?>
			</ul>
		</div>
		</li><?
	}

	if ($min_price != $max_price)
	{?>
		<div class="categoryF" id="price"><span></span>Цена</div>
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
		</div><?
	}?>

	<?


	?>

	<?foreach($arFilterProps as $arProp):?>
	<?if(empty($arProp["VALUES"])) continue;?>

	<?if ($arProp["FIRST"] != "Y" && !$deactive_layer_is_opened):?>
	<?$deactive_layer_is_opened = true;?>
	<div class="allTub deactive">
		<?endif?>

		<?if($arProp["CODE"] == "PRODUCER" && !$USER -> IsAdmin()):?>
			<? // свойство "Производители"  ?>

			<div class="categoryF" id="proizv"><span></span>Производители
				<?if (count($arProp["VALUES"]) > $first_producers_count):?>
					<div><a href="" class="greydot showAll" id="allProizv">Все производители</a></div>
				<?endif?>
			</div>

			<?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
				<div class="relClass">
					<div class="qw tp-pr showClickPosition" id="info<?=$arProp["ID"]?>"></div>
					<div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>100):?> infoBig<?endif;?>">
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
				<table width="100%"><?
					$i=0;
					foreach($arProp["VALUES"] as $key=>$value):
					if ($key==0):?>
					<tr>
						<?/* <td width="50%"><input type="checkbox" id="checkbx" class="filterChange all" name="<?=$arProp["CODE"]?>" /><span style="display:none;"><?=$arProp["CODE"]?></span><div class="name">Все</div></td>
                            <?$i++;?>*/?>
						<?endif?>
						<td <?if($i >= $first_producers_count && count($arProp["VALUES"]) > $first_producers_count):?> class="allProizv deactive"<?endif?>width="50%">

							<?if (in_array($value["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])) $checked=' checked'; else $checked = '';?>

							<input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
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
			<?// свойство список ?>
			<div class="categoryF" id="check"><span></span><?=$arProp["NAME"]?></div>

			<?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
				<div class="relClass">
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
						<?if ($value["ID"] > 0):?>
							<input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>"<?=$checked?> />
							<span style="display:none;"><?=$arProp["CODE"]?></span>
							<div class="name"><?=$value["TEXT"]?></div>
							<div class="num"><?=$value["COUNT"]?></div>
						<?endif?>
					</div>
					<div class="clear"></div>
				<?endforeach?>
			</div>
		<?else:?>
			<? // числовое свойство ?>
			<?if ($arNumPropsRange[$arProp["CODE"]]["MIN"] != $arNumPropsRange[$arProp["CODE"]]["MAX"]): // если значений больше одного ?>

				<div class="categoryF"><span></span><?=$arProp["NAME"]?></div>

				<?if(strlen($arGetHintByPropID[$arProp["ID"]]) > 0):?>
					<div class="relClass">
						<div class="qw tp showClickPosition" id="info<?=$arProp["ID"]?>"></div>
						<div class="info<?=$arProp["ID"]?> info<?if(strlen($arGetHintByPropID[$arProp["ID"]])>700):?> infoBig<?endif;?>">
							<div class="hint">
								<div class="exitpUp"></div>
								<div class="cn tl"></div>
								<div class="cn tr"></div>
								<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
											<h2><?=$arProp["NAME"]?></h2>
											<p>
												Те кто что то делает трудится а мы тут это отдаем вам в подарок и даже не напрягаемся. круто да а вы и незнали.
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

	<?if (!$arResult["NO_HIDDEN_PROPERTIES"]):?>
		<?=showNoindex()?><a href="#" class="greydot showAll allParam" id="allTub">Все параметры</a><?=showNoindex(false)?>
	<?endif?>
	<input type="hidden" name="set_filter" value="Y" />
	</form>
	<div class="top15"></div>
	<?=showNoindex()?><input type="submit" value="Показать" name="set_filter" class="left-filter categoryF-left-filter">  <?=showNoindex(false)?>
</div><?
}
}

?>