<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!$USER->IsAuthorized())
{
	echo ShowError($arResult["ERROR_MESSAGE"]);	
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
}
else
{
	if ($arResult["CurrentStep"] < 6):?>
		<form method="post" id="orderForm" class="jqtransform" action="<?=htmlspecialchars('/basket/order/'.($arResult["CurrentStep"]>0?$arResult["CurrentStep"].'/':''))?>" name="order_form">
	<?endif;?>
	<?//print_R($arResult)?>
<input type="hidden" id="allPriceFull" value="<?=$arResult["ORDER_PRICE"]?>">
	<table width="100%" border="0">
	<?
	if($arParams["SHOW_MENU"] == "Y")
	{
		?>		
		<tr>
			<td>
			<?if ($arResult["CurrentStep"] < 6):?>
				
				<?
				$arMenuLine = array(
						0 => GetMessage("STOF_PERSON_TYPE"),
						1 => GetMessage("STOF_MAKING"),
						2 => GetMessage("STOF_DELIVERY"),
						3 => GetMessage("STOF_PAYMENT"),
						4 => GetMessage("STOF_CONFIRM")
					);
				for ($i = 0; $i < count($arMenuLine); $i++)
				{
					
					//if ($arResult["SKIP_FIRST_STEP"] == "Y" && $i == 0)
						//continue;
					if ($arResult["SKIP_FIRST_STEP"] == "Y" && $i == 0)
						continue;
					if ($arResult["SKIP_SECOND_STEP"] == "Y" && $i == 1)
						continue;
					if ($arResult["SKIP_THIRD_STEP"] == "Y" && $i == 2)
						continue;
					if ($arResult["SKIP_FORTH_STEP"] == "Y" && $i == 3)
						continue;

					
					if ($i > 0)
						echo " &gt; ";

					if ($arResult["CurrentStep"] > $i + 1)
						echo "<a href=\"#\" OnClick=\"document.order_form.CurrentStep.value='".($i + 1)."'; document.order_form.BACK.value='Y'; document.order_form.submit();\">".$arMenuLine[$i]."</a>";
					elseif ($arResult["CurrentStep"] == $i + 1)
						echo "<b>".$arMenuLine[$i]."</b>";
					else
						echo $arMenuLine[$i];
				}
				?>
				
			<?endif;?>
			</td>
		</tr>
		<?
	}
	?>
	<tr>
		<td><br />
			
			<?
			if ($arResult["CurrentStep"] == 1)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step1.php");
			elseif ($arResult["CurrentStep"] == 2)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step2.php");
			elseif ($arResult["CurrentStep"] == 3)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step3.php");
			elseif ($arResult["CurrentStep"] == 4)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step4.php");
			elseif ($arResult["CurrentStep"] == 5)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step5.php");
			elseif ($arResult["CurrentStep"] >= 6)
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/step6.php");
			?>
		</td>
	</tr>
	</table>


	<?if ($arResult["CurrentStep"] > 0 && $arResult["CurrentStep"] <= 7):?>
		<input type="hidden" name="ORDER_PRICE" value="<?= $arResult["ORDER_PRICE"] ?>">
		<input type="hidden" name="ORDER_WEIGHT" value="<?= $arResult["ORDER_WEIGHT"] ?>">
		<input type="hidden" name="SKIP_FIRST_STEP" value="<?= $arResult["SKIP_FIRST_STEP"] ?>">
		<input type="hidden" name="SKIP_SECOND_STEP" value="<?= $arResult["SKIP_SECOND_STEP"] ?>">
		<input type="hidden" name="SKIP_THIRD_STEP" value="<?= $arResult["SKIP_THIRD_STEP"] ?>">
		<input type="hidden" name="SKIP_FORTH_STEP" value="<?= $arResult["SKIP_FORTH_STEP"] ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 1 && $arResult["CurrentStep"] <= 6):?>
		<input type="hidden" name="PERSON_TYPE" value="<?= $arResult["PERSON_TYPE"] ?>">
		<input type="hidden" name="BACK" value="">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 2 && $arResult["CurrentStep"] <= 6):?>
		<input type="hidden" name="PROFILE_ID" value="<?= $arResult["PROFILE_ID"] ?>">
		<input type="hidden" name="DELIVERY_LOCATION" value="<?= $arResult["DELIVERY_LOCATION"] ?>">
		<?
		$dbOrderProps = CSaleOrderProps::GetList(
				array("SORT" => "ASC"),
				array("PERSON_TYPE_ID" => $arResult["PERSON_TYPE"]),
				false,
				false,
				array("ID", "TYPE", "SORT")
			);
		while ($arOrderProps = $dbOrderProps->Fetch())
		{
			if ($arOrderProps["TYPE"] == "MULTISELECT")
			{
				if (count($arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]]) > 0)
				{
					for ($i = 0; $i < count($arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]]); $i++)
					{
						?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>[]" value="<?= $arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]][$i] ?>"><?
					}
				}
				else
				{
					?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>[]" value=""><?
				}
			}
			else
			{
				?><input type="hidden" name="ORDER_PROP_<?= $arOrderProps["ID"] ?>" value="<?= $arResult["POST"]["ORDER_PROP_".$arOrderProps["ID"]] ?>"><?
			}
		}
		?>
	<?endif?>

	<?if ($arResult["CurrentStep"] > 3 && $arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="DELIVERY_ID" value="<?= is_array($arResult["DELIVERY_ID"]) ? implode(":", $arResult["DELIVERY_ID"]) : IntVal($arResult["DELIVERY_ID"]) ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] > 4 && $arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="TAX_EXEMPT" value="<?= $arResult["TAX_EXEMPT"] ?>">
		<input type="hidden" name="PAY_SYSTEM_ID" value="<?= $arResult["PAY_SYSTEM_ID"] ?>">
		<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="<?= $arResult["PAY_CURRENT_ACCOUNT"] ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] < 6):?>
		<input type="hidden" name="CurrentStep" value="<?= ($arResult["CurrentStep"] + 1) ?>">
	<?endif?>

	<?if ($arResult["CurrentStep"] < 6):?>
		</form>
	<?endif;?>
	
	<?//print_R($arResult)?>
		<div id="cerfBasket" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Выберите сертификаты</div>
		<?if(isset($arResult["CERT"]) && is_array($arResult["CERT"]) && count($arResult["CERT"])>0):?>
        <form class="jqtransform">
            <div class="certdiv">
				<input type="hidden" value="<?=$arResult["SALE"]?>" id="allCert">
				<?$arr = $_SESSION["certificates"];?>
				<?foreach($arResult["CERT"] as $cert):?>
					<?for($i=0;$i<$cert["COUNT"];$i++){?>
						<div class="certItem">
							
							<?$check = "";
								if(isset($arr[$cert["ID"]]) && $arr[$cert["ID"]]>0){
									$check = "checked";
									$arr[$cert["ID"]]--;
								}
							?>
							<input type="checkbox" class="certItem_checkbox" id="<?=$cert["PRICE"]?>" value="<?=$cert["ID"]?>" <?=$check?>>
							<div class="certItem_picture"><?=CFile::ShowImage($cert["PICTURE"],50,50)?></div>
							<div class="certItem_price"><?=$cert["PRICE"]?> руб.</div>
						</div>
					<?}?>
				<?endforeach?>
			</div>
			<div class="clear"></div>
            <div class="top30"><input type="submit" class="addCert purple" value="<?if($arResult["SALE"]>0):?>Выбрано <?=$arResult["SALE"]?> руб<?else:?>Выбрать<?endif?>" /></div>
        </form>
		<?else:?>
			<p>В данный момент у вас нет сертификатов.</p>
			<!--<p>Вы можете <a href="#">купить</a> их самостоятельно или получить в подарок от друзей.</p>-->
		<?endif?>
        <div class="clear"></div>
        
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div>	
<?
}
?>