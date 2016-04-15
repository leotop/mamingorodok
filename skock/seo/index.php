<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

if(!$USER -> IsAdmin()) die();

@ini_set("memory_limit", "2048M");
@set_time_limit(0);
@ignore_user_abort(true);

setlocale(LC_ALL, "ru_RU.cp1251"); 
setlocale(LC_NUMERIC, "C"); 
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/auxiliary/CIExcelReader.php");  
CModule::IncludeModule("iblock");

?>

<form enctype="multipart/form-data" method="post">
	Файл в формате XLS (не XLSX!) формата<br>
	ID | Внешний код | Название | Заголовок | H1 Модель (SEO) | Модель RUS (SEO) | Тайтл	Тип (SEO) | Мета_описание | Ключевые слова
<br><input size="50" type="file" name="fileSeo" value="" /> <input type="submit" name="btnSend" value="Загрузить" />
</form><?



$strFile = $_FILES["fileSeo"]["tmp_name"];
if(file_exists($strFile))
{
	if($_FILES["fileSeo"]["type"] != "application/vnd.ms-excel")
	{
		echo '<div>Неверный тип файла</div>';
		die();
	}
	
	$intFoundCnt = 0;
	$arNotFound = array();
	$el = new CIBlockElement;
	
	$xml = new CIExcelReader($strFile);
	$arWorksheets = $xml->GetWorksheets();
	while($arData = $xml->GetNextDataFromWorksheet(0))
	{
		if($i > 0)
		{
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
			
			if($intID <= 0) continue;
			
			$rsI = CIBlockElement::GetList(Array(), array("IBLOCK_ID"=>2, "ID"=>$intID), false, false, array("IBLOCK_ID", "ID"));
			if($arI = $rsI -> GetNext())
			{
				$intFoundCnt++;
				
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
				
				//echo $arI["ID"];
				//echo '<pre>'.print_r($arF, true).'</pre>';
				//echo '<pre>'.print_r($arProp, true).'</pre>';
				
				$el->Update($arI["ID"], $arF);
				CIBlockElement::SetPropertyValuesEx($arI["ID"], 2, $arProp);
	
			} else $arNotFound[] = $arData;
		}
		
		$i++;
	}
	
	echo '<br><br>Обновлено: '.$intFoundCnt.'<br>';
	if(count($arNotFound)>0)
	{
		echo 'Не найдены по ID в каталоге:<br>';
		echo '<pre>'.print_r($arNotFound, true).'</pre>';
	}
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php"); ?>