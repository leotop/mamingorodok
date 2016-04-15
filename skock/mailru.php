<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Детские товары для новорожденных");
$APPLICATION->SetPageProperty("description", "Каталог товаров для детей и новорожденных в интернет-магазине «МАМИН ГОРОДОК», купить товары для новорожденных по низкой цене с доставкой по Москве.");
$APPLICATION->SetPageProperty("keywords", "товары для новорожденных в интернет магазине, цены на товары для детей");
$APPLICATION->SetPageProperty("title", "Купить товары для новорожденных в интернет-магазине в Москве, цена товаров для детей и новорожденных с доставкой");
?><?php
$APPLICATION->IncludeComponent(
	"mailru:comments.list",
	".default",
	array(
		"clientId" => 10183, // Id клиента в Mail.Ru
		"onPage" => 5, // Количество отзывов на страницу
		"pager" => 2, // Тип листалки, значения 1 (постраничная) или 2 (ajax-овая)
		"offerId" => $arResult["ID"], // id элемента (товара), нужно подставлять динамически в зависимости от текущей страницы
		"backgroundColor" => "#B7BF84", // Цвет фона
		"fontColor" => "#CF004E", // Цвет текста
	),
	false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>