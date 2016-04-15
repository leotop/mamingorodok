<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");    
$qua = intval($_REQUEST["qua"]);
header("Content-type: image/png");

$img = imagecreatefrompng('basket_number.png');
$color = imagecolorallocate($img, 255, 255, 255);
$ttfFile = $_SERVER["DOCUMENT_ROOT"]."/arial.ttf";

if(strlen($qua)>1)
    $x=23;
else
    $x=26;

imagesavealpha($img,TRUE);
imagettftext($img, 9, 0, $x, 14, $color, $ttfFile, $qua);
//imagestring($img, 3, $x, 3, $qua, $color);
imagepng($img);
imagedestroy($img);
?>