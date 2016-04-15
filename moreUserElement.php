<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
$do = "";
if($_POST["whatDo"] == "#userWant") $do = "userWant";
if($_POST["whatDo"] == "#userWantAll") $do = "userWantAll";
if($_POST["whatDo"] == "#userWantFriends") $do = "userWantFriends";
if($_POST["whatDo"] == "#userWantFriendsAll") $do = "userWantFriendsAll";
if($_POST["whatDo"] == "#userHave") $do = "userHave";
if($_POST["whatDo"] == "#userHaveAll") $do = "userHaveAll";
if($_POST["whatDo"] == "#userHaveFriends") $do = "userHaveFriends";
if($_POST["whatDo"] == "#userHaveFriendsAll") $do = "userHaveFriendsAll";

if(!empty($do)){
	CModule::IncludeModule('iblock');
	global $USER;
	$user_id = intval($USER->GetID());
	// получаем список друзей
	if ($user_id > 0)
	{
		CModule::IncludeModule('socialnetwork');
		$arFriends = array();
		$dbFriends = CSocNetUserRelations::GetRelatedUsers($user_id, SONET_RELATIONS_FRIEND, false);
		while ($arFriend = $dbFriends->GetNext())
		{
			$arFriends[] = $arFriend;
			if($arFriend["FIRST_USER_ID"]!=$user_id)
			$arFriendsIDs[] = $arFriend["FIRST_USER_ID"];
		}            
	}
	// получаем список пользователей которые хот€т этот товар

	$arFriendsIDsI = $arFriendsIDs;
	$arFriendsIDsI[] = $user_id;
		
	$ElementID = intval($_POST["element_id"]);
	$page = intval($_POST["page_now"])+1;
	$countPage = intval($_POST["count_page"]);
	
	if($do=="userWant"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nPageSize"=>$countPage, "iNumPage"=>$page);
	}
	
	if($do=="userWantAll"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nTopCount"=>100);
	}
	
	if($do=="userWantFriends"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nPageSize"=>$countPage, "iNumPage"=>$page);
		if(count($arFriendsIDs)<=0) return;
	}
	
	if($do=="userWantFriendsAll"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "!PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nTopCount"=>100);
		if(count($arFriendsIDs)<=0) return;
	}
	
	if($do=="userHave"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nPageSize"=>$countPage, "iNumPage"=>$page);
	}
	
	if($do=="userHaveAll"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "!PROPERTY_USER_ID" => $arFriendsIDsI, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nTopCount"=>100);
	}
	
	if($do=="userHaveFriends"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nPageSize"=>$countPage, "iNumPage"=>$page);
		if(count($arFriendsIDs)<=0) return;
	}
	
	if($do=="userHaveFriendsAll"){
		$arFilter = Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $arFriendsIDs, "PROPERTY_PRODUCT_ID" => $ElementID, "PROPERTY_STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID);
		$arNav = array("nTopCount"=>100);
		if(count($arFriendsIDs)<=0) return;
	}
	
	
	$dbEl = CIBlockElement::GetList(Array("SORT"=>"ASC"),$arFilter, array("PROPERTY_USER_ID"), $arNav , array("ID", "IBLOCK_ID", "PROPERTY_USER_ID"));
	
	$user = array();
	while($obEl = $dbEl->GetNext())    
	{ 
		$user[] = $obEl["PROPERTY_USER_ID_VALUE"];
	}

	
	if(count($user)>0){
		$i = 0;
		$user = implode(" | ",$user);
		$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), array("ID"=>$user));
		while($arUser = $rsUsers->GetNext()){
			?> <div class="friend">
                <?if($arUser["PERSONAL_PHOTO"] > 0):?>
					<?$rsFile = CFile::GetByID($arUser["PERSONAL_PHOTO"]);?>
					<?if($arFile = $rsFile->Fetch()):?>
						<?=ShowImage($arUser["PERSONAL_PHOTO"], 42, 42);?>
					<?else:?>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
					<?endif;?>
				<?else:?>
					<img src="<?=SITE_TEMPLATE_PATH?>/images/profile_img.png" style="width:42px; height;42px;"/>
				<?endif?>
				<?$name = ShowFullName($arUser["NAME"],$arUser["SECOND_NAME"], $arUser["LAST_NAME"]);
				if(empty($name)) $name = $arUser["EMAIL"];
				?>
                <div class="lnk2"><a href="/community/user/<?=$arUser["ID"]?>/"><?=$name?></a></div>
                <div class="lnk_gray"><a id="this_<?=$ElementID ?>" class="getReport" href="<?=$arUser["ID"]?>">«апросить отзыв</a></div>
            </div>
			<?$i++;?>
			<?if($i==3):?>
				<?$i=0;?>
				 <div class="clear"></div>
			<?endif;
		}
		?>
		<div class="clear"></div>
		<?
	}
}
?>