<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (is_array($arResult["RESULT"]))
{
	if ($arResult["RESULT"]["RESULT"] == "NEXT_STEP")
		require("step.php");
	else
	{
		if ($arResult["RESULT"]["RESULT"] == "ERROR")
			echo ShowError($arResult["RESULT"]["TEXT"]);
		elseif ($arResult["RESULT"]["RESULT"] == "NOTE")
			echo ShowNote($arResult["RESULT"]["TEXT"]);
		elseif ($arResult["RESULT"]["RESULT"] == "OK")
		{
			
			?>
				<input type="hidden" id="dost" value="<?=$arResult["RESULT"]["VALUE"]?>">
			<?

			/*if ($arResult["RESULT"]["TRANSIT"] > 0)
			{
				echo '<br />';
				echo GetMessage('SALE_SADC_TRANSIT').': <b>'.$arResult["RESULT"]["TRANSIT"].'</b>';
			}*/
		}
	}
}

if ($arParams["STEP"] == 0)
	require("start.php");
?>