<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>
<p>На этой странице отображены все товары, которые Вы хотели бы приобрести, но по каким-то причинам отложили покупку. На современном языке это называется "вишлист".</p>
<?$APPLICATION->IncludeComponent("sk:personal.wish.list", "personal_wish_list", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?>          
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>