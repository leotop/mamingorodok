////////////////////////////////////////////////////
// ���������� ������� �������� � ������� �������� //
// � ���������� �� ���� ��������� ��������� ////////
////////////////////////////////////////////////////
function GetProductsInInterval(){
	var p, j;
	var min = last_price_min;
	var max = last_price_max;

	var arResult = new Array();

	var arSectionsSelected = new Array();
	$("#liSections input:checked").each(function() {
		arSectionsSelected.push($(this).val());
	});
	//console.log("selected: "+arSectionsSelected.length);

	//for (i = 0; i < arPrices.length; i++)
	for(var i in arPrices)
	{
		// ���� �� ���������� ������� (��� ����)
		// � ������ ������ ��������� ������ �� �� �� ��� ��������
		var product_missed = false;  // ���� �������� ������

		// ���� ����� �� ������ � ������� ��������, �� ���� ����
		var price = parseInt(arPrices[i]);
		if(isNaN(price)) price = -1;

		// ���� �� ���������� �� ����? (������� �� ����� ������ value �� input'� � ��������� �����)
		var current_start_price = $('.price .startPrice').val();
		if(current_start_price === undefined) current_start_price = "";

		if (((price < parseInt(min) || price > parseInt(max))) && current_start_price.length) // ���� ���� ������ ������������ � ��������� �������� ���� �������� ������ (������� ������� � ������ � ��� ����������� � arrFilter)
			continue;

		for(p=0; p<arPropsToShow.length; p++) // ���� �� ��������� ���������
		{
			if (arSelectedProps[arPropsToShow[p]].length)  // ���� ���-�� �������, ���������� ���������� ��������
			{
				var product_present = false;
				for(j=0; j<arSelectedProps[arPropsToShow[p]].length; j++)  // in_array �������� �������� ������ � ���������� ���������
				{
					if(typeof(arAllItemsProps[arPropsToShow[p]][i]) == "object")
					{
						for(var i_in_ibject in arAllItemsProps[arPropsToShow[p]][i])
						{
							if(arSelectedProps[arPropsToShow[p]][j] == arAllItemsProps[arPropsToShow[p]][i][i_in_ibject])
							{
								product_present = true;  // ���� �����
								break;
							}
						}
					} else {
						if (arSelectedProps[arPropsToShow[p]][j] == arAllItemsProps[arPropsToShow[p]][i])        // arAllItemsProps[arPropsToShow[p]] == arTypes � ��..
							product_present = true;  // ���� �����
					}
				}
			} else product_present = true;  // ���� ����� // ���� � ������� ������ �� �������

			if (!product_present)  // ���� �� ����� ��������� � ���������� ������
			{
				product_missed = true;
				break;
			}
		}

		// ���� �� �������� ���������, ���� ��� ����
		if (arPropsToShowNum != null)
		{
			if(!product_missed)
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
		}

		// ��������� �� ������� ���� ��� ������� (���� �� �� ������ ������ ��������) ...

		if (selected_section != null)
		{
			if(!product_missed)
			{
				if (arSectionsIDs[i] != selected_section)
					product_missed = true;
			}
		}


		if(arSectionsSelected.length>0) // filter multiple sections
		{
			if(!product_missed)
			{
				var intProductSecID, intSelectedSecID;
				var boolProductInSections = false;

				for(intProductSecID in arProductToSections[i])
				{
					for(intSelectedSecID in arSectionsSelected)
					{
						if(arProductToSections[i][intProductSecID] == arSectionsSelected[intSelectedSecID])
						{
							boolProductInSections = true;
							break;
						}
					}
				}

				if(!boolProductInSections) product_missed = true;
			}
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
    });

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
    });

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
	$('a.link_1_a').click(function() {
		$(this).parent().parent().find('div.all_parametrs').slideToggle("normal");
		return false;
	});

	$('.baloon_close').click(function() {
		$(".ballon_float").hide();
	});

	$('.filterChange').click(function() {
		$.ajax({
			type: "POST",
			url: "/ajax/getUrl.php",
			async: false,
			data: $("#frmFilter").serialize()+"&currSection="+currSection
		}).done(function( msg ) {
			if(msg.length>0)
				$("#showHref").attr("href", msg);
			else $("#showHref").attr("href", "#");
		});
	});


	$(".endPrice").keyup(function(){
		last_price_max = $(this).val();
		last_price_max = parseInt(last_price_max);
		last_price_min = $( ".startPrices" ).val();
		if(last_price_min=="") {last_price_min = min_price; $( ".startPrices" ).val(last_price_min); }
		last_price_min = parseInt(last_price_min);
		var products_count = GetProductsInInterval();
		showBallon($(this), products_count);
	});

	$(".startPrices").keyup(function(){
		last_price_max = $(".endPrice").val();
		if(last_price_max=="") {last_price_max = max_price; $( ".endPrice" ).val(last_price_max); }
		last_price_max = parseInt(last_price_max);
		last_price_min = $(this).val();
		last_price_min = parseInt(last_price_min);
		var products_count = GetProductsInInterval();
		showBallon($(this), products_count);
	});
    ////////////////////////////////////////////
    // ��� ����� �� �������, ���������� ////////
    // ���������� �������� � arSelectedProps  //
    ////////////////////////////////////////////
    $('.filterChange').click(function(){
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
    });



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
    });

//   $(".check .name").click(function(){
//		var el = $(this).parent().find(":checkbox");
//
//		if(!el.is(':checked')){
//			hoHideAny = true;
//		} else {
//			el.attr("checked",false);
//		}
//
//		//el.click();
//			if(!hoHideAny){
//				el.attr("checked",false);
//			}
//		 hoHideAny = true;
//	});

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
	$('.ballon_text').click(function()
	{
		var strHref = $("#showHref").attr("href");
		if(strHref == "#")
		{
			//clearForm('.filter form');
			$('.filter form').submit();
		} else document.location.href = strHref;

		return false;
	});
    // ���� ���� �������� ��������, ��� �������� ��������� ������ ��������� �������� �������
    SelectedPropsGet();




});