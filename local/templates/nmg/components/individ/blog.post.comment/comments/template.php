<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="comments_head" id="lookcomments">
<?$GLOBALS["NUM_COMMENTS"] = $arResult["Post"]["NUM_COMMENTS"]?>
<?if (intval($arResult["Post"]["NUM_COMMENTS"])>0):?>
<span class="how_commets">
    <a href="" class="comment_tree"></a>
    <a href="" class="comment_list"></a>
</span>
<?endif;?>
<div class="clear"></div>
</div>
<?if (intval($arResult["Post"]["NUM_COMMENTS"])>0):?>
<div class="comments">
<?else:?>
<div class="comments <?if(isset($_REQUEST["preview"])){?>hide<?}?>">
<?endif?>
<?
include_once(dirname(__FILE__)."/script.php");

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
else
{
	?>
	<div id="form_comment_" style="display:none;">
		<div id="form_c_del">
		<?if($arResult["Post"]["ENABLE_COMMENTS"]=="Y"):?>
		<div class="clear"></div>
		<div class="top15"></div>
		<div class="commentForm" >
		<div class="leftTR"></div>
		<div class="leftBR"></div>
		<div class="rightTR"></div>
		<div class="rightBR"></div>
		<div class="title">Добавить свой комментарий</div>
		<div class="clear"></div>
		<div class="top15"></div>

		<?if(empty($arResult["User"]) && $USER->IsAuthorized()):?>
		<?
			$name = "";
			$name = $USER->GetFullName();
			if(empty($name))
				$name = $USER->GetLogin();
			?>
		<div class="info">Вы вошли как <a href="/personal/profile/"><?=$name?></a>. <a href="?logout=yes" class="grey">Выйти?</a> </div>
		<div class="clear"></div>
		<?endif;?>
        <div>
		<form method="POST" class="jqtransform" name="form_comment" id="form_comment" action="<?=POST_FORM_ACTION_URI?>">

		<input type="hidden" name="parentId" id="parentId" value="">
		<input type="hidden" name="edit_id" id="edit_id" value="">
		<input type="hidden" name="act" id="act" value="add">
		<input type="hidden" name="post" value="Y">
		<?=bitrix_sessid_post()?>

		<div class="blog-comment-fields">
			<?
			if(empty($arResult["User"]))
			{
				?>
				<div class="clear"></div>
				<div class="top15"></div>

				<table>
					<tr><td width="100px">
					 <label for="user_name"><?=GetMessage("B_B_MS_NAME")?></label>
					 <span class="blog-required-field">*</span>
					</td><td>
						<input maxlength="255" style="width:300px;" tabindex="3" type="text" name="user_name" id="user_name" value="<?=htmlspecialcharsEx($_SESSION["blog_user_name"])?>">
					</td></tr>
					<tr><td>
					<div class="top15"></div>
					 <label for="">E-mail</label>
					 <span class="blog-required-field">*</span>
					</td><td>
					<div class="top15"></div>
						<input maxlength="255" style="width:300px;" tabindex="4" type="text" name="user_email" id="user_email" value="<?=htmlspecialcharsEx($_SESSION["blog_user_email"])?>">
					</td></tr>
				</table>

					<div class="top15"></div>
					<div class="clear"></div>
				<?
			}
			?>
			<div class="">
				 <textarea style="width:640px; height:150px; margin-left:5px;" tabindex="6" id="comment"  name="comment"></textarea>
				<div class="clear"></div>
			</div>
			<?
			if($arResult["use_captcha"]===true)
			{
				?>
				<div class="blog-comment-field blog-comment-field-captcha">
					<div class="blog-comment-field-captcha-label">
						<label for=""><?=GetMessage("B_B_MS_CAPTCHA_SYM")?></label><span class="blog-required-field">*</span><br>
						<input type="hidden" name="captcha_code" id="captcha_code" value="<?=$arResult["CaptchaCode"]?>">
						<input type="text" size="30" name="captcha_word" id="captcha_word" value=""  tabindex="7">
						</div>
					<div class="blog-comment-field-captcha-image"><div id="div_captcha"></div></div>
				</div>
				<?
			}
			?>

			<div class="blog-comment-buttons">
				<div class="top15"></div>
				<input tabindex="10" type="submit" class="purple fll"  name="post" value="Добавить комментарий">
					<input type="hidden" name="post" value="Добавить комментарий">
            </div>
            <div class="clear"></div>

		</div>
		</form>
		</div>
		</div>
		<?endif;?>
	</div>
	</div>

	<?
	if($arResult["use_captcha"]===true)
	{
		?>
		<div id="captcha_del">
		<script>
			<!--
			var cc;
			if(document.cookie.indexOf('<?echo session_name()?>'+'=') == -1)
				cc = Math.random();
			else
				cc ='<?=$arResult["CaptchaCode"]?>';

			document.write('<img src="/bitrix/tools/captcha.php?captcha_code='+cc+'" width="180" height="40" id="captcha" style="display:none;" onload="imageLoaded()">');
			document.getElementById('captcha_code').value = cc;
			//-->
		</script>
		</div>
		<?
	}
	?>
	<?
	function ShowComment($comment, $tabCount=0, $tabSize=2.5, $canModerate=false, $User=Array(), $use_captcha=false, $bCanUserComment=false, $errorComment=false, $arParams = array())
	{
        //arshow($comment);
        if($comment["SHOW_AS_HIDDEN"] == "Y" || $comment["PUBLISH_STATUS"] == BLOG_PUBLISH_STATUS_PUBLISH || $comment["SHOW_SCREENNED"] == "Y" || $comment["ID"] == "preview")
		{
			$tabCount = IntVal($tabCount);
			if($tabCount <= 5)
				$paddingSize = 2.5 * $tabCount;
			elseif($tabCount > 5 && $tabCount <= 10)
				$paddingSize = 2.5 * 5 + ($tabCount - 5) * 1.5;
			elseif($tabCount > 10 && $tabCount <=22)
				$paddingSize = 2.5 * 5 + 1.5 * 5 + ($tabCount-10) * 1;
            elseif($tabCount > 22)
                $paddingSize = 2.5 * 5 + 1.5 * 5 + 12;

            $padding_top=($tabCount==0)?1.5:0;
			?>

            <?if($comment["PUBLISH_STATUS"] == BLOG_PUBLISH_STATUS_PUBLISH || $comment["SHOW_SCREENNED"] == "Y" || $comment["ID"] == "preview")
            {
                $aditStyle = "";
                /*if($arParams["is_ajax_post"] == "Y" || $comment["NEW"] == "Y")
                    $aditStyle .= " blog-comment-new";
                if($comment["AuthorIsAdmin"] == "Y")
                    $aditStyle = " blog-comment-admin";
                if(IntVal($comment["AUTHOR_ID"]) > 0)
                    $aditStyle .= " blog-comment-user-".IntVal($comment["AUTHOR_ID"]);
                if($comment["AuthorIsPostAuthor"] == "Y")
                    $aditStyle .= " blog-comment-author"; */
                if($comment["PUBLISH_STATUS"] != BLOG_PUBLISH_STATUS_PUBLISH && $comment["ID"] != "preview")
                    $aditStyle .= " blog-comment-hidden";
                /*if($comment["ID"] == "preview")
                    $aditStyle .= " blog-comment-preview";*/
            ?>


			<a name="<?=$comment["ID"]?>"></a>
			<div class="blog-comment comment top15<?=$aditStyle?>" style="padding-left:<?=$paddingSize?>em;padding-top:<?=$padding_top?>em;">
				<div class="head">
					<?if(isset($comment["arUser"]["PERSONAL_PHOTO"]) && $comment["arUser"]["PERSONAL_PHOTO"]>0):?>
						<?=CFile::ShowImage($comment["arUser"]["PERSONAL_PHOTO"], 42, 42, "border=0 class='foto'", "", true); ?>
					<?else:?>
						<?=CFile::ShowImage(SITE_TEMPLATE_PATH."/images/profile_img.png", 42, 42, "border=0 class='foto'", "", true); ?>
					<?endif;?>
					<?$name = "";?>
					<?if(!empty($comment["AuthorName"])) $name = $comment["AuthorName"];?>
					<?if(empty($name)) $name = $comment["arUser"]["LOGIN"];?>

					<a href="/community/user/<?=$comment["arUser"]["ID"]?>/" class="boldLink"><?=$name?></a>
					<span class="date">
						<?
						if(!empty($comment["DATE_CREATE"])):
						$mas = explode(" ",$comment["DATE_CREATE"]);
						if(isset($mas[0])):
						?>
						<?=MyFormatDate($mas[0], false);?>,
						<?endif;
						if(isset($mas[1]) && !empty($mas[1])):
							$mas = explode(":",$mas[1]);
							if(isset($mas[0]) && isset($mas[1]) && !empty($mas[1]) && !empty($mas[0])):
						?>
								<?=$mas[0].":".$mas[1]?>
						<?	endif;
						endif;?>
						<?endif;?>
					</span>
					<div class="rat">
					<?
                    $GLOBALS["APPLICATION"]->IncludeComponent(
                        "individ:rating.vote", "blog",
                        Array(
                            "ENTITY_TYPE_ID" => "BLOG_COMMENT",
                            "ENTITY_ID" => $comment["ID"],
                            "OWNER_ID" => $comment["arUser"]["ID"],
                            "USER_HAS_VOTED" => $arParams["RATING"][$comment["ID"]]["USER_HAS_VOTED"],
                            "TOTAL_VOTES" => $arParams["RATING"][$comment["ID"]]["TOTAL_VOTES"],
                            "TOTAL_POSITIVE_VOTES" => $arParams["RATING"][$comment["ID"]]["TOTAL_POSITIVE_VOTES"],
                            "TOTAL_NEGATIVE_VOTES" => $arParams["RATING"][$comment["ID"]]["TOTAL_NEGATIVE_VOTES"],
                            "TOTAL_VALUE" => $arParams["RATING"][$comment["ID"]]["TOTAL_VALUE"]
                        ),
                        null,
                        array("HIDE_ICONS" => "Y")
                    );?>
					</div>
					</div>
					<div class="text"><?=$comment["TextFormated"]?>
					<div class="clear"></div>

					<?
					if($bCanUserComment===true)
					{
						?>
						<a class="boldLink" href="javascript:void(0)" onclick="return showComment('<?=$comment["ID"]?>', '<?=$comment["CommentTitle"]?>', '', '', '', '')" class="str_bottom"><?=GetMessage("B_B_MS_REPLY")?></a>
						<?
					}

					?>
					<?
					if($comment["CAN_EDIT"] == "Y")
					{
						$Text = CUtil::JSEscape($comment["~POST_TEXT"]);
						$Title = CUtil::JSEscape($comment["TITLE"]);
						?>
						<script>
						<!--
						var cmt<?=$comment["ID"]?> = '<?=$Text?>';
						//-->
						</script>
						<a class="boldLink" href="javascript:void(0)" onclick="return editComment('<?=$comment["ID"]?>', '<?=$Title?>', cmt<?=$comment["ID"]?>)"><?=GetMessage("BPC_MES_EDIT")?></a>
						<?
					}
                    if(strlen($comment["urlToShow"])>0)
                    {
                        ?>
                        <span class="blog-vert-separator"></span>
                        <span class="blog-comment-show">
                            <?if($arParams["AJAX_POST"] == "Y"):?>
                                <a class="boldLink" href="javascript:void(0)" onclick="return hideShowComment('<?=$comment["urlToShow"]."&".bitrix_sessid_get()?>', '<?=$comment["ID"]?>');" title="<?=GetMessage("BPC_MES_SHOW")?>">
                            <?else:?>
                                <a class="boldLink" href="<?=$comment["urlToShow"]."&".bitrix_sessid_get()?>" title="<?=GetMessage("BPC_MES_SHOW")?>">
                            <?endif;?>
                            <?=GetMessage("BPC_MES_SHOW")?></a></span>
                        <?
                    }
                    if(strlen($comment["urlToHide"])>0)
                    {
                        ?>
                        <span class="blog-vert-separator"></span>
                        <span class="blog-comment-show">
                            <?if($arParams["AJAX_POST"] == "Y"):?>
                                <a class="boldLink" href="javascript:void(0)" onclick="return hideShowComment('<?=$comment["urlToHide"]."&".bitrix_sessid_get()?>', '<?=$comment["ID"]?>');" title="<?=GetMessage("BPC_MES_HIDE")?>">
                            <?else:?>
                                <a class="boldLink" href="<?=$comment["urlToHide"]."&".bitrix_sessid_get()?>" title="<?=GetMessage("BPC_MES_HIDE")?>">
                            <?endif;?>
                            <?=GetMessage("BPC_MES_HIDE")?></a></span>
                        <?
                    }

					if(strlen($comment["urlToDelete"])>0)
					{
						?>
						<a class="boldLink" href="javascript:if(confirm('<?=GetMessage("BPC_MES_DELETE_POST_CONFIRM")?>')) window.location='<?=$comment["urlToDelete"]."&".bitrix_sessid_get()?>'"><?=GetMessage("BPC_MES_DELETE")?></a>
						<?
					}
					?>


					</div>


				<?
				if(strlen($errorComment) <= 0 && strlen($_POST["preview"]) > 0 && (IntVal($_POST["parentId"]) > 0 || IntVal($_POST["id"]) > 0)
					&& ( (IntVal($_POST["parentId"])==$comment["ID"] && IntVal($_POST["id"]) <= 0)
						|| (IntVal($_POST["id"]) > 0 && IntVal($_POST["id"]) == $comment["ID"] && $comment["CAN_EDIT"] == "Y")))
				{
					?><div style="border:1px solid red"><?
						$commentPreview = Array(
								"ID" => "preview",
								"TitleFormated" => htmlspecialcharsEx($_POST["subject"]),
								"TextFormated" => $_POST["commentFormated"],
								"AuthorName" => $User["NAME"],
								"DATE_CREATE" => GetMessage("B_B_MS_PREVIEW_TITLE"),
							);
						ShowComment($commentPreview, (IntVal($_POST["id"]) == $comment["ID"] && $comment["CAN_EDIT"] == "Y") ? $level : ($level+1), 2.5, false, Array(), false, false, false, $arParams);
					?></div><?
				}

				if(strlen($errorComment)>0 && $bCanUserComment===true
					&& (IntVal($_POST["parentId"])==$comment["ID"] || IntVal($_POST["id"]) == $comment["ID"]))
				{
					?>
					<div class="blog-errors blog-note-box blog-note-error">
						<div class="blog-error-text">
							<?=$errorComment?>
						</div>
					</div>
					<?
				}
				?>
				</div>
				<div id="form_comment_<?=$comment['ID']?>"></div>

				<?
				if((strlen($errorComment) > 0 || strlen($_POST["preview"]) > 0)
					&& (IntVal($_POST["parentId"])==$comment["ID"] || IntVal($_POST["id"]) == $comment["ID"])
					&& $bCanUserComment===true)
				{
					$form1 = CUtil::JSEscape($_POST["comment"]);
					$subj = CUtil::JSEscape($_POST["subject"]);
					$user_name = CUtil::JSEscape($_POST["user_name"]);
					$user_email = CUtil::JSEscape($_POST["user_email"]);
					?>
					<script>
					<!--
					var cmt = '<?=$form1?>';
					<?
					if(IntVal($_POST["id"]) == $comment["ID"])
					{
						?>
						editComment('<?=$comment["ID"]?>', '<?=$subj?>', cmt);
						<?
					}
					else
					{
						?>
						showComment('<?=$comment["ID"]?>', '<?=$subj?>', 'Y', cmt, '<?=$user_name?>', '<?=$user_email?>');
						<?
					}
					?>
					//-->
					</script>
					<?
				}
            }
			}
			elseif($comment["SHOW_AS_HIDDEN"] == "Y")
				echo "<b>".GetMessage("BPC_HIDDEN_COMMENT")."</b>";
			?>

			<?

	}

	function RecursiveComments($sArray, $key, $level=0, $first=false, $canModerate=false, $User, $use_captcha, $bCanUserComment, $errorComment, $arSumComments, $arParams)
	{
		if(!empty($sArray[$key]))
		{
			foreach($sArray[$key] as $comment)
			{
				if(!empty($arSumComments[$comment["ID"]]))
				{
					$comment["CAN_EDIT"] = $arSumComments[$comment["ID"]]["CAN_EDIT"];
					$comment["SHOW_AS_HIDDEN"] = $arSumComments[$comment["ID"]]["SHOW_AS_HIDDEN"];
					$comment["SHOW_SCREENNED"] = $arSumComments[$comment["ID"]]["SHOW_SCREENNED"];
				}
				ShowComment($comment, $level, 2.5, $canModerate, $User, $use_captcha, $bCanUserComment, $errorComment, $arParams);
				if(!empty($sArray[$comment["ID"]]))
				{
					foreach($sArray[$comment["ID"]] as $key1)
					{
						if(!empty($arSumComments[$key1["ID"]]))
						{
							$key1["CAN_EDIT"] = $arSumComments[$key1["ID"]]["CAN_EDIT"];
							$key1["SHOW_AS_HIDDEN"] = $arSumComments[$key1["ID"]]["SHOW_AS_HIDDEN"];
							$key1["SHOW_SCREENNED"] = $arSumComments[$key1["ID"]]["SHOW_SCREENNED"];
						}
						ShowComment($key1, ($level+1), 2.5, $canModerate, $User, $use_captcha, $bCanUserComment, $errorComment, $arParams);

						if(!empty($sArray[$key1["ID"]]))
						{
							RecursiveComments($sArray, $key1["ID"], ($level+2), false, $canModerate, $User, $use_captcha, $bCanUserComment, $errorComment, $arSumComments, $arParams);
						}
					}
				}
				if($first)
					$level=0;
			}
		}
	}
	?>
	<?
	if($arResult["CanUserComment"])
	{
		$postTitle = "";
		if($arParams["NOT_USE_COMMENT_TITLE"] != "Y")
			$postTitle = "RE: ".CUtil::JSEscape($arResult["Post"]["TITLE"]);

		/*?>
		<div class="blog-add-comment"><a name="comments"></a><a href="javascript:void(0)" onclick="return showComment('0', '<?=$postTitle?>')"><b><?=GetMessage("B_B_MS_ADD_COMMENT")?></b></a><br /></div>
		<a name="0"></a>
		<? */
		if(strlen($arResult["COMMENT_ERROR"]) <= 0 && strlen($_POST["parentId"]) < 2
			&& IntVal($_POST["parentId"])==0 && strlen($_POST["preview"]) > 0 && IntVal($_POST["id"]) <= 0)
		{
			?><div style="border:1px solid red"><?
				$commentPreview = Array(
						"ID" => "preview",
						"TitleFormated" => htmlspecialcharsEx($_POST["subject"]),
						"TextFormated" => $_POST["commentFormated"],
						"AuthorName" => $arResult["User"]["NAME"],
						"DATE_CREATE" => GetMessage("B_B_MS_PREVIEW_TITLE"),
					);
				ShowComment($commentPreview, 0, 2.5, false, $arResult["User"], $arResult["use_captcha"], $arResult["CanUserComment"], false, $arParams);
			?></div><?
		}

		if(strlen($arResult["COMMENT_ERROR"]) > 0 && strlen($_POST["parentId"]) < 2
			&& IntVal($_POST["parentId"])==0 && IntVal($_POST["id"]) <= 0)
		{
			?>
			<div class="blog-errors blog-note-box blog-note-error">
				<div class="blog-error-text"><?=$arResult["COMMENT_ERROR"]?></div>
			</div>
			<?
		}
		?>
		<div id=form_comment_0_></div>
		<?
		if((strlen($arResult["COMMENT_ERROR"])>0 || strlen($_POST["preview"]) > 0)
			&& IntVal($_POST["parentId"]) == 0 && strlen($_POST["parentId"]) < 2 && IntVal($_POST["id"]) <= 0)
		{
			$form1 = CUtil::JSEscape($_POST["comment"]);

			$subj = CUtil::JSEscape($_POST["subject"]);
			$user_name = CUtil::JSEscape($_POST["user_name"]);
			$user_email = CUtil::JSEscape($_POST["user_email"]);

			?>
			<script>
			<!--
			var cmt = '<?=$form1?>';
			showComment('0', '<?=$subj?>', 'Y', cmt, '<?=$user_name?>', '<?=$user_email?>');
			//-->
			</script>
			<?
		}

		if($arResult["NEED_NAV"] == "Y")
		{
			?>
			<div class="blog-comment-nav">
				<?=GetMessage("BPC_PAGE")?>&nbsp;<?
				foreach($arResult["PAGES"] as $v)
				{
					echo $v;
				}


			?>
			</div>
			<?
		}
	}

	$arParams["RATING"] = $arResult["RATING"];
	RecursiveComments($arResult["CommentsResult"], $arResult["firstLevel"], 0, true, $arResult["canModerate"], $arResult["User"], $arResult["use_captcha"], $arResult["CanUserComment"], $arResult["COMMENT_ERROR"], $arResult["Comments"], $arParams);

	if($arResult["NEED_NAV"] == "Y")
	{
		?>
		<div class="blog-comment-nav">
			<?=GetMessage("BPC_PAGE")?>&nbsp;<?
			foreach($arResult["PAGES"] as $v)
			{
				echo $v;
			}


		?>
		</div>
		<?
	}

	if($arResult["CanUserComment"] && count($arResult["Comments"])>2)
	{
		// КОММЕНТАРИИ???
        /*?>
		<div class="blog-add-comment"><a href="#comments" onclick="return showComment('00', '<?=$postTitle?>')"><b><?=GetMessage("B_B_MS_ADD_COMMENT")?></b></a><br /></div><a name="00"></a>
		<?    */
		if(strlen($arResult["COMMENT_ERROR"]) <= 0 && $_POST["parentId"] == "00" && strlen($_POST["parentId"]) > 1 && strlen($_POST["preview"]) > 0)
		{
			?><div style="border:1px solid red"><?
				$commentPreview = Array(
						"ID" => "preview",
						"TitleFormated" => htmlspecialcharsEx($_POST["subject"]),
						"TextFormated" => $_POST["commentFormated"],
						"AuthorName" => $arResult["User"]["NAME"],
						"DATE_CREATE" => GetMessage("B_B_MS_PREVIEW_TITLE"),
					);
				ShowComment($commentPreview, 0, 2.5, false, $arResult["User"], $arResult["use_captcha"], $arResult["CanUserComment"], $arResult["COMMENT_ERROR"], $arParams);
			?></div><?
		}

		if(strlen($arResult["COMMENT_ERROR"])>0 && $_POST["parentId"] == "00" && strlen($_POST["parentId"]) > 1)
		{
			?>
			<div class="blog-errors blog-note-box blog-note-error">
				<div class="blog-error-text">
					<?=$arResult["COMMENT_ERROR"]?>
				</div>
			</div>
			<?
		}
		?>

		<div id=form_comment_00></div><br />

		<?
		if((strlen($arResult["COMMENT_ERROR"])>0 || strlen($_POST["preview"]) > 0)
			&& $_POST["parentId"] == "00" && strlen($_POST["parentId"]) > 1)
		{
			$form1 = CUtil::JSEscape($_POST["comment"]);
			$subj = CUtil::JSEscape($_POST["subject"]);
			$user_name = CUtil::JSEscape($_POST["user_name"]);
			$user_email = CUtil::JSEscape($_POST["user_email"]);
			?>
			<script>
			<!--
			var cmt = '<?=$form1?>';
			showComment('00', '<?=$subj?>', 'Y', cmt, '<?=$user_name?>', '<?=$user_email?>');
			//-->
			</script>
			<?
		}
	}
	?>
	<a name="fcomment"></a>
	<div id=form_comment_0></div>
	<?
}
?>
	<?if($arResult["Post"]["ENABLE_COMMENTS"]=="Y"):?>
        <div style="display:block;">
		<div class="clear"></div>
		<div class="top15"></div>
		<div class="commentForm" id="addcomments">
		<div class="leftTR"></div>
		<div class="leftBR"></div>
		<div class="rightTR"></div>
		<div class="rightBR"></div>
		<div class="title dfgfdsdf">Добавить свой комментарий</div>
		<?//print_R($arResult["User"])?>
			<?
			$name = "";
			$name = $USER->GetFullName();
			if(empty($name))
				$name = $USER->GetLogin();
			?>

		<?if(!empty($arResult["User"]) && $USER->IsAuthorized()):?>
		<div class="info">Вы вошли как <a href="/personal/profile/"><?=$name?></a>. <a href="?logout=yes" class="grey">Выйти?</a> </div>
		<div class="clear"></div>
		<?endif;?>
        <div>
        <div class="blog-comment-form">

        <form method="POST" class="jqtransform" name="form_comment2" id="form_comment2" action="<?=POST_FORM_ACTION_URI?>">
        <input type="hidden" name="parentId" id="parentId" value="">
        <input type="hidden" name="edit_id" id="edit_id" value="">
        <input type="hidden" name="act" id="act" value="add">
        <input type="hidden" name="post" value="Y">
        <?=bitrix_sessid_post()?>
        <?//print_R($arResult);?>
        <div class="blog-comment-fields">
	        <div class="user_i_field">
	         <input type="text" name="user_eml" value="" class="" />
		      </div>
            <?
            if(empty($arResult["User"]) && !$USER->IsAuthorized() )
            {
                ?>
				<div class="clear"></div>
				<div class="top15"></div>

				<table>
					<tr><td width="120px">
					 <label for="user_name" class="dfgfdsdf"><?=GetMessage("B_B_MS_NAME")?> <span class="blog-required-field">*</span></label>

					</td><td>
						<input maxlength="255" style="width:300px;" tabindex="3" type="text" name="user_name" id="user_name" value="<?=htmlspecialcharsEx($_SESSION["blog_user_name"])?>">
					</td></tr>
					<?/*<tr><td>
					<div class="top15"></div>
					 <label for="">E-mail</label>
					 <span class="blog-required-field">*</span>
					</td><td>
					<div class="top15"></div>
						<input maxlength="255" style="width:300px;" tabindex="4" type="text" name="user_email" id="user_email" value="<?=htmlspecialcharsEx($_SESSION["blog_user_email"])?>">
					</td></tr>*/?>
				</table>

					<div class="top15"></div>
					<div class="clear"></div>
                <?
            }
            ?>

            <div class="blog-comment-field blog-comment-field-text blog-comment-field-content">
                <textarea style="width:640px; height:150px; margin-left:5px;" tabindex="6" id="comment" name="comment"></textarea>
				<div class="clear"></div>
            </div>
			<div class="clear"></div>
            <?
            if($arResult["use_captcha"]===true)
            {
                ?>
                <div class="blog-comment-field blog-comment-field-captcha">
					<div class="clear"></div>
					<div class="top15"></div>
                        <label for="" class="sdfsdfsdf"><?=GetMessage("B_B_MS_CAPTCHA_SYM")?> <span class="blog-required-field">*</span></label><br>
                        <input type="hidden" name="captcha_code" id="captcha_code" value="<?=$arResult["CaptchaCode"]?>">
						<div class="clear"></div>

                    <div class="blog-comment-field-captcha-image dfgfdsdf">
					<table>
						<tr>
						<td>
							<img src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CaptchaCode"]?>" alt="<?=GetMessage("F_CAPTCHA_TITLE")?>" />
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<input type="text" size="30" name="captcha_word" id="captcha_word" value=""  tabindex="7">
						</td>
						</tr>
					</table>
					</div>
                </div>
                <?
            }
            ?>

            <div class="blog-comment-buttons">
				<div class="top15"></div>
				<input tabindex="10" type="submit" class="purple fll"  name="post" value="Добавить комментарий">
				<input type="hidden" name="post" value="Добавить комментарий">
            </div>
            <div class="clear"></div>
        </div>
        </form>
        </div>
		</div>
    </div>
    </div>
    <?endif;?>
</div>