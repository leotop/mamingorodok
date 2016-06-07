<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $id = $_POST["id"];
    $comments = $_POST["comments"];

?>
<?
if(CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))    // подключение модулей каталога и корзины
{
    global $USER;

        if (!$USER->IsAuthorized()){ //если пользователь не авторизирован

            $filter = Array( "EMAIL" => $email );
            $rsUsers = CUser::GetList($by = 'ID', $order = 'ASC', $filter)->Fetch(); // выбираем пользователей

            $login = randString(10, array(
              "0123456789",
            ));

            if(!$rsUsers){           // существует ли email в базе
                $emailRand = $email;
                $user_new = $USER->SimpleRegister($emailRand); // регистрируем нового пользоателя
                    $fields = Array(
                      "NAME"  => utf8win1251($name),
                      );
                    $USER->Update($USER->GetID(), $fields);
                    $rsUsers["ID"] = $USER->GetID();
            }
        }
        // Выберем записи корзины текущего пользователя
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
                       $arItemsNew["PRODUCT_XML_ID"] =  $arItems["PRODUCT_XML_ID"];

                       $arItemsNew_1[] = $arItemsNew;
                  }

            CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());

        $price = CPrice::GetList( array(),array("PRODUCT_ID"=>$id))->Fetch();
        $basket_array = array(
            "PRICE" => $price["PRICE"],
            "QUANTITY" => 1,
            "CURRENCY" => "RUB",
            "PRODUCT_ID" => $id,
            "PRODUCT_PROVIDER_CLASS"=>"CCatalogProductProvider",
            "MODULE"=> "catalog",
            "NAME" => utf8win1251($_POST['name_item']),
            "LID" => LANG,
            "DELAY" => "N",
            "CAN_BUY" => "Y",
            "PRODUCT_XML_ID" => $_POST['data_code'],
            "CATALOG_XML_ID" => $_POST['data_code_section']

        );

        $basket = CSaleBasket::Add($basket_array);



        $arProps = array();

          $arProps[] = array(
            "NAME" => "Цвет",
            "VALUE" => $_POST['color']
          );

        $arFields["PROPS"] = $arProps;

        $arFields = array(
           "LID" => SITE_ID,
           "PERSON_TYPE_ID" => 1,
           "PAYED" => "N",
           "CANCELED" => "N",
           "STATUS_ID" => "u",
           "PRICE" => $price["PRICE"],
           "CURRENCY" => "RUB",
           "NOTES" => "",
           "MODULE" => "catalog",
           "USER_ID" => $rsUsers["ID"],
        );



      //  $aar_items = CSaleBasket::OrderBasket($ORDER_ID, $_SESSION["SALE_USER_ID"], SITE_ID);


        $arResult["ORDER_ID"] = (int)CSaleOrder::DoSaveOrder($arFields_props, $arFields, 0, $arResult["ERROR"]);

        $arOrder = CSaleOrder::GetByID($arResult["ORDER_ID"]);

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

        /*$arFields_props = array("ORDER_ID" => $arResult["ORDER_ID"], "ORDER_PROPS_ID" => 34, "NAME" => "Быстрый заказ", "CODE" => "quick_order", "VALUE" =>"Y");
        CSaleOrderPropsValue::Add($arFields_props);  */
            $aar_items = CSaleBasket::OrderBasket( $arOrder, $_SESSION["SALE_USER_ID"], SITE_ID);

            CSaleOrder::Update($arResult["ORDER_ID"], $arFields);

        if($user_new){
            $USER->Logout();
        }

        $arSend = array("LINK"=>'http://'.$_SERVER["HTTP_HOST"].$_POST["url"], "NAME" => utf8win1251($name), "CODE"=>$phone, "ACTIVE_FROM" => date("d.m.Y H:i:s"), "XML_ID"=>$email, "PREVIEW_TEXT" => utf8win1251($comments));
        CEvent::Send("QUICK_ORDER", SITE_ID, $arSend);

        foreach($arItemsNew_1 as $ItemNew){
             CSaleBasket::Add($ItemNew);
        }
}

?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>