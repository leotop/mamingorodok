<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<input type="hidden" id="nohide" value="1">
<?
if (StrLen($arResult["ERROR_MESSAGE"])<=0)
{
	if(is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
	{
		foreach($arResult["WARNING_MESSAGE"] as $v)
		{
			echo ShowError($v);
		}
	}
	
	?>
	<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" class="jqtransform">
	<input type="hidden" id="allPriceFull" value="<?=$arResult["allSum"]?>">
		<?
		if ($arResult["ShowReady"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
		}

		if ($arResult["ShowDelay"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delay.php");
		}

		if ($arResult["ShowNotAvail"]=="Y")
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_notavail.php");
		}
		?>
	</form>
	<div id="cerfBasket" class="CatPopUp">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
        <div class="title">Выберите сертификаты</div>
			<?//print_R($arResult["CERT"]);?>
		<?if(isset($arResult["CERT"]) && is_array($arResult["CERT"]) && count($arResult["CERT"])>0):?>
        <form class="jqtransform">
			
            <div class="certdiv">
				<input type="hidden" value="<?=$arResult["SALE"]?>" id="allCert">
				<?$arr = $_SESSION["certificates"];?>
				<?foreach($arResult["CERT"] as $cert):?>
                <?arshow($cert["ID"])?>
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
		<?endif?>
        <div class="clear"></div>
        
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 


	<?
    
}
else
	ShowError($arResult["ERROR_MESSAGE"]);
?>
