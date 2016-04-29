<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

__IncludeLang(dirname(__FILE__)."/lang/".LANGUAGE_ID."/vk.php");
$name = "vk";
$title = GetMessage("BOOKMARK_HANDLER_VK");
$icon_url_template = "<script>\n".
	"if (__function_exists('vk_click') == false) \n".
	"{\n".
		"function vk_click(url,desc) \n".
		"{ \n".
			"window.open('http://vkontakte.ru/share.php?url='+encodeURIComponent(url)+'&description='+desc,'sharer','toolbar=0,status=0,width=626,height=436'); \n".
			"return false; \n".
		"} \n".
	"}\n".
	"</script>\n".
	"<a href=\"http://vkontakte.ru/share.php?url=#PAGE_URL#\" onclick=\"return vk_click('#PAGE_URL#','#PAGE_DESCRIPTION_MOD#');\" target=\"_blank\" class=\"vk\" title=\"".$title."\"></a>\n";
$sort = 400;
?>