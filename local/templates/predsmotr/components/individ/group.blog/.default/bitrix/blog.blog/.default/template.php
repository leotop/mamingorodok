<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div id="blog-posts-content">
<?
if(!empty($arResult["OK_MESSAGE"]))
{
	?>
	<div class="blog-notes blog-note-box">
		<div class="blog-note-text">
			<ul>
				<?
				foreach($arResult["OK_MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
if(!empty($arResult["MESSAGE"]))
{
	?>
	<div class="blog-textinfo blog-note-box">
		<div class="blog-textinfo-text">
			<ul>
				<?
				foreach($arResult["MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
if(!empty($arResult["ERROR_MESSAGE"]))
{
	?>
	<div class="blog-errors blog-note-box blog-note-error">
		<div class="blog-error-text">
			<ul>
				<?
				foreach($arResult["ERROR_MESSAGE"] as $v)
				{
					?>
					<li><?=$v?></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
	global $MyBlog;
	if($MyBlog!="BLOG"){
		?>
			<?//print_R($arResult)?>
			<div class="BlogInfo">
			<h1 class="BlogName">Блог <a href="/community/user/<?=$arResult["BLOG"]["OWNER_ID"]?>/"><?=$arResult["LOOK_NAME"]?></a></h1>
			<?
			global $USER;
			if($USER->IsAuthorized()):?>
			<input type="submit" id="blog_<?=$arResult["BLOG"]["ID"]?>" class="purple frending" value="<?if($arResult["USER_ADD"]=="Y"):?>Отписаться от блога<?else:?>Подписаться на блог<?endif;?>">
			<?endif;?>
			<div class="items">
			<?=ShowImage($arResult["LOOK_FOTO"],57,57,"border='0' class='foto'")?>
			<div class="rait"><span class="rating">Рейтинг</span> <?if(intval($arResult["RATING"])>0):?>+<?endif?><?=$arResult["RATING"]?></div>
			</div>
			<div class="clear"></div>
			<div class="text">
			<?=$arResult["PERSONAL_NOTES"]?>
			</div>
			<div class="clear"></div>
			</div>
		<?
	}

if(count($arResult["POST"])>0)
{

	foreach($arResult["POST"] as $ind => $CurPost)
	{
	?>
	<div class="items">
	<?
	if($CurPost["TYPE"]==BLOG_TYPE):
	?>
		<div class="headers">
			<a href="<?=$CurPost["urlToPost"]?>"><?=$CurPost["TITLE"]?></a>
			<?if(strLen($CurPost["urlToEdit"])>0):?>
			<a href="<?=$CurPost["urlToEdit"]?>" class="edit">Редактировать</a>
			<?endif;?>
		</div>
		<div class="clear"></div>
		<?=$CurPost["TEXT_FORMATED"]?>
		<a href="<?=$CurPost["urlToPost"]?>">Читать полностью</a>
		<?if(!empty($CurPost["CATEGORY"]))
			{?>
			<div class="mark">Рубрики: 
				<noindex>
					<?
						$i=0;
						foreach($CurPost["CATEGORY"] as $v)
						{
							if($i!=0)
								echo ",";
							?> <a href="<?=$v["urlToCategory"]?>" class="grey" rel="nofollow"><?=$v["NAME"]?></a><?
							$i++;
						}
					?>
				</noindex>
			</div>
			<?}	?><?
	elseif($CurPost["TYPE"]==WISHLIST_TYPE):
	?>
	
	
	<div class="clear"></div>
	<div class="st">Я <?if($CurPost["GENDER"]=="M"):?>добавил<?else:?>добавила<?endif?>
		<a href="<?=$CurPost["PRODUCT"]["DETAIL_PAGE_URL"]?>"><?=$CurPost["PRODUCT"]["NAME"]?></a>
	</div>
	<?if($CurPost["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
		<?=ShowImage($CurPost["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
	<?endif;?>
	<div class="clear"></div>
	<?
	elseif($CurPost["TYPE"]==FRIEND_TYPE):
		?><div class="clear"></div>
		<div class="st">Я дружу с 
		<?if(!empty($CurPost["FRIEND_BLOG"])):?>
		<a href="/community/blog/<?=$CurPost["FRIEND_BLOG"]?>/">
		<?=$CurPost["FRIEND_NAME"]?></a>
		<?else:?>
		<?=$CurPost["FRIEND_NAME"]?>
		<?endif;?>
		</div>
		<?if(intval($CurPost["FRIEND_PHOTO"])>0):?>
		<?=ShowImage($CurPost["FRIEND_PHOTO"],57,57,'class="stfoto"');?>
		<?endif;?>
		<div class="clear"></div><?
	else:
		print_R($CurPost["DETAIL_TEXT"]);
	endif;
	?>
	<div class="panel">
			<div class="panelLeft"></div>
			<div class="panelCenter">
				<div class="ratnum"><?
					$APPLICATION->IncludeComponent(
						"individ:rating.vote", "blog",
						Array(
							"ENTITY_TYPE_ID" => "BLOG_POST",
							"ENTITY_ID" => $CurPost["ID"],
							"OWNER_ID" => $CurPost["arUser"]["ID"],
							"USER_HAS_VOTED" => $arResult["RATING"][$CurPost["ID"]]["USER_HAS_VOTED"],
							"TOTAL_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_VOTES"],
							"TOTAL_POSITIVE_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_POSITIVE_VOTES"],
							"TOTAL_NEGATIVE_VOTES" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_NEGATIVE_VOTES"],
							"TOTAL_VALUE" => $arResult["RATING"][$CurPost["ID"]]["TOTAL_VALUE"]
						),
						null,
						array("HIDE_ICONS" => "Y")
					);?>
				</div> 
				<div class="date">
				<?
				//echo $CurPost["DATE_PUBLISH"];
				if(!empty($CurPost["DATE_PUBLISH"])):
				$mas = explode(" ",$CurPost["DATE_PUBLISH"]);
				if(isset($mas[0])):
				?>
				<?=MyFormatDate($mas[0], false);?>
				<?endif;
				if(isset($mas[1]) && !empty($mas[1])):
					$mas = explode(":",$mas[1]);
					if(isset($mas[0]) && isset($mas[1]) && !empty($mas[1]) && !empty($mas[0])):
				?>
						<?=$mas[0].":".$mas[1]?>
				<?	endif;
				endif;?>
				<?endif;?>
				</div>
				<div class="share">
						<?
							$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
									"HANDLERS" => $arParams["SHARE_HANDLERS"],
									"PAGE_URL" => htmlspecialcharsback($CurPost["urlToPost"]),
									"PAGE_TITLE" => htmlspecialcharsback($CurPost["TITLE"]),
									"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
									"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
									"ALIGN" => "right",
									"HIDE" => $arParams["SHARE_HIDE"],
								),
								$component,
								array("HIDE_ICONS" => "Y")
							);
							?>
				</div>
				
				<a href="<?=$CurPost["urlToPost"]?>#addcomments" class='addcomment'>Оставить комментарий</a>
				<a href="<?=$CurPost["urlToPost"]?>#lookcomments" class="comment grey"><?if($CurPost["NUM_COMMENTS"]>0):?><?=$CurPost["NUM_COMMENTS"]?> <?endif;?><?=CommentLang($CurPost["NUM_COMMENTS"])?></a>
			</div>
			<div class="panelRight"></div>
		</div>
	</div><?
	}
		?>
			
				<?
	if(strlen($arResult["NAV_STRING"])>0)
		echo $arResult["NAV_STRING"];
}
elseif(!empty($arResult["BLOG"]))
	echo GetMessage("BLOG_BLOG_BLOG_NO_AVAIBLE_MES");
?>	
</div>