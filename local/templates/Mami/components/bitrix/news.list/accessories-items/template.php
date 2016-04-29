<div class="DetailLargeRight aks" id="aks">
    <?if (!empty($arResult["ITEMS"])):?>
        <div class="goods">
            <h2>С этим товаром покупают</h2>
            <?if (count($arResult["ITEMS"]) > 6):?>
                <div class="recommended-prev"></div>
                <div class="recommended-next"></div>
            <?endif?>
            <div class="recommended">
                <?if (count($arResult["ITEMS"]) > 6): // если больше 6, то карусель  ?>
                    <ul>
                    <?foreach($arResult["ITEMS"] as $akey => $arAccItem):?>
                        <?//echo $akey?>
						<?if ($akey == 0):?>
                            <li>
                        <?endif?>
						<?//echo $akey;?>
                        <?if ($akey % 6 == 0 && $akey != 0):?>
                                <div class="clear"></div>
                            </li>
                            <li>
                        <?endif?>
                        
                                <div class="item-item<?if(($akey+1) % 2 == 0):?> last<?endif?>">
                                    <a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" class="name-name spll"><?=$arAccItem["NAME"]?></a>
                                    <div class="clear"></div>
                                    <div class="left-left">
                                    <div class="img">
                                    <a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>">
									<?=ShowImage($arAccItem["PREVIEW_PICTURE"]["ID"],100,100)?>
									</a>
                                    </div>
                                    </div>
                                    <div class="right-right">
                                        <div class="Raiting">
											<?=showRating($arAccItem["PROPERTIES"]["RATING"]["VALUE"]);?>
                                        </div>
                                        <div class="price"><span>от</span> <?=intval($arAccItem["PROPERTIES"]["PRICE"]["VALUE"])?> <span>р</span></div>
										<?if($arAccItem["BUY"]):?>
                                        <a href="/select-color-and-size.php?id=<?=$arAccItem["ID"]?>" class="add-to-basket"></a>
										<?else:?>
										<a href="#" class="add-to-basket-none" onclick="return false"></a>
										<?endif;?>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <?if($akey+1 % 2 == 0):?>
                                    <div class="clear"></div>
                                <?endif?>
                                
                            
                        
                        <?if($akey + 1 == count($arResult["ITEMS"])):?>
                            </li>
                        <?endif?>
                    <?endforeach?>        
                    </ul>
                <?else:?>
                    <?foreach($arResult["ITEMS"] as $akey => $arAccItem):?>
                        
                        <div class="item-item<?if(($akey+1) % 2 == 0):?> last<?endif?>">
                            <a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>" class="name-name spll"><?=$arAccItem["NAME"]?></a>
                            <div class="clear"></div>
                            <div class="left-left">
                            <div class="img">
                            <a href="<?=$arAccItem["DETAIL_PAGE_URL"]?>">
							<?=ShowImage($arAccItem["PREVIEW_PICTURE"]["ID"],100,100)?>
							</a>
                            </div>
                            </div>
                            <div class="right-right">
                                <div class="Raiting">
									<?=showRating($arAccItem["PROPERTIES"]["RATING"]["VALUE"]);?>
                                </div>
                                <div class="price">
								<?if($arAccItem["PROPERTIES"]["PRICE"]["VALUE"]>0):?>
								<span>&nbsp;</span> <?=$arAccItem["PROPERTIES"]["PRICE"]["VALUE"]?> <span>р</span>
								<?else:?>
								&nbsp;
								<?endif?>
								</div>
                               <?if($arAccItem["BUY"]):?>
								<a href="/select-color-and-size.php?id=<?=$arAccItem["ID"]?>" class="add-to-basket"></a>
								<?else:?>
								<a href="#" class="add-to-basket-none" onclick="return false"></a>
								<?endif;?>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <?if($akey+1 % 2 == 0):?>
                            <div class="clear"></div>
                        <?endif?>
                        
                        <?//if($akey == 7) break;?>
                    <?endforeach?>        
                <?endif?>
            </div>
        </div>
    <?endif?>
</div>
<div class="clear"></div>

<script>
	if($('.recommended ul').length>0){
    $('.recommended').jCarouselLite({
        btnPrev: '.recommended-prev', 
        btnNext: '.recommended-next', 
        mouseWheel: true, 
        visible: 1});
	}
</script>