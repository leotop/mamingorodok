<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$id= intval($_REQUEST["id"]);
if($id>0){
	 $APPLICATION->IncludeComponent("individ:forum.topic.reviews", "add-comment", array(
                "FORUM_ID" => "1",
                "IBLOCK_ID" => $arResult["IBLOCK_ID"],
                "ELEMENT_ID" => $id,
                "POST_FIRST_MESSAGE" => "N",
                "POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#
                            [url=#LINK#]#TITLE#[/url]
                            #BODY#",
                "URL_TEMPLATES_READ" => "",
                "URL_TEMPLATES_DETAIL" => "",
                "URL_TEMPLATES_PROFILE_VIEW" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "0",
                "MESSAGES_PER_PAGE" => "0",
                "PAGE_NAVIGATION_TEMPLATE" => "",
                "DATE_TIME_FORMAT" => "d.m.Y H:i:s",
                "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                "USE_CAPTCHA" => "Y",
                "PREORDER" => "Y",
                "SHOW_LINK_TO_FORUM" => "N",
                "FILES_COUNT" => "2"
                ),
                false
            );
			
}
?>