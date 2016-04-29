<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//$arResult["allow_html"]="Y";?>
<div class="blog-post-edit">
<?
if(strlen($arResult["MESSAGE"])>0)
{
	?>
	<div class="blog-textinfo blog-note-box">
		<div class="blog-textinfo-text">
			<?=$arResult["MESSAGE"]?>
		</div>
	</div>
	<?
}
if(strlen($arResult["ERROR_MESSAGE"])>0)
{
	?>
	<div class="blog-errors blog-note-box blog-note-error">
		<div class="errortext">
			<?=$arResult["ERROR_MESSAGE"]?>
		</div>
	</div>
	<?
}
if(strlen($arResult["FATAL_MESSAGE"])>0)
{
	?>
	<div class="blog-errors blog-note-box blog-note-error">
		<div class="errortext">
			<?=$arResult["FATAL_MESSAGE"]?>
		</div>
		<?
		global $USER;
		if(!$USER->IsAuthorized()):?>
		<div class="top15">
			<a href="/personal/registaration/">Зарегистрироваться</a>
		</div>
		<div class="top15">
			<a href="/community/group/">Читать сообщество</a>
		</div>
		<?endif?>
	</div>
	<?
}
elseif(strlen($arResult["UTIL_MESSAGE"])>0)
{
	?>
	<div class="blog-textinfo blog-note-box">
		<div class="blog-textinfo-text">
			<?=$arResult["UTIL_MESSAGE"]?>
		</div>
		<?
		global $USER;
		if(!$USER->IsAuthorized()):?>
		<div class="top15">
			<a href="/personal/registaration/">Зарегистрироваться</a>
		</div>
		<div class="top15">
			<a href="/community/group/">Читать сообщество</a>
		</div>
		<?endif?>
	</div>
	<?
}
else
{
	?>
	<form action="<?=POST_FORM_ACTION_URI?>" name="REPLIER" class="jqtransform" id="REPLIER" method="post" enctype="multipart/form-data">
		<?=bitrix_sessid_post();?>
	
	
    <?

    // выберем все блоги где текущий пользователь входит в какую нибудь группу (является другом блога по логике битрикса)
    global $USER;
    $user_id = $USER->GetID();
    
    $dbFriends = CBlogUser::GetUserFriends($user_id, true);
    while ($arFriends = $dbFriends->Fetch())
    {
		$perms = CBlog::GetBlogUserPostPerms($arFriends["ID"], $user_id);
		//echo $perms."<br>";
		if($perms != "D" && $perms != "I"){
		if($arFriends["NAME"]=="Блог"):
			//echo $arFriends["ID"];
			$rsUser = CUser::GetByID($arFriends["OWNER_ID"]);
			if($arUser = $rsUser->Fetch()){
				$arFriends["NAME"] .= " ".$arUser["NAME"];
			}		
		endif;
        //echo "<pre>"; var_dump($arFriends); echo "</pre>";   
        $arBlogsAvailable[] = $arFriends;
		}
    }     
    
	$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
	$arFilter = Array(
			"ACTIVE" => "Y",
			"GROUP_SITE_ID" => SITE_ID,
			"OWNER_ID"=>GROUP_BLOG_USER_ID
		);	
	$arSelectedFields = array();

	$dbBlogs = CBlog::GetList(
			$SORT,
			$arFilter,
			false,
			false
			//$arSelectedFields
		);

	while ($arBlog = $dbBlogs->Fetch())
	{
		$perms = CBlog::GetBlogUserPostPerms($arBlog["ID"], $USER->GetID());
		if($perms != "D" && $perms != "I"){
			$i=0;
			foreach($arBlogsAvailable as $arBl){
				if($arBl["ID"]==$arBlog["ID"])
					$i++;
			}
			if($i==0)
				$arBlogsAvailable[] = $arBlog;
		}
	}


    // добавляем к списку свой блог
    $arBlog = CBlog::GetByOwnerID($user_id);
    if(is_array($arBlog)){	
        $arMyBlog = $arBlog;
		}
    ?>

    
	
	<?
		// Frame with file input to ajax uploading in WYSIWYG editor dialog
	if($arResult["imageUploadFrame"] == "Y")
	{
		if (!isset($_POST["blog_upload_image"]))
		{
			?>
			<html>
				<head></head>
				<body style="overflow: hidden; margin: 0!important; padding: 6px 0 0 0!important;">
				<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" style="margin: 0!important; padding: 0!important;">
				<?=bitrix_sessid_post()?>
				<input type="file" size="30" name="BLOG_UPLOAD_FILE" id="bx_lhed_blog_img_input" />
				<input type="hidden" value="Y" name="blog_upload_image"/>
				</form></body>
			</html>
			<?
		}
		else
		{
			?>
			<script>
				<?if(!empty($arResult["Image"])):?>
				var imgTable = top.BX('blog-post-image');
				if (imgTable)
				{
					imgTable.innerHTML += '<div class="blog-post-image-item"><div class="blog-post-image-item-border"><?=$arResult["ImageModified"]?></div>' +
					'<div class="blog-post-image-item-input"><input name=IMAGE_ID_title[<?=$arResult["Image"]["ID"]?>] value="<?=Cutil::JSEscape($arResult["Image"]["TITLE'"])?>"></div>' +
					'<div><input type=checkbox name=IMAGE_ID_del[<?=$arResult["Image"]["ID"]?>] id=img_del_<?=$arResult["Image"]["ID"]?>> <label for=img_del_<?=$arResult["Image"]["ID"]?>><?=GetMessage("BLOG_DELETE")?></label></div></div>';
				}

				top.arImages.push('<?=$arResult["Image"]["ID"]?>');
				window.bxBlogImageId = top.bxBlogImageId = '<?=$arResult["Image"]["ID"]?>';
				<?elseif(strlen($arResult["ERROR_MESSAGE"]) > 0):?>
					alert('<?=$arResult["ERROR_MESSAGE"]?>');
				<?endif;?>
			</script>
			<?
		}
		die();
	}
	else
	{
		// TODO: Check it!
		//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/script.php");

		if($arResult["preview"] == "Y" && !empty($arResult["PostToShow"])>0)
		{
			
			$className = "blog-post";
			$className .= " blog-post-first";
			$className .= " blog-post-alt";
			$className .= " blog-post-year-".$arResult["postPreview"]["DATE_PUBLISH_Y"];
			$className .= " blog-post-month-".IntVal($arResult["postPreview"]["DATE_PUBLISH_M"]);
			$className .= " blog-post-day-".IntVal($arResult["postPreview"]["DATE_PUBLISH_D"]);
			?>
			
			
			
			<div class="clear"></div>
		<div><label>Предварительный просмотр</label></div>
		<div class="clear"></div>
			<div id="BlogLeft">
			<div id="blog-posts-content">
			<div class="items">
			<div class="headers">
			<a href="#"><?=$arResult["postPreview"]["TITLE"]?></a>
			</div>
			 <div class="clear"></div>
			 <?
			 global $USER;
			$rsUser = CUser::GetList(
			$by, 
			$order,		
			array(			
				"ID" => $USER->GetID(),		
			),		
			array(			
				"SELECT" => 
				array(	
					"NAME",
					"LAST_NAME",
					"LOGIN",
					"PERSONAL_PHOTO",
					"UF_USER_RATING",			
					),		
				)	
			);
			$name = "";
			$foto = "";
			$rat = 0;
			if($arUser = $rsUser->Fetch())	{
				
				if(!empty($arUser["NAME"])){
					$name = $arUser["NAME"];
				}
				if(!empty($arUser["LAST_NAME"])){
					if(!empty($name)){
						$name .=" ".$arUser["LAST_NAME"];
					}
					else{
						$name =$arUser["LAST_NAME"];
					}
				}
				
				if(empty($name)) $name = $arUser["LOGIN"];
				if(intval($arUser["PERSONAL_PHOTO"])>0){
					$foto = $arUser["PERSONAL_PHOTO"];
				}
				
				$rsGender = CUserFieldEnum::GetList(array(), 
					array(			
						"ID" => $arUser["UF_USER_RATING"],		
						)
					);		
				
				if($arGender = $rsGender->GetNext())			
					$rat = $arGender["VALUE"];	

			}
			if(empty($name)){
				$name = $arResult["NAME"];
			}
			if(empty($foto)){
				$foto = SITE_TEMPLATE_PATH."/images/profile_img.png";
			}

			$arResult["LOOK_NAME"] = $name;
			$arResult["LOOK_FOTO"] = $foto;
			$arResult["RATING"] = $rat;
			 ?>
            <?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
            <a href="/community/user/<?=$USER->GetID()?>/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span> <?if($arResult["RATING"]>0):?>+<?endif;?><?=$arResult["RATING"]?>
            <div class="clear"></div>
			<div class="clear"></div>
			<?=$arResult["postPreview"]["textFormated"]?>	
			<?if(!empty($arResult["postPreview"]["Category"]))
					{
						?>
						<div class="mark">Метка:
							<?
							$i=0;
							foreach($arResult["postPreview"]["Category"] as $v)
							{
								if($i!=0)
									echo ",";
								?> <a class="grey" href="<?=$v["urlToCategory"]?>"><?=$v["NAME"]?></a><?
								$i++;
							}
							?>
						</div>
						<?
					}
					?>
			
			</div>
<div class="panel">
<div class="panelLeft"></div>
<div class="panelCenter">
<div class="ratnum">
<span id="rating-vote-BLOG_POST-111-1310636003-result" class="rating-vote-result">0</span>
</span>
</div>
<div class="date">
<?=MyFormatDate($arResult["postPreview"]["DATE_PUBLISH_DATE"])?>	</div>
<div class="share">
<a href="#" onclick="#" target="_blank" class="facebook" title="Facebook"></a>
<a href="#" onclick="#" target="_blank" class="twitter" title="Twitter"></a>
<a href="#" onclick="#" target="_blank" class="vk" title="ВКонтакте"></a>
<a href="#" onclick="#" target="_blank" class="lj" title="Livejournal"></a>
</div>
<a href="#/#addcomments" class="addcomment">Оставить комментарий</a>
<a href="#/#lookcomments" class="comment grey">комментариев нет</a>

</div>
<div class="panelRight"></div>
</div>
			</div>
			
			</div>
			<div class="clear"></div>
			<br />
			<?
		}

		?>
		
		<div><label>В какой блог публиковать</label></div>
		<div class="clear"></div>
		<div>
		<select name="selected_blog_id">
			<option value="<?=$arMyBlog["ID"]?>">Мой блог</option>
			<?foreach($arBlogsAvailable as $arBlog):?>
                <option value="<?=$arBlog["ID"]?>"<?if($arResult["Blog"]["ID"]==$arBlog["ID"]):?> selected<?endif;?>><?=$arBlog["NAME"]?></option>
            <?endforeach?>   
		</select>
		</div>
		
		<div class="clear"></div>
		<div><label>Заголовок</label></div>
		<div class="clear"></div>
		<div class="blog-edit-form blog-edit-post-form blog-post-edit-form">
		<div class="blog-post-fields blog-edit-fields">
			<div class="blog-post-field blog-post-field-title blog-edit-field blog-edit-field-title">
				<input maxlength="255" tabindex="1" type="text" name="POST_TITLE" id="POST_TITLE" value="<?=$arResult["PostToShow"]["TITLE"]?>">
				<div class="clear"></div>
				<div><?=GetMessage("BLOG_TOPIK")?></div>
				<div class="clear"></div>
			</div>
			<?
				//
				///групповые блоги
				$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
				$arFilter = Array(
						"ACTIVE" => "Y",
						"GROUP_SITE_ID" => SITE_ID,
						"OWNER_ID"=>GROUP_BLOG_OWNER_USER_ID,
						"URL" => $arResult["Blog"]["URL"]
					);	
				$arSelectedFields = array("ID", "NAME", "DESCRIPTION", "URL", "OWNER_ID", "DATE_CREATE");

				$dbBlogs = CBlog::GetList(
						$SORT,
						$arFilter,
						false,
						false,
						$arSelectedFields
					);

				while ($arBlog = $dbBlogs->Fetch())
				{
					$blog_id[] = $arBlog["ID"];
				}

				
				 
					
				$arFilter = Array(
					"PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
					"BLOG_ID"=>$blog_id
					);	

				$dbPosts = CBlogPost::GetList(
						$SORT,
						$arFilter,
						false,
						false,
						array("ID","NAME","CATEGORY_ID")
					);

				while ($arPost = $dbPosts->Fetch())
				{
					if(!empty($arPost["CATEGORY_ID"]))
						$arPost["CATEGORY_ID"] = explode(",",$arPost["CATEGORY_ID"]);
						foreach($arPost["CATEGORY_ID"] as $cat){
							$arCategory = CBlogCategory::GetByID($cat);
							if(is_array($arCategory))
								if(!in_array($arCategory["NAME"],$arResult["ITEMS"]))
									$arResult["ITEMS"][] = $arCategory["NAME"];
							
							}
				}
			?>
			<?
				if(count($arResult["ITEMS"])>0):
				?>
			<div><label>Рубрики</label></div>
			<div class="clear"></div>
			<?global $USER;?>
			<div class="rubricks">
			
				<table class="rubric">
				<?
				$j=0;
				$h = 0;
				foreach($arResult["ITEMS"] as $k=>$v){
					if($j==0) {echo "<tr>";}
					?>
						<td><input type="checkbox" id='rub<?=$h?>' class="rubric_ch" name="rubric[]" value="<?=$v?>"><label for='rub<?=$h?>'><?=$v?></label>
						<div class="clear"></div>
						</td>
					<?
					$h++;
					if($j==2) {echo "</tr>"; $j=0;}
				}
				?>
				</table>
				
			
			</div>
			<div class="clear"></div>
			<div class="top25"></div>
			<?
				endif;
			?>
		<div class="blog-post-message blog-edit-editor-area blog-edit-field-text">
			<div class="blog-comment-field blog-comment-field-bbcode">
				
				<?if($arResult["allow_html"] == "Y")
				{
				if($arResult["allow_html"] == "Y" && (($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] == "html" && $_REQUEST["load_editor"] != "N") || $_REQUEST["load_editor"] == "Y"))
					?>
					<input type="radio" id="blg-text-text" name="POST_MESSAGE_TYPE" value="text"<?if($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] != "html" || $_REQUEST["load_editor"] == "N") echo " checked";?> onclick="window.location.href='<?=CUtil::JSEscape($APPLICATION->GetCurPageParam("load_editor=N", Array("load_editor")))?>';"> <label for="blg-text-text">Text</label> <span style="float:left; margin-top:6px;">/</span> <input type="radio" id="blg-text-html" name="POST_MESSAGE_TYPE" value="html"<?if(($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] == "html" && $_REQUEST["load_editor"] != "N") || $_REQUEST["load_editor"] == "Y") echo " checked";?> onclick="window.location.href='<?=CUtil::JSEscape($APPLICATION->GetCurPageParam("load_editor=Y", Array("load_editor")))?>';"> <label for="blg-text-html">HTML</label>
					<div class="clear"></div>
				<?
				}
				
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lhe.php");
				?>
			</div>
			
			<br />
			<div class="blog-post-field blog-post-field-images blog-edit-field" id="blog-post-image">
			<?
			if (!empty($arResult["Images"]))
			{
				?><div><?=GetMessage("BLOG_P_IMAGES")?></div><?
				foreach($arResult["Images"] as $aImg)
				{
					?>
						<div class="blog-post-image-item">
							<div class="blog-post-image-item-border"><?=$aImg["FileShow"]?></div>

								<div class="blog-post-image-item-input">
									<input name="IMAGE_ID_title[<?=$aImg["ID"]?>]" value="<?=$aImg["TITLE"]?>" title="<?=GetMessage("BLOG_BLOG_IN_IMAGES_TITLE")?>">
								</div>
								<div>
									<input class="fl" type="checkbox" name="IMAGE_ID_del[<?=$aImg["ID"]?>]" id="img_del_<?=$aImg["ID"]?>"> <label for="img_del_<?=$aImg["ID"]?>"><?=GetMessage("BLOG_DELETE")?></label>
								</div>

						</div>
					<?
				}
			}
			?>
			</div>
		</div>
		<div class="blog-clear-float"></div>
		<div class="clear"></div>
		<?if ($USER->IsAdmin()):?>
		<div class="blog-post-field blog-post-field-category blog-edit-field blog-edit-field-tags">
			
			<div class="blog-post-field-text">
			<label for="TAGS" class="blog-edit-field-caption">Создать рубрики</label>
			</div>
			<div class="clear"></div>
			<span><?
					if(IsModuleInstalled("search"))
					{
						$arSParams = Array(
							"NAME"	=>	"TAGS",
							"VALUE"	=>	$arResult["PostToShow"]["CategoryText"],
							"arrFILTER"	=>	"blog",
							"PAGE_ELEMENTS"	=>	"10",
							"SORT_BY_CNT"	=>	"Y",
							"TEXT" => 'tabindex="3"'
							);
						if($arResult["bSoNet"] && $arResult["bGroupMode"])
						{
							$arSParams["arrFILTER"] = "socialnetwork";
							$arSParams["arrFILTER_socialnetwork"] = $arParams["SOCNET_GROUP_ID"];
						}
						$APPLICATION->IncludeComponent("bitrix:search.tags.input", ".default", $arSParams);
					}
					else
					{
						?><input type="text" id="TAGS" tabindex="3" name="TAGS"  value="<?=$arResult["PostToShow"]["CategoryText"]?>">
						<?
					}?>
			</span>	
			
		</div>
		<div class="clear"></div>
		<div>
		Рубрики нужно разделять запятой. Например: общение, социальные сети, myspace.com, подростки
		</div>
		<div class="blog-clear-float"></div>
		<div class="clear"></div>
		<div class="top25"></div>
		<?endif;?>
		<div class="blog-post-buttons blog-edit-buttons commentForm">
			<div class="leftTR"></div>
			<div class="leftBR"></div>
			<div class="rightTR"></div>
			<div class="rightBR"></div>
			<input type="hidden" name="save" value="Y">
			<input tabindex="4" type="submit" name="save" value="<?=GetMessage("BLOG_PUBLISH")?>">
			<input type="hidden" name="save" value="Y">

			<input type="submit" name="preview" class="preview" value="<?=GetMessage("BLOG_PREVIEW")?>">

		</div>
		</div>
		</form>

		<script>
		<!--
		document.REPLIER.POST_TITLE.focus();
		//-->
		</script>
		</div>
		<?
	}
}
	
?>
</div>