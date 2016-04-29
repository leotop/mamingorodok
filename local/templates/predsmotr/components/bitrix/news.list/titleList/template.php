<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="goods">
<div class="item_list nomargin">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?if(count($arResult["ITEMS"])>0):?>
    <?$j=0;?>
	<?foreach($arResult["ITEMS"] as $key=>$arElement):?>
	
			<?if(strlen($arElement["NAME"])>0):?>
		        <div class="itemMain">
            <div class="itemAbsl">
                <div class="podlogka">
                    <div class="cn tl deactive"></div>
                    <div class="cn tr deactive"></div>
                    <div class="content deborder"><div class="content deborder"><div class="content"> <div class="clear"></div>

								<?if(isset($arElement["PREVIEW_PICTURE"]["SRC"]) && count($arElement["PREVIEW_PICTURE"])>0):?>
                                <div class="img"><a href="<?=$arElement['DETAIL_PAGE_URL']?>">
								<?=ShowImage($arElement["PREVIEW_PICTURE"]["SRC"],160,160);?>
								</a></div>
                                <?if($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"]!=''):?>
                                    <a class="ttp_lnk" onclick="window.open('/view360.php?idt=<?=$arElement["ID"]?>', 'wind1','width=900, height=600, resizable=no, scrollbars=yes, menubar=no')" href="javascript:" title="Подробная 3D - Модель"><i class="img360"></i></a>
                                <?endif;?>
								<?endif;?>
                                <div class="head">
									<?//=strlen($arElement["NAME"])?>
                                    <a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=substr($arElement["NAME"],0,45)?><?if(strlen($arElement["NAME"])>45):?>...<?endif?></a>
                                </div>
								<div class="head">
									<div class="clear"></div>
                                    <div class="reating"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html") );?></div>
									<a href="<?=$tovar["DETAIL_PAGE_URL"]?><?if($arElement["COUNT_REPORTS"]==0):?>#comment<?else:?>#reports<?endif;?>" <?if($arElement["COUNT_REPORTS"]==0):?>style="margin-left: 0px;"<?endif;?> class="comment grey"><?if($arElement["COUNT_REPORTS"]>0):?><?=$arElement["COUNT_REPORTS"]?> <?endif;?><?=RevirewsLang(intval($arElement["COUNT_REPORTS"]),true)?></a>
								</div>

                                <div class="mainText showTime" id="feature<?=$arElement["ID"]?>">
                                    <?=TextCut($arElement["PREVIEW_TEXT"], 50)?>
                                </div>
                                <div class="hoHide">
                                    <div class="feature feature<?=$arElement["ID"]?>">
                                        <div class="name">Характеристики:</div>
                                        <?
											//print_R($arElement);
                                            foreach($arElement["PROPERTIES"] as $arProperty)
                                            {
                                                 if (in_array($arProperty["ID"], $arElement["UF_HARACTERISTICS"])){
													if(is_array($arProperty["VALUE"]))
														$arProperty["VALUE"] = implode(", ", $arProperty["VALUE"]);
													if(!empty($arProperty["VALUE"]))
                                                    echo '- '.$arProperty["NAME"].': '.$arProperty["VALUE"].'<br />';
                                                }
                                            }
                                            
                                            
                                        ?>
                                        <?//echo "<pre>"; var_dump($arElement["PROPERTIES"]); echo "</pre>";?>
                                    </div>
                                    <div class="clear"></div>
                                    <table  class="price_table">
                                        <tr>
                                            <td>
                                                <?if ($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"] > 0):?>
                                                    <div class="oldPrice"><?=$arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"]?> руб.</div>
                                                <?else:?>
                                                    &nbsp;
                                                <?endif?>
                                            </td>

                                            <td>
                                                <div class="price newPrice">
												<?if(!empty($arElement["PROPERTIES"]["PRICE"]["VALUE"])):?>
													<?=$arElement["PROPERTIES"]["PRICE"]["VALUE"]?> руб.
												<?endif?>
												</div>
                                            </td>
                                        </tr>    
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="add-to-compare-list-ajax" value="<?=$arElement["ID"]?>" />
                                                <a href="/catalog/compare/" class="grey compare_link">Сравнить</a>
                                            </td>

                                            <td>
                                                <a class="add-to-basket" href="/select-color-and-size.php?id=<?=$arElement["ID"]?>"></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div></div></div>
                    <div class="cn bl deactive"></div>
                    <div class="cn br deactive"></div>
                </div>
            </div>
        </div>
        <?$first = false;?>
		<?$j++;?>
		<?if($j == 3):?><div class="clear"></div><?$j=0;?><?endif;?>
		<?endif;?>
    <?endforeach;?>
    
  <?else:?> 
	Ничего не найдено.
<?endif?>  
    <div class="clear"></div>
	<div class="top15"></div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
</div>
