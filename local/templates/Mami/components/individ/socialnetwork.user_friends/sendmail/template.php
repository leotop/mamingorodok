<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["Friends"]["List"])>0):?>
	<div class="right_part">
	<?$i=0;?>
	<?foreach($arResult["Friends"]["List"] as $arFriend):?>
		 <div class="friend">
			<input type="checkbox" class="myfriendssend" value="<?=$arFriend["USER_ID"]?>"/>
			<?if(intval($arFriend["USER_PERSONAL_PHOTO"])>0):?>
				 <?=ShowIImage($arFriend["USER_PERSONAL_PHOTO"],41,41);?>
			<?else:?>
				<?=ShowIImage(SITE_TEMPLATE_PATH.'/images/profile_img.png',41,41);?>
			<?endif;?>
			<?
			$name = "";
			if($arFriend["USER_NAME"]!="") $name = $arFriend["USER_NAME"];
			if($arFriend["USER_LAST_NAME"]!="")
				if($name!="") $name .= " ".$arFriend["USER_LAST_NAME"];
			else	$name = $arFriend["USER_LAST_NAME"];
			if($name=="") $name = $arFriend["USER_LOGIN"];
			
			?>
			<div class="lnk2"><a href="/community/user/<?=$arFriend["USER_ID"]?>/"><?=$name?></a></div>
		</div>
	<?
	$i++;
	if($i==3):
		?>
		<div class="clear"></div>
		<?
	endif;
	?>
	<?endforeach?>
	</div>
<?endif;?>