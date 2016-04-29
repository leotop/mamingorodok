////////////////////////////////////////////////////
// ���������� ������� �������� � ������� �������� //
// � ���������� �� ���� ��������� ��������� ////////
////////////////////////////////////////////////////
function GetProductsInInterval(){
    
   // var min = ;
    //var max = ;
    var count = -1;
    var arResult = new Array();
	var arPrice = new Array();
	var noadd = false;
    for (i = 0; i < arPrices.length; i++)
    {
		noadd = false;
        // ���� �� ���������� ������� (��� ����)
        // � ������ ������ ��������� ������ �� �� �� ��� �������� 
        product_missed = false;  // ���� �������� ������
        
        // ���� ����� �� ������ � ������� ��������, �� ���� ����
        if (parseInt(arPrices[i]) <= parseInt(last_price_min) || parseInt(arPrices[i]) > parseInt(last_price_max))
            continue;
        
        for(p=0; p<arPropsToShow.length; p++) // ���� �� ��������� ���������
        {
			if(count==-1) count=0;
			
			
			if(arPropsToShow[p]=="PRODUCER"){
				if (arSelectedProps[arPropsToShow[p]].length){
					for(j=0; j<arPrice.length; j++){
						if(arPrice[j]==arPrices[i]){
							product_missed = false;
							noadd = true;
							}
					}	
					if(!noadd){
						var rr = arSelectedProps[arPropsToShow[p]].length;
						for(j=0; j<arSelectedProps[arPropsToShow[p]].length; j++)  // in_array �������� �������� ������ � ���������� ���������
						{
							var t = arAllItemsProps2[arPropsToShow[p]][arSelectedProps[arPropsToShow[p]][j]][arPrices[i]];
							t = parseInt(t,10);
							count = count+t;
							arPrice.push(arPrices[i]);
						}  
					}					
				}
				else  // ���� � ������� ������ �� �������
                product_missed = true;  // ���� �����
			}
			
                  
           
			
        } 
        
       if (product_missed)     // ������� ���������� �� ���� �������� ���������� ��� ��� ����������
        {
            cur_price = arPrices[i];
            arResult.push(cur_price);
        } 
        
    }
	if(arResult.length>0)
		return  arResult.length;
    return count;   // ���������� ���������� ���������� �������
}    
 
/////////////////////////////////////////////////////////
// �������� ������ ���������� �������� �������         //
// �� ��� ������������� ��������� � �������� ��������� //
/////////////////////////////////////////////////////////
function SelectedPropsGet()
{
    // ���� �� ������ ��������� �������
    $('.check').each(function(){

        var current_prop_code = $(this).find('.filterChange').eq(1).next().html();
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
    if (last_price_min > 0)
        $('#check_PRICE .num-value-left').html(last_price_min);
    if (last_price_max > 0)
        $('#check_PRICE .num-value-right').html(last_price_max);
    
    if ($('.price .startPrice').val() > 0) // ���� � ������ ������ ��� - ������ � last_price_min � last_price_max ������ ������������ �������� ���
        $('#check_PRICE').show();
}  
 
 $(document).ready(function(){
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
            if ($(this).is(':checked') && !$(this).hasClass('all')) 
            {
                var name = $(this).next().html();
                var current_prop_value = parseInt($(this).attr('value'));
                
                $('.myCheck').find('.'+current_prop_code+'_'+current_prop_value).show(); // ���������� ������ ���������� ������
                
                arSelectedProps[current_prop_code].push(current_prop_value);
                $('#check_'+current_prop_code).show(); // ���������� ���� ���� ���� ������ ���� �����
            }
        })
        
        var products_count = GetProductsInInterval();
       // showBallon($(this), products_count);
        
        //showBallon($(".startPrices"), products_count);
    })
	
	 SelectedPropsGet();
	 
	 $('.ballon_text').click(function(){
        $('.filter form').submit();
        return false;
    })
	
});