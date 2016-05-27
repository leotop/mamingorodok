<?
######################################################
# Name: energosoft.nivoslider                        #
# File: template.php                                 #
# (c) 2005-2011 Energosoft, Maksimov M.A.            #
# Dual licensed under the MIT and GPL                #
# http://energo-soft.ru/                             #
# mailto:support@energo-soft.ru                      #
######################################################

if(!empty($arResult["ITEMS"])) {
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?=showNoindex(true, true)?>
<?=$arParams["ADV_NOINDEX"]=="Y" ? "<noindex>" : ""?>
<div class="slider-wrapper theme-<?=$arParams["ES_THEME"]?>" style="width:<?=$arParams["ES_WITDH"]?>px;height:<?=$arParams["ES_HEIGHT"]?>px;">
    <div class="<?=$arParams["ES_RIBBON"]?>"></div>
    <div id="nivoslider<?=$arParams["ES_ID"]?>" class="nivoSlider" style="width:<?=$arParams["ES_WITDH"]?>px;height:<?=$arParams["ES_HEIGHT"]?>px;">
        <?foreach($arResult["ITEMS"] as $arElement):?>
            <?if(is_array($arElement["IMAGE"])):?>
                <?if($arParams["ADV_NOINDEX"]=="Y"):?>
                    <?=isset($arElement["URL"]) ? "<a href=\"".$arElement["URL"]."\" target=\"".$arElement["URL_TARGET"]."\" rel=\"nofollow\">" : ""?>
                <?else:?>
                    <?=isset($arElement["URL"]) ? "<a href=\"".$arElement["URL"]."\" target=\"".$arElement["URL_TARGET"]."\">" : ""?>
                <?endif;?>
                <?if($arParams["ES_SHOWCAPTION"]=="Y" && $arElement["TEXT"]!=""):?>
                    <img src="<?=$arElement["IMAGE"]["SRC"]?>" width="<?=$arElement["IMAGE"]["WIDTH"]?>" height="<?=$arElement["IMAGE"]["HEIGHT"]?>" border="0" title="#caption<?=$arParams["ES_ID"]."_".$arElement["ID"]?>" alt="<?=$arElement["TEXT_ALT"]?>"/>
                <?else:?>
                    <img src="<?=$arElement["IMAGE"]["SRC"]?>" width="<?=$arElement["IMAGE"]["WIDTH"]?>" height="<?=$arElement["IMAGE"]["HEIGHT"]?>" border="0" alt="<?=$arElement["TEXT_ALT"]?>"/>
                <?endif;?>
                <?=isset($arElement["URL"]) ? "</a>" : ""?>
            <?endif;?>
        <?endforeach;?>
    </div>
</div>
<?=$arParams["ADV_NOINDEX"]=="Y" ? "</noindex>" : ""?>

<?if($arParams["ES_SHOWCAPTION"]=="Y"):?>
    <?foreach($arResult["ITEMS"] as $arElement):?>
        <?if(is_array($arElement["IMAGE"]) && $arElement["TEXT"]!=""):?>
            <div id="caption<?=$arParams["ES_ID"]."_".$arElement["ID"]?>" class="nivo-html-caption"><?=$arElement["TEXT"]?></div>
        <?endif;?>
    <?endforeach;?>
<?endif;?>

<script type="text/javascript">
jQuery(window).load(function()
{
    jQuery("#nivoslider<?=$arParams["ES_ID"]?>").nivoSlider({
        effect: '<?=$arParams["ES_EFFECT"]?>',
        slices: <?=$arParams["ES_SLICES"]?>,
        boxCols: <?=$arParams["ES_BOXCOLS"]?>,
        boxRows: <?=$arParams["ES_BOXROWS"]?>,
        animSpeed: <?=$arParams["ES_ANIMSPEED"]?>,
        pauseTime: <?=$arParams["ES_PAUSETIME"]?>,
        directionNav: <?=$arParams["ES_DIRECTIONNAV"]=="Y" ? "true" : "false"?>,
        directionNavHide: <?=$arParams["ES_DIRECTIONNAVHIDE"]=="Y" ? "true" : "false"?>,
        controlNav: <?=$arParams["ES_CONTROLNAV"]=="Y" ? "true" : "false"?>,
        keyboardNav: false,
        pauseOnHover: <?=$arParams["ES_PAUSEONHOVER"]=="Y" ? "true" : "false"?>,
        captionOpacity: <?=$arParams["ES_CAPTIONOPACITY"]?>,
        prevText: '',
        nextText: ''
    });
<?if($arParams["ES_CONTROLNAV"]=="Y"):?>
    <?if($arParams["ES_CONTROLNAVALIGN"]!="center"):?>
    jQuery("#nivoslider<?=$arParams["ES_ID"]?> .nivo-controlNav").css("<?=$arParams["ES_CONTROLNAVALIGN"]?>","0px");
    <?else:?>
    var esCenter = <?=$arParams["ES_WITDH"]/2?>-(jQuery("#nivoslider<?=$arParams["ES_ID"]?> .nivo-controlNav").width()/2);
    jQuery("#nivoslider<?=$arParams["ES_ID"]?> .nivo-controlNav").css("left", esCenter + "px");
    <?endif;?>
<?endif;?>
});
</script><?=showNoindex(false, true)?><br clear="all" /><br /><br /><?
}?>