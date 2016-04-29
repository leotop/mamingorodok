<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $price = $_POST["price"];
    $comments = $_POST["comments"];

?>
<?
    global $USER;
    /*$password = randString(7, array(
    "abcdefghijklnmopqrstuvwxyz",
    "ABCDEFGHIJKLNMOPQRSTUVWX­YZ",
    "0123456789",
    "!@#\$%^&*()",
    ));  */
    $login = randString(10, array(
        "0123456789",
    ));    
    $user_new = $USER->SimpleRegister($login.'_'.$email); // регистрируем нового пользоателя
    $fields = Array(
        "NAME"  => utf8win1251($name),
    );
    $USER->Update($USER->GetID(), $fields);
    /*$user_new = $USER->Register('user'.$login, utf8win1251($name), "", $password, $password, $email); // регистрируем нового пользоателя
    */
    // Выберем записи корзины текущего пользователя


    $arFields = array(
        "LID" => SITE_ID,
        "PERSON_TYPE_ID" => 1,
        "PAYED" => "N",
        "CANCELED" => "N",
        "STATUS_ID" => "u",
        "PRICE" => $price,
        "CURRENCY" => "RUB",
        "MODULE" => "catalog",
        "USER_ID" => $USER->GetID(),
    );      

    $arResult["ORDER_ID"] = (int)CSaleOrder::DoSaveOrder($arFields_props, $arFields, 0, $arResult["ERROR"]);//сохраняем все параметры корзины

    $arOrder = CSaleOrder::GetByID($arResult["ORDER_ID"]);      //получем id сохраненного заказа

    $arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 2, "NAME" => "Имя", "CODE" => "ORDER_USER", "VALUE" => utf8win1251($name));
    CSaleOrderPropsValue::Add($arFields_props);

    $arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 3, "NAME" => "Телефон", "CODE" => "PHONE", "VALUE" => $phone);
    CSaleOrderPropsValue::Add($arFields_props);

    $arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 5, "NAME" => "E-mail", "CODE" => "EMAIL", "VALUE" => $email);
    CSaleOrderPropsValue::Add($arFields_props);

    $arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 6, "NAME" => "Адрес", "CODE" => "ADDRESS", "VALUE" => "БЫСТРЫЙ ЗАКАЗ");
    CSaleOrderPropsValue::Add($arFields_props);

    $arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 7, "NAME" => "Комментарий", "CODE" => "COMMENT", "VALUE" => utf8win1251($comments));
    CSaleOrderPropsValue::Add($arFields_props);  

    $aar_items = CSaleBasket::OrderBasket($arOrder, $_SESSION["SALE_USER_ID"], SITE_ID);

    CSaleOrder::Update($arResult["ORDER_ID"], $arFields);    // пересохраняем заказ
    //$ORDER_ID = CSaleOrder::Add($arFields);

    $arSend = array("LINK"=>'http://'.$_SERVER["HTTP_HOST"].'/basket/order/?ORDER_ID='.$ORDER_ID, "NAME" => utf8win1251($name), "CODE"=>$phone, "ACTIVE_FROM" => date("d.m.Y H:i:s"), "XML_ID"=>$email, "PREVIEW_TEXT" => utf8win1251($comments));
    CEvent::Send("QUICK_ORDER", SITE_ID, $arSend); 

    $USER->Logout();

?>
<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>