<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixComponent $component */
    $this->setFrameMode(true);

    /*function formatItem($arI, $arResult)
    {
    ?>
    <div class="sk-menu-offer-item">
    <?if($arI["PREVIEW_PICTURE"]) {
    if($arResult["ITEM2ACTION"][$arI["ID"]])
    {
    $arAction = $arResult["ACTIONS"][$arResult["ITEM2ACTION"][$arI["ID"]]];
    $isSpecOffer = $arAction["PROPERTY_SPECOFFER_ENUM_ID"]>0;

    if($isSpecOffer)
    {?>
    <div class="wrap-specialoffert">
    <a href="<?=$arI['DETAIL_PAGE_URL']?>" title="Спецпредложение!" class="btt-specialoffert">Спецпредложение!</a></div><?
    }?>
    <div class="prize"><?
    if(!$isSpecOffer)
    {?>
    <a href="#" target="_blank"><div class="gift_bg"></div></a><?
    }?>
    <div class="gift_info ">
    <div class="gift_info_text">
    <div style="text-align: center;">Акция!</div> <?=$arAction["PREVIEW_TEXT"]?>
    </div><div class="gift_info_bg"></div></div></div><?
    }
    ?>
    <a href="<?=$arI["DETAIL_PAGE_URL"]?>" title="<?=$arI['~NAME']?>"><div class="photo"><p><?=ShowImage($arI["PREVIEW_PICTURE"], 160, 160)?><span>&nbsp;</span></p></div></a><?
    } ?>
    <div class="link"><a href="<?=$arI["DETAIL_PAGE_URL"]?>" title="<?=$arI['~NAME']?>"><?=smart_trim($arI['NAME'], 50)?></a></div>
    <span class="s_like"><?=str_replace("р", ' <span class="rub">&#101;</span>', CurrencyFormat($arI["PROPERTY_PRICE_VALUE"], "RUB"))?></span><?
    if($arI["PROPERTY_OLD_PRICE_VALUE"]>0)
    {?>
    <i><?=CurrencyFormat($arI["PROPERTY_OLD_PRICE_VALUE"], "RUB")?></i><?
    }
    ?>
    </div><?
    }*/ 

    function isNumeric($strChar) {
        $intOrd = ord($strChar);
        if($intOrd >= 48 && $intOrd <= 57)
            return true;
        else return false;
    }

    $strBrandHtml = '';
    $strNumeric = '';
    $isEnglish = true; 

    foreach($arResult["PRODUCERS"] as $arProd) {
        $strLetter = ToUpper(substr($arProd["NAME"], 0, 1));
        if(isNumeric($strLetter))
            $strLetter = '123';

        if($strLetter != $strLastLetter) {
            $strLastLetter = $strLetter;
            if(!empty($strBrandHtml)) $strBrandHtml .= '</ul></li>';

            if(ord($strLetter) >= 192 && $isEnglish) {
                $isEnglish = false;
                $strBrandHtml .= '<li class="sk-menu-abc-devider"> | </li>';
            }

            if($strLetter == '123')
                $strNumeric .= '<li class="sk-menu-abc-devider"> | </li><li><a href="#">'.$strLetter.'</a><ul class="sk-menu-abc-sub">';
            else $strBrandHtml .= '<li><a href="#">'.$strLetter.'</a><ul class="sk-menu-abc-sub">';
        }

        if($strLetter == '123')
            $strNumeric .= '<li><a href="/catalog/filter/proizvoditel-'.$arProd["CODE"].'/">'.$arProd["NAME"].'</a></li>';
        else $strBrandHtml .= '<li><a href="/catalog/filter/proizvoditel-'.$arProd["CODE"].'/">'.$arProd["NAME"].'</a></li>';
    }

    if(!empty($strBrandHtml)) {
        $strBrandHtml .= '</ul>';
        if(!empty($strNumeric)) $strNumeric .= '</ul>';?>
    <div class="wrap-sk-menu-abc">
        <ul class="sk-menu-abc">
            <li>Бренды:</li>
            <?=$strBrandHtml.$strNumeric?>
        </ul>
    </div><?
    }
?>

<?//arshow($arResult["PRODUCERS"])?>


<!-- New menu-->
<div class="sk-menu">
    <ul class="sk-menu_main"><?
            foreach($arResult["SECTIONS"] as $arSec) {
            ?>
            <li<?=(strlen($arSec["TITLE"]) < 13 ? ' class="sk-menu-oneline"' : '')?> data-for="topSec<?= $arSec["ID"] ?>">
                <a href="<?= $arSec["SECTION_PAGE_URL"] ?>" title="<?= $arSec["NAME"] ?>"><?=$arSec["TITLE"]?></a></li><?
        } ?>
        <li class="sk-menu-oneline sk-menu-brand" data-for="brand"><a href="#" title="">Бренды</a></li>
    </ul>


    <div class="sk-menu-dropdown"><?
            foreach($arResult["SECTIONS"] as $arSec) {
                $intRootSectionID = $arSec["ID"]; ?>
            <div class="sk-menu-dropdown--item" data-name="topSec<?= $arSec["ID"] ?>" style="display: none;">
                <table>
                    <tr>
                        <td>
                            <div class="sk-menu-dropdown--head"><?=$arSec["NAME"]?></div>
                            <ul class="sk-menu_sub"><?
                                    foreach($arSec["SUBSECTIONS"] as $arSubSec) {
                                    ?>
                                    <li><a href="<?= $arSubSec["SECTION_PAGE_URL"] ?>" title="<?=$arSubSec["NAME"]?>"><?=$arSubSec["NAME"]?></a>
                                    </li><?
                                }?>
                            </ul>
                        </td><?
                            $strProducers = '';

                            foreach($arResult["SECTION_TO_PRODUCER"][$intRootSectionID] as $intProdID)
                            {   
                                $arProd = $arResult["PRODUCERS"][$intProdID];
                                if ($arProd) {
                                    $strProducers .= '<li><a href="/catalog/'.$arSec["CODE"].'/filter/proizvoditel-'.$arProd["CODE"].'/" title="'.$arProd["NAME"].'">'.$arProd["NAME"].'</a></li>';
                                }
                            }

                            if(strlen($strProducers)>0)
                            { ?>
                            <td>
                                <div class="sk-menu-dropdown--head">Популярные бренды</div>
                                <ul class="sk-menu_sub"><?=$strProducers?></ul>
                            </td><?
                            }

                            /*if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_BEST"]])
                            {?>
                            <td>
                            <div class="sk-menu-offer-head">Самый лучший</div>
                            <?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_BEST"]], $arResult)?>
                            </td><?
                            }*/

                            /*if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_POPULAR"]])
                            { ?>
                            <td>
                            <div class="sk-menu-offer-head">Самый популярный</div>
                            <?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_POPULAR"]], $arResult)?>
                            </td><?
                            }*/

                            /*if($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_RECOMMEND"]])
                            { ?>
                            <td>
                            <div class="sk-menu-offer-head">Мы рекомендуем</div>
                            <?=formatItem($arResult["PRODUCTS"][$arSec["DATA"]["UF_ITEM_RECOMMEND"]], $arResult)?>
                            </td><?
                        } */?>
                    </tr>
                </table>
            </div><?
            }

            $intColCnt = 7;
            $intItemsPerCol = ceil((count($arResult["PRODUCERS"]) + 15) / 6);
        ?>
        <div class="sk-menu-dropdown--item" data-name="brand" style="display: none;">
            <div class="sk-menu-dropdown--head sk-menu-dropdown--head_brand">Бренды по алфавиту</div>
            <table class="sk-menu-brandlist">
                <tr>
                    <td><?  
                            $strLastLetter = '';
                            $intCurrentCnt = 0;
                            foreach($arResult["PRODUCERS"] as $arProd) {
                                $strLetter = ToUpper(substr($arProd["NAME"], 0, 1));
                                if($intCurrentCnt >= $intItemsPerCol) {
                                    echo '</td><td>';
                                    $intCurrentCnt = 0;
                                }

                                if($strLetter != $strLastLetter) {
                                    echo '<div class="sk-menu-brandlist-letter">'.$strLetter.'</div>';
                                    $intCurrentCnt++;
                                }

                                $strLastLetter = $strLetter;

                                echo '<i title="/catalog/filter/proizvoditel-'.$arProd["CODE"].'/">'.$arProd["NAME"].'</i>';

                                $intCurrentCnt++;   
                        }?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>

