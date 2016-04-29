<?define('NEED_AUTH', true);?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$pageId = "user_friends_invite";
//include("util_menu.php");
//include("util_profile.php");
?>
<?$APPLICATION->IncludeComponent("individ:invite.by.email.form", "", array(
    "USER_ID" => $arResult["VARIABLES"]["user_id"]
));?>