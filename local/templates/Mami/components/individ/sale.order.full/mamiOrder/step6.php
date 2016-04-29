<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->SetTitle("Заказ сформирован");?>
		<?
		if (!empty($arResult["ORDER"]))
		{
			?>
			<table class="sale_order_full_table">
				<tr>
					<td>
						<?/*
						<?= str_replace("#ORDER_DATE#", $arResult["ORDER"]["DATE_INSERT_FORMATED"], str_replace("#ORDER_ID#", $arResult["ORDER_ID"], GetMessage("STOF_ORDER_CREATED_DESCR"))); ?>
						<!--<br /><br />
						<?//= str_replace("#LINK#", $arParams["PATH_TO_PERSONAL"], GetMessage("STOF_ORDER_VIEW")) ?>-->
						*/?>
						<? echo str_replace(array('#ORDER_DATE#', '#ORDER_ID#', '#LINK#'), array($arResult["ORDER"]["DATE_INSERT_FORMATED"], $arResult["ORDER_ID"], $arParams["PATH_TO_PERSONAL"]), GetMessage("SALE_CONTENT_FROM_ILYA_1")); ?>
					</td>
				</tr>
			</table>
			<?
			if (!empty($arResult["PAY_SYSTEM"]))
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
									?>
									<script language="JavaScript">
										$(document).ready(function() { 
											$("#popago").append("<form target='_blank' action='<?=$arParams["PATH_TO_PAYMENT"]?>'><input type='hidden' value='<?=$arResult["ORDER_ID"]?>' name='ORDER_ID'></form>");
											$("#popago form").submit();
										});
									</script>
									<?= str_replace("#LINK#", $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$arResult["ORDER_ID"], GetMessage("STOF_ORDER_PAY_WIN")) ?>
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
		<?/*<div class="bottomline">Вы можете:</div> */?>
		<br />
		<? echo GetMessage("SALE_CONTENT_FROM_ILYA_2"); ?>
		<br /><br />
		<table>
		<tr>
			<td style="padding:10px;">
			<a href="http://vkontakte.ru/mamingorodok" style="font-size:16px;">Мамин Городок Вконтакте</a>
			</td>
			<td>
			<a href="http://vkontakte.ru/mamingorodok"><img src="/i/vkontakte.png"></a>
			</td>
			<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
			<td style="padding:10px;">
			<a href="http://www.facebook.ru/mamingorodok" style="font-size:16px;">Мамин Городок Facebook</a>
			</td>
			<td>
			<a href="http://www.facebook.com/mamingorodok"><img src="/i/facebook.png"></a> 
			</td>
		</tr>
				
		<?/*<div>Пообщаться в <a href="/community/group/">сообществе</a>, либо перейти к просмотру <a href="/catalog/">других товаров.</a></div>*/?>
