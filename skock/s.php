<?
die();
$str = '2014-07-10T00:00:00+04:00';
preg_match("#(\d{4})-(\d{2})-(\d{2})#", $str, $arM);
echo $strDate = "$arM[3].$arM[2].$arM[1]";