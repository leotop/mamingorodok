<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?
$APPLICATION->AddChainItem("Профиль", "/community/profile/");
$APPLICATION->AddChainItem("Рейтинг", "");
$pageId = "user_rating";
//include("util_menu.php");
//include("util_profile.php");

global $USER;
$current_user_id = $USER->GetID();
$user_id = $arResult["VARIABLES"]["user_id"];
?>


<? // если пользователь смотрит свой рейтинг ?>
<?if ($current_user_id == $user_id):?>

      <div class="wish-list-light">
        <div class="wish-list-left">        
        <?$APPLICATION->IncludeComponent("individ:group.blogs.list.my.created", "", array(
            "USER_ID" => $user_id,
            "GROUP_ID" => "2",
            "BLOG_COUNT" => "10",
            "SHOW_DESCRIPTION" => "Y",
            "PATH_TO_BLOG" => "/community/group/#blog#/",
            "PATH_TO_USER" => "/community/user/#user_id#/",
            "PATH_TO_GROUP" => "",
            "PATH_TO_GROUP_BLOG" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "86400",
            "SORT_BY1" => "DATE_CREATE",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "BLOG_VAR" => "",
            "USER_VAR" => "",
            "PAGE_VAR" => "",
            "SEO_USER" => "N"
            ),
            false
        );?>        
        
        <?$APPLICATION->IncludeComponent("individ:group.blogs.list.my", "rating", array(
            "USER_ID" => $user_id,
            "GROUP_ID" => "2",
            "BLOG_COUNT" => "10",
            "SHOW_DESCRIPTION" => "Y",
            "PATH_TO_BLOG" => "/community/group/#blog#/",
            "PATH_TO_USER" => "/community/user/#user_id#/",
            "PATH_TO_GROUP" => "",
            "PATH_TO_GROUP_BLOG" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "86400",
            "SORT_BY1" => "DATE_CREATE",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "BLOG_VAR" => "",
            "USER_VAR" => "",
            "PAGE_VAR" => "",
            "SEO_USER" => "N"
            ),
            false
        );?>
        </div>
      </div>

<?else: // чужой рейтинг?>
        <?$APPLICATION->IncludeComponent("individ:user.profile.top", "", array(
            "USER_ID" => $user_id,
            "CURRENT_USER_ID" => $current_user_id,
            "IS_FRIENDS" => CSocNetUserRelations::IsFriends($user_id, $current_user_id),
            "CURRENT_PAGE" => "RATING"

        ));?>        
      <div class="wish-list-light">
        <div class="wish-list-left">        
        <?$APPLICATION->IncludeComponent("individ:group.blogs.list.my.created", "", array(
            "USER_ID" => $user_id,
            "GROUP_ID" => "2",
            "BLOG_COUNT" => "10",
            "SHOW_DESCRIPTION" => "Y",
            "PATH_TO_BLOG" => "/community/group/#blog#/",
            "PATH_TO_USER" => "/community/user/#user_id#/",
            "PATH_TO_GROUP" => "",
            "PATH_TO_GROUP_BLOG" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "86400",
            "SORT_BY1" => "DATE_CREATE",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "BLOG_VAR" => "",
            "USER_VAR" => "",
            "PAGE_VAR" => "",
            "SEO_USER" => "N"
            ),
            false
        );?>        
        
        <?$APPLICATION->IncludeComponent("individ:group.blogs.list.my", "rating", array(
            "USER_ID" => $user_id,
            "GROUP_ID" => "2",
            "BLOG_COUNT" => "10",
            "SHOW_DESCRIPTION" => "Y",
            "PATH_TO_BLOG" => "/community/group/#blog#/",
            "PATH_TO_USER" => "/community/user/#user_id#/",
            "PATH_TO_GROUP" => "",
            "PATH_TO_GROUP_BLOG" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "86400",
            "SORT_BY1" => "DATE_CREATE",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "ID",
            "SORT_ORDER2" => "DESC",
            "BLOG_VAR" => "",
            "USER_VAR" => "",
            "PAGE_VAR" => "",
            "SEO_USER" => "N"
            ),
            false
        );?>
        </div>
      </div>

<?endif?>