<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

?>
<?$APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", ".default", array(
	"IBLOCK_TYPE" => "community",
	"IBLOCK_ID" => "8",
	"STATUS_NEW" => "N",
	"LIST_URL" => "",
	"USE_CAPTCHA" => "N",
	"USER_MESSAGE_EDIT" => "",
	"USER_MESSAGE_ADD" => "",
	"DEFAULT_INPUT_SIZE" => "30",
	"RESIZE_IMAGES" => "Y",
	"PROPERTY_CODES" => array(
		0 => "NAME",
		1 => "408",
	),
	"PROPERTY_CODES_REQUIRED" => array(
		0 => "408",
	),
	"GROUPS" => array(
		0 => "2",
	),
	"STATUS" => "ANY",
	"ELEMENT_ASSOC" => "PROPERTY_ID",
	"ELEMENT_ASSOC_PROPERTY" => WISHLIST_USER_ID_PROPERTY_ID,
	"MAX_USER_ENTRIES" => "100000",
	"MAX_LEVELS" => "100000",
	"LEVEL_LAST" => "Y",
	"MAX_FILE_SIZE" => "0",
	"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
	"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/community/user/1/",
	"CUSTOM_TITLE_NAME" => "",
	"CUSTOM_TITLE_TAGS" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
	"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
	"CUSTOM_TITLE_IBLOCK_SECTION" => "",
	"CUSTOM_TITLE_PREVIEW_TEXT" => "Описание",
	"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
	"CUSTOM_TITLE_DETAIL_TEXT" => "",
	"CUSTOM_TITLE_DETAIL_PICTURE" => ""
	),
	$component
);?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); 
?>