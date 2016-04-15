<?
$IS_REVIEWS = true;
$showSravn = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обзоры");



if(isset($_REQUEST["SECTION_CODE"])){
	if(preg_match("/[a-zA-Z0-9_]+/i",$_REQUEST["SECTION_CODE"])){
		$arrFilter["SECTION_CODE"] = $_REQUEST["SECTION_CODE"];
	}
	if(isset($GLOBALS["arrFilter_pf"])){
		//print_R($GLOBALS["arrFilter_pf"]);
		$arrFilter = array_merge($arrFilter,$GLOBALS["arrFilter_pf"]);
	}

$arFilter = Array('IBLOCK_ID' => REVIEWS_IBLOCK_ID, 'CODE' =>$_REQUEST["SECTION_CODE"]);
$rsSection = CIBlockSection::GetList(array(), $arFilter, false, array("UF_TITLE","UF_DESCRIPTION","UF_KEYWORDS"));
if($arSection = $rsSection->Fetch()) {
    
    $META = $arSection;
}
 if(isset($META["UF_TITLE"]) && !empty($META["UF_TITLE"])){
	$APPLICATION->SetPageProperty("headertitle",$META["UF_TITLE"]);
	}
if(isset($META["UF_KEYWORDS"]) && !empty($META["UF_KEYWORDS"]))
	$APPLICATION->SetPageProperty("keywords",$META["UF_KEYWORDS"]);
	if(isset($META["UF_DESCRIPTION"]) && !empty($META["UF_DESCRIPTION"])){
	$APPLICATION->SetPageProperty("description",$META["UF_DESCRIPTION"]);
		
	}
}
?>


<?$APPLICATION->IncludeComponent("individ:recomend.list", "recommendList1", Array(
	"IBLOCK_TYPE" => "catalog",	// Тип информационного блока (используется только для проверки)
	"IBLOCK_ID" => "7",	// Код информационного блока
	"NEWS_COUNT" => "20",	// Количество новостей на странице
	"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
	"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
	"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
	"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
	"FILTER_NAME" => "arrFilter",	// Фильтр
	"FIELD_CODE" => array(	// Поля
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(	// Свойства
		0 => "LOOK_REC_LIST",
		1 => "BLOG_POST_ID",
		2 => "",
	),
	"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
	"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"CACHE_FILTER" => "Y",	// Кешировать при установленном фильтре
	"CACHE_GROUPS" => "Y",	// Учитывать права доступа
	"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
	"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
	"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
	"PARENT_SECTION" => "",	// ID раздела
	"PARENT_SECTION_CODE" => "",	// Код раздела
	"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
	"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
	"PAGER_TITLE" => "Новости",	// Название категорий
	"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
	"PAGER_TEMPLATE" => "",	// Название шаблона
	"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
	"PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
	"DISPLAY_DATE" => "Y",	// Выводить дату элемента
	"DISPLAY_NAME" => "Y",	// Выводить название элемента
	"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
	"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>