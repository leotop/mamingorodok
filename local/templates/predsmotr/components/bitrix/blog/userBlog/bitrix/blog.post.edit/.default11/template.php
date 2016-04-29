<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

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
		<div class="blog-error-text">
			<?=$arResult["ERROR_MESSAGE"]?>
		</div>
	</div>
	<?
}
if(strlen($arResult["FATAL_MESSAGE"])>0)
{
	?>
	<div class="blog-errors blog-note-box blog-note-error">
		<div class="blog-error-text">
			<?=$arResult["FATAL_MESSAGE"]?>
		</div>
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
	</div>
	<?
}
else
{
	?>
	<form action="<?=POST_FORM_ACTION_URI?>" name="REPLIER" class="jqtransform" id="REPLIER" method="post" enctype="multipart/form-data">
		<?=bitrix_sessid_post();?>
<!--	<div><label>� ����� ���� �����������</label></div>
	<div class="clear"></div>
	<div>
		<select>
			<option>������������ �����������</option>
			<option>��� ����</option>
		</select>
	</div>-->
	
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
		<div><label>��������������� ��������</label></div>
		<div class="clear"></div>
			<div id="BlogLeft">
			<div id="blog-posts-content">
			<div class="items">
			<div class="headers">
			<a href="#"><?=$arResult["postPreview"]["TITLE"]?></a>
			</div>
			<div class="clear"></div>
			<?=$arResult["postPreview"]["textFormated"]?>	
			<?if(!empty($arResult["postPreview"]["Category"]))
					{
						?>
						<div class="mark">�����:
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
<a href="#" onClick="#" target="_blank" class="facebook" title="Facebook"></a>
<a href="#" onClick="#" target="_blank" class="twitter" title="Twitter"></a>
<a href="#" onClick="#" target="_blank" class="vk" title="���������"></a>
<a href="#" onClick="#" target="_blank" class="lj" title="Livejournal"></a>
</div>
<a href="#/#addcomments" class="addcomment">�������� �����������</a>
<a href="#/#lookcomments" class="comment grey">������������ ���</a>

</div>
<div class="panelRight"></div>
</div>
			</div>
			
			</div>
			<br />
			<?
		}

		?>
		<div class="clear"></div>
		<div><label>���������</label></div>
		<div class="clear"></div>
		<div class="blog-edit-form blog-edit-post-form blog-post-edit-form">
		<div class="blog-post-fields blog-edit-fields">
			<div class="blog-post-field blog-post-field-title blog-edit-field blog-edit-field-title">
				<input maxlength="255" tabindex="1" type="text" name="POST_TITLE" id="POST_TITLE" value="<?=$arResult["PostToShow"]["TITLE"]?>">
				<div class="clear"></div>
				<div><?=GetMessage("BLOG_TOPIK")?></div>
				<div class="clear"></div>
			</div>
			
			<div class="top25"></div>

		<div class="blog-post-message blog-edit-editor-area blog-edit-field-text">
			<div class="blog-comment-field blog-comment-field-bbcode">
				<?if($arResult["allow_html"] == "Y")
				{
				if($arResult["allow_html"] == "Y" && (($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] == "html" && $_REQUEST["load_editor"] != "N") || $_REQUEST["load_editor"] == "Y"))
					?>
					<input type="radio" id="blg-text-text" name="POST_MESSAGE_TYPE" value="text"<?if($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] != "html" || $_REQUEST["load_editor"] == "N") echo " checked";?> onClick="window.location.href='<?=CUtil::JSEscape($APPLICATION->GetCurPageParam("load_editor=N", Array("load_editor")))?>';"> <label for="blg-text-text">Text</label> / <input type="radio" id="blg-text-html" name="POST_MESSAGE_TYPE" value="html"<?if(($arResult["PostToShow"]["DETAIL_TEXT_TYPE"] == "html" && $_REQUEST["load_editor"] != "N") || $_REQUEST["load_editor"] == "Y") echo " checked";?> onClick="window.location.href='<?=CUtil::JSEscape($APPLICATION->GetCurPageParam("load_editor=Y", Array("load_editor")))?>';"> <label for="blg-text-html">HTML</label>
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
									<input type="checkbox" name="IMAGE_ID_del[<?=$aImg["ID"]?>]" id="img_del_<?=$aImg["ID"]?>"> <label for="img_del_<?=$aImg["ID"]?>"><?=GetMessage("BLOG_DELETE")?></label>
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
		<div class="blog-post-field blog-post-field-category blog-edit-field blog-edit-field-tags">
			<div class="blog-post-field-text">
			<label for="TAGS" class="blog-edit-field-caption"><?=GetMessage("BLOG_CATEGORY")?></label>
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
		����� ����� ��������� �������. ��������: �������, ���������� ����, myspace.com, ���������
		</div>
		<div class="blog-clear-float"></div>
		<div class="clear"></div>
		<div class="top25"></div>

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