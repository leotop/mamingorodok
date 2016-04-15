<?
global $NO_BROAD;
$NO_BROAD = false;
$HIDE_LEFT_COLUMN = true;

define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->AddChainItem("Профиль", "/community/profile/");
$APPLICATION->AddChainItem("Восстановление пароля", "");
if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0)
    LocalRedirect($backurl);

$APPLICATION->SetTitle("Авторизация");
?>
<div id="CatalogCenterColumn" class="LExist">
<?ShowNote("Вы зарегистрированы и успешно авторизованы.");?>
<p><a href="<?=SITE_DIR?>">Вернуться на главную страницу</a></p>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>