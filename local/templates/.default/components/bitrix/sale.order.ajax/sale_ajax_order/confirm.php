<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$order_props = CSaleOrder::GetByID($arResult["ORDER"]["ACCOUNT_NUMBER"]);

$arDeliv = CSaleDelivery::GetByID($order_props["DELIVERY_ID"]);

$db_sales = CSaleOrderUserProps::GetList(      //вытаскиваю параметры плательщика текущего user
        array("DATE_UPDATE" => "DESC"),
        array("USER_ID" => $USER->GetID())
    )->Fetch();
   $db_sales_new = (explode(' ',$db_sales["DATE_UPDATE"]));
   if($arDeliv["ID"] == 1 and date("d.m.Y") == $db_sales_new["0"]){
        CSaleOrderUserProps::Delete($db_sales["ID"]);     // удаляем адрес текущего пользователя если заказ осуществлён через самовывоз
   }

if (!empty($arResult["ORDER"]))
{?>
                <div class="wrap_footer _top">
                    <p><?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?></p>

                    <span>В ближайшее время с Вами свяжется наш менеджер для его подтверждения.</span>
                </div>
                <?//= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>

    <?
    if (!empty($arResult["PAY_SYSTEM"]))
    {
        ?>
        <br /><br />
        <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");?>
        <div class="sum_sistem">
            <div class="ps_logo">
                <div class="pay_name">Выбранный способ оплаты</div>
                <div class="image_order">
                    <?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 160, 100, "border=0", "", false);?>
                </div>
                <div class="paysystem_name"><?=$arResult["PAY_SYSTEM"]["NAME"] ?></div>
            </div>

            <div class="bx_ordercart_order_pay">
                 <div id="sum_order" class="bx_ordercart_order_pay_right">
                    <table class="bx_ordercart_order_sum">

                        <tr>
                            <td class="custom_t1"><?=GetMessage("SALE_SUMM")?>:
                            <td class="custom_t2" id="PRICE_WITHOUT_DISCOUNT">
                            <?=SaleFormatCurrency($arPrice, $arItem["CURRENCY"])?> <div class="rub_none">руб.</div>
                            </td>
                        </tr>
                        <?if($arDeliv["ID"] == 13 or $arDeliv["ID"] == 12 or $arDeliv["ID"] == 14 or $arDeliv["ID"] == 15){?>
                        <tr>

                            <td class="fwb">Стоимость доставки до ТК:</td>
                            <td class="fwb" id="allSumDiscount"><?=SaleFormatCurrency($arDeliv["PRICE"], $arDeliv["CURRENCY"])?><div class="rub_none">руб.</div> </td>
                        </tr>
                        <?}else{?>
                        <tr>
                            <td class="fwb">Стоимость доставки:</td>
                            <td class="fwb" id="allSumDiscount"><?=SaleFormatCurrency($arDeliv["PRICE"], $arDeliv["CURRENCY"])?><div class="rub_none">руб.</div> </td>
                        </tr>
                        <?}?>
                        <tr>
                            <td class="fwb">Итого:</td>
                            <td class="fwb" id="allSum_FORMATED"><?=SaleFormatCurrency($arPrice + $arDeliv["PRICE"], $arItem["CURRENCY"])?> <div class="rub_none">руб.</div></td>
                        </tr>

                    </table>
                    <div style="clear:both;"></div>
                </div>
            </div>
            <div class="ps_logo_1">
                <div class="pay_name">Выбранный способ доставки</div>
                <div class="image_order_1">
                    <?=CFile::ShowImage($arDeliv["LOGOTIP"], 100, 100, "border=0", "", false);?>
                </div>
                <div class="paysystem_name_1"><?=$arDeliv["NAME"] ?></div>
            </div>
        </div>
            <div class="conatiner">
                На Вашу почту <a href="<?=$arResult["ORDER"]["USER_EMAIL"]?>"><?=$arResult["ORDER"]["USER_EMAIL"]?></a> отправлено письмо, содержащее информацию о заказе.
                <br><br>
                <?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
            </div>
         <div class="obratnayach_us">
             <div class="obratnayach_us_wrap_1">
                 <h2>Обратная связь</h2>
                 <p>Есть вопросы? Свяжитесь с нами удобным способом.</p>
                 <ul>
                    <li>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/personal/order/phone_1.php",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "standard.php"
                            )
                        );?>
                    </li>
                    <li>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/personal/order/phone_2.php",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "standard.php"
                            )
                        );?>
                    </li>
                    <li>
                        <?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/personal/order/email.php",
                                "AREA_FILE_SUFFIX" => "inc",
                                "AREA_FILE_RECURSIVE" => "Y",
                                "EDIT_TEMPLATE" => "standard.php"
                            )
                        );?>
                    </li>
                 </ul>
                 <a href="javascript:void(0)" onclick="jivo_api.open();">Открыть онлайн чат</a>
             </div>
             <div class="obratnayach_us_wrap_2">
                <h2>Присоединяйтесь к нам</h2>
                <script type="text/javascript" src="//vk.com/js/api/openapi.js?117"></script>

                <!-- VK Widget -->
                <div id="vk_groups"></div>
                <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 0, width: "440", height: "255", color1: 'FFFFFF', color2: '8449a4', color3: '8449a4'}, 35529174);
                </script>
            </div>
         </div>

         <div class="wrap_footer">
             <p>Спасибо за выбор нашего Интернет-магазина! С уважением, <b>Ваш Мамин Городок.</b></p>
         </div>
         <?/*?>   <table class="sale_order_full_table">
            <?
            if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
            {
                ?>
                <tr>
                    <td>
                        <?
                        if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
                        {
                            ?>
                            <script language="JavaScript">
                                window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
                            </script>
                            <?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
                            <?
                            if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
                            {
                                ?><br />
                                <?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
                                <?
                            }
                        }
                        else
                        {
                            if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
                            {
                                try
                                {
                                    include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
                                }
                                catch(\Bitrix\Main\SystemException $e)
                                {
                                    if($e->getCode() == CSalePaySystemAction::GET_PARAM_VALUE)
                                        $message = GetMessage("SOA_TEMPL_ORDER_PS_ERROR");
                                    else
                                        $message = $e->getMessage();

                                    echo '<span style="color:red;">'.$message.'</span>';
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?
            }
            ?>
        </table>     <?*/?>
        <?
    }
}
else
{
    ?>

    <table class="sale_order_full_table">
        <tr>
            <td>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ACCOUNT_NUMBER"]))?>
                <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
            </td>
        </tr>
    </table>
    <?
}
?>
