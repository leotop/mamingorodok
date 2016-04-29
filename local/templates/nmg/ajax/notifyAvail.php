<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(isset($_REQUEST["frmNASent"]))
{
	$arErr = array();
	if(strlen($_REQUEST["naName"])<=2) $arErr[] = 'Не заполнено поле "Имя"';
	if(strlen($_REQUEST["naPhone"])<=2) $arErr[] = 'Не заполнено поле "Телефон"';
	if(!check_email($_REQUEST["naEmail"])) $arErr[] = 'Не заполнено поле "Email"';
	
	CModule::IncludeModule("iblock");
	
	if(intval($_REQUEST["naOffer"])>0 || intval($_REQUEST["naProduct"])>0)
	{
		if(intval($_REQUEST["naOffer"])>0)
		{
			$rsProduct = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>intval($_REQUEST["naOffer"])), false, false, array("ID"));
			if(!$arOffer = $rsProduct -> GetNext())
				$arErr[] = 'Неверно указан товар';
		} elseif(intval($_REQUEST["naProduct"])>0) {
			$rsProduct = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ACTIVE"=>"Y", "ID"=>intval($_REQUEST["naProduct"])), false, false, array("ID"));
			if(!$arProduct = $rsProduct -> GetNext())
				$arErr[] = 'Неверно указан товар';
		}
	} else $arErr[] = 'Неверно указан товар';
	
	if(count($arErr)>0)
		echo showHtmlNote(implode("<br>", $arErr), true).'<br>';
	else {
        
		$el = new CIBlockElement;
		$arLoadProductArray = array(
			"IBLOCK_ID" => NOTIFY_IBLOCK_ID,
			"ACTIVE" => "Y",
			"NAME" => utf8win1251($_REQUEST["naName"]),
			"ACTIVE_FROM" => date("d.m.Y H:i:s"),
			"CODE" => utf8win1251($_REQUEST["naPhone"]),
			"XML_ID" => $_REQUEST["naEmail"],
			"PROPERTY_VALUES" => array(
				"OFFER" => $arOffer["ID"],
				"PRODUCT" => $arProduct["ID"]
			)
		);
		
		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{
            if ($USER->IsAuthorized())
            {
			echo showHtmlNote('Интересующий Вас товар успешно добавлен в список ожидания. Как только указанный Вами товар появится в наличии, Вам будет отправлено извещение на указанный Вами электронный адрес. Список товаров в статусе <a href="http://www.mamingorodok.ru/personal/products/track/">"Ожидается поставка"</a> вы можете посмотреть в своем <a href="http://www.mamingorodok.ru/personal/">личном кабинете.</a><script type="text/javascript"> function form_res() { $("#naForm").find("input:visible").each(function() { if(($(this).attr("name"))) $(this).val(""); $(this).css("display","none");}); $("#naForm").find("ul:visible").each(function() {$(this).css("display","none");})}; form_res(); </script>');
			//echo '<script type="text/javascript"> $(document).ready(function() { $("#naForm").find("input:visible").each(function() { if(($(this).attr("name"))) $(this).val("") }); showNotify("Как только указанный Вами товар появится в наличии, Вам будет отправлено извещение на указанный адрес.", "Ваш запрос успешно сохранен"); }); </script>';
			}
            else {
             echo showHtmlNote('Интересующий Вас товар успешно добавлен в список ожидания. Как только указанный Вами товар появится в наличии, Вам будет отправлено извещение на указанный Вами электронный адрес. <script type="text/javascript"> function form_res() { $("#naForm").find("input:visible").each(function() { if(($(this).attr("name"))) $(this).val(""); $(this).css("display","none");}); $("#naForm").find("ul:visible").each(function() {$(this).css("display","none");})}; form_res(); </script>');   
            }
		} else echo showHtmlNote($el->LAST_ERROR, true);
	}
}
?>