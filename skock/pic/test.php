<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


$arFileTmp = CFile::ResizeImageGet(
	19422958,
	array("width" => 100, 'height' => 100),
	BX_RESIZE_IMAGE_EXACT,
	false
);

echo '<img src="'.$arFileTmp["src"].'">';