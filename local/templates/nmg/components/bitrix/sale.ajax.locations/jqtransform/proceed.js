function loadCitiesList(country_id, arParams)
{
	property_id = arParams.CITY_INPUT_NAME;

	function fix_select(selector) {
		selectedVal = $(selector).children(':selected').val();
		$(selector).prev().prev().remove();
		$(selector).children('option').removeAttr('selected');
		$(selector).children('option[value="'+selectedVal+'"]').attr('selected','selected');

		$(selector).removeClass('jqTransformHidden');
		//$(selector).css('display','block');
		$(selector).prev('ul').remove();
		$(selector).prev('div.selectWrapper').remove();

		var selectElm = $(selector).closest('.jqTransformSelectWrapper').html();

		$(selector).closest('.jqTransformSelectWrapper').after(selectElm);
		$(selector).closest('.jqTransformSelectWrapper').remove();

		$(selector).closest('form').removeClass('jqtransformdone');
		$(selector).closest('form').jqTransform();
	}

	function __handlerCitiesList(data)
	{
		//alert(data);
		var obContainer = document.getElementById('LOCATION_' + property_id);
		if (obContainer)
		{
			obContainer.innerHTML = data;
			PCloseWaitMessage('wait_container_' + property_id, true);


			$(".contant_table select").each(function() {
				var obT = $(this);
				if(!obT.hasClass("jqTransformHidden"))
					fix_select("[name='"+obT.attr("name")+"']");
			});
		}
	}

	arParams.COUNTRY = parseInt(country_id);
	
	if (arParams.COUNTRY <= 0) return;

	PShowWaitMessage('wait_container_' + property_id, true);
	
	var TID = CPHttpRequest.InitThread();
	CPHttpRequest.SetAction(TID,__handlerCitiesList);
	CPHttpRequest.Post(TID, '/bitrix/templates/nmg/components/bitrix/sale.ajax.locations/jqtransform/ajax.php', arParams);
	 
}



