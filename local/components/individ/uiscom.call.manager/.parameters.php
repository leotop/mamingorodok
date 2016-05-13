<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!CModule::IncludeModule("blog"))
	return false;

$arComponentParameters = Array(
	"GROUPS" => array(
		"VARIABLE_ALIASES" => array(
			"NAME" => GetMessage("B_VARIABLE_ALIASES"),
		),
	),
	"PARAMETERS" => Array(
		"h" => Array(
			"NAME" => "h-ключ",
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"DEFAULT" => "",
		)
	)
);
?>