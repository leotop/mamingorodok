<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $USER;?>
<?
//echo '<pre>'.print_r($arResult, true).'</pre>';

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
} elseif(strlen($arResult["NOTE_MESSAGE"])>0) {
	?>
<div class="blog-textinfo blog-note-box">
	<div class="blog-textinfo-text">
		<?=$arResult["NOTE_MESSAGE"]?>
	</div>
</div>
<?
} else {
	if(!empty($arResult["Post"])>0)
	{
		// список статусов пользователей 
        $arStatusList = GetStatusList();
		
		//print_R($arResult);
		if($arResult["Post"]["AUTHOR_ID"] != $USER->GetID())
		{?>
<div class="BlogInfo">
	<?
			$rsUser = CUser::GetByID($arResult["Post"]["AUTHOR_ID"]);
			$arUser = $rsUser->Fetch();
			$name = "";
			if(!empty($arUser["NAME"]))
				$name = $arUser["NAME"];
				
			if(!empty($arUser["LAST_NAME"]))
				if(!empty($name))
					$name .= " ".$arUser["LAST_NAME"];
				else
					$name = $arUser["LAST_NAME"];
					
			if(empty($name))
				$name = $arUser["LOGIN"];
			//$arResult["Blog"]["NAME"] = $name;
			?>
	<div class="BlogName">Блог <a href="/community/user/<?=$arResult["Blog"]["URL"]?>/"><?=$name?></a></div>
	<div><?=$arResult["Blog"]["DESCRIPTION"]?></div>
</div>
<div class="top15"></div><?
		};
		
		if($arResult["Post"]["TYPE"]==BLOG_TYPE):?>
<div class="headers">
	<div class="blogLinkAdmin">
		<?if(strLen($arResult["urlToDelete"])>0):?>
		<a href="<?=$arResult["urlToDelete"]?>" class="delete">Удалить</a>
		<?endif;?>
		<?if(strLen($arResult["urlToEdit"])>0):?>
		<a href="<?=$arResult["urlToEdit"]?>" class="edit">Редактировать</a>
		<?endif;?>
	</div>
	<h1 class="BlogName"><span>
		<?=$arResult["Post"]["TITLE"]?>
		</span></h1>
</div>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/community/user/<?=$USER->GetID()?>/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span><?=($arResult["RATING"]>0?'+':'')?><?=$arResult["RATING"]?><span class="rating">Статус:</span><?=GetStatusByRatingValue($arResult["RATING"], $arStatusList);?>

<div class="clear"></div>
<div class="text2">
	<?=$arResult["Post"]["textFormated"]?>
</div>
<div class="mark">
	<?if(!empty($arResult["Category"]))
			{?>
	Метка:
	<noindex>
		<?
						$i=0;
						foreach($arResult["Category"] as $v)
						{
							if($i!=0)
								echo ",";
							?>
		<a href="<?=$v["urlToCategory"]?>" class="grey" rel="nofollow"><?=$v["NAME"]?></a>
		<?
							$i++;
						}
						?>
	</noindex>
	<?}?>
</div>
<?elseif($arResult["Post"]["TYPE"]==FRIEND_TYPE):?>
<?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/personal/profile/">
<?=$arResult["LOOK_NAME"]?>
</a> <span class="rating">Рейтинг</span>
<?if($arResult["RATING"]>0):?>
+
<?endif;?>
<?=$arResult["RATING"]?>
<div class="clear"></div>
<div class="status">
	<div class="tvr"> теперь дружит с
		<table>
			<tbody>
				<tr>
					<td><?if(intval($arResult["Post"]["FRIEND_PHOTO"])>0):?>
						<?=ShowImage($arResult["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
						<?else:?>
						<?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
						<?endif;?></td>
					<td><?if(!empty($arResult["Post"]["FRIEND_BLOG"])):?>
						<a href="/community/blog/<?=$arResult["Post"]["FRIEND_BLOG"]?>/">
						<?=$arResult["Post"]["FRIEND_NAME"]?>
						</a>
						<?else:?>
						<?=$arResult["Post"]["FRIEND_NAME"]?>
						<?endif;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?else:?>
<div class="st"> Я дружу с
	<?if(!empty($arResult["Post"]["FRIEND_BLOG"])):?>
	<a href="/community/blog/<?=$arResult["Post"]["FRIEND_BLOG"]?>/">
	<?=$arResult["Post"]["FRIEND_NAME"]?>
	</a>
	<?else:?>
	<?=$arResult["Post"]["FRIEND_NAME"]?>
	<?endif;?>
</div>
<?if(intval($arResult["Post"]["FRIEND_PHOTO"])>0):?>
<?=ShowImage($arResult["Post"]["FRIEND_PHOTO"],48,48,'class="stfoto"');?>
<?else:?>
<?=ShowImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',48,48,'class="stfoto"');?>
<?endif;?>
<div class="clear"></div>
<?endif;?>
<?elseif($arResult["Post"]["TYPE"]==WISHLIST_TYPE):?>
<?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/personal/profile/">
<?=$arResult["LOOK_NAME"]?>
</a> <span class="rating">Рейтинг</span>
<?if($arResult["RATING"]>0):?>
+
<?endif;?>
<?=$arResult["RATING"]?>
<div class="clear"></div>
<div class="status">
	<div>
		<?if($arResult["Post"]["GENDER"]=="M"):?>
		Добавил
		<?else:?>
		Добавила
		<?endif?>
		в свой список</div>
	<div class="tvr">
		<table>
			<tbody>
				<tr>
					<td><?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
						<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
						<?endif;?></td>
					<td><a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
						<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
						</a>
						<?$rating = intval($arResult["Post"]["PROPERTY_RATING_VALUE"]);?>
						<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?else:?>
<div class="st"> Я
	<?if($arResult["Post"]["GENDER"]=="M"):?>
	добавил
	<?else:?>
	добавила
	<?endif?>
	<a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
	<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
	</a> </div>
<?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
<?endif;?>
<div class="clear"></div>
<?endif?>
<?elseif($arResult["Post"]["TYPE"]==ADD_COMMENT_TYPE):?>
<?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/personal/profile/">
<?=$arResult["LOOK_NAME"]?>
</a> <span class="rating">Рейтинг</span>
<?if($arResult["RATING"]>0):?>
+
<?endif;?>
<?=$arResult["RATING"]?>
<div class="clear"></div>
<div class="status">
	<?//echo $arResult["Post"]["USER_GENDER"];?>
	<div>
		<?if($arResult["Post"]["USER_GENDER"]=="M"):?>
		Добавил
		<?else:?>
		Добавила
		<?endif?>
		отзыв на товар</div>
	<div class="tvr">
		<table>
			<tbody>
				<tr>
					<td><?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
						<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
						<?endif;?></td>
					<td><?//print_R($CurPost["COUNT"]);?>
						<a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
						<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
						</a>
						<?$rating = intval($arResult["Post"]["PROPERTY_RATING_VALUE"]);?>
						<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?else:?>
<?//print_R($CurPost)?>
<div class="clear"></div>
<div class="st">Я
	<?if($CurPost["USER_GENDER"]=="M"):?>
	добавил
	<?else:?>
	добавила
	<?endif?>
	отзыв на товар <a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
	<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
	</a> </div>
<?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto"');?>
<?endif;?>
<div class="clear"></div>
<?endif;?>
<?elseif($arResult["Post"]["TYPE"]==ADD_REPORT_TYPE):?>
<?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/personal/profile/">
<?=$arResult["LOOK_NAME"]?>
</a> <span class="rating">Рейтинг</span>
<?if($arResult["RATING"]>0):?>
+
<?endif;?>
<?=$arResult["RATING"]?>
<div class="clear"></div>
<div class="status">
	<?//echo $arResult["Post"]["USER_GENDER"];?>
	<div>
		<?if($arResult["Post"]["USER_GENDER"]=="M"):?>
		Запросил
		<?else:?>
		Запросила
		<?endif?>
		отзыв у <a href="/comunity/blog/<?=$arResult["Post"]["REPORT_USER_BLOG"]?>/">
		<?=$arResult["Post"]["REPORT_USER"]?>
		</a> на товар</div>
	<div class="tvr">
		<table>
			<tbody>
				<tr>
					<td><?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
						<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
						<?endif;?></td>
					<td><?//print_R($CurPost["COUNT"]);?>
						<a href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
						<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
						</a>
						<?$rating = intval($arResult["Post"]["PROPERTY_RATING_VALUE"]);?>
						<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array('Raiting'=>$rating), array("MODE"=>"html") );?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?else:?>
<?//print_R($CurPost)?>
<div class="clear"></div>
<div class="st">Я
	<?if($CurPost["USER_GENDER"]=="M"):?>
	запросил
	<?else:?>
	запросила
	<?endif?>
	отзыв у <a href="/comunity/blog/<?=$arResult["Post"]["REPORT_USER_BLOG"]?>/">
	<?=$arResult["Post"]["REPORT_USER"]?>
	</a> на товар </div>
<?if($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"]>0):?>
<?=ShowImage($arResult["Post"]["PRODUCT"]["PREVIEW_PICTURE"],60,60,'class="stfoto tovarfoto"');?>
<?endif;?>
<div class="tovarName"><a style="margin-top:15px;" href="<?=$arResult["Post"]["PRODUCT"]["DETAIL_PAGE_URL"]?>">
	<?=$arResult["Post"]["PRODUCT"]["NAME"]?>
	</a></div>
<div class="clear"></div>
<?endif;?>
<?elseif($arResult["Post"]["TYPE"]==CERTIFICATE_TYPE):?>
<?
				//print_R($CurPost["USER_TO"]);
				$name = "";
				
				if(!empty($arResult["Post"]["USER_TO"]["NAME"])){
					$name = $arResult["Post"]["USER_TO"]["NAME"];
				}
				
				if(!empty($arResult["Post"]["USER_TO"]["LAST_NAME"])){
					if(!empty($name))
						$name .= " ".$arResult["Post"]["USER_TO"]["LAST_NAME"];
					else
						$name = $arResult["Post"]["USER_TO"]["LAST_NAME"];
				}
				
				if(empty($name)){
					$name = $arResult["Post"]["USER_TO"]["LOGIN"];
				}
				?>
<?if($arResult["Blog"]["OWNER_ID"]!=$USER->GetID()):?>
<div class="top15"></div>
<div class="clear"></div>
<?=ShowImage($arResult["LOOK_FOTO"], 42,42,"class='foto'")?>
<a href="/personal/profile/"><?=$arResult["LOOK_NAME"]?></a> <span class="rating">Рейтинг</span>
<?if($arResult["RATING"]>0):?>
+
<?endif;?>
<?=$arResult["RATING"]?>
<div class="clear"></div>
<div class="status">
	<?//echo $arResult["Post"]["USER_GENDER"];?>
	<div>
		<?if($arResult["Post"]["USER_GENDER"]=="M"):?>
		Подарил
		<?elseif($arResult["Post"]["USER_GENDER"]=="F"):?>
		Подарила
		<?else:?>
		Подарил(а)
		<?endif?>
		пользователю <a href="/comunity/user/<?=$arResult["Post"]["USER_TO"]["ID"]?>/">
		<?=$name?>
		</a> сертификат </div>
	<div class="tvr">
		<table>
			<tbody>
				<tr>
					<td><?if($arResult["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"]>0):?>
						<?=ShowImage($arResult["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"],48,48,'class="stfoto"');?>
						<?endif;?></td>
					<td><?//print_R($CurPost["COUNT"]);?>
						<?if($arResult["Post"]["CERTIFICATE"]["PRICE"]>0):?>
						<br />
						<?=$arResult["Post"]["CERTIFICATE"]["PRICE"]?> 	руб.
						<?endif;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?else:?>
<div class="clear"></div>
<div>Я
	<?if($arResult["Post"]["USER_GENDER"]=="M"):?>
	подарил
	<?elseif($arResult["Post"]["USER_GENDER"]=="F"):?>
	Подарила
	<?else:?>
	Подарил(а)
	<?endif?>
	пользователю <a href="/comunity/user/<?=$arResult["Post"]["USER_TO"]["ID"]?>/">
	<?=$name?>
	</a> сертификат </div>
</div>
<?if($arResult["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"]>0):?>
<?=ShowImage($arResult["Post"]["CERTIFICATE"]["PREVIEW_PICTURE"],60,60,'class="stfoto tovarfoto"');?>
<?endif;?>
<div class="tovarName">
	<?if($arResult["Post"]["CERTIFICATE"]["PRICE"]>0):?>
	<br />
	<?=$arResult["Post"]["CERTIFICATE"]["PRICE"]?>
	руб.
	<?endif;?>
</div>
<div class="clear"></div>
<?endif;?>
<?else:?>
<?=$arResult["Post"]["textFormated"]?>
<?endif;?>
<div class="panel">
	<div class="panelLeft"></div>
	<div class="panelCenter">
		<div class="ratnum">
			<?
					$APPLICATION->IncludeComponent(
						"individ:rating.vote", "blog",
						Array(
							"ENTITY_TYPE_ID" => "BLOG_POST",
							"ENTITY_ID" => $arResult["Post"]["ID"],
							"OWNER_ID" => $arResult["Post"]["AUTHOR_ID"],
							"USER_HAS_VOTED" => $arResult["RATING"]["USER_HAS_VOTED"],
							"TOTAL_VOTES" => $arResult["RATING"]["TOTAL_VOTES"],
							"TOTAL_POSITIVE_VOTES" => $arResult["RATING"]["TOTAL_POSITIVE_VOTES"],
							"TOTAL_NEGATIVE_VOTES" => $arResult["RATING"]["TOTAL_NEGATIVE_VOTES"],
							"TOTAL_VALUE" => $arResult["RATING"]["TOTAL_VALUE"]
						),
						null,
						array("HIDE_ICONS" => "Y")
					);?>
		</div>
		<div class="date">
			<?
				//echo $arResult["DATE_PUBLISH"];
				if(!empty($arResult["Post"]["DATE_PUBLISH"])):
				$mas = explode(" ",$arResult["Post"]["DATE_PUBLISH"]);
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
									"PAGE_URL" => htmlspecialcharsback($arResult["urlToPost"]),
									"PAGE_TITLE" => $arResult["Post"]["~TITLE"],
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
		<a href="#addcomments" class='addcomment'>Оставить комментарий</a> <a href="#lookcomments" class="comment grey">
		<?if($arResult["Post"]["NUM_COMMENTS"]>0):?>
		<?=$arResult["Post"]["NUM_COMMENTS"]?>
		<?endif;?>
		<?=CommentLang($arResult["Post"]["NUM_COMMENTS"])?>
		</a> </div>
	<div class="panelRight"></div>
</div>
<h2 class="grey top15">
	<?if($arResult["Post"]["NUM_COMMENTS"]>0):?>
	<?=$arResult["Post"]["NUM_COMMENTS"]?>
	<?endif;?>
	<?=CommentLang($arResult["Post"]["NUM_COMMENTS"],true)?>
	к записи
	<?if($arResult["Post"]["TYPE"]==BLOG_TYPE):?>
	"
	<?=$arResult["Post"]["TITLE"]?>
	"
	<?endif;?>
</h2>
<?
	}
	else
		echo GetMessage("BLOG_BLOG_BLOG_NO_AVAIBLE_MES");
}
?>
