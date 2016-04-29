<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
			global $APPLICATION;

			
			foreach($arResult as $k=>$arPost)
			{
				//print_R($arPost["AUTHOR_ID"]);
				//echo "<br>";
				$rsUser = CUser::GetByID($arPost["AUTHOR_ID"]);
				if($arUser = $rsUser->Fetch()){

				$name = "";
				if(!empty($arUser["NAME"])){
					$name = $arUser["NAME"];
				}
				if(!empty($arUser["LAST_NAME"])){
					if(!empty($name))
						$name .= " ".$arUser["LAST_NAME"];
					else
						$name = $arUser["LAST_NAME"];
				}	
				
				if(empty($name)){
					$name = $arUser["LOGIN"];
				}
				
				//echo $name;
				$arPost["USER_NAME"] = $name;
				$arResult[$k] = $arPost;
				}
			}
		/*
		*/
	


		
?>