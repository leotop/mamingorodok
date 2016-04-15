<?
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?>
<div class="map">
<h1>Карта сайта</h1>

<div class="reviews">
	<?
	$APPLICATION->IncludeComponent("bitrix:main.map", "sitemap", Array(
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"LEVEL" => "3",	// Максимальный уровень вложенности (0 - без вложенности)
	"COL_NUM" => "1",	// Количество колонок
	"SHOW_DESCRIPTION" => "N",	// Показывать описания
	),
	false
);
	?>
</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>