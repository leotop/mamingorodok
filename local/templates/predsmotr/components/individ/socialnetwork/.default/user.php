<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	//print_r($arResult);
    $pageId = "user";
    global $USER;
    $current_user_id = $USER->GetID();
    $user_id = $arResult["VARIABLES"]["user_id"];
?>

<?

					global $presentCert;
					global $cert;
					$arFilter = Array(   
						"IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID,   
						"ACTIVE"=>"Y",   
					);
					$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,array("ID","NAME","PROPERTY_PRICE"));
					while($ar_fields = $res->GetNext()){  
						$cert[$ar_fields["ID"]] = $ar_fields["PROPERTY_PRICE_VALUE"];
					}
					
					$arFilter = Array(   
						"IBLOCK_ID"=>CERTIFICATES_PRESENT_IBLOCK_ID,   
						"ACTIVE"=>"Y",   
						"PROPERTY_USER_PRESENT"=>$user_id,
						"PROPERTY_STATUS"=>CERTIFICATE_STATUS_OK
					);
					$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,array("ID","NAME","PROPERTY_USER_BY","PROPERTY_CERTIFICATE_ID"));
						
					$sum = 0;
					while($ar_fields = $res->GetNext()){  
						$sum += $cert[$ar_fields["PROPERTY_CERTIFICATE_ID_VALUE"]];
						$presentCert[] = $ar_fields;
					}
					 
?>

<? // ���� ������������ ������� ���� ������� ?>
<?if ($current_user_id == $user_id):?>
		
		
	<?
	if($_REQUEST["showMe"]=="Y"):
	$APPLICATION->AddChainItem("�������", "/community/profile/");
	$APPLICATION->AddChainItem("�������� �������", "");
	$filter = array("ID"=>$current_user_id);
	$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter,array("SELECT"=>array("UF_USER_RATING"))); 
	while($arfiled = $rsUsers->GetNext()){
		$rating = intval($arfiled["UF_USER_RATING"]);
	}

    // ������ �������� ������������� 
    $arStatusList = GetStatusList();
    $arResult["STATUS"] = GetStatusByRatingValue($rating);

	$rsUser = CUser::GetList(($by="personal_country"), ($order="desc"), array("ID"=>$current_user_id),array("SELECT"=>array("UF_*")));
	$name = "";
	if($arUser = $rsUser->GetNext()){
	
	
	
		if(!empty($arUser["NAME"]))
			$name = $arUser["NAME"];
		
		if(!empty($arUser["LAST_NAME"]))
			if(!empty($name))
				$name .= " ".$arUser["LAST_NAME"];
			else
				$name = $arUser["LAST_NAME"];
				
		if(empty($name))
			$name = $arUser["LOGIN"];

		$arBlog = CBlog::GetByOwnerID($current_user_id);
		//if(is_array($arBlog))
			//print_r($arBlog);

	//echo "<pre>"; print_r($arUser); echo "</pre>";
	?>
	<div class="title-line profile"><h2>������� ������������</h2></div>
    <div class="user-profile">
        <div class="left-left">
							<?if(intval($arUser["PERSONAL_PHOTO"])>0):?>
								<?=ShowImage($arUser["PERSONAL_PHOTO"],100,100,'border="0"')?>
							<?else:?>
								<?=ShowImage(SITE_TEMPLATE_PATH."/images/profile_img.png",100,100,'border="0"')?>
							<?endif;?>
                                              </div>
        <div class="center-center">
            <div class="name-name"><?=$name?></div>
			<?
			$age = GetAge($arUser["PERSONAL_BIRTHDAY"]);
			if($age>0)
				$age.=", ";
			else
				$age = "";
			?>	
            <?=$age?><?=$arUser["PERSONAL_CITY"]?><br />
            <b>�������:</b> <?if($arUser["UF_USER_RATING"]>0):?>+<?=$arUser["UF_USER_RATING"]?><?else:?>0<?endif;?><br />
				<?$arFilter = Array(   
					"IBLOCK_ID"=>PRESENTER_IBLOCK_ID,    
					"ACTIVE"=>"Y",    
					"PROPERTY_USERS"=>$user_id
				);
				$res = CIBlockElement::GetList(Array("SORT"=>"ASC",), $arFilter, false,false,array("NAME"));
				while($ar_fields = $res->GetNext()){  
					$arResult["AWARDS"][] = $ar_fields["NAME"];
				}?>
				<?if(is_array($arResult["AWARDS"])):?>
					<b>�������:</b> <?=implode(", ",$arResult["AWARDS"])?><br />
				<?endif;?>
				<?if(!empty($arResult["STATUS"])):?>
					<b>������ � �����������:</b> <?=$arResult["STATUS"]?><br />
				<?endif;?>
				<?if(strlen($arUser["PERSONAL_NOTES"])>0):?>
                            <b>� ����:</b><br />
                <?=$arUser["PERSONAL_NOTES"]?>  
				<?endif;?>
				</div>
					<div class="right-right">
            <input class="orange select-sertificate" id="sert" type="submit" value="�������� ����������" />
            <div class="presents">
																		������� ������� <a class="showpUp" href="#certificate-presented-user"><?=count($presentCert)?> ��������</a>
				            </div>
            <div class="read-blog">
                <a href="/community/blog/<?=$arBlog["URL"]?>/">������ ����</a>
            </div>                                            
            
                    </div>
        <div class="clear"></div>
    </div>
	<?}
	endif;
	?>

	<?
		$arUser = CIUser::GetUserInfo($user_id);
		$uStr = $arUser['ID'].$arUser['DATE_REGISTER'].$arUser['EMAIL'];
		$uStrMd = md5($uStr);
		?>

	<?
	ob_start();

	if ($_REQUEST["tab"]=="have"):

      $APPLICATION->IncludeComponent("individ:wish.list", "have.my", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID,
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "N",
            "SORT_BY" => $_REQUEST["sortby"],
            "SORT_ORDER" => $_REQUEST["sortorder"]
        )); 
  
    
    else:
        $APPLICATION->IncludeComponent("individ:wish.list", "wish.my", array(
            "CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
            "WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
            "USER_ID" => $user_id,
            "STATUS" => '',
            "ITEMS_COUNT" => 15,
            "ALL_EXCEPT_ALREADY_HAVE" => "Y"
        )); 

	endif;

	$out1 = ob_get_contents();

	ob_end_clean();

	//var_dump($out1, $out2);
	?>
		
    <div class="product-type-selector ie7-bug">
        <ul>
            <?if ($_REQUEST["tab"]=="have"):?>
                <li>
                    <span><span><a href="?tab=wish<?if($_REQUEST["showMe"]=="Y"):?>&showMe=Y<?endif?>">����</a></span></span>
                </li>
                <li class="selected">
                    <span><span>��� ����</span></span>
                </li>            
            <?else:?>
                <li class="selected">
                    <span><span>����</span></span>
                </li>
                <li>
                    <span><span><a href="?tab=have<?if($_REQUEST["showMe"]=="Y"):?>&showMe=Y<?endif?>">��� ����</a></span></span>
                </li>
            <?endif?>
        </ul>
    </div>
    
    <?if ($_REQUEST["tab"] == "have"):?>
    <div class="sort-layer">
        <div class="left-left">
            ����������� ��:
        </div>
        <?if ($_REQUEST["sortby"] == "NAME"):?>
            <div class="product-type-selector ie7-bug">
                <ul>
                    <li>
                        <span><span><a href="?tab=have&sortby=timestamp_x&sortorder=<?if($_REQUEST["sortorder"] == "ASC"):?>DESC<?else:?>ASC<?endif?>">�������</a></span></span>
                    </li>
                    <li class="selected">
                        <span><span><nobr><a href="?tab=have&sortby=NAME&sortorder=<?if($_REQUEST["sortorder"] == "DESC"):?>ASC<?else:?>DESC<?endif?>">�������� <?if($_REQUEST["sortorder"] == "ASC"):?>&#9650;<?else:?>&#9660;<?endif?></a></nobr></span></span>
                    </li>
                </ul>
            </div>         
        <?else:?>
            <div class="product-type-selector ie7-bug">
                <ul>
                    <li class="selected">
                        <span><span><nobr><a href="?tab=have&sortby=timestamp_x&sortorder=<?if($_REQUEST["sortorder"] == "ASC"):?>DESC<?else:?>ASC<?endif?>">������� <?if($_REQUEST["sortorder"] == "ASC"):?>&#9650;<?else:?>&#9660;<?endif?></a></nobr></span></span>
                    </li>
                    <li>
                        <span><span><a href="?tab=have&sortby=NAME&sortorder=<?if($_REQUEST["sortorder"] == "DESC"):?>ASC<?else:?>DESC<?endif?>">��������</a></span></span>
                    </li>
                </ul>
            </div>   
        <?endif?>     
        <div class="clear"></div>
    </div>
    <?endif?>
    
    <div class="clear"></div>

    <?if ($_REQUEST["tab"] != "have"):?>
	
        <div class="sub-selector-line">
            <div class="left-left">
				
				<?if($sum>0):?>
                <a class="presents" href="#certifFriend">���� ����������� �� ����� <?=$sum?> ���.</a>
				<?endif;?>
            </div>
		
			
		<?
				preg_match_all('/item.*?img.*?src="(.*?)".*?product\-name.*?>(.*?)<.*?right\-right.*?price.*?>(.*?)</is',$out1,$match);
				//preg_match_all('/price.*(.*?)</is',$out1,$match);
				//print_R();
				if(is_array($match) && isset($match[1][0])){
					$desc = $match[2][0];
					$img = $match[1][0];
					if(!empty($img) && !preg_match("/http/is",$img)){
						$img = "http://mamingorodok.individ.ru".$img;
					}
					$price = $match[3][0];
					if(!empty($price)){
						$desc.=" ����:".$price;
					}
					
					if(empty($desc)){
						$desc ="������ ������ - ��� ����� ������� ������� ����� ������� � ���������� ������� ����.";
					}
				}
			?>
            <div class="right-right">
                <ul>
                    <li class="icon-icon plus add-my"><a href="#addG">�������� ���� �������</a></li>                
                    <li class="icon-icon letter i-choose"><a href="#">�������� �������</a></li>                
                    <li class="send-to-friends">
						<?$APPLICATION->IncludeComponent("individ:main.share", "share", array(
							"HIDE" => "N",
							"HANDLERS" => array(
								0 => "vk",
								1 => "twitter",
								2 => "facebook",
								3 => "lj",
								4 => "mailru"
							),
							"PAGE_URL" => htmlspecialcharsback("/community/user/".$USER->GetID()."/?s=".$uStrMd),
							"PAGE_TITLE" => "������� ��� ������ ������ �� ����� ����� �������",
							"PAGE_DESCRIPTION"=> $desc,
							"PAGE_IMAGE" => htmlspecialcharsback($img),
							"SHORTEN_URL_LOGIN" => "",
							"SHORTEN_URL_KEY" => ""
							),
							false
						);?>
					</li>                
                </ul>
            </div>
            <div class="clear"></div>
        </div>
		
		
		
		<div id="FriendsRecomend" class="ifancy">
			<div class="white_plash"><div class="exitpUp"></div>
			<div class="cn tl"></div>
			<div class="cn tr"></div>
			<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
			
				<div class="title">���������� "������� ������"</div>
				<form class="jqtransform" action="?">
				<div class="data">
				<div class="left_part">
					<label for="femail">����������� �����</label>
					<div class="clear"></div>
					<input type="text" id="femail" style="width:216px;"/>
					<div class="clear"></div>
					<input type="submit" class="nbm" value="�������������">
				</div>
				<?
				global $USER;
				$APPLICATION->IncludeComponent("individ:socialnetwork.user_friends","sendmail",array(
					"SET_NAV_CHAIN"=>"N",
					"ITEMS_COUNT"=>10,
					"ID"=>$USER->GetID()
				));?>
				</div>
				<div class="clear"></div>
				</form><div class="clear"></div>
			</div></div></div>
			<div class="cn bl"></div>
			<div class="cn br"></div>
			</div>
		</div>
		
		<div id="add-my" class="ifancy">
			<div class="white_plash">
				<div class="exitpUp"></div>
				<div class="cn tl"></div>
				<div class="cn tr"></div>
				<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
					<div class="title">�������� ���� �������</div>

					<?$APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "ifancy", array(
						"IBLOCK_TYPE" => "community",
						"IBLOCK_ID" => WISHLIST_IBLOCK_ID,
						"STATUS_NEW" => "N",
						"LIST_URL" => "",
						"USE_CAPTCHA" => "N",
						"USER_MESSAGE_EDIT" => "",
						"USER_MESSAGE_ADD" => "",
						"DEFAULT_INPUT_SIZE" => "30",
						"RESIZE_IMAGES" => "Y",
						"PROPERTY_CODES" => array(
							0 => "NAME",
							1 => "408",
							2 => "PREVIEW_TEXT",
							
						),
						"PROPERTY_CODES_REQUIRED" => array(
							0 => "NAME",
						),
						"GROUPS" => array(
							"2"
						),
						"STATUS" => array(
						),
						"ELEMENT_ASSOC" => "PROPERTY_ID",
						"ELEMENT_ASSOC_PROPERTY" => WISHLIST_USER_ID_PROPERTY_ID,
						"MAX_USER_ENTRIES" => "100000",
						"MAX_LEVELS" => "100000",
						"LEVEL_LAST" => "Y",
						"MAX_FILE_SIZE" => "0",
						"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",
						"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
						"SEF_MODE" => "N",
						"SEF_FOLDER" => "/community/user/1/",
						"CUSTOM_TITLE_NAME" => "",
						"CUSTOM_TITLE_TAGS" => "",
						"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
						"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
						"CUSTOM_TITLE_IBLOCK_SECTION" => "",
						"CUSTOM_TITLE_PREVIEW_TEXT" => "��������",
						"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
						"CUSTOM_TITLE_DETAIL_TEXT" => "",
						"CUSTOM_TITLE_DETAIL_PICTURE" => "",
						
						"AJAX_MODE" => "Y",
						"AJAX_OPTION_JUMP" => "N"
						
						),
						$component
					);?>
					
				</div></div></div>
				<div class="cn bl"></div>
				<div class="cn br"></div>
			</div>
		</div>
		
		
		
		
		
		<div id="i-choose" class="ifancy">
			<div class="white_plash">
				<div class="exitpUp"></div>
				<div class="cn tl"></div>
				<div class="cn tr"></div>
				<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
					<div class="title">������ �� ���� ������</div>
					<p>�� ������ ������ ����� ������������ ����� ������� ���� ������.</p>
					<br/>
					<?global $USER;?>
					<p><input type="text" style='width:610px' value='http://<?=SITE_SERVER_NAME?>/community/user/<?=$USER->GetID()?>/?s=<?=$uStrMd?>'></p>
				</div></div></div>
				<div class="cn bl"></div>
				<div class="cn br"></div>
			</div>
		</div>
		
    <?endif?>  
    
    <?
    if (strlen($_REQUEST["sortby"]) == 0)
        $_REQUEST["sortby"] = "timestamp_x";
    if (strlen($_REQUEST["sortorder"]) == 0)
        $_REQUEST["sortorder"] = "DESC";
    ?>    

   <?echo $out1;?>

<?else: // ������������ ������� ����� ������� ?>

	<?$APPLICATION->IncludeComponent("individ:user.profile.top", "", array(
		"USER_ID" => $user_id,
		"CURRENT_USER_ID" => $current_user_id,
		"IS_FRIENDS" => CSocNetUserRelations::IsFriends($user_id, $current_user_id),
		"CURRENT_PAGE" => "BABY_LIST"

	));?>

	<?
	$isCode = false;
	
	if($_REQUEST['s'])
	{
		$arUser = CIUser::GetUserInfo($user_id);
		$uStr = $arUser['ID'].$arUser['DATE_REGISTER'].$arUser['EMAIL'];
		$uStrMd = md5($uStr);
		
		if($uStrMd==$_REQUEST['s'])
		{
			$isCode = true;
		}
	}
	?>
	
	<?if(CSocNetUserRelations::IsFriends($user_id, $current_user_id) || $isCode):?>
	
		<div class="product-type-selector ie7-bug">
			<ul>
				<?if ($_REQUEST["tab"]=="have"):?>
					<li>
						<span><span><a href="?tab=wish<?if(isset($_REQUEST["s"])):?>&s=<?=$_REQUEST["s"]?><?endif;?>">����</a></span></span>
					</li>
					<li class="selected">
						<span><span>��� ����</span></span>
					</li>            
				<?else:?>
					<li class="selected">
						<span><span>����</span></span>
					</li>
					<li>
						<span><span><a href="?tab=have<?if(isset($_REQUEST["s"])):?>&s=<?=$_REQUEST["s"]?><?endif;?>">��� ����</a></span></span>
					</li>
				<?endif?>
			</ul>
		</div>

		<?if ($_REQUEST["tab"]=="have"):?>
		
			<?$APPLICATION->IncludeComponent("individ:wish.list", "have.user", array(
				"CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
				"WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
				"USER_ID" => $user_id,
				"STATUS" => WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID,
				"ITEMS_COUNT" => 15,
				"ALL_EXCEPT_ALREADY_HAVE" => "N",
				"SORT_BY" => $_REQUEST["sortby"],
				"SORT_ORDER" => $_REQUEST["sortorder"]
			));?> 
	  
		
		<?else:?>
		
			<?$APPLICATION->IncludeComponent("individ:wish.list", "wish.user", array(
				"CATALOG_IBLOCK_ID" => CATALOG_IBLOCK_ID,
				"WISHLIST_IBLOCK_ID" => WISHLIST_IBLOCK_ID,
				"USER_ID" => $user_id,
				"STATUS" => '',
				"ITEMS_COUNT" => 15,
				"ALL_EXCEPT_ALREADY_HAVE" => "Y"
			));?> 

		<?endif?>
	<?else:?>
	
		<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/NotFriends.php"), array(), array("MODE"=>"html") );?>
	
	<?endif?>
	
<?endif?>


<div id="certificates-selector" class="CatPopUp<?if(!$USER->IsAuthorized()):?> shortt-certificates-selector<?endif?>">
    <div class="white_plash">
    <div class="exitpUp"></div>
    <div class="cn tl"></div>
    <div class="cn tr"></div>
    <div class="content"><div class="content"><div class="content"> <div class="clear"></div>
	
		<input type="hidden" value="<?=$user_id?>" id="cur_user">
		<input type="hidden" value="<?=$current_user_id?>" id="this_user">
		<?if($USER->IsAuthorized()):?> 
		<div class="title">�������� �����������</div>
	   <?else:?>
		<div class="title">��� ������� ������������ ����� ��������������</div>
	   <?endif;?>
	   <?if ($current_user_id == $user_id):?>
			�� �� ������ �������� ���� ����������.
		<?else:?>
		<?
		global $USER;
		if($USER->IsAuthorized()):?>
		<div class="dt">
	    <table><tr><td>
		<div class="datamy">
       
      
		
		<?$APPLICATION->IncludeComponent("individ:certificate.my.list","",array(
		"IBLOCK_TYPE"=>"certificate",
		"IBLOCK_ID"=>CERTIFICATES_IBLOCK_ID,
		"USER_ID"=>$current_user_id,
		"CACHE_GROUPS"=>"N"
		));?>
		
       
        
		</div>
		</td><td>
		
		<div class="data">
        <div class="sub-title">������ ����������� � ��������</div>
		
		<?$APPLICATION->IncludeComponent("bitrix:news.list","certificate.buy.user",array(
			"IBLOCK_TYPE" => "certificate",	// ��� ��������������� ����� (������������ ������ ��� ��������)
			"IBLOCK_ID" => "4",	// ��� ��������������� �����
			"NEWS_COUNT" => "20",	// ���������� �������� �� ��������
			"SORT_BY1" => "ACTIVE_FROM",	// ���� ��� ������ ���������� ��������
			"SORT_ORDER1" => "DESC",	// ����������� ��� ������ ���������� ��������
			"SORT_BY2" => "SORT",	// ���� ��� ������ ���������� ��������
			"SORT_ORDER2" => "ASC",	// ����������� ��� ������ ���������� ��������
			"FILTER_NAME" => "",	// ������
			"FIELD_CODE" => array(	// ����
				0 => "",
				1 => "",
			),
			"PROPERTY_CODE" => array(	// ��������
				0 => "PRICE",
				1 => "",
			),
			"CHECK_DATES" => "Y",	// ���������� ������ �������� �� ������ ������ ��������
			"DETAIL_URL" => "",	// URL �������� ���������� ��������� (�� ��������� - �� �������� ���������)
			"AJAX_MODE" => "Y",	// �������� ����� AJAX
			"AJAX_OPTION_SHADOW" => "Y",	// �������� ���������
			"AJAX_OPTION_JUMP" => "N",	// �������� ��������� � ������ ����������
			"AJAX_OPTION_STYLE" => "Y",	// �������� ��������� ������
			"AJAX_OPTION_HISTORY" => "N",	// �������� �������� ��������� ��������
			"CACHE_TYPE" => "A",	// ��� �����������
			"CACHE_TIME" => "36000000",	// ����� ����������� (���.)
			"CACHE_FILTER" => "N",	// ���������� ��� ������������� �������
			"CACHE_GROUPS" => "Y",	// ��������� ����� �������
			"PREVIEW_TRUNCATE_LEN" => "",	// ������������ ����� ������ ��� ������ (������ ��� ���� �����)
			"ACTIVE_DATE_FORMAT" => "d.m.Y",	// ������ ������ ����
			"SET_TITLE" => "N",	// ������������� ��������� ��������
			"SET_STATUS_404" => "N",	// ������������� ������ 404, ���� �� ������� ������� ��� ������
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// �������� �������� � ������� ���������
			"ADD_SECTIONS_CHAIN" => "N",	// �������� ������ � ������� ���������
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// �������� ������, ���� ��� ���������� ��������
			"PARENT_SECTION" => "",	// ID �������
			"PARENT_SECTION_CODE" => "",	// ��� �������
			"DISPLAY_TOP_PAGER" => "N",	// �������� ��� �������
			"DISPLAY_BOTTOM_PAGER" => "Y",	// �������� ��� �������
			"PAGER_TITLE" => "�������",	// �������� ���������
			"PAGER_SHOW_ALWAYS" => "N",	// �������� ������
			"PAGER_TEMPLATE" => "",	// �������� �������
			"PAGER_DESC_NUMBERING" => "N",	// ������������ �������� ���������
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// ����� ����������� ������� ��� �������� ���������
			"PAGER_SHOW_ALL" => "N",	// ���������� ������ "���"
			"DISPLAY_DATE" => "Y",	// �������� ���� ��������
			"DISPLAY_NAME" => "Y",	// �������� �������� ��������
			"DISPLAY_PICTURE" => "Y",	// �������� ����������� ��� ������
			"DISPLAY_PREVIEW_TEXT" => "Y",	// �������� ����� ������
			"AJAX_OPTION_ADDITIONAL" => "",	// �������������� �������������
		
		));?>
		
        </div>
		</td>
		</tr>
		</table>
		
		</div>
		<?else:?>
			<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth2", array(
				"REGISTER_URL" => "/personal/registaration/",
				"FORGOT_PASSWORD_URL" => "/personal/profile/forgot-password/",
				"PROFILE_URL" => "/personal/profile/auth/",
				"SHOW_ERRORS" => "N"
				),
				false
			);?>
			<div class="clear"></div>
		<?endif;?>
		<?endif;?>
    </div></div></div>
    <div class="cn bl"></div>
    <div class="cn br"></div>
    </div>
</div> 

<div id="made-a-gift">
			<div class="white_plash"><div class="exitpUp"></div>
			<div class="cn tl"></div>
			<div class="cn tr"></div>
			<div class="content"><div class="content"><div class="content"> <div class="clear"></div>
			
				<div class="title">����������� ��������</div>
				<?$i=0;?>
				<?$us = array();?>
				<?foreach($presentCert as $pres):?>
					<?if(!in_array($pres["PROPERTY_USER_BY_VALUE"],$us)):?>
						<?
						$rsUser = CUser::GetByID($pres["PROPERTY_USER_BY_VALUE"]);
						$arUser = $rsUser->Fetch();
						
						$name = "";
						if(!empty($arUser["NAME"])){
							$name = $arUser["NAME"];
						}
						
						if(!empty($arUser["LAST_NAME"])){
							if(!empty($name))
								$name .= " ".$arUser["NAME"];
							else
								$name = $arUser["NAME"];
						}
						
						if(empty($name))
							$name = $arUser["LOGIN"];
						
						?>
						<div class="user_item">
							<div class="user_foto">
								<?if(!empty($arUser["PERSONAL_PHOTO"])):?>
									<?=ShowImage($arUser["PERSONAL_PHOTO"],100,100,"border='0'")?>
								<?else:?>
									<?=ShowImage(SITE_TEMPLATE_PATH."/images/profile_img.png",100,100,"border='0'")?>
								<?endif;?>
							</div>
							<div class="user_name"><a href="/community/user/<?=$arUser["ID"]?>/"><?=$name?></a></div>
						</div>
						<?$i++;?>
						<?if($i==4):?>
							<div class="clear"></div>
							<?$i=0;?>
						<?endif;?>
					<?endif;?>
					<?$us[] = $pres["PROPERTY_USER_BY_VALUE"];?>
				<?endforeach;?>
				
				<div class="clear"></div>
			</div></div></div>
			<div class="cn bl"></div>
			<div class="cn br"></div>
			</div>
		</div>