<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult["FORM_TYPE"] == "login"):?>

    <?
        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
            ShowMessage($arResult['ERROR_MESSAGE']);
    ?>

    <form method="post" target="_top" class="jqtransform former" action="<?=$arResult["AUTH_URL"]?>">
        <?if($arResult["BACKURL"] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
            <?endif?>
        <?foreach ($arResult["POST"] as $key => $value):?>
            <?if($key!="TYPE" && $key!="AUTH_FORM" && $key!="change_pwd" && $key!="USER_CHECKWORD"):?>
                <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                <?endif;?>
            <?endforeach?>   
        <table class="auth-table">
            <tr>
                <td>
                    <input type="hidden" name="AUTH_FORM" value="Y" />
                    <input type="hidden" name="TYPE" value="AUTH" />

                    <div class="clear"></div>
                    <input type="text" name="USER_LOGIN" maxlength="50" placeholder="Логин" value="<?=$arResult["USER_LOGIN"]?>" />
                    <div class="clear"></div>

                    <div class="clear"></div>
                    <input type="password" class="pass" name="USER_PASSWORD" placeholder="Пароль" maxlength="50"/>
                    <div class="clear"></div>        

                    <?if ($arResult["CAPTCHA_CODE"]):?>
                        <label><?=GetMessage("AUTH_CAPTCHA_PROMT")?>:</label>
                        <div class="clear"></div>
                        <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                        <div class="clear"></div>
                        <input type="text" name="captcha_word" maxlength="50" value="" />    
                        <div class="clear"></div>
                        <?endif?>
                    <div class="clear"></div>
                    <?    /*<div class="top15"></div>*/     ?>
                    <div class="clear"></div>
                </td>
                <td>
                    <?if($arResult["AUTH_SERVICES"]):?>

                        <label class="socservice-title"><?="Войти с помощью профилю"?>:</label>
                        <?
                            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons-basket", 
                                array(
                                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                                    "SUFFIX"=>"form",
                                ), 
                                $component, 
                                array("HIDE_ICONS"=>"Y")
                            );
                        ?>
                        <div class="clear"></div>    
                        <?endif?><br>
                    <input type="submit" name="Login" class="login" value="Войти и оформить заказ" />

                </td>
            </tr>
        </table> 


    </form>

    <?if($arResult["AUTH_SERVICES"]):?>   
        <?
            $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
                array(
                    "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                    "AUTH_URL"=>$arResult["AUTH_URL"],
                    "POST"=>$arResult["POST"],
                    "POPUP"=>"Y",
                    "SUFFIX"=>"",
                ), 
                $component, 
                array("HIDE_ICONS"=>"Y")
            );
        ?>
        <?endif?>

    <?
        //if($arResult["FORM_TYPE"] == "login")
        else:
    ?>

    <form action="<?=$arResult["AUTH_URL"]?>" class="jqtransform former">
        <div class="top15"></div>
        Вы авторизовались, как 
        <?if(!empty($arResult["USER_NAME"])):?>
            <!--a href="</?=$arResult["PROFILE_URL"]?>" title="</?=GetMessage("AUTH_PROFILE")?>"></?=$arResult["USER_NAME"]?></a-->
            <a href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_NAME"]?></a>
            <?else:?>
            <!--a href="</?=$arResult["PROFILE_URL"]?>" title="</?=GetMessage("AUTH_PROFILE")?>"></?=$arResult["USER_LOGIN"]?></a-->
            <a href="/community/profile/" title="<?=GetMessage("AUTH_PROFILE")?>"><?=$arResult["USER_NAME"]?></a>
            <?endif?>

        <?foreach ($arResult["GET"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
            <?endforeach?>
        <input type="hidden" name="logout" value="yes" />
        <a href="#" class="exit" onClick='document.getElementById("logout").submit()'><?=GetMessage("AUTH_LOGOUT_BUTTON")?></a>
    </form>
    <?endif?>