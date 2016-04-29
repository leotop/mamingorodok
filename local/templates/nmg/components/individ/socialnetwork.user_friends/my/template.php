<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    global $USER;
    $user_id = $USER->GetID();
    
?>

<?foreach($arResult["Friends"]["List"] as $arFriend):?>
    <div class="friendProf">
        <div style="width:110px; height:110px; overflow:hidden"><?=$arFriend["USER_PERSONAL_PHOTO_IMG"]?></div>
		<div class="clear"></div>
        <a href="<?=$arFriend["USER_PROFILE_URL"]?>"><?=ShowFullName($arFriend["USER_NAME"], $arFriend["USER_SECOND_NAME"], $arFriend["USER_LAST_NAME"])?></a>
		<?
		$age = GetAge($arFriend["PARAMS"]["PERSONAL_BIRTHDAY"]);
		$r = array();
		if(!empty($age) && $age>0)
			$r[] = $age;
		$sity = $arFriend["PARAMS"]["PERSONAL_CITY"];
		if(!empty($sity))
			$r[] = $sity;
		$r = implode(",",$r);
		?>
		<?if(!empty($r)):?>
			<div class="age"><?=$r?></div>
		<?endif;?>
        <!--div class="children">Дети: Мария, Евгений</div-->
    </div>
<?endforeach?>