<?
$handle = fopen($_SERVER['DOCUMENT_ROOT']."/upload/import/log.txt", "rb");
$contents = stream_get_contents($handle);
fclose($handle);
//echo iconv("utf-8", "windows-1251", str_replace("\r\n", "<br>\r\n", $contents));
$arC = explode("\r\n", $contents);
foreach($arC as $str)
	echo  iconv("windows-1251", "utf-8",  $str)."<br>\r\n";

?>