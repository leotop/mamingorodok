<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui-1.8.11.custom.min.js');?>
<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/slider/jquery-ui-1.8.11.custom.css" />
<script type="text/javascript">
            $(function(){
                
                // Slider
                $('#sliderVes').slider({
                    range: true,
                    min:0,
                    max:100,
                    textMark:"txtM",
                    values: [0, 100],
                    slide: function( event, ui ) {
                        var sV = $( ".startPriceVes" ).val();
                        if(sV!=ui.values[ 0 ]){
                            showBallon($( ".startPriceVes" ));
                        }
                        $( ".startPriceVes" ).val( ui.values[ 0 ]);
                        var eV = $( ".endPriceVes" ).val();
                        if(eV!=ui.values[ 1 ]){
                            showBallon($( ".endPriceVes" ));
                        }
                        $( ".endPriceVes" ).val( ui.values[ 1 ]);
                    }
                });
                });
</script>

<?
// значения свойств товаров для фильтра

// id секции из url
if(strpos($_SERVER["REDIRECT_URL"], "catalog") !== false)
{
    $arURL = explode('/', $_SERVER["REDIRECT_URL"]);
    $current_section_id = $arURL[2];  
}
// максимальная цена
$dbEl = CIBlockElement::GetList(Array("PROPERTY_PRICE" => "ASC"), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID" => $current_section_id), false, false, array("ID", "IBLOCK_ID"));    
if($obEl = $dbEl->GetNext())    
{           
    $min_price = $obEl["PROPERTY_PRICE_VALUE"];
}
// минимальная цена
$dbEl = CIBlockElement::GetList(Array("PROPERTY_PRICE" => "DESC"), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID" => $current_section_id), false, false, array("ID", "IBLOCK_ID"));    
if($obEl = $dbEl->GetNext())    
{           
    $max_price = $obEl["PROPERTY_PRICE_VALUE"];
}


// этот массив надо будет формировать из свойства секции...
$arPropsToShow = array (
    array(
        "NAME" => "Вид",
        "CODE" => "CH_TYPE",
        "TYPE" => "CHECKBOX"
    ),
    array(
        "NAME" => "Производители",
        "CODE" => "CH_PRODUCER",
        "TYPE" => "CHECKBOX"
    ),
    
);

// все свойства элементов заносим в js для фильтрации на лету    
foreach($arPropsToShow as $arProp)
{
    unset($arValues);
    $dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID"=>$current_section_id), array("PROPERTY_".$arProp['CODE']), false, array("ID", "IBLOCK_ID", "PROPERTY_".$arProp['CODE']));    
    while($obEl = $dbEl->GetNext())    
    {           
        $arValues[] = array(
            "ID" => $obEl["PROPERTY_".$arProp['CODE']."_ENUM_ID"],
            "TEXT" => $obEl["PROPERTY_".$arProp['CODE']."_VALUE"],
            "COUNT" => $obEl["CNT"]
        );
    } 

    $arFilterProps[] = array(
        "NAME" => $arProp["NAME"],
        "CODE" => str_replace("CH_", "", $arProp["CODE"]),
        "TYPE" => $arProp["TYPE"],
        "VALUES" => $arValues
    );

} 
?>
<?
$first = true;
$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID" => $current_section_id), false, false, array("ID", "IBLOCK_ID", "PROPERTY_PRICE", "PROPERTY_CH_TYPE", "PROPERTY_CH_PRODUCER"));    
while($obEl = $dbEl->GetNext())    
{           
    $arIDs[] = $obEl["ID"];
    $arPrices[] = $obEl["PROPERTY_PRICE_VALUE"];
    $arTypes[] = $obEl["PROPERTY_CH_TYPE_ENUM_ID"];
    $arProducers[] = $obEl["PROPERTY_CH_PRODUCER_ENUM_ID"];
}
?>
<script>
    // Данные всех товаров секции
    arPropsToShow = new Array("TYPE", "PRODUCER");  // заполнять автоматом
    
    var last_price_min = <?=$min_price?>;
    var last_price_max = <?=$max_price?>;
            
    var arSelectedProps = new Array();
    arSelectedProps["TYPE"] = new Array();
    arSelectedProps["PRODUCER"] = new Array();    
    
    arAllItemsProps = new Array();
    
    arAllItemsProps["TYPE"] = new Array()
    arAllItemsProps["TYPE"] = <?=json_encode($arTypes);?>;
    arAllItemsProps["PRODUCER"] = new Array()
    arAllItemsProps["PRODUCER"] = <?=json_encode($arProducers);?>;
    
    // массив id и свойств товаров 
    var arIDs = <?=json_encode($arIDs);?>;
    var arPrices = <?=json_encode($arPrices);?>;
</script>

<div class="filter">
<div class="ballon_float">
<div class="baloon">
    <div class="baloon_left"></div>
    <div class="baloon_right"></div>
    <div class="ballon_text">Найдено <span></span> товаров. <a href="#">Показать</a></div>
    <div class="baloon_close"></div>
</div>
</div>
<form name="arrLeftFilter_form" class="jqtransform" action="?">
<div class="categoryF no-top-margin">Ваш выбор</div>
<div class="myCheck">
    <?foreach($arFilterProps as $arProp):?>
        <div id="check_<?=$arProp["CODE"]?>" class="check-block" style="display:none;">
            <ul>
            <?foreach($arProp["VALUES"] as $value):?>
                <li class="<?=$arProp["CODE"]?>_<?=$value["ID"]?>" style="display:none;"><?=$value["TEXT"]?></li>
            <?endforeach?>
            </ul>
            <div class="myCheckNone"></div>
        </div>
    <?endforeach?>
    <a class="greydot myCheckLinkClear" href="?">Очистить все</a>
</div>

<div class="categoryF" id="price"><span></span>Цена</div>
<div class="price">
<input type="text" class="startPrice startPrices filterChange" placeholder="от" name="arrLeftFilter_pf[PRICE][LEFT]" /> <div class="line"></div> <input type="text" class="endPrice endPrices filterChange" placeholder="до" name="arrLeftFilter_pf[PRICE][RIGHT]" />
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

<?foreach($arFilterProps as $arProp):?>

    
    <?if($arProp["CODE"] == "PRODUCER"):?>
    <? // свойство "Производители"  ?>
    
    <div class="categoryF" id="proizv"><span></span>Производители
    <div><a href="" class="greydot showAll" id="allProizv">Все производители</a></div></div>
    <div class="relClass">
    <div class="qw tp showClickPosition" id="info1"></div>
    <div class="info1 info">
        <div class="hint">
        <div class="exitpUp"></div>
        <div class="cn tl"></div>
        <div class="cn tr"></div>
        <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <h2>Производители</h2>
        <p>
        Те кто что то делает трудится а мы тут это отдаем вам в подарок и даже не напрягаемся. круто да а вы и незнали.
        <p>
            </div></div></div>
        <div class="cn bl"></div>
        <div class="cn br"></div>
        </div>
    </div>
    </div>

    <div class="proizv check_<?=$arProp["CODE"]?>">
        <table width="100%">
            <?foreach($arProp["VALUES"] as $key=>$value):?>
					
                    <?if ($key==0):?>
                        <tr>
                           <?/* <td width="50%"><input type="checkbox" id="checkbx" class="filterChange all" name="<?=$arProp["CODE"]?>"><div class="name">Все</div></td>
                            <?$i++;?>*/?>
                    <?endif?>
                    <td <?if($i > 1):?> class="allProizv deactive"<?endif?>width="50%"><input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$value["ID"]?>" /><span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><?=$value["TEXT"]?></div></td>
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
        <?// своство список ?>

        <div class="categoryF" id="check"><span></span><?=$arProp["NAME"]?></div>
        <div class="check check_<?=$arProp["CODE"]?>">
            <?foreach($arProp["VALUES"] as $value):?>
                <div class="checkbx">
                    <input type="checkbox" id="checkbx" class="filterChange" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>]" value="<?=$value["ID"]?>" />
                    <span style="display:none;"><?=$arProp["CODE"]?></span>
                    <div class="name"><?=$value["TEXT"]?></div>
                    <div class="num"><?=$value["COUNT"]?></div>
                </div>    
                <div class="clear"></div>
            <?endforeach?>
        </div>
    <?endif?>

    
    
<?endforeach?>

<div class="allTub deactive">

<div class="categoryF unselect" id="ves"><span></span>Вес</div>
<div class="relClass">
<div class="qw tp3 showClickPosition" id="info3"></div>
<div class="info3 info">
    <div class="hint">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    <h2>Вес</h2>
    <p>
    Те кто что то делает трудится а мы тут это отдаем вам в подарок и даже не напрягаемся. круто да а вы и незнали.
    <p>
        </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
</div>
<div class="ves" style="display: none;">
<input type="text" class="startPrice startPriceVes filterChange" placeholder="от"> <div class="line"></div> <input type="text" class="endPrice endPriceVes filterChange" placeholder="до"> 
<div class="clear"></div>
<div id="sliderVes" class="slider">
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

<div class="categoryF unselect" id="typ"><span></span>Тип складывания</div>
<div class="relClass">
<div class="qw tp2 showClickPosition" id="info2"></div>
<div class="info2 info">
    <div class="hint">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    <h2>Тип складывания</h2>
    <p>
    Те кто что то делает трудится а мы тут это отдаем вам в подарок и даже не напрягаемся. круто да а вы и незнали.
    <p>
        </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
</div>
<div class="typ" style="display: none;">
    <div class="checkbx">
        <input type="checkbox" id="checkbx" class="filterChange">
        <div class="name">Квадратиком</div>
    </div>
    <div class="clear"></div>
    <div class="checkbx">
        <input type="checkbox" id="checkbx" class="filterChange">
        <div class="name">Кружком</div>
    </div>
    <div class="clear"></div>
</div>

</div>
<a href="#" class="greydot showAll allParam" id="allTub">Все параметры</a>
<input type="hidden" name="set_filter" value="Y" />
</form>
<div class="top15"></div>
<input type="submit" value="Показать" name="set_filter" class="left-filter categoryF-left-filter">  
</div>


<script type="text/javascript">

////////////////////////////////////////////////////
// количество товаров входящих в ценовой диапозон //
// и подходящим по всем выбранным свойствам ////////
////////////////////////////////////////////////////
function GetProductsInInterval(min, max){
    
    var arResult = new Array();
    for (i = 0; i < arPrices.length; i++)
    {
        // идем по оставшимся товарам (уже идем)
        // в каждом товаре проверяем входит ли он во все свойства 
        
        product_missed = false;  // флаг пропуска товара
        
        // если товар не входит в ценовой диапозон, он идет мимо
        if (parseInt(arPrices[i]) < parseInt(min) || parseInt(arPrices[i]) > parseInt(max))
            continue;
        
        for(p=0; p<arPropsToShow.length; p++) // идем по списковым свойствам
        {
            if (arSelectedProps[arPropsToShow[p]].length)  // если что-то выбрано, перебираем выделенные чекбоксы
            {
                product_present = false;
                for(j=0; j<arSelectedProps[arPropsToShow[p]].length; j++)  // in_array значение свойства товара в выделенных чекбоксах
                {
                    if (arSelectedProps[arPropsToShow[p]][j] == arAllItemsProps[arPropsToShow[p]][i])        // arAllItemsProps[arPropsToShow[p]] == arTypes и тд..
                    {
                        product_present = true;  // есть такой
                    }
                }                
            }
            else  // если в фильтре ничего не выбрано
                product_present = true;  // есть такой
                  
            if (!product_present)  // если не нашли переходим к следующему товару
            {
                product_missed = true;
                break;
            }
        } 
        
        if (!product_missed)     // продукт присутвует во всех свойтвах записываем его как подходящий
        {
            cur_price = arPrices[i];
            arResult.push(cur_price)
        }        
        
    }
    return arResult.length;
}        

$(function(){
    // Slider
    $('#sliderPrice').slider({
        step:10,
        range: true,
        min:<?=$min_price?>,
        max:<?=$max_price?>,
        textMark:"txtMM",
        values: [<?=$min_price?>, <?=$max_price?>],
        slide: function( event, ui ) {
            var sV = $( ".startPrices" ).val();
            if(sV!=ui.values[ 0 ]){
                var products_count = GetProductsInInterval(ui.values[0], ui.values[1]);
                showBallon($(".startPrices"), products_count);
                
                last_price_min = ui.values[0]
                last_price_max = ui.values[1]
            }
            $( ".startPrices" ).val( ui.values[ 0 ]);
            var eV = $( ".endPrices" ).val();
            if(eV!=ui.values[ 1 ]){
                var products_count = GetProductsInInterval(ui.values[0], ui.values[1]);
                showBallon($(".endPrices"), products_count);

                last_price_min = ui.values[0]
                last_price_max = ui.values[1]
            }
            $( ".endPrices" ).val( ui.values[ 1 ]);
        }
    });
    
});

////////////////////////////////////////////
// при клике на чекбоск, записываем ////////
// выделенные значения в arSelectedProps  //
////////////////////////////////////////////
$('.filterChange').click(function(){

    // если нажали галку "Все"  (она только в производителях)
    if ($(this).hasClass('all'))
    {
        if ($(this).is(':checked'))
        {
            // проствляем все галки для свойства
            $('.proizv').find('.filterChange').each(function(){
                if (!$(this).is(':checked') && !$(this).hasClass('all'))
                    $(this).attr('checked', 'checked');
            })
        }
        else
        {
            // снимаем галки
            $('.proizv').find('.filterChange').each(function(){
                if ($(this).is(':checked') && !$(this).hasClass('all'))
                    $(this).attr('checked', '');
            })
        }
    }
    
    var name = $(this).attr('name');
    //var arName = explode('arrLeftFilter_pf[', name);
    var current_prop_code = $(this).next().html();  //)str_replace('][]', '', arName[1]);
    var current_prop_value = $(this).attr('value');
    
    if (current_prop_code == "PRODUCER")
        var current_filter = $('.proizv');
    else
        var current_filter = $(this).parent().parent();

    arSelectedProps[current_prop_code] = new Array();

    $('#check_'+current_prop_code).hide();              // скрываем весь блок 
    $('#check_'+current_prop_code).find('li').hide();   // скрываем все пункты 
    
    
    current_filter.find('.filterChange').each(function(){
        if ($(this).is(':checked') && !$(this).hasClass('all')) 
        {
            var name = $(this).attr('name');
            //var arName = explode('arrLeftFilter_pf[', name);
            var current_prop_value = parseInt($(this).attr('value'));
            
            $('.myCheck').find('.'+current_prop_code+'_'+current_prop_value).show(); // показываем только выделенные пункты
            
            arSelectedProps[current_prop_code].push(current_prop_value);
            $('#check_'+current_prop_code).show(); // показываем блок если есть хотябы один пункт
        }
    })
    
    var products_count = GetProductsInInterval(last_price_min, last_price_max);
    showBallon($(".startPrices"), products_count);
})


$('.myCheckNone').click(function(){
    var block = $(this).parent();
    var hide_class = block.attr('id');  // id блока равен классу блока свойств
    block.fadeOut();
    $('.'+hide_class).find('.filterChange').attr('checked', '');
    
    // идем по всем свойствам
    for(i=0; i<arPropsToShow.length; i++)
    {
        $('.check_'+arPropsToShow[i]).find('.filterChange').each(function(){
            var name = $(this).attr('name');
            var arName = explode('_', name);
            var current_prop_value = parseInt(arName[1]);

            // добавляем выбранные опции в общий массив
            arSelectedProps[arPropsToShow[i]].push(current_prop_value);
        })    
    }
    
    // считаем количество продуктов    
    var products_count = GetProductsInInterval(last_price_min, last_price_max);
    showBallon($(".startPrices"), products_count);
    $('.ballon_float').hide(); // прячем всплывающую подсказку 
    
    return false;
})

</script>