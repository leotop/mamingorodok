<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$id = intval($_REQUEST["idt"]);
if($id>0) {
    if(CModule::IncludeModule("iblock"))
    {
        $db_props = CIBlockElement::GetProperty(CATALOG_IBLOCK_ID, $id, array("sort" => "asc"), Array("CODE"=>"MODEL_3D"));
        if($ar_props = $db_props->Fetch()) {
			//print_R($ar_props);
            $rsFile = CFile::GetPath($ar_props["VALUE"]);
			//print_R($rsFile);
            echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="650" height="500"><param name="wmode" value="opaque"><param name="movie" value="'.$rsFile.'"><param name="quality" value="high"><embed src="'.$rsFile.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="650" height="500" wmode="opaque"></embed></object>';
        }
    }
}
?>