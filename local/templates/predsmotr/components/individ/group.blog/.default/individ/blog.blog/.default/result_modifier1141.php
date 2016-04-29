<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?



global $MyBlog;
if($MyBlog!="BLOG"){
global $USER;
	$arFilter = Array(
			"ACTIVE" => "Y",
			"GROUP_SITE_ID" => SITE_ID,
			"OWNER_ID" => $USER->GetID()
		);	
	$arSelectedFields = array("ID", "NAME", "OWNER_ID");

	$dbBlogs = CBlog::GetList(
			$SORT,
			$arFilter,
			false,
			false,
			$arSelectedFields
		);

	if($arBlogMy = $dbBlogs->Fetch())
	{
	$dbUsers = CBlogUser::GetList(
		array(),
		array(
				"GROUP_BLOG_ID" => $arBlogMy["ID"],
			),
		array("ID", "USER_ID")
		);
	while($arUsers = $dbUsers->Fetch())
		$arFriendUsers[] = $arUsers["USER_ID"];
	if(in_array($arResult["BLOG"]["OWNER_ID"],$arFriendUsers)){
		$arResult["USER_ADD"] = 'Y';
		}
	else{
		$arResult["USER_ADD"] = 'N';
		}
	}	
}	


foreach($arResult["POST"] as $ind => $CurPost){
	
}


?>