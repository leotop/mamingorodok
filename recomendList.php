<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?global $USER;
if (!CModule::IncludeModule("forum")){
	return;
}
$user_id = $USER->GetID();
$answer = array("error"=>"1");
if($_REQUEST["do"]=="getChangeElement"){
	if (CModule::IncludeModule("iblock")){
		$tovarGetFullId = intval($_REQUEST["tovarGetFullId"]);
		$tovarGetShortId = intval($_REQUEST["tovarGetShortId"]);
		$recListId = intval($_REQUEST["recListId"]);
		if($tovarGetFullId>0 && $tovarGetShortId>0 && $recListId>0){
			//<!--- товар который будет полным
			$arFilter = Array(   
				"ID"=> $tovarGetFullId,
				"IBLOCK_ID"=>CATALOG_IBLOCK_ID
				);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter,false, false, array("*"));
			if($ar_fields = $res->GetNextElement()){
				$props = $ar_fields->GetProperties();
				$ar_fields = $ar_fields->fields;
				$ar_fields["PROPERTY"] = $props;
			$count_reports = CForumMessage::GetList(array("ID"=>"ASC"), array("FORUM_ID"=>FORUM_ID, "PARAM2"=>$tovarGetFullId), true);
			
			if(!$USER->IsAuthorized()):
				$IN_WISH = '<a class="showpUp greydot" href="#messageNoUser1">В список малыша</a>';
			else:
			$dbEl = CIBlockElement::GetList(Array(), Array("IBLOCK_ID"=>WISHLIST_IBLOCK_ID, "ACTIVE"=>"Y", "PROPERTY_USER_ID" => $user_id, "PROPERTY_PRODUCT_ID" => $tovarGetFullId, "!PROPERTY_STATUS"=> WISHLIST_PROPERTY_STATUS_ALREADY_HAVE_ENUM_ID ), false, false, array("ID", "IBLOCK_ID"));
				if($obEl = $dbEl->GetNext()) {   
					$IN_WISH = '<a class="greydot" href="/community/user/'.$USER->GetId().'/">Уже в списке малыша</a>';
					}
				else
					$IN_WISH = '<div class="action BabyList BabyList'.$tovarGetFullId.'" ><a class="add greydot " id="'.$tovarGetFullId.'" href="#">В список малыша</a><div class="clear"></div></div>';
			endif;	
				
			//print_R($recListId);
			$arFilter = Array(   
				"ID"=> $recListId,
				"IBLOCK_ID"=>CATALOG_IBLOCK_RECOMMENDETION_LIST_ID
				);
			$res2 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter,false, false, array("*"));
			$ar_fields2 = array();
			if($ar_fields2t = $res2->GetNextElement()){
				$props2 = $ar_fields2t->GetProperties();
				$ar_fields2t = $ar_fields2t->fields;
				$ar_fields2t["PROPERTY"] = $props2;
				//print_R($ar_fields2["PROPERTY"]["THUMB_REC"]);
				$ar_fields2 = $ar_fields2t;
			}
			$thumb = "";
			//echo $ar_fields["ID"];
			//print_R($ar_fields2["PROPERTY"]["THUMB_REC"]["VALUE"]);
			if(in_array($ar_fields["ID"],$ar_fields2["PROPERTY"]["THUMB_REC"]["VALUE"])){
						$thumb = '<div class="is-great"></div>';
					}
			ob_start();
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => intval($ar_fields["PROPERTY"]["RATING"]["VALUE"])));
			$raiting = ob_get_contents();
			ob_end_clean();
			$checked = "";
			if(isset($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"][$ar_fields["ID"]])):
				$checked = "checked";
			endif;
			
			if($count_reports>0){			
				$str = $count_reports." ".RevirewsLang($count_reports);
				$addstr = "reports";
			}
			else{
				$str = RevirewsLang($count_reports);
				$addstr = "comment";
			}
			
				
			$arFilter = Array(  
					"IBLOCK_ID"=>OFFERS_IBLOCK_ID,
					"ACTIVE"=>"Y",    
					"PROPERTY_CML2_LINK" => $tovarGetFullId
					);
			
			CModule::IncludeModule("catalog");
				$res3 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
				$buy3 = 0;
				while($ar_fields3 = $res3->GetNext()){  
					$ar_res3 = CCatalogProduct::GetByID($ar_fields3["ID"]);
					if(intval($ar_res3["QUANTITY"])>0)
						$buy3++;
				}

				$HAVEBUY="N";
				if($buy3>0){
					$HAVEBUY="Y";
				}
			if($HAVEBUY=="Y"):
				$btn = '<a href="/select-color-and-size.php?id='.$ar_fields["ID"].'" class="add-to-basket"></a>';
			else:
				$btn = '<a href="#" class="add-to-basket-none" onclick="return false;"></a>';
			endif;
			
			$fullBlock = '<div class="left-left">
							<div class="name-name-layer">
								<a  target="_blank" href="'.$ar_fields["DETAIL_PAGE_URL"].'" class="name-name">'.$ar_fields["NAME"].'</a>
							</div>
							<div class="img">
								<a  target="_blank" href="'.$ar_fields["DETAIL_PAGE_URL"].'">
								'.CFile::ShowImage($ar_fields["PREVIEW_PICTURE"], 95, 95, "border=0", "", false).'</a>
								'.$thumb.'
							</div>
							<div class="right-text">
								'.$raiting.'
								<a href="'.$ar_fields["DETAIL_PAGE_URL"].'#'.$addstr.'" class="reports-reports">'.$str.'</a>
								<div class="clear"></div>
								<div class="text-text">'.$ar_fields["PREVIEW_TEXT"].'</div>
							</div>
						</div>
						<div class="right-right">
							<div class="price"><span>от</span> '.$ar_fields["PROPERTY"]["PRICE"]["VALUE"].'<span>р</span></div>
							'.$btn.'
							<div class="heart"></div>'.$IN_WISH .'
							<div class="compare-checkbox-layer">
								<label><input type="checkbox" '.$checked.' class="add-to-compare-list-ajax" value="'.$ar_fields["ID"].'"> <a class="grey compare_link" href="/catalog/compare/"><a class="grey compare_link" href="/catalog/compare/">Сравнить</a></label>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>';
			
			$plusMinus = "";
			if(!empty($ar_fields["PROPERTY"]["PLUS"]["VALUE"])):
                $plusMinus .= '<div class="plus">
                    <div class="label-label">Плюсы</div>
                    <span>'.$ar_fields["PROPERTY"]["PLUS"]["VALUE"]["TEXT"].'</span>
                </div>';
			endif;
			if(!empty($ar_fields["PROPERTY"]["MINUS"]["VALUE"])):
                $plusMinus .= '<div class="minus">
                    <div class="label-label">Минусы</div>
                    <span>'.$ar_fields["PROPERTY"]["MINUS"]["VALUE"]["TEXT"].'</span>
                </div>';
			endif;
			
		
			}
			
			//<!--- товар который будет коротким
			$arFilter = Array(   
				"ID"=> $tovarGetShortId,
				"IBLOCK_ID"=>CATALOG_IBLOCK_ID
				);
			$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter,false, false, array("*"));
			if($ar_fields = $res->GetNextElement()){
				$props = $ar_fields->GetProperties();
				$ar_fields = $ar_fields->fields;
				$ar_fields["PROPERTY"] = $props;
			
			$thumb = "";
			if(in_array($ar_fields["ID"],$ar_fields2["PROPERTY"]["THUMB_REC"]["VALUE"])){
						$thumb = '<div class="is-great"></div>';
					}
			ob_start();
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/includes/raiting.php', array('Raiting' => intval($ar_fields["PROPERTY"]["RATING"]["VALUE"])));
			$raiting = ob_get_contents();
			ob_end_clean();
			$checked = "";
			if(isset($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"][$ar_fields["ID"]])):
				$checked = "checked";
			endif;
			
			$arFilter = Array(  
					"IBLOCK_ID"=>OFFERS_IBLOCK_ID,
					"ACTIVE"=>"Y",    
					"PROPERTY_CML2_LINK" => $tovarGetShortId
					);
			
			CModule::IncludeModule("catalog");
				$res2 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false,false,array("ID"));
				$buy1 = 0;
				while($ar_fields2 = $res2->GetNext()){  
					$ar_res2 = CCatalogProduct::GetByID($ar_fields2["ID"]);
					if(intval($ar_res2["QUANTITY"])>0)
						$buy1++;
				}

				$HAVEBUY="N";
				if($buy1>0){
					$HAVEBUY="Y";
				}
			if($HAVEBUY=="Y"):
				$btn = '<a class="add-to-basket" href="/select-color-and-size.php?id='.$ar_fields["ID"].'"></a> ';
			else:
				$btn = '<a href="#" class="add-to-basket-none" onclick="return false;"></a>';
			endif;
			
			//$answer
			$shortBlock = '<a class="name-name recommend-update" id="" href="'.$ar_fields["DETAIL_PAGE_URL"].'">'.$ar_fields["NAME"].'</a>
					<div class="clear"></div>
					<div class="left-left">
						<div class="img">
							<a href="'.$ar_fields["DETAIL_PAGE_URL"].'">'.CFile::ShowImage($ar_fields["PREVIEW_PICTURE"], 95, 95, "border=0", "", false).'</a>
							'.$thumb.'
						</div>                            
					</div>
					<div class="right-right">
						<div class="price"><span>от</span> '.$ar_fields["PROPERTY"]["PRICE"]["VALUE"].'<span>р</span></div>
							'.$btn.'
							<label class="tpf"><input type="checkbox" '.$checked.' class="add-to-compare-list-ajax" value="'.$ar_fields["ID"].'"> <a class="grey compare_link" href="/catalog/compare/">Сравнить</a></label>
					</div>';
			//echo $fullBlock;
			}
			//$fullBlock = addslashes($fullBlock);
			//$shortBlock = addslashes($shortBlock);
			$fullBlock = $APPLICATION->ConvertCharset($fullBlock, "WINDOWS-1251", "UTF-8");
			$fullBlock = htmlspecialchars($fullBlock);
			$shortBlock = $APPLICATION->ConvertCharset($shortBlock, "WINDOWS-1251", "UTF-8");
			$shortBlock = htmlspecialchars($shortBlock);
			$plusMinus = $APPLICATION->ConvertCharset($plusMinus, "WINDOWS-1251", "UTF-8");
			$plusMinus = htmlspecialchars($plusMinus);
			$answer = array("error"=>"0", "fullBlock"=> $fullBlock, "plusMinus"=>$plusMinus, "shortBlock"=>$shortBlock );
		}
	}
}
echo json_encode($answer);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>