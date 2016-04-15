<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if (CModule::IncludeModule("iblock")){
function saleCerf(){
	
	$sale = 0;
	if(isset($_SESSION["certificates"]) && !empty($_SESSION["certificates"]) && is_array($_SESSION["certificates"]) && count($_SESSION["certificates"])>0){
		foreach($_SESSION["certificates"] as $k=>$val){
			$price = 0;
			$db_props = CIBlockElement::GetProperty(CERTIFICATES_IBLOCK_ID, $k, array("sort" => "asc"), Array("CODE"=>"PRICE"));
			if($ar_props = $db_props->Fetch())	
				$price = IntVal($ar_props["VALUE"]);
			$sale += $price*$val;
		}
	}
	return $sale;
}

function clearSale($v){
	$sale = 0;
	if(isset($_SESSION["certificates"]) && !empty($_SESSION["certificates"]) && is_array($_SESSION["certificates"]) && count($_SESSION["certificates"])>0){
		foreach($_SESSION["certificates"] as $k=>$val){
			$up = -1;
			$price = 0;
			$db_props = CIBlockElement::GetProperty(CERTIFICATES_IBLOCK_ID, $k, array("sort" => "asc"), Array("CODE"=>"PRICE"));
			if($ar_props = $db_props->Fetch())	
				$price = IntVal($ar_props["VALUE"]);
			if($sale+$price*$val>$v){
				for($i=$val;$i>0;$i--)
					if($sale+$price*$i<$v){
						$sale += $price*$i;
						$up = $i;
					}
			}
			else{
				$sale += $price*$val;
				$up = $val;
			}
			if($up>-1){
				$_SESSION["certificates"][$k] = $up;
			}
			else
				unset($_SESSION["certificates"][$k]);
		}
	}
	return $sale;
}
?>
<?
if (CModule::IncludeModule("sale")){

	//���������� ���-��
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="updateQuantity"){
		//id ������
		$product_id = intval($_REQUEST["id"]);
		//����������
		$count = intval($_REQUEST["count"]);
		
		
			
		//��������� ���������� ������
		if($product_id>0 && $count>0){
			$result = array ("error"=>0);
			
			//�������� �������
			$dbBasketItems = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					),
				false,
				false,
				array("ID", "CALLBACK_FUNC", "MODULE", 
              "PRODUCT_ID", "QUANTITY", "DELAY", 
              "CAN_BUY", "PRICE")
				);
			
			//���������� ������ �������
			$allVulue = 0;
			while ($arItems = $dbBasketItems->Fetch())
				{
					if($arItems["PRODUCT_ID"]==$product_id){
						$arItems["QUANTITY"] = $count;
						CSaleBasket::UpdatePrice($arItems["ID"], 
							 $arItems["CALLBACK_FUNC"], 
							 $arItems["MODULE"], 
							 $arItems["PRODUCT_ID"], 
							 $arItems["QUANTITY"]);
						$result["value"] = $count*$arItems["PRICE"];
						
					}
					//������ ����� ���������
					$allVulue += $arItems["PRICE"]*$arItems["QUANTITY"];
				}
			$result["allValue"] = $allVulue;
			$sale = saleCerf();
			
			//��������� �� �������
			$result["allValueSale"] = $allVulue - $sale;
		}
		else
			$result = array ("error"=>"Incorrect value");
		echo json_encode($result);
	}
	//���������� ���-�� END
	
	//�������� �������� �� �������
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="deleteElement"){
		//id ������
		$product_id = intval($_REQUEST["id"]);
		//��������� ���������� ������
		if($product_id>0){
			$result = array ("error"=>0);
			//�������� �������
			$dbBasketItems = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					),
				false,
				false,
				array("ID", "NAME", "CALLBACK_FUNC", "MODULE", 
				"PRODUCT_ID", "QUANTITY", "DELAY", 
				"CAN_BUY", "PRICE")
				);
			$allVulue = 0;
			while ($arItems = $dbBasketItems->Fetch())
				{
					if($arItems["PRODUCT_ID"]==$product_id){
						CSaleBasket::UpdatePrice($arItems["ID"], 
							 $arItems["CALLBACK_FUNC"], 
							 $arItems["MODULE"], 
							 $arItems["PRODUCT_ID"], 
							 $arItems["QUANTITY"]);
						$arItems = CSaleBasket::GetByID($arItems["ID"]);
						if(isset($_SESSION["PRODUCTS"][$product_id]))
						{
							 $arItems["QUANTITY"] +=$_SESSION["PRODUCTS"][$product_id]["QUANTITY"];
						}
						$_SESSION["PRODUCTS"][$product_id] = array(
							"PRODUCT_ID" => $arItems["PRODUCT_ID"],
							"PRODUCT_PRICE_ID" => $arItems["PRODUCT_PRICE_ID"],
							"PRICE" => $arItems["PRICE"],
							"CURRENCY" => $arItems["CURRENCY"],
							"WEIGHT" => $arItems["WEIGHT"],
							"QUANTITY" =>$arItems["QUANTITY"],
							"LID" => $arItems["LID"],
							"DELAY" => $arItems["DELAY"],
							"CAN_BUY" => $arItems["CAN_BUY"],
							"NAME" => $arItems["NAME"],
							"CALLBACK_FUNC" => $arItems["CALLBACK_FUNC"],
							"MODULE" => $arItems["MODULE"],
							"ORDER_CALLBACK_FUNC" => $arItems["ORDER_CALLBACK_FUNC"],
							"DETAIL_PAGE_URL" => $arItems["DETAIL_PAGE_URL"],
						);
						$result["name"] = iconv('cp1251', 'utf-8',trim($arItems["NAME"]));
						CSaleBasket::Delete($arItems["ID"]);
						$arItems["QUANTITY"] = 0;
					}
					$allVulue += $arItems["PRICE"]*$arItems["QUANTITY"];
				}
				$result["allValue"] = $allVulue;
				
				$sale = saleCerf();
				
				if($allVulue<$sale){
					$sale = 0;
					$sale = clearSale($value);
				}
			
				//��������� �� �������
				$result["SERTIFICATE"] = count($_SESSION["certificates"]);
				$result["SALE"] = $sale;
				$result["allValueSale"] = $allVulue - $sale;
		}
		else
			$result = array ("error"=>"Incorrect value");
		echo json_encode($result);
	}
	//�������� �������� �� ������� END
	
	
	//�������������� �������� � �������
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="repearElement"){
		//id ������
		$product_id = intval($_REQUEST["id"]);
		//��������� ���������� ������
		if($product_id>0){
			$result = array ("error"=>0);
			CSaleBasket::Add($_SESSION["PRODUCTS"][$product_id]);
			$dbBasketItems = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					),
				false,
				false,
				array("ID", "NAME", "CALLBACK_FUNC", "MODULE", 
				"PRODUCT_ID", "QUANTITY", "DELAY", 
				"CAN_BUY", "PRICE")
				);
			$allVulue = 0;
			
			while ($arItems = $dbBasketItems->Fetch())
				{
					CSaleBasket::UpdatePrice($arItems["ID"], 
						 $arItems["CALLBACK_FUNC"], 
						 $arItems["MODULE"], 
						 $arItems["PRODUCT_ID"], 
						 $arItems["QUANTITY"]);
					$arItems = CSaleBasket::GetByID($arItems["ID"]);
					if($arItems["PRODUCT_ID"]==$product_id){
						$arFilter = Array(       
							"ID"=>$arItems["PRODUCT_ID"],    
							"ACTIVE"=>"Y",      
						);
						
						$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("NAME","PROPERTY_COLOR","PROPERTY_SIZE", "PROPERTY_CML2_LINK","PROPERTY_PICTURE_MIDI"));
						
						if($ar_fields = $res->GetNext()){  
							$IMAGE = CFile::GetPath($ar_fields["PROPERTY_PICTURE_MIDI_VALUE"]);
							$COLOR = $ar_fields["PROPERTY_COLOR_VALUE"];
							$SIZE = $ar_fields["PROPERTY_SIZE_VALUE"];
							$arFilter2 = Array(       
							"ID"=>$ar_fields["PROPERTY_CML2_LINK_VALUE"],    
							"ACTIVE"=>"Y",      
							);
							$res2 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter2, false, false, array("IBLOCK_SECTION_ID","PROPERTY_RATING"));
							if($ar_fields2 = $res2->GetNext()){
								$RATING = $ar_fields2["PROPERTY_RATING_VALUE"];
								$URL = "/catalog/".$ar_fields2["IBLOCK_SECTION_ID"]."/".$ar_fields["PROPERTY_CML2_LINK_VALUE"]."/";
							}
						}
						ob_start();
						$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/includes/raiting.php", array("Raiting"=>$RATING));
						$html .= ob_get_contents();
						ob_end_clean();
						$result["html"] = '
							<tr class="line'.$arItems["PRODUCT_ID"].'">
							<td class="td1"><a href="'.$arItems["PRODUCT_ID"].'" class="delete"></a></td>
							<td class="td2">
							<div class="bskt_img">'.CFile::ShowImage($IMAGE,100,100).'</div>
							<div class="bskt_info">
							<div class="bskt_lnk"><a href="'.$URL .'">'.$arItems["NAME"].'</a></div>
							<div class="bskt_rtg"> '.$html.'</div>
							<div class="bskt_color">����: '.$COLOR .'</div>
							<div class="bskt_size">������: '.$SIZE.'</div>
							</div>
							<div class="clear"></div>
							</td>
							<td class="td3">'.intval($arItems["PRICE"]).' ���.</td>
							<td class="td4">�</td>
							<td class="td5"><input maxlength="18" id="'.$arItems["PRODUCT_ID"].'" type="text" name="QUANTITY_'.$arItems["ID"].'" value="'.intval($arItems["QUANTITY"]).'" class="QUANTITY" ></td>
							<td class="td7">=</td>
							<td class="td8"><span class="priceid'.$arItems["PRODUCT_ID"].'">'.$arItems["PRICE"]*$arItems["QUANTITY"].'</span> ���.</td>
							</tr>
							';
						$result["html"] = iconv('cp1251', 'utf-8',$result["html"]);
						$result["html"] = htmlspecialchars($result["html"]);
					}
					$allVulue += $arItems["PRICE"]*$arItems["QUANTITY"];
				}
			$result["allValue"] = $allVulue;
			
			
			
			$result["ALLCERT"] = $allVulue;
			
			//��������� �� �������
			$result["allValueSale"] = $allVulue - $sale;
			unset($_SESSION["PRODUCTS"][$product_id]);
			}
		else
			$result = array ("error"=>"Incorrect value");
		echo json_encode($result);
	}
	//�������������� �������� � ������� END
	
	//������ ������ �� ������������
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="certificate"){
		//id ������
		
		$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC"),
				array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					)
			);
			$count  = 0;
			$prices = 0;
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				$count +=$arBasketItems["QUANTITY"];
				$prices += $arBasketItems["PRICE"];
			}
			
		unset($_SESSION["certificates"]);
		$_SESSION["certificates"] = array();
		$arr = explode(";",$_REQUEST["ids"]);
		//��������� ���������� ������
		if(count($arr)>0){
			$result = array ("error"=>0);
			foreach($arr as $val){
				if($val!=0){
				$val = intval($val);
				if(isset($_SESSION["certificates"][$val]) && $_SESSION["certificates"][$val]>0)
					$_SESSION["certificates"][$val]++;
				else
					$_SESSION["certificates"][$val]=1;
					//echo $val." ".$_SESSION["certificates"][$val]." 1--";
				}
			}
			//print_R($_SESSION["certificates"]);
			//�������� �������
			$dbBasketItems = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					),
				false,
				false,
				array("ID", "NAME", "CALLBACK_FUNC", "MODULE", 
				"PRODUCT_ID", "QUANTITY", "DELAY", 
				"CAN_BUY", "PRICE")
				);
			$allVulue = 0;
			while ($arItems = $dbBasketItems->Fetch())
				{
					$allVulue += $arItems["PRICE"]*$arItems["QUANTITY"];
				}
			$result["allValue"] = $allVulue;
			
			$result["sale"] = saleCerf();
			if($prices<$result["sale"]){
				$result["sale"] =0;
				unset($_SESSION["certificates"]);
			}
			//��������� �� �������
			$result["allValueSale"] = $allVulue - $result["sale"];
		}
		else
			$result = array ("error"=>"Incorrect value");
		echo json_encode($result);
	}
	//������ ������ �� ������������ END
	
	//�������� ��������� � ���������
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="refreshPostPrice"){
		$result = array ("error"=>0);
		$location = intval($_REQUEST["location"]);
		if(preg_match("/[0-9a-zA-Z_]*/",$_REQUEST["postType"])){
			$id = $_REQUEST["postType"];
			$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC"),
				array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					)
			);
			$count  = 0;
			$prices = 0;
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				$count +=$arBasketItems["QUANTITY"];
				$prices += $arBasketItems["PRICE"];
			}
		
		
			$sale = saleCerf();
			
			$db_dtype = CSaleDelivery::GetList(    
				array(            
					"SORT" => "ASC",            
					"NAME" => "ASC"        
					),    
				array(            
					"LID" => SITE_ID,            
					"ACTIVE" => "Y", 
					"ID"=>$id,
					"LOCATION" => $location        
					),    false,    false,    array()
				);
			$cur = 0;
			if ($ar_dtype = $db_dtype->Fetch())
			{    
				$cur = $ar_dtype["PRICE"];
			}  
		
			$result["BASKET"]["COUNT"] = $count;
			$result["BASKET"]["PRICE"] = $prices-$sale;
			$result["BASKET"]["CERT"] = $sale;
			$result["BASKET"]["CUR"] = $cur;
		}
		else $result = array ("error"=>"Incorrect value");
		echo json_encode($result);
	}
	//�������� ��������� � ��������� END
	
	//������ ������ �� ������������
	if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="certificate2"){
		//id ������
		$dbBasketItems = CSaleBasket::GetList(
				array("NAME" => "ASC"),
				array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					)
			);
			$count  = 0;
			$prices = 0;
			while ($arBasketItems = $dbBasketItems->Fetch())
			{
				$count +=$arBasketItems["QUANTITY"];
				$prices += $arBasketItems["PRICE"];
			}
			
		unset($_SESSION["certificates"]);
		$_SESSION["certificates"] = array();
		$arr = explode(";",$_REQUEST["ids"]);
		//��������� ���������� ������
		if(count($arr)>0){
			$result = array ("error"=>0);
			foreach($arr as $val){
				if($val!=0){
				$val = intval($val);
				if(isset($_SESSION["certificates"][$val]) && $_SESSION["certificates"][$val]>0)
					$_SESSION["certificates"][$val]++;
				else
					$_SESSION["certificates"][$val]=1;
					//echo $val." ".$_SESSION["certificates"][$val]." 1--";
				}
			}
			//print_R($_SESSION["certificates"]);
			//�������� �������
			$dbBasketItems = CSaleBasket::GetList(
					array(
						"NAME" => "ASC",
						"ID" => "ASC"
					),
					array(
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					),
				false,
				false,
				array("ID", "NAME", "CALLBACK_FUNC", "MODULE", 
				"PRODUCT_ID", "QUANTITY", "DELAY", 
				"CAN_BUY", "PRICE")
				);
			$allVulue = 0;
			while ($arItems = $dbBasketItems->Fetch())
				{
					$allVulue += $arItems["PRICE"]*$arItems["QUANTITY"];
				}
			$result["allValue"] = $allVulue;
			
			$result["sale"] = saleCerf();
			if($prices<$result["sale"]){
				$result["sale"] =0;
				unset($_SESSION["certificates"]);
			}
			//��������� �� �������
			$result["allValueSale"] = $allVulue - $result["sale"];
		}
		else
			$result = array ("error"=>"Incorrect value");
			
		$location = intval($_REQUEST["location"]);
		$weight = intval($_REQUEST["weight"]);
		$delevery = addslashes($_REQUEST["delevery"]);
		$lang = addslashes($_REQUEST["lang"]);
		$arOrder = array(
					"PRICE" =>$result["allValueSale"],
					"WEIGHT" => $weight,
					"LOCATION_FROM" => COption::GetOptionInt('sale', 'location'),
					"LOCATION_TO" => $location,
				);
		$delevery = explode(":",$delevery);
		$arDeliveryPrice = CSaleDeliveryHandler::CalculateFull($delevery[0], $delevery[1], $arOrder, $lang);
		$result["delevery"] = $arDeliveryPrice;
		echo json_encode($result);
	}
	//������ ������ �� ������������ END
}
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>