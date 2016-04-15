<?
session_start();
define('NO_BITRIX_AUTOLOAD', true);   // !!!!!!!!!
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $nameeee;
$nameeee = "dir_files.xls";
require_once("PHPExcel.php");
function url_get_from_file(){
	global $nameeee;
	$name = dirname(__FILE__) . '/xls/'.$nameeee;
	if(file_exists($name)){
		$objReader = new PHPExcel_Reader_Excel5();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load( $name );
		$worksheet = $objPHPExcel->getActiveSheet();
		return get_last_url_for_file($worksheet);
		unset($objReader);
		unset($objPHPExcel);
	}
	else{
		require_once 'PHPExcel/IOFactory.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($name);
		unset($objWriter);
		unset($objPHPExcel);
	}
}
function search_last_url_for_file($handler){
	$highestRow = $handler->getHighestRow();
	$highestColumn = $handler->getHighestColumn();
	$res = array();
	if($highestColumn=="S"){
		for ($row = 1; $row <= $highestRow; $row++)
		{
			$cell = $handler->getCellByColumnAndRow(18, $row);
			$val = $cell->getValue();
			if($val==""){
				$cell = $handler->getCellByColumnAndRow(0,$row);
				$res["url"]=$cell->getValue();
				$res["row"]=$row;
				return $res;
			}
		}
	}
	else{
		$cell = $handler->getCellByColumnAndRow("A",1);
		$res["url"]=$cell->getValue();
		$res["row"]=1;
		return $res;
	}
	return array();
}
function get_last_url_for_file($handler){
	$highestRow = $handler->getHighestRow();
	$highestColumn = $handler->getHighestColumn();
	$res = array();
	if($highestColumn=="S"){
		for ($row = 1; $row <= $highestRow; $row++)
		{
			$cell = $handler->getCellByColumnAndRow(18, $row);
			$val = $cell->getValue();
			if($val==""){
				$cell = $handler->getCellByColumnAndRow(0,$row);
				$res["type"]=$cell->getValue();
				$cell = $handler->getCellByColumnAndRow(1,$row);
				$res["path"]=$cell->getValue();
				$cell = $handler->getCellByColumnAndRow(2,$row);
				$res["name"]=$cell->getValue();
				$res["row"]=$row;
				return $res;
			}
		}
	}
	else{
		$cell = $handler->getCellByColumnAndRow(0,1);
		$res["type"]=$cell->getValue();
		$cell = $handler->getCellByColumnAndRow(1,1);
		$res["path"]=$cell->getValue();
		$cell = $handler->getCellByColumnAndRow(2,1);
		$res["name"]=$cell->getValue();
		
		$res["row"]=1;
		return $res;
	}
	return array();
}
// function search_for_file($handler,$search){
	// $highestRow = $handler->getHighestRow();
	// $highestColumn = $handler->getHighestColumn();
	// for ($row = 1; $row <= $highestRow; ++ $row)
	// {
		// $cell = $handler->getCellByColumnAndRow(0, $row);
		// $val = $cell->getValue();
		// if($val[strlen($val)-1]!="/" && $search[strlen($search)-1]=="/"){
			// $ss = substr($search,0,strlen($search)-1);
			// if($ss==$val)
				// return $row;
		// }
		
		// if($val[strlen($val)-1]=="/" && $search[strlen($search)-1]!="/"){	
			// $ss = substr($val,0,strlen($val)-1);
			// if($ss==$search)
				// return $row;
		// }
		// if($val==$search)
			// return $row;
	// }

	// return -1;
// }

// function saveUrlFound($url = array()){
	// $name = dirname(__FILE__) . '/xls/url.xls';
	// if(file_exists($name)){
		// $objReader = new PHPExcel_Reader_Excel5();
		// $objReader->setReadDataOnly(true);
		// $objPHPExcel = $objReader->load( $name );
		// $masAddUrl = array();
		// $masAddUrl["URL"] = array();
		// foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){
			// $masAddUrl["ROW"] = $worksheet->getHighestRow();
			// $masAddUrl["COLUMN"] = $worksheet->getHighestColumn();
			// foreach($url as $v){
				// if(search_for_file($worksheet,$v)==-1)
					// if(!in_array($v,$masAddUrl["URL"]))
						// $masAddUrl["URL"][] = $v;
			// }
		// }
		// unset($objReader);
		// unset($objPHPExcel);
		// return $masAddUrl;
	// }
	// return array();
// }
function saveUrlWrite($val=array()){
	global $defaultDir, $nameeee;
	$name = dirname(__FILE__)."/xls/".$nameeee;
	//print_R($val);
	require_once 'PHPExcel/IOFactory.php';
	//$name = dirname(__FILE__) . '/xls/url.xls';		
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	echo $name;
	$objPHPExcel = $objReader->load($name);
	$sheet = $objPHPExcel->getActiveSheet();
	$row = $sheet->getHighestRow();
	echo $row;
	foreach($val as $v){
		$sheet->setCellValue("A".(string)$row,$v["type"]);
		$sheet->setCellValue("B".(string)$row,$v["path"]);
		$sheet->setCellValue("C".(string)$row,$v["name"]);
		$row++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save($name);
	$objPHPExcel->disconnectWorksheets();
	unset($objWriter);
	unset($objReader);
	unset($objPHPExcel);
}
function updatePositionNow($raw=0){
	global $nameeee;
	if($raw!=0){
		global $nameeee;
		require_once 'PHPExcel/IOFactory.php';
		$name = dirname(__FILE__) . '/xls/'.$nameeee;		
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($name);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValue("S".(string)$raw,"Y");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($name);
		$objPHPExcel->disconnectWorksheets();
		unset($objWriter);
		unset($objReader);
		unset($objPHPExcel);
	}
}

function rdir ($path2dir) {
    if(is_dir($path2dir)){ 
			if ($handle = opendir($path2dir)) {
			$pafs = array();
			 while (false !== ($entry = readdir($handle))) {
		 
				if ($entry!='.' && $entry!='..' && $entry!='' ) {
					$all_path = $path2dir.$entry;
					$new_path = go ($all_path, is_file($all_path),$entry); 
		 
					$pafs[] =  $new_path;
				}
			}
			if(count($pafs)>0)
				return  $pafs;
		}
	}
    return false;
}
 
function go ($path2file, $is_file = true, $entry) { 
 
    if ($is_file) { 
 
        # выполняем операцию над файлом
        # выведем относительный путь к обрабатываемому файлу
        return array("type"=>"file", "path"=>$path2file,"name"=>$entry); 
 
 
    } else { 
 
        # выполняем операцию над папкой
        $path2file = $path2file.'/'; 
 
        # выведем относительный путь к обрабатываемой директории
		return array("type"=>"folder", "path"=>$path2file,"name"=>$entry); 
 

    } 
	
	return false;
}
 
 
# непосредственно вызываем функцию
if (rdir ($folder)) {
    echo 'DONE';
}

global $defaultDir;
$defaultDir = $_SERVER["DOCUMENT_ROOT"]."/upload/iblock/";
//$nameeee
function Analize(){
	global $defaultDir, $nameeee;
	$name = dirname(__FILE__)."/xls/".$nameeee;
	if(file_exists($name)){
		$val = url_get_from_file();
		if($val["type"]=="folder"){
			$fld = rdir($val["path"]);
			saveUrlWrite($fld);
			updatePositionNow($val["row"]);
		}
		else{
			global $DB;
			$res = $DB->Query("SELECT ID FROM b_file WHERE FILE_NAME=='".$val["type"]."'");
			die(print_R($res));
		}
		/**
			прочитать значения из файла
			если папка получить след значени
			если файл проверить на b_file (удалить/оставить)
		**/
	}
	//else{
		
		// $fld = rdir($defaultDir);
		// saveUrlWrite($fld);
		// print_R($fld);
		//записать значения в файл
	//}
}

Analize();

?>