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
// �������� ������� ������� ��� �������

// id ������ �� url
if(strpos($_SERVER["REDIRECT_URL"], "catalog") !== false)
{
    $arURL = explode('/', $_SERVER["REDIRECT_URL"]);
    $current_section_id = $arURL[2];  
}
// ������������ ����
$dbEl = CIBlockElement::GetList(Array("PROPERTY_PRICE" => "ASC"), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID" => $current_section_id), false, false, array("ID", "IBLOCK_ID"));    
if($obEl = $dbEl->GetNext())    
{           
    $min_price = $obEl["PROPERTY_PRICE_VALUE"];
}
// ����������� ����
$dbEl = CIBlockElement::GetList(Array("PROPERTY_PRICE" => "DESC"), Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "INCLUDE_SUBSECTIONS" => "Y", "SECTION_ID" => $current_section_id), false, false, array("ID", "IBLOCK_ID"));    
if($obEl = $dbEl->GetNext())    
{           
    $max_price = $obEl["PROPERTY_PRICE_VALUE"];
}


// ���� ������ ���� ����� ����������� �� �������� ������...
$arPropsToShow = array (
    array(
        "NAME" => "���",
        "CODE" => "CH_TYPE",
        "TYPE" => "CHECKBOX"
    ),
    array(
        "NAME" => "�������������",
        "CODE" => "CH_PRODUCER",
        "TYPE" => "CHECKBOX"
    ),
    
);

// ��� �������� ��������� ������� � js ��� ���������� �� ����    
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
    // ������ ���� ������� ������
    arPropsToShow = new Array("TYPE", "PRODUCER");  // ��������� ���������
    
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
    
    // ������ id � ������� ������� 
    var arIDs = <?=json_encode($arIDs);?>;
    var arPrices = <?=json_encode($arPrices);?>;
</script>

<div class="filter">
<div class="ballon_float">
<div class="baloon">
    <div class="baloon_left"></div>
    <div class="baloon_right"></div>
    <div class="ballon_text">������� <span></span> �������. <a href="#">��������</a></div>
    <div class="baloon_close"></div>
</div>
</div>
<form name="arrLeftFilter_form" class="jqtransform" action="?">
<div class="categoryF no-top-margin">��� �����</div>
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
    <a class="greydot myCheckLinkClear" href="?">�������� ���</a>
</div>

<div class="categoryF" id="price"><span></span>����</div>
<div class="price">
<input type="text" class="startPrice startPrices filterChange" placeholder="��" name="arrLeftFilter_pf[PRICE][LEFT]" /> <div class="line"></div> <input type="text" class="endPrice endPrices filterChange" placeholder="��" name="arrLeftFilter_pf[PRICE][RIGHT]" />
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
    <? // �������� "�������������"  ?>
    
    <div class="categoryF" id="proizv"><span></span>�������������
    <div><a href="" class="greydot showAll" id="allProizv">��� �������������</a></div></div>
    <div class="relClass">
    <div class="qw tp showClickPosition" id="info1"></div>
    <div class="info1 info">
        <div class="hint">
        <div class="exitpUp"></div>
        <div class="cn tl"></div>
        <div class="cn tr"></div>
        <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <h2>�������������</h2>
        <p>
        �� ��� ��� �� ������ �������� � �� ��� ��� ������ ��� � ������� � ���� �� �����������. ����� �� � �� � �������.
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
                           <?/* <td width="50%"><input type="checkbox" id="checkbx" class="filterChange all" name="<?=$arProp["CODE"]?>"><div class="name">���</div></td>
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
        <?// ������� ������ ?>

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

<div class="categoryF unselect" id="ves"><span></span>���</div>
<div class="relClass">
<div class="qw tp3 showClickPosition" id="info3"></div>
<div class="info3 info">
    <div class="hint">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    <h2>���</h2>
    <p>
    �� ��� ��� �� ������ �������� � �� ��� ��� ������ ��� � ������� � ���� �� �����������. ����� �� � �� � �������.
    <p>
        </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>
</div>
<div class="ves" style="display: none;">
<input type="text" class="startPrice startPriceVes filterChange" placeholder="��"> <div class="line"></div> <input type="text" class="endPrice endPriceVes filterChange" placeholder="��"> 
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

<div class="categoryF unselect" id="typ"><span></span>��� �����������</div>
<div class="relClass">
<div class="qw tp2 showClickPosition" id="info2"></div>
<div class="info2 info">
    <div class="hint">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
    <h2>��� �����������</h2>
    <p>
    �� ��� ��� �� ������ �������� � �� ��� ��� ������ ��� � ������� � ���� �� �����������. ����� �� � �� � �������.
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
        <div class="name">�����������</div>
    </div>
    <div class="clear"></div>
    <div class="checkbx">
        <input type="checkbox" id="checkbx" class="filterChange">
        <div class="name">�������</div>
    </div>
    <div class="clear"></div>
</div>

</div>
<a href="#" class="greydot showAll allParam" id="allTub">��� ���������</a>
<input type="hidden" name="set_filter" value="Y" />
</form>
<div class="top15"></div>
<input type="submit" value="��������" name="set_filter" class="left-filter categoryF-left-filter">  
</div>


<script type="text/javascript">

////////////////////////////////////////////////////
// ���������� ������� �������� � ������� �������� //
// � ���������� �� ���� ��������� ��������� ////////
////////////////////////////////////////////////////
function GetProductsInInterval(min, max){
    
    var arResult = new Array();
    for (i = 0; i < arPrices.length; i++)
    {
        // ���� �� ���������� ������� (��� ����)
        // � ������ ������ ��������� ������ �� �� �� ��� �������� 
        
        product_missed = false;  // ���� �������� ������
        
        // ���� ����� �� ������ � ������� ��������, �� ���� ����
        if (parseInt(arPrices[i]) < parseInt(min) || parseInt(arPrices[i]) > parseInt(max))
            continue;
        
        for(p=0; p<arPropsToShow.length; p++) // ���� �� ��������� ���������
        {
            if (arSelectedProps[arPropsToShow[p]].length)  // ���� ���-�� �������, ���������� ���������� ��������
            {
                product_present = false;
                for(j=0; j<arSelectedProps[arPropsToShow[p]].length; j++)  // in_array �������� �������� ������ � ���������� ���������
                {
                    if (arSelectedProps[arPropsToShow[p]][j] == arAllItemsProps[arPropsToShow[p]][i])        // arAllItemsProps[arPropsToShow[p]] == arTypes � ��..
                    {
                        product_present = true;  // ���� �����
                    }
                }                
            }
            else  // ���� � ������� ������ �� �������
                product_present = true;  // ���� �����
                  
            if (!product_present)  // ���� �� ����� ��������� � ���������� ������
            {
                product_missed = true;
                break;
            }
        } 
        
        if (!product_missed)     // ������� ���������� �� ���� �������� ���������� ��� ��� ����������
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
// ��� ����� �� �������, ���������� ////////
// ���������� �������� � arSelectedProps  //
////////////////////////////////////////////
$('.filterChange').click(function(){

    // ���� ������ ����� "���"  (��� ������ � ��������������)
    if ($(this).hasClass('all'))
    {
        if ($(this).is(':checked'))
        {
            // ���������� ��� ����� ��� ��������
            $('.proizv').find('.filterChange').each(function(){
                if (!$(this).is(':checked') && !$(this).hasClass('all'))
                    $(this).attr('checked', 'checked');
            })
        }
        else
        {
            // ������� �����
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

    $('#check_'+current_prop_code).hide();              // �������� ���� ���� 
    $('#check_'+current_prop_code).find('li').hide();   // �������� ��� ������ 
    
    
    current_filter.find('.filterChange').each(function(){
        if ($(this).is(':checked') && !$(this).hasClass('all')) 
        {
            var name = $(this).attr('name');
            //var arName = explode('arrLeftFilter_pf[', name);
            var current_prop_value = parseInt($(this).attr('value'));
            
            $('.myCheck').find('.'+current_prop_code+'_'+current_prop_value).show(); // ���������� ������ ���������� ������
            
            arSelectedProps[current_prop_code].push(current_prop_value);
            $('#check_'+current_prop_code).show(); // ���������� ���� ���� ���� ������ ���� �����
        }
    })
    
    var products_count = GetProductsInInterval(last_price_min, last_price_max);
    showBallon($(".startPrices"), products_count);
})


$('.myCheckNone').click(function(){
    var block = $(this).parent();
    var hide_class = block.attr('id');  // id ����� ����� ������ ����� �������
    block.fadeOut();
    $('.'+hide_class).find('.filterChange').attr('checked', '');
    
    // ���� �� ���� ���������
    for(i=0; i<arPropsToShow.length; i++)
    {
        $('.check_'+arPropsToShow[i]).find('.filterChange').each(function(){
            var name = $(this).attr('name');
            var arName = explode('_', name);
            var current_prop_value = parseInt(arName[1]);

            // ��������� ��������� ����� � ����� ������
            arSelectedProps[arPropsToShow[i]].push(current_prop_value);
        })    
    }
    
    // ������� ���������� ���������    
    var products_count = GetProductsInInterval(last_price_min, last_price_max);
    showBallon($(".startPrices"), products_count);
    $('.ballon_float').hide(); // ������ ����������� ��������� 
    
    return false;
})

</script>