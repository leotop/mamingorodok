<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arParams["AJAX_CALL"] != "Y"):?><div id="LOCATION_<?=$arParams["CITY_INPUT_NAME"];?>"><?endif?>

<select name="<?=$arParams["COUNTRY_INPUT_NAME"]?>" onChange="loadCitiesList(this.value, <?=$arResult["JS_PARAMS"]?>)">
<?if (count($arResult["COUNTRY_LIST"]) > 0):?>
	<?foreach ($arResult["COUNTRY_LIST"] as $arCountry):?>
	<option value="<?=$arCountry["ID"]?>"<?if ($arCountry["ID"] == $arParams["COUNTRY"]):?> selected="selected"<?endif;?>><?=$arCountry["NAME_LANG"]?></option>
	<?endforeach;?>
<?endif;?>
</select>

<?if (count($arResult["CITY_LIST"]) > 0):?>
	<div style="float:left; width:10px;">&nbsp;&nbsp;&nbsp;</div><select name="<?=$arParams["CITY_INPUT_NAME"]?>"<?if (strlen($arParams["ONCITYCHANGE"]) > 0):?> onchange="<?=$arParams["ONCITYCHANGE"]?>"<?endif;?>>
		<?foreach ($arResult["CITY_LIST"] as $arCity):?>
		<option value="<?=$arCity["ID"]?>"<?if ($arCity["ID"] == $arParams["CITY"]):?> selected="selected"<?endif;?>><?=($arCity['CITY_ID'] > 0 ? $arCity["CITY_NAME"] : GetMessage('SAL_CHOOSE_CITY_OTHER'))?></option>
		<?endforeach;?>
	</select>
	
<script>
var jqTransformHideSelect = function(oTarget){
		var ulVisible = $('.jqTransformSelectWrapper ul:visible');
		ulVisible.each(function(){
			var oSelect = $(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
			//do not hide if click on the label object associated to the select
			if( !(oTarget && oSelect.oLabel && oSelect.oLabel.get(0) == oTarget.get(0)) ){$(this).hide();}
		});
	};
var jqTransformGetLabel2 = function(objfield){
		var selfForm = $(objfield.get(0).form);
		var oLabel = objfield.next();
		if(!oLabel.is('label')) {
			oLabel = objfield.prev();
			if(oLabel.is('label')){
				var inputname = objfield.attr('id');
				if(inputname){
					oLabel = selfForm.find('label[for="'+inputname+'"]');
				} 
			}
		}
		if(oLabel.is('label')){return oLabel.css('cursor','pointer');}
		return false;
	};
$.fn.SelectReload = function(){
		return this.each(function(index){
			var $select = $(this);

			if($select.hasClass('jqTransformHidden')) {return;}
			if($select.attr('multiple')) {return;}

			var oLabel  =  jqTransformGetLabel2($select);
			/* First thing we do is Wrap it */
			var $wrapper = $select
				.addClass('jqTransformHidden')
				.wrap('<div class="jqTransformSelectWrapper"></div>')
				.parent()
				.css({zIndex: 10-index})
			;
			
			/* Now add the html for the select */
			$wrapper.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
			var $ul = $('ul', $wrapper).css('width',$select.width()).hide();
			/* Now we add the options */
			$('option', this).each(function(i){
				var oLi = $('<li><a href="#" index="'+ i +'">'+ $(this).html() +'</a></li>');
				$ul.append(oLi);
			});
			
			/* Add click handler to the a */
			$ul.find('a').click(function(){
					$('a.selected', $wrapper).removeClass('selected');
					$(this).addClass('selected');	
					/* Fire the onchange event */
					if ($select[0].selectedIndex != $(this).attr('index') && $select[0].onchange) { $select[0].selectedIndex = $(this).attr('index'); $select[0].onchange(); }
					$select[0].selectedIndex = $(this).attr('index');
					$('span:eq(0)', $wrapper).html($(this).html());
					$ul.hide();
					return false;
			});
			/* Set the default */
			$('a:eq('+ this.selectedIndex +')', $ul).click();
			$('span:first', $wrapper).click(function(){$("a.jqTransformSelectOpen",$wrapper).trigger('click');});
			oLabel && oLabel.click(function(){$("a.jqTransformSelectOpen",$wrapper).trigger('click');});
			this.oLabel = oLabel;
			
			/* Apply the click handler to the Open */
			var oLinkOpen = $('a.jqTransformSelectOpen', $wrapper)
				.click(function(){
					//Check if box is already open to still allow toggle, but close all other selects
					if( $ul.css('display') == 'none' ) {jqTransformHideSelect();} 
					if($select.attr('disabled')){return false;}

					$ul.slideToggle('fast', function(){					
						var offSet = ($('a.selected', $ul).offset().top - $ul.offset().top);
						$ul.animate({scrollTop: offSet});
					});
					return false;
				})
			;

			// Set the new width
			var iSelectWidth = $select.outerWidth();
			var oSpan = $('span:first',$wrapper);
			var newWidth = (iSelectWidth > oSpan.innerWidth())?iSelectWidth+oLinkOpen.outerWidth():$wrapper.width();
			$wrapper.css('width',newWidth);
			$ul.css('width',newWidth-2);
			oSpan.css({width:iSelectWidth});
		
			// Calculate the height if necessary, less elements that the default height
			//show the ul to calculate the block, if ul is not displayed li height value is 0
			$ul.css({display:'block',visibility:'hidden'});
			var iSelectHeight = ($('li',$ul).length)*($('li:first',$ul).height());//+1 else bug ff
			(iSelectHeight < $ul.height()) && $ul.css({height:iSelectHeight,'overflow':'hidden'});//hidden else bug with ff
			$ul.css({display:'none',visibility:'visible'});
			
		});
	};

	$("#LOCATION_ORDER_PROP_4 select").SelectReload();
</script>
<?endif;?>
<?if ($arParams["AJAX_CALL"] != "Y"):?></div><div id="wait_container_<?=$arParams["CITY_INPUT_NAME"]?>" style="display: none;"></div><?endif;?>