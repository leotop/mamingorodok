<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["CALLING"]=="YES"):?>
    <h2>Спасибо, ожидайте звонка.</h2>
    <?else:?>
    <?if(!empty($arResult["ERROR"])):?>
        <div class="notetext"><?=$arResult["ERROR"]?></div>
        <?endif;?>
<h2>Бесплатный звонок</h2>
<form action="" id="callfreeform" class="jqtransform">
    <table>
        <tr>
            <td colspan="2">
                Введите свой номер и вас бесплатно соединят:
                <div class="top15"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><span style="float:left; position:relative; top:7px;">+7 (</span><input type="text" value="" style="width:50px" name="number1"><span style="float:left;  position:relative; top:7px;">)&nbsp;&nbsp;&nbsp;</span><input type="text" value="" style="width:200px" name="number2">
                <div class="clear"></div>
                <div class="top15"></div>
            </td>
        </tr>
        <tr>
            <td style="width:93px">
                <img src="http://universe.uiscom.ru/centrex/callme/get_captcha_image/?key=<?=$arResult["KEY"]?>">
                <input type="hidden" value="<?=$arResult["KEY"]?>" name="capcha_key">
            </td>
            <td>
                <input type="text" style="width:200px" name="capcha_word" value="">
                <div class="clear"></div>
                <div class="top15"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Звонить" id="callfree"></td>
        </tr>
    </table>
	</form>
<?endif;?>