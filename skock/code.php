<?
die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$el = new CIBlockElement;

CIBlockElement::SetPropertyValues(39936, 2, "123", "PHASH");

die();


$res = CIBlockElement::GetList(Array("ID"=>"ASC"), array("IBLOCK_ID"=>3, "ACTIVE"=>"Y", "!PROPERTY_PICTURE_MAXI"=>false), false, array("nTopCount"=>10), array("ID", "ACTIVE", "IBLOCK_ID", "PROPERTY_PICTURE_MAXI"));
while($ar = $res -> GetNext())
{
	$MIDI = CIBlock::ResizePicture(array_merge(CFile::MakeFileArray($ar["PROPERTY_PICTURE_MAXI_VALUE"]), array("COPY_FILE"=>"Y")), array("WIDTH"=>256, "HEIGHT"=>256, "METHOD"=>"resample", "COMPRESSION"=>95));
	echo '<br>-----------------------------------------<br>'.$ar["ID"].'<br>';
	echo 'Исходник:<pre>'.print_r(CFile::MakeFileArray($ar["PROPERTY_PICTURE_MAXI_VALUE"]), true).'</pre>';
	echo 'Результат: <pre>'.print_r($MIDI, true).'</pre>';
	CIBlockElement::SetPropertyValuesEx($ar["ID"], OFFERS_IBLOCK_ID, array("PICTURE_MIDI" => array($MIDI)));
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