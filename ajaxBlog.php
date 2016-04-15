<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
global $USER;
$typeClass = new IBlogType;
if (CModule::IncludeModule("blog") && CModule::IncludeModule("iblock")){
	if($_REQUEST["do"]=="frending"){
		$blog_id = intval($_REQUEST["blog_id"]);
		if($blog_id>0){
			$arBlog = CBlog::GetByID($blog_id);
			if(is_array($arBlog)){
				//текущий пользователь
				$user = $USER->GetID();			

				if(intval($user)>0){
					$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
					$arFilter = Array(
							"ACTIVE" => "Y",
							"GROUP_SITE_ID" => SITE_ID,
							"OWNER_ID" => $user
						);	
					$arSelectedFields = array("ID", "NAME", "OWNER_ID");

					//блог текущего пользователя
					$dbBlogs = CBlog::GetList(
							$SORT,
							$arFilter,
							false,
							false,
							$arSelectedFields
						);
					
					if ($arBlogMy = $dbBlogs->Fetch())
					{
						$arFriendUsers = array();
						$dbUsers = CBlogUser::GetList(
							array(),
							array(
								"GROUP_BLOG_ID" => $arBlogMy["ID"],
							),
							array("ID", "USER_ID")
						);
						while($arUsers = $dbUsers->Fetch())
							$arFriendUsers[] = $arUsers["USER_ID"];
						
						if(!is_array($arFriendUsers)) $arFriendUsers = array();
						if(!in_array($arBlog["OWNER_ID"],$arFriendUsers)){
							$arOrder = Array(
									"NAME" => "ASC",
									"ID" => "ASC"
								);
							$arFilter = Array(
									"SITE_ID"=>SITE_ID,
									"BLOG_ID"=>$arBlogMy["ID"]
								);
							$arSelectedFields = Array("ID", "SITE_ID", "NAME");

							$dbGroup = CBlogUserGroup::GetList($arOrder, $arFilter, false, false, $arSelectedFields);
							$group = array();
							while ($arGroup = $dbGroup->Fetch())
							{
								$group[] = $arGroup["ID"];
							}
							if(count($group)==0){
								$arFields = array(
									"NAME" => 'Друзья',
									"BLOG_ID" => $arBlogMy["ID"]
								);
								$group[] = CBlogUserGroup::Add($arFields);
							}

							if($arBlog["OWNER_ID"]!=$user){
								if(!CBlogUser::AddToUserGroup($arBlog["OWNER_ID"], $arBlogMy["ID"], $group, "Y", BLOG_BY_USER_ID , BLOG_ADD))
								{
									echo "false";
									return;
								}
								echo "add";
								return;
							}
						}
						else{
							//$arBlog["OWNER_ID"]."_".$arBlogMy["ID"]
							if(!CBlogUser::DeleteFromUserGroup($arBlog["OWNER_ID"], $arBlogMy["ID"], BLOG_BY_USER_ID ))
							{
								echo "false";
								return;
							}
							echo "remove";
							return;
						}
					}
				}
			}
		}
	}
	
	if($_REQUEST["do"]=="frendingOf"){
		$blog_id = intval($_REQUEST["blog_id"]);
		if($blog_id>0){
			$arBlog = CBlog::GetByID($blog_id);
			if(is_array($arBlog)){
				$user = $USER->GetID();			

				if(intval($user)>0){
					$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
					$arFilter = Array(
							"ACTIVE" => "Y",
							"GROUP_SITE_ID" => SITE_ID,
							"OWNER_ID" => $user
						);	
					$arSelectedFields = array("ID", "NAME", "OWNER_ID");

					$dbBlogs = CBlog::GetList(
							$SORT,
							$arFilter,
							false,
							false,
							$arSelectedFields
						);
					
					if ($arBlogMy = $dbBlogs->Fetch())
					{
					
					
						$arFriendUsers = array();
						$dbUsers = CBlogUser::GetList(
							array(),
							array(
								"GROUP_BLOG_ID" => $arBlog["ID"],
							),
							array("ID", "USER_ID")
						);
						while($arUsers = $dbUsers->Fetch())
							$arFriendUsers[] = $arUsers["USER_ID"];
						
						if(!is_array($arFriendUsers)) $arFriendUsers = array();
						if(!in_array($arBlogMy["OWNER_ID"],$arFriendUsers)){
							$arOrder = Array(
									"NAME" => "ASC",
									"ID" => "ASC"
								);
							$arFilter = Array(
									"SITE_ID"=>SITE_ID,
									"BLOG_ID"=>$arBlog["ID"]
								);
							$arSelectedFields = Array("ID", "SITE_ID", "NAME");

							$dbGroup = CBlogUserGroup::GetList($arOrder, $arFilter, false, false, $arSelectedFields);
							$group = array();
							while ($arGroup = $dbGroup->Fetch())
							{
								$group[] = $arGroup["ID"];
							}
		
							if(count($group)==0){
								$arFields = array(
									"NAME" => 'Друзья',
									"BLOG_ID" => $arBlog["ID"]
								);
								$group[] = CBlogUserGroup::Add($arFields);
							}

							if($arBlog["OWNER_ID"]!=$user){
								if(!CBlogUser::AddToUserGroup($arBlogMy["OWNER_ID"], $arBlog["ID"], $group, "Y", BLOG_BY_USER_ID , BLOG_ADD))
								{
									echo "false";
									return;
								}
								echo "add";
								return;
							}
						}
						else{
							if(!CBlogUser::DeleteFromUserGroup($arBlogMy["OWNER_ID"], $arBlog["ID"], BLOG_BY_USER_ID ))
							{
								echo "false";
								return;
							}
							echo "remove";
							return;
						}
					}
				}
			}
		}
	}
	
	if($_REQUEST["do"]=="frendingWrite"){
		
		$blog_id = intval($_REQUEST["blog_id"]);
		if($blog_id>0){
			$arBlog = CBlog::GetByID($blog_id);
			if(is_array($arBlog)){
				//текущий пользователь
				$user = $USER->GetID();			
				if(intval($user)>0){
					$SORT = Array("DATE_CREATE" => "DESC", "NAME" => "ASC");
					$arFilter = Array(
							"ACTIVE" => "Y",
							"GROUP_SITE_ID" => SITE_ID,
							"OWNER_ID" => $user
						);	
					$arSelectedFields = array("ID", "NAME", "OWNER_ID");

					//блог текущего пользователя
					$dbBlogs = CBlog::GetList(
							$SORT,
							$arFilter,
							false,
							false,
							$arSelectedFields
						);
					
					if ($arBlogMy = $dbBlogs->Fetch())
					{
						$arFriendUsers = array();
						$dbUsers = CBlogUser::GetList(
							array(),
							array(
								"GROUP_BLOG_ID" => $arBlog["ID"],
							),
							array("ID", "USER_ID")
						);
						while($arUsers = $dbUsers->Fetch())
							$arFriendUsers[] = $arUsers["USER_ID"];
						
						//print_R($arFriendUsers);
						if(!is_array($arFriendUsers)) $arFriendUsers = array();
						if(!in_array($arBlogMy["OWNER_ID"],$arFriendUsers)){
							$arOrder = Array(
									"NAME" => "ASC",
									"ID" => "ASC"
								);
							$arFilter = Array(
									"SITE_ID"=>SITE_ID,
									"BLOG_ID"=>$arBlog["ID"]
									
								);
							$arSelectedFields = Array("ID", "SITE_ID", "NAME");

							$dbGroup = CBlogUserGroup::GetList($arOrder, $arFilter, false, false, $arSelectedFields);
							$group = array();
							while ($arGroup = $dbGroup->Fetch())
							{
								
								$perms = CBlogUserGroup::GetGroupPerms($arGroup["ID"], $arBlog["ID"]);
								//echo $arBlog["ID"]." ".$arGroup["ID"]." ".$perms."<br>";
								if($perms == "P" || $perms=="W" || $perms=="I")
									$group[] = $arGroup["ID"];
							}
		
						

							if($arBlog["OWNER_ID"]!=$user && count($group)>0){
								//echo "Owner: ".$arBlog["OWNER_ID"]." BlogMy".$arBlogMy["ID"];
								//print_R($group);
								if(!CBlogUser::AddToUserGroup($arBlogMy["OWNER_ID"], $arBlog["ID"], $group, "Y", BLOG_BY_USER_ID , BLOG_ADD))
								{

									echo "false";
									return;
								}
								echo "add";
								return;
							}
							else{
								echo "error";
								echo $arBlog["OWNER_ID"]."-".$user;
								echo count($group);
								}
						}
						else{
							//$arBlog["OWNER_ID"]."_".$arBlogMy["ID"]
							if(!CBlogUser::DeleteFromUserGroup($arBlogMy["OWNER_ID"], $arBlog["ID"], BLOG_BY_USER_ID ))
							{
								echo "false";
								return;
							}
							echo "remove";
							return;
						}
					}
				}
			}
		}
	}
}
echo "false";
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>