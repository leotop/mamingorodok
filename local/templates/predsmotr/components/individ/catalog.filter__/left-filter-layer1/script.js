////////////////////////////////////////////////////
// ���������� ������� �������� � ������� �������� //
// � ���������� �� ���� ��������� ��������� ////////
////////////////////////////////////////////////////
function GetProductsInInterval(){
    
    var min = last_price_min;
    var max = last_price_max;
    
    var arResult = new Array();
    for (i = 0; i < arPrices.length; i++)
    {
        // ���� �� ���������� ������� (��� ����)
        // � ������ ������ ��������� ������ �� �� �� ��� �������� 
        product_missed = false;  // ���� �������� ������
        
        // ���� ����� �� ������ � ������� ��������, �� ���� ����
        var price = parseInt(arPrices[i]);
		if(isNaN(price))
			price = -1;

		// ���� �� ���������� �� ����? (������� �� ����� ������ value �� input'� � ��������� �����)
		var current_start_price = $('.price .startPrice').val();
		if(current_start_price === undefined) current_start_price = "";
		
		if (((price < parseInt(min) || price > parseInt(max))) && current_start_price.length) // ���� ���� ������ ������������ � ��������� �������� ���� �������� ������ (������� ������� � ������ � ��� ����������� � arrFilter)
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
        
        // ���� �� �������� ���������, ���� ��� ����
        if (arPropsToShowNum != null) 
        {
            for(p=0; p<arPropsToShowNum.length; p++) // ���� �� ��������� ���������
            {
                // ���� ����� �� �������� � �������� - �� �� ���� ����
                if (parseInt(arAllItemsPropsNum[arPropsToShowNum[p]][i]) < arSelectedPropsNum[arPropsToShowNum[p]]["LEFT"] || parseInt(arAllItemsPropsNum[arPropsToShowNum[p]][i]) > arSelectedPropsNum[arPropsToShowNum[p]]["RIGHT"])             
                {
                    product_missed = true;
                    break;    
                }
            }        
        }
        
        // ��������� �� ������� ���� ��� ������� (���� �� �� ������ ������ ��������) ... 
        if (selected_section != null)
        {
            if (arSectionsIDs[i] != selected_section)
                product_missed = true;
        }
        
        
        if (!product_missed)     // ������� ���������� �� ���� �������� ���������� ��� ��� ����������
        {
            cur_price = arPrices[i];
            arResult.push(cur_price)
        }        
        
    }
    return arResult.length;   // ���������� ���������� ���������� �������
}    

/////////////////////////////////////////////////////////
// �������� ������ ���������� �������� �������         //
// �� ��� ������������� ��������� � �������� ��������� //
/////////////////////////////////////////////////////////
function SelectedPropsGet()
{
    // ���� �� ������ ��������� �������
    $('.check').each(function(){

        var current_prop_code = $(this).find('.filterChange').eq(0).next().html();
        arSelectedProps[current_prop_code] = new Array();
        
        $(this).find('.filterChange').each(function(){
            if ($(this).is(':checked') && !$(this).hasClass('all')) 
            {
                var name = $(this).next().html();
                var current_prop_value = parseInt($(this).attr('value'));
                
                $('.myCheck').find('.'+current_prop_code+'_'+current_prop_value).show(); // ���������� ������ ���������� ������
                
                arSelectedProps[current_prop_code].push(current_prop_value);
                $('#check_'+current_prop_code).show(); // ���������� ���� ���� ���� ������ ���� �����
            }
        })     
    })
    
    // ���� �� ������ �������� �������
    $('.num-prop').each(function(){
        var prop_code = str_replace('num-', '', $(this).attr('id'));
        var value_left = $('#start-num-'+prop_code).val();
        var value_right = $('#end-num-'+prop_code).val();
        
        if (value_left > 0)
            arSelectedPropsNum[prop_code]["LEFT"] = value_left;

        if (value_right > 0)
            arSelectedPropsNum[prop_code]["RIGHT"] = value_right;
        
        var block = $('#check_'+prop_code);
        block.find('.num-value-left').html(value_left);
        block.find('.num-value-right').html(value_right);
        
        if (value_left > 0 || value_right > 0)
            block.show();
    })
    
    // ���� ����� ��� ���
    // last_price_min � last_price_max ��� ��������� �� GLOBALS � �������
    //if (last_price_min > 0)  // �����������, ������ ���, ���� ���� ����� ����, �� ���� �����������, ��� ������� ������ �������
    $('#check_PRICE .num-value-left').html(last_price_min);
    if (last_price_max > 0)
        $('#check_PRICE .num-value-right').html(last_price_max);
    
    var current_start_price = $('.price .startPrice').val();
	if(current_start_price === undefined) current_start_price = "";
	if (current_start_price.length) // ���� � ������ ������ ��� - ������ � last_price_min � last_price_max ������ ������������ �������� ���
        $('#check_PRICE').show();
}    

//////////////////////////////////////////////////////////  D O C U M E N T   R E A D Y  //////////////////////////////////////////////////////////////////////////
$(document).ready(function(){

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
        var current_prop_code = $(this).next().html();  
        var current_prop_value = $(this).attr('value');
        
        if (current_prop_code == "PRODUCER")
            var current_filter = $('.proizv');
        else
            var current_filter = $(this).parent().parent();

        arSelectedProps[current_prop_code] = new Array();

        $('#check_'+current_prop_code).hide();              // �������� ���� ���� 
        $('#check_'+current_prop_code).find('li').hide();   // �������� ��� ������ 
        
        current_filter.find('.filterChange').each(function(){
           if (($(this).is(':checked') && !$(this).hasClass('all')) || hoHideAny) 
            {
                var name = $(this).next().html();
                var current_prop_value = parseInt($(this).attr('value'));
                
                $('.myCheck').find('.'+current_prop_code+'_'+current_prop_value).show(); // ���������� ������ ���������� ������
                
                arSelectedProps[current_prop_code].push(current_prop_value);
                $('#check_'+current_prop_code).show(); // ���������� ���� ���� ���� ������ ���� �����
            }
        })
        
        var products_count = GetProductsInInterval();
        showBallon($(this), products_count);
        
        //showBallon($(".startPrices"), products_count);
    })

    ////////////////////////
    // �������� ��������� //
    ////////////////////////
    $('.myCheckNone').click(function(){
        var block = $(this).parent();
        var hide_class = block.attr('id');  // id ����� ����� ������ ����� �������
        block.slideUp();
        $('.'+hide_class).find('.filterChange').prop('checked', false);
        
        // ��������� ��������� ��������� ��������
        SelectedPropsGet();
        
        // ���������� ������� �������� ��������� ������, ���� ������� ��������� � ����� "��� �����"
        if (block.attr('id') == 'check_section')
        {
            selected_section = null;
            $('.filter form').attr('action', '');
            $('#sections-list').show();
        }

        // ��� �������� ������ � ����� "��� �����" �� ������ ������ - ������������ � ������������ ������
        if (block.attr('id') == "check_section_redirect")
        {
            var parent_section_id = block.find('.parent-section-id').html();
            if (parent_section_id > 0)
                location.href = '/catalog/'+parent_section_id+'/';    // ������� �� ������� ������
            else
                location.href = '/catalog/';                          // � �������
        }
        
        // ���� ��������� ���� ��������
        if (block.hasClass('num-block'))
        {
            var prop_code = str_replace('check_', '', block.attr('id'));
            
            // ���������� �������� �������� � ������� �� ����������� � ������������
            $('#slider-num-'+prop_code).slider("values", [arNumPropsRange[prop_code]["MIN"], arNumPropsRange[prop_code]["MAX"]])
            $('#start-num-'+prop_code).attr('value', '');
            $('#end-num-'+prop_code).attr('value', '');
            arSelectedPropsNum[prop_code]["LEFT"] = arNumPropsRange[prop_code]["MIN"];
            arSelectedPropsNum[prop_code]["RIGHT"] = arNumPropsRange[prop_code]["MAX"];
        }
        
        // ���� ��������� ������� � ������
        if (block.attr('id') == "check_PRICE")
        {
            // ���������� �������� �������� � ������� �� ����������� � ������������
            $('#sliderPrice').slider("values", [min_price, max_price])
            $('.startPrice').attr('value', '');
            $('.endPrice').attr('value', '');
            last_price_min = min_price;
            last_price_max = max_price
        }
        
        // ������� ���������� ���������    
        var products_count = GetProductsInInterval();
        showBallon($(".startPrices"), products_count);
        $('.ballon_float').hide(); // ������ ����������� ��������� 
        
        return false;
    })
    
    // �������� "�������� ���"
    $('.myCheckLinkClear').click(function(){
        $('.myCheck .check-item').each(function(){
            if ($(this).css('display')!='none')
                $(this).find('.myCheckNone').click();
        })
        return false;
    })
	
   $(".check .name").click(function(){
		var el = $(this).parent().find("#checkbx").eq(0);
		if(!el.is(':checked')){
			hoHideAny = true;
			}
		 else
			{
			el.attr("checked",false);
			 }
			
		el.click();
			if(!hoHideAny){
			el.attr("checked",false);
			}
		 hoHideAny = true;
	});
    
    ///////////////////////////////////////
    // ���� �� ������ (�� ������ ������) //
    ///////////////////////////////////////
    /*$('#sections-list a').click(function(){
        var section_id = $(this).next().html();
        var section_name = $(this).html();
        selected_section = section_id
        
        // ���������� � ����� "��� �����"
        $('#check_section .section-name').html(section_name);
        $('#check_section .section-id').html(section_id);
        $('#check_section').show();

        // ��������� ���������� ��������� �������
        var products_count = GetProductsInInterval();
        showBallon($(this), products_count);
        
        // ��� ������� ��������� � ��������� ������
        $('.filter form').attr('action', '/catalog/'+section_id+'/');
        
        $('#sections-list').hide();
        
        return false;
    })*/
    
    // ���� ���� �������� ��������, ��� �������� ��������� ������ ��������� �������� �������
    SelectedPropsGet();

    $('.ballon_text').click(function(){
        $('.filter form').submit();
        return false;
    })
    
    
})