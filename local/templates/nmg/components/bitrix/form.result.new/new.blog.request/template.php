<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
$arReplace = array('<p>', '</p>');
$arResult["FORM_ERRORS_TEXT"] = str_replace($arReplace, '', $arResult["FORM_ERRORS_TEXT"]);
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=str_replace('font', 'div', $arResult["FORM_ERRORS_TEXT"]);?><?endif;?>

<?if(strlen($arResult["FORM_NOTE"]) > 0):?>
    <div class="oktext"><?=$arResult["FORM_NOTE"]?></div>
    <?return true;?>
<?endif?>

<div class="form jqtransform-cover">
        <div class="title"><?=$arResult["FORM_TITLE"]?></div>

        <?=$arResult["FORM_HEADER"]?>
        <?
        foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
        {
        ?>
                <?if ($FIELD_SID == "PRODUCT_ID"): // вставляем id продукта ?>
                    <?$arQuestion["HTML_CODE"] = str_replace("text", "hidden", $arQuestion["HTML_CODE"])?>
                    <?
                        if ($_REQUEST["PRODUCT_ID"] > 0)
                        {
                            // получаем имя товара и списываем его в поле формы
                            CModule::IncludeModule('iblock');
                            $dbEl = CIBlockElement::GetList(Array(), Array("ID"=>$_REQUEST["PRODUCT_ID"], "ACTIVE"=>"Y"), false, false, array("ID", "IBLOCK_ID", "NAME"));    
                            if($obEl = $dbEl->GetNext())    
                            {           
                                $product_name = '[id = '.$obEl["ID"].'] '.$obEl["NAME"];
                            }    
                        }
                    ?>
                    <?=str_replace("#PRODUCT_ID#", $product_name, $arQuestion["HTML_CODE"])?>
                    <?continue;?>
                <?endif?>

                <div class="question">
                    <?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
                </div>
                <div class="answer">    
                    <?=$arQuestion["HTML_CODE"]?>
                </div>
                <div class="clear"></div>
        <? 
        } //endwhile 
        ?>
        
        <?
        if($arResult["isUseCaptcha"] == "Y")
        {
        ?>
            <div class="question">
                <div class="answer"><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></div>
            </div>
            <div class="answer">            
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" />
                <div class="answer">
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($arResult["CAPTCHACode"]);?>" width="180" height="40" />
                </div>
                <div class="answer">
                    <?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?>            
                </div>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" />
            </div>
            <div class="clear"></div>
			<br>
        <?
        } // isUseCaptcha
        ?>
        <div class="button-line">
            <input class="blue" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"];?>" />
            <input type="hidden" name="web_form_submit" value="Y" />
        </div>
        <br />
        <?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
        <?=$arResult["FORM_FOOTER"]?>
</div>
