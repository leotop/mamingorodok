<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

if($_REQUEST["sef"] == "Y")
{
	$arExclude = array("sef", "producerCode", "propertyCode");
	
	$isMod = false;
	$strNavQueryStringOrig = str_replace("&amp;", "&", $strNavQueryString);
	
	
	parse_str($strNavQueryStringOrig, $arTmp);
	foreach($arTmp as $key => $val)
	{
		if(in_array($key, $arExclude))
		{
			unset($arTmp[$key]);
			$isMod = true;
		}
	}
	
	if($isMod)
	{
		if(count($arTmp)>0)
		{
			$arP = array();
			foreach($arTmp as $key => $val)
				$arP[] = $key.'='.$val;
			
			$strNavQueryString = implode("&", $arP).'&';
			$strNavQueryStringFull = '?'.implode("&", $arP);
		} else {
			$strNavQueryString = '';
			$strNavQueryStringFull = '';
		}
	}
}

?>
<!--noindex-->

<? if ($_GET['PAGEN_1'] == 2) : ?>

							<div class="show_block">

							<?$showCount = 1;?>

							<?if($arResult["bDescPageNumbering"] === true):?>

							    <?=$arResult["NavFirstRecordShow"]?> - <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>&nbsp;&nbsp;|&nbsp;    
							    
								<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
									<?if($arResult["bSavePage"]):?>
							            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
										<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_begin")?></a>
									<?else:?>
										<?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
											<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
										<?else:?>
											<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
										<?endif?>
							            <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a> 
									<?endif?>
								<?else:?>
								<?endif?>

								<?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
									<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

									<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
										<span class="select"><span><?=$NavRecordGroupPrint?></span></span>
									<?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
										<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
									<?else:?>
										<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
									<?endif?>

									<?$arResult["nStartPage"]--?>
								<?endwhile?>

								

								<?if ($arResult["NavPageNomer"] > 1):?>
									<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_end")?></a>
							        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a>
								<?else:?>
								<?endif?>

							<?else:?>


							    <?=$arResult["NavFirstRecordShow"]?> - <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>&nbsp;&nbsp;|&nbsp;    
							    
								<?if ($arResult["NavPageNomer"] > 1):?>

									<?if($arResult["bSavePage"]):?>
							            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
							            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_begin")?></a>
									<?else:?>
										<?if ($arResult["NavPageNomer"] > 2):?>
											<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
										<?else:?>
											<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
										<?endif?>
										<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a>
									<?endif?>

								<?else:?>
								<?endif?>

								<?$start = $arResult["NavPageNomer"]-$showCount;?>
								<?$end = $arResult["NavPageNomer"]+$showCount;?>
								<?$oldstart = $arResult["nStartPage"]?>
								<?
								if($start>$arResult["nStartPage"])
									$arResult["nStartPage"] = $start;
								else
									$start = $arResult["nStartPage"];
								?>
								<?$oldend = $arResult["nEndPage"]?>
								<?
								if($arResult["nEndPage"]>$end)
									$arResult["nEndPage"] = $end;
								else
									$end = $arResult["nEndPage"];
									?>
								<?if($oldstart!=$start):?><span class="tochka">...</span><?endif;?>
								<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

									<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
										<b><?=$arResult["nStartPage"]?></b>
									<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
										<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
									<?else:?>
										<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
									<?endif?>
									<?$arResult["nStartPage"]++?>
								<?endwhile?>
								<?if($oldend!=$end):?>...<?endif;?>
								<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
									<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_end")?></a>
							        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_next")?></a>        
								<?else:?>
								<?endif?>

							<?endif?>

							<?if ($arResult["bShowAll"]):?>

								<?if ($arResult["NavShowAll"]):?>
									|&nbsp;<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></a>
								<?else:?>
									|&nbsp;&nbsp;<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></a>
								<?endif?>

							<?endif?>
							</div>
<? else: ?>
						<div class="show_block">

						<?$showCount = 1;?>

						<?if($arResult["bDescPageNumbering"] === true):?>

						    <?=$arResult["NavFirstRecordShow"]?> - <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>&nbsp;&nbsp;|&nbsp;    
						    
							<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
								<?if($arResult["bSavePage"]):?>
						            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
									<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_begin")?></a>
								<?else:?>
									<?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
										<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
									<?else:?>
										<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
									<?endif?>
						            <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a> 
								<?endif?>
							<?else:?>
							<?endif?>

							<?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
								<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

								<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
									<span class="select"><span><?=$NavRecordGroupPrint?></span></span>
								<?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
									<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
								<?else:?>
									<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
								<?endif?>

								<?$arResult["nStartPage"]--?>
							<?endwhile?>

							

							<?if ($arResult["NavPageNomer"] > 1):?>
								<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_end")?></a>
						        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a>
							<?else:?>
							<?endif?>

						<?else:?>


						    <?=$arResult["NavFirstRecordShow"]?> - <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>&nbsp;&nbsp;|&nbsp;    
						    
							<?if ($arResult["NavPageNomer"] > 1):?>

								<?if($arResult["bSavePage"]):?>
						            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
						            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_begin")?></a>
								<?else:?>
									<?if ($arResult["NavPageNomer"] > 2):?>
										<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?></a>
									<?else:?>
										<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
									<?endif?>
									<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a>
								<?endif?>

							<?else:?>
							<?endif?>

							<?$start = $arResult["NavPageNomer"]-$showCount;?>
							<?$end = $arResult["NavPageNomer"]+$showCount;?>
							<?$oldstart = $arResult["nStartPage"]?>
							<?
							if($start>$arResult["nStartPage"])
								$arResult["nStartPage"] = $start;
							else
								$start = $arResult["nStartPage"];
							?>
							<?$oldend = $arResult["nEndPage"]?>
							<?
							if($arResult["nEndPage"]>$end)
								$arResult["nEndPage"] = $end;
							else
								$end = $arResult["nEndPage"];
								?>
							<?if($oldstart!=$start):?><span class="tochka">...</span><?endif;?>
							<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

								<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
									<b><?=$arResult["nStartPage"]?></b>
								<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
									<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
								<?else:?>
									<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
								<?endif?>
								<?$arResult["nStartPage"]++?>
							<?endwhile?>
							<?if($oldend!=$end):?>...<?endif;?>
							<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
								<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_end")?></a>
						        <i title="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_next")?></i>        
							<?else:?>
							<?endif?>

						<?endif?>

						<?if ($arResult["bShowAll"]):?>

							<?if ($arResult["NavShowAll"]):?>
								|&nbsp;<i title="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0"><?=GetMessage("nav_paged")?></i>
							<?else:?>
								|&nbsp;&nbsp;<i title="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_all")?></i>
							<?endif?>

						<?endif?>
						</div>

<? endif; ?>



<!--/noindex-->