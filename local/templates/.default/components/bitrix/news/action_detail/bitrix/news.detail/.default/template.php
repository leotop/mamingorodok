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
?> 
<div class="news-detail">

    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
        <span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
        <?endif;?>
    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
        <h2 class="act_name"><?=$arResult["NAME"]?></h2>
        <?endif;?>
    <div class="action_body">
        <?echo $arResult["DETAIL_TEXT"];?>
        <img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>">     
        
        </br>
    </div>
</div>








<?
    // сортировку берем из параметров компонента
    $arSort = array(
        $arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
        $arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
    );
    // выбрать нужно id элемента, его имя и ссылку. Можно добавить любые другие поля, например PREVIEW_PICTURE или PREVIEW_TEXT
    $arSelect = array(
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
        "PROPERTY_PREVIEW"
    );
    // выбираем активные элементы из нужного инфоблока. Раскомментировав строку можно ограничить секцией
    $arFilter = array (
        "IBLOCK_ID" => $arResult["IBLOCK_ID"],
        //"SECTION_CODE" => $arParams["SECTION_CODE"],
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y",
    );
    // выбирать будем по 1 соседу с каждой стороны от текущего
    $arNavParams = array(
        "nPageSize" => 1,
        "nElementID" => $arResult["ID"],
    );
    $arItems = Array();
    $rsElement = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);
    $rsElement->SetUrlTemplates($arParams["DETAIL_URL"]);
    while($obElement = $rsElement->GetNextElement())
        $arItems[] = $obElement->GetFields();
    // возвращается от 1го до 3х элементов в зависимости от наличия соседей, обрабатываем эту ситуацию               
    if(count($arItems)==3):
        $arResult["TORIGHT"] = Array("NAME"=>$arItems[0]["NAME"], "URL"=>$arItems[0]["DETAIL_PAGE_URL"], "VALUE"=>$arItems[0]["PROPERTY_PREVIEW_VALUE"]);
        $arResult["TOLEFT"] = Array("NAME"=>$arItems[2]["NAME"], "URL"=>$arItems[2]["DETAIL_PAGE_URL"], "VALUE"=>$arItems[2]["PROPERTY_PREVIEW_VALUE"]);
        elseif(count($arItems)==2):
        if($arItems[0]["ID"]!=$arResult["ID"])
            $arResult["TORIGHT"] = Array("NAME"=>$arItems[0]["NAME"], "URL"=>$arItems[0]["DETAIL_PAGE_URL"], "VALUE"=>$arItems[0]["PROPERTY_PREVIEW_VALUE"]);
        else
            $arResult["TOLEFT"] = Array("NAME"=>$arItems[1]["NAME"], "URL"=>$arItems[1]["DETAIL_PAGE_URL"], "VALUE"=>$arItems[1]["PROPERTY_PREVIEW_VALUE"]);
        endif;
    // в $arResult["TORIGHT"] и $arResult["TOLEFT"] лежат массивы с информацией о соседних элементах
?>

<?if(is_array($arResult["TORIGHT"])):?>
    <div class="a_near">
        <div class="action_name_mod">
            <h3 class="near_action"><?=$arResult["TORIGHT"]["NAME"]?> </br> </h3>
            <a href="<?=$arResult["TORIGHT"]["URL"]?>">Предыдущая акция</a>

        </div>
        <a class="fright" id="next_page" href="<?=$arResult["TORIGHT"]["URL"]?>"><img class="toright_image" src="<?=CFile::GetPath($arResult["TORIGHT"]["VALUE"])?>"></a>
    </div>        
    <?endif?>

<?if(is_array($arResult["TOLEFT"])):?>
    <div class="a_near">
        <a class="fleft" id="previous_page" href="<?=$arResult["TOLEFT"]["URL"]?>"><img class="toleft_image" src="<?=CFile::GetPath($arResult["TOLEFT"]["VALUE"])?>"></a>
        <div class="action_name">
            <h3 class="near_action"><?=$arResult["TOLEFT"]["NAME"]?> </br> </h3>
            <a href="<?=$arResult["TOLEFT"]["URL"]?>">Следующая акция</a> 


        </div>
    </div>   
    <?endif?> 
    
    
    
