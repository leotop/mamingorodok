<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetTitle("Тест");
?><style>
    .centered {
        position:relative;
    }
</style>&nbsp;<br>
 <?$APPLICATION->IncludeComponent(
	"bitrix:main.register", 
	"basket-reg", 
	array(
		"COMPONENT_TEMPLATE" => "basket-reg",
		"SHOW_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
			3 => "PERSONAL_CITY",
		),
		"REQUIRED_FIELDS" => array(
			0 => "EMAIL",
			1 => "NAME",
			2 => "PERSONAL_PHONE",
		),
		"AUTH" => "Y",
		"USE_BACKURL" => "Y",
		"SUCCESS_PAGE" => "",
		"SET_TITLE" => "Y",
		"USER_PROPERTY" => array(
		),
		"USER_PROPERTY_NAME" => ""
	),
	false
);?><br>
<?$APPLICATION->IncludeComponent(
	"bitrix:socserv.auth.form",
	"icons",
	Array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"COMPONENT_TEMPLATE" => "icons"
	),
$component,
Array(
	'HIDE_ICONS' => 'Y'
)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>