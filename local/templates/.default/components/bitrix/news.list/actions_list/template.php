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
//arshow($arResult);
?>  
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    //arshow($arItem);
    ?>
    <div class="action_prev">
        <div class="img_container">
            <?if($arItem["PROPERTIES"]["PREVIEW"]["VALUE"]){?>
            <img class="prev_pict" src="<?=CFile::GetPath($arItem["PROPERTIES"]["PREVIEW"]["VALUE"])?>">
            <?}?>
        </div>
        <?if(($arItem["DISPLAY_ACTIVE_FROM"]) && ($arItem["DATE_ACTIVE_TO"])){?>
           <div class="date_contain">
            <span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?>-</span>
            <span class="news-date-time"><?echo $arItem["DATE_ACTIVE_TO"]?></span>
           </div> 
        <?}?>
             
         
        
        <div class="text_contain">
            <div class="action_head">
		        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                    <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
                    <?else:?>
                        <b><?echo $arItem["NAME"]?></b><br />
                    <?endif;?>
                <?endif;?>
            </div>
		   
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>
		
		<a class="detail_action" href="<?=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a>
        </div>
    
    </div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?//=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
