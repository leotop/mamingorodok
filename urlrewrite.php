<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/community/user/(.*?)/certificates/([a-zA-Z\\-_]*)?(/?)#",
		"RULE" => "USER_ID=\$1&DO=\$2",
		"ID" => "individ:certificates.list",
		"PATH" => "/community/certificates/index.php",
	),
	array(
		"CONDITION" => "#^/personal/profile/exchange-password/(.*?)#",
		"RULE" => "\$1",
		"ID" => "",
		"PATH" => "/personal/auth/index.php",
	),
	array(
		"CONDITION" => "#^/personal/profile/forgot-password/(.*?)#",
		"RULE" => "forgot_password=yes",
		"ID" => "",
		"PATH" => "/personal/auth/index.php",
	),
	array(
		"CONDITION" => "#^/basketFriend/(.*?)/((.*?)/(.*?)/)?#",
		"RULE" => "USER_ID=\$1&step=\$3&ORDER_ID=\$4",
		"ID" => "",
		"PATH" => "/basketFriend/index.php",
	),
	array(
		"CONDITION" => "#^/community/user/(.*?)/awards/#",
		"RULE" => "USER_ID=\$1",
		"ID" => "",
		"PATH" => "/community/awards.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/title/(.*?)/.*?#",
		"RULE" => "FILTER_PARAM=\$1",
		"ID" => "",
		"PATH" => "/catalog/title/index.php",
	),
	array(
		"CONDITION" => "#^/reviews/([^\\/]+)/(.*)?#",
		"RULE" => "SECTION_CODE=\$1",
		"ID" => "",
		"PATH" => "/reviews/type.php",
	),
	array(
		"CONDITION" => "#^/catalog/title/(.*?)#",
		"RULE" => "FILTER_PARAM=\$1",
		"ID" => "",
		"PATH" => "/catalog/title/index.php",
	),
	array(
		"CONDITION" => "#^/community/group/#",
		"RULE" => "",
		"ID" => "individ:group.blog",
		"PATH" => "/community/group/index.php",
	),
	array(
		"CONDITION" => "#^/community/blog/#",
		"RULE" => "",
		"ID" => "bitrix:blog",
		"PATH" => "/community/blog/index.php",
	),
	array(
		"CONDITION" => "#^/community/blog/#",
		"RULE" => "",
		"ID" => "bitrix:blog",
		"PATH" => "/community/blog/group/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/test/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/test_cat.php",
	),
	array(
		"CONDITION" => "#^/community/#",
		"RULE" => "",
		"ID" => "individ:socialnetwork",
		"PATH" => "/community/index.php",
	),
	array(
		"CONDITION" => "#^/actions/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/actions/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/test_catalog.php",
	),
	array(
		"CONDITION" => "#^\\??(.*)#",
		"RULE" => "&\$1",
		"ID" => "bitrix:catalog.top",
		"PATH" => "/basket/index.php",
	),
	array(
		"CONDITION" => "#^/forum/#",
		"RULE" => "",
		"ID" => "bitrix:forum",
		"PATH" => "/forum/index.php",
	),
);

?>