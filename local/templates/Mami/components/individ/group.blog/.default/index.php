<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?print_R($arResult["ALIASES"]["user_id"]);?>
<?//print_R($arParams);?>
<div class="body-blog">
<div class="blog-mainpage">
<?$APPLICATION->IncludeComponent(
	"bitrix:blog.menu",
	"",
	Array(
			"BLOG_VAR"				=> $arResult["ALIASES"]["blog"],
			"POST_VAR"				=> $arResult["ALIASES"]["post_id"],
			"USER_VAR"				=> $arResult["ALIASES"]["user_id"],
			"PAGE_VAR"				=> $arResult["ALIASES"]["page"],
			"PATH_TO_BLOG"			=> $arResult["PATH_TO_BLOG"],
			"PATH_TO_USER"			=> $arResult["PATH_TO_USER"],
			"PATH_TO_BLOG_EDIT"		=> $arResult["PATH_TO_BLOG_EDIT"],
			"PATH_TO_BLOG_INDEX"	=> $arResult["PATH_TO_BLOG_INDEX"],
			"PATH_TO_DRAFT"			=> $arResult["PATH_TO_DRAFT"],
			"PATH_TO_POST_EDIT"		=> $arResult["PATH_TO_POST_EDIT"],
			"PATH_TO_USER_FRIENDS"	=> $arResult["PATH_TO_USER_FRIENDS"],
			"PATH_TO_USER_SETTINGS"	=> $arResult["PATH_TO_USER_SETTINGS"],
			"PATH_TO_GROUP_EDIT"	=> $arResult["PATH_TO_GROUP_EDIT"],
			"PATH_TO_CATEGORY_EDIT"	=> $arResult["PATH_TO_CATEGORY_EDIT"],
			"BLOG_URL"				=> $arResult["VARIABLES"]["blog"],
			"SET_NAV_CHAIN"			=> $arResult["SET_NAV_CHAIN"],
			"GROUP_ID" 			=> $arParams["GROUP_ID"],
		),
	$component
);?>
	<?if($USER->IsAuthorized() && CBlog::CanUserCreateBlog($USER->GetID()))
	{
		if(!CBlog::GetByOwnerID($USER->GetID(), $arParams["GROUP_ID"]))
		{
			?>
		<div class="blog-mainpage-create-blog">
		<a href="<?=$arResult["PATH_TO_NEW_BLOG"]?>" class="blog-author-icon"></a>&nbsp;<a href="<?=$arResult["PATH_TO_NEW_BLOG"]?>"><?=GetMessage("BLOG_CREATE_BLOG")?></a>
		</div>
			<?
		}
	}

?>
<script>
<!--
function BXBlogTabShow(id, type)
{
	if(type == 'post')
	{
		
		document.getElementById('new-posts').style.display = 'inline';
		document.getElementById('popular-posts').style.display = 'inline';
		document.getElementById('commented-posts').style.display = 'inline';
		
		document.getElementById('new-posts-title').style.display = 'none';
		document.getElementById('popular-posts-title').style.display = 'none';
		document.getElementById('commented-posts-title').style.display = 'none';
		
		document.getElementById('new-posts-content').style.display = 'none';
		document.getElementById('popular-posts-content').style.display = 'none';
		document.getElementById('commented-posts-content').style.display = 'none';

		document.getElementById(id).style.display = 'none';
		document.getElementById(id+'-title').style.display = 'inline';
		document.getElementById(id+'-content').style.display = 'block';
	}
	else if(type == 'blog')
	{
		document.getElementById('new-blogs').style.display = 'inline-block';
		document.getElementById('popular-blogs').style.display = 'inline-block';
		
		document.getElementById('new-blogs-title').style.display = 'none';
		document.getElementById('popular-blogs-title').style.display = 'none';
		
		document.getElementById('new-blogs-content').style.display = 'none';
		document.getElementById('popular-blogs-content').style.display = 'none';

		document.getElementById(id).style.display = 'none';
		document.getElementById(id+'-title').style.display = 'inline-block';
		document.getElementById(id+'-content').style.display = 'block';
	}
	
}
//-->
</script>


<div class="top15"></div>

    <div id="BlogLeft">
	<div class="group">
	
    
        <?$APPLICATION->IncludeComponent("individ:group.blogs.list", "", array(
            "GROUP_ID" => "2",
            "BLOG_COUNT" => "6",
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
		
		<div class="clear"></div>
		
		<div class="group">
		<?if($USER->IsAuthorized()):?>
	
    <?$APPLICATION->IncludeComponent("individ:group.blogs.list.my", "", array(
        "GROUP_ID" => "2",
        "BLOG_COUNT" => "6",
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
    <?endif;?>
    <div class="clear"></div>
	</div>
    </div>
	
	<div id="BlogRight">
		<div class="group">
            <a href="#zayav" class="showpUp"><div class="addZ"></div></a>
			 <div class="clear"></div>
        </div>
		
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/blog/rightColumn.php", array("arResult"=>$arResult, "arParams"=>$arParams), array("MODE"=>"html") );?>
</div>
	
    <?if ($_REQUEST["WEB_FORM_ID"] > 0 || $_REQUEST["formresult"] == "addok"):?>
        <script>
            $(document).ready(function(){
                $("#BlogRight .group .showpUp").click()
            })
        </script>    
    <?endif?>
    
    <div class="form" id="zayav" style="<?=$display?>">
        <div class="white_plash">
            <div class="exitpUp"></div>
            <div class="cn tl"></div>
            <div class="cn tr"></div>
            <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
			<?
			global $USER;
			if($USER->IsAuthorized()):
			?>
                        <?$APPLICATION->IncludeComponent("bitrix:form.result.new", "new.blog.request", array(
                            "WEB_FORM_ID" => "1",
                            "IGNORE_CUSTOM_TEMPLATE" => "N",
                            "USE_EXTENDED_ERRORS" => "N",
                            "SEF_MODE" => "N",
                            "SEF_FOLDER" => "/",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "3600",
                            "LIST_URL" => "",
                            "EDIT_URL" => "",
                            "SUCCESS_URL" => "",
                            "CHAIN_ITEM_TEXT" => "",
                            "CHAIN_ITEM_LINK" => "",
                            "VARIABLE_ALIASES" => array(
                                "WEB_FORM_ID" => "WEB_FORM_ID",
                                "RESULT_ID" => "RESULT_ID",
                            )
                            ),
                            false
                        );?>
                        
                        <?/*<div class="title">Заявка на создание блога</div>
                        <form class="jqtransform">
                            <div><label>Название блога</label></div>
                            <div class="clear"></div>
                            <div><input type="text" value=""></div>
                            <div class="clear"></div>
                            <div><label>Описание блога</label></div>
                            <div class="clear"></div>
                            <div><textarea></textarea></div>
                            <div class="clear"></div>
                            <div class="top15"></div>
                            <input type="submit" value="Отправить заявку">
                            <input type="reset" value="Отмена">
                        </form>
                        */?>
				<?else:?>
					Для создания блога, необходимо <a href="/personal/auth/">авторизоваться</a>.
				<?endif;?>
                    </div></div></div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
    </div>





<?
if($arResult["SET_TITLE"]=="Y")
	$APPLICATION->SetTitle(GetMessage("BLOG_TITLE"));
?>
</div>
</div>

<div id="usernoWrite" class="nodisplay CatPopUp">
        <div class="white_plash">
            <div class="exitpUp"></div>
            <div class="cn tl"></div>
            <div class="cn tr"></div>
            <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
			
			Писать сообщения в сообществах могут только зарегистрированные пользователи.
			<br><br>
			<a href="/personal/registaration/">Зарегистрироваться</a><br><br>
			<a href="/community/group/">Читать сообщество</a><br>
			
			</div></div></div>
			<div class="clear"></div>
            <div class="cn bl"></div>
            <div class="cn br"></div>
        </div>
</div>
