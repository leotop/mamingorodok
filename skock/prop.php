<?
die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

$arBasketItems = array();

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
		"CAN_BUY", "PRICE", "WEIGHT")
);
while ($arItems = $dbBasketItems->Fetch())
{
	if (strlen($arItems["CALLBACK_FUNC"]) > 0)
	{
		CSaleBasket::UpdatePrice($arItems["ID"],
			$arItems["CALLBACK_FUNC"],
			$arItems["MODULE"],
			$arItems["PRODUCT_ID"],
			$arItems["QUANTITY"]);
		$arItems = CSaleBasket::GetByID($arItems["ID"]);
	}

	$db_res = CSaleBasket::GetPropsList(
		array(
			"SORT" => "ASC",
			"NAME" => "ASC"
		),
		array("BASKET_ID" => $arItems["ID"])
	);
	while ($ar_res = $db_res->Fetch())
	{
		echo '<pre>'.print_r($ar_res, true).'</pre>';;
	}


	$arBasketItems[] = $arItems;
}

// Печатаем массив, содержащий актуальную на текущий момент корзину
echo "<pre>";
print_r($arBasketItems);
echo "</pre>";

die();

$rsO = CIBlockElement::GetList(Array(), array("ID"=>37669), false, false, array("IBLOCK_ID", "PROPERTY_SIZE", "ID", "PROPERTY_CML2_LINK.PROPERTY_CH_VYBIRAEM"));
if($arO = $rsO -> GetNext())
{
	$arProp = array("NAME" => empty($arO["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"])?'Размер':$arO["PROPERTY_CML2_LINK_PROPERTY_CH_VYBIRAEM_VALUE"], "CODE" => "SIZE", "VALUE" => $arO["PROPERTY_SIZE_VALUE"]);
	echo '<pre>'.print_r($arProp, true).'</pre>';
}


die();

// set links producer - section / ignore 1C settings
$arProdSecLinks = array();
$rsAllSec = CIBlockSection::GetList(Array(),
	array(
		"IBLOCK_ID" => CATALOG_IBLOCK_ID,
		"ACTIVE"    => "Y"
	), false
);
while($arAllSec = $rsAllSec -> GetNext())
{
	if($arAllSec["IBLOCK_SECTION_ID"]>0)
		$arProdSecLinks[$arAllSec["ID"]] = $arAllSec["IBLOCK_SECTION_ID"];
}

$arProdLinks = array();
$rsAllProducers = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => PRODUCERS_IBLOCK_ID, "ACTIVE" => "Y"), false, false, array("ID"));
while($arAllProducers = $rsAllProducers -> GetNext())
	$arProdLinks[$arAllProducers["ID"]] = array(); // dont forget null producers

$rsP = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE" => "Y", "!PROPERTY_CH_SNYATO" => 2100916), array("PROPERTY_CH_PRODUCER", "IBLOCK_SECTION_ID"), false, array("IBLOCK_ID", "ID"));
while($arP = $rsP -> GetNext())
{
	if($arP["IBLOCK_SECTION_ID"]>0) $arProdLinks[$arP["PROPERTY_CH_PRODUCER_VALUE"]][] = $arP["IBLOCK_SECTION_ID"];
	if(isset($arProdSecLinks[$arP["IBLOCK_SECTION_ID"]]) && !in_array($arProdSecLinks[$arP["IBLOCK_SECTION_ID"]], $arProdLinks[$arP["PROPERTY_CH_PRODUCER_VALUE"]])) $arProdLinks[$arP["PROPERTY_CH_PRODUCER_VALUE"]][] = $arProdSecLinks[$arP["IBLOCK_SECTION_ID"]];
}

foreach($arProdLinks as $intProducerID => $arProducerSections)
{
	$arTmp = array();
	foreach($arProducerSections as $intProducerSection)
		$arTmp[] = array("VALUE" => $intProducerSection, "DESCRIPTION" => "Y");

	CIBlockElement::SetPropertyValues($intProducerID, PRODUCERS_IBLOCK_ID, $arTmp, "FILTER_LINK");
}

unset($arProdSecLinks);
unset($arProdLinks);
unset($arTmp);

die();

//$arPropLink = array(array("VALUE" => 301, "DESCRIPTION" => "Y"), array("VALUE" => 319, "DESCRIPTION" => "Y"));
//CIBlockElement::SetPropertyValues(41455, 5, $arPropLink, "FILTER_LINK");

$rsP = CIBlockElement::GetList(Array(), array("ID" => 11525), false, false, array("IBLOCK_ID", "ID", "PROPERTY_FILTER_LINK")); // 11525
$arP = $rsP -> GetNext();
echo '<pre>'.print_r($arP, true).'</pre>';





die();


if(!function_exists('getFileDir')) //Получение файлов из директории
	{
		function getFileDir($dir)
		{
			if(!empty($dir))
			{
				if(is_dir($dir))
				{
					$files = scandir($dir);  
					array_shift($files);
					array_shift($files);
					
					return $files;
				}
			}
			return array();
		}
	}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

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