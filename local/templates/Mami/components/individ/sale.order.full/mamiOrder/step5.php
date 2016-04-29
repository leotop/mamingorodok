<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->SetTitle("������������� ������");?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb"=>5), array("MODE"=>"html") );?>
<div>
<?echo ShowError($arResult["ERROR_MESSAGE"]); ?>
<input type="hidden" id="location" value="<?=$arResult["POST"]["DELIVERY_LOCATION"]?>">
<input type="hidden" id="weight" value="<?=$arResult["POST"]["ORDER_WEIGHT"]?>">
<input type="hidden" id="delevery" value="<?=$arResult["POST"]["DELIVERY_ID"]?>">
<input type="hidden" id="lang" value="<?=$arResult["BASE_LANG_CURRENCY"]?>">
<div class="basketResult">
	<div class="pnk bold2">���������� � ���������� <a href="" class="grey backstep">��������</a></div>
	<p class="black"><b>��������:</b> <?=$arResult["ORDER_PROPS_PRINT"][0]["VALUE_FORMATED"]?> <?=$arResult["ORDER_PROPS_PRINT"][2]["VALUE_FORMATED"]?></p>
	<p class="black"><b>�������:</b> <?=$arResult["ORDER_PROPS_PRINT"][1]["VALUE_FORMATED"]?></p>
	<p class="black"><b>����� ��������:</b> <?=$arResult["ORDER_PROPS_PRINT"][3]["VALUE_FORMATED"]?>,
	<?=$arResult["ORDER_PROPS_PRINT"][4]["VALUE_FORMATED"]?><?if(!empty($arResult["ORDER_PROPS_PRINT"][5]["VALUE_FORMATED"])):?>, <?=$arResult["ORDER_PROPS_PRINT"][5]["VALUE_FORMATED"]?><?endif;?>
	<?//print_R($arResult["ORDER_PROPS_PRINT"])?>
	</p>
</div>
<div class="bottomline">
	������ ������ <a href="/basket/" class="grey">��������</a>
	<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>">
</div>
</div>

<table class="sale_order_full">
<tr>
	<th colspan="2">�����</th>
	<th width="80px">����������</th>
	<th width="80px">���������</th>
</tr>
<?
foreach($arResult["BASKET_ITEMS"] as $arBasketItems)
{
	?>
	<tr>
		<td class="imgg100"><?=ShowImage($arResult["SHOW_INFO"][$arBasketItems["PRODUCT_ID"]]["PICTURE"],100,100)?></td>
		<td><a class="tnn" href="<?=$arResult["SHOW_INFO"][$arBasketItems["PRODUCT_ID"]]["DETAIL_PAGE_URL"]?>"><?=$arResult["SHOW_INFO"][$arBasketItems["PRODUCT_ID"]]["NAME"]?></a>
		<div class="clear"></div>
		<?=showRating($arBasketItems["RATING"])?>
		<div class="clear"></div>
		<div class="top5"></div>
		����: <?=$arResult["SHOW_INFO"][$arBasketItems["PRODUCT_ID"]]["COLOR"]?>
		<div class="clear"></div>
		������: <?=$arResult["SHOW_INFO"][$arBasketItems["PRODUCT_ID"]]["SIZE"]?>
		<div class="clear"></div>
		</td>
		<td class="alignr"><?=intval($arBasketItems["QUANTITY"])?></td>
		<td><?=$arBasketItems["PRICE"]*$arBasketItems["QUANTITY"]?> ���.</td>
	</tr>
	<?
}
?>
</table>
<table width="100%" class="resultPT">
	<tr>
		<td width="50%"></td>
		<td class="alignr itogoT">����� ��� ��������� ��������:</td>
		<td width="80px" class="black max"><nobr><?=$arResult["ORDER_PRICE"]?> ���.</nobr></td>
	</tr>
	<!--<tr>
		<td class="alignr">������ ��� ������������� ������������:</td>
		<td class="alignr">������ ��� ������������� ������:</td>
		<td><??></td>
	</tr>-->
	<tr>
		<td><a href="#cerfBasket" class="showpUp greydot padding-class">������� ����������� ��� ������</a></td>
		<td class="alignr sertT">������ ������������� �� �����:</td>
		<td class="black"><nobr><span class="serf"><?=$arResult["SALE"]?></span> ���.</nobr></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr >
		<td >
		<div class="pnk bold">������ �������� <a href="3" class="grey backstep">��������</a></div>	
		<div class="sm">
		<?
		//echo "<pre>"; print_r($arResult); echo "</pre>";
		if (is_array($arResult["DELIVERY"]))
		{

				echo $arResult["DELIVERY"]["NAME"];
		
				
			
			/*if (is_array($arResult["DELIVERY_ID"]))
			{
				echo " (".$arResult["DELIVERY"]["PROFILES"][$arResult["DELIVERY_PROFILE"]]["TITLE"].")";
			}*/
		}
		elseif ($arResult["DELIVERY"]=="ERROR")
		{
			echo ShowError(GetMessage("SALE_ERROR_DELIVERY"));
		}
		else
		{
			echo "��������� �� ������";
		}
		?>
		</div>
		<?//print_r($arResult)?>
		</td>
		<td class="alignr sertT">��������� ��������:</td>
		<td class="black"><nobr><span class="dostav"><?=$arResult["DELIVERY_PRICE"]?></span> ���.</nobr></td>
	</tr>
	
	<tr>
		<td>
		<div class="pnk bold">������ ������ <a href="4" class="grey backstep">��������</a></div>	
		<div class="sm">
		<?
		if (is_array($arResult["PAY_SYSTEM"]))
		{
			echo $arResult["PAY_SYSTEM"]["PSA_NAME"];
		}
		elseif ($arResult["PAY_SYSTEM"]=="ERROR")
		{
			echo ShowError(GetMessage("SALE_ERROR_PAY_SYS"));
		}
		elseif($arResult["PAYED_FROM_ACCOUNT"] != "Y")
		{
			echo GetMessage("STOF_NOT_SET");
		}
		if($arResult["PAYED_FROM_ACCOUNT"] == "Y")
			echo " (".GetMessage("STOF_PAYED_FROM_ACCOUNT").")";
		?>	
		</div>
		</td>
		<td class="alignr sertT black max">����� � ������:</td>
		<td class="black"><span class="redPr"><nobr><span class="itogo"><?=$arResult["ORDER_PRICE"]-$arResult["SALE"]+$arResult["DELIVERY_PRICE"]?></span> ���.</nobr></span></td>
	</tr>
</table>
<div class="mrgt"></div>
<?//print_R($arResult);?>
<div id="comment" class="commentForm">
<div class="leftTR"></div>
<div class="leftBR"></div>
<div class="rightTR"></div>
<div class="rightBR"></div>
<div class="mrgsogl">
	&nbsp;
</div>
<div class="mrgbtn">
<input type="submit" name="contButton" value="<?= GetMessage("SALE_CONFIRM")?>">
</div>
</div>