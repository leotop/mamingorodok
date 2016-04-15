<?
die();
set_time_limit(0);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$el = new CIBlockElement;

$res = CIBlockElement::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "!PROPERTY_PICTURE_MAXI"=>false, ">=ID"=>33257), false, array("nPageSize"=>500), array("ID", "ACTIVE", "IBLOCK_ID", "PROPERTY_PICTURE_MAXI"));
echo $res -> NavPrint();
while($ar = $res -> GetNext())
{
	echo $ar["ID"].'<br>';
	$arSrc = CFile::MakeFileArray($ar["PROPERTY_PICTURE_MAXI_VALUE"]);	
	$strCopyPath = $_SERVER['DOCUMENT_ROOT'].'/upload/import/temp/'.$arSrc["name"];
	
	if($arSrc["size"]>0)
	{
		if(copy($arSrc["tmp_name"], $strCopyPath))
		{
			$MIDI = CIBlock::ResizePicture(CFile::MakeFileArray($strCopyPath), array("WIDTH"=>256, "HEIGHT"=>256, "METHOD"=>"resample", "COMPRESSION"=>95));
			CIBlockElement::SetPropertyValuesEx($ar["ID"], OFFERS_IBLOCK_ID, array("PICTURE_MIDI" => array($MIDI)));
			unlink($strCopyPath);
		} else {
			echo '<br>';
			echo $ar["ID"];
			die("cant copy");
		}
	}
}

die();


$db_res = CForumMessage::GetList(array("ID"=>"ASC"), array("TOPIC_ID"=>148));
				$i = 0;
				$rat = 0;
				$mesRaiting = new IForumMessageRating;
				while ($ar_res = $db_res->Fetch())
				{
					$rat += $mesRaiting->IGetRating($ar_res["ID"]);
					$i++;
				}
				echo $rat.' '.$i;
				
//UpdateRatingForTovar(11681, 148);

die();

if (CModule::IncludeModule("iblock"))
{
	/*$bs = new CIBlockSection;
	
	$rsS = CIBlockSection::GetList(Array(), array("IBLOCK_ID"=>2), false);
	while($arS = $rsS -> GetNext())
	{
		if(strlen($arS["CODE"])==1)
		{
			$bs->Update($arS["ID"], array("CODE"=>CUtil::translit($arS["NAME"], "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L"))));
			echo $arS["NAME"]." - ".CUtil::translit($arS["NAME"], "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L")).'<br>';
		}
	}*/
	
	$el = new CIBlockElement;
	$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>5, "CODE"=>false), false, Array("nTopCount"=>400), array("NAME", "ID", "CODE"));
	while($arI = $rsI -> GetNext())
	{
		if(strlen($arI["CODE"])<=0)
		{
			$strCode = CUtil::translit(trim($arI["NAME"]), "ru", array("max_len"=>100, "replace_space"=>"-", "change_case"=>"L"));
			$el->Update($arI["ID"], array("CODE"=>$strCode, "IBLOCK_ID"=>5));
			echo $arI["NAME"].' '.$strCode.'<br>';
		}
	}
}
?>