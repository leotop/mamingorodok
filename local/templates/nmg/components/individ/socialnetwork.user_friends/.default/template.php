<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    global $USER;
    $user_id = $USER->GetID();
    
?>

<?foreach($arResult["Friends"]["List"] as $arFriend):?>
    <div class="friendProf">
        <div style="width:110px; height:110px; overflow:hidden"><?=$arFriend["USER_PERSONAL_PHOTO_IMG"]?></div>
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
        <?if ($user_id > 0):?>
            <?if (CSocNetUserRelations::IsFriends($user_id, $arFriend["USER_ID"])):?>
                <div class="generalFriend">Общий друг</div>
            <?elseif($user_id != $arFriend["USER_ID"]):?>
                <a class="lnk grey marginLnk" href="<?=$arFriend["ADD_TO_FRIENDS_LINK"]?>">Добавить в друзья</a>
            <?else:?>
                <div class="generalFriend">Это вы!</div>                        
            <?endif?>
        <?endif?>
    </div>
<?endforeach?>