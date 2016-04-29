<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props_format.php");
?>

<h4><?=GetMessage("SOA_TEMPL_PROP_INFO")?></h4>   

<?
    foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery){
        
    if (count($arDelivery["STORE"]) > 0)
        $clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."')\";";
    else
        $clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;submitForm();\"";?>
        
    <label <?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>  class="label_dat <?if ($arDelivery["CHECKED"]=="Y"){echo 'active_delivery';}?>" <?=$clickHandler?> for="<?=$arDelivery["ID"]?>">   <?//for="ID_DELIVERY_ID_<?=$arDelivery["ID"]"?>
            <strong><?= htmlspecialcharsbx($arDelivery["NAME"])?></strong>
    </label>   

   <? }
?>   
<?//arshow($arDelivery["ID"]);?>
<input type="hidden" value="<?=$_POST["DELIVERY_ID"]?>" id="active_delivery_id">
<div class="bx_section delivery">
<?//arshow($_POST)?>
       <div id="wrap_left">
         
       <?if($_POST["DELIVERY_ID"] == 1){?>
            <div class="delivery_2">
            <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery){?>
                <?if($arDelivery["ID"] == 1){ // выбран ли адрес доставки "самовывоз"?>
                    <p><?= $arDelivery["DESCRIPTION"]?></p>
                    <img src="https://api-maps.yandex.ru/services/constructor/1.0/static/?sid=lOgqO0Kau_2lLWu1SY8vcvXakoDc79hV&width=400&height=300&lang=ru_RU&sourceType=constructor" alt=""/>                     

                <?}
            }?>
            
            </div>
       <?}elseif($_POST["DELIVERY_ID"] == 13 or    // транспортная компания стоимостью от 1501 до 3000 р
                 $_POST["DELIVERY_ID"] == 12 or    // транспортная компания стоимостью от 0 до 1500 р
                 $_POST["DELIVERY_ID"] == 14 or   // транспортная компания стоимостью от 3001 до 5000 р
                 $_POST["DELIVERY_ID"] == 15){  // транспортная компания стоимостью от 5000
                 ?>
               <div class="delivery_3">
               <?foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery){?>
                   <?if($arDelivery["ID"] == 13 or   // транспортная компания стоимостью от 1501 до 3000 р
                        $arDelivery["ID"] == 12 or   // транспортная компания стоимостью от 0 до 1500 р
                        $arDelivery["ID"] == 14 or    // транспортная компания стоимостью от 3001 до 5000 р
                        $arDelivery["ID"] == 15){    // транспортная компания стоимостью от 5000
                   ?>
                        <div class="sale_order_props">     
                            <div class="new_adress">
                                 <h2>Выберите транспортную компанию</h2>
                            </div>
                            <?
                            PrintPropsForm_delivery_company($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);
                            echo '<br>';
                            PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
                            ?>
                            <div class="mandatory_fields">Просим вас заполнить новые поля - Контактный номер и контактное лицо</div>
                            <div class="city_null"></div>
                        </div>
                        <p><?= $arDelivery["DESCRIPTION"]?></p>
                   <?}?>     
               <?}?>
               </div>
       <?}else{?>
           <div class="table_adres">
                      <?//arshow($_POST)?>
                     <ul>          
                  <?foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arProp)
                    { ?>
                       
                     <li>
                     <?if(!empty($_POST["PROFILE_ID"]))
                     {                                                          
                        $_SESSION["PROP_ID"] = $_POST["PROFILE_ID"];   // записываем текущий id выбранного адреса покупателя и записываем в сессию
                     }?> 
                    <?if(!empty($arProp["ID"])){
                      //  $arProp["CHECKED"] = 'Y';
                     }?>
                        <?if($_SESSION["PROP_ID"] == $arProp["ID"] and $_POST["profile_change"] == "N"){   // сравниваем id сессии с id адреса покупателя и создан ли новый адрес покупателя
                            $arProp["CHECKED"] = 'Y';?>
                       <? }?>
                       <?//arshow($arProp["ID"],true)?>
                        <?//arshow($_SESSION["new_adress_click"],true);?>
                        <input type="radio" class="prof radio" name="PROFILE_ID" id="ID_PROFILE_ID_<?=$arProp["ID"] ?>" for="false" onClick="SetContact(true); new_adress_click = false;" value="<?= $arProp["ID"];?>"<?if($arProp["CHECKED"]=="Y"){$checekd=true; echo " checked";}?> >
                        <label for="ID_PROFILE_ID_<?=$arProp["ID"] ?>" class="radio <?if($arProp["CHECKED"] and $_SESSION["new_adress_click"] == "true" or empty($_SESSION["new_adress_click"])){?>active_location<?}?>"> 
                      <?  $adress ="";
                            // arshow(CSaleOrderUserProps::GetByID($arProp["USER_ID"]));
                        $db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$arProp["ID"])); // выводим свойства из адресов плательщика
                        while ($arPropVals = $db_propVals->Fetch())
                        { 
                            if($arPropVals["PROP_CODE"] == "location"){                           // заносим свойства полей в переменную и выводим
                                $arLocs = CSaleLocation::GetByID($arPropVals["VALUE"], LANGUAGE_ID);
                                $adress .= $arLocs["COUNTRY_NAME"].','.$arLocs["CITY_NAME"].' ';
                            } 
                            if($arPropVals["PROP_CODE"] == "address"){    
                                $adress .= $arPropVals["VALUE"].' ';
                            } 
                            if($arPropVals["PROP_CODE"] == "structure"){    
                                $adress .= $arPropVals["VALUE"].' ';
                            } 
                            if($arPropVals["PROP_CODE"] == "home"){    
                                $adress .= $arPropVals["VALUE"].' ';
                            } 
                            if($arPropVals["PROP_CODE"] == "apartment"){    
                                $adress .= $arPropVals["VALUE"];
                            }  
                            $arProp["CHECKED"] = 'N';      
                        }
                       
                        echo $adress; ?>
                        </label>  
                    </li>  
                      <?  }?>
                     </ul> 
            </div>  
            <?//arshow($arProp)?> 
                <div class="create_new_adress" <?if( empty($arProp) or $_POST["PROFILE_ID"] == 0 and !empty($_POST) or $_SESSION["new_adress_click"] == "true"){?>style="display: none;<?}?>">       <?//?>
                    <input class="prof" for="true" name="PROFILE_ID" <?if ($arProp["CHECKED"]=="Y") echo " checked";?> type="radio" id="ID_PROFILE_ID" onClick="setTimeout(submitForm(), 1000);SetContact(this.value); new_adress_click = true;" value="0"> <?// активация флага для переменной new_adress_click?>
                    <label for="ID_PROFILE_ID" class="radio">Добавить новый адрес доставки</label>             <?//onClick="setTimeout(submitForm(), 1000);"?>
                </div>
            <?}?>
        </div>

    <?
    if(!empty($arResult["DELIVERY"]))
    {
        $width = ($arParams["SHOW_STORES_IMAGES"] == "Y") ? 850 : 700;
        ?>
       
        <?

        foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
        {
            if ($delivery_id !== 0 && intval($delivery_id) <= 0)
            {
                foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
                {
                    ?>
                    <div class="bx_block w100 vertical" >      
                        <div class="bx_element">

                            <input
                                type="radio"
                                id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>"
                                name="<?=htmlspecialcharsbx($arProfile["FIELD_NAME"])?>"
                                value="<?=$delivery_id.":".$profile_id;?>"
                                <?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?>
                                onclick="submitForm();"
                                />

                            <label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">

                                <?
                                if (count($arDelivery["LOGOTIP"]) > 0):

                                    $arFileTmp = CFile::ResizeImageGet(
                                        $arDelivery["LOGOTIP"]["ID"],
                                        array("width" => "95", "height" =>"55"),
                                        BX_RESIZE_IMAGE_PROPORTIONAL,
                                        true
                                    );

                                    $deliveryImgURL = $arFileTmp["src"];
                                else:
                                    $deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
                                endif;

                                if($arDelivery["ISNEEDEXTRAINFO"] == "Y")
                                    $extraParams = "showExtraParamsDialog('".$delivery_id.":".$profile_id."');";
                                else
                                    $extraParams = "";

                                ?>
                                <div class="bx_logotype" onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;<?=$extraParams?>submitForm();">
                                    <span style='background-image:url(<?=$deliveryImgURL?>);'></span>
                                </div>

                                <div class="bx_description">

                                    <strong onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;<?=$extraParams?>submitForm();">
                                        <?=htmlspecialcharsbx($arDelivery["TITLE"])." (".htmlspecialcharsbx($arProfile["TITLE"]).")";?>
                                    </strong>

                                    <span class="bx_result_price"><!-- click on this should not cause form submit -->
                                        <?
                                        if($arProfile["CHECKED"] == "Y" && doubleval($arResult["DELIVERY_PRICE"]) > 0):
                                        ?>
                                            <div><?=GetMessage("SALE_DELIV_PRICE")?>:&nbsp;<b><?=$arResult["DELIVERY_PRICE_FORMATED"]?></b></div>
                                        <?
                                            if ((isset($arResult["PACKS_COUNT"]) && $arResult["PACKS_COUNT"]) > 1):
                                                echo GetMessage('SALE_PACKS_COUNT').': <b>'.$arResult["PACKS_COUNT"].'</b>';
                                            endif;

                                        else:
                                            $APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
                                                "NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
                                                "DELIVERY" => $delivery_id,
                                                "PROFILE" => $profile_id,
                                                "ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
                                                "ORDER_PRICE" => $arResult["ORDER_PRICE"],
                                                "LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
                                                "LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
                                                "CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
                                                "ITEMS" => $arResult["BASKET_ITEMS"],
                                                "EXTRA_PARAMS_CALLBACK" => $extraParams
                                            ), null, array('HIDE_ICONS' => 'Y'));
                                        endif;
                                        ?>
                                    </span>

                                    <p onclick="BX('ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>').checked=true;submitForm();">
                                        <?if (strlen($arProfile["DESCRIPTION"]) > 0):?>
                                            <?=nl2br($arProfile["DESCRIPTION"])?>
                                        <?else:?>
                                            <?=nl2br($arDelivery["DESCRIPTION"])?>
                                        <?endif;?>
                                    </p>
                                </div>

                            </label>

                        </div>
                    </div>
                    <?
                } // endforeach
            }
            else // stores and courier
            {
                if (count($arDelivery["STORE"]) > 0)
                    $clickHandler = "onClick = \"fShowStore('".$arDelivery["ID"]."','".$arParams["SHOW_STORES_IMAGES"]."','".$width."','".SITE_ID."')\";";
                else
                    $clickHandler = "onClick = \"BX('ID_DELIVERY_ID_".$arDelivery["ID"]."').checked=true;submitForm();\"";
                ?>
                     
                    <div class="bx_block w100 vertical" <?if ($arDelivery["CHECKED"]!="Y"){?>style="display: none;"<?}?>>

                        <div class="bx_element">

                            <input type="radio"
                                id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>"
                                name="<?=htmlspecialcharsbx($arDelivery["FIELD_NAME"])?>"
                                value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>
                                onclick="submitForm();"
                                />

                            <!--<label for="ID_DELIVERY_ID_<?=$arDelivery["ID"]?>" <?=$clickHandler?>>  -->

                                <?
                                if (count($arDelivery["LOGOTIP"]) > 0):

                                    $arFileTmp = CFile::ResizeImageGet(
                                        $arDelivery["LOGOTIP"]["ID"],
                                        array("width" => "auto", "height" =>"auto"),
                                        BX_RESIZE_IMAGE_PROPORTIONAL,
                                        true
                                    );

                                    $deliveryImgURL = $arFileTmp["src"];
                                else:
                                    $deliveryImgURL = $templateFolder."/images/logo-default-d.gif";
                                endif;
                                ?>

                                <div class="bx_logotype">
                                    <span <?if($_POST["profile_change"] == "Y"){?> class="wrap_delivery"<?}?> style='background-image:url(<?=$deliveryImgURL?>);'>
                                        <span class="bx_result_price">
                                        <?if($_POST["DELIVERY_ID"] == 1)
                                        {?>
                                              <strong>Самовывоз бесплатно</strong>
                                        <?}
                                        else
                                        {?>
                                            <?

                                            if (strlen($arDelivery["PERIOD_TEXT"])>0)
                                            {
                                               // echo $arDelivery["PERIOD_TEXT"];
                                                ?><br /><?
                                            }
                                            ?>
                                           
                                           <?if($_POST["DELIVERY_ID"] == 13 or     // транспортная компания стоимостью от 1501 до 3000 р
                                                $_POST["DELIVERY_ID"] == 12 or      // транспортная компания стоимостью от 0 до 1500 р
                                                $_POST["DELIVERY_ID"] == 14 or       // транспортная компания стоимостью от 3001 до 5000 р
                                                $_POST["DELIVERY_ID"] == 15){        // транспортная компания стоимостью от 5000
                                                echo "<p>Доставка до транспортной компании в Москве</p>"; 
                                            }else{?>
                                                <p> <?=GetMessage("SALE_DELIV_PRICE");?></p><br>
                                            <?}?> 
                                           <?if($arDelivery["PRICE"] <= 0){?>
                                               <strong>Бесплатно</strong>
                                           <?}else{?>
                                                <b><?=$arDelivery["PRICE_FORMATED"]?></b><br />
                                           <?}?>
                                        <?}?>
                                        </span>
                                    </span>
                                </div>

                                <div class="bx_description" >
                             
                                   
                                </div>

                           <!-- </label>  -->

                        <div class="clear"></div>
                    </div>
                </div>
                <?
            }
        }
    }
?>


	<? 
	$bHideProps = true;

	if (is_array($arResult["ORDER_PROP"]["USER_PROFILES"]) && !empty($arResult["ORDER_PROP"]["USER_PROFILES"])):
		if ($arParams["ALLOW_NEW_PROFILE"] == "Y"):
		?>
			<!--<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_PROP_CHOOSE")?>
			</div>
			<div class="bx_block r3x1">
				<select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
					<option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
					<?
					foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
					{
						?>
						<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
						<?
					}
					?>
				</select>
				<div style="clear: both;"></div>
			</div>   -->
		<?
		else:
		?>
			<div class="bx_block r1x3">
				<?=GetMessage("SOA_TEMPL_EXISTING_PROFILE")?>
			</div>
			<div class="bx_block r3x1">
					<?
					if (count($arResult["ORDER_PROP"]["USER_PROFILES"]) == 1)
					{
						foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
						{
							echo "<strong>".$arUserProfiles["NAME"]."</strong>";
							?>
							<input type="hidden" name="PROFILE_ID" id="ID_PROFILE_ID" value="<?=$arUserProfiles["ID"]?>" />
							<?
						}
					}
					else
					{
						?>
						<select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
							<?
							foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
							{
								?>
								<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
								<?
							}
							?>
						</select>
						<?
					}
					?>
				
			</div>
		<?
		endif;
	else:
		$bHideProps = false;
	endif;
	?>

  
<br/>   
    <div class="bx_section adress_pole">

	   
		    <?
		    if (array_key_exists('ERROR', $arResult) && is_array($arResult['ERROR']) && !empty($arResult['ERROR']))
		    {
			    $bHideProps = false;
		    }

		    if ($bHideProps && $_POST["showProps"] != "Y"):
		    ?>
			    <a href="#" class="slide" onclick="fGetBuyerProps(this); return false;">
				    <?=GetMessage('SOA_TEMPL_BUYER_SHOW');?>
			    </a>
		    <?
		    elseif (($bHideProps && $_POST["showProps"] == "Y")):
		    ?>
			    <a href="#" class="slide" onclick="fGetBuyerProps(this); return false;">
				    <?=GetMessage('SOA_TEMPL_BUYER_HIDE');?>
			    </a>
		    <?
		    endif;
		    ?>
		    <input type="hidden" name="showProps" id="showProps" value="<?=($_POST["showProps"] == 'Y' ? 'Y' : 'N')?>" />
         
         
         <?
         global $city_new_post;
       //  arshow($_SESSION["ALTASIB_GEOBASE_CODE"]["CITY"]["ID"]);
         $city_new_post = $_POST["ORDER_PROP_4"];    // записывает id выбранногог города в поле оформления заказа
         $db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$arProp["ID"]))->fetch(); //получаем массив адресов пользователя
        ?> 
          <?if( $_POST["DELIVERY_ID"] == 14 or     // транспортная компания стоимостью от 3001 до 5000 р
                $_POST["DELIVERY_ID"] == 15 or    // транспортная компания стоимостью от 5000
                $_POST["DELIVERY_ID"] == 12 or    // транспортная компания стоимостью от 0 до 1500 р
                $_POST["DELIVERY_ID"] == 13      // транспортная компания стоимостью от 1501 до 3000 р
                )
                    {
                    
                    }else{?> 
	                    <div id="sale_order_props" 
                              
                             class="<?=($_POST["DELIVERY_ID"] == 1)? "sale_order_props_none":""?>"
                             <?
                             if((empty($db_propVals)) or     // проверяет существкют ли адреса у данного пользователя
                                 $_POST["PROFILE_ID"] == 0 and // проверяет выбран ли какой либо адрес пользователя
                                 !empty($_POST) or      // проверяет не пустой ли метод POST
                                 $_SESSION["new_adress_click"] == "true"   // проверяет была ли активна кнопка "Новый адрес доставки"
                               )      //
                             { 
                                 echo "style='display:block;'";
                             }else{
                                 echo "style='display:none;'"; 
                             }?>>       
                            <div class="new_adress">
                                 <h2>Новый адрес доставки</h2>
                            </div>
		                    <?
                           // arshow(CSaleOrderUserPropsValue::GetByID($_SESSION["PROP_ID"]));
		                    PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);
		                    PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
		                    ?>
                            <div class="mandatory_fields">Просим вас заполнить новые поля - Контактный номер и контактное лицо</div>
                            <div class="city_null"></div>
	                    </div>  
                    <?}?>  
    </div>  
    <?//arshow($_SESSION["ALTASIB_GEOBASE_CODE"])?>
    

    <div class="element_date">
         <div class="exit_sale">
             <p>Отказ от заказа: <span> 500 <span class="rouble">a</span></span></p>
             <a href="javascript:void(0);">Подробнее об отказе</a>
         </div>
            <?PrintPropsForm_date($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);?>

         <p>Если товар не подошел, вы можете сразу вернуть его курьеру.<br>
            Проверка соответствия производится при курьере</p>

    </div>
         
    </div>    
<script type="text/javascript">
	function fGetBuyerProps(el)
	{
		var show = '<?=GetMessageJS('SOA_TEMPL_BUYER_SHOW')?>';
		var hide = '<?=GetMessageJS('SOA_TEMPL_BUYER_HIDE')?>';
		var status = BX('sale_order_props').style.display;
		var startVal = 0;
		var startHeight = 0;
		var endVal = 0;
		var endHeight = 0;
		var pFormCont = BX('sale_order_props');
		pFormCont.style.display = "block";
		pFormCont.style.overflow = "hidden";
		pFormCont.style.height = 0;
		var display = "";

		if (status == 'none')
		{
			el.text = '<?=GetMessageJS('SOA_TEMPL_BUYER_HIDE');?>';

			startVal = 0;
			startHeight = 0;
			endVal = 100;
			endHeight = pFormCont.scrollHeight;
			display = 'block';
			BX('showProps').value = "Y";
			el.innerHTML = hide;
		}
		else
		{
			el.text = '<?=GetMessageJS('SOA_TEMPL_BUYER_SHOW');?>';

			startVal = 100;
			startHeight = pFormCont.scrollHeight;
			endVal = 0;
			endHeight = 0;
			display = 'none';
			BX('showProps').value = "N";
			pFormCont.style.height = startHeight+'px';
			el.innerHTML = show;
		}

		(new BX.easing({
			duration : 700,
			start : { opacity : startVal, height : startHeight},
			finish : { opacity: endVal, height : endHeight},
			transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
			step : function(state){
				pFormCont.style.height = state.height + "px";
				pFormCont.style.opacity = state.opacity / 100;
			},
			complete : function(){
					BX('sale_order_props').style.display = display;
					BX('sale_order_props').style.height = '';

					pFormCont.style.overflow = "visible";
			}
		})).animate();
	}    

</script>

<?if(!CSaleLocation::isLocationProEnabled()):?>
	<div style="display:none;">

		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.ajax.locations",
			$arParams["TEMPLATE_LOCATION"],
			array(
				"AJAX_CALL" => "N",
				"COUNTRY_INPUT_NAME" => "COUNTRY_tmp",
				"REGION_INPUT_NAME" => "REGION_tmp",
				"CITY_INPUT_NAME" => "tmp",
				"CITY_OUT_LOCATION" => "Y",
				"LOCATION_VALUE" => "",
				"ONCITYCHANGE" => "submitForm()",
			),
			null,
			array('HIDE_ICONS' => 'Y')
		);?>

	</div>
<?endif?>
