<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetTitle("����� �����������");


		$arParams["PATH_TO_PAYMENT"] = '/basket/order/payment.php';
		if (!empty($arResult["ORDER"]))
		{
			// certifacates
			$arResult["CERTIFICATE"] = array();
			$arResult["CERTIFICATE_PRICE"] = 0;
			$rsCertificates = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CERTIFICATES_PRESENT_IBLOCK_ID, "PROPERTY_ORDER_ID"=>$arResult["ORDER"]["ID"]), false, false, array("PROPERTY_CERTIFICATE_ID"));
			while($arCertificate = $rsCertificates -> GetNext())
				$arResult["CERTIFICATE"][$arCertificate["PROPERTY_CERTIFICATE_ID_VALUE"]]++;
			
			if(count($arResult["CERTIFICATE"])>0)
			{
				$rsCPrice = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID, "ID"=>array_keys($arResult["CERTIFICATE"])), false, false, array("PROPERTY_PRICE", "ID", "IBLOCK_ID"));
				while($arCPrice = $rsCPrice -> Fetch())
					$arResult["CERTIFICATE_PRICE"] += $arResult["CERTIFICATE"][$arCPrice["ID"]] * $arCPrice["PROPERTY_PRICE_VALUE"];
			}
			
			echo '<script type="text/javascript"> '.getGASaleJS($arResult["ORDER"]["ID"]).' </script>';
			
			
			$arDelivery = CSaleDelivery::GetByID($arResult["ORDER"]["DELIVERY_ID"]);			
			?>
			<table class="sale_order_full_table">
				<tr>
					<td>
						<p>��� ����� <strong>� <?=$arResult["ORDER_ID"]?></strong> �� <?=date("d.m.Y")?> ������. � ��������� ����� � ���� �������� ��� �������� ��� ��� �������������.<br>
						�� ���� ����� <strong><?=$USER -> GetEmail()?></strong> ���������� ������, ���������� ���������� � ������.</p><br>
						<p>
							�������� ����� ���������� ������, �� ��������� ����� ��������� ����� ��� ������������ ��������, ����� ����� ������������� ������� ������ ����� ���������� �� ������ <a href="/personal/order/">������� ��������</a>.</p><br>
						<p>
						���� � ��� �������� �������, �� ������ ��������� � ���� ����� ������� ��� ��� ��������:<br>
							<ul class="common_ul">
								<li>�� �������� (��� ������ � ��): <strong>+7 (495) 988-32-39</strong></li>
								<li>�� �������� ������� ����� (��� ��������): <strong>8 800 775 91 36</strong></li>
								<li>�� ����������� �����: <a href="mailto:info@mamingorodok.ru">info@mamingorodok.ru</a></li>
								<li>����� ������-��� �� ����� �����</li>
						</ul></p>
<br><p>
						������� �� ����� ������ ��������-��������!<br>
						� ���������, ��� ����� �������.</p>
					</td>
				</tr>
			</table><?
			if(false) {?>
			<br>
			<div class="pink_d"><?
			
			$arCreditItems = array();
			$strOrderItems = '';
			$floatItemsPrice = 0;
			$intCnt = 1;
			$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC"),
				array("ORDER_ID" => $arResult["ORDER"]["ID"]),
				false,
				false,
				array("ID", "PRODUCT_ID", "NAME", "PRICE", "CURRENCY", "QUANTITY")
			);
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				$rsItem = CIBlockElement::GetList(Array(), array("ID"=>$arBasketItems["PRODUCT_ID"]), false, false, array("IBLOCK_ID", "PROPERTY_MAIN_PRODUCT.DETAIL_PAGE_URL", "PROPERTY_MAIN_PRODUCT.NAME", "PROPERTY_MAIN_PRODUCT.IBLOCK_SECTION_ID", "ID", "PROPERTY_COLOR", "PROPERTY_SIZE", "PROPERTY_PICTURE_MIDI"));
				$arItem = $rsItem->GetNext();				
				
				$arFile = CFile::ResizeImageGet($arItem["PROPERTY_PICTURE_MIDI_VALUE"],array("width"=>100,"height"=>100), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
				
				$strOrderItems .= '
					<tr>
						<td>';
				
				if(strlen($arFile["src"])>0) $strOrderItems .= '<a href="'.$arItem["PROPERTY_MAIN_PRODUCT_DETAIL_PAGE_URL"].'"><img src="'.$arFile["src"].'" border="0" alt="'.$arItem["PROPERTY_MAIN_PRODUCT_NAME"].'"></a>';
				
				$strOrderItems .= '</td>
						<td><a href="'.$arItem["PROPERTY_MAIN_PRODUCT_DETAIL_PAGE_URL"].'">'.$arItem["PROPERTY_MAIN_PRODUCT_NAME"].'</a>';
						
				$strAddon = '';
				if(strlen($arItem["PROPERTY_COLOR_VALUE"])>0) $strAddon .= '����: '.$arItem["PROPERTY_COLOR_VALUE"];
				if(strlen($arItem["PROPERTY_SIZE_VALUE"])>0) $strAddon .= (strlen($strAddon)>0?'<br>':'').'������: '.$arItem["PROPERTY_SIZE_VALUE"];
				
				if(strlen($strAddon)>0)
					$strOrderItems .= '<br><br>'.$strAddon;	
				
				$strOrderItems .= '</td>
						<td>'.CurrencyFormat($arBasketItems["PRICE"], "RUB").'</td>
						<td>'.intval($arBasketItems["QUANTITY"]).'</td>
						<td>'.CurrencyFormat($arBasketItems["PRICE"]*$arBasketItems["QUANTITY"], "RUB").'</td>
					</tr>';
				
				$arTmp = array();
				$rsNav = CIBlockSection::GetNavChain(2, $arItem["PROPERTY_MAIN_PRODUCT_IBLOCK_SECTION_ID"]);
				while($arNav = $rsNav -> GetNext())
					$arTmp[] = $arNav["NAME"];
				
				$rsSec = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>2, "ID" => $arItem["PROPERTY_MAIN_PRODUCT_IBLOCK_SECTION_ID"], "ACTIVE"=>"Y"), false);
				$arSec = $rsSec -> GetNext();
				
				$arCreditItems[] = array(
					'title' => $arItem["PROPERTY_MAIN_PRODUCT_NAME"],
					'category' => $arSec["NAME"],
					'qty' => $arBasketItems["QUANTITY"],
					'price' => $arBasketItems["PRICE"]*$arBasketItems["QUANTITY"],
				);
				
				$floatItemsPrice += $arBasketItems["PRICE"] * $arBasketItems["QUANTITY"];
				$intCnt++;
			}

				if(false) {
			
			if(true)
			{
?>
				<h2>�������� ������ ������:</h2>
				<br>
				<ol class="num_list">
					<li>��������� ��� ��������� ������. (������ ��� ������ � ��)</li>
					<li><a href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=5" onclick="return creditClick(<?=$arResult["ORDER_ID"]?>);" target="_blank">�������� ������</a> ������. <? $APPLICATION->IncludeComponent("individ:sale.order.payment",'',array('ORDER_ID_VALUE'=>$_REQUEST['ORDER_ID'], "DIE" => "N", "PAYMENT_ID" => 5), false); ?></li>
					<li><a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=3">������� ���������</a> ��� ������ � ����� �����.</li>
				<li><a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=6&type=card">���������� ������</a> �� �����. �� ��������� Visa,
				Master Card.</li><?
				if(false) {?>
					<li><a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=2&type=card">���������� ������</a> �� �����. �� ��������� Visa,
						Master Card.</li>
					<?
				}

				if(false) { ?><li><a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=2&type=emoney">������������ ��������</a> �� �����. �� ��������� ������.������, WebMoney, QIWI. �������� 4,5%</li><?
				}?>
				</ol><?
			} else {?>
				<h2>�� ������ �������� ����� ��������</h2>
				<br>
				<table width="100%">
					<tr>
						<td width="300">Visa, Master Card, WebMoney, ������ ������, QIWI</td>
						<td><a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=2">�������� ����� ��������� �������</a></td>
						<td width="400">��� ������ ������������ �������� ������������� ��������� ���������� �������� 4%.</td>
					</tr>
				</table>
				<br>
				��� ������� <a target="_blank" href="/system/payment_selected.php?ORDER_ID=<?=$arResult["ORDER_ID"]?>&pay_system=3">��������� ��� ������ � �����</a>
				<br>
				<br><?
			}
				}?>
			</div>
			<br>
			<div class="pink_d hidden" id="orderDetails">
				<h2>������ ������</h2><br>
				<table class="sale_basket_basket data-table">
					<tr>
						<th width="110">&nbsp;</th>
						<th>��������</th>
						<th width="80">����</th>
						<th width="80">���-��</th>
						<th width="80">���������</th>
					</tr>
					<?=$strOrderItems?>
				</table>
			</div>
			<p>
			<a href="#" onclick="$('#orderDetails').show(); $(this).parent().hide(); return false;">���������� �����</a>
			<br></p><br>
			<div class="pink_d">
				<table width="400">
					<tr>
						<td>��������� ������� ��� ������</td>
						<td><?=CurrencyFormat($floatItemsPrice, "RUB")?></td>
					</tr>
					<tr>
						<td>�������� �������������</td>
						<td><?=CurrencyFormat($arResult["CERTIFICATE_PRICE"], "RUB")?></td>
					</tr>
					<tr>
						<td>��������</td>
						<td><?=CurrencyFormat($arDelivery["PRICE"], "RUB")?></td>
					</tr>
					<tr>
						<td><strong>�����:</strong></td>
						<td class="redPr"><?=CurrencyFormat($arResult["ORDER"]["PRICE"], "RUB")?></td>
					</tr>
				</table>
			</div>
			<?
			}

			if (!empty($arResult["PAY_SYSTEM"]) && false)
			{
				?>
				<?/*<div class="bottomline" style="width:100%"><?echo GetMessage("STOF_ORDER_PAY_ACTION")?></div><br /><br /> */?>

				<table class="sale_order_full_table">
					<?/*<tr>
						<td>
							<?echo GetMessage("STOF_ORDER_PAY_ACTION1")?> <?= $arResult["PAY_SYSTEM"]["NAME"] ?>
						</td>
					</tr> */?>
					<?
					if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
					{
						?>
						<tr>
							<td>
								<?
								if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
								{
									if(false)
									{
									?>
									<script language="JavaScript">
										$(document).ready(function() { 
											$("#popago").append("<form target='_blank' action='<?=$arParams["PATH_TO_PAYMENT"]?>'><input type='hidden' value='<?=$arResult["ORDER_ID"]?>' name='ORDER_ID'></form>");
											$("#popago form").submit();
										});
									</script><?
									}
									?>
									<?= str_replace(array("#LINK#", "<a"), array($arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$arResult["ORDER_ID"], "<a target='_blank'"), GetMessage("STOF_ORDER_PAY_WIN")) ?>
									<?
								}
								else
								{
									if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
									{
										include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
									}
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				<div class="displaynone" id="popago">
					
				</div>
				<?
			}
		}
		else
		{
			?>
			<div class="bottomline"><?echo GetMessage("STOF_ERROR_ORDER_CREATE")?></div>
			<br /><br />
			<table class="sale_order_full_table">
				<tr>
					<td>
						<?=str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_NO_ORDER"))?>
						<?=GetMessage("STOF_CONTACT_ADMIN")?>
					</td>
				</tr>
			</table>
			<?
		}
		?>
		<? /*<div class="bottomline">�� ������:</div> */ ?>
		<br />
		<? echo GetMessage("SALE_CONTENT_FROM_ILYA_2"); ?>
		<br /><br />
<table>
	<tr>
		<td style="padding:10px;">
			<a href="http://vkontakte.ru/mamingorodok" style="font-size:16px;">����� ������� ���������</a>
		</td>
		<td>
			<a href="http://vkontakte.ru/mamingorodok"><img src="/i/vkontakte.png"></a>
		</td><? if (false) { ?>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td style="padding:10px;">
			<a href="http://www.facebook.ru/mamingorodok" style="font-size:16px;">����� ������� Facebook</a>
		</td>
		<td>
			<a href="http://www.facebook.com/mamingorodok"><img src="/i/facebook.png"></a>
		</td><? } ?>
	</tr>
</table>
