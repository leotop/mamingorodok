<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if($USER -> IsAuthorized() && cSKTools::checkHash(intval($USER -> GetID()), $_REQUEST["hash"])) {
	$user = new CUser;
	$user->Update($USER -> GetID(), array("ACTIVE" => "N"));
	$USER -> Logout();
}

LocalRedirect('/');