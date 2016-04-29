<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="catalogFilter">
    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose.php',array("arChoose"=>array(
        "0"=>array("NAME"=>"цена", "CODE"=>'PROPERTY_PRICE'),
        "1"=>array("NAME"=>"новизна", "CODE" => "PROPERTY_NEW"),
        "2"=>array("NAME"=>"наличие", "CODE" => "SORT"),
        "3"=>array("NAME"=>"рейтинг", "CODE" => "PROPERTY_RATING"),
        "4"=>array("NAME"=>"популярность", "CODE" => "PROPERTY_SALES_RATING"),
    )));?>
    
    <?=$arResult["NAV_STRING"]?>
    <div class="clear"></div>
</div>

<?foreach($arResult["ROWS"] as $arRow):?>
    <?foreach($arRow as $arElement):?>
	
		<?//print_R($arElement["ID"]);?>
        <?if (intval($arElement["ID"])==0) continue;?>
        <div class="itemMain">
            <div class="itemAbsl">
                <div class="podlogka">
                    <div class="cn tl deactive"></div>
                    <div class="cn tr deactive"></div>
                    <div class="content deborder"><div class="content deborder"><div class="content"> <div class="clear"></div>
					
								<?if(isset($arElement["PREVIEW_PICTURE"]["SRC"]) && count($arElement["PREVIEW_PICTURE"])>0):?>
								<?//print_R($arElement["PREVIEW_PICTURE"]["ID"]);?>
								<div class="rel">
								
                                <div class="img"><a href="<?=$arElement['DETAIL_PAGE_URL']?>">
								<?=ShowImage($arElement["PREVIEW_PICTURE"]["ID"],160,160)?>
								</a></div>
                                <?if($arElement["PROPERTIES"]["MODEL_3D"]["VALUE"]!=''):?>
                                    <a class="ttp_lnk" onclick="window.open('/view360.php?idt=<?=$arElement["ID"]?>', 'wind1','width=900, height=600, resizable=no, scrollbars=yes, menubar=no')" href="javascript:" title="Подробная 3D - Модель"><i class="img360"></i></a>
                                <?endif;?>
								</div>
								<?endif;?>
                                <div class="head">
                                    <div class="headname">
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
									<?=substr($arElement["NAME"],0,55);?><?if(strlen($arElement["NAME"])>55):?>...<?endif?>
									</a>
									</div>
									<div class="clear"></div>
                                    <div class="reating"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arElement["PROPERTIES"]['RATING']["VALUE"]), array("MODE"=>"html") );?></div>
									<a href="<?=$arElement["DETAIL_PAGE_URL"]?><?if($arElement["COUNT_REPORTS"]==0):?>#comment<?else:?>#reports<?endif;?>" class="comment grey"><?if($arElement["COUNT_REPORTS"]>0):?><?=$arElement["COUNT_REPORTS"]?> <?endif;?><?=RevirewsLang(intval($arElement["COUNT_REPORTS"]),true)?></a>
                                    <div class="clear"></div>
                                </div>
								<?//print_R($arElement["PROPERTIES"]);?>
                                <div class="mainText showTime" id="feature<?=$arElement["ID"]?>">
                                    <?=TextCut(strip_tags($arElement["PREVIEW_TEXT"]), 120)?>
                                </div>
                                <div class="hoHide">
                                    <div class="feature feature<?=$arElement["ID"]?>">
                                        <div class="name">Характеристики:</div>
                                        <?
											//print_R($arElement["PROPERTIES"]);
											//print_R($arElement["UF_HARACTERISTICS"]);
                                            foreach($arElement["PROPERTIES"] as $arProperty)
                                            {
												//echo $arProperty["ID"]." ".$arProperty["VALUE"]."<br>";
                                                if (in_array($arProperty["ID"], $arResult["UF_HARACTERISTICS"]))
                                                {
													if($arProperty["VALUE"]["TYPE"]=="HTML"){
														echo '- '.$arProperty["NAME"].': ';
														echo $arProperty["~VALUE"]["TEXT"]."<br />";
													}
													elseif($arProperty["VALUE"]["TYPE"]=="TEXT"){
														echo '- '.$arProperty["NAME"].': ';
														echo "<pre>".$arProperty["VALUE"]["TEXT"]."</pre>";
													}
													else{

														if(is_array($arProperty["VALUE"]))
															$arProperty["VALUE"] = implode(", ",$arProperty["VALUE"]);
														if(!empty($arProperty["VALUE"]))
														echo '- '.$arProperty["NAME"].': '.$arProperty["VALUE"].'<br />';
													}
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
                                                    <div class="oldPrice">
													
													<?=number_format($arElement["PROPERTIES"]["OLD_PRICE"]["VALUE"], 0, ',', ' ')?>р
													
													</div>
                                                <?else:?>
                                                    &nbsp;
                                                <?endif?>
                                            </td>

                                            <td>
                                                <div class="price newPrice">
												<?if(!empty($arElement["PROPERTIES"]["PRICE"]["VALUE"])):?>
												от <?=number_format($arElement["PROPERTIES"]["PRICE"]["VALUE"], 0, ',', ' ')?>р
												<?else:?>
												&nbsp;
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
												<?if($arElement["COUNT_SKLAD"]==0):?>
												<div class="add-to-basket-none"></div>
												<?else:?>
												 <a class="add-to-basket" href="/select-color-and-size.php?id=<?=$arElement["ID"]?>"></a>
												<?endif;?>
                                               
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="clear"></div>
                                </div>

                            </div></div></div>
                    <div class="cn bl deactive"></div>
                    <div class="cn br deactive"></div>
                </div>
            </div>
        </div>
    <?endforeach?>
    <div class="clear"></div>
<?endforeach?>
<div class="clear"></div>
<div style="margin-top:60px"></div>   
<div class="catalogFilter">
    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/catalog/choose.php',array("arChoose"=>array(
        "0"=>array("NAME"=>"цена", "CODE"=>'PROPERTY_PRICE'),
        "1"=>array("NAME"=>"новизна", "CODE" => "PROPERTY_NEW"),
        "2"=>array("NAME"=>"наличие", "CODE" => "SORT"),
        "3"=>array("NAME"=>"рейтинг", "CODE" => "PROPERTY_RAITING"),
        "4"=>array("NAME"=>"популярность", "CODE" => "PROPERTY_SALES"),
    )));?>
    
    <?=$arResult["NAV_STRING"]?>
    <div class="clear"></div>
	<br>
	<?echo $arResult["DESCRIPTION"];?>
</div>