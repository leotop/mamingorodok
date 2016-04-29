<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

    if(isset($_REQUEST["frmQuickOrderSent"]))
    {
        $arErr = array();
        if(strlen(iconv('utf-8','windows-1251',$_REQUEST["qoName"]))<=2) $arErr[] = 'Не заполнено поле "Имя"';
        if(strlen(iconv('utf-8','windows-1251',$_REQUEST["qoPhone"]))<=2) $arErr[] = 'Не заполнено поле "Телефон"';
        if(!check_email($_REQUEST["qoEmail"])) $arErr[] = 'Не заполнено поле "Email"';
        //if(strlen($_REQUEST["qoComment"])<=2) $arErr[] = 'Не заполнено поле "Комментарий"';
        
        if(intval($_REQUEST["qoProduct"])>0)
        {
            CModule::IncludeModule("iblock");
            $rsOffer = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>intval($_REQUEST["qoProduct"])), false, false, array("NAME", "PROPERTY_CML2_LINK", "ID", "IBLOCK_ID"));
            if(!$arOffer = $rsOffer -> GetNext())
                $arErr[] = 'Неверно указан товар';
            else {
                $rsProduct = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>$arOffer["PROPERTY_CML2_LINK_VALUE"]), false, false, array("NAME", "PROPERTY_ARTICUL", "DETAIL_PAGE_URL"));
                $arProduct = $rsProduct -> GetNext();
            }
        } else $arErr[] = 'Неверно указан товар';

        if(count($arErr)>0) {
            echo showHtmlNote(implode("<br>", $arErr), true).'<br>';
        }
        else {
            if(!$USER -> IsAuthorized())
            {
                $def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
                if($def_group!="")
                {
                    $GROUP_ID = explode(",", $def_group);
                    $arPolicy = $USER->GetGroupPolicy($GROUP_ID);
                }
                else
                {
                    $arPolicy = $USER->GetGroupPolicy(array());
                }

                $password_min_length = intval($arPolicy["PASSWORD_LENGTH"]);
                if($password_min_length <= 0) $password_min_length = 6;
                $password_chars = array(
                    "abcdefghijklnmopqrstuvwxyz",
                    "ABCDEFGHIJKLNMOPQRSTUVWXYZ",
                    "0123456789",
                );
                if($arPolicy["PASSWORD_PUNCTUATION"] === "Y")
                    $password_chars[] = ",.<>/?;:'\"[]{}\|`~!@#\$%^&*()-_+=";

                $strDefPass = randString($password_min_length, $password_chars);
                $rsRegister = $USER->Register($_REQUEST["qoEmail"], iconv('utf-8','windows-1251',$_REQUEST["qoName"]), "", $strDefPass, $strDefPass, $_REQUEST["qoEmail"]);
                if($rsRegister["TYPE"] == "ERROR")
                {
                    echo showHtmlNote($el->LAST_ERROR, true);
                    die();
                }
            }

            $el = new CIBlockElement;
            $arLoadProductArray = array(
                "IBLOCK_ID" => QUICK_ORDER_IBLOCK_ID,
                "ACTIVE" => "Y",
                "NAME" => utf8win1251($_REQUEST["qoName"]),
                "ACTIVE_FROM" => date("d.m.Y H:i:s"),
                "PREVIEW_TEXT" => utf8win1251($_REQUEST["qoComment"]),
                "DETAIL_TEXT" => $arProduct["NAME"]." [арт. ".$arProduct["PROPERTY_ARTICUL_VALUE"].", ID ".$arProduct["ID"]." | offerID ".$arOffer["ID"]."]",
                "CODE" => utf8win1251($_REQUEST["qoPhone"]),
                "XML_ID" => $_REQUEST["qoEmail"]
            );

            if($PRODUCT_ID = $el->Add($arLoadProductArray))
            {
                // create order
                if(CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
                {
                    $arOrderFields = array(
                        "LID" => SITE_ID,
                        "PERSON_TYPE_ID" => 1,
                        "PAYED" => "N",
                        "CANCELED" => "N",
                        "STATUS_ID" => "N",
                        "PRICE" => 0,
                        "CURRENCY" => "RUB",
                        "USER_ID" => ($USER->GetID()>0?$USER->GetID():5250),
                        "PAY_SYSTEM_ID" => 1,
                        "PRICE_DELIVERY" => 0,
                        "DELIVERY_ID" => 1,
                        "DISCOUNT_VALUE" => 0,
                        "TAX_VALUE" => 0,
                        "USER_DESCRIPTION" => utf8win1251($_REQUEST["qoComment"])
                    );

                    $intOrderID = CSaleOrder::Add($arOrderFields);
                    if($intOrderID>0)
                    {

                    $BasketItems = CSaleBasket::GetList(
                         array(
                                    "NAME" => "ASC",
                                    "ID" => "ASC"
                                 ),
                         array(
                                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                                    "LID" => SITE_ID,
                                    "ORDER_ID" => "NULL"
                                 ),
                         false,
                         false,
                         array("*","PROPEERY_*")
                                 );
                         while ($arItems = $BasketItems->Fetch())
                              {
                                   $arItemsNew["PRODUCT_ID"] = $arItems["PRODUCT_ID"];
                                   $arItemsNew["PRICE"] = $arItems["PRICE"];
                                   $arItemsNew["CURRENCY"] = $arItems["CURRENCY"];
                                   $arItemsNew["PRODUCT_PRICE_ID"] =  $arItems["PRODUCT_PRICE_ID"];
                                   $arItemsNew["WEIGHT"] =  $arItems["WEIGHT"];
                                   $arItemsNew["QUANTITY"] =  $arItems["QUANTITY"];
                                   $arItemsNew["LID"] =  $arItems["LID"];
                                   $arItemsNew["DELAY"] =  $arItems["DELAY"];
                                   $arItemsNew["CAN_BUY"] =  $arItems["CAN_BUY"];
                                   $arItemsNew["NAME"] =  $arItems["NAME"];
                                   $arItemsNew["CALLBACK_FUNC"] =  $arItems["CALLBACK_FUNC"];
                                   $arItemsNew["MODULE"] =  $arItems["MODULE"];
                                   $arItemsNew["NOTES"] =  $arItems["NOTES"];
                                   $arItemsNew["ORDER_CALLBACK_FUNC"] =  $arItems["ORDER_CALLBACK_FUNC"];
                                   $arItemsNew["DETAIL_PAGE_URL"] =  $arItems["DETAIL_PAGE_URL"];
                                   
                                   $arItemsNew_1[] = $arItemsNew;
                              } 
                            
                        CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
                        
                        $price = CPrice::GetList( array(),array("PRODUCT_ID"=>$arOffer["ID"]))->Fetch();

                        CSaleBasket::Add(array(
                            "PRICE" => $price["PRICE"],
                            "QUANTITY" => 1,
                            "CURRENCY" => "RUB",
                            "PRODUCT_ID" => $arOffer["ID"],
                            "PRODUCT_PROVIDER_CLASS"=>"CCatalogProductProvider",
                            "MODULE"=> "catalog",
                            "NAME" => $arOffer["NAME"],
                            "LID" => LANG,
                            "DELAY" => "N",
                            "CAN_BUY" => "Y",  
                        ));      
                        
                       // Add2BasketByProductID($arOffer["ID"], 1);

                        CSaleBasket::OrderBasket($intOrderID, CSaleBasket::GetBasketUserID(), SITE_ID, false);

                        $dbBasketItems = CSaleBasket::GetList(array(), array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => $intOrderID), false, false, array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "NAME"));
                        $totalOrderPrice = 0;
                        while ($arBasketItems = $dbBasketItems->GetNext())
                            $totalOrderPrice += DoubleVal($arBasketItems["PRICE"]) * DoubleVal($arBasketItems["QUANTITY"]);

                        CSaleOrder::Update($intOrderID, Array("PRICE" => $totalOrderPrice));
                        
                        $arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 2, "NAME" => "Имя", "CODE" => "MAME", "VALUE" => utf8win1251($_REQUEST["qoName"]));
                        CSaleOrderPropsValue::Add($arFields);

                        $arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 3, "NAME" => "Телефон", "CODE" => "PHONE", "VALUE" => utf8win1251($_REQUEST["qoPhone"]));
                        CSaleOrderPropsValue::Add($arFields);

                        $arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 5, "NAME" => "E-mail", "CODE" => "EMAIL", "VALUE" => $_REQUEST["qoEmail"]);
                        CSaleOrderPropsValue::Add($arFields);

                        $arFields = array("ORDER_ID" => $intOrderID, "ORDER_PROPS_ID" => 6, "NAME" => "Адрес", "CODE" => "ADDRESS", "VALUE" => "БЫСТРЫЙ ЗАКАЗ");
                        CSaleOrderPropsValue::Add($arFields);

                        $strGA = getGASaleJS($intOrderID, "fast");

                        // mail message

                        $strOrderList = '
                        <table width="100%" cellspacing="0" cellpadding="0">
                        <tr style="border-bottom:1px;">
                        <td bgcolor="#de9694" style="padding:5px;">Наименование</td>
                        <td bgcolor="#de9694" style="padding:5px;">Цвет</td>
                        <td bgcolor="#de9694" style="padding:5px;">Размер</td>
                        <td bgcolor="#de9694" style="padding:5px;">Кол-во</td>
                        <td bgcolor="#de9694" style="padding:5px;">Цена</td>
                        </tr>';

                        $dbBasketItems = CSaleBasket::GetList(
                            array("NAME" => "ASC"),
                            array("ORDER_ID" => $intOrderID),
                            false,
                            false,
                            array("ID", "PRODUCT_ID", "NAME", "PRICE", "CURRENCY", "QUANTITY")
                        );
                        $i=0;
                        while ($arBasketItems = $dbBasketItems->Fetch())
                        {
                            $style = "";
                            if($i%2==1){
                                $style = 'bgcolor="#f7dbde"';
                            }
                            $strOrderList .= "<tr style='border-bottom:1px;' ".$style.">";
                            $arFilter = Array(   
                                "ACTIVE"=>"Y",    
                                "ID"=>$arBasketItems["PRODUCT_ID"]
                            );
                            $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("PROPERTY_COLOR","PROPERTY_CML2_LINK","PROPERTY_SIZE"));
                            if($ar_fields = $res->GetNext()){

                                $iddd = $ar_fields["PROPERTY_CML2_LINK_VALUE"];
                                //die(print_R($iddd));
                                $res2 = CIBlockElement::GetByID($iddd);
                                if($ar_res2 = $res2->GetNext()){
                                    //die(print_R($ar_res2));
                                    $arBasketItems["NAME"] = $ar_res2["NAME"];
                                }
                                //die(print_r($ar_res));
                                $strOrderList .= "<td style='padding:5px;'>".$arBasketItems["NAME"]."</td>";    

                                if(!empty($ar_fields["PROPERTY_COLOR_VALUE"])){
                                    $COLOR = $ar_fields["PROPERTY_COLOR_VALUE"];
                                }
                                $strOrderList .= "<td style='padding:5px;'>".$COLOR."</td>";    
                                if(!empty($ar_fields["PROPERTY_SIZE_VALUE"])){
                                    $SIZE = $ar_fields["PROPERTY_SIZE_VALUE"];
                                }
                                $strOrderList .= "<td style='padding:5px;'>".$SIZE."</td>";    
                            }
                            if($arBasketItems["CURRENCY"]=="RUR" || $arBasketItems["CURRENCY"]=="RUB")
                                $cur = "руб.";

                            $strOrderList .= "<td style='padding:5px;'>".$arBasketItems["QUANTITY"]."шт.</td>";
                            $strOrderList .= "<td style='padding:5px;'>".$arBasketItems["PRICE"]." ".$cur."</td>";                    
                            $strOrderList .= "</tr>";

                            $i++;
                        }

                        $strOrderList .= "</table>";
                      //   arshow($_REQUEST);

                        $arFields = Array(
                            "ORDER_ID" => $intOrderID,
                            "ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
                            "ORDER_USER" => ( (strlen($arResult["PAYER_NAME"]) > 0) ? $arResult["PAYER_NAME"] : $USER->GetFullName()),
                            "PRICE" => SaleFormatCurrency($totalOrderPrice, "RUB"),
                            "BCC" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
                            "EMAIL" => $_REQUEST["qoEmail"],
                            "ORDER_LIST" => $strOrderList,
                            "SALE_EMAIL" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
                            "DELIVERY_PRICE"=>"0 руб.",
                            "PAY_SYS" => "",
                            "ADDRESS" => "",
                            "PHONE" => utf8win1251($_REQUEST["qoPhone"]),
                            "CONTACT2" => "",
                            "PHONE2" => "",
                            "DELIVERY_DATE" => "не указано",
                            "PAY_SYSTEM" => "не указано",
                            "PAY_LINK" => "",
                            "DELIVERY" => ""
                        );

                        if(strlen($strDefPass)>0)
                        {
                            $arFields["LOGIN_DATA"] = '<tr><td colspan="5" style="padding:5px;"><strong>Доступ на сайт:</strong><br>Логин: '.$USER->GetLogin().'<br>Пароль: '.$strDefPass.'<br><br></td></tr>';
                        } else $arFields["LOGIN_DATA"] = '';
                         
                        $event = new CEvent;
                        $event->Send("SALE_NEW_ORDER", SITE_ID, $arFields);   
                    }
                }
                 
                echo showHtmlNote('Ваш заказ успешно сохранен. В ближайшее время с Вами свяжется менеджер для уточнения деталей.<script type="text/javascript"> $(document).ready(function() { $("#quickOrderForm").find("input:visible").each(function() { if(($(this).attr("name"))) $(this).val("") }); $("#quickOrderForm").find("textarea").val(""); $("#quickOrderForm").find("ul").hide(); }); '.$strGA.' </script>');
                //$arSend = array_merge(array("LINK"=>'http://'.$_SERVER["HTTP_HOST"].'/bitrix/admin/iblock_element_edit.php?WF=Y&ID='.$arProduct["ID"].'&type=catalog&lang=ru&IBLOCK_ID=3&find_section_section=-1'), $arLoadProductArray);
                $arSend = array_merge(array("LINK"=>'http://'.$_SERVER["HTTP_HOST"].$arProduct["DETAIL_PAGE_URL"]), $arLoadProductArray);
                CEvent::Send("QUICK_ORDER", SITE_ID, $arSend);
                foreach($arItemsNew_1 as $ItemNew){
                     CSaleBasket::Add($ItemNew);
                }
                             
            } else echo showHtmlNote($el->LAST_ERROR, true); 
        }
    }
?>