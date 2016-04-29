<?if($arChoose):?>
<?//xvar_dump($arChoose);?>
<div class="choose">
    <?
    if (empty($_REQUEST["orderby"])) $_REQUEST["orderby"] = "";
    if (empty($_REQUEST["sort"])) $_REQUEST["sort"] = "DESC";
    ?>
    
    <?foreach($arChoose as $arItem):?> 
        <?if ($_REQUEST["orderby"] == $arItem["CODE"]):?>
            <?if ($_REQUEST["sort"] == "DESC"):?>
                <span class="active"><span><a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort=ASC', array('sort', 'orderby'))?>"><?=$arItem["NAME"]?><i class="down"></i></a></span></span>
            <?else:?>                               
                <span class="active"><span><a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort=DESC', array('sort', 'orderby'))?>"><?=$arItem["NAME"]?><i class="up"></i></a></span></span>
            <?endif?>
        <?else:?>
            <span><span><a href="<?=$APPLICATION->GetCurPageParam('orderby='.$arItem["CODE"].'&sort=DESC', array('sort', 'orderby'))?>"><?=$arItem["NAME"]?></a></span></span>
        <?endif?>
    <?endforeach?>
    <div class="clear"></div>
                           
</div>



    
<?endif;?>