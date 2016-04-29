<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

	if (!empty($arResult))
	{
		$previousLevel = 0;
		foreach($arResult as $arItem)
		{
			$cntHtml = '';
			switch($arItem["PARAMS"]["CNT"]) {
				case "BASKET":
					if (CModule::IncludeModule("sale")) {
						$dbBasketItems = CSaleBasket::GetList(
							array(),
							array(
								"FUSER_ID" => CSaleBasket::GetBasketUserID(),
								"LID" => SITE_ID,
								"ORDER_ID" => "NULL"
							),
							false,
							false,
							array("QUANTITY")
						);
						while ($arItems = $dbBasketItems->Fetch())
							$intCnt += $arItems["QUANTITY"];

						if($intCnt>0) $cntHtml = ' <span class="mnuCnt js-cartCnt">'.$intCnt.'</span>';
					}
				break;

				case "TRACK":
					if(CModule::IncludeModule("iblock")) {
						$rsICnt = CIBlockElement::GetList(Array("SORT" => "ASC"), array(
							"IBLOCK_ID" => 16, "PROPERTY_DELETED" => false, "CREATED_BY" => $USER -> GetID()
						), array());
						if($rsICnt>0) $cntHtml = ' <span class="mnuCnt">'.$rsICnt.'</span>';
					}
				break;

				case "OWN":
					if(CModule::IncludeModule("sale") && CModule::IncludeModule("iblock")) {
						$arFilter = Array("USER_ID" => $USER->GetID(), "STATUS" => "F");
						$rsOrders = CSaleOrder::GetList(array(), $arFilter);
						while($arOrder = $rsOrders -> GetNext())
							$arResult["ORDER_ID"][] = $arOrder["ID"];

						if(!empty($arResult["ORDER_ID"])) {
							$dbBasketItemsCnt = CSaleBasket::GetList(array("ID" => "ASC"), array("ORDER_ID" => $arResult["ORDER_ID"]), array());
							if($dbBasketItemsCnt>0) $cntHtml = ' <span class="mnuCnt">'.$dbBasketItemsCnt.'</span>';
						}
					}
				break;

				case "WISHLIST":
					if(CModule::IncludeModule("iblock")) {
						$rsICnt = CIBlockElement::GetList(Array("ID" => "DESC"), array(
							"ACTIVE" => "Y",
							"IBLOCK_ID" => 8,
							"PROPERTY_DELETED" => false,
							"PROPERTY_USER_ID" => $USER -> GetID()
						), array());
						if($rsICnt>0) $cntHtml = ' <span class="mnuCnt">'.$rsICnt.'</span>';
					}
				break;
			}



			if($arItem["DEPTH_LEVEL"] == 1)
			{
				if($previousLevel == 2) echo '</ul>';
				echo '<h3>'.$arItem["TEXT"].'</h3>';
				if($arItem["IS_PARENT"]) echo '<ul class="submenu">';
			} else {
				?><li><a<?=($arItem["SELECTED"]?' class="active"':'')?> href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a><?=$cntHtml?></li><?
			}
			$previousLevel = $arItem["DEPTH_LEVEL"];
	}
	
	if ($previousLevel == 2) echo '</ul>';
}?>