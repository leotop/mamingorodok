<?
die();
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("NO_BITRIX_AUTOLOAD", True);
define('BX_NO_ACCELERATOR_RESET', true);

@set_time_limit (0);
@ignore_user_abort(true);
ini_set("max_execution_time", 1000000000);

if(empty($_SERVER["DOCUMENT_ROOT"])) $_SERVER["DOCUMENT_ROOT"] = '/data/mamingorodok.ru/docs';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("catalog"))
{
	$def = CCatalogExport::GetList(array(),array("ID"=>15),false);
	if($res = $def->Fetch())
	{
		global $NochekMoreParam;
		
		$NochekMoreParam = true;
		fwrite($handle,"Yandex import профиль ".$res["ID"]."\r\n");
		if(!CCatalogExport::PreGenerateExport($res["ID"]))
			fwrite($handle,"Yandex import error.\r\n");
		else fwrite($handle,"Yandex import done.\r\n");
	} else fwrite($handle,"Yandex import error profile.\r\n");
}
?>