<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

if(!$USER -> IsAdmin()) die();

function getCP1251($arData)
{
	foreach($arData as $key => $val)
		$arData[$key] = iconv("CP866", "windows-1251", $val);
		
	return $arData;
}

if (($handle = fopen("babyexpert.csv", "r")) !== false)
{
	$el = new CIBlockElement;
	
	while (($arData = fgetcsv($handle, 1000, ";")) !== false)
	{
		//$arData = getCP1251($arData);
		
		//echo '<pre>'.print_r($arData, true).'</pre>';
		
		$intID = intval($arData[0]);
		$strXML = trim($arData[1]);
		$strName = trim($arData[2]);
		$strH1 = trim($arData[3]);
		$strModel = trim($arData[4]);
		$strModelRus = trim($arData[5]);
		$strTitle = trim($arData[6]);
		$strType = trim($arData[7]);
		$strDescr = trim($arData[8]);
		$strKeyw = trim($arData[9]);
		
		
		$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "ID"=>$intID), false, false, array("IBLOCK_ID", "ID"));
		if($arI = $rsI -> GetNext())
		{
			$arF = array("NAME" => $strName, "XML_ID" => $strXML);
			$arProp = array(
				"SEO_H1" => $strH1,
				"SEO_MODEL" => $strModel,
				"SEO_MODEL_RUS" => $strModelRus,
				"SEO_TYPE" => $strType,
				"title" => $strTitle,
				"description" => $strDescr,
				"keywords" => $strKeyw
			);
			
			foreach($arProp as $key => $val)
				if(strlen($arProp[$key]) == 0) unset($arProp[$key]);
			
			echo $arI["ID"];
			echo '<pre>'.print_r($arF, true).'</pre>';
			echo '<pre>'.print_r($arProp, true).'</pre>';
			
			$el->Update($arI["ID"], $arF);
			CIBlockElement::SetPropertyValuesEx($arI["ID"], 2, $arProp);

		}
    }
    fclose($handle);
}





die();



$el = new CIBlockElement;
$arF = array(
	"IBLOCK_ID" => 2,
	"ACTIVE" => "Y",
	"NAME" => "Детская кроватка Geuther Belvedere",
	"XML_ID" => "03-139-000010",
	"IBLOCK_SECTION_ID" => 319,
	"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/import/goods_files/03-139-000010/1.jpg'),
	"PREVIEW_PICTURE" => CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/upload/import/goods_files/03-139-000010/1.jpg'),
);
echo '<pre>'.print_r($arF, true).'</pre>';
if($PRODUCT_ID = $el->Add($arF))  echo "New ID: ".$PRODUCT_ID;else  echo "Error: ".$el->LAST_ERROR;




die();

$rsDir = getFileDir($_SERVER['DOCUMENT_ROOT'].'/upload/import/goods_files');
foreach($rsDir as $strDir)
{
	$rsFiles = getFileDir($_SERVER['DOCUMENT_ROOT'].'/upload/import/goods_files/'.$strDir);
	foreach($rsFiles as $strFile)
	{
		if(preg_match("/^11\.(jpg|gif|png|bmp|jpeg)?/is", $strFile))
		{
			
			$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "XML_ID"=>$strDir), false, false, array("ID"));
			if($arI = $rsI -> GetNext())
			{
				echo $strDir.' '.$strFile.' <a  target="_blank"href="http://www.mamingorodok.ru/bitrix/admin/iblock_element_edit.php?ID='.$arI["ID"].'&lang=ru&type=catalog&form_element_2_active_tab=edit5&IBLOCK_ID=2&find_section_section=-1">Open</a><br>';
			}
		}
	}
}
	
die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

$bs = new CIBlockSection;
$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>2, "<=DEPTH_LEVEL" => 2), false);
while($arS = $rsS -> GetNext())
{
	echo $arS["NAME"].' ['.$arS["ID"].']<br>';
	$arSF = array("UF_TITLE" => "", "UF_DESCRIPTION"=> "", "UF_KEYWORDS" => "", "UF_H1" => "", "UF_H2" => "", "UF_NAME_PAD" => "");
	$bs->Update($arS["ID"], $arSF);
}


die();


$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "!PROPERTY_CH_POST_PRIN_MATER"=>false), false, Array("nTopCount"=>500), array("ID", "IBLOCK_ID", "PROPERTY_CH_KOL_KOMPLEKT_TE", "PROPERTY_CH_POST_PRIN_MATER"));
echo $rsI -> SelectedRowsCount();
while($arI = $rsI -> GetNext())
{
	CIBlockElement::SetPropertyValues($arI["ID"], 2, array("VALUE" => $arI["~PROPERTY_CH_POST_PRIN_MATER_VALUE"]), "CH_KOL_KOMPLEKT_TE");
	CIBlockElement::SetPropertyValues($arI["ID"], 2, array("VALUE" => array("TEXT" => "", "TYPE" => "text")), "CH_POST_PRIN_MATER");
}

die();

CModule::IncludeModule("sale");

$rsI = CIBlockElement::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>2, ">ID"=>12065), false, false, array("ID", "IBLOCK_ID", "PROPERTY_FORUM_TOPIC_ID"));
while($arI = $rsI -> Fetch())
{
	UpdateRatingForTovar($arI["ID"], $arI["PROPERTY_FORUM_TOPIC_ID_VALUE"]);
	echo $arI["ID"].'<br>';
}
die();


$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2), false, false, array("ID", "DETAIL_PICTURE", "PREVIEW_PICTURE"));
while($arI = $rsI -> GetNext())
{
	if($arI["DETAIL_PICTURE"]>0 && $arI["PREVIEW_PICTURE"]<=0)
	{
		echo $arI["ID"].'<br>';
	}
}

// add user profile
/*$arUserProfile = array(
   "NAME" => "Профиль skock@mail.ru",
   "USER_ID" => 2991,
   "PERSON_TYPE_ID" => 1
);
echo $intUserProfile = CSaleOrderUserProps::Add($arUserProfile);

if($intUserProfile>0)
{
	$arUserProfileProp = array("USER_PROPS_ID" => $intUserProfile, "ORDER_PROPS_ID" => 2, "VALUE" => "236015");
	CSaleOrderUserPropsValue::Add($arUserProfileProp);
}
   */
 
 die();


if(!$USER -> IsAdmin()) die();

if(isset($_REQUEST["frmsent"]))
{
	$el = new CIBlockElement;
	
	$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "ACTIVE"=>"Y"), false, false, array("ID"));
	while($arI = $rsI -> GetNext())
		$el->Update($arI["ID"], array("ACTIVE"=>"N"));
	
	if(strlen($_REQUEST["props"])>0)
	{
		$_REQUEST["props"] = str_replace(" ", "", $_REQUEST["props"]);
		$arProps = explode(",", $_REQUEST["props"]);
	} else $arProps = array();
	
	if(is_array($arProps) && count($arProps)>0)
	{
		$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>2));
		while($arProp = $rsProp -> GetNext())
		{
			if($arProp["PROPERTY_TYPE"] == "L" && in_array($arProp["CODE"], $arProps))
			{
				$rsEnum = CIBlockProperty::GetPropertyEnum($arProp["CODE"], Array(), Array("IBLOCK_ID"=>2));
				while($arEnum = $rsEnum -> GetNext())
				{
					$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "XML_ID"=>$arEnum["XML_ID"]), false, false, array("ID"));
					if($arI = $rsI -> GetNext())
					{
						$el->Update($arI["ID"], array("ACTIVE"=>"Y"));
					} else {
						$arF = array(
							"IBLOCK_ID" => 17, "ACTIVE" => "Y", "NAME" => $arEnum["VALUE"], "XML_ID" => $arEnum["XML_ID"], "CODE" => CUtil::translit(trim($arEnum["VALUE"]), "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L")), "PREVIEW_TEXT" => $arEnum["ID"], "DETAIL_TEXT" => $arProp["CODE"]
						);
						$el->Add($arF);
					}
				}
			}
		}
	}
}

$arTmpAdded = array();
$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>17, "ACTIVE"=>"Y"), array("DETAIL_TEXT"), false, array("DETAIL_TEXT"));
if($rsI -> SelectedRowsCount()>0)
{
	while($arI = $rsI -> GetNext())
		$arTmpAdded[] = $arI["DETAIL_TEXT"];
}
?>
<form method="post">
	<input type="hidden" name="frmsent" value="Y" />
	Укажите символьные коды свйств из каталога, которые необходимо включить в ЧПУ. Не указанные, но заведенные ранее свойства будут деактивированы в ЧПУ.
	Пример: CH_AK_GROUP,CH_AK_KREPL_TYPE,CH_KOL_KOLVO_KOLES,CH_KOL_MEST,CH_KOL_TYPE,CH_KOL_TYPE_SKLAD,CH_KROV_TYPE,CH_MEH_KACH,CH_VID_NYANYA<br><br>
	<textarea style="width:700px; height:100px;" name="props"><?=implode(",", $arTmpAdded)?></textarea><br>
	<input type="submit" name="process" value="Обновить список свойств">
</form>