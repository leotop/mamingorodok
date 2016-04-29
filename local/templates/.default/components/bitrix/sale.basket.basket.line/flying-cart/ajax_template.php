<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

    $this->IncludeLangFile('template.php');

    $cartId = $arParams['cartId'];

    require(realpath(dirname(__FILE__)).'/top_template.php');

    if ($arParams["SHOW_PRODUCTS"] == "Y" /*&& $arResult['NUM_PRODUCTS'] > 0*/):?>
    <div class="bx_item_listincart<?
            $topNumber = 3;
            if ($arParams['SHOW_TOTAL_PRICE'] == 'N')
                $topNumber--;
            if ($arParams['SHOW_PERSONAL_LINK'] == 'N')
                $topNumber--;
            if ($topNumber < 3)
                echo " top$topNumber"?>">
        <?/*
            <?if ($arParams["POSITION_FIXED"] == "Y"):?>
            <div id="<?=$cartId?>status" class="status" onclick="<?=$cartId?>.toggleOpenCloseCart()"><?=GetMessage("TSB1_EXPAND")?></div>
            <?endif?>

        <div id="<?=$cartId?>products" class="bx_itemlist_container">   */?>
        
        <?foreach ($arResult["CATEGORIES"] as $category => $items):
                if (empty($items))
                    continue;
            ?>
            <?/*			<div class="bx_item_status"><?=GetMessage("TSB1_$category")?></div>   */?>
            <?foreach ($items as $v):?>
            <?if($v["DELAY"] == "N"){?>
                <? $countItems = $countItems + $v["QUANTITY"];?>
            <?}?>
                <?/*	<div class="bx_itemincart">
                    <div class="bx_item_delete" onclick="<?=$cartId?>.removeItemFromCart(<?=$v['ID']?>)" title="<?=GetMessage("TSB1_DELETE")?>"></div>
                    <?if ($arParams["SHOW_IMAGE"] == "Y"):?>
                    <div class="bx_item_img_container">
                    <?if ($v["PICTURE_SRC"]):?>
                    <?if($v["DETAIL_PAGE_URL"]):?>
                    <a href="<?=$v["DETAIL_PAGE_URL"]?>"><img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>"></a>
                    <?else:?>
                    <img src="<?=$v["PICTURE_SRC"]?>" alt="<?=$v["NAME"]?>" />
                    <?endif?>
                    <?endif?>
                    </div>
                    <?endif?>
                    <div class="bx_item_title">
                    <?if ($v["DETAIL_PAGE_URL"]):?>
                    <a href="<?=$v["DETAIL_PAGE_URL"]?>"><?=$v["NAME"]?></a>
                    <?else:?>
                    <?=$v["NAME"]?>
                    <?endif?>
                    </div>
                    <?if (true):/*$category != "SUBSCRIBE") TODO ?>
                    <?if ($arParams["SHOW_PRICE"] == "Y"):?>
                    <div class="bx_item_price">
                    <strong><?=$v["PRICE_FMT"]?></strong>
                    <?if ($v["FULL_PRICE"] != $v["PRICE_FMT"]):?>
                    <span class="bx_item_oldprice"><?=$v["FULL_PRICE"]?></span>
                    <?endif?>
                    </div>
                    <?endif?>
                    <?if ($arParams["SHOW_SUMMARY"] == "Y"):?>
                    <div class="bx_item_col_summ">
                    <strong><?=$v["QUANTITY"]?></strong> <?=$v["MEASURE_NAME"]?> <?=GetMessage("TSB1_SUM")?>
                    <strong><?=$v["SUM"]?></strong>
                    </div>
                    <?endif?>
                    <?endif?>
                </div>  */?>
                <?endforeach?>
            <?endforeach?>
        <?/*</div>  */?>

        <?/*if($arParams["PATH_TO_ORDER"] && $arResult["CATEGORIES"]["READY"]):?>
            <div class="bx_button_container">
            <a href="<?=$arParams["PATH_TO_ORDER"]?>" class="bx_bt_button_type_2 bx_medium">
            <div>Моя корзина: <?=$countItems?></div>
            </a>
            </div>
        <?endif*/?>

        <a href="<?=$arParams["PATH_TO_ORDER"]?>" >
            <div class="basketIcon"> <span class="basketQuant"><? if($countItems=="") { echo 0;} else { echo $countItems;}?></span></div>
        </a>

    </div>
    <?endif?>
<?
    if ($USER->IsAuthorized()){
        //Получаем список отложенных товаров
        $arResult["WISHLIST"] = array();

        $rsI = CIBlockElement::GetList(Array("ID" => "DESC"), array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => 8,
            "PROPERTY_DELETED" => false,
            "PROPERTY_USER_ID" => $USER -> GetID()
            ), false, false, array(
                "ID",
                "IBLOCK_ID", "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS",
                "PROPERTY_PRODUCT_ID.DETAIL_PAGE_URL",
                "PROPERTY_PRODUCT_ID.NAME",
                "PROPERTY_PRODUCT_ID.PREVIEW_PICTURE"
        ));
        while($arI = $rsI->GetNext())
            $arResult["WISHLIST"][$arI["PROPERTY_PRODUCT_ID_VALUE"]] = $arI;
    }
?>
<div class="flying-wish-list <? if (empty($arResult["WISHLIST"])) { echo "hide";}?>">
    <a href="/personal/products/wishlist/" >
        <div class="wishIcon"> <span class="wishQuant"><? if(count($arResult["WISHLIST"])=="") { echo 0;} else { echo count($arResult["WISHLIST"]);}?></span></div>
    </a>
</div>

<div class="flying-compare-list <? if (empty($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])) { echo "hide";}?>">
    <a href="/catalog/compare/" > 
        <div class="compareIcon"> <span class="compareQuant"><? if(count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"])=="") { echo 0;} else { echo count($_SESSION["CATALOG_COMPARE_LIST"][CATALOG_IBLOCK_ID]["ITEMS"]);}?></span></div>
    </a>
</div>