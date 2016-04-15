<?
global $NO_BROAD;
$NO_BROAD = true;
$IS_HIDE = true;
$HIDE_LEFT_COLUMN = true;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?><?
$APPLICATION->SetTitle("Категории");
?>
<?
global $USER;
if($USER->IsAuthorized()){
$user_id = $USER->GetID();
$arBlog = CBlog::GetByOwnerID($user_id);
if(is_array($arBlog)){
    //print_r($arBlog);
	$APPLICATION->IncludeComponent(
	"bitrix:blog.menu",
	"",
	Array(
			"BLOG_VAR"				=> $arBlog["URL"],
			"USER_VAR"				=> $user_id,
			"PAGE_VAR"				=> $arResult["ALIASES"]["page"],
			"PATH_TO_BLOG"			=> $arResult["PATH_TO_BLOG"],
			"PATH_TO_USER"			=> $arResult["PATH_TO_USER"],
			"PATH_TO_USER_FRIENDS"	=> $arResult["PATH_TO_USER_FRIENDS"],
			"BLOG_URL"				=> $arResult["VARIABLES"]["blog"],
		),
	$component
	);
	}
}
?>
<div class="top15"></div>

    <div id="BlogLeft">
	<div class="group">
	 <div class="clear"></div>
	</div>
    </div>
	
	<div id="BlogRight">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/rightColumn.php", array("arResult"=>$arResult, "arParams"=>$arParams), array("MODE"=>"html") );?>
	</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>