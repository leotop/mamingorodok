<?//print_R($arResult["ITEMS"]);?>

<?if (!empty($arResult["ITEMS"])):?>
<div class="goods">
    <h2>Похожие товары</h2>
    <?if (count($arResult["ITEMS"]) > 6):?>
        <div class="like-items-prev"></div>
        <div class="like-items-next"></div>
    <?endif?>
    <div class="item_list like-items">
        <?if (count($arResult["ITEMS"]) > 4):?>
            <ul>
                <?foreach($arResult["ITEMS"] as $arLikeItem):?>
                    <li>
                        <div class="item<?if($lkey == 0):?> first<?endif?><?if($lkey == 3):?> last<?endif?>">
                            <div class="align_center_to_left">
                                <div class="align_center_to_right"><a href="<?=$arLikeItem["DETAIL_PAGE_URL"]?>" class="Pic"><img width="96" height="96" title="" alt="" src="<?=$arLikeItem["PREVIEW_PICTURE"]["SRC"]?>"></a></div> 
                                <div class="align_center_to_right">
                                    <div class="Raiting">
                                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arLikeItem["PROPERTIES"]["RATING"]["VALUE"]), array("MODE"=>"html") );?>
                                    </div>
                                </div>
                                <div class="align_center_to_right"><a href="<?=$arLikeItem["DETAIL_PAGE_URL"]?>" class="Name"><?=$arLikeItem["NAME"]?></a></div>
                                <div class="align_center_to_right"><div class="Price"><span class="Currency">от</span> <?=$arLikeItem["PROPERTIES"]["PRICE"]["VALUE"]?> <span class="Currency">р</span></div></div>
                            </div>
                        </div>
                    </li>
                <?endforeach?>        
            </ul>
        <?else:?>
            <?foreach($arResult["ITEMS"] as $arLikeItem):?>
                <div class="item<?if($lkey == 0):?> first<?endif?><?if($lkey == 3):?> last<?endif?>">
                    <div class="align_center_to_left">
                        <div class="align_center_to_right"><a href="<?=$arLikeItem["DETAIL_PAGE_URL"]?>" class="Pic"><img width="96" height="96" title="" alt="" src="<?=$arLikeItem["PREVIEW_PICTURE"]["SRC"]?>"></a></div> 
                        <div class="align_center_to_right">
                            <div class="Raiting">
                                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$arLikeItem["PROPERTIES"]["RATING"]["VALUE"]), array("MODE"=>"html") );?>
                            </div>
                        </div>
                        <div class="align_center_to_right"><a href="<?=$arLikeItem["DETAIL_PAGE_URL"]?>" class="Name"><?=$arLikeItem["NAME"]?></a></div>
                        <div class="align_center_to_right"><div class="Price"><span class="Currency">от</span> <?=$arLikeItem["PROPERTIES"]["PRICE"]["VALUE"]?> <span class="Currency">р</span></div></div>
                    </div>
                </div>
                <?if($lkey == 3) break;?>
            <?endforeach?>
        <?endif?>
    </div>
</div>
<?endif?>

<script>
    $('.like-items').jCarouselLite({
        btnPrev: '.like-items-prev', 
        btnNext: '.like-items-next', 
        mouseWheel: true, 
        visible: 4});
</script>