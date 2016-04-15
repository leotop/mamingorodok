<?

@ini_set("memory_limit", "4096M");
error_reporting(E_ALL);
$thisDir = $_SERVER["DOCUMENT_ROOT"];
if (!$_SERVER["DOCUMENT_ROOT"])
{
	//require_once(dirname(__FILE__) .  "/../php_interface/global_const.php");
	// define("NO_KEEP_STATISTIC", true);
	// define("NOT_CHECK_PERMISSIONS", true);
	// $_SERVER["DOCUMENT_ROOT"]=DOCUMENT_ROOT_MAIN_SITE;     //realpath(dirname(__FILE__)."/../..");
	$DOCUMENT_ROOT = "/data/mamingorodok.ru/docs/";
	$thisDir = $DOCUMENT_ROOT;
	$_SERVER["DOCUMENT_ROOT"] = "/data/mamingorodok.ru/docs";
}
define("AUX_NO_PERSISTENT", true);
define("BX_CRONTAB", true);

setlocale(LC_ALL, "ru_RU.cp1251");
setlocale(LC_NUMERIC, "C");

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");



@set_time_limit(0);
@ignore_user_abort(true);


if(CModule::IncludeModule("catalog") && CModule::IncludeModule("iblock")) {
	$r = CCatalogExport::PreGenerateExport(19);
	var_dump($r);
}